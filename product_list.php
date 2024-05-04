<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    
    
    $nested_query = "select 물품유형번호, count(물품상태) as 대여가능수량 from 물품 where 물품상태='대여가능' group by 물품유형번호";
    
    $query = "select * from 물품유형 natural join ($nested_query) as T;";
    
    $result = mysqli_query($conn, $query);
    if (!$result) {
         die('Query Error : ' . mysqli_error());
    }
    ?>

    <table class="table table-striped table-bordered">
        <tr>
            <th>No.</th>
            <th>물품명</th>
            <th>수량</th>
            <th>대여가능수량</th>
            <th>보관위치</th>
        </tr>
        
        <?
            $row_index = 1;
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>{$row_index}</td>";
                echo "<td><a href='product_view.php?product_id={$row['물품유형번호']}'>{$row['물품명']}</a></td>";
                echo "<td>{$row['수량']}</td>";
                echo "<td>{$row['대여가능수량']}</td>";
                echo "<td>{$row['보관위치']}</td>";
                echo "</tr>";
                $row_index++;
            }
        ?>
        
        
        
        
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['manufacturer_name']}</td>";
            echo "<td><a href='product_view.php?product_id={$row['product_id']}'>{$row['product_name']}</a></td>";
            echo "<td>{$row['price']}</td>";
            echo "<td>{$row['added_datetime']}</td>";
            echo "<td width='17%'>
                <a href='product_form.php?product_id={$row['product_id']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['product_id']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
    </table>
    <script>
        function deleteConfirm(product_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "product_delete.php?product_id=" + product_id;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
