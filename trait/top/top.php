<?php
namespace module\task;
require './model/task/task.php';
use Task;

trait top_module{
    //週初め
    public function weeks_first_day(): string{
        $today = date('Y-m-d');
        $week_number = (int)date('w',strtotime($today));
        $start = date('Y-m-d', strtotime("-{$week_number} day".$today));
        return $start;
    }
    //週末
    public function weeks_last_day(): string{
        $today = date('Y-m-d');
        $first_num = date('w', strtotime($this->weeks_first_day()));
        $last_num = 6 -(int)$first_num;
        return date('Y-m-d', strtotime("+{$last_num} day".$today));
    }
    //当日レコード取得
    public function today_data(){
        $task = new Task();
        return $task->get_range_task( date('Y-m-d'), date('Y-m-d') );

    }
    //週間のレコードの取得
    public function one_week_data(): array{
         $task = new Task();
         return $task->get_range_task( $this->weeks_first_day(), $this->weeks_last_day() );

    }
    //一ヶ月のレコードの取得
    public function one_month_data(): array{
       
         $task = new Task();
         return $task->one_month_task( $this->weeks_first_day());

    }
    //当日のうち未完了を抽出
    public function today_incomplete(){
        $weekTasks = $this->today_data();
        $new_array = array();
        foreach($weekTasks as $week){
          $week->status == 1? array_push($new_array, $week) : '';
        }
        return $new_array;
    }
    //一週間のうち未完了を抽出
    public function weekly_incomplete(){
        $weekTasks = $this->one_week_data();
        $new_array = array();
        foreach($weekTasks as $week){
          $week->status == 1? array_push($new_array, $week) : '';
        }
        return $new_array;
    }
    //一ヶ月のうち未完了抽出
    public function monthly_incomplete(){
      $monthTasks = $this->one_month_data();
      $new_array = array();
        foreach($monthTasks as $week){
          $week->status == 1? array_push($new_array, $week) : '';
        }
        return $new_array;
    }
}