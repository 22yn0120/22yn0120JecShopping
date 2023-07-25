<?php
    require_once './helpers/MemberDAO.php';
    require_once './helpers/CartDAO.php';

    //セッションの開始
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

    //ログイン中のとき
    if(!empty($_SESSION['member']))
    {
        //セッション変数の会員情報を取得する
        $member = $_SESSION['member'];
        
        //DBから会員のカートデータを取得する
         $cartDAO = new CartDAO();
         $cart_list = $cartDAO -> get_cart_by_memberid($member ->memberid);

         //カート商品の合計個数を計算する
         $sum = 0;
         if(!empty($cart_list)) :
            foreach($cart_list as $cart) :
                $sum += $cart ->num;
            endforeach;
         endif;
    }
?>

<header>
    <link href="css/HeaderStyle.css" rel="stylesheet">
    <div id="logo">
        <a href="index.php">
            <img src ="images/JecShoppingLogo.jpg" alt="JecShopping ロゴ">
        </a>
    </div>
    <div id="link">
        <?php if(isset($member)):?>
            <?= $member->membername ?>さん
            <a href = "cart.php">カート(<?=$sum?>)</a>
            <a href = "logout.php">ログアウト</a>
        <?php else:?>
            <form action="index.php?keyword=" method="GET">
                <input type="text" name="keyword" value="<?= @$keyword ?>">
                <input type="submit" value="検索">
            </form>
            <a href = "login.php">ログイン</a>
        <?php endif;?>

    </div>
    <div id="clear">
        <hr>
    </div>
</header>
