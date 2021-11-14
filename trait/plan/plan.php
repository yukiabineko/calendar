<?php

namespace plan\calender;

use task;

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
       else if(is_null($target_year)){
          $this_month = date('m');
          $months = array();
          foreach(range(1, $this_month) as $month){
            array_push($months, $month);
          }
       }
       return $months;
   }
   //アクセス端末のチェック
   public function is_mobile(): bool{
    $user_agent = $_SERVER['HTTP_USER_AGENT']; // HTTP ヘッダからユーザー エージェントの文字列を取り出す
    return preg_match('/iphone|ipod|ipad|android/ui', $user_agent) != 0; // 既知の判定用文字列を検索
  }
   /**
    * 月ごとの履歴の総数を計算その後5件ごとにするため1/5分けしてページネーションの数確定
    */
    public function pagination_set(array  $tasks): string{
        if( !$this->is_mobile()){
            $url = "/calendar/plan/history?user_id=".$_GET['user_id']."&year=".( isset($_GET['year'])? $_GET['year'] : date('Y') )
        ."&date=".$_GET['date'].(isset($_GET['first'])?'&first='.$_GET['first'] : '');
        }
        else{
           $url = "/calendar/plan/tasks?user_id=".$_GET['user_id']."&year=".( isset($_GET['year'])? $_GET['year'] : date('Y') )
           ."&date=".$_GET['date'].(isset($_GET['first'])?'&first='.$_GET['first'] : '');
        }
       

        if( !empty($tasks) ){
            //全レコードを5で割り全ページネーションページ数を算出
            $count = ceil( count($tasks) /5 );  

            //ページネーションページ数が5以上ならば5で切り替えるようにするため算出
            $div_count = $count >=6 ?ceil( $count / 5) : 1;

            //ページネーション表示最初のページ
            $first = isset($_GET['first']) ?(int)$_GET['first'] : 1;
            //ページネーション表示最後のページ($conutをオーバーしてしまった場合は上限$count)
            $last = ( $first + 4 ) <= $count ?($first + 4) : $count;


            //echo $count;
            $html = '<div class="pagination">';
            $html .= $first != 1 ?'<div class="pagination-item">
              <a href="'.$url.'&page='.($first - 1).'&first='.($first - 1).'">< 前</a>
              </div>' : '';
            
            foreach(range($first, $last) as $i){
                $html.= '<div class="pagination-item"'.testCol($i).'>';
                $html.= '<a href="'.$url.'&page='.$i.'" '.testCol($i).'>'.$i.'</a>';
                $html.='</div>';
            }
            (($div_count >=2) && $last < $count) ?$html.='<div class="pagination-item">
              <a href="'.$url.'&page='.($first +1).'&first='.($first + 1).'">< 次</a>
            </div>&nbsp;' : '';

            $html.= '</div>';
            return $html;
        }
        else { return '';}
     }
     
}
/**
 * ページネーション選択ページcss変動
 */
 function testCol(int $num): string{
   if(isset($_GET['page'])){
       return (int)$_GET['page'] == $num ? 'style=background:blue;color:white' : '';
   }
   else{
       return $num ==1 ? 'style=background:blue;color:white' : '';
   }
}
