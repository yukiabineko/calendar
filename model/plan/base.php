<?php 

class BasePlan {
    protected $pdo;

    public function __construct()
    {
       $this->pdo = new PDO(Connect::$dbinfo, Connect::$dbuser, Connect::$dbpass);
       $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $this->pdo->exec('CREATE TABLE IF NOT EXISTS plan(
        id INT PRIMARY KEY AUTO_INCREMENT,
        dy DATE NOT NULL,
        user_id INT,
        memo VARCHAR(22),
        FOREIGN KEY fk_user_id(user_id) REFERENCES users(id)
      )');
    }
    public function create(string $param = null, int $user_id){
        try{
           
           $smt = $this->pdo->prepare('INSERT INTO plan( dy, memo, user_id)VALUES(?,?,?)');
           if(isset($param)){
            $date = date('Y-m-d',strtotime($param));
            $last = date('j', strtotime('last day of'.$date));
            $year = date('Y',strtotime($param));
            $month = date('m',strtotime($param));
           }
           else{
            $date = date('Y-m-d');
            $last = date('j', strtotime('last day of'.$date));
            $year = date('Y');
            $month = date('m');
           }
           
           foreach(range(1,$last) as $i){
               $dt = date('Y-m-d',strtotime($year.'-'.$month.'-'.$i));
               $record = $this->searchDay($user_id, $dt);
               if(empty($record)){
                $smt->bindValue(1, $dt, PDO::PARAM_STR);
                $smt->bindValue(2, null, PDO::PARAM_STR);
                $smt->bindValue(3, $user_id, PDO::PARAM_INT);
                $smt->execute();
               }
           }
        }
        catch(Exception $e){}
    }
    public function all(int $user_id){
        try{
            $smt = $this->pdo->prepare('SELECT * FROM plan WHERE user_id=?');
            $smt->bindValue(1,$user_id,PDO::PARAM_INT);
            $smt->execute();
            $results = $smt->fetchAll(PDO::FETCH_ASSOC);
            $this->pdo = null;
            return $results;
         }
         catch(Exception $e){
             echo $e->getMessage();
             die();
         }
    }
    public function where(int $user_id, string $param = null){
        try{
            $date = isset($param) ?date('Y-m-d',strtotime($param)) : date('Y-m-d');
            $first = date('Y-m-d',strtotime('first day of'.$date));
            $last =  date('Y-m-d',strtotime('last day of'.$date));

            $smt = $this->pdo->prepare('SELECT * FROM plan WHERE (dy BETWEEN ? AND ?) AND user_id=?');
            $smt->bindValue(1, $first, PDO::PARAM_STR);
            $smt->bindValue(2, $last, PDO::PARAM_STR);
            $smt->bindValue(3, $user_id, PDO::PARAM_INT);
            $smt->execute();
            $results = $smt->fetchAll(PDO::FETCH_ASSOC);
            $this->pdo = null;
            return $results;
         }
         catch(Exception $e){
             echo $e->getMessage();
             die();
         }
    }
    /*個別表示 */
    public function find(int $id){
        try{
            
            $smt = $this->pdo->prepare('SELECT *FROM plan WHERE id=?');
            $smt->bindValue(1, $id, PDO::PARAM_INT);
            $smt->execute();
            $result = $smt->fetch(PDO::FETCH_ASSOC);
            $this->pdo = null;
            return $result;

        }
        catch(Exception $e){
            echo $e->getMessage();
            die();
        }
    }
  // 日ごとの検索
  public function searchDay(int $user_id, string $dy){
     try{
        $smt = $this->pdo->prepare('SELECT*FROM plan WHERE dy=? AND user_id=?');
        $smt->bindValue(1, $dy, PDO::PARAM_STR);
        $smt->bindValue(2, $user_id, PDO::PARAM_INT);
        $smt->execute();
        $result = $smt->fetch(PDO::FETCH_ASSOC);
        return $result;

     }
     catch(Exception $e){
         $e->getMessage();
         die();
     }
  }
  //ユーザー idと日ずけで取得
  public function find_date(int $user_id, string $day){
    $smt = $this->pdo->prepare('SELECT * FROM plan WHERE dy=? AND user_id=?');
    $smt->bindValue(1, $day, PDO::PARAM_STR);
    $smt->bindValue(2, $user_id, PDO::PARAM_INT);
    $smt->execute();
    $result = $smt->fetch(PDO::FETCH_ASSOC);
    $this->pdo = null;
    return $result;
  }
}