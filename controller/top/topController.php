<?php 

class topController extends Controller{
   use module\task\top_module;

    public function index(){
        $this->toptitle = "トップページ";
        echo $this->weeks_first_day();
        
    }
}