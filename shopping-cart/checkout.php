<?php
    require "../connect.php";
    session_start();
    if (isset($_COOKIE['username'])){
        $name = $_COOKIE['username'];
        $query = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$name'");
        $query = mysqli_fetch_row($query);
        $getSDT = $query[0];
    }

    if (isset($_GET['username']) && isset($_GET['size']) && isset($_GET['quantity']) && isset($_GET['checkBuy'])){
        $username = $_GET['username'];
        $size = $_GET['size'];
        $quantity = $_GET['quantity'];
        $checkBuy = $_GET['checkBuy'];

        $query = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$username'");
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
    <script>
        $(document).ready(function(){
            var contHtml = $("#Total").html();
            var getPrice = contHtml.split(" ");
            var intPrice = parseInt(getPrice[0].replace(/,/g, ""), 10);

            var PriceDeliver = $("#deliverPrice").html();
            var PriceDeliver = PriceDeliver.split(" ");
            var PriceDeliver = parseInt(PriceDeliver[0].replace(/,/g, ""), 10);

            $("#sum").html((intPrice + PriceDeliver).toLocaleString('en-US') + " VND");

            $("#order_btn").click(function(){
                var name = $("#fullName").val();
                var city = $("#city").val();
                var district = $("#district").val();
                var ward = $("#ward").val();
                var address = $("#address").val();
                var phone = $("#phone").val();
                var regexPhone = /((09|03|07|08|05|02)+([0-9]{8})\b)/g;
                var check = <?php echo $checkBuy?>;

                var bankMethod = $("#bank").find(":selected").text();
                if (name == "" || city == "" || district == "" || ward == "" || address == "" || phone == ""){
                    swal("Register Failure!", "Hãy điền đầy đủ thông tin!", "warning");
                }else{
                    if (regexPhone.test(phone)){
                        $.ajax({
                            url: "order.php",
                            type: "POST",
                            data: {
                                name: name, 
                                city: city, 
                                district: district, 
                                ward: ward, 
                                address: address,
                                phone: phone,
                                bankMethod: bankMethod,
                                check: check,
                            },
                            success: function(data){
                                swal({
                                    title: "CONGRATULATIONS!",
                                    text: "ĐẶT HÀNG THÀNH CÔNG",
                                    icon: "success",
                                    closeOnClickOutside: false  
                                })
                                .then(() => {
                                    location.href = "shipping.php";
                                })
                            }
                        })
                    }else{
                        swal("Checkout Failure!", "Số điện thoại không đúng định dạng", "warning");
                    } 
                }
            });
        })
    </script>
    <main class="cartmain">
        <div class="cartcheckout">
            <div class="addressInfo">
                <h1>ENTER YOUR NAME AND ADDRESS</h1>
                <div class="inputBox">
                    <input type="text" placeholder="Full Name" id="fullName">
                    <input type="text" placeholder="City/Province" id="city">
                    <input type="text" placeholder="District" id="district">
                    <input type="text" placeholder="Ward" id="ward">
                    <input type="text" placeholder="Address" id="address">
                    <input type="text" placeholder="Phone Number" id="phone">
                </div>
                <div class="payMethod">
                    <h3>PAYMENT METHOD</h3>
                    <label>
                        <i class="fa-solid fa-caret-down"></i>
                        <select id="bank">
                            <option>COD</option>
                            <option>BANK TRANSFER</option>
                            <option>CREDIT CARD</option>
                        </select>
                    </label>
                </div>
                <button type="submit" id="order_btn"><p>ORDER</p></button>
            </div>
                <div class="orderSummary">
                    <?php
                        if ($checkBuy == 2){
                            $query = mysqli_query($conn, "SELECT SUM(GIATIEN * SOLUONG) FROM giohang WHERE SDT = '$getSDT' AND KIEMTRA = 1");
                            $query = mysqli_fetch_row($query);
                            $getSumPrice = $query[0];
                    ?>
                    <h3>ORDER SUMMARY</h3>
                    <div class="summary">
                        <h3>Summary</h3>
                        <div class="sumTotal" style="margin-bottom: 10px;">
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
                    </div>
                    <div class="cartItems">
                        <?php
                            $query = mysqli_query($conn, "SELECT * FROM giohang, giay, chitiet_giay WHERE giohang.MAGIAY = giay.MAGIAY AND chitiet_giay.MAGIAY = giay.MAGIAY AND SDT = '$getSDT' AND KIEMTRA = 1");
                            while ($rowData=mysqli_fetch_assoc($query)) {
                                $arrImg = explode("|", $rowData['HINHANH']);
                                $size = $rowData['KICH_THUOC'];
                        ?>
                            <div class="Items"> 
                                <img id="imageItem" src="../images/<?php echo $arrImg[0]?>" alt="shoe" style="margin-right: 10px; min-width: 150px">
                                <div class="detail">
                                    <div class="context">
                                        <h3 style="margin-bottom: 20px;"><?php echo $rowData['MAGIAY']?></h3>
                                        <h5 style="margin-bottom: 20px;"><?php echo $rowData['MAU']?> | <?php echo $rowData['THELOAI']?></h5>
                                        <p>
                                            <span>Size: <?php echo $rowData['KICH_THUOC']?></span>
                                            |
                                            <span>Quantity: <?php echo $rowData['SOLUONG']?></span>
                                        </p>
                                    </div>
                                    <div class="price">
                                        <h3><?php echo number_format($rowData['GIATIEN'])?> VND</h3>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                            }else{
                                    $query = mysqli_query($conn, "SELECT SUM(GIATIEN) FROM giohang WHERE SDT = '$getSDT' AND KIEMTRA = 2");
                                    $query = mysqli_fetch_row($query);
                                    $getSumPrice = $query[0];
                                ?>
                                <h3>ORDER SUMMARY</h3>
                                <div class="summary">
                                    <h3>Summary</h3>
                                    <div class="sumTotal" style="margin-bottom: 10px;">
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
                                </div>
                                <div class="cartItems">
                                <?php
                                    $query = mysqli_query($conn, "SELECT * FROM giohang, giay, chitiet_giay WHERE giohang.MAGIAY = giay.MAGIAY AND chitiet_giay.MAGIAY = giay.MAGIAY AND SDT = '$getSDT' AND KIEMTRA = 2");
                                    while ($rowData=mysqli_fetch_assoc($query)) {
                                        $arrImg = explode("|", $rowData['HINHANH']);
                                        $size = $rowData['KICH_THUOC'];
                                ?>
                                    <div class="Items"> 
                                        <img id="imageItem" src="../images/<?php echo $arrImg[0]?>" alt="shoe">
                                        <div class="detail">
                                            <div class="context">
                                                <h3 style="margin-bottom: 20px;"><?php echo $rowData['MAGIAY']?></h3>
                                                <h5 style="margin-bottom: 20px;"><?php echo $rowData['MAU']?> | <?php echo $rowData['THELOAI']?></h5>
                                                <p>
                                                    <span>Size: <?php echo $rowData['KICH_THUOC']?></span>
                                                    |
                                                    <span>Quantity: <?php echo $rowData['SOLUONG']?></span>
                                                </p>
                                            </div>
                                            <div class="price">
                                                <h3><?php echo number_format($rowData['GIATIEN'])?> VND</h3>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>
                            <?php
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