<?php

namespace plan\calender;

trait planHelper
{
    public function getWeek(){
        $html = '<tr>';
        $weeks = ["日", "月", "火", "水", "木", "金", "土"];
        foreach($weeks as $week){
            $html .= '<th>'.$week.'</th>';
        }
        $html .= '</tr>';
        return $html;
    }
    public function getPrev(string $f){
       $html = '';
       $firstNum = date('w',strtotime($f));
       $year = date('Y',strtotime($f));
       $month = date('m',strtotime($f));
       $prev = date('Y-m',strtotime($year.'-'.($month - 1)));
       $prev_last = date('j',strtotime('last day of'.$prev));


       if($firstNum !=0){
          $html .= '<tr>';
          foreach(range(0,$firstNum-1) as $num){
              $html .= '<td class="empty">'.($prev_last - ($firstNum -1 - $num)).'</td>';
          }
       }
      return $html;
    }
    public function getDay(array $plans){
        $html = '';
        $first = date('Y-m-d',strtotime($plans[0]->dy)); 
        $lastDate = date('j',strtotime('last day of'.$first));
      
        foreach(range(0,$lastDate-1) as $i){
           $link = isset($_GET['date'])? '/calendar/plan/index?date='.$_GET['date'].'&plan_day='.$plans[$i]->dy : '/calendar/plan/index?plan_day='.$plans[$i]->dy;
           //選択日付け
           if(isset($_GET['plan_day'])){
             $select = $plans[$i]->dy == $_GET['plan_day'] ?'style=background:#00FF00' : '';
           }
           elseif(!isset($_GET['plan_day']) && !isset($_GET['date'])){
              $select = date('j',strtotime($plans[$i]->dy)) == date('j')? 'style=background:#00FF00' : '';  
           }
           else{ $select = date('j',strtotime($plans[$i]->dy)) == 1? 'style=background:#00FF00' : ''; }
          
           $num = date('w',strtotime($plans[$i]->dy));
           $cell = date('j',strtotime($plans[$i]->dy));
           if($num == 0) { $html.= '<tr>';}
           $html.='<td><a href="'.$link . '"'.$select.' id="day-'.$i.'">'.$cell.'</a></td>';
           if($num == 6) { $html.= '</tr>';}

        }
        return $html;
    }
    public function getNext(string $f){
       $html = '';
       $num = 1;
       $first = date('Y-m-d',strtotime($f));
       $lastNum = date('w',strtotime('last day of'.$first));
       if($lastNum !=6){
           for($i = $lastNum; $i<6; $i++){
            $html .= "<td class='empty'>".$num."</td>";
            $num ++;
           }
       }
       $html .='</tr>';
       return $html;
    }
    //履歴年度設定
   public function target_year(string $year = null): string{
      if(isset($year)){
          return date('Y',strtotime($year));
      }
      else{
          return date('Y');
      }
   }
   //各年度の月の振り分け(今年度の場合は今月まで)
   public function each_year_month(string $target_year = null): array {
       $target = date('Y-m-d',strtotime($target_year.'-01-01'));
       
       if(isset($target_year)){
         $months = array();
         foreach(range(1, 12) as $month){
             array_push($months, $month);
         }
       }
       else if(is_null($target_year) || date('Y') == date('Y',strtotime($target))){
          $this_month = date('m');
          $months = array();
          foreach(range(1, $this_month) as $month){
            array_push($months, $month);
          }
       }
       return $months;
   }
   
}
