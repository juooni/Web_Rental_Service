<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from 고객";
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query .= " where 고객이름 like '%$search_keyword%' or 연락처 like '%$search_keyword%'";
    }
    $result = mysqli_query($conn, $query);
    if (!$result) {
         die('Query Error : ' . mysqli_error());
    }
    ?>

    <table class="table table-striped table-bordered">
        <tr>
            <th>No.</th>
            <th>고객id</th>
            <th>고객이름</th>
            <th>연락처</th>
            <th>기능</th>
        </tr>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['고객번호']}</td>";
            echo "<td>{$row['고객이름']}</td>";
            echo "<td>{$row['연락처']}</td>";
            echo "<td width='17%'>
                <a href='customer_form.php?customer_id={$row['고객번호']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['고객번호']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
    </table>
    <script>
        function deleteConfirm(customer_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "customer_delete.php?customer_id=" + customer_id;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
