<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "customer_insert.php";

if (array_key_exists("customer_id", $_GET)) {
    $customer_id = $_GET["customer_id"];
    $query =  "select * from 고객 where 고객번호 = $customer_id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_array($result);
    if(!$product) {
        msg("고객이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "customer_modify.php";
}

?>
    <div class="container">
        <form name="customer_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="customer_id" value="<?=$product['고객번호']?>"/>
            <h3>고객 정보 <?=$mode?></h3>
            <p>
                <label for="customer_name">고객이름</label>
                <input type="text" placeholder="이름이나 단체명" id="customer_name" name="customer_name" value="<?=$product['고객이름']?>"/>
            </p>
            <p>
                <label for="customer_phone">연락처</label>
                <input type="text" placeholder="000-0000-0000" id="customer_phone" name="customer_phone" value="<?=$product['연락처']?>"/>
            </p>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    else if(document.getElementById("customer_name").value == "") {
                        alert ("고객이름을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("customer_phone").value == "") {
                        alert ("연락처를 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>