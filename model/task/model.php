<?php

require_once 'base.php';

class taskModel{
    public $id;
    public $content;
    public $working_time;
    public $plan_id;
    public $status;

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
    
  
    
}