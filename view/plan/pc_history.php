
<div class="content">
    <!-- 左エリア-->
    <div class="histroy-year-content">
        <h4 style="text-align:center">作業履歴</h4>
        <p style="text-align:center">【<?= $target_year.'年度履歴' ?>】</p>

        <div class="year-buttons"> 
        <!--前年存在するか -->
          <?php if($before_count >0): ?>
            <a href="#">前年</a>
          <?php endif; ?>

         <!--次年存在するか -->
         <?php if($after_count >0): ?>
            <a href="#">次年</a>
          <?php endif; ?>
        </div>

        <!-- 各月の格納 -->
        <dl class="month-list">
          <dt>月を選択してください。</dt>
          <?php foreach($months as $month) : ?>
            <dd>
              <a 
               href="/calendar/plan/history?user_id=<?= $user->id ?>&date=<?= date('Y-m',strtotime($target_year.'-'.$month)) ?>"
               ><?= $month.'月度履歴' ?></a>
            </dd>
          <?php endforeach; ?>
        </dl>

    </div>

        
    <!-- 右エリア-->
    <div class="history-table">
        <div class="task-info">
          <h4>【<?= Plan::getDateFormat($_GET['date']).'作業履歴' ?>】</h4>
        </div>
        <?php if(count($tasks) >=1) : ?>
          <table>
            <thead>
              <tr>
                <th>日付け</th>
                <th>曜日</th>
                <th style="width:50%;">内容</th>
                <th>状況</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($tasks as $task) : ?>
                <tr>
                  <td><?= $task->month_and_day() ?></td>
                  <td><?= $task->setWeek() ?></td>
                  <td><?= $task->content ?></td>
                  <td><?= $task->status ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <!-- スケジュールがその日に存在しない時 -->
          <div class="empty-task">作業履歴はありません。</div>
        <?php endif; ?>
    </div>

</div>
