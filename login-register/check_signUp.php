<?php
    require '../connect.php';
    // session_start();
    
    if (isset($_POST['phone']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['birthday']) && isset($_POST['address']) && isset($_POST['email'])){
        $phone = $_POST['phone'];

        $query = "SELECT * FROM khachhang WHERE SDT = '$phone'";
        $count_query = mysqli_num_rows(mysqli_query($conn, $query));

        $password = $_POST['password'];
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        if ($count_query == 1){
            echo 0;
        }else{
            $conn->query("INSERT INTO khachhang VALUES ('$phone','$password','$address','$name','$email','$birthday')");
            $conn->close();
            echo 1;
        }
    }
?>