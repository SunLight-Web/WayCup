<?php 
include('../inc/dbConnect.php');
include('../inc/functions.php');
wcp_session_start();
?>


<?php if (isLoggedIn($mysqli) != true) : ?>
        <span class="error">У вас нет прав для просмотра этой страницы! </span><a href="../index.php">Войти</a>.
    </p>
   <?php die(); ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>

      <?php 
      if (!isset($pagetitle)) { 
         echo "Way Cup Coffee";
      } else { 
         echo "Way Cup Coffee" . " | " . $pagetitle;
      }
      ?>

    </title>
    <script src="../js/jquery.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/bootstrap.min.js"></script> 
    <link href="../css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="../css/style.css" rel="stylesheet" media="screen">
    <link rel="shortcut icon" type="image/x-icon" href="../img/icon.gif" />

  </head>
  <body>
   <div class="container header-crm">
     <div class="row">
      <div class="span4"><a href="../index.php" class="logo-head"></a></div>
      <div class="span4">
        <div class="time">
          <h2>
            <?php
            /* Установка русской локали */
            setlocale(LC_ALL, 'rus');
            date_default_timezone_set('Europe/Moscow');
            echo strftime("%A, %B, %d", time());
            ?>
        </h2>
          <span><?php echo date("H:i");; ?></span>
        </div>
      </div>
      <div class="span4">
        <div class="login-out">
          <?php echo htmlentities($_SESSION['nicename']); ?><br>
          <a href="../inc/logout.php">Выйти</a>
        </div>
      </div>
    </div>
   </div>
  <div class="container main-block">
    <div class="row">