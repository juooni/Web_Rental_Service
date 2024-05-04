<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";  
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
    
    $now = date('Y-m-d');
    
    ?>
    <form name='rental' action='rental.php' method='POST'>
        <h3>대여 정보 <?=$mode?></h3>
        
        <p> 
        	<label for="rental_name">고객 ID</label>
        	<input type='text' placeholder="고객ID" id="customer_id" name='customer_id'/>
        </p>
        
        <br>
        
        <p>
            <label for="rental_name">대여자 이름</label>
            <input type="text" placeholder="대여자 이름" id="rental_name" name="rental_name" />
        </p>
        
        <br>
        
        <p>
            <label for="rental_phone">대여자 연락처</label>
            <input type="text" placeholder="000-0000-0000" id="rental_phone" name="rental_phone" />
        </p>
        
        <br>
        
        <p>
        	<label for="start_date">대여일자</label>
			<input type="date"  id="start_date" name="start_date" required pattern="\d{4}-\d{2}-\d{2}" value="<?=$now?>"/>
			~
			<label for="end_date">반납예정일</label>
			<input type="date"  id="end_date" name="end_date" required pattern="\d{4}-\d{2}-\d{2}" value="<?=$now?>"/>
        </p>

		<br>        
        
        <p>
            <label for="charger_name">대여 담당자</label>
            <input type="text" placeholder="대여 담당 위원 이름" id="charger_name" name="charger_name" />
        </p>

		<br><br>
		<h3>대여 물품 정보</h3>
        <script>
            function validate() {
                if(document.getElementById("rental_name").value == "") {
                    alert ("대여자 이름을 입력해 주십시오"); return false;
                }
                else if(document.getElementById("customer_phone").value == "") {
                    alert ("대여자 연락처를 입력해 주십시오"); return false;
                }
                else if(document.getElementById("charger_name").value == "") {
                    alert ("대여 담당 위원 이름을 입력해 주십시오"); return false;
                }
                else if(document.getElementById("customer_id").value == "") {
                    alert ("고객id를 입력해 주십시오"); return false;
                }
                else if(document.getElementById("start_date").value == "") {
                    alert ("대여일자를 입력해 주십시오"); return false;
                }
                else if(document.getElementById("end_date").value == "") {
                    alert ("반납예정일를 입력해 주십시오"); return false;
                }

            }
        </script>
        
        
        <table class="table table-striped table-bordered">
            <tr>
                <th>No.</th> 
                <th>물품명</th>
                <th>총수량</th>
                <th>대여가능수량</th>
                <th>대여희망수량</th>
                <th>선택</th>
            </tr>
            <?
            $row_index = 1;
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>{$row_index}</td>";
                echo "<td><a href='product_view.php?product_id={$row['물품유형번호']}'>{$row['물품명']}</a></td>";
                echo "<td>{$row['수량']}</td>";
                echo "<td>{$row['대여가능수량']}</td>";
                echo "<td width='10%'>
                	<input type='text' id='quantity_{$row['물품유형번호']}' name='quantity_{$row['물품유형번호']}' size='5'/>개</td>";
                echo "<td width='17%'>
                    <input type='checkbox' name=product_id[] value='{$row['물품유형번호']}'/></td>";
                echo "</tr>";
                $row_index++;
            }
            ?>
            

            
        </table>
        <div align='center'>
            <input type='submit' class='button primary small' value=대여 onclick="javascript:return validate();">
        </div>
    </form>
</div>
<? include("footer.php") ?>