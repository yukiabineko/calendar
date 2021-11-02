<h2 style="text-align:center;">【会員情報編集】</h2>
<h5 style="text-align:center;">【<?= $user->name ?>】</h5>

<div class="new-user-area">
    <!--エラーメッセージあるか? -->
    <?php if(isset($_SESSION['errors'])) : ?>
      <?php foreach($_SESSION['errors'] as $err) : ?>
        <div class="error"><?= $err ?></div>
      <?php endforeach; ?>
    <?php endif; ?>

  <form action="/calendar/user/update?id=<?= $user->id ?>" method="POST">
      <div class="form-group">
          <p>【会員名<span style="color:red;font-size:9px;">(*必須です)</span>】</p>
          <input type="text" name="name" value="<?= isset($_SESSION['old']['name'])? $_SESSION['old']['name'] : $user->name  ?>" />
      </div>

      <div class="form-group">
          <p>【メールアドレス<span style="color:red;font-size:9px;">(*必須です)</span>】</p>
          <input type="email" name="email"  value="<?= isset($_SESSION['old']['email'])? $_SESSION['old']['email'] : $user->email  ?>" />
      </div>

      <div class="form-group">
          <p>【パスワード<span style="color:red;font-size:9px;">(*必須です)</span>】</p>
          <input type="password" name="password" />
      </div>

      <div class="form-group">
          <p>【パスワード確認<span style="color:red;font-size:9px;">(*必須です)</span>】</p>
          <input type="password" name="password_confirmation" />
      </div>

      <input type="hidden" name="csrf-token" value="<?= $csrf ?>" />

      <div class="form-group">
          <input type="submit" value="編集" />
      </div>
  </form>
</div>