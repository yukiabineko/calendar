<?php

class session{
    /*ログイン認証*/
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(Connect::$dbinfo, Connect::$dbuser, Connect::$dbpass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function __destruct()
    {
        $this->pdo = null;
    }


    public function auth_validation(){
        $errors = [];
        $ja = ['email'=>'メールアドレス', 'password'=>'パスワード'];

        foreach($_POST as $key=>$value){
           empty($value) ?array_push($errors, $ja[$key].'は必須です。') : '';
        }
        if(!empty($_POST['email'])){
            !preg_match( '/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $_POST['email']) ?array_push($errors, 'メールアドレスが不正です。') : ''; 
        }
        $_SESSION['errors'] = $errors;
    }
    
    /*認証*/

    public function auth(array $params){
       /*
        バリデーション対策
        */
        $this->auth_validation();
        if(!empty($_SESSION['errors'])){
            $_SESSION['old']= $params;
            $_SESSION['render'] = true;
            header('location: /calendar/session/new');
            exit();
            return false;
        }
        else{
           if(isset($_SESSION['old'])){ unset($_SESSION['old']); }
        }
         /* csrf対策 okなら登録 */
         if($params['csrf-token'] == $_SESSION['csrf_token']){
            try{
               
               $smt = $this->pdo->prepare('SELECT * FROM users WHERE email=?');
               $smt->bindValue(1, htmlspecialchars($params['email'],ENT_QUOTES), PDO::PARAM_STR);
               $smt->execute();
               $record = $smt->fetch(PDO::FETCH_ASSOC);
               if(password_verify($params['password'], $record['password'])){
                   $_SESSION['current_user'] = $record;
                   header('location: /calendar/top/index');
                   exit();
               }
               else{
                    header('location: /calendar/session/new');
                    exit();
               }
            }
           
            catch(Exception $e){}
         }
    }
    /* ログアウト処理 */
    public function destroy(){
       if(isset($_SESSION['current_user'])){
           unset($_SESSION['current_user']);
       }
    }

}