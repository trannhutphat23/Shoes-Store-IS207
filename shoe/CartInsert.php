<?php
    require "../connect.php";

    if (isset($_POST['selectSize']) && isset($_POST['selectNum']) && isset($_POST['phone']) && isset($_POST['shoeName']) && isset($_POST['check'])){
        $size = $_POST['selectSize'];
        $amount = $_POST['selectNum'];
        $phone = $_POST['phone'];
        $shoeName = $_POST['shoeName'];
        $check = $_POST['check'];

        $query = mysqli_query($conn, "SELECT GIA FROM giay WHERE MAGIAY = '$shoeName'");
        $query = mysqli_fetch_row($query);
        $getPrice = $query[0];

        $price = $getPrice * $amount;

        $query_check = "SELECT * FROM giohang WHERE KIEMTRA = 2";
        $count_query_check = mysqli_num_rows(mysqli_query($conn, $query_check));
        if ($count_query_check >= 1){
            $conn-> query("DELETE FROM giohang WHERE KIEMTRA = 2");
        }

        if ($check == 2){
            $query = "SELECT * FROM giohang WHERE SDT = '$phone' AND MAGIAY = '$shoeName' AND KICH_THUOC = '$size'";
            $count_query = mysqli_num_rows(mysqli_query($conn, $query));
            if ($count_query >= 1){
                echo 2;
            }else{
                echo 1;
            }
        }

        $query = "SELECT * FROM giohang WHERE SDT = '$phone' AND MAGIAY = '$shoeName' AND KICH_THUOC = '$size'";
        $count_query = mysqli_num_rows(mysqli_query($conn, $query));
        if ($count_query == 0){
            $conn->query("INSERT INTO giohang VALUES ('$phone','$shoeName','$amount','$size', '$price', '$check')");
        }else{
            $conn->query("UPDATE giohang SET SOLUONG = SOLUONG + $amount WHERE SDT = '$phone' AND MAGIAY = '$shoeName' AND KICH_THUOC = '$size'");
        }
    }
?>