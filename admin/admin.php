<?php
  require "../connect.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../fontawesome-free-6.3.0-web/fontawsome/css/all.min.css" />
  <link rel="stylesheet" href="./admin.css" />
  <title>Document</title>
</head>

<body>
  <!-- navbar -->
  <div class="navbar">
    <!-- navbar head -->
    <div class="navbar-head">
      <h1>webbangiay</h1>
    </div>
    <ul class="nav">
      <!-- Dashboard -->
      <li>
        <div class="tag-title" onclick="ShowDropdown(this)">
          <i class="fa-solid fa-chart-line"></i>
          <p>Dashboard</p>
          <i class="fa-solid fa-caret-down"></i>
        </div>
        <ol class="hidden">
          <li>
            <i class="fa-solid fa-plus"></i>
            <p>Doanh thu</p>
          </li>
          <li>
            <i class="fa-solid fa-plus"></i>
            <p>Thống kê</p>
          </li>
        </ol>
      </li>

      <!-- Sản phẩm -->
      <li>
        <div class="tag-title" onclick="ShowDropdown(this)">
          <i class="fa-solid fa-shop"></i>
          <p>Sản phẩm</p>
          <i class="fa-solid fa-caret-down"></i>
        </div>
        <ol class="hidden">
          <!-- Tất cả -->
          <li onclick="routerPage('./web item/all-item.php')">
            <i class="fa-solid fa-plus"></i>
            <p>Tất cả</p>
          </li>

          <!-- Thêm mới -->
          <li onclick="routerPage('./web item/add-item.php')">
            <i class="fa-solid fa-plus"></i>
            <p>Thêm mới</p>
          </li>
        </ol>
      </li>

      <!-- Đơn hàng -->
      <li>
        <div class="tag-title" onclick="ShowDropdown(this)">
          <i class="fa-solid fa-clipboard-list"></i>
          <p>Đơn hàng</p>
          <i class="fa-solid fa-caret-down"></i>
        </div>
        <ol class="hidden">
          <li onclick="routerPage('./order/unprocess.html')">
            <i class="fa-solid fa-plus"></i>
            <p>Chưa xử lí</p>
          </li>
          <li onclick="routerPage('./order/processed.html')">
            <i class="fa-solid fa-plus"></i>
            <p>Đã xử lí</p>
          </li>
          <li onclick="routerPage('./order/payed.html')">
            <i class="fa-solid fa-plus"></i>
            <p>Đã thanh toán</p>
          </li>
        </ol>
      </li>

      <!-- Khách hàng -->
      <li onclick="routerPage('./customer/customer.html')">
        <div class="tag-title" onclick="ShowDropdown(this)">
          <i class="fa-solid fa-user"></i>
          <p>Khách hàng</p>
          <i class="fa-solid fa-caret-down" style="visibility: hidden"></i>
        </div>
        <ol class="hidden"></ol>
      </li>
    </ul>
  </div>

  <!-- main -->
  <main>
    <iframe src="./customer/customer.html" id="frame"> </iframe>
  </main>
</body>
<script src="./admin.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</html>