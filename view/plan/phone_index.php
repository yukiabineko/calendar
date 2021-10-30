
<div class="content">
    <!-- 上部カレンダー　-->
    <div class="calender-content">
    <h4 style="text-align:center;">【スケージュール管理】</h4>
    <p style="text-align:center;">日付けを選択してください。</p>

    <!-- 月の切り替え -->
    <div class="month-link">
        <a href="/calendar/plan/index?date=<?php echo date('Y-m',strtotime('-1 month'.$firstPlan)); ?>">前月</a>
        <p><?= Plan::getDateFormat($firstPlan); ?></p>
        <a href="#">次月</a>
    </div>

     <!--カレンダー　-->
     <table class="cal">
      <thead>
        <?php echo $weeks ;?>        <!--週の表示 -->
      </thead>
      <tbody>
        <?php echo $prevData; ?>     <!--前月の表示 -->
        <?php echo $dates; ?>        <!--今月の表示 -->
        <?php echo $nextData; ?>     <!--次月の表示 -->
      </tbody>
     </table>

      <!-- 下エリア -->
      <div class="table-area">
        <div class="task-info">
            <h4 style="text-align:center;margin-bottom:10%;">【<?= $current_plan->dy.'作業一覧' ?>】</h4>

            <!--日付により新規作成ボタンの表示、非表示 -->
          <div class="task-buttons">
            <?php if( $current_plan->before_today() ): ?>
                <a href="/calendar/task/new?plan_day=<?php echo isset($_GET['plan_day'])?$_GET['plan_day'] :date('Y-m-d'); ?>" class="new_task_button">新規作業登録</a>
            <?php endif; ?>

            <!--関連日にタスクレコードが1以上存在するなら削除ボタン表示 -->
            <?php if($current_plan->count() >= 1) : ?>
                <button id="delete-task-button" onclick="deleteTask()">削除</button>
                <form action="#" method="POST" id="delete-task-form">
                <input type="hidden" name="csrf-token" value="<?= $csrf ?>" />  
                </form>
            <?php endif; ?>
        </div>
    </div>

    <?php if(count($tasks)>=1) : ?>
         <!-- スケジュールがその日に存在する時 -->
           <table class="task-table">
               <thead>
                   <tr>
                       <th>作業内容</th>
                       <th>開始時間</th>
                       <th>状況</th>
                       <th colspan="2">削除</th>
                   </tr>
               </thead>
               <tbody>
                   <?php foreach($tasks as $task): ?>
                    <tr>
                        <td><?= $task->content ?></td>
                        <td><?= $task->timeFormat() ?></td>
                        <td>
                            <?php if($task->getStatausLabel() == '未着手' || $task->getStatausLabel() == '完了済' ) : ?>
                              <button 
                                 style="background:<?php echo $task->getStatausStyle(); ?>;color:#F5FFFA;padding:5px;border:none;"
                                 onMouseOver="this.style.background='#D2B48C'"
                                 onMouseOut="this.style.background='<?=  $task->getStatausStyle() ?>'"
                                 onClick="openModal(<?php echo  $task->id ?>)"
                              >
                               <?= $task->getStatausLabel() ?>
                            </button>

                            <?php else : ?>
                              <span style="background:<?php echo $task->getStatausStyle(); ?>;color:#F5FFFA;padding:5px;"><?= $task->getStatausLabel() ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <!--日付により編集ボタンの表示、非表示 -->
                                <?php if( $current_plan->before_today() ): ?>
                                    <a href="/calendar/task/edit?id=<?= $task->id ?>">編集</a>
                                <?php endif; ?>
                            
                        </td>
                        <td>
                            <input type="checkbox">
                        </td>
                    </tr>
                   <?php endforeach; ?>
               </tbody>
           </table>
         
        <?php else: ?>
          <!-- スケジュールがその日に存在しない時 -->
          <div class="empty-task">現在この日付けに予定はありません。</div>
        <?php endif; ?>

    
</div>
