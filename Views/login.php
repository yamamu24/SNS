<?php
    session_start();
	require("../Model/dbconnect.php");

    $mode = "login";
    $name = "";
    $email = "";
    $password = "";
    $chk_str = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/";
	if (!empty($_POST)) {
        $mode = $_POST["mode"];
        if ($mode === "login") {
            $email = $_POST["loginEmail"];
            $password = $_POST["loginPassword"];

            if ($email !== "" && $password !== "") {
                $login = $db->prepare('SELECT * FROM members WHERE email = ? AND password = ? AND deleteflg = 0');
                $login->execute(array(
                    $email,
                    sha1($password)
                ));
                $user = $login->fetch();

                if ($user) {
                    $_SESSION["userid"] = $user["userid"];
                    $_SESSION["time"] = time();

                    header('Location: ../index.php');
                    exit();
                }
                else {
                    $error["login"] = '※ログインに失敗しました。メールアドレス、パスワードをご確認ください。';
                }
            }
            else {
                $error["login"] = "※すべてのフォームに入力してください。";
            }
        }
        else if ($mode === "signup") {
            $name = $_POST["resistUsername"];
            $email = $_POST["registEmail"];
            $password = $_POST["registPassword"];

            // バリデーションチェック
            if ($name === "") {
                $error["name"] = "※ユーザー名を入力してください。";
            }
            if ($email === "") {
                $error["email"] = "※メールアドレスを入力してください。";
            }
            else if (!preg_match($chk_str, $email)) {
                $error["email"] = "※正しいメールアドレスを入力してください。";
            }
            if ($password === "") {
                $error["password"] = "※パスワードを入力してください。";
            }
            else if (strlen($password) < 8) {
                $error["password"] = "※パスワードは8文字以上で入力してください。";
            }
            $picture = $_FILES["registPicture"]["name"];
            if (!empty($picture)) {
                $ext = substr($picture, -3);
                if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
				    $error['picture'] = '※アイコン画像は拡張子が「.jpg」「.jpeg」「.png」のみご利用いただけます。';
			    }
            }

            // アカウントの重複チェック
            if (empty($error)) {
                $member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=? AND deleteflg = 0');
                $member->execute(array($email));
                $record = $member->fetch();
                if ($record["cnt"] > 0) {
                    $error["email"] = "※入力されたメールアドレスはすでに登録されています。";
                }
            }

            // データ登録
            if (empty($error)) {
                if (!empty($picture)) {
                    $picture = date('YmdHis') . $picture;
                    move_uploaded_file($_FILES['registPicture']['tmp_name'], '../Members_Picture/' . $picture);
                }

                $statement = $db->prepare('INSERT INTO members SET name = ?, email = ?, password = ?, picture = ?, created = NOW()');
                $statement->execute(array(
                    $name, 
                    $email, 
                    sha1($password),
                    !empty($picture) ? $picture : NULL
                ));

                // セッション登録用にユーザー情報を取得
                $login = $db->prepare('SELECT * FROM members WHERE email = ? AND password = ? AND deleteflg = 0');
                $login->execute(array(
                    $email,
                    sha1($password)
                ));
                $user = $login->fetch();

                if ($user) {
                    $_SESSION["userid"] = $user["userid"];
                    $_SESSION["time"] = time();

                    header('Location: ../index.php');
                    exit();
                }
            }
        }
	}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 minimum-scale=1, user-scalable=no">

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../Script/login.js"></script>
    <link rel="stylesheet" href="../CSS/header.css" media="screen">
    <link rel="stylesheet" href="../CSS/login.css" media="screen">
</head>
<body>
    <div class="header">
        <img class="logoimage" src="../Images/logo.png">
    </div>

    <div class="content">
        <div class="errorArea">
            <?php if (!empty($error['login'])): ?>
                <div class="error">
                    <?php echo $error['login']; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($error['name'])): ?>
                <div class="error">
                    <?php echo $error['name']; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($error['email'])): ?>
                <div class="error">
                    <?php echo $error['email']; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($error['password'])): ?>
                <div class="error">
                    <?php echo $error['password']; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($error['picture'])): ?>
                <div class="error">
                    <?php echo $error['picture']; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="tabArea">
            <label name="login" class="tab loginLabel is-active">ログイン</label>
            <label name="signup" class="tab signupLabel">ユーザー登録</label>
        </div>

        <div class="contentArea">
            <input id="selectedMode" type="hidden" value="<?php print(htmlspecialchars($mode, ENT_QUOTES)); ?>">
            <form id="loginForm" class="is-active" action="" method="post">
                <div class="inputArea">
                    <i class="emailIcon"></i>
                    <input id="loginEmail" type="text" name="loginEmail" placeholder="メールアドレス" value="<?php print(htmlspecialchars($email, ENT_QUOTES)); ?>" maxlength="255">
                </div>

                <div class="inputArea">
                    <i class="passIcon"></i>
                    <input id="loginPassword" type="password" name="loginPassword" placeholder="パスワード" value="<?php print(htmlspecialchars($password, ENT_QUOTES)); ?>" maxlength="20">
                </div>

                <div class="buttonArea">
                    <input id="loginButton" type="button" value="ログイン" onclick="loginUser()">
                </div>

                <input type="hidden" name="mode" value="login">
            </form>

            <form id="signupForm" action="" method="post" enctype="multipart/form-data">
                <div class="inputArea">
                    <i class="userIcon"></i>
                    <input id="registUserName" type="text" name="resistUsername" placeholder="ユーザー名" value="<?php print(htmlspecialchars($name, ENT_QUOTES)); ?>" maxlength="255">
                </div>

                <div class="inputArea">
                    <i class="emailIcon"></i>
                    <input id="registEmail" type="text" name="registEmail" placeholder="メールアドレス" value="<?php print(htmlspecialchars($email, ENT_QUOTES)); ?>" maxlength="255">
                </div>
                
                <div class="inputArea">
                    <i class="passIcon"></i>
                    <input id="registPassword" type="password" name="registPassword" placeholder="パスワード" value="<?php print(htmlspecialchars($password, ENT_QUOTES)); ?>" maxlength="20">
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