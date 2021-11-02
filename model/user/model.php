<?php
require_once 'base.php';

class userModel{
    public $id;
    public $name;
    public $email;
    public $plan_array;

    public function create(array $params): bool{
        $base = new BaseUser();
        $base->create($params);
        return true;
    }
    public function find(int $id): self{
        $base = new BaseUser();
        $row =$base->find($id);
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        return $this;
    }

    //当該ユーザーの関連プラン

    public function plans(): self{
        $planObj = new Plan();
        $plans = $planObj->all((int)$this->id);
        $arr = array();
        foreach($plans as $plan){
           array_push($arr, $plan);
        }
        $this->plan_array = $arr;
        return $this;
    }
    //上の関数から当該日ずけのオブジェ取得
    public function find_plan(string $param_date ): Plan{
        foreach($this->plan_array as $pl){
           if($param_date == $pl->dy){
              return $pl;
           }
        }
    }
    //レコードアップロード
    public function update(array $params, int $id): bool{
        $base = new BaseUser();
        if($base->update($params,$id)){
            return true;
        }
        else{
            return false;
        }
    }
}