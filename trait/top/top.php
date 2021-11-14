<?php
namespace module\task;

trait top_module{
    public function weeks_first_day(): string{
        $today = date('Y-m-d');
        $week_number = date('w',strtotime($today));
        $start = date('Y-m-d', strtotime("- {$week_number} day".$today));
        return $start;
    }
}