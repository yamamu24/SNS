<?php
	require("../Model/dbconnect.php");

	if (!empty($_POST)) {
		$email = $_POST["email"];
		$password = $_POST["password"];

		if ($email !== '' && $password !== '') {
			
		}
	}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script type="text/javascript" src="../Script/login.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="../CSS/login.css">
</head>
<body>
    <div class="header">
        <div>やまったー</div>
    </div>

    <div class="content">
		<?php if (!empty($error)): ?>
			<div>
				test
			</div>
		<?php endif; ?>

        <form id="registForm" action="" method="post">
			<div>
				<span>メールアドレス</span>
				<input type="text" name="email">
			</div>
            
			<div>
				<span>パスワード</span>
				<input type="password" name="password">
			</div>

			<input type="button" value="登録" onclick="registUser()">
        </form>
    <div>
</body>