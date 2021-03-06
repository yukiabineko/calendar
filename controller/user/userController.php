<?php 

class userController extends Controller{
    use user\create\tokenCreate;

    public function new(){

        $this->toptitle = "新規会員登録";
        $token = $this->createToken();
        $_SESSION['csrf_token'] = $token;
        $this->csrf = $token;
    }

    public function create(){
        $user = new user();
        if($user->create($_POST)){
            header('location: /calendar/top/index');
            exit();
        }
    }

    public function edit(){

        //他のユーザーがurl操作でアクセスするのを防止
        if($_GET['id'] != $_SESSION['current_user']['id']){
            $_SESSION['flash'] = array('success'=>'操作が不正です。');
            header('location: /calendar/top/index');
            exit();
        }
        $this->user = new user();
        $this->user->find($_GET['id']);
        $this->toptitle = "会員編集";
        $token = $this->createToken();
        $_SESSION['csrf_token'] = $token;
        $this->csrf = $token;
        
    }
   
    public function update(){
        $user = new user();
        if($user->update($_POST, (int)$_GET['id'])){
            header('location: /calendar/top/index');
            exit();
        }
    }
}