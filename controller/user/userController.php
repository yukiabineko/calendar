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