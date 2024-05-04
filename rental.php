<?
include "config.php";
include "util.php";
?>

<div class="container">

    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    mysqli_query($conn, "set autocommit=0;");
    mysqli_query($conn, "set transaction isolation level serializable;");
    mysqli_query($conn, "begin;");
    $customer_id = $_POST['customer_id'];
    
    $available_insert = check_id($conn, $customer_id);
    if ($available_insert){
    	$start_date = $_POST['start_date'];
        $rental_name = $_POST['rental_name'];
        $rental_phone = $_POST['rental_phone'];
        $charger_name = $_POST['charger_name'];
        
        // insert data into 대여
        $query = "insert into 대여(대여일자, 대여자이름, 대여자연락처, 대여담당자이름, 고객번호) values ('$start_date', '$rental_name', '$rental_phone', '$charger_name', $customer_id);";
        $result = mysqli_query($conn, $query);
        $rental_id = mysqli_insert_id($conn);
        if(!$result){
	    	mysqli_query($conn, "rollback;");
	        s_msg('대여신청에 실패하였습니다. 다시 시도하여 주십시오.');
	    }

    	
        $end_date = $_POST['end_date'];
        foreach($_POST['product_id'] as $pid){
        	$quantity = $_POST['quantity_'.$pid];

	        for($num=1;$num<=$quantity;$num++){
	        	$query0 = "select min(물품번호) from 물품 where 물품유형번호=$pid and 물품상태='대여가능';";
	        	$product_num = mysqli_query($conn, $query0);
	        	if(!$product_num){
	        		s_msg('대여 가능한 물품이 없습니다. 다시 시도하여 주십시오.');
	        		mysqli_query($conn, "rollback;");
	        	}
	        	
	        	// update 물품 table, 물품 상태 -> 대여중
	        	$product_num = mysqli_fetch_array($product_num)[0];
		        $query1 = "update 물품 set 물품상태='대여중' where 물품유형번호=$pid and 물품상태='대여가능' and 물품번호<=$product_num;";
		        $result1 = mysqli_query($conn, $query1);
		        if(!$result1){
		        	s_msg('대여신청에 실패하였습니다. 다시 시도하여 주십시오.');
	        		mysqli_query($conn, "rollback;");
	        	}
		        
		        // insert into 대여물품 
		        $query2 = "insert into 대여물품(반납예정일, 물품번호, 대여번호) values ('$end_date', $product_num, $rental_id);"; 
		        $result2 = mysqli_query($conn, $query2);
		        if(!$result2){
		        	s_msg('대여신청에 실패하였습니다. 다시 시도하여 주십시오.');
	        		mysqli_query($conn, "rollback;");
	        	}
	        }
	        
        } 
        
        s_msg('주문이 완료되었습니다');
        echo "<script>location.replace('rental_list.php');</script>";
        mysqli_query($conn, "commit;");
        
        
    }
    else{
        msg('등록되지 않은 아이디 입니다.');
    }
    ?>

</div>

