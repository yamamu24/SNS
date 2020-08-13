<?php
    session_start();
    require('Model/dbconnect.php');

    if (isset($_SESSION["userid"]) && $_SESSION["time"] + 3600 > time()) {
        $_SESSION["time"] = time();

        $members = $db->prepare('SELECT * FROM members WHERE userid=?');
        $members->execute(array($_SESSION['userid']));
        $user = $members->fetch();

        $imgSrc = $user["picture"];
    } else {
        header('Location: Views/login.php');
        exit();
    }
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="CSS/header.css" media="screen">
    <link rel="stylesheet" href="CSS/index.css" media="screen">
</head>
<body>
    <div class="header">
        <a href="index.php">
            <img class="logoimage" src="Images/logo.png">
        </a>

        <div class="pcmenu">
            <a href="Model/logout.php">
                <img class="iconHeight36 menuIcon" src="Images/logout.png">
            </a>
        </div>
    </div>

    <div class="content">
        <div>
            <img src="Members_Picture/<?php print(htmlspecialchars($imgSrc, ENT_QUOTES)); ?>" class="iconHeight36" alt="" />
            <?php print(htmlspecialchars($user["name"])); ?>
        </div>
    </div>
</body>