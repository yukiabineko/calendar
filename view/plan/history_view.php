<?php if($device == false) : ?>
  <!-- pcの表示　-->
  <div class="plan-pc">
    <?php include('./view/plan/pc_history.php'); ?>
  </div>

<?php else : ?>
  <!-- phoneの表示　-->
  <div class="plan-phone">
    <?php include('./view/plan/phone_history.php'); ?>
  </div>

<?php endif; ?>

