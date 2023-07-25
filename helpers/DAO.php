<?php
// DB接続設定の読み込み
require_once 'config.php';

class DAO 
{
    //DB接続オブジェクト
    private static $dbh;//DB接続情報を保持

    // DBに接続するメソッド
    public static function get_db_connect()
    {
        try 
        { //DBに接続されていない場合
            if(self::$dbh === null){
                //DBに接続する
                self::$dbh = new PDO(DSN,DB_USER,DB_PASSWORD); //self:: staticメンバーにアクセスするときに使う
            }
        }
        // DB接続が失敗したとき
        catch (PDOException $e) 
        {  // エラーメッセージを表示して終了
            echo $e->getMessage();
            die();
        }
        //DB接続オブジェクトを返す
        return self::$dbh;
    }
}
