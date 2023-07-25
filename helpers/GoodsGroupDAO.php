<?php
require_once 'DAO.php';

class GoodsGroup
{
    public int $groupcode;//商品分類コード
    public String $groupname;//商品分類名
}

class GoodsGroupDAO
{
    //DBから全商品グループを取得するメソッド
    public function get_goodsgroup()
    {
        //DBに接続する
        $dbh = DAO::get_db_connect();

        //全商品グループを取得する SQL
        $sql ="SELECT * FROM GoodsGroup";
        $stmt = $dbh ->prepare($sql);

        //SQLを実行する
        $stmt -> execute();

        //取得したデータをGoodsGroupクラスの配列にする
        $data =[];
        while($row = $stmt->fetchObject('GoodsGroup'))
        {
            $data[] = $row;
        }
        return $data;
    }
}