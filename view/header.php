<?php
  $path = "";
  $indexPath = $path . "/index.php"; 

  // if no one logged in, show log in, register
  if (! isset($_SESSION["id"])) {
    $links = '
    <li class="nav-item">
      <a class="nav-link" href="' . $indexPath . '/login" aria-disabled="true">Anmelden</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="' . $indexPath . '/register" aria-disabled="true">Registrieren</a>
    </li>
    ';
  } 
  // if someone logged in, show my memos, account, log out and 
  else {
    if (! $_SESSION["admin"]) {
      $adminDashboard = "";
    } else {
      $adminDashboard = '
      <li class="nav-item">
        <a class="nav-link" href="' . $indexPath . '/admindashboard" aria-disabled="true">Admin-Bereich</a>
      </li>
      ';
    }

    $links = '
    <li class="nav-item">
      <a class="nav-link" href="' . $indexPath . '/openmemos" aria-disabled="true">Öffentliche Notizen</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="' . $indexPath . '/mymemos" aria-disabled="true">Meine Notizen</a>
    </li>
    ' . $adminDashboard . '
    <li class="nav-item">
      <a class="nav-link" href="' . $indexPath . '/account" aria-disabled="true">Konto</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="' . $indexPath . '/logout" aria-disabled="true">Abmelden</a>
    </li>
    ';
  }
?>

<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo $path; ?>/view/../favicon.ico">
    <!-- css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="<?php echo $path; ?>/css/styles.css" rel="stylesheet"><!-- fontawesome -->
    <script src="https://kit.fontawesome.com/4d20ff7212.js" crossorigin="anonymous"></script>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
    <title>Smiling Memo</title>
  </head>
  <body class="min-vh-100 d-flex flex-column justify-content-between">
    <div>
      <header>
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
          <div class="container">
            <a class="navbar-brand" href="<?php echo $path; ?>/index.php">
              <img src="<?php echo $path; ?>/img/sun.png" alt="Icon made by Pixel perfect from www.flaticon.com" width="50px" height="50px">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                  <?php echo $links; ?>
              </ul>
            </div>
          </div>
        </nav>
      </header>