<?php
    session_start();
	require("../Model/dbconnect.php");

	if (!empty($_POST)) {
        if ($_POST["mode"] === "login") {
            $email = $_POST["loginEmail"];
            $password = $_POST["loginPassword"];

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
                    $error['login'] = '※ログインに失敗しました。メールアドレス、パスワードをご確認ください。';
                }
            }
            else {
                $error['login'] = "※すべてのフォームに入力してください。";
            }
        }
        else if ($_POST["mode"] === "signup") {
            $name = $_POST["resistUsername"];
            $email = $_POST["registEmail"];
            $password = $_POST["registPassword"];
            $picture = $_POST["registPicture"];
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
			<div class="error">
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
                <div class="inputArea">
                    <i class="emailIcon"></i>
                    <input id="loginEmail" type="text" name="loginEmail" placeholder="メールアドレス" value="<?php print(htmlspecialchars($email, ENT_QUOTES)); ?>">
                </div>

                <div class="inputArea">
                    <i class="passIcon"></i>
                    <input id="loginPassword" type="password" name="loginPassword" placeholder="パスワード" value="<?php print(htmlspecialchars($password, ENT_QUOTES)); ?>">
                </div>

                <div class="buttonArea">
                    <input id="loginButton" type="button" value="ログイン" onclick="loginUser()">
                </div>

                <input type="hidden" name="mode" value="login">
            </form>

            <form id="signupForm" action="" method="post">
                <div class="inputArea">
                    <i class="userIcon"></i>
                    <input id="registUserName" type="text" name="resistUsername" placeholder="ユーザー名">
                </div>

                <div class="inputArea">
                    <i class="emailIcon"></i>
                    <input id="registEmail" type="text" name="registEmail" placeholder="メールアドレス">
                </div>
                
                <div class="inputArea">
                    <i class="passIcon"></i>
                    <input id="registPassword" type="password" name="registPassword" placeholder="パスワード">
                </div>

                <div class="pictureArea">
                    <i class="cameraIcon"></i>
                    <input type="file" name="registPicture" accept=".png, .jpeg, .jpg">
                </div>

                <div class="buttonArea">
                    <input id="signupButton" type="button" value="登録" onclick="registUser()">
                </div>

                <input type="hidden" name="mode" value="signup">
            </form>
        </div>
    <div>
</body>