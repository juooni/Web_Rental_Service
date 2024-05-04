<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$customer_name = $_POST['customer_name'];
$customer_phone = $_POST['customer_phone'];

$result = mysqli_query($conn, "insert into 고객(고객이름, 연락처) values('$customer_name', '$customer_phone');");


if(!$result)
{
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 수정 되었습니다');
    echo "<script>location.replace('customer_list.php');</script>";
}

?>