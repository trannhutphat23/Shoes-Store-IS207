<?php
    require '../connect.php';
    session_start();

    if (isset($_SESSION['username']) && isset($_COOKIE['checkSignin'])){
        $getUser = $_SESSION['username'];
        $checkSignin = $_COOKIE['checkSignin'];
        $querySDT = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$getUser'");
        $querySDT = mysqli_fetch_row($querySDT);
        $getSDT = $querySDT[0];
    }else{
        $checkSignin=0;
    }
    if (isset($_GET['ShoeName'])){
        $shoeName = $_GET['ShoeName'];
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <link rel="stylesheet" href="./shoe.css">
    <link rel="stylesheet" href="../login-register/login.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../fontawesome-free-6.3.0-web/fontawsome/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Document</title>
</head>
<body>
    <style>
        .swal-title {
            margin: 0px;
            font-size: 20px;
        }
    </style>
    <script>
        $(document).ready(function(){
            var checkSignin = <?php echo $checkSignin?>;
            $(".favouriteShoe").click(function(){
                if (checkSignin == 1){
                    <?php if (isset($_SESSION['username'])){ ?>
                        var phoneNum = "<?php echo $getSDT?>";
                    <?php } ?>
                    var shoe = "<?php echo $shoeName?>";
                    favouriteShoe();
                    $.ajax({
                        type: "POST",
                        url: "FavInsert.php",
                        data: {phone: phoneNum, shoe: shoe},
                        success: function(data){
                        }
                    })
                }else{
                    swal("Failure!", "Bạn chưa đăng nhập", "warning");
                }
            })

            $("#buynow").click(function(){
                if (checkSignin == 1){
                    var selectSize = $('option:selected').val();
                    var selectNum = $('#quantity').val();
                    var phone = "<?php echo $getSDT?>";
                    var shoeName = "<?php echo $shoeName?>";
                    var username = "<?php echo $getUser?>";
                    $.ajax({
                        url: "CartInsert.php",
                        type: "POST",
                        data: {selectSize: selectSize, selectNum: selectNum, phone: phone, shoeName: shoeName, check: 2},
                        success: function(data){
                            if (data == 2){
                                swal({
                                    title: "SẢN PHẨM ĐÃ CÓ TRONG GIỎ HÀNG!",
                                    icon: "warning",
                                })
                                .then(() => {
                                    location.href = "../shopping-cart/cart.php?username=" + username;   
                                })
                            }else{
                                CheckOut(username,selectSize, selectNum,1);
                            }
                        }
                    })
                }else{
                    swal("Failure!", "Bạn chưa đăng nhập", "warning");
                }
            })

            $("#addCart").click(function(){
                if (checkSignin == 1){
                    var selectSize = $('option:selected').val();
                    var selectNum = $('#quantity').val();
                    var phone = "<?php echo $getSDT?>";
                    var shoeName = "<?php echo $shoeName?>"
                    var username = "<?php echo $getUser?>"
                    swal({
                        title: "Đã thêm vào giỏ hàng",
                        icon: "success",
                        closeOnClickOutside: false  
                    })
                    .then(() => {
                        $.ajax({
                            url: "CartInsert.php",
                            type: "POST",
                            data: {selectSize: selectSize, selectNum: selectNum, phone: phone, shoeName: shoeName, check: 0},
                        })
                    })
                    .then(() => {
                        window.location.href = "../shopping-cart/cart.php?username=" + username;
                    })
                    .catch((err) => {
                        console.log(err);
                    });
                }else{
                    swal("Failure!", "Bạn chưa đăng nhập", "warning");
                }
            })
        })
    </script>
    <main class="shoe">
        <div class="shoeImg">
            <aside>
                <?php
                    foreach($arrImg as $url){
                        $url = ltrim($url);
                        echo "<img src='../images/$url' alt='asideImg' class='asideImg chose' onclick='choseImg(this)'>";
                    }
                ?>
            </aside>
            <img src="../images/<?php echo $arrImg[0]?>" alt="shoe" id="imgDisplay" style="height: 450px">
        </div>
        <div class="shoeDetail">
            <h2><?php echo stripslashes($shoeName)?></h2>
            <p style="margin-bottom: 30px;"><?php echo $color?> | <?php echo $style?></p>
            <ul>
                <li>
                    <h4>Price:</h4>
                    <h4><?php echo number_format($getPrice)?> đ</h4>
                </li>
                <li>
                    <p>Size:</p>
                    <select>
                        <?php
                            foreach ($arrSize as $size){
                                echo "<option value=".$size.">".$size."</option>";
                            }
                        ?>
                    </select>
                </li>
                <li>
                    <p>Quantity</p>
                    <div class="quantityButton">
                        <button class="dec" onclick="dec()">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <input type="number" value="1" id="quantity">
                        <button class="inc" onclick="inc()">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </li>
                <li class="decription">
                    <p>
                        <?php
                            $query = mysqli_query($conn, "SELECT MOTA_SANPHAM FROM giay WHERE MAGIAY = '$shoeNameEscape'");
                            $query = mysqli_fetch_row($query);
                            $info = $query[0];
                            echo $info;
                        ?>
                    </p>
                </li>
                <li class="shoeButton">
                    <button id="addCart">
                        <p>ADD TO CART</p>
                    </button>
                    <button id="buynow">
                        <p>BUY NOW</p>
                    </button>
                    <i style="margin-bottom: 250px" class="<?php 
                        $query_fav = "SELECT * FROM yeuthich WHERE SDT = '$getSDT' AND MAGIAY = '$shoeNameEscape'";
                        $row_query = mysqli_num_rows(mysqli_query($conn, $query_fav));
                        echo ($row_query == 1) ?  "fa-solid" :  "fa-regular";
                    ?> fa-heart favouriteShoe"></i>
                </li>
            </ul>
        </div>
    </main>
</body>
<script src="../app.js"></script>
</html>