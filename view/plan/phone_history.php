<div class="content">
    <!-- 上エリア-->
    <div class="histroy-year-content">
        <h4 style="text-align:center">作業履歴</h4>
        <p style="text-align:center">【<?= $target_year.'年度履歴' ?>】</p>

        <div class="year-buttons"> 
        <!--前年存在するか -->
          <?php if($before_count >0): ?>
            <a href="/calendar/plan/history?user_id=<?= $user->id ?>&year=<?= $prev_year ?>&date=<?= date('Y-m',strtotime($prev_year.'-01')) ?>"
            >前年</a>
          <?php endif; ?>

         <!--次年存在するか -->
         <?php if($after_count >0): ?>
            <a href="/calendar/plan/history?user_id=<?= $user->id ?>&year=<?= $next_year ?>&date=<?= date('Y-m',strtotime($next_year.'-01')) ?>"
              >次年</a>
          <?php endif; ?>
        </div>

        <!-- 各月の格納 -->
        <dl class="month-list">
          <dt>月を選択してください。</dt>
          <?php foreach($months as $month) : ?>
            <dd>
              <a 
                href="/calendar/plan/tasks?user_id=<?= $user->id ?>&date=<?= date('Y-m',strtotime($target_year.'-'.$month)) ?>"
                ><?= $month.'月度履歴' ?></a>
            </dd>
          <?php endforeach; ?>
        </dl>
    </div>


</div>
