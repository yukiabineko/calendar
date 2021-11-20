<?php 

class topController extends Controller{
   use module\task\top_module;

    public function index(){
        $this->toptitle = "トップページ";
        //当日レコード
        $this->today_data = $this->today_data();
        //一週間のレコード
        $this->weeks_data = $this->one_week_data();
        //一ヶ月レコード
        $this->months_data = $this->one_month_data();
        //本日未完了
        $this->today_incompletes = $this->today_incomplete();
        //一週間未完了
        $this->weekly_incompletes = $this->weekly_incomplete();
        //一ヶ月未完了
        $this->monthly_incomletes = $this->monthly_incomplete();
        
    }
    public function show(){
      if(isset($_SESSION['current_user'])){
          echo 'ok';
      }  
    }
}