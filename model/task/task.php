<?php

require_once 'model.php';

class task extends taskModel{
  const STATUS = [
    1=>['label' => '未着手', 'style'=>'#A9A9A9'],
    2=>['label' => '完了済', 'style'=>'#2C7CFF'],
    3=>['label' => '予定日前', 'style'=>'#A9A9A9'],
    4=>['label' => '期限切れ', 'style'=>'#FF0000'],
  ];
    //日付けのフォーマット
    public function dateFormat(){
        return date('Y/m/d',strtotime(($this->working_time)));
      }
    //時間のフォーマットz
    public function timeFormat(){
      return date('H時i分',strtotime(($this->working_time)));
    }

    //ステータスの状況でラベルの変化

    public function getStatausLabel(): string{
       $today = date('Y-m-d');
       $time_limit = date('Y-m-d', strtotime($this->working_time));

       //まず日付けが当日以前か当日か後かで分岐

       if(strtotime($today) == strtotime($time_limit)){
          return  $this->status == 1 ?self::STATUS[1]['label'] : self::STATUS[2]['label'];
       }
       elseif(strtotime($today) < strtotime($time_limit)){
         return self::STATUS[3]['label'];
       }
       elseif(strtotime($today) > strtotime($time_limit)){
        return $this->status == 2 ?self::STATUS[2]['label'] : self::STATUS[4]['label'];
      }
    }
     //ステータスの状況でcssスタイルの変化

    public function getStatausStyle(): string{
      $today = date('Y-m-d');
      $time_limit = date('Y-m-d', strtotime($this->working_time));

      //まず日付けが当日以前か当日か後かで分岐

      if(strtotime($today) == strtotime($time_limit)){
         return  $this->status == 1 ?self::STATUS[1]['style'] : self::STATUS[2]['style'];
      }
      elseif(strtotime($today) < strtotime($time_limit)){
        return self::STATUS[3]['style'];
      }
      elseif(strtotime($today) > strtotime($time_limit)){
       return $this->status == 2 ?self::STATUS[2]['style'] : self::STATUS[4]['style'];
     }
   }
   //viewの編集ページのinput value用
   public function getTimeValue(){
     return date('H:i',strtotime($this->working_time));
   }
   
}