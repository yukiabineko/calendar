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
 
  if(type ==1 && !incomplete){
    alert(getWeek()[1]);
  }
 
  
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
 * 今週の計算
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
