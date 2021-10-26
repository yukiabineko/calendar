<?php
class Controller{
   protected  $current_user_id = null;

   public function __construct(int...$id)
   {
      if(!empty($id)){
         $this->current_user_id = $id[0];
      }
    
   }
   
    public function __set($name, $value){
       $this->$name = $value;
    }
    public function __get($name){
       if($this->$name){
          return $this->$name;
       }
       else{
          return null;
       }
    }
}