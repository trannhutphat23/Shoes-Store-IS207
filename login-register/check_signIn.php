<?php
    require '../connect.php';
    session_start();
    if (isset($_POST['phone']) && isset($_POST['password'])){
        $check = 1;
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $query = "SELECT * FROM khachhang WHERE SDT = '$phone' AND MATKHAU = '$password'";
        $count_query = mysqli_num_rows(mysqli_query($conn, $query));
        if ($count_query == 0){
            $check = 0;
            echo $check;
        }
        else {
            $check = 1;
            $query = mysqli_query($conn, "SELECT TEN FROM khachhang WHERE SDT = '$phone' AND MATKHAU = '$password'");
            $query = mysqli_fetch_row($query);
            $getName = $query[0];
            $_SESSION['username'] = $getName;
            $_SESSION['checkSignin'] = 1;
            echo $check;
        }
    }
?>