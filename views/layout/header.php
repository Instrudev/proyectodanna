<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="shortcut icon" href="<?= $baseUrl ?>img/imagen 1.jpeg" type="">
  <title>Tienda Online</title>
  <link rel="stylesheet" type="text/css" href="<?= $baseUrl ?>css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" />
  <link href="<?= $baseUrl ?>css/font-awesome.min.css" rel="stylesheet" />
  <link href="<?= $baseUrl ?>css/style.css" rel="stylesheet" />
  <link href="<?= $baseUrl ?>css/responsive.css" rel="stylesheet" />
</head>
<body>
  <div class="hero_area">
    <div class="bg-box">
      <img src="<?= $baseUrl ?>img/pexels-cottonbro-6068975.jpg" alt="Fondos de comida">
    </div>
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="<?= BASE_URL ?>index.php">
            <span>
              <img src="<?= $baseUrl ?>img/escudo-institucion-removebg-preview.png" alt="escudo" class="logo">
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  mx-auto ">
              <li class="nav-item active">
                <a class="nav-link" href="<?= BASE_URL ?>index.php">Inicio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#productos">Productos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#nosotros">Nosotros</a>
              </li>
            </ul>
            <div class="user_option">
              <a class="cart_link" href="<?= BASE_URL ?>index.php?action=cart">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <span class="ml-2">Carrito (<?= (int)$cartCount ?>)</span>
              </a>
              <a class="cart_link" href="<?= BASE_URL ?>admin/index.php">
                <i class="fa fa-lock" aria-hidden="true"></i>
                <span class="ml-2">Admin</span>
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>
