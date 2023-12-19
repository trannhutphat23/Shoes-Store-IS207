<?php
require "../../connect.php";

if (isset($_GET['id'])) {
  $shoeName = $_GET['id'];
  $shoeNameEscape = $conn->real_escape_string($shoeName);
  $query = mysqli_query($conn, "SELECT * FROM giay,chitiet_giay WHERE giay.MAGIAY = chitiet_giay.MAGIAY AND giay.MAGIAY = '$shoeNameEscape'");
  $query = mysqli_fetch_row($query);
  $getImg = $query[3];
  $getPrice = $query[4];
  $arrImg = explode("|", $getImg);
  $color = $query[8];
  $style = $query[10];
  $getSize = $query[9];
  $arrSize = explode(",", $getSize);
}
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
  <title>Document</title>
</head>

<body>
  <div class="item-view-container">
    <!-- image -->
    <div class="item-side-image">
      <aside>
        <?php
        foreach ($arrImg as $url) {
          $url = ltrim($url);
          echo "<img src='../../images/$url' alt='shoe' class='asideImg' onclick='choseImg(this)'>";
        }
        ?>
      </aside>
      <img src="../../images/<?php echo $arrImg[0] ?>" alt="mainImg" class="main-img" id="imgDisplay" />
    </div>
    <!-- detail -->
    <div class="item-detail-container">
      <p>Thông tin của sản phẩm</p>
      <div class="input-box">
        <p>
          Tên sản phẩm:
          <strong onclick="Edit(this)">Chỉnh sửa</strong>
        </p>
        <input type="text" placeholder="NIKE DUNK RETRO LOW" required disabled />
      </div>
      <div class="input-box">
        <p>
          Màu:
          <strong onclick="Edit(this)">Chỉnh sửa</strong>
        </p>
        <input type="text" placeholder="White" required disabled />
      </div>
      <div class="input-box">
        <p>
          Loại:
          <strong onclick="Edit(this)">Chỉnh sửa</strong>
        </p>
        <input type="text" placeholder="Low" required disabled />
      </div>
      <div class="input-box">
        <p>
          Giá:
          <strong onclick="Edit(this)">Chỉnh sửa</strong>
        </p>
        <input type="text" placeholder="3,000,000" required disabled />
      </div>
      <div class="input-box">
        <p>
          Hãng:
          <strong onclick="Edit(this)">Chỉnh sửa</strong>
        </p>
        <select disabled>
          <option>NIKE</option>
          <option>ADIDAS</option>
          <option>BITIS</option>
          <option>VANS</option>
          <option>CONVERSE</option>
          <option>NEW BALANCE</option>
        </select>
      </div>
      <div class="input-box">
        <p>
          Thông tin liên quan:
          <strong onclick="Edit(this)">Chỉnh sửa</strong>
        </p>
        <textarea placeholder="Giày siêu lit cháy lửa" required disabled></textarea>
      </div>
      <div class="button-container">
        <button class="save" onclick="Save()">
          <p>LƯU THAY ĐỔI</p>
        </button>
        <button class="delete">
          <p>XOÁ</p>
        </button>
      </div>
    </div>
  </div>
</body>
<script src="./web-item.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</html>