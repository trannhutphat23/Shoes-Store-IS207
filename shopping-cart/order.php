<?php
    require "../connect.php";
    session_start();
    if (isset($_POST['name']) && isset($_POST['city']) && isset($_POST['district']) && isset($_POST['ward']) && isset($_POST['address']) && isset($_POST['phone']) && isset($_POST['bankMethod']) && isset($_POST['check'])){
        $name = $_POST['name'];
        $city = $_POST['city'];
        $district = $_POST['district'];
        $ward = $_POST['ward'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $bankMethod = $_POST['bankMethod'];
        $check = $_POST['check'];
        echo $check;

        $codeOrder = rand(10000000, 99999999);
        if (isset($_SESSION['username'])){
            $name = $_SESSION['username'];
            $query = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$name'");
            $query = mysqli_fetch_row($query);
            $getSDT = $query[0];
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $orderDay = date('Y-m-d', time());
        $shipDay = date('Y-m-d', time()+ (24 * 60 * 60)*5);
        $conn->query("INSERT INTO donhang VALUE('$codeOrder', '$getSDT', 'SHIPPING', '$orderDay', '$shipDay', '$bankMethod')");

        if ($check == 1){
            $query = mysqli_query($conn, "SELECT * FROM giohang, giay, chitiet_giay WHERE giohang.MAGIAY = giay.MAGIAY AND chitiet_giay.MAGIAY = giay.MAGIAY AND SDT = '$getSDT' AND KIEMTRA = 2");
            while ($rowData=mysqli_fetch_assoc($query)) {
                $shoeNameID = $rowData['MAGIAY'];
                $size = $rowData['KICH_THUOC'];
                $shoename = $rowData['TENGIAY'];
                $color = $rowData['MAU'];
                $price = $rowData['GIA'];
                $amount = $rowData['SOLUONG'];
                $sum = $price*$amount;

                $conn->query("INSERT INTO chitiet_donhang VALUE('$codeOrder', '$shoeNameID', '$size', '$shoename', '$color', '$price', '$amount', '$sum', '$name', '$phone', '$address', '$city', '$district', '$ward')");
            }
        }else{
            $query = mysqli_query($conn, "SELECT * FROM giohang, giay, chitiet_giay WHERE giohang.MAGIAY = giay.MAGIAY AND chitiet_giay.MAGIAY = giay.MAGIAY AND SDT = '$getSDT' AND KIEMTRA = 1");
            while ($rowData=mysqli_fetch_assoc($query)) {
                $shoeNameID = $rowData['MAGIAY'];
                $size = $rowData['KICH_THUOC'];
                $shoename = $rowData['TENGIAY'];
                $color = $rowData['MAU'];
                $price = $rowData['GIA'];
                $amount = $rowData['SOLUONG'];
                $sum = $price*$amount;
    
                $conn->query("INSERT INTO chitiet_donhang VALUE('$codeOrder', '$shoeNameID', '$size', '$shoename', '$color', '$price', '$amount', '$sum', '$name', '$phone', '$address', '$city', '$district', '$ward')");
            }
        }
        $conn -> query("DELETE FROM giohang WHERE SDT = '$getSDT' AND KIEMTRA = 1");
    }
?>