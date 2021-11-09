<div class="content">
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
                <td style="color:<?= $task->getStatausStyle() ?>"><?= $task->getStatausLabel() ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    <?php else: ?>
        <!-- スケジュールがその日に存在しない時 -->
        <div class="empty-task">作業履歴はありません。</div>
    <?php endif; ?>
  </div>

  <div class="history-back">
      <a href="/calendar/plan/history?user_id=<?= $_GET['user_id'] ?>&date=<?= $_GET['date'] ?>">戻る</a>
  </div>
</div>