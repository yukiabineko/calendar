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

  //作業
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
        createTable(json, sendtype);
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
function createTable(Objs, type){
  
  //日付けthが存在する場合削除してリセット
  let th =document.getElementById('create-th');
  th? document.getElementById('top-modal-thead').removeChild(th) : '';

  if( type == 2 || type == 3 || type == 5 || type == 6){
    let theadTr = document.getElementById('top-modal-thead');
    let th = document.createElement('th');
    th.id = 'create-th';
    th.textContent = '日付';
    theadTr.prepend(th);
  }
  
  let tbody = document.getElementById('top-table-tbody');
  tbody.innerHTML = '';
  Objs.forEach(data => {
    let tr = document.createElement('tr');
    if( type == 2 || type == 3 || type == 5 || type == 6){
      let day_td = document.createElement('td');
      day_td.textContent = getDateFormat(data['working_time']);
      tr.appendChild(day_td);
    }
    let time_td = document.createElement('td');
    let week_td = document.createElement('td');
    let content_td = document.createElement('td');

    
    time_td.textContent =  getWeek( data['working_time'] );
    week_td.textContent = parseDateTime( data['working_time'] );
    content_td.textContent = data['content'];
    
    tr.appendChild(time_td);
    tr.appendChild(week_td);
    tr.appendChild(content_td);
    tbody.appendChild(tr);

  });
  
}
/**
 * 
 */
function getDateFormat(params){
  let date = new Date(params.replace(/-/g,"/"));
  let month = toDoubleDigits(date.getMonth() + 1 );
  let day = toDoubleDigits(date.getDate());
  return `${month}/${day}`;
}

/**
 * 時間の設定
 */
function parseDateTime(params){
  let date = new Date(params.replace(/-/g,"/"));
  let hour = toDoubleDigits( date.getHours() );
  let min = toDoubleDigits( date.getMinutes() );
  return `${hour}時${min}分`;
}
/**
 * 
 * 曜日の設定
 * 
 */
function getWeek(params){
  const weeks = ['日', '月', '火', '水', '木', '金', '土'];
  let date = new Date(params.replace(/-/g,"/"));
  let num = date.getDay();
  return weeks[parseInt(num)];
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