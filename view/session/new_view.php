<h2 style="text-align:center;">【ログイン】</h2>

<div class="new-user-area">
    <!--エラーメッセージあるか? -->
    <?php if(isset($_SESSION['errors'])) : ?>
      <?php foreach($_SESSION['errors'] as $err) : ?>
        <div class="error"><?= $err ?></div>
      <?php endforeach; ?>
    <?php endif; ?>

  <form action="/calendar/session/create" method="POST">
      
      <div class="form-group">
          <p>【メールアドレス<span style="color:red;font-size:9px;">(*必須です)</span>】</p>
          <input type="email" name="email"  value="<?= isset($_SESSION['old']['email'])? $_SESSION['old']['email'] : ''  ?>" />
      </div>

      <div class="form-group">
          <p>【パスワード<span style="color:red;font-size:9px;">(*必須です)</span>】</p>
          <input type="password" name="password" />
      </div>

      <input type="hidden" name="csrf-token" value="<?= $csrf ?>" />

      <div class="form-group">
          <input type="submit" value="ログイン" />
      </div>

      <div class="form-group">
          <a href="/calendar/user/new" style="display:block; text-align:center;margin-top:12px;">新規登録はこちら</a>
      </div>
      
  </form>
</div>
