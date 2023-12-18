<?php
    require '../connect.php';
    session_start();

    if (isset($_POST['btn_submit'])){
        if (isset($_POST['phone']) && isset($_POST['password'])){
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $query = "SELECT * FROM khachhang WHERE SDT = '$phone' AND MATKHAU = '$password'";
            $count_query = mysqli_num_rows(mysqli_query($conn, $query));
            if ($count_query != 0){
                $query = mysqli_query($conn, "SELECT TEN FROM khachhang WHERE SDT = '$phone' AND MATKHAU = '$password'");
                $query = mysqli_fetch_row($query);
                $getName = $query[0];

                $_SESSION['username'] = $getName;
                setcookie('checkSignin', 1, time() + (86400 * 30), "/");
            }else{
                setcookie('checkSignin', 2, time() + (86400 * 30), "/");
            }
        }
    }
    header("Location: signIn.php?username=".$getName);
?>