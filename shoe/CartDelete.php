<?php
    require "../connect.php";

    if (isset($_POST['phone']) && isset($_POST['shoename']) && isset($_POST['size'])){
        $phone = $_POST['phone'];
        $shoename = $_POST['shoename'];
        $size = $_POST['size'];

        $conn->query("DELETE FROM giohang WHERE SDT = '$phone' AND MAGIAY = '$shoename' AND KICH_THUOC = '$size'");
    }
?>