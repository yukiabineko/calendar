<?php if($device == false) : ?>
  <!-- pcの表示　-->
  <div class="plan-pc">
    <?php include('./view/plan/pc_index.php'); ?>
  </div>

<?php else : ?>
  <!-- phoneの表示　-->
  <div class="plan-phone">
    <?php include('./view/plan/phone_index.php'); ?>
  </div>

<?php endif; ?>



 <!-- モーダルの表示 -->

 <div id="modal">
     <div class="modal-bg"></div>
     <div id="modal-content">
       <div style="text-align:right;margin-right:1%;">
         <button class="modal-colse" onclick="closeModal()">×</button>
       </div>
       <div class="modal-body">
          <div class="modal-title"><p id="modal-task-day"></p></div>
          <div id="datetime-content"></div> 
          <form action="/calendar/task/change" method="POST">
              <input type="hidden" name='id' id="id-hidden" />
              <input type="hidden" name='status' id="status-hidden" />
              <input type="hidden" name='plan_day' id="date-hidden" />
              <input type="submit" value="作業完了" id="task-status-change"  />
          </form>
         
       </div>
     </div>
   </div>