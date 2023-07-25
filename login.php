<?php
    require_once './helpers/MemberDAO.php';

    $email = '';
    $errs =[];

    //セッションの開始
    session_start();

    //ログイン済みのとき
    if(!empty($_SESSION['member']))
    {
        //index.phpへリダイレクトする
        header('Location:index.php');
        exit;
    }

    //POSTメソッドでリクエストされたとき
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        //入力されたメールアドレスを受け取る
        $email =  $_POST['email'];
        $password =  $_POST['password'];

        //メールアドレスのバリデーションチェック
        if($email === '')
        {
            $errs[] = 'メールアドレスを入力してください。';
        }
        else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $errs[] = 'メールアドレスの形式に誤りがあります。';
        }

        //パスワードの未入力チェック
        if($password === '')
        {
            $errs[] = 'パスワードを入力してください。';
        }

        //エラーがないとき
        if(empty($errs))
        {
            //DBからメールアドレス・パスワードが一致する会員を取り出す
            $memberDAO = new MemberDAO();
            $member = $memberDAO->get_member($email,$password);

            if($member !== false){
            //セッションIDを変更する
            session_regenerate_id(true);
            //セッション変数に会員データを保存する
            $_SESSION['member'] = $member;
            //index.phpに移動
            header('Location:index.php');
            exit;
            }
            //会員データが取り出せなかったとき
            else{
            $errs[] = 'メールアドレスまたはパスワードに誤りがあります。';
            }
        }
        
    }

    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="css/LoginStyle.css" rel="stylesheet">
    <title>ログイン</title>
</head>
<body>
    <?php include "header2.php"; ?>
    <form method="POST" action="">
        <table id="LoginTable" class="box">
            <tr>
                <th colspan="2">ログイン</th>
            </tr>
            <tr>
                <td>
                    メールアドレス
                </td>
                <td>
                    <input type = "email" required autofocus name="email" value="<?= $email ?>">
                </td>
            </tr>
            <tr>
                <td>
                    パスワード
                </td>
                <td>
                    <input type = "password" required name="password">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="ログイン">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php foreach($errs as $e) : ?>
                        <span style="color:red"><?= $e ?></span>
                        <br>
                    <?php endforeach; ?>
                </td>
            </tr>
        </table>
    </form>
    <table class="box">
        <tr>
            <th>はじめてご利用の方</th>
        </tr>
        <tr>
            <td>ログインするには会員登録が必要です。</td>
        </tr>
        <tr>
            <td><a href="signup.php">新規会員登録はこちら</a></td>
        </tr>
    </table>
    <table class="box">
        <tr>
            <th>管理者メニュー</th>
        </tr>
        <tr>
            <td>※本来は管理者としてログインした場合に有効なメニューです</td>
        </tr>
        <tr>
            <td><a href="GoodsUpload.php">新商品アップロード</a></td>
        </tr>
    </table>
</body>
</html>
