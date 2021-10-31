<?php 
require './model/plan/plan.php';

class taskController extends Controller{

    //登録ページ
    public function new(){
        $this->toptitle = "新規作業登録";
        if(isset($_GET['plan_day'])){
            $planObj = new Plan();
            $this->plan = $planObj->find_by($this->current_user_id, 'dy:'.$_GET['plan_day']);    //関連日のプランオブジェクト

            //トークン
            $str = openssl_random_pseudo_bytes(16);
            $token = bin2hex($str);
            $_SESSION['csrf_token'] = $token;
            $this->csrf = $token;
        }
        else{
            header('location: /top/index');
            exit();
        }
    }
    //登録
    public function create(){
        $task =new task();
        if($task->create($_POST)==true){
            header('location: /calendar/plan/index?plan_day='.$_POST['plan_date']);
            exit();
        }
    }
    //ajax 検索
    public function show(){
        $task =new task();
        $record = $task->find((int)$_GET['task_id']);
        $array = array(
            'id'=>$record->id, 
            'content'=>$record->content, 
            'working_time'=>$record->working_time,
            'status'=>$record->status,
            'plan_id'=>$record->plan_id
        );
       echo  json_encode($array);
    }
    //ステータス更新
    public function change(){
        $task =new task();  
        $task->change_status($_POST);
        header('location: /calendar/plan/index?plan_date='.$_POST['plan_date']);
        exit();
    }
    //タスク編集ページ
    public function edit(){
       $this->task = new task();
       $this->task = $this->task->find($_GET['id']);
       $this->toptitle = $this->task->content.'編集';
       $this->plan = new Plan();
       $this->plan = $this->plan->find((int)$this->task->plan_id);
       
       //トークン
       $str = openssl_random_pseudo_bytes(16);
       $token = bin2hex($str);
       $_SESSION['csrf_token'] = $token;
       $this->csrf = $token;
    }
    //タスク編集処理
    public function update(){
        print_r($_POST);
        $this->task = new task();
        if($this->task->update($_POST)){
            header('location: /calendar/plan/index?plan_date='.$_POST['plan_date']);
            exit();   
        }
    }
    //タスクの削除処理
    public function delete(){
       foreach($_POST['tasks'] as $id){
           $task = new task();
           $task->delete((int)$id);
       }
       header('location: /calendar/plan/index?plan_date='.$_POST['plan_date']);
       exit();
    }
}