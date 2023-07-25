<?php
    require_once './helpers/GoodsDAO.php';
    //POSTメソッドでリクエストされたとき

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    //入力された商品データを受け取る
    $goodscode = $_POST['goodscode'];//商品コード
    $goodsname; //商品名
    $price; //価格
    $detail; //商品詳細
    $groupcode; //商品グループコード
    $recommend; //おすすめフラグ
    $goodsimage; //商品画像
 
    $GoodsDAO = new GoodsDAO();

    //エラーがなければDBに会員データを追加
    if(empty($errs))
    {
        $GoodsDAO = new GoodsDAO();
        $goods->goodscode = $goodscode;
    
        //DBに会員データを登録する
        $GoodsDAO->insert($goods);
    
        //登録完了ページindex.phpへ遷移
        header('Location:index.php');
        exit;
    }
}
 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="css/LoginStyle.css" rel="stylesheet">
    <title>商品アップロード</title>
</head>
<body>
    <?php include "header2.php"; ?>
    <h1>商品アップロード</h1>
    <p>以下の項目を入力してください(*は必須)</p>
    <form action="" method="post" enctype="multipart/form-data">
        <table>
        <tr>
            <td>
                商品コード*
            </td>
            <td>
                <input type = "text" required autofocus name="goodscode">
            </td>
        </tr>
        <tr>
            <td>
                商品名*
            </td>
            <td>
                <input type = "text" required name="goodsname">
            </td>
        </tr>
        <tr>
            <td>
                価格*
            </td>
            <td>
                <input type = "number" required name="goodsname">円
            </td>
        </tr>
        <tr>
            <td>
                商品詳細
            </td>
            <td>
                <textarea  name="detail"></textarea>
            </td>
        </tr>
        </tr>
        <tr>
            <td>
                商品グループ*
            </td>
            <td>
                <select required name="groupname">
                    <option>Tシャツ</option>
                    <option>ズボン</option>
                    <option>靴</option>
                    <option>椅子</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
               おすすめ商品
            </td>
            <td>
                <input type = "checkbox" name="recommend">おすすめ
            </td>
        </tr>
        <tr>
            <td>
                商品画像
            </td>
            <td>
                <input type="file" name="img">
            </td>
        </tr>
        </table>
        <br><input type="submit" value="登録する">
    </form>
</body>