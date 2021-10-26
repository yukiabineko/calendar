<?php
require './trait/user/token.php';

class sessionController extends Controller{
    use user\create\tokenCreate;

    public function new(){
        $this->toptitle = "ログイン";
        $token = $this->createToken();
        $_SESSION['csrf_token'] = $token;
        $this->csrf = $token;
    }
    public function create(){
        $auth = new session();
        $auth->auth($_POST);
    }
    public function destroy(){
        $auth = new session();
        $auth->destroy();
        header('location: /calendar/top/index');
        exit();

    }
}
