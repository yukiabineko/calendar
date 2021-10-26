<?php

require_once 'model.php';

class Plan extends planModel{
   public static function getDateFormat(string $date): string{
       $year = date('Y',strtotime($date));
       $month = date('m',strtotime($date));
       return $year.'年'.$month.'月';
   }
   //日付けが今日より前か後かチェック(今日以前の場合false)
   public function  before_today(): bool{
    $today = date('Y-m-d');
    return strtotime($today) <= strtotime($this->dy) ?true : false;
   }
   
}