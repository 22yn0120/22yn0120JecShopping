<?php
require_once 'DAO.php';

class Member
{
    public int $memberid; //会員ID
    public string $email; //メールアドレス
    public string $membername; //会員名
    public string $zipcode; //郵便番号
    public string $address; //住所
    public string $tel; //電話番号
    public string $password; //パスワード
}

class MemberDAO
{
    //DBからメールアドレスとパスワードが一致する会員データを取得する
    public function get_member(string $email,string $password)
    {
       //DBに接続する
       $dbh = DAO::get_db_connect();

       $sql ="SELECT * FROM member WHERE  email = :email ";
       $stmt = $dbh ->prepare($sql);

       $stmt ->bindValue(':email',$email,PDO::PARAM_STR);

       //SQLを実行する
       $stmt -> execute();

        //1件分のデータをGoodsクラスのオブジェクトとして取得する
        $member = $stmt->fetchObject('Member');

        //会員データが取得できたとき
        if($member !== false)
        {
            //パスワードが一致するか検証
            if(password_verify($password,$member->password))
            {
                //会員データを返す
                return $member;
            }
        }
        return false;
    }  
    
    //会員データを登録する
    public function insert(Member $member)
    {
        $dbh = DAO::get_db_connect();

        $sql="INSERT INTO Member(email,membername,zipcode,address,tel,password)
        VALUES(:email,:membername,:zipcode,:address,:tel,:password);";

        $stmt = $dbh ->prepare($sql);

        //パスワードをハッシュ化
        $password = password_hash($member->password,PASSWORD_DEFAULT);

        //SQLに変数の値を当てはめる
        $stmt ->bindValue(':email',$member->email,PDO::PARAM_STR);
        $stmt ->bindValue(':membername',$member->membername,PDO::PARAM_STR);
        $stmt ->bindValue(':zipcode',$member->zipcode,PDO::PARAM_STR);
        $stmt ->bindValue(':address',$member->address,PDO::PARAM_STR);
        $stmt ->bindValue(':tel',$member->tel,PDO::PARAM_STR);
        $stmt ->bindValue(':password',$password,PDO::PARAM_STR);

        //SQLを実行する
        $stmt -> execute();
    }

    //指定したメールアドレスの会員データが存在すればtrueを返す
    public function email_exists(String $email)
    {
        //DBに接続する
        $dbh = DAO::get_db_connect();

        $sql ="SELECT * FROM Member WHERE email=:email";

        $stmt = $dbh ->prepare($sql);

        //SQLに変数の値を当てはめる
        $stmt ->bindValue(':email',$email,PDO::PARAM_STR);

        //SQLを実行する
        $stmt -> execute();

        if($stmt -> fetch() !== false)
        {
            return true; //指定したメールアドレスの会員データが存在する
        }
        else{
            return false; //指定したメールアドレスの会員データが存在しない
        }
    }
}