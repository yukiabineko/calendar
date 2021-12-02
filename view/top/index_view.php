<div class="main-visual" id="main-visual">
    <img src="../image/main.jpg" alt="メインビジュアル" class="main-visual-img" id="img1">
    <img src="../image/coffice.jpg" alt="メインビジュアル" class="main-visual-img" id="img2">
    <img src="../image/memo.jpg" alt="メインビジュアル" class="main-visual-img" id="img3">

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
    </div>
    <!-- モーダル -->
    <div id="top-modal">
      <div class="bg"></div>
      <div class="top-modal-content" id="top-content">
        <div class="top-modal-close-button">
          <button onclick="closeTopModal()">閉じる</button>
        </div>

        <div class="top-modal-heder">
          <h3 id="top-modal-title">【本日の作業一覧】</h3>
        </div>

        <div class="content-body">
           <!-- レコードある場合の表示 -->
           <table class="top-modal-table" id="top-modal-table">
            <thead>
              <tr id="top-modal-thead">
                <th>曜日</th>
                <th>作業予定時間</th>
                <th>作業内容</th>
              </tr>
            </thead>
            <tbody id="top-table-tbody"></tbody>
          </table>

           <!-- レコードのない場合の表示 -->
           <div id="top-modal-no-record">
             該当データがありません。
           </div>
         
        </div>
      </div>
    </div>
   <!--/モーダル -->

    <?php if(isset($current_user)) : ?>
      <div class="hamburger">
        <input type="checkbox" id="hm-menu">
        <label for="hm-menu" class="lb" id="c_lb"><span></span></label>
        <p style="color:white;margin-top:-2%;" id="menu-title">menu</p>
        <div class="drower" id="drower">
            <div class="close">
                <button id="closebutton" onclick="closeDrower()">✖️</button>
            </div>
            <div class="drower-header">【メニュー】</div>
            <dl class="drower-dl">
              <dt>スケジュール状況</dt>
              <dd>
                <button onclick="openTopModal(<?= $current_user['id'] ?>, 1, false)">
                  本日の作業:【<span style="color:red;"><?= count($today_data) ?></span>】件
                </button>
              </dd>

              <dd>
                <button onclick="openTopModal(<?= $current_user['id'] ?>, 2, false)">
                  今週の作業:【<span style="color:red;"><?= count($weeks_data) ?></span>】件
                </button>
              </dd>

              <dd>
                <button onclick="openTopModal(<?= $current_user['id'] ?>, 3, false)">
                  今月の作業:【<span style="color:red;"><?= count($months_data) ?></span>】件
                </button>
              </dd>
              <dd style="background:coral;color:mediumblue">
                <button onclick="openTopModal(<?= $current_user['id'] ?>, 1, true)">
                  本日の未完了の作業:【<span style="color:navajowhite;"><?= count($today_incompletes) ?></span>】件
                </button>
              </dd>
              <dd style="background:coral;color:mediumblue">
                <button onclick="openTopModal(<?= $current_user['id'] ?>, 2, true)">今週の未完了の作業:【<span style="color:navajowhite;"><?= count($weekly_incompletes) ?></span>】件
                </button>
              </dd>
              <dd style="background:coral;color:mediumblue">
                <button onclick="openTopModal(<?= $current_user['id'] ?>, 3, true)">
                   今月の未完了の作業: 【<span style="color:navajowhite;"><?= count($monthly_incomletes) ?></span>】件
                </button>
              </dd>
            </dl>
        </div>
      </div>
    <?php endif; ?>
     
</div>



