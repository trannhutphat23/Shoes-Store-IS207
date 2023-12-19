<?php
  require "../../connect.php";
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../fontawesome-free-6.3.0-web/fontawsome/css/all.min.css" />
  <link rel="stylesheet" href="./web-item.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
  <style>
    .fa-magnifying-glass:hover {
      cursor: pointer;
    }
  </style>
  <div class="all-item-container">
    <!-- title -->
    <h1>ALL ITEMS</h1>
    <!-- brand button -->
    <div class="brand-container">
      <img src="../../images/logo/Adidas_logo.png" alt="logo" id="NIKE" onclick="handleBrand(this)" />
      <img src="../../images/logo/Bitis_logo.png" alt="logo" id="ADIDAS" onclick="handleBrand(this)" />
      <img src="../../images/logo/Converse_logo.png" alt="logo" id="NEW BALANCE" onclick="handleBrand(this)" />
      <img src="../../images/logo/Newbalance_logo.png" alt="logo" id="BITIS" onclick="handleBrand(this)" />
      <img src="../../images/logo/nikelogo.png" alt="logo" id="CONVERSE" onclick="handleBrand(this)" />
      <img src="../../images/logo/Vans_logo.png" alt="logo" id="VANS" onclick="handleBrand(this)" />
    </div>

    <!-- advance button -->
    <div class="advance">
      <div class="search">
        <input type="text" placeholder="Tìm kiếm..." />
        <i class="fa-solid fa-magnifying-glass"></i>
      </div>
      <div class="sort">
        <div class="sort-button" onclick="showSortOption(this)">
          <p class="button-text">Sắp xếp</p>
          <i class="fa-solid fa-sort"></i>
        </div>
        <ul class="sort-option">
          <li onclick="getOption(this)">
            <i class="fa-solid fa-arrow-down-a-z"></i>
            <p>A - Z</p>
          </li>
          <li onclick="getOption(this)">
            <i class="fa-solid fa-arrow-down-z-a"></i>
            <p>Z -A</p>
          </li>
          <li onclick="getOption(this)">
            <i class="fa-solid fa-arrow-down-wide-short"></i>
            <p>Giá giảm dần</p>
          </li>
          <li onclick="getOption(this)">
            <i class="fa-solid fa-arrow-up-wide-short"></i>
            <p>Giá tăng dần</p>
          </li>
        </ul>
      </div>
    </div>

    <!-- item container -->
    <div class="item-container">
      <?php
      if (isset($_GET['search'])) {
        $searchVal = $_GET['search'];
        $query = mysqli_query($conn, "SELECT * FROM giay WHERE MAGIAY LIKE '%$searchVal%'");
      }else{
        $query = mysqli_query($conn, "SELECT * FROM giay");
      }
      while ($rowData = mysqli_fetch_assoc($query)) {
        $arrImg = explode("|", $rowData['HINHANH']);
      ?>
        <div style="height: 290px" class="item" onclick="GoToItemDetail('<?php echo $conn->real_escape_string($rowData['MAGIAY']) ?>')">
          <img style="width: 214px" src="../../images/<?php echo $arrImg[0] ?>" alt="shoe" />
          <p style="width: 214px; height: 50px" class="shoe-title"><?php echo $rowData['MAGIAY'] ?></p>
          <p class="shoe-price"><?php echo number_format($rowData['GIA']) ?> VNĐ</p>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</body>
<script src="web-item.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</html>