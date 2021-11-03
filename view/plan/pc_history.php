
<div class="content">
    <!-- 左エリア-->
    <div class="histroy-year-content">
        <h4 style="text-align:center">作業履歴</h4>
        <p style="text-align:center">【<?= $target_year ?>】</p>

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
          <?php foreach($months as $month) : ?>
            <dd><?= $month ?></dd>
          <?php endforeach; ?>
        </dl>

    </div>

        
    <!-- 右エリア-->
    <div class="history-table">
        <div class="task-info">
          
        </div>
    </div>

</div>
