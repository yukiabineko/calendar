<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $toptitle ?></title>
    <link rel="stylesheet" href="/calendar/css/share.css">
    <link rel="stylesheet" href="/calendar/css/share-phone.css">
    <link rel="stylesheet" href="<?php echo $css_file; ?>">
    <script src="<?php echo isset($js_file)? $js_file : '' ?>"></script>
</head>
<body>
    <!-- pcのヘッダー -->
    <div class="pc-header">
      <?php include('./view/share/header.php'); ?>
    </div>

    <!-- phoneのヘッダー -->
    <div class="phone-header">
      <?php include('./view/share/header-phone.php'); ?>
    </div>
   
    <?php if(isset($_SESSION['flash'])) : ?>
      <div><?= $_SESSION['flash']['success'] ?></div>
    <?php unset($_SESSION['flash']); endif; ?>
   <main>
     <?php include($yield); ?>
   </main>
  
   <!-- pcのフッター -->
   <div class="pc-footer">
      <?php include('./view/share/footer.php'); ?>
    </div>

    <!-- phoneのフッター -->
    <div class="phone-footer">
      <?php include('./view/share/footer-phone.php'); ?>
    </div>

</body>
</html>
