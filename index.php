<?php
require 'connect.php';
session_start();
if (isset($_SESSION['username']) && isset($_COOKIE['checkSignin'])) {
  $getUser = $_SESSION['username'];
  $checkSignin = $_COOKIE['checkSignin'];
  if ($checkSignin == 1) {
    echo "
        <script>
          var check = confirm('You want to log out?');
          if (check == 1){
            document.cookie = 'checkSignin=0';
          }
        </script>
      ";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./fontawesome-free-6.3.0-web/fontawsome/css/all.min.css" />
  <link rel="stylesheet" href="./style.css" />
  <link rel="stylesheet" href="./login-register/login.css" />
  <link rel="stylesheet" href="./account/account.css" />
  <link rel="stylesheet" href="./shopping-cart/itemdisplay.css" />
  <link rel="stylesheet" href="./home-page/home.css" />
  <link rel="stylesheet" href="./shoe/shoe.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <title>webbangiay</title>
</head>

<body>
  <script>
    $(document).ready(function() {
      $("#logout").click(function() {
        $.ajax({
          url: './update_session.php',
          type: 'POST',
          success: function(data) {
            LogOut();
            userMenu();
          }
        })
      })
      $("main").hover(function() {
        $("#account").load('session_storage.php');
      })
      $("button[type='submit']").click(function() {
        var val = $(".input").val();
        if (val != "") {
          routerPage("searchPage.php?search=" + val)
        } else {
          swal({
            title: "HÃY NHẬP GIÁ TRỊ",
            icon: "warning",
            closeOnClickOutside: false
          })
        }
      })
    })
  </script>
  <header id="header">
    <!-- Thanh điều hướng -->
    <nav>
      <div class="nav-head" id="nav-head">
        <h1>webbangiay</h1>
        <div class="unsign">
          <span>HOTLINE: 19002152</span>
          <hr />
          <p class="unsigned" onclick="signUp()">SIGN UP</p>
          <hr class="unsigned" />
          <p onclick="signIn()" class="unsigned">SIGN IN</p>
          <div class="userAccount">
            <p class="signed hidden" onclick="userMenu()">
              <span id="account"><?php
                                  echo (isset($_SESSION['username']) && $_SESSION['username'] != NULL) ? $_SESSION['username'] : " ";
                                  ?></span>
              <i class="fa-solid fa-user"></i>
            </p>
            <div class="userMenu hidden">
              <p onclick="Account(); userMenu()">
                My Account <i class="fa-solid fa-user"></i>
              </p>
              <p onclick="userMenu(); Shipping();">
                Order <i class="fa-solid fa-truck-fast"></i>
              </p>
              <p id="fav" onclick="Fav(); userMenu()">
                Favourite <i class="fa-solid fa-heart"></i>
              </p>
              <p id="logout" style="margin-bottom: 20px">
                Log out <i class="fa-solid fa-right-from-bracket"></i>
              </p>
            </div>
          </div>
        </div>
        <div class="navunsign" onclick="signIn()">
          <i class="fa-solid fa-right-to-bracket"></i>
        </div>
      </div>
      <div class="nav-bottom">
        <ul>
          <li style="width: 20%"><a href="#" onclick="Home()">HOME</a></li>
          <li style="width: 80%" class="nav-responsive">
            <div class="brand-selection">
              <a href="#" onclick="BrandItem('Nike')">NIKE</a>
              <a href="#" onclick="BrandItem('Adidas')">ADIDAS</a>
              <a href="#" onclick="BrandItem('Biti\'s')">BITIS</a>
              <a href="#" onclick="BrandItem('Vans')">VANS</a>
              <a href="#" onclick="BrandItem('New Balance')">NEW BALANCE</a>
              <a href="#" onclick="BrandItem('Converse')">CONVERSE</a>
            </div>
            <div class="search">
              <input type="text" class="input" />
              <button type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </div>
            <div class="other">
              <i class="fa-solid fa-cart-shopping" onclick="shoppingCart()"></i>
              <i class="fa-solid fa-heart" onclick="Fav()"></i>
            </div>
            <div class="navmenu-responsive" onclick="OpenNavSlide()">
              <i class="fa-solid fa-bars"></i>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <ul class="nav-slide hidden">
    <li class="nav-access">
      <div class="search">
        <input type="text" class="input" />
        <button type="submit">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </div>
      <div class="other">
        <i class="fa-solid fa-cart-shopping" onclick="shoppingCart()"></i>
        <i class="fa-solid fa-heart" onclick="Fav()"></i>
      </div>
    </li>
    <li class="nav-brand">
      <a href="#" onclick="BrandItem('Nike')">NIKE</a>
      <a href="#" onclick="BrandItem('Adidas')">ADIDAS</a>
      <a href="#" onclick="BrandItem('Biti\'s')">BITIS</a>
      <a href="#" onclick="BrandItem('Vans')">VANS</a>
      <a href="#" onclick="BrandItem('New Balance')">NEW BALANCE</a>
      <a href="#" onclick="BrandItem('Converse')">CONVERSE</a>
    </li>
  </ul>
  <main id="display">
    <iframe src="./home-page/home.php" id="frame" scrolling="no">

    </iframe>
  </main>
  <footer>
    <ul>
      <li>
        <h3>About website</h3>
        <p>HELP</p>
        <p>FEED BACK</p>
        <p>CONTACT</p>
        <div class="socialmedia">
          <i class="fa-brands fa-square-facebook"></i>
          <i class="fa-brands fa-square-instagram"></i>
          <i class="fa-brands fa-square-twitter"></i>
          <i class="fa-brands fa-square-github"></i>
        </div>
      </li>
      <li>
        <h3>About us</h3>
        <p><a style="text-decoration: none; color:white" href="mailto:21520419@gm.uit.edu.vn">21520419@gm.uit.edu.vn</a></p>
        <p><a style="text-decoration: none; color:white" href="mailto:21520390@gm.uit.edu.vn">21520390@gm.uit.edu.vn</a></p>
        <p><a style="text-decoration: none; color:white" href="mailto:21521129@gm.uit.edu.vn">20520724@gm.uit.edu.vn</a></p>
        <p><a style="text-decoration: none; color:white" href="mailto:21522162@gm.uit.edu.vn">20520412@gm.uit.edu.vn</a></p>
      </li>
    </ul>
  </footer>
</body>
<script src="./app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</html>