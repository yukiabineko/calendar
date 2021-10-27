<?php 


class BaseUser{
     protected static array $user;

     protected $pdo;

     public function __construct(){
       $this->pdo = new PDO(Connect::$dbinfo, Connect::$dbuser, Connect::$dbpass);
       $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $this->pdo->exec('CREATE TABLE IF NOT EXISTS users(
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(20),
        email VARCHAR(40),
        password VARCHAR(100)
       )');
     }
     public function __destruct()
     {
         $this->pdo = null;
     }
    //errorの追加
    public function validation(){
        $errors = [];
        $ja = ['name'=>'名前', 'email'=>'メールアドレス','password'=>'パスワード', 'password_confirmation'=>'パスワード確認'];

        foreach($_POST as $key=>$value){
           empty($value) ?array_push($errors, $ja[$key].'は必須です。') : '';
        }
        $_POST['password'] != $_POST['password_confirmation']?array_push($errors, 'パスワードが一致しません。') : ''; 

        if(!empty($_POST['email'])){
            !preg_match( '/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $_POST['email']) ?array_push($errors, 'メールアドレスが不正です。') : ''; 
        }

        in_array($_POST['email'], $this->getEmail()) ?array_push($errors, 'そのメールアドレスはすでに存在します。') : ''; 

        
        (mb_strlen($_POST['password']) < 6 && !empty($_POST['password']) ) ?array_push($errors, 'パスワードは６文字以上です。') : ''; 
         $_SESSION['errors'] = $errors;
    }
    /*
    /*
    /*
    */

    //会員登録

    public function create(array $params){
        /*
        バリデーション対策
        */
        $this->validation();
        if(!empty($_SESSION['errors'])){
            $_SESSION['old']= $params;
            $_SESSION['render'] = true;
            header('location: /calendar/user/new');
            exit();
            return false;
        }
        else{
           if(isset($_SESSION['old'])){ unset($_SESSION['old']); }
        }

        /* csrf対策 okなら登録 */
        if($params['csrf-token'] == $_SESSION['csrf_token']){
           $hash_pass = password_hash($params['password'], PASSWORD_DEFAULT);
           try{
              
               $smt = $this->pdo->prepare('INSERT INTO users(name, email, password)VALUES(?, ?, ?)');
               $smt->bindValue(1, htmlspecialchars($params['name'], ENT_QUOTES, 'UTF-8'),PDO::PARAM_STR);
               $smt->bindValue(2, htmlspecialchars($params['email'], ENT_QUOTES, 'UTF-8'), PDO::PARAM_STR);
               $smt->bindValue(3, $hash_pass, PDO::PARAM_STR);
               $smt->execute();
               $_SESSION['flash'] = array('success'=>'登録しました。');

               return true;
           }
           catch(Exception $e){
               echo $e->getMessage();
               die();
           }
        }

    }
    /*ユーザーの個別読み込み*/
    public  function find(int $id): array{
        try{
            $smt = $this->pdo->prepare('SELECT*FROM users WHERE id=?');
            $smt->bindValue(1,$id, PDO::PARAM_INT);
            $smt->execute();
            $result = $smt->fetch(PDO::FETCH_ASSOC);
            $this->pdo = null;
            return $result;
        }
        catch(Exception $e){
            $e->getMessage();
            die();
        }
    }
    /*メール取り出し*/
    
    public function getEmail(){
        try{
           $smt = $this->pdo->query('SELECT email FROM users');
           $results = $smt->fetchAll(PDO::FETCH_ASSOC);
           $mails = array_map(function($record){
               return $record['email'];
           },$results);
           return $mails;

        }
        catch(Exception $e){
            echo $e->getMessage();
            die();
        }
    }

}
