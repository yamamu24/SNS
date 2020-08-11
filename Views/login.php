<?php
    session_start();
	require("../Model/dbconnect.php");

	if (!empty($_POST)) {
        $name = $_POST["registUsername"];
		$email = $_POST["registEmail"];
        $password = $_POST["registPassword"];

		if ($email !== '' && $password !== '') {
            $login = $db->prepare('SELECT * FROM members WHERE email = ? AND password = ? AND deleteflg = 0');
            $login->execute(array(
                $email,
                sha1($password)
            ));
            $user = $login->fetch();

            if ($user) {
                
            }
            else {
                $error['login'] = 'ログインに失敗しました。メールアドレス、パスワードをご確認ください。';
            }
        }
        else {
            $error['login'] = "";
        }
	}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 minimum-scale=1, user-scalable=no">

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../Script/login.js"></script>
    <link rel="stylesheet" href="../CSS/login.css" media="screen">
</head>
<body>
    <div class="header">
        <img class="logoimage" src="../Images/logo.png">
    </div>

    <div class="content">
		<?php if (!empty($error)): ?>
			<div>
				<?php echo $error['login']; ?>
			</div>
		<?php endif; ?>

        <div class="tabArea">
            <label name="login" class="tab loginLabel is-active">ログイン</label>
            <label name="signup" class="tab signupLabel">ユーザー登録</label>
        </div>

        <div class="contentArea">
            <input id="mode" type="hidden" value="login">
            <form id="loginForm" class="is-active" action="" method="post">
                <div>
                    <span>メールアドレス</span>
                    <input id="loginEmail" type="text" name="loginEmail">
                </div>
            </form>

            <form id="signupForm" action="" method="post">
                <div>
                    <span>ユーザー名</span>
                    <input id="registUserName" type="text" name="resistUsername">
                </div>

                <div>
                    <span>メールアドレス</span>
                    <input id="registEmail" type="text" name="registEmail">
                </div>
                
                <div>
                    <span>パスワード</span>
                    <input id="registPassword" type="password" name="registPassword">
                </div>

                <input type="button" value="登録" onclick="registUser()">
            </form>
        </div>
    <div>
</body>