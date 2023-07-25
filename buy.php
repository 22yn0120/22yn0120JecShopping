<?php
    require_once './helpers/MemberDAO.php';
    require_once './helpers/CartDAO.php';
    require_once './helpers/SaleDAO.php';


    //セッションの開始
    session_start();
    
    //未ログインの場合
    if(empty($_SESSION['member']))
    {
        //ログインページにリダイレクトする
        header('Location:login.php');
        exit;
    }

    //「購入する」ボタンをクリックせずにこのページを表示した場合はcart.phpにリダイレクトする
    if($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        header('Location:cart.php');
        exit;
    }

    //ログイン中の会員データを取得
    $member = $_SESSION['member'];

    //会員のカートデータを取得
    $cartDAO = new CartDAO();
    $cart_list = $cartDAO->get_cart_by_memberid($member->memberid);

    //カートの商品をSaleテーブルに登録する
    $saleDAO = new SaleDAO();
    $ret = $saleDAO->insert($member->memberid,$cart_list);

    //購入完了メール

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    // PHPMailerの読み込みパス
    require_once 'PHPMailer/src/PHPMailer.php';
    require_once 'PHPMailer/src/Exception.php';
    require_once 'PHPMailer/src/SMTP.php';


    // 文字エンコードを指定
    mb_language('uni');
    mb_internal_encoding('UTF-8');

    // インスタンスを生成（true指定で例外を有効化）
    $mail = new PHPMailer(true);

    // 文字エンコードを指定
    $mail->CharSet = 'utf-8';

    //ログイン中の会員データを取得
    $member = $_SESSION['member'];
    $email = $member->email;
    $membername = $member->membername;

    //DBから会員のカートデータを取得する
    $cartDAO = new CartDAO();
    $cart_list = $cartDAO -> get_cart_by_memberid($member ->memberid);

            //購入処理が成功したとき
            if($ret === true)
            {   
                //テキストメール
                    try {
                    // SMTPサーバの設定
                    $mail->isSMTP();                          // SMTPの使用宣言
                    $mail->Host       = 'smtp.gmail.com';     // SMTPサーバーを指定
                    $mail->SMTPAuth   = true;                 // SMTP authenticationを有効化
                    $mail->Username   = '22yn0120@jec.ac.jp';   // ★自分の学校メールアドレス
                    $mail->Password   = 'vWW82rmtn3KT';             // ★Gmailパスワード
                    $mail->SMTPSecure = 'ssl';                // 暗号化モード（tls or ssl）。無効の場合はfalse。
                    $mail->Port       = 465;                  // TCPポートを指定（tlsの場合は465や587）
                
                    // 送信元（第2引数は省略可）
                    //$mail->setFrom('XXXXXX@jec.ac.jp', '差出人名');
                
                    // 宛先（第2引数は省略可）
                    $mail->addAddress($email, $membername);      // ★宛先TO
                    // $mail->addAddress('XXXXXX@example.com', '受信者名'); // 他にも宛先TOがあれば指定
                    // $mail->addCC('XXXXXX@example.com', '受信者名');      // CC
                    // $mail->addBCC('XXXXXX@example.com');                // BCC
                
                    // 返信先
                    //$mail->addReplyTo('XXXXXX@example.com', 'お問い合わせ');
                
                    // 件名
                    $mail->Subject = 'JecShopping購入完了';
                
                    // 本文
                    $mail->Body = '購入ありがとうございました。';
                    
                    // メール送信
                    $mail->send();
                
                }
                catch (Exception $e) {
                    echo "メールを送信できませんでした。Mailer Error: {$mail->ErrorInfo}";
                }
                //HTMLメール
                    try {
                        // SMTPサーバの設定
                        $mail->isSMTP();                          // SMTPの使用宣言
                        $mail->Host       = 'smtp.gmail.com';     // SMTPサーバーを指定
                        $mail->SMTPAuth   = true;                 // SMTP authenticationを有効化
                        $mail->Username   = '22yn0120@jec.ac.jp';   // ★自分の学校メールアドレス
                        $mail->Password   = 'vWW82rmtn3KT';             // ★Gmailパスワード
                        $mail->SMTPSecure = 'ssl';                // 暗号化モード（tls or ssl）。無効の場合はfalse。
                        $mail->Port       = 465;                  // TCPポートを指定（tlsの場合は465や587）
                    
                        // 送信元（第2引数は省略可）
                        //$mail->setFrom('XXXXXX@jec.ac.jp', '差出人名');
                    
                        // 宛先（第2引数は省略可）
                        $mail->addAddress($email, $membername);      // ★宛先TO
                        // $mail->addAddress('XXXXXX@example.com', '受信者名'); // 他にも宛先TOがあれば指定
                        // $mail->addCC('XXXXXX@example.com', '受信者名');      // CC
                        // $mail->addBCC('XXXXXX@example.com');                // BCC
                    
                        // 返信先
                        //$mail->addReplyTo('XXXXXX@example.com', 'お問い合わせ');
                    
                        // 件名
                        $mail->Subject = 'JecShopping購入完了';

                        // HTMLメールを有効に。
                        $mail->isHTML(true);
                        
                        // 埋込画像の設定。
                        // 第一引数： 画像ファイル
                        // 第二引数： コンテンツID名。任意の名前を付ける。
                        // 本文の画像指定で『cid:コンテンツID名』で利用できるようになる。
                        foreach($cart_list as $cart) :
                        $mail->AddEmbeddedImage("./images/goods/{$cart ->goodsimage}", "{$cart ->goodsimage}");
                        endforeach;

                        // 本文。HTMLタグが使える。
                        $mail->Body = "
                            <p> {$membername}さん。</p>
                            <p>購入ありがとうございました。</p>";

                        foreach($cart_list as $cart) :
                        $str="<table>
                                <tr>
                                    <td><img src='cid:{$cart ->goodsimage}'></td>
                                </tr>
                                <tr>
                                    <td>{$cart ->goodsname}</td>
                                </tr>
                                <tr>
                                    <td>{$cart ->price}円</td>
                                </tr>
                                <tr>
                                <td>数量：{$cart ->num}</td>
                            </tr>
                            </table>
                            <hr>
                        ";

                        $mail->Body.=$str;
                        endforeach;
                    
                        // メール送信
                        $mail->send();

                    }
                    catch (Exception $e) {
                        echo "メールを送信できませんでした。Mailer Error: {$mail->ErrorInfo}";
                    }
                        //会員のカートデータすべてを削除する
                        $cartDAO ->dalete_by_memberid($member->memberid);
                    }   
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>購入完了</title>
</head>
<body>
<div>
    <?php include "header2.php" ?>
    <?php if($ret === true): ?>
    <p>購入が完了しました。</p>
    <a href = "index.php">トップページへ</a>
    <?php else: ?>
        <p>購入処理でエラーが発生しました。カートページへ戻りもう一度やり直してください。</p>
        <p><a href="cart.php">カートページへ</a></p>
    <?php endif; ?>
</body>