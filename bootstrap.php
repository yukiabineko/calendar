<?php
require 'route.php';
require 'database.php';
require 'connect.php';

/*database.phpでデータベースの変数を取得してConnect(static)クラスでデータベースコネクト変数を格納*/

Connect::setConnect($dbinfo,$dbuser,$dbpass);


$current_user = null;

class AutoLoader{
    public $class = null;
    public $action = null;

    public function register(){
       spl_autoload_register(array($this, 'loadClass'));
    }
    public function loadClass(){
        if(isset($this->class)){
            $controller_file = './controller/'.$this->class.'/'.$this->class.'Controller.php';
            $model_file = './model/'.$this->class.'/'.$this->class.'.php';
            require './controller/Controller.php';
            require './model/user/user.php';
            if($model_file != './model/user/user.php' ){
                is_file($model_file) ? require $model_file : '';
            }  
            is_file($controller_file) ? require $controller_file: '';
            
        }
    }
    public function setParams(array $routes){
        $url = $_SERVER['REQUEST_URI'];
        $urlParam = explode('/', $url);
        $parseUrl = parse_url($url);
        
        foreach($routes as $route){
          if($url == $route['url']){
              $this->class = $route['class'];
              $this->action = $route['action'];
              break;
          }
          elseif ($url != $route['url'] && $parseUrl['path'] == $route['url']) {
            $this->class = $route['class'];
            $this->action = $route['action'];
            break;
          }
          else{
              
          }
       }
    }
    public function is_mobile(): bool{
      $user_agent = $_SERVER['HTTP_USER_AGENT']; // HTTP ヘッダからユーザー エージェントの文字列を取り出す
      return preg_match('/iphone|ipod|ipad|android/ui', $user_agent) != 0; // 既知の判定用文字列を検索
    }

}
$load = new AutoLoader();
$load -> setParams($routes);
$load -> register();

//アクセス端末のチェック
$device = $load->is_mobile();

//traitの読み込み
$trait_pattern = './trait/'.$load->class.'/*.php';
foreach(glob($trait_pattern) as $file){
    require $file;
}
/*
 バリデーションで登録失敗した時renderされそのセッション削除通常時はerrorとold削除
*/
session_start();
if(isset($_SESSION['render'])){
    unset($_SESSION['render']);
}
else{
    unset($_SESSION['old']);
    unset($_SESSION['errors']);
}
if(isset($_SESSION['current_user'])){
    $current_user = $_SESSION['current_user'];
}
 /*未ログイン時ログイン、新規会員、トップ以外アクセス禁止----(コメントA) */

else if(!isset($_SESSION['current_user'])           
        && $_SERVER['REQUEST_URI'] != '/calendar/top/index' 
        && $_SERVER['REQUEST_URI'] != '/calendar/session/new'
        && $_SERVER['REQUEST_URI'] != '/calendar/user/create'
        && $_SERVER['REQUEST_URI'] != '/calendar/user/new'){
            
    header('location: /calendar/top/index');
}
/* ---(コメントA)範囲end */
        

$controller = $load->class.'Controller';
$action = $load ->action;

if(isset($_SESSION['current_user'])){
  $call = new $controller($_SESSION['current_user']['id']);
}
else{
  $call = new $controller();
}

$call -> $action();




$yield = './view/'.$load->class.'/'.$load ->action.'_view.php';
if(is_file($yield) == false){
    $yield = null;
}
$css_file = '/calendar/css/'.$load->class.'.css';
$js_file = '/calendar/js/'.$load->class.'.js';

foreach($call as $key => $value){
    ${$key} = $value;
}
if(is_readable($yield)){
  require './view/layout.php';

}


//Word
/*
require_once 'vendor/autoload.php';

$rc = new plan();
$rows = $rc->where($current_user['id']);

  // インスタンス生成
  $phpWord = new PhpOffice\PhpWord\PhpWord();

  // Wordのセクションを追加
  $section = $phpWord->createSection();

  // 文字列を追加（オプションで書式設定追加）
  $section->addText(
    $current_user['name'].'作業報告',
    ['name' => 'ＭＳ ゴシック', 'size' => 38, 'color' => '#0000bbb']
  );

  // テーブルのスタイルを指定
  $tableStyle = array(
    'borderColor' => '000000',
    'borderSize' => 6,
    'cellMargin' => 50,
    'size' => 9
  );

  // テーブルを追加
  $table = $section->addTable($tableStyle);
  $table->addRow();


  // 1つのセル内に複数行の文字列を追加
  $multiTable = $table->addCell(2000, ['bgColor' => 'FFFFFF']);
  foreach($rows as $row){
    $multiTable->addText(
      $row->dy,
      ['name' => 'ＭＳ ゴシック', 'size' => 9, 'color' => '000000']
    );
    $multiTable->addText(
      $row->memo,
      ['name' => 'ＭＳ ゴシック', 'size' => 9, 'color' => '000000']
    );
  }
  

  // Word生成
  $objWriter = PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

  // 生成したファイルを保存（今回のファイル名はtest.docxとした）
  $objWriter->save('test.docx');
*/
