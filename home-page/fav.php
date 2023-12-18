<?php
    require '../connect.php';
    session_start();
    if (isset($_SESSION['username'])){
        $name = $_SESSION['username'];
        $query = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$name'");
        $query = mysqli_fetch_row($query);
        $getSDT = $query[0];
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
    <title>Document</title>
</head>
<body>
    <main class="fav">
        <h1>FAVOURITE</h1>
        <div class="shoeDisplay">
            <?php
                if ($check == 1){
                    $queryImg = mysqli_query($conn, "SELECT * FROM yeuthich, giay, khachhang WHERE khachhang.SDT = yeuthich.SDT AND yeuthich.MAGIAY = giay.MAGIAY AND khachhang.SDT = '$getSDT'");
                    $count_row = mysqli_num_rows($queryImg);
                    if ($count_row > 0){
                    while ($rowData=mysqli_fetch_assoc($queryImg)) {
                        $arrImg = explode("|", $rowData['HINHANH']);
            ?>
                <div class="shoes" style="max-width: 250px;" onclick="Shoe('<?php echo $conn->real_escape_string($rowData['MAGIAY'])?>')">
                    <div class="imgContain">
                        <i class="fa-solid fa-heart" style="color: red"></i>
                        <img src="../images/<?php echo ltrim($arrImg[0])?>" alt="shoes" class="img1">
                        <img src="../images/<?php echo ltrim($arrImg[1])?>" alt="shoes" class="img2">
                    </div>
                    <h4 style="height: 20px; margin-bottom: 20px; text-align: center;"><?php echo $rowData['MAGIAY']?></h4>
                    <p><?php echo number_format($rowData['GIA'])?></p>
                </div>
            <?php
                    }
                }
                else{
                    echo "<h3 style='color: red; margin: auto'>Không có dữ liệu</h3>";
                }
            }
            ?>
        </div>
    </main>
  
</body>
<script src="../app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</html>