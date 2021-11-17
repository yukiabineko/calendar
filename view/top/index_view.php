<div class="main-visual">
    <img src="../image/main.jpg" alt="メインビジュアル">
    <div class="visual-content">
        <h3>スケジュール管理アプリ</h3>
        <h2>スケジュール</h2>
        <h2>管理アプリ</h2>
        <p>日々の予定を管理できるアプリです</p>
       
         <!--認証分岐-->
         <?php if(is_null($current_user)) : ?>
            <p style="margin-top:12px;font-size:10px;color:white; ">機能のご利用はログインしてご利用ください。</p>
            <a href="/calendar/session/new">ログイン</a>
         <?php endif; ?>
         <!-- モーダル -->
    </div>
    <?php if(isset($current_user)) : ?>
      <div class="hamburger">
        <input type="checkbox" id="hm-menu">
        <label for="hm-menu" class="lb" id="c_lb"><span></span></label>
        <p style="color:white;margin-top:-2%;">menu</p>
        <div class="drower" id="drower">
            <div class="close">
                <button id="closebutton" onclick="closeDrower()">✖️</button>
            </div>
            <div class="drower-header">【メニュー】</div>
            <dl class="drower-dl">
              <dt>スケジュール状況</dt>
              <dd>本日の作業:【<span style="color:red;"><?= count($today_data) ?></span>】件</dd>
              <dd>今週の作業:【<span style="color:red;"><?= count($weeks_data) ?></span>】件</dd>
              <dd>今月の作業:【<span style="color:red;"><?= count($months_data) ?></span>】件</dd>
              <dd style="background:coral;color:mediumblue">本日の未完了の作業:【<span style="color:navajowhite;"><?= count($today_incompletes) ?></span>】件</dd>
              <dd style="background:coral;color:mediumblue">今週の未完了の作業:【<span style="color:navajowhite;"><?= count($weekly_incompletes) ?></span>】件</dd>
              <dd style="background:coral;color:mediumblue">今月の未完了の作業: 【<span style="color:navajowhite;"><?= count($monthly_incomletes) ?></span>】件</dd>
            </dl>
        </div>
      </div>
    <?php endif; ?>
</div>

