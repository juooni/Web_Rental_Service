<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수


$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("rental_id", $_GET)) {
    $rental_id = $_GET["rental_id"];
	// 대여, 대여물품, 고객  table join    
    $tables = "대여 natural join 고객";
    $attributes = "대여번호, 대여일자, 대여자이름, 대여자연락처, 대여담당자이름, 고객번호, 고객이름";
    $query = "select $attributes from $tables where 대여번호=$rental_id;";

    $result = mysqli_query($conn, $query);
    $rental = mysqli_fetch_assoc($result);
    if (!$rental) {
        msg("대여이력이 없습니다.");
    }
    
    // 대여물품 정보 
    $query1 = "select 반납예정일, 반납여부, 반납담당자이름, 물품번호, 물품명, 물품유형번호, 대여번호 from (대여물품 natural join 물품) natural join 물품유형 where 대여번호=$rental_id";
    $result1 = mysqli_query($conn, $query1);
    if (!$result1) {
        msg("대여이력이 없습니다.");
    }
    
    $query2 = "select distinct 반납예정일 from 대여물품 where 대여번호=$rental_id";
    $result = mysqli_query($conn, $query2);
    $end_date = mysqli_fetch_assoc($result);
    if (!$end_date) {
        msg("대여이력이 없습니다.");
    }
}

?>
    <div class="container fullwidth">
        <h3>대여 정보</h3>

        <p>
            <label for="rental_id">대여번호</label>
            <input readonly type="text" id="rental_id" name="rental_id" value="<?= $rental['대여번호'] ?>"/>
        </p>
        
        <p>
            <label for="customer_id">고객번호</label>
            <input readonly type="text" id="customer_id" name="customer_id" value="<?= $rental['고객번호'] ?>"/>
        </p>
        
        <p>
            <label for="customer_id">고객이름 </label>
            <input readonly type="text" id="customer_name" name="customer_name" value="<?= $rental['고객이름'] ?>"/>
        </p>
        
        <p>
            <label for="rental_name">대여자이름</label>
            <input readonly type="text" id="rental_name" name="rental_name" value="<?= $rental['대여자이름'] ?>"/>
        </p>
        
        <p>
            <label for="rental_name">대여자연락처</label>
            <input readonly type="text" id="rental_phone" name="rental_phone" value="<?= $rental['대여자연락처'] ?>"/>
        </p>
        
        <p>
            <label for="start_date">대여일자</label>
            <input readonly type="date" id="start_date" name="start_date" value="<?= $rental['대여일자'] ?>"/>
            ~
            <label for="end_date">반납예정일</label>
            <input readonly type="date" id="end_date" name="end_date" value="<?= $end_date['반납예정일'] ?>"/>
        </p>
        
        
        
        <p>
            <label for="charger_name">대여 담당자</label>
            <input readonly type="text" id="charger_name" name="charger_name" value="<?= $rental['대여담당자이름'] ?>"/> <br> 
        </p>
        
        <h3>대여 물품 정보</h3>

        
    </div>
    
    <div class="container">
    
    
    <table class="table table-striped table-bordered">
        <tr>
            <th>No.</th>
            <th>물품명</th>
            <th>물품번호</th>
            <th>반납여부</th>
            <th>반납예정일</th>
            <th>반납담당자</th>
            <th>반납</th>
        </tr>

        <?
        $row_num = mysqli_num_rows($result1);
        for($row_index=1;$row_index<=$row_num;$row_index++){
            $row= mysqli_fetch_array($result1);
            
            echo "<form name='return' action='return.php' method='POST'>";
            
            //echo "<tr>";
            //echo "<td>{$row_index}</td>";
            //echo "<td><a href='product_view.php?product_id={$row['물품유형번호']}'>{$row['물품명']}</a></td>";
            //echo "<td>{$row['물품번호']}</td>";
            //echo "<td>{$row['반납여부']}</td>";
            //echo "<td>{$row['반납예정일']}</td>";
            //echo "<td>{$row['반납담당자이름']}</td>";
            //echo "</tr>";
            
            echo "<tr>";
            echo "<input type='hidden' name='rental_id_{$row['물품번호']}' value='{$row['대여번호']}'/>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='product_view.php?product_id={$row['물품번호']}'>{$row['물품명']}</a></td>";
            echo "<td>{$row['물품번호']}</td>";
            echo "<td>{$row['반납여부']}</td>";
            echo "<td>{$row['반납예정일']}</td>";
            echo "<td width='10%'><input type='text' id='charger_name' name='charger_name_{$row['물품번호']}' value='{$row['반납담당자이름']}'/></td>";
            echo "<td width='17%'><input type='checkbox' name=product_id[] value='{$row['물품번호']}'/></td>";
            echo "</tr>";
            
            
        }
        ?>
    </table>
    
    <div align='center'>
            <input type='submit' class='button primary small' value=반납 onclick="javascript:return validate();">
    </div>
    
</div>


    
<? include("footer.php") ?>