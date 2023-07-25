<?php
require_once 'DAO.php';

class Goods
{
    public string $goodscode; //商品コード
    public string $goodsname; //商品名
    public int $price; //価格
    public string $detail; //商品詳細
    public int $groupcode; //商品グループコード
    public bool $recommend; //おすすめフラグ
    public string $goodsimage; //商品画像
}

//Goos\dsテーブルアクセス用クラス
class GoodsDAO
{
    //おすすめ商品を取得するメソッド
    public function get_recommend_goods()
    {
        //DBに接続する
        $dbh = DAO::get_db_connect();

        //Goodsテーブルからおすすめ商品を取得する
        $sql = "SELECT * FROM GOODs WHERE recommend =1";
        $stmt = $dbh ->prepare($sql);

        //SQLを実行する
        $stmt -> execute();

        //取得したデータをGoodsGroupクラスの配列にする
        $data =[];
        while($row = $stmt->fetchObject('Goods'))
        {
            $data[] = $row;
        }
        return $data;
    }
    public function get_goods_by_groupcode(int $groupcode)
    {
        //DBに接続する
        $dbh = DAO::get_db_connect();

        $sql ="SELECT * FROM goods WHERE groupcode = :groupcode  ORDER BY recommend DESC";
        $stmt = $dbh ->prepare($sql);

        $stmt ->bindValue(':groupcode',$groupcode,PDO::PARAM_INT);

        //SQLを実行する
        $stmt -> execute();

        //取得したデータをGoodsGroupクラスの配列にする
        $data =[];
        while($row = $stmt->fetchObject('Goods'))
        {
            $data[] = $row;
        }
        return $data;
    }
    public function get_goods_by_goodscode(String $goodscode)
    {
        $dbh = DAO::get_db_connect();

        $sql ="SELECT * FROM goods WHERE goodscode = :goodscode";
        $stmt = $dbh ->prepare($sql);

        $stmt ->bindValue(':goodscode',$goodscode,PDO::PARAM_STR);

        //SQLを実行する
        $stmt -> execute();

        //1件分のデータをGoodsクラスのオブジェクトとして取得する
       $goods = $stmt->fetchObject('Goods');
        return $goods;
    }

    //指定した検索ワードの商品を検索して返すメソッド
    public function get_goods_by_keyword(String $keyword)
    {
        $dbh = DAO::get_db_connect();

        $sql ="SELECT * FROM Goods WHERE goodsname LIKE :keyword1 OR detail LIKE :keyword2 ORDER BY recommend DESC";
        $stmt = $dbh ->prepare($sql);

        $stmt ->bindValue(':keyword1','%'.$keyword.'%',PDO::PARAM_STR);
        $stmt ->bindValue(':keyword2','%'.$keyword.'%',PDO::PARAM_STR);
        //SQLを実行する
        $stmt -> execute();

        //取得したデータをGoodsGroupクラスの配列にする
        $data =[];
        while($row = $stmt->fetchObject('Goods'))
         {
             $data[] = $row;
         }
        return $data;
    }

     //Goodsデータを登録する
     public function insert(Goods $goods)
     {
         $dbh = DAO::get_db_connect();
 
         $sql="INSERT INTO Goods(goodscode,goodsname,price,detail,groupcode,recommend,goodsimage)
         VALUES(:goodscode,:goodsname,:price,:detail,:groupcode,:recommend,:goodsimage);";
 
         $stmt = $dbh ->prepare($sql);
 
         //SQLに変数の値を当てはめる
         $stmt ->bindValue(':goodscode',$goods->goodscode,PDO::PARAM_STR);
         $stmt ->bindValue(':goodsname',$goods->goodsname,PDO::PARAM_STR);
         $stmt ->bindValue(':price',$goods->price,PDO::PARAM_INT);
         $stmt ->bindValue(':detail',$goods->detail,PDO::PARAM_STR);
         $stmt ->bindValue(':groupcode',$goods->groupcode,PDO::PARAM_INT);
         $stmt ->bindValue(':recommend',$goods->recommend,PDO::PARAM_BOOL);
         $stmt ->bindValue(':goodsimage',$goods->goodsimage,PDO::PARAM_STR);
 
         //SQLを実行する
         $stmt -> execute();
     }
}

