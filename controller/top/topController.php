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
    /**
     * ajaxによるレコードを取得
     */
    public function show(){
      if(isset($_SESSION['current_user'])){
          switch ($_GET['type']) {
            case 1:
              //当日レコード
              $today_data = $this->today_data();
              echo json_encode($today_data, JSON_UNESCAPED_UNICODE);
            break;

            case 2:
              //一週間のレコード
              $weeks_data = $this->one_week_data();
              echo json_encode($weeks_data, JSON_UNESCAPED_UNICODE);
            break;

            case 3:
              //一ヶ月レコード
              $months_data = $this->one_month_data();
              echo json_encode($months_data, JSON_UNESCAPED_UNICODE);
            break;

            case 4:
              //本日未完了
              $today_incompletes = $this->today_incomplete();
              echo json_encode($today_incompletes, JSON_UNESCAPED_UNICODE);
            break;

            case 5:
              //一週間未完了
              $weekly_incompletes = $this->weekly_incomplete();
              echo json_encode( $weekly_incompletes, JSON_UNESCAPED_UNICODE);
            break;
            
            default:
              //一ヶ月未完了
              $monthly_incomletes = $this->monthly_incomplete();
              echo json_encode($monthly_incomletes, JSON_UNESCAPED_UNICODE);
            break;
          }
      }  
    }
    //
}
