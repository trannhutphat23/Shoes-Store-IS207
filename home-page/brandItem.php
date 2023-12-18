<?php
    require '../connect.php';
    session_start();
    $img_url = "";
    if (isset($_GET['brandName'])){
        $brandName = $_GET['brandName'];
        $escapedBrandName = $conn->real_escape_string($brandName);
        $query = mysqli_query($conn, "SELECT HANG_ID FROM hanggiay WHERE TENHANG = '$escapedBrandName'");
        $query = mysqli_fetch_row($query);
        $getID = $query[0];
        switch($brandName){
            case "Nike":{
                $img_url = "nikelogo.png";
                break;
            }
            case "Adidas": {
                $img_url = "Adidas_logo.png";
                break;
            }
            case "Biti's": {
                $img_url = "Bitis_logo.png";
                break;
            }
            case "Vans": {
                $img_url = "Vans_logo.png";
                break;
            }
            case "New Balance": {
                $img_url = "Newbalance_logo.png";
                break;
            }
            case "Converse": {
                $img_url = "Converse_logo.png";
                break;
            }
        }
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
    <main>
        <img src="../images/logo/<?php echo $img_url?>" alt="logo" style="height: 80px; margin-top: 15px;">
        <div class="shoeDisplay" style="max-width: 100%;">
            <?php
                $queryImg = mysqli_query($conn, "SELECT * FROM giay WHERE HANG_ID = $getID");
                while ($rowData=mysqli_fetch_assoc($queryImg)) {
                    $arrImg = explode("|", $rowData['HINHANH']);
            ?>
                <div class="shoes" style="max-width: 250px;" onclick="Shoe('<?php echo $conn->real_escape_string($rowData['MAGIAY'])?>')">
                    <div class="imgContain">
                        <i class="<?php 
                            $shoe = $conn->real_escape_string($rowData['MAGIAY']);
                            if (isset($_SESSION['username'])){
                                $name = $_SESSION['username'];
                                $query = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$name'");
                                $query = mysqli_fetch_row($query);
                                $getSDT = $query[0];
                            }
                            $query_fav = "SELECT * FROM yeuthich WHERE SDT = '$getSDT' AND MAGIAY = '$shoe'";
                            $row_query = mysqli_num_rows(mysqli_query($conn, $query_fav));
                            echo ($row_query == 1) ?  "fa-solid" :  "fa-regular";
                        ?> fa-heart" style="color: <?php echo ($row_query == 1) ?  "red" :  null?>"></i>
                        <img src="../images/<?php echo ltrim($arrImg[0])?>" alt="shoes" class="img1">
                        <img src="../images/<?php echo ltrim($arrImg[1])?>" alt="shoes" class="img2">
                    </div>
                    <h4 style="height: 20px; margin-bottom: 20px; text-align: center;"><?php echo $rowData['MAGIAY']?></h4>
                    <p><?php echo number_format($rowData['GIA'])?> đ</p>
                </div>
            <?php
                }
            ?>
        </div>
    </main>
</body>
<script src="../app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</html>