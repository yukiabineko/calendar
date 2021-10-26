<div class="main-visual">
    <img src="../image/main.jpg" alt="メインビジュアル">
    <div class="visual-content">
        <h3>スケジュール管理アプリ</h3>
        <p>日々の予定を管理できるアプリです</p>
       
         <!--認証分岐-->
         <?php if(is_null($current_user)) : ?>
            <p style="margin-top:12px;font-size:10px;color:white; ">機能のご利用はログインしてご利用ください。</p>
            <a href="/calendar/session/new">ログイン</a>
         <?php endif; ?>
    </div>
    <?php if(isset($current_user)) : ?>
      <div class="hamburger">
        <input type="checkbox" id="hm-menu">
        <label for="hm-menu" class="lb"><span></span></label>
        <p style="color:white;margin-top:-2%;">menu</p>
        <div class="drower" id="drower">
            <div class="close">
                <button id="closebutton" onclick="closeDrower()">✖️</button>
            </div>
            <div style="margin-top:20%;text-align:center;font-weight:bold">【メニュー】</div>
        </div>
      </div>
    <?php endif; ?>
</div>
