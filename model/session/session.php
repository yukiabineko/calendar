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
        if($this->password_check( )== false && empty($errors)){
            array_push($errors, 'パスワードもしくはメールアドレスが間違ってます。');
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
               if($this->password_check()){
                   $_SESSION['current_user'] = $this->sessin_confirm_record();     /*#=>定義された関数から*/
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
    /**
     * 認証パスワード確認用レコード
     */
    public function sessin_confirm_record(): array{
        $smt = $this->pdo->prepare('SELECT * FROM users WHERE email=?');
        $smt->bindValue(1, htmlspecialchars($_POST['email'],ENT_QUOTES), PDO::PARAM_STR);
        $smt->execute();
        $record = $smt->fetch(PDO::FETCH_ASSOC);
        return  !empty($record)? $record : [];
    } 
    /**
     * @password_check
     */
    public function password_check(): bool{
        $record = $this->sessin_confirm_record();
        return (password_verify($_POST['password'], $record['password']) && !empty($record) ) ?true : false;
    }
    /**
     * ログアウト処理 
     */
    public function destroy(){
       if(isset($_SESSION['current_user'])){
           unset($_SESSION['current_user']);
       }
    }

}