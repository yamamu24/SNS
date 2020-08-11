<?php
    session_start();
    require('Model/dbconnect.php');

    if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
        $_SESSION['time'] = time();

        $members = $db->prepare('SELECT * FROM members WHERE id=?');
        $members->execute(array($_SESSION['id']));
        $member = $members->fetch();
    } else {
        header('Location: Views/login.php');
        exit();
    }
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="CSS/index.css">
</head>
<body>
    <div id="header">
        <div>やまったー</div>
    </div>
</body>