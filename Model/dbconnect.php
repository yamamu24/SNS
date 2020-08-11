<?php
    try {
        $db = new PDO('mysql:dbname=yamamu24_mydb;host=127.0.0.1;charset=utf8', 'root', '');
    }
    catch (PDOException $ex) {
        print('DB接続エラー：' . $ex->getMessage());
    }
?>