<?php
    require "../connect.php";
    session_start();
    if (isset($_SESSION['username'])){
        $name = $_SESSION['username'];
        $query = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$name'");
        $query = mysqli_fetch_row($query);
        $getSDT = $query[0];
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
        .swal-title {
            margin: 0px;
            font-size: 20px;
        }
    </style>
    <script>
        $(document).ready(function(){
            var contHtml = $("#Total").html();
            var getPrice = contHtml.split(" ");
            var intPrice = parseInt(getPrice[0].replace(/,/g, ""), 10);

            var PriceDeliver = $("#deliverPrice").html();
            var PriceDeliver = PriceDeliver.split(" ");
            var PriceDeliver = parseInt(PriceDeliver[0].replace(/,/g, ""), 10);

            $("#sum").html((intPrice + PriceDeliver).toLocaleString('en-US') + " VND");

            $(".fa-trash-can").click(function(){
                var getid = $(this).attr("id");
                var arr = getid.split(',');
                var phone = arr[0];
                var shoename = arr[1];
                var size = arr[2];
                $.ajax({
                    url: "../shoe/CartDelete.php",
                    type: "POST",
                    data: {phone: phone, shoename: shoename, size: size},
                    success: function(data){
                        swal({
                            title: "CONGRATULATIONS!",
                            text: "XÓA SẢN PHẨM THÀNH CÔNG",
                            icon: "success",
                            closeOnClickOutside: false  
                        })
                        .then(() => {
                            location.href = "cart.php";
                        })
                    }
                })
            })

            $("._check").click(function(){
                var getID = $(this).parent().parent().children().find('*').map(function(){
                    return this.id;
                });
                var arrIDVal = getID[7].split(",");
                var phone = "<?php echo $getSDT?>";
                var shoeName = arrIDVal[1];
                var size = arrIDVal[2];
                $.ajax({
                    url: "updateCheckIcon.php",
                    type: "POST",
                    data: {phone: phone, shoeName: shoeName, size: size},
                    success: function(data){
                        location.href = "cart.php";
                    }
                })
            })

            $(".checkout").click(function(){
                <?php
                    $query = mysqli_query($conn, "SELECT * FROM giohang, giay, chitiet_giay WHERE giohang.MAGIAY = giay.MAGIAY AND chitiet_giay.MAGIAY = giay.MAGIAY AND SDT = '$getSDT'");
                    $query_count = mysqli_num_rows($query);
                    $query_false = mysqli_query($conn, "SELECT * FROM giohang, giay, chitiet_giay WHERE giohang.MAGIAY = giay.MAGIAY AND chitiet_giay.MAGIAY = giay.MAGIAY AND SDT = '$getSDT' AND KIEMTRA = 0");
                    $query_count_false = mysqli_num_rows($query_false);
                    $query = mysqli_fetch_row($query);
                    $shoeName = $query[1];
                    $quantity = $query[2];
                    $size = $query[3];
                    $check = $query[5];
                ?>
                var check = <?php echo $query_count?>; 
                var checkFalse = <?php echo $query_count_false?>; 
                if (check == checkFalse){
                    swal({
                        title: "KHÔNG CÓ SẢN PHẨM NÀO ĐƯỢC CHỌN",
                        text: "",
                        icon: "warning",
                        closeOnClickOutside: false  
                    })
                }else{
                    var phone = "<?php echo $getSDT?>";
                    var shoe = "<?php echo $shoeName?>";
                    var size = "<?php echo $size?>";
                    var name = "<?php echo $name?>";
                    var quantity = <?php echo $quantity?>;

                    location.href = "checkout.php?username=" + name + "&size=" + size + "&quantity=" + quantity + "&checkBuy=" + 2;
                }
            })
        })
    </script>
    <main class="cartmain">
        <h1 class="cartTitle">SHOPPING CART</h1>
        <div class="cart">
            <div class="cartItems">
                <?php
                    $query = mysqli_query($conn, "SELECT * FROM giohang, giay, chitiet_giay WHERE giohang.MAGIAY = giay.MAGIAY AND chitiet_giay.MAGIAY = giay.MAGIAY AND SDT = '$getSDT' AND (KIEMTRA = 1 || KIEMTRA = 0)");
                    $count_row = mysqli_num_rows($query);
                    if ($count_row > 0){
                    while ($rowData=mysqli_fetch_assoc($query)) {
                        $arrImg = explode("|", $rowData['HINHANH']);
                        $size = $rowData['KICH_THUOC'];
                ?>
                    <div class="Items"> 
                        <img id="imageItem" src="../images/<?php echo $arrImg[0]?>" alt="shoe" style="min-width: 150px; margin-right: 20px;">
                        <div class="detail" style="display: flex; justify-content: space-between;">
                            <div class="context">
                                <h3><?php echo $rowData['MAGIAY']?></h3>
                                <h5><?php echo $rowData['MAU']?> | <?php echo $rowData['THELOAI']?></h5>
                                <p>
                                    <span>Size: <?php echo $rowData['KICH_THUOC']?></span>
                                    |
                                    <span>Quantity: <?php echo $rowData['SOLUONG']?></span>
                                </p>
                                <span>
                                    <i class="
                                    <?php 
                                        $shoe = $conn->real_escape_string($rowData['MAGIAY']);
                                        $query_fav = "SELECT * FROM yeuthich WHERE SDT = '$getSDT' AND MAGIAY = '$shoe'";
                                        $row_query = mysqli_num_rows(mysqli_query($conn, $query_fav));
                                        echo ($row_query == 1) ?  "fa-solid" : "fa-regular";
                                    ?>  
                                    fa-heart"></i>
                                    <?php
                                        $arrVal = [$rowData['SDT'], $rowData['MAGIAY'], $rowData['KICH_THUOC']];
                                    ?>
                                    <i style="cursor: pointer;" class="fa-solid fa-trash-can" id="<?php echo implode(',', $arrVal)?>"></i>
                                </span>
                            </div>
                            <div class="price">
                                <h3><?php echo number_format($rowData['GIATIEN'])?> VND</h3>
                                <?php
                                    $shoe = $conn->real_escape_string($rowData['MAGIAY']);
                                    $query_cart = "SELECT * FROM giohang WHERE SDT = '$getSDT' AND MAGIAY = '$shoe' AND KICH_THUOC = '$size'";
                                    $count_query = mysqli_num_rows(mysqli_query($conn, $query_cart));
                                    if ($count_query == 1){
                                        $query_check = mysqli_query($conn, "SELECT KIEMTRA FROM giohang WHERE SDT = '$getSDT' AND MAGIAY = '$shoe' AND KICH_THUOC = '$size'");
                                        $query_check = mysqli_fetch_row($query_check);
                                        $check = $query_check[0];
                                    }
                                    // $arr = [$rowData['MAGIAY'], $rowData['KICH_THUOC']];
                                    echo ($check == 0) ? "<i class='_check fa-regular fa-circle uncheck'></i>" : "<i class='_check fa-regular fa-circle-check checked'></i>";
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    }else{
                        echo "<h3 style='color: red; text-align: center'>Không có dữ liệu</h3>";
                    }
                ?>
                </div>
            <?php
                $query = mysqli_query($conn, "SELECT SUM(GIATIEN * SOLUONG) FROM giohang WHERE SDT = '$getSDT' AND KIEMTRA = 1");
                $query = mysqli_fetch_row($query);
                $getSumPrice = $query[0];
            ?>
            <div class="summary">
                <h3>Summary</h3>
                <div class="sumTotal" style="margin-bottom: 0px;">
                    <h4>Subtotal</h4>
                    <h4 id="Total" value="<?php echo number_format(($getSumPrice != NULL) ? $getSumPrice : 0)?>"><?php echo number_format(($getSumPrice != NULL) ? $getSumPrice : 0)?> VND</h4>
                </div>
                <div class="sumTotal" style="margin-top: 0px;">
                    <h4>Estimated Delivery & Handling</h4>
                    <h4 id="deliverPrice">10,000 VND</h4>
                </div>
                <hr>
                <div class="sumTotal">
                    <h3>Total</h3>
                    <h3 id="sum"></h3>
                </div>
                <button type="submit" class="checkout">
                    <p>CHECK OUT</p>
                </button>
            </div>
        </div>
    </main>
   
</body>
<script src="../app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</html>