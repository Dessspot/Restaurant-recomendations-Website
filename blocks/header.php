<!DOCTYPE html> 
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title_name; ?></title>
    <link rel="website icon" type="jpg" href="img/RR-logo2-copy.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body style="padding-top: 83px;">

<header class="p-3 bg-dark text-white" style="position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <img class="bi me-2 rounded-circle img-fluid" width="50" height="50" src="img/RR-logo2-copy.jpg" alt="">
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.php" class="nav-link px-2 text-secondary">Главная</a></li>
          <li><a href="features.php" class="nav-link px-2 text-white">Особенности</a></li>
          <li><a href="FAQs.php" class="nav-link px-2 text-white">FAQs</a></li>
          <li><a href="about-us.php" class="nav-link px-2 text-white">О нас</a></li>
          <li><a href="yamap.php" class="nav-link px-2 text-white">Карта</a></li>
          <li><a href="restaurants.php" class="nav-link px-2 text-white">Рестораны</a></li>
        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
        </form>

        <div class="text-end">
          <a href="sign-in.php"> 
            <button type="button" class="btn btn-outline-light me-2">Войти</button>
          </a>
          <a href="sign-up.php">
            <button type="button" class="btn btn-warning">Регистрация</button>
          </a>
        </div>
      </div>
    </div>
  </header>