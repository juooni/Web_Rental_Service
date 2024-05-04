<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("product_id", $_GET)) {
    $product_id = $_GET["product_id"];
    $query = "select * from 물품유형 where 물품유형번호=$product_id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_array($result);
    if (!$product) {
        msg("물품이 존재하지 않습니다.");
    }
    
}
?>
    <div class="container fullwidth">

		
        <h3>상품 정보 상세 보기</h3>

        <p>
            <label for="product_id">물품유형번호</label>
            <input readonly type="text" id="product_id" name="product_id" value="<?= $product['물품유형번호'] ?>"/>
        </p>
        

        <p>
            <label for="product_name">물품명</label>
            <input readonly type="text" id="product_name" name="product_name" value="<?= $product['물품명'] ?>"/>
        </p>

        <p>
            <label for="product_num">수량</label>
            <input readonly type="text" id="product_num" name="product_num" value="<?= $product['수량'] ?>"/>
        </p>

        <p>
            <label for="product_loc">보관위치</label>
            <input readonly type="text" id="product_loc" name="product_loc" value="<?= $product['보관위치'] ?>"/>
        </p>

    </div>
<? include "footer.php" ?>