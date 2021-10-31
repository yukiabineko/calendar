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
        
    }
}