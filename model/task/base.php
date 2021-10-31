<?php 

class baseTask{
  protected $pdo;

  public function __construct()
  {
     $this->pdo = new PDO(Connect::$dbinfo, Connect::$dbuser, Connect::$dbpass);
     $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $this->pdo->exec('CREATE TABLE IF NOT EXISTS task(
      id INT PRIMARY KEY AUTO_INCREMENT,
      content VARCHAR(200) NOT NULL,
      working_time DATETIME NOT NULL,
      status INT DEFAULT 1,
      plan_id INT NOT NULL,
      FOREIGN KEY fk_plan_id(plan_id) REFERENCES plan(id)
    )');
  }
  public function __destruct()
  {
    $this->pdo = null;
  }
  public function create(array $params): bool{
      /*
      バリデーション対策
      */
      $this->validation();
      if(!empty($_SESSION['errors'])){
          $_SESSION['old']= $params;
          $_SESSION['render'] = true;
          header('location: /calendar/task/new?plan_day='.$params['plan_date']);
          exit();
          return false;
      }
      /* csrf対策 okなら登録 */
      if($params['csrf-token'] == $_SESSION['csrf_token']){
        try{
          
          $datetimeArray = [$params['plan_date'], $params['working_time']];
          $working_time = implode(' ',$datetimeArray );     //=>datetime整形
        
          
          $smt = $this->pdo->prepare('INSERT INTO task(content, working_time, plan_id)VALUES(?, ?, ?)');
          $smt->bindValue(1, $params['content'], PDO::PARAM_STR);
          $smt->bindValue(2, $working_time, PDO::PARAM_STR);
          $smt->bindValue(3, (int)$params['plan_id'], PDO::PARAM_INT);
          $smt->execute();
          return true;
      }
      catch(Exception $e){
        echo $e->getMessage();
        die();
      }
    }
    else{
      header('location: /calendar/plan/index?plan_day='.$params['plan_date']);
      exit();
    }
      
  }
  public function all(int $plan_id): array{
    try{
        $smt = $this->pdo->prepare('SELECT * FROM task WHERE plan_id=?');
        $smt->bindValue(1, $plan_id, PDO::PARAM_INT);
        $smt->execute();
        $results = $smt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
      
    }
    catch(Exception $e){}
  }
  //個別レコード表示
  function show(int $id): array{
     try{
       $smt = $this->pdo->prepare('SELECT * FROM task WHERE id= ?');
       $smt->bindValue(1, $id, PDO::PARAM_INT);
       $smt->execute();
       $result = $smt->fetch(PDO::FETCH_ASSOC);
       return $result;

     }
     catch(Exception $e){
       $e->getMessage();
       die();
     }
  }
  public function change_status(array $params): bool{
     try{
        $id = $params['id'];
        $status = $params['status'];
        switch ($status) {
          case '1':
            $setStaus = 2;
            break;
          case '2':
            $setStaus = 1;
            break;
          default:
            break;
        }
        $smt = $this->pdo->prepare('UPDATE task SET status=? WHERE id=?');
        $smt->bindValue(1, $setStaus, PDO::PARAM_INT);
        $smt->bindValue(2, $id, PDO::PARAM_INT);
        $smt->execute();
        return true;
      
     }
     catch(Exception $e){
       $e->getMessage();
       die();
       return false;
     }
  }
  //更新処理
  public function update(array $params): bool{
     /*
      バリデーション対策
      */
      $this->validation();
      if(!empty($_SESSION['errors'])){
          $_SESSION['old']= $params;
          $_SESSION['render'] = true;
          header('location: /calendar/task/new?plan_day='.$params['plan_date']);
          exit();
          return false;
      }
      /* csrf対策 okなら編集 */
      if($params['csrf-token'] == $_SESSION['csrf_token']){
        try{
          $datetimeArray = [$params['plan_date'], $params['working_time']]; 
          $working_time = implode(' ',$datetimeArray );  //=>datetime整形
        
          
          $smt = $this->pdo->prepare('UPDATE task SET content=?, working_time=? WHERE id=? AND plan_id=?');
          
          $smt->bindValue(1, $params['content'], PDO::PARAM_STR);
          $smt->bindValue(2, $working_time, PDO::PARAM_STR);
          $smt->bindValue(3, (int)$params['task_id'], PDO::PARAM_INT);
          $smt->bindValue(4, (int)$params['plan_id'], PDO::PARAM_INT);
          $smt->execute();
          return true;
      }
      catch(Exception $e){
        echo $e->getMessage();
        die();
      }
    }
    else{
      header('location: /calendar/plan/index?plan_day='.$params['plan_date']);
      exit();
    }
  }
  //タスクの削除
  public function delete(int  $id): bool{
    try{
      /* csrf対策 okなら登録 */
      if($_POST['csrf-token'] == $_SESSION['csrf_token']){
        $smt = $this->pdo->prepare('DELETE FROM task WHERE id=?');
        $smt->bindValue(1, (int)$id, PDO::PARAM_INT);
        $smt->execute();
        return true;
      }
      return false;
    }
    catch(Exception $e){
      $e->getMessage();
      die();
      return false;
    }
  }
  
  //バリデーション
  public function validation(){
    $errors = [];
    $ja = ['content'=>'作業名', 'working_time'=>'作業日時'];
    foreach($_POST as $key=>$value){
      empty($value) ?array_push($errors, $ja[$key].'は必須です。') : '';
   }
   $_SESSION['errors'] = $errors;
  }

}