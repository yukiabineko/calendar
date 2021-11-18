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
function openTopModal(){
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