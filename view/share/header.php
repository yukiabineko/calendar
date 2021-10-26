<header>
    <div class="icon-area">
        <div class="icon-left">
            <img src="../image/cal.png" alt="カレンダー">
            <p>schedule App</p>
        </div> 
         <!--認証分岐-->
         <?php if(!is_null($current_user)) : ?>
            <div style="font-size:20px; color:blue;"><?= '👤こんにちは'.$current_user['name'].'さん' ?></div>
         <?php endif; ?>

        <div class="icon-right">
            <img src="../image/mail.png" alt="メール">
            <p>問い合わせ</p>
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="/calendar/top/index">HOME</a></li>
            <li>
              <a href="/calendar/plan/index" style="<?php echo is_null($current_user)? 'pointer-events:none;background:#4d4c4c;color:gray;border:1px dotted white;' : ''   ?>">
                スケジュール
              </a>
           </li>
           <li>
              <a href="#" style="<?php echo is_null($current_user)? 'pointer-events:none;background:#4d4c4c;color:gray;border:1px dotted white;' : ''   ?>">
                  履歴
              </a>
           </li>
            <li class="menu">
               <!--認証分岐-->

              <?php if(is_null($current_user)) : ?>
                <a href="/calendar/session/new">ログイン</a>
              <?php else : ?>
                <a href="#">設定</a>
                <dl class="sub-menu">
                    <dd>会員情報編集</dd>
                    <dd><a href="/calendar/session/destroy" style="background:none;border:none;padding:0;">ログアウト</a></dd>
                </dl>
              <?php endif; ?>
              
            </li>
        </ul>
    </nav>
</header>