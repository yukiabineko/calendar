<?php 
class planController extends Controller{
    use plan\calender\planHelper;

    public function index(){
        $this->toptitle = "スケジュール";
        $user_id = $this->current_user_id;
        $record = new user();
        $user = $record->find($user_id);
        
    
        $plan = new Plan();
       
        $plan->create(isset($_GET['date'])? $_GET['date'] : null, (int)$user->id);
        $this->plans = $plan->where((int)$user->id, isset($_GET['date'])? $_GET['date'] : null);
        $this->firstPlan = date('Y-m-d',strtotime($this->plans[0]->dy));

        //trait plan.phpで定義(カレンダー項目)
        $this->weeks = $this->getweek();
        $this->prevData = $this->getPrev($this->plans[0]->dy);
        $this->dates = $this->getDay($this->plans);
        $this->nextData = $this->getNext($this->plans[0]->dy);


         //選択日付けユーザーモデルメソッドチェーン(user object)
         $this->current_plan = isset($_GET['plan_day'])?$user->plans()->find_plan($_GET['plan_day']) : $user->plans()->find_plan(date('Y-m-d'));
        
         //日付けごとのタスク一覧
         $this->tasks = $this->current_plan->tasks()->tasks;

         //トークン
         $str = openssl_random_pseudo_bytes(16);
         $token = bin2hex($str);
         $_SESSION['csrf_token'] = $token;
         $this->csrf = $token;

    }
    
    public function show(){
        $record = new Plan();
        $plan = $record->find($_GET['id']);
        echo json_encode($plan);
        
    }

    public function history(){
        $files = get_included_files();
        $include_file = './model/task/task.php';

        //タスクモデルファイル読み込んでなければ読み込み
        !in_array($include_file, $files)? require $include_file : '';


        $user = new user();
        $this->user = $user->find((int)$_GET['user_id']);


         //該当年度セット(当年、前年、次年)
        $this->target_year = isset($_GET['year'])? $_GET['year'] : date('Y'); 
        $this->prev_year = (int)$this->target_year - 1;
        $this->next_year = (int)$this->target_year + 1;
        
        $this->toptitle = "履歴";

        //前年数
        $this->before_count = Plan::before_count(isset($_GET['year'])? $_GET['year'] : date('Y'), (int)$_GET['user_id']);

        //来年度
        $this->after_count = Plan::after_count(isset($_GET['year'])? $_GET['year'] : date('Y'), (int)$_GET['user_id']);
       

        //左エリアの月リスト
        $this->months = $this->each_year_month(isset($_GET['year'])? $_GET['year'] : null);

        //右エリアにて各月のタスクリスト
         $task =new task();
         $this->tasks = $task->one_month_task(isset($_GET['date'])? $_GET['date'] : date('Y-m'));
         $this->pagination = $this->pagination_set($this->tasks);
         $this->tasks = $task->pagination_task(isset( $_GET['page'])? $_GET['page'] : null );
         
        
    }

    //スマホのみ年月タスク表示ページ
    public function tasks(){
       if(!$this->is_mobile()){
           header('location: /calendar/top/index');
           exit();
       }
       $files = get_included_files();
        $include_file = './model/task/task.php';

        //タスクモデルファイル読み込んでなければ読み込み
        !in_array($include_file, $files)? require $include_file : '';


        $user = new user();
        $this->user = $user->find((int)$_GET['user_id']);
        
        //各月のタスクリスト
         $task =new task();
         $this->tasks = $task->one_month_task(isset($_GET['date'])? $_GET['date'] : date('Y-m'));
         $this->pagination = $this->pagination_set($this->tasks);
         $this->tasks = $task->pagination_task(isset( $_GET['page'])? $_GET['page'] : null );
         
    }
}
