<?php
    require "../connect.php";

    if (isset($_POST['phone']) && isset($_POST['shoeName']) && isset($_POST['size'])){
        $phone = $_POST['phone'];
        $shoeName = $_POST['shoeName'];
        $size = $_POST['size'];

        $query = mysqli_query($conn, "SELECT KIEMTRA FROM giohang WHERE SDT = '$phone' AND MAGIAY = '$shoeName' AND KICH_THUOC = '$size'");
        $query = mysqli_fetch_row($query);
        $Check = $query[0];
        if ($Check == 0){
            $conn->query("UPDATE giohang SET KIEMTRA = 1 WHERE SDT = '$phone' AND MAGIAY = '$shoeName' AND KICH_THUOC = '$size'");
        }else{
            $conn->query("UPDATE giohang SET KIEMTRA = 0 WHERE SDT = '$phone' AND MAGIAY = '$shoeName' AND KICH_THUOC = '$size'");
        }
    }
?>