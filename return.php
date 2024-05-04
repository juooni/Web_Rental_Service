<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
mysqli_query($conn, "set autocommit=0;");
mysqli_query($conn, "set transaction isolation level serializable;");
mysqli_query($conn, "begin;");


foreach($_POST['product_id'] as $product_id){
	$rental_id = $_POST['rental_id_'.$product_id];
	$charger_name = $_POST['charger_name_'.$product_id];

	
	$pid_ret = mysqli_query($conn, "select 물품번호 from 물품 where 물품번호=$product_id and 물품상태='대여중'");
	if(!mysqli_fetch_array($pid_ret)){
		mysqli_query($conn, "rollback;");
		s_msg ('이미 반납된 제품입니다.');
	    echo "<meta http-equiv='refresh' content='0;url=rental_list.php'>";
	}
	
	// 물품 테이블 상태 변경
	$query = "update 물품 set 물품상태='대여가능' where 물품번호=$product_id";
	$result = mysqli_query($conn, $query);
	if (!$result){
		mysqli_query($conn, "rollback;");
		s_msg("반납에 실패했습니다. 다시 시도하여 주십시오.");
	}
	
	
	
	// 대여물품 테이블 반납담당자이름 변경
	$query = "update 대여물품 set 반납담당자이름='$charger_name', 반납여부='반납완료' where 대여번호=$rental_id and 물품번호=$product_id";
	$result = mysqli_query($conn, $query);
	if (!$result){
		mysqli_query($conn, "rollback;");
		s_msg("반납에 실패했습니다. 다시 시도하여 주십시오.");
	}
	
	
	// 대여물품 테이블 개수 확인 후 0이면 대여 테이블, 대여물품테이블 삭제
	$query = "select count(물품번호) from 대여물품 where 대여번호=$rental_id and 반납여부='반납안됨'";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result);
	if (!$result){
		mysqli_query($conn, "rollback;");
		s_msg("반납에 실패했습니다. 다시 시도하여 주십시오.");
	}
	
	if ($row[0] == 0){
		$query = "delete from 대여 where 대여번호=$rental_id";
		$result = mysqli_query($conn, $query);	
		if (!$result){
			mysqli_query($conn, "rollback;");
			s_msg("반납에 실패했습니다. 다시 시도하여 주십시오.");
		}
	}
	
	s_msg ('성공적으로 삭제 되었습니다');
	echo "<meta http-equiv='refresh' content='0;url=rental_list.php'>";

	mysqli_query($conn, "commit;");	
}

?>

