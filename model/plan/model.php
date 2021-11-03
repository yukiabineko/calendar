<?php
require_once 'base.php';

class planModel{
   public $id;
   public $dy;
   public $memo;
   public $tasks;
   public $user_id;

   public function create(string $param = null, int $user_id){
       $base = new BasePlan();
       $base->create($param, $user_id);

   }
   public function all(int $user_id): array{
      $base = new BasePlan();
      $rows = $base->all($user_id);
      $arr = array();
      foreach($rows as $row){
          $obj = new Plan();
          $obj->id = $row['id'];
          $obj->dy = $row['dy'];
          $obj->memo = $row['memo'];
          $obj->user_id =$user_id;
          array_push($arr, $obj);
      }
      return $arr;
   }
   public function where(int $user_id, string $param = null): array{
       $base = new BasePlan();
       $rows = $base->where($user_id, $param);
       $arr = array();
      foreach($rows as $row){
          $obj = new plan();
          $obj->id = $row['id'];
          $obj->dy = $row['dy'];
          $obj->memo = $row['memo'];
          $obj->user_id =$user_id;
          array_push($arr, $obj);
      }
      return $arr;
   }
   public function find(int $id): self{
      $base = new BasePlan();
      $row = $base->find($id);
      $this->id = $row['id'];
      $this->dy = $row['dy'];
      $this->memo = $row['memo'];
      return $this;
   }
   public function find_by(int $user_id,string $params): self{
      $key = explode(':', $params)[0];
      $value = explode(':',$params)[1];
      if($key =="dy"){
         $base = new BasePlan();
         $row = $base->searchDay($user_id, $value);
         $this->id = $row['id'];
         $this->dy = $row['dy'];
         $this->memo = $row['memo'];
         return $this;
      }
   }
   
   //リレーションのタスクを取得
   public function tasks(): self{
      require './model/task/task.php';
      $task_obj = new task();
      $tasks = $task_obj->all($this->id);
      $this->tasks = $tasks;
      return $this;
   }
   //リレーションタスクレコード数
   public function count(): int{
      return count($this->tasks);
   }
   /******************************************************************************* */
   /*
   static function
   */
  //前年度のレコード数
  public static function before_count(string $before_year, int $user_id): int{
   $base = new BasePlan();
   return $base->before_record_count($before_year, $user_id);
  }
  //次年度のレコード数
  public static function after_count(string $after_year, int $user_id): int{
   $base = new BasePlan();
   return $base->after_record_count($after_year, $user_id);
  }
   
}