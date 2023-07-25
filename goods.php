<?php
    require_once'./helpers/GoodsDAO.php';

    //URLリクエストパラメータに商品コードがセットされているとき
    if(isset($_GET['goodscode']))
    {
        $goodscode = $_GET['goodscode'];

        //DBから商品データを取得する
        $goodsDAO = new GoodsDAO();
        $goods = $goodsDAO->get_goods_by_goodscode($goodscode);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>商品詳細</title>
</head>
<body>
    <?php include "header.php" ?>
    <table>
        <tr>
            <td rowspan="5">
                <img src = "images/goods/<?= $goods ->goodsimage ?>">
            </td>
            <td>
                <?= $goods ->goodsname ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= $goods ->detail ?>
            </td>
        </tr>
            <td>
                \<?= number_format($goods ->price) ?>
            </td>
        </tr>
            <td>
            <?= $goods ->recommend? "おすすめ商品" : "　" ?>
            </td>
        </tr>
        <tr>
            <td>
                <form method="POST" action="cart.php">
                個数
                <select name ="num">
                    <?php for($i = 1; $i <= 10; $i++):?>
                        <option value="<?=$i ?>"><?= $i ?></option>
                    <?php endfor;?>
                </select>
                <input type="hidden"name="goodscode"value="<?= $goods ->goodscode ?>">
                <input type="submit" name="add" value="カートに入れる">
                </form>
            </td>
        </tr>
    </table>

</body>
</html>
