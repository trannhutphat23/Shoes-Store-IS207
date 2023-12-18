<?php
    require '../connect.php';
    session_start();
    if (isset($_COOKIE['checkSignin'])){
        $check = $_COOKIE['checkSignin'];
    }
    if (isset($_GET['username'])){
        $username = $_GET['username'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./login.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./fontawesome-free-6.3.0-web/fontawsome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Login</title>
</head>
<body>
    <script>
        $(document).ready(function(){
            var check = <?php echo $check?>;
            var getUser = "<?php echo $username?>";
            if (check == 1){
                swal({
                    title: "CONGRATULATIONS!",
                    text: "ĐĂNG NHẬP THÀNH CÔNG",
                    icon: "success",
                    closeOnClickOutside: false  
                })
                .then(() => {
                    $.ajax({
                        url: "../index.php",
                        type: "POST",
                        data: {USER: getUser},
                        success: function(data){
                            Login();
                            SignIn();
                        }
                    })
                })
                .catch(() => {
                    console.log("error");
                })
            }else if (check == 2){
                swal("Login Failure!", "SỐ ĐIỆN THOẠI HOẶC MẬT KHẨU KHÔNG CHÍNH XÁC", "warning");
            }
        })
    </script>
    <main>
        <h1>webbangiay</h1>
        <form action="signin_form.php" method="POST">
            <div class="inputBox">
                <input type="text" placeholder="PHONE NUMBER" name="phone" id="phone" required>
                <input type="password" placeholder="PASSWORD" name="password" id="password" required>
            </div>
            <button type="submit" name="btn_submit" id="signIn_btn" style="margin-left: 27%;"><p>SIGN IN</p></button>
        </form>
    </main>
</body>
<script src="../app.js"></script>
<script src="./login.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</html>