let imageNo = 1;

window.addEventListener('load', function(){
   setInterval(() => {
      changeImage();
   }, 3000);
});

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
      if(json.length > 0){
        createTable(json, sendtype);
      }
      else{
        NoRecordCase();
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
  document.getElementById('top-modal-table').style.display = 'table';
  document.getElementById('top-modal-no-record').style.display = 'none';
  
  //日付けthが存在する場合削除してリセット
  let th =document.getElementById('create-th');
  th? document.getElementById('top-modal-thead').removeChild(th) : '';
  let colorflag = false;


  if( type == 2 || type == 3 || type == 5 || type == 6){
    let theadTr = document.getElementById('top-modal-thead');
    let th = document.createElement('th');
    th.id = 'create-th';
    th.textContent = '日付';
    theadTr.prepend(th);
  }
  
  let tbody = document.getElementById('top-table-tbody');
  tbody.innerHTML = '';
  Objs.forEach((data,i) => {
    let tr = document.createElement('tr');
    //日付けの切り替わりで色変え
    tr.style.background = colorflag? '#f0f0f0' : '#fff';
    tr.id = `tr-${data['id']}`;
    //色変えのフラグの変更処理
    if(Objs[i + 1]){
      //console.log(Objs[i + 1]);
      getDateFormat( Objs[i]['working_time'] ) != getDateFormat( Objs[i+1]['working_time'] )? colorflag =!colorflag : '';
    }
    
    

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
 * レコードがない場合のモーダル表示
 */
function NoRecordCase(){
  document.getElementById('top-modal-no-record').style.display = 'block';
  document.getElementById('top-modal-table').style.display = 'none';
}
/**
 * ハイフンと/切り替え
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
/**
 * トップページの画像の切り替え
 */
function changeImage(){
  let firstImage = document.getElementById('img1');
  let secondImage = document.getElementById('img2');
  let lastImage = document.getElementById('img3');

  switch (imageNo) {
    case 1:
      firstImage.style.display = 'block';
      secondImage.style.display = 'none';
      lastImage.style.display = 'none';
      break;
    case 2:
      firstImage.style.display = 'none';
      secondImage.style.display = 'block';
      lastImage.style.display = 'none';
      break;
    case 3:
      firstImage.style.display = 'none';
      secondImage.style.display = 'none';
      lastImage.style.display = 'block';
      break;
  
    default:
      break;
  }


  imageNo < 3 ? imageNo ++ : imageNo = 1;
  
}