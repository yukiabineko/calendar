<h2 style="text-align:center;">【<?=$task->content ?>編集】</h2>
<h3 style="text-align:center;">【<?= $plan->dy ?>】</h3>
<div class="new-task-area">
    <!--エラーメッセージあるか? -->
    <?php if(isset($_SESSION['errors'])) : ?>
      <?php foreach($_SESSION['errors'] as $err) : ?>
        <div class="error"><?= $err ?></div>
      <?php endforeach; ?>
    <?php endif; ?>

  <form action="/task/update" method="POST">
      <div class="form-group">
          <p>【作業内容<span style="color:red;font-size:9px;">(*必須です)</span>】</p>
          <input type="text" name="content" value="<?= isset($_SESSION['old']['content'])? $_SESSION['old']['content'] : $task->content  ?>" />
      </div>

      <div class="form-group">
          <p>【作業日時<span style="color:red;font-size:9px;">(*必須です)</span>】</p>
          <input type="time" name="working_time"  value="<?= isset($_SESSION['old']['working_time'])? $_SESSION['old']['working_time'] : $task->getTimeValue()  ?>" />
      </div>

      <input type="hidden" name="csrf-token" value="<?= $csrf ?>" />
      <input type="hidden" name="plan_id" value="<?= $plan->id ?>" />
      <input type="hidden" name="task_id" value="<?= $task->id ?>" />
      <input type="hidden" name="plan_date" value="<?= $plan->dy ?>" />

      <div class="form-group">
          <input type="submit" value="編集" />
      </div>
  </form>
</div>