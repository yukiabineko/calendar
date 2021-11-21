window.addEventListener('scroll',function(){
  let closebutton = this.document.getElementById('closebutton');

  if(window.scrollY>150){
     closebutton.style.display ="inline";
  }
  else if(window.screenY <150){
    closebutton.style.display ="none";
  }
});
function closeDrower(){
    let checkbox = document.getElementById('hm-menu');
    checkbox.checked = false;
}
/**
 * モーダルを開く
 */
function openTopModal(user_id, type, incomplete){
  
  const status = [
    "【本日の作業一覧】", "【今週の作業一覧】", "【今月の作業一覧】", "【本日の未完了作業一覧】", "【今週の未完了作業一覧】", "【今月の未完了作業一覧】"
  ];
  let keys = null;

  let xhr = new XMLHttpRequest();
  
  //{typeは　当日全て1, 週全て2, 月全て3, 当日未完了4, 週未完了5, 月未完了6}

  //当日全ての作業
  if(type == 1 && !incomplete){
    sendtype = 1;
  }
  else if(type == 2 && !incomplete){
    sendtype = 2;
  }
  else if(type == 3 && !incomplete){
    sendtype = 3;
  }
  else if(type == 1 && incomplete){
    sendtype = 4;
  }
  else if(type == 2 && incomplete){
    sendtype = 5;
  }
  else if(type == 3 && incomplete){
    sendtype = 6;
  }
  
  xhr.open('GET', `/calendar/top/show?type=${sendtype}`,true);
  xhr.onreadystatechange = function(){
    if(xhr.readyState == 4 && xhr.status == 200){
      let json = JSON.parse( xhr.responseText );
      keys = Object.keys(json);
      console.log(keys); //要素数
      
      let checkbox = document.getElementById('hm-menu');
      checkbox.checked = false;

      let menus = document.getElementById('c_lb');
      menus.style.display = 'none';

      let menuTitle = document.getElementById('menu-title');
      menuTitle.style.display = 'none';

      let modal = document.getElementById('top-modal');
      modal.style.display ='block';
      //モーダル内の要素
      document.getElementById('top-modal-title').textContent = status[sendtype -1];
      //要素数によりテーブルかdivか？
      if(keys.length >0){
        console.log(json);
      }
      else{
        console.log('no');
      }


    }
  }
  xhr.send();
}
/**
 * モーダルを閉じる
 */
function closeTopModal(){
  let menus = document.getElementById('c_lb');
  menus.style.display = 'flex';

  let menuTitle = document.getElementById('menu-title');
  menuTitle.style.display = 'block';

  let modal = document.getElementById('top-modal');
  modal.style.display ='none';
}

/**
 * テーブルの作成
 */
function createTable(Objs){
  let html = '';
  
  
}


/**
 * 今月の初日、末日
 */
function getThisMonth(){
  let today = new Date();
  let year = today.getFullYear();
  let month = today.getMonth() + 1;
  let first_date = new Date(year, today.getMonth(), 1);
  let last_date = new Date(year,month, 0);

  let first = `${first_date.getFullYear()}-${first_date.getMonth() + 1 }-${ toDoubleDigits(first_date.getDate())}`;
  let last = `${last_date.getFullYear()}-${last_date.getMonth() + 1 }-${ toDoubleDigits(last_date.getDate())}`;
  return [ first, last];
}
/**
 * 日付けの０埋め
 */
function toDoubleDigits(num){
  num += "";
  if (num.length === 1) {
    num = "0" + num;
  }
 return num;    
}