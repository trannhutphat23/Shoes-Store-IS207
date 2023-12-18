<?php
    require "../connect.php";
    session_start();
    if (isset($_SESSION['username']) && isset($_COOKIE['checkSignin'])){
        $getUser = $_SESSION['username'];
        $checkSignin = $_COOKIE['checkSignin'];
        $querySDT = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$getUser'");
        $querySDT = mysqli_fetch_row($querySDT);
        $getSDT = $querySDT[0];
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
    <style>
        #orderID{
            display: inline;
        }
        #orderID:hover{
            color: rgb(141, 156, 138);
        }
        #checkStatus:hover{
            color: rgb(85, 154, 237);
        }
        .top-position-alert {
            top: unset !important;
            transform: translateY(0) !important;
        }
    </style>
    <script>
        $(document).ready(function(){
            $(".cancelorder").click(function(){
                var arrID = $(this).attr("id");
                $.ajax({
                    url: "delOrder.php",
                    type: "POST",
                    data: {trashID: arrID},
                    success: function(data){
                        swal({
                            title: "CONGRATULATIONS!",
                            text: "XÓA SẢN PHẨM THÀNH CÔNG",
                            icon: "success",
                            closeOnClickOutside: false,
                        })
                        .then(() => {
                            location.href = "shipping.php";
                        })
                    }
                })
            })

            $("h3#orderID").click(function(){
                var getID = $(this).attr('class');
                orderDetail(getID);
            })

            $("#checkStatus").click(function(){
                var getSDT = "<?php echo $getSDT?>";
                $.ajax({
                    url: 'updateStatus.php',
                    type: 'POST',
                    data: {getSDT: getSDT},
                    success: function(data){
                        if (data == 1){
                            alert("KIỂM TRA THÀNH CÔNG");
                            location.href = 'shipping.php';
                        }else{
                            alert("KHÔNG CÓ SẢN PHẨM NÀO THAY ĐỔI");
                        }
                    }
                })
            })

            $(".shipping").hover(function(){
                $("#info_order").fadeIn(500);
            }, function(){
                $("#info_order").fadeOut(500);
            })
        })
    </script>
    <span id="checkStatus" style="cursor: pointer; margin-top: 10px; display: flex; align-items: center;"><svg style="margin-right: 10px; margin-left: 100px; width: 25px; height: 25px;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg> <h3 style="text-align: center;">Kiểm tra tình trạng</h3></span>
        <main class="cartmain">
        <h1 style="text-align: left; cursor: pointer" class="cartTitle shipping">SHIPPING</h1>
        <h3 id="info_order" style="color: blue; display:none">Hàng sẽ được giao sau 5 ngày kể từ ngày đặt hàng</h3>
        <div class="ship">
            <div class="cartItems">
                <div class="order">
                    <?php
                        $query = mysqli_query($conn, "SELECT * FROM donhang, chitiet_donhang WHERE donhang.MADON = chitiet_donhang.MADON AND donhang.SDT = '$getSDT' AND TINHTRANG = 'SHIPPING' GROUP BY chitiet_donhang.MADON");
                        $count_row = mysqli_num_rows($query);
                        if ($count_row > 0){    
                        while ($rowData=mysqli_fetch_assoc($query)) {
                            $codeOrder = $rowData['MADON'];
                            echo "<div class='idbox'>";
                            echo "<h3 style='cursor: pointer;' id='orderID' class=".$codeOrder.">ORDER ID: ".$codeOrder."</h3>";
                            echo "<h3 class='cancelorder' id=".$codeOrder.">HỦY ĐƠN</h3>";
                            echo "</div>";
                            $query_order = mysqli_query($conn, "SELECT *, chitiet_donhang.KICHTHUOC as ORDER_SIZE FROM chitiet_donhang, giay, chitiet_giay WHERE chitiet_donhang.MAGIAY=giay.MAGIAY AND giay.MAGIAY=chitiet_giay.MAGIAY AND MADON = '$codeOrder'");
                            while ($rowData=mysqli_fetch_assoc($query_order)) {
                                $image = explode("|", $rowData['HINHANH']);
                                $shoeName = $rowData['MAGIAY'];
                                $size = $rowData['ORDER_SIZE'];
                                $color = $rowData['MAU'];
                                $type = $rowData['THELOAI'];
                                $quantity = $rowData['SOLUONG'];
                                $price = $rowData['GIA'];
                    ?>     
                            <div class="Items"> 
                                <img id="imageItem" src="../images/<?php echo $image[0]?>" alt="shoe">
                                <div class="detail">
                                    <div class="context">
                                        <h3><?php echo $shoeName?></h3>
                                        <h5><?php echo $color?> | <?php echo $type?> </h5>
                                        <p>
                                            <span>Size: <?php echo $size?></span>
                                            |
                                            <span>Quantity: <?php echo $quantity?></span>
                                        </p>
                                        <span>
                                            <i class="<?php
                                                $shoe = $conn->real_escape_string($shoeName);
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
                                        </span>
                                    </div>
                                    <div class="price">
                                        <h3><?php echo number_format($price)?> VND</h3>
                                    </div>
                                </div>
                            </div>
                        <?php
                                }
                            ?>
                                <h3 class="orderTotal" style="margin-bottom: 30px">TOTAL: <?php
                                    $querySum = mysqli_query($conn, "SELECT SUM(chitiet_donhang.THANHTIEN) AS TONG FROM donhang, chitiet_donhang WHERE donhang.MADON = chitiet_donhang.MADON AND donhang.SDT = '$getSDT' AND TINHTRANG = 'SHIPPING' AND chitiet_donhang.MADON = '$codeOrder'");
                                    $querySum = mysqli_fetch_row($querySum);
                                    $Sum = $querySum[0];
                                    echo number_format($Sum);
                                ?> VND</h3>
                            <?php
                            }
                        }else{
                            echo "<h3 style='color: red; margin: auto'>Không có dữ liệu</h3>";
                        }
                        ?>
                </div>
            </div>
        </div>

        <h1 class="cartTitle">DELIVERED</h1>
        <div class="ship">
            <div class="cartItems">
                <div class="order">
                    <?php
                        $query = mysqli_query($conn, "SELECT * FROM donhang, chitiet_donhang WHERE donhang.MADON = chitiet_donhang.MADON AND donhang.SDT = '$getSDT' AND TINHTRANG = 'DELIVERED' GROUP BY chitiet_donhang.MADON");
                        $count_row = mysqli_num_rows($query);
                        if ($count_row > 0){
                        while ($rowData=mysqli_fetch_assoc($query)) {
                            $codeOrder = $rowData['MADON'];
                            echo "<h3 style='cursor: pointer;' id='orderID' class=".$codeOrder.">ORDER ID: ".$codeOrder."</h3>";
                            $query_order = mysqli_query($conn, "SELECT *, chitiet_donhang.KICHTHUOC as ORDER_SIZE FROM chitiet_donhang, giay, chitiet_giay WHERE chitiet_donhang.MAGIAY=giay.MAGIAY AND giay.MAGIAY=chitiet_giay.MAGIAY AND MADON = '$codeOrder'");
                            while ($rowData=mysqli_fetch_assoc($query_order)) {
                                $image = explode("|", $rowData['HINHANH']);
                                $shoeName = $rowData['MAGIAY'];
                                $size = $rowData['ORDER_SIZE'];
                                $color = $rowData['MAU'];
                                $type = $rowData['THELOAI'];
                                $quantity = $rowData['SOLUONG'];
                                $price = $rowData['GIA'];
                    ?>     
                            <div class="Items"> 
                                <img id="imageItem" src="../images/<?php echo $image[0]?>" alt="shoe">
                                <div class="detail">
                                    <div class="context">
                                        <h3><?php echo $shoeName?></h3>
                                        <h5><?php echo $color?> | <?php echo $type?> </h5>
                                        <p>
                                            <span>Size: <?php echo $size?></span>
                                            |
                                            <span>Quantity: <?php echo $quantity?></span>
                                        </p>
                                        <span>
                                            <i class="<?php
                                                $shoe = $conn->real_escape_string($shoeName);
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
                                        </span>
                                    </div>
                                    <div class="price">
                                        <h3><?php echo number_format($price)?> VND</h3>
                                    </div>
                                </div>
                            </div>
                        <?php
                                }
                            ?>
                                <h3 class="orderTotal" style="margin-bottom: 30px">TOTAL: <?php
                                    $querySum = mysqli_query($conn, "SELECT SUM(chitiet_donhang.THANHTIEN) AS TONG FROM donhang, chitiet_donhang WHERE donhang.MADON = chitiet_donhang.MADON AND donhang.SDT = '$getSDT' AND TINHTRANG = 'DELIVERED' AND chitiet_donhang.MADON = '$codeOrder'");
                                    $querySum = mysqli_fetch_row($querySum);
                                    $Sum = $querySum[0];
                                    echo number_format($Sum);
                                ?> VND</h3>
                            <?php
                            }
                        }else{
                            echo "<h3 style='color: red; margin: auto'>Không có dữ liệu</h3>";
                        }
                        ?>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="../app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</html>