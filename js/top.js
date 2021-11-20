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

  let today = new Date();
  let todayDate = `${today.getFullYear()}-${ today.getMonth() + 1}-${ today.getDate() }`;
  let sendtype = null;

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
    type = 6;
  }
  alert(sendtype);

  xhr.open('GET', `/calendar/top/show?type=${type}`,true);
  
  let checkbox = document.getElementById('hm-menu');
  checkbox.checked = false;

  let menus = document.getElementById('c_lb');
  menus.style.display = 'none';

  let menuTitle = document.getElementById('menu-title');
  menuTitle.style.display = 'none';

  let modal = document.getElementById('top-modal');
  modal.style.display ='block';
 
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
 * 今週の初日、末日
 */
function getWeek(){
  let today = new Date();
  let year = today.getFullYear();
  let month = today.getMonth() + 1;
  let todayDay = today.getDay();
  let todayDate = today.getDate();
  let weekfirstDate = todayDate - todayDay;
  let weeklastDate = weekfirstDate + 6;
  let first = `${year}-${month}-${weekfirstDate}`;
  let last =  `${year}-${month}-${weeklastDate}`;

  return [first, last];
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