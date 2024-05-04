<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

?>
<div class="container">
    <table class="table table-striped table-bordered">
        <tr>
            <th>대여번호</th>
            <th>대여일자</th>
            <th>고객이름</th>
        </tr>
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select 대여번호, 대여일자, 고객이름 from 대여 natural join 고객 order by 대여일자 DESC;";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {
    	echo "<tr>";
        echo "<td><a href='rental_detail.php?rental_id={$row['대여번호']}'>{$row['대여번호']}</td></a>";
        echo "<td>{$row['대여일자']}</td>";
        echo "<td>{$row['고객이름']}</td>";
        echo "</tr>";
    }
    ?>
    
    </table>
</div>
    
<?
include "footer.php"
?>
