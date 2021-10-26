window.onload = function(){
    
}
function openModal(id){
    let modal = document.getElementById('modal');
    modal.style.display = 'block';
    let xhr = new XMLHttpRequest();
    xhr.open('GET', `/calendar/task/show?task_id=${id}` ,true );
    xhr.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200) {
         let responseData = JSON.parse(xhr.responseText);

         //日付けのコンテンツ
         let taskDayContent = document.getElementById('modal-task-day');
         let thisday = setDay(responseData['working_time'])
         taskDayContent.textContent = `進捗更新 ${thisday}`;

         if(responseData['status'] == '2'){
             let submitButton = document.getElementById('task-status-change')
             submitButton.style.background = "red";
             submitButton.value = "未着手に変更";
             
         }

         //時間のコンテンツ
         let taskTimeContent = document.getElementById('datetime-content');
         taskTimeContent.textContent = `【作業時間:${setTime(responseData['working_time'])}】`;

         //input hidden でid格納
         document.getElementById('id-hidden').value = responseData['id'];

         //input hidden でstatus格納
         document.getElementById('status-hidden').value = responseData['status'];

         //input hidden でdate格納
         document.getElementById('date-hidden').value = returnDay(responseData['working_time']);


      }  
    }
    xhr.send();


}
function closeModal(){
    let modal = document.getElementById('modal');
    modal.style.display = 'none';
}
function setDay(param){
  let dateTime = new Date(param);
  let year = dateTime.getFullYear();
  let month = dateTime.getMonth() + 1;
  let day = dateTime.getDate();
  return `${year}年${month}月${day}日`;
}
function setTime(param){
    let dateTime = new Date(param);
    let hour = dateTime.getHours();
    let min = dateTime.getMinutes();
    return `${hour}時${min}分`;
}
//post処理後のパラメーターで使用
function returnDay(param){
    let dateTime = new Date(param);
    let year = dateTime.getFullYear();
    let month = dateTime.getMonth() + 1; 
    let day = dateTime.getDate();
    return `${year}-${month}-${toDoubleDigits(day)}`; 
}
//日付けを0埋めする
function toDoubleDigits(num){
    num+='';
    if (num.length === 1) {
        num = "0" + num;
    }
     return num;   
}