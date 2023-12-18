<?php
    require "../connect.php";   

    if (isset($_GET['orderID'])){
        $orderID = $_GET['orderID'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./itemdisplay.css">
    <link rel="stylesheet" href="../login-register/login.css">
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Document</title>
</head>
<body>
    <main class="detailshipping" style="margin: 10px; height: 550px">
        <div class="cartItems">
            <h3>ORDER ID: <?php echo $orderID?></h3>
            <?php
                $query = mysqli_query($conn, "SELECT *, chitiet_donhang.KICHTHUOC as ORDER_SIZE FROM chitiet_donhang, giay, chitiet_giay WHERE chitiet_donhang.MAGIAY=giay.MAGIAY AND giay.MAGIAY=chitiet_giay.MAGIAY AND MADON = '$orderID'");
                while ($rowData=mysqli_fetch_assoc($query)) {
                    $codeOrder = $rowData['MADON'];
                    $image = explode("|", $rowData['HINHANH']);
                    // $sum = $rowData['TONG'];
            ?>
                <div class="Items"> 
                    <img id="imageItem" src="../images/<?php echo $image[0]?>" alt="shoe">
                    <div class="detail">
                        <div class="context">
                            <h3><?php echo $rowData['MAGIAY']?></h3>
                            <h5><?php echo $rowData['MAU']?> | <?php echo $rowData['THELOAI']?></h5>
                            <p>
                                <span>Size: <?php echo $rowData['ORDER_SIZE']?></span>
                                |
                                <span>Quantity: <?php echo $rowData['SOLUONG']?></span>
                            </p>
                        </div>
                        <div class="price">
                            <h3><?php echo number_format($rowData['GIA'])?> VND</h3>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>
            <h3 class="orderTotal">TOTAL: <?php 
                $query = mysqli_query($conn, "SELECT SUM(chitiet_donhang.THANHTIEN) as TONG FROM chitiet_donhang, giay, chitiet_giay WHERE chitiet_donhang.MAGIAY=giay.MAGIAY AND giay.MAGIAY=chitiet_giay.MAGIAY AND MADON = '$orderID'");
                $query = mysqli_fetch_row($query);
                $sum = $query[0];
            echo number_format($sum)?> VND</h3>
        </div>
        
        <div class="summary">
            <?php
                $query = mysqli_query($conn, "SELECT *, chitiet_donhang.KICHTHUOC as ORDER_SIZE, chitiet_donhang.SDT as PHONE FROM chitiet_donhang, giay, chitiet_giay WHERE chitiet_donhang.MAGIAY=giay.MAGIAY AND giay.MAGIAY=chitiet_giay.MAGIAY AND MADON = '$orderID'");
                $query = mysqli_fetch_row($query);
                $getName = $query[14];
                $getPhone = $query[26];
                $getAddress = $query[10];
            ?>
            <h3>ADDRESS INFOMATION</h3>
            <p><b>Name: </b><?php echo $getName?></p>
            <p><b>Phone Number: </b><?php echo $getPhone?></p>
            <p><b>Address: </b><?php echo $getAddress?></p>
        </div>
    </main>
</body>
<script src="../app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</html>