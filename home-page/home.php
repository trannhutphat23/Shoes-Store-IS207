<?php
    require "../connect.php";
    session_start();
    if (isset($_SESSION['username'])){
        $user = $_SESSION['username'];
    }
    if (isset($_COOKIE['checkSignin'])){
        $check = $_COOKIE['checkSignin'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="../fontawesome-free-6.3.0-web/fontawsome/css/all.min.css"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body> 
    <script>
        $(document).ready(function(){
            $("h4.SeeALL").click(function(){
                var brandName = $(this).attr("id");
                location.href = "brandItem.php?brandName=" + brandName;
                window.parent.document.getElementById('header').scrollIntoView(true);
            })
        })
    </script>
  <main>
      <div class="banner">
          <img src="../images/banner.jpg" alt="banner">
      </div>          
      <div class="logo-brand">
          <img src="../images/logo/nikelogo.png" alt="logo" onclick="BrandItemIframe('Nike')">
          <img src="../images/logo/Adidas_logo.png" alt="logo" onclick="BrandItemIframe('Adidas')">
          <img src="../images/logo/Bitis_logo.png" alt="logo" onclick="BrandItemIframe('Biti\'s')">
          <img src="../images/logo/Vans_logo.png" alt="logo" onclick="BrandItemIframe('Vans')">
          <img src="../images/logo/Newbalance_logo.png" alt="logo" onclick="BrandItemIframe('New Balance')">
          <img src="../images/logo/Converse_logo.png" alt="logo" onclick="BrandItemIframe('Converse')">
      </div>
      <div class="homepage">
          <div class=" brand bestseller">
              <h2>BEST SELLER</h2>
              <div class="shoeDisplay"> 
                <?php
                    $query = mysqli_query($conn, "SELECT *,SUM(SOLUONG) as SL FROM chitiet_donhang, giay WHERE chitiet_donhang.MAGIAY=giay.MAGIAY GROUP BY chitiet_donhang.MAGIAY ORDER by SUM(SOLUONG) DESC LIMIT 4");
                    while ($rowData=mysqli_fetch_assoc($query)) {
                        $arrImg = explode("|", $rowData['HINHANH']);
                        $Shoename = $rowData['MAGIAY'];
                        $price = $rowData['GIA'];
                ?>
                    <div class="shoes" onclick="Shoe('<?php echo $conn->real_escape_string($rowData['MAGIAY'])?>')" style="max-width: 250px">
                        <div class="imgContain">
                            <i class="<?php
                                $shoe = $conn->real_escape_string($name);
                                if (isset($_SESSION['username'])){
                                    $name = $_SESSION['username'];
                                    $query_sdt = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$name'");
                                    $query_sdt = mysqli_fetch_row($query_sdt);
                                    $getSDT = $query_sdt[0];
                                } 
                                $query_fav = "SELECT * FROM yeuthich WHERE SDT = '$getSDT' AND MAGIAY = '$shoe'";
                                $row_query = mysqli_num_rows(mysqli_query($conn, $query_fav));
                                echo ($row_query == 1) ?  "fa-solid" :  "fa-regular";
                            ?>
                            fa-heart"></i>
                            <img src="../images/<?php echo ltrim($arrImg[0])?>" alt="shoes" class="img1">
                            <img src="../images/<?php echo ltrim($arrImg[1])?>" alt="shoes" class="img2">
                        </div>
                        <h4 style="height: 20px; margin-bottom: 20px; text-align: center;"><?php echo $Shoename?></h4>
                        <p><?php echo number_format($price)?> VND</p>
                    </div>  
                <?php
                    }
                ?>
              </div>
          </div>

          <div class=" brand ">
            <img src="../images/logo/Adidas_logo.png" alt="logo">
            <div class="shoeDisplay">
                <?php
                    $brandName = "Adidas";
                    $escapedBrandName = $conn->real_escape_string($brandName);
                    $query = mysqli_query($conn, "SELECT HANG_ID FROM hanggiay WHERE TENHANG = '$escapedBrandName'");
                    $query = mysqli_fetch_row($query);
                    $getID = $query[0];
                    $query = mysqli_query($conn, "SELECT * FROM giay WHERE HANG_ID = '$getID' LIMIT 4");
                    while ($rowData=mysqli_fetch_assoc($query)) {
                        $arrImg = explode("|", $rowData['HINHANH']);
                        $shoename = $rowData['MAGIAY'];
                        $price = $rowData['GIA'];
                ?>
                    <div class="shoes">
                        <div class="imgContain">
                            <i class="<?php
                                $shoename = $conn->real_escape_string($shoename);
                                if (isset($_SESSION['username'])){
                                    $user = $_SESSION['username'];
                                    $query_sdt = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$user'");
                                    $query_sdt = mysqli_fetch_row($query_sdt);
                                    $getSDT = $query_sdt[0];
                                } 
                                $query_fav = "SELECT * FROM yeuthich WHERE SDT = '$getSDT' AND MAGIAY = '$shoename'";
                                $row_query = mysqli_num_rows(mysqli_query($conn, $query_fav));
                                echo ($row_query == 1) ?  "fa-solid" :  "fa-regular";
                            ?>
                            fa-heart"></i>
                            <img src="../images/<?php echo ltrim($arrImg[0])?>" alt="shoes" class="img1">
                            <img src="../images/<?php echo ltrim($arrImg[1])?>" alt="shoes" class="img2">
                        </div>
                        <h4><?php echo $shoename?></h4>
                        <p><?php echo number_format($price)?> VND</p>
                    </div>
                <?php
                    }
                ?>
            </div>
              <h4 id="Adidas" class="SeeALL" style="align-self: flex-end;margin-right: 80px;cursor: pointer; margin-bottom: 10px;">See All</h4>
          </div>

          <div class=" brand ">
              <img src="../images/logo/nikelogo.png" alt="logo">
              <div class="shoeDisplay">
              <?php
                    $brandName = "Nike";
                    $escapedBrandName = $conn->real_escape_string($brandName);
                    $query = mysqli_query($conn, "SELECT HANG_ID FROM hanggiay WHERE TENHANG = '$escapedBrandName'");
                    $query = mysqli_fetch_row($query);
                    $getID = $query[0];
                    $query = mysqli_query($conn, "SELECT * FROM giay WHERE HANG_ID = '$getID' LIMIT 4");
                    while ($rowData=mysqli_fetch_assoc($query)) {
                        $arrImg = explode("|", $rowData['HINHANH']);
                        $shoename = $rowData['MAGIAY'];
                        $price = $rowData['GIA'];
                ?>
                    <div class="shoes">
                        <div class="imgContain">
                            <i class="<?php
                                $shoename = $conn->real_escape_string($shoename);
                                if (isset($_SESSION['username'])){
                                    $user = $_SESSION['username'];
                                    $query_sdt = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$user'");
                                    $query_sdt = mysqli_fetch_row($query_sdt);
                                    $getSDT = $query_sdt[0];
                                } 
                                $query_fav = "SELECT * FROM yeuthich WHERE SDT = '$getSDT' AND MAGIAY = '$shoename'";
                                $row_query = mysqli_num_rows(mysqli_query($conn, $query_fav));
                                echo ($row_query == 1) ?  "fa-solid" :  "fa-regular";
                            ?>
                            fa-heart"></i>
                            <img src="../images/<?php echo ltrim($arrImg[0])?>" alt="shoes" class="img1">
                            <img src="../images/<?php echo ltrim($arrImg[1])?>" alt="shoes" class="img2">
                        </div>
                        <h4><?php echo $shoename?></h4>
                        <p><?php echo number_format($price)?> VND</p>
                    </div>
                <?php
                    }
                ?>
              </div>
              <h4 id="Nike" class="SeeALL" style="align-self: flex-end;margin-right: 80px;cursor: pointer; margin-bottom: 10px;">See All</h4>
          </div>

          <div class=" brand ">
              <img src="../images/logo/Bitis_logo.png" alt="logo">
              <div class="shoeDisplay">
                <?php
                    $brandName = "Biti's";
                    $escapedBrandName = $conn->real_escape_string($brandName);
                    $query = mysqli_query($conn, "SELECT HANG_ID FROM hanggiay WHERE TENHANG = '$escapedBrandName'");
                    $query = mysqli_fetch_row($query);
                    $getID = $query[0];
                    $query = mysqli_query($conn, "SELECT * FROM giay WHERE HANG_ID = '$getID' LIMIT 4");
                    while ($rowData=mysqli_fetch_assoc($query)) {
                        $arrImg = explode("|", $rowData['HINHANH']);
                        $shoename = $rowData['MAGIAY'];
                        $price = $rowData['GIA'];
                ?>
                    <div class="shoes" style="max-width: 250px">
                        <div class="imgContain">
                            <i class="<?php
                                $shoename = $conn->real_escape_string($shoename);
                                if (isset($_SESSION['username'])){
                                    $user = $_SESSION['username'];
                                    $query_sdt = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$user'");
                                    $query_sdt = mysqli_fetch_row($query_sdt);
                                    $getSDT = $query_sdt[0];
                                } 
                                $query_fav = "SELECT * FROM yeuthich WHERE SDT = '$getSDT' AND MAGIAY = '$shoename'";
                                $row_query = mysqli_num_rows(mysqli_query($conn, $query_fav));
                                echo ($row_query == 1) ?  "fa-solid" :  "fa-regular";
                            ?>
                            fa-heart"></i>
                            <img src="../images/<?php echo ltrim($arrImg[0])?>" alt="shoes" class="img1">
                            <img src="../images/<?php echo ltrim($arrImg[1])?>" alt="shoes" class="img2">
                        </div>
                        <h4 style="height: 20px; margin-bottom: 20px; text-align: center;"><?php echo $shoename?></h4>
                        <p><?php echo number_format($price)?> VND</p>
                    </div>
                <?php
                    }
                ?>
              </div>
              <h4 id="Biti's" class="SeeALL" style="align-self: flex-end;margin-right: 80px;cursor: pointer; margin-bottom: 10px;">See All</h4>
          </div>

          <div class=" brand ">
              <img src="../images/logo/Vans_logo.png" alt="logo">
              <div class="shoeDisplay">
              <?php
                    $brandName = "Vans";
                    $escapedBrandName = $conn->real_escape_string($brandName);
                    $query = mysqli_query($conn, "SELECT HANG_ID FROM hanggiay WHERE TENHANG = '$escapedBrandName'");
                    $query = mysqli_fetch_row($query);
                    $getID = $query[0];
                    $query = mysqli_query($conn, "SELECT * FROM giay WHERE HANG_ID = '$getID' LIMIT 4");
                    while ($rowData=mysqli_fetch_assoc($query)) {
                        $arrImg = explode("|", $rowData['HINHANH']);
                        $shoename = $rowData['MAGIAY'];
                        $price = $rowData['GIA'];
                ?>
                    <div class="shoes">
                        <div class="imgContain">
                            <i class="<?php
                                $shoename = $conn->real_escape_string($shoename);
                                if (isset($_SESSION['username'])){
                                    $user = $_SESSION['username'];
                                    $query_sdt = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$user'");
                                    $query_sdt = mysqli_fetch_row($query_sdt);
                                    $getSDT = $query_sdt[0];
                                } 
                                $query_fav = "SELECT * FROM yeuthich WHERE SDT = '$getSDT' AND MAGIAY = '$shoename'";
                                $row_query = mysqli_num_rows(mysqli_query($conn, $query_fav));
                                echo ($row_query == 1) ?  "fa-solid" :  "fa-regular";
                            ?>
                            fa-heart"></i>
                            <img src="../images/<?php echo ltrim($arrImg[0])?>" alt="shoes" class="img1">
                            <img src="../images/<?php echo ltrim($arrImg[1])?>" alt="shoes" class="img2">
                        </div>
                        <h4><?php echo $shoename?></h4>
                        <p><?php echo number_format($price)?> VND</p>
                    </div>
                <?php
                    }
                ?>
              </div>
              <h4 id="Vans" class="SeeALL" style="align-self: flex-end;margin-right: 80px;cursor: pointer; margin-bottom: 10px;">See All</h4>
          </div>

          <div class=" brand ">
              <img src="../images/logo/Newbalance_logo.png" alt="logo">
              <div class="shoeDisplay">
              <?php
                    $brandName = "New Balance";
                    $escapedBrandName = $conn->real_escape_string($brandName);
                    $query = mysqli_query($conn, "SELECT HANG_ID FROM hanggiay WHERE TENHANG = '$escapedBrandName'");
                    $query = mysqli_fetch_row($query);
                    $getID = $query[0];
                    $query = mysqli_query($conn, "SELECT * FROM giay WHERE HANG_ID = '$getID' LIMIT 4");
                    while ($rowData=mysqli_fetch_assoc($query)) {
                        $arrImg = explode("|", $rowData['HINHANH']);
                        $shoename = $rowData['MAGIAY'];
                        $price = $rowData['GIA'];
                ?>
                    <div class="shoes">
                        <div class="imgContain">
                            <i class="<?php
                                $shoename = $conn->real_escape_string($shoename);
                                if (isset($_SESSION['username'])){
                                    $user = $_SESSION['username'];
                                    $query_sdt = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$user'");
                                    $query_sdt = mysqli_fetch_row($query_sdt);
                                    $getSDT = $query_sdt[0];
                                } 
                                $query_fav = "SELECT * FROM yeuthich WHERE SDT = '$getSDT' AND MAGIAY = '$shoename'";
                                $row_query = mysqli_num_rows(mysqli_query($conn, $query_fav));
                                echo ($row_query == 1) ?  "fa-solid" :  "fa-regular";
                            ?>
                            fa-heart"></i>
                            <img src="../images/<?php echo ltrim($arrImg[0])?>" alt="shoes" class="img1">
                            <img src="../images/<?php echo ltrim($arrImg[1])?>" alt="shoes" class="img2">
                        </div>
                        <h4><?php echo $shoename?></h4>
                        <p><?php echo number_format($price)?> VND</p>
                    </div>
                <?php
                    }
                ?>
              </div>
              <h4 id="New Balance" class="SeeALL" style="align-self: flex-end;margin-right: 80px;cursor: pointer; margin-bottom: 10px;">See All</h4>
          </div>

          <div class=" brand ">
              <img src="../images/logo/Converse_logo.png" alt="logo">
              <div class="shoeDisplay">
              <?php
                    $brandName = "Converse";
                    $escapedBrandName = $conn->real_escape_string($brandName);
                    $query = mysqli_query($conn, "SELECT HANG_ID FROM hanggiay WHERE TENHANG = '$escapedBrandName'");
                    $query = mysqli_fetch_row($query);
                    $getID = $query[0];
                    $query = mysqli_query($conn, "SELECT * FROM giay WHERE HANG_ID = '$getID' LIMIT 4");
                    while ($rowData=mysqli_fetch_assoc($query)) {
                        $arrImg = explode("|", $rowData['HINHANH']);
                        $shoename = $rowData['MAGIAY'];
                        $price = $rowData['GIA'];
                ?>
                    <div class="shoes">
                        <div class="imgContain">
                            <i class="<?php
                                $shoename = $conn->real_escape_string($shoename);
                                if (isset($_SESSION['username'])){
                                    $user = $_SESSION['username'];
                                    $query_sdt = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$user'");
                                    $query_sdt = mysqli_fetch_row($query_sdt);
                                    $getSDT = $query_sdt[0];
                                } 
                                $query_fav = "SELECT * FROM yeuthich WHERE SDT = '$getSDT' AND MAGIAY = '$shoename'";
                                $row_query = mysqli_num_rows(mysqli_query($conn, $query_fav));
                                echo ($row_query == 1) ?  "fa-solid" :  "fa-regular";
                            ?>
                            fa-heart"></i>
                            <img src="../images/<?php echo ltrim($arrImg[0])?>" alt="shoes" class="img1">
                            <img src="../images/<?php echo ltrim($arrImg[1])?>" alt="shoes" class="img2">
                        </div>
                        <h4><?php echo $shoename?></h4>
                        <p><?php echo number_format($price)?> VND</p>
                    </div>
                <?php
                    }
                ?>
              </div>
              <h4 id="Converse" class="SeeALL" style="align-self: flex-end;margin-right: 80px;cursor: pointer; margin-bottom: 10px;">See All</h4>
          </div>
          
      </div>
  </main> 
</body>
<script src="../app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</html>