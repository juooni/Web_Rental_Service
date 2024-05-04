<!DOCTYPE html>
<html lang='ko'>
<head>
    <title>고려대학교 학생복지위원회</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<form action="customer_list.php" method="post">
    <div class='navbar fixed'>
        <div class='container'>
            <a class='pull-left title' href="index.php">고려대학교 학생복지위원회</a>
            <ul class='pull-right'>
                <li>
                    <input type="text" name="search_keyword" placeholder="고객 id 검색">
                </li>
                <li><a href='customer_list.php'>고객 목록</a></li>
                <li><a href='customer_form.php'>고객 등록</a></li>
                <li><a href='rental_form.php'>대여 신청</a></li>
                <li><a href='rental_list.php'>대여 신청 목록</a></li>
                <li><a href='product_list.php'>물품목록</a></li>
            </ul>
        </div>
    </div>
</form>