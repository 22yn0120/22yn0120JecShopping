<?php
    require_once 'DAO.php';

    class SaleDetail
    {
        public int $saleno;//販売番号
        public string $goodscode;//商品コード
        public int $num;//数量
    }

    class SaleDetailDAO
    {
        //DBに購入データを追加する
        public function insert(SaleDetail $detail,PDO $dbh)
        {   
            $dbh = DAO::get_db_connect();

            $sql = "INSERT INTO SaleDetail(saleno,goodscode,num) VALUES(:saleno,:goodscode,:num);";

            $stmt = $dbh->prepare($sql);

            $stmt ->bindValue(':saleno',$detail->saleno,PDO::PARAM_INT);
            $stmt ->bindValue(':goodscode',$detail->goodscode,PDO::PARAM_STR);
            $stmt ->bindValue(':num',$detail->num,PDO::PARAM_INT);

            $stmt -> execute();
        }
    }
?>