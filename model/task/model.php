<?php

require_once 'base.php';

class taskModel{
    public $id;
    public $content;
    public $working_time;
    public $plan_id;
    public $status;
    public $tasks = array();

    public function all(int $user_id): array{
        $base = new baseTask();
        $rows = $base->all($user_id);
        $arr = array();
        foreach($rows as $row){
          $task = new task();
          $task->id = $row['id'];
          $task->content = $row['content'];
          $task->working_time = $row['working_time'];
          $task->plan_id = $row['plan_id'];
          $task->status = $row['status'];
          array_push($arr, $task);
        }
      return $arr;
    }
    public function create(array $params){
      $base = new baseTask();
      return $base->create($params);
    }
    public function find(int $id): self{
      $base = new baseTask();
      $row = $base->show($id);
      $this->id = $row['id'];
      $this->content = $row['content'];
      $this->working_time = $row['working_time'];
      $this->plan_id = $row['plan_id'];
      $this->status = $row['status'];
      return $this;
    }
    public function change_status(array $params){
      $base = new baseTask();
      $base->change_status($params);

    }
    public function update(array $params): bool{
      $base = new baseTask();
      if($base->update($params)){
        return true;
      }
      else{
        return false;
      }
    }

    //削除
    public function delete(int $id): bool{
     
      $base = new baseTask();
      if($base->delete($id)){
        return true;
      }
      else{
        return false;
      }
    }

    //一ヶ月分のタスクを検索
    public function one_month_task(string $send_date): array{
       $tasks = array();

       if(isset($_SESSION['current_user'])){
         $base = new baseTask();
         $records = $base->target_tasks((int)$_SESSION['current_user']['id'], $send_date);
         
         foreach($records as $record){
           $new_task = new task();
           $new_task->id = $record['id'];
           $new_task->content = $record['content'];
           $new_task->working_time = $record['working_time'];
           $new_task->status = $record['status'];
           $new_task->plan_id = $record['plan_id'];
           array_push($tasks, $new_task);
         }
       }
       $this->tasks = $tasks;
       return $tasks;
    }

    /**
     * 任意の範囲のタスク取得
     */
    public function get_range_task(string $first, string $last): array{
      $tasks = array();
      if(isset($_SESSION['current_user'])){
        $base = new baseTask();
        $records = $base->range_task_acquisition((int)$_SESSION['current_user']['id'], $first, $last);
        
        foreach($records as $record){
          $new_task = new task();
          $new_task->id = $record['id'];
          $new_task->content = $record['content'];
          $new_task->working_time = $record['working_time'];
          $new_task->status = $record['status'];
          $new_task->plan_id = $record['plan_id'];
          array_push($tasks, $new_task);
        }
      }
      $this->tasks = $tasks;
      return $tasks;
    }

    /**
     * ページネーションによる分割タスク
     */
    public function pagination_task(int $page = null){
      //5の数が振り分け数(ここを変更すれば振り分け数ができる。)
      if(isset( $this->tasks ) ){
        $page = $page ?? 1;
        $start = $page !=1 ?(($page - 1) * 5 ) : 0;
        $num = $start !=0 ?($page - 1) * 5 + 5 : 5;
         
        return array_slice($this->tasks, $start, 5);
      }
    }
  
    
}