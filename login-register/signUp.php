<?php
    require '../connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./login.css">
    <link rel="stylesheet" href="../fontawesome-free-6.3.0-web/fontawsome/css/all.min.css">
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
            $("#sub_btn").click(function(){
                var phone = $("input[name='phone']").val();
                var regexPhone = /((09|03|07|08|05|02)+([0-9]{8})\b)/g;
                var password = $("input[name='password']").val();
                var cf_password = $("input[name='confirm_password']").val();
                var name = $("input[name='name']").val();
                var email = $("input[name='email']").val();
                var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                var birthday = $("input[name='birthday']").val();
                var inputDate = new Date(birthday);
                var now = new Date();
                var address = $("input[name='address']").val();
                if (phone == "" || password == "" || cf_password == "" || name == "" || birthday == "" || address == "" || email == ""){
                    swal("Register Failure!", "Hãy điền đầy đủ thông tin!", "warning");
                }else if (inputDate > now){
                    swal("SignUp Failure!", "Ngày không được lớn hơn ngày hiện tại", "warning");
                }else{
                    if(regex.test(email) && regexPhone.test(phone)) {
                        if (password == cf_password) {
                            $("#error-text").html("");
                            $("input[name='confirm_password']").css({"border":"1px solid black"})
                            $.ajax({
                                url: "./check_signUp.php",
                                type: "POST",
                                data: {phone: phone, password: password, name: name, birthday: birthday, address: address, email: email},
                                success: function(data){
                                    if (data == 1){
                                        swal("CONGRATULATIONS!", "YOUR ACCOUNT HAS BEEN SUCCESFULLY CREATED", "success");
                                        let asyn = setTimeout(function(){
                                            cancelNoti();
                                            clearTimeout(asyn);
                                        },1000)
                                    }else{
                                        swal("SignUp Failure!", "Số điện thoại đã được sử dụng", "warning");
                                    }
                                }
                            });
                        }else{
                            $("input[name='confirm_password']").css({"border":"2px solid red"})
                            $("#error-text").html("Password không trùng nhau!!");
                            $("#error-text").css({"color":"red","margin-bottom":"15px"});
                        }
                    }else{
                        if (regex.test(email)==false){
                            swal("SignUp Failure!", "Email không đúng định dạng", "warning");
                        }
                        else if (regexPhone.test(phone)==false){
                            swal("SignUp Failure!", "Số điện thoại không đúng định dạng", "warning");
                        }
                    }
                }     
            });
        });
    </script>
    <main class="first" id="first header">
        <h1>webbangiay</h1>
        <div class="inputBox">
            <input type="text" placeholder="PHONE NUMBER" name="phone" required>
            <input type="password" placeholder="PASSWORD" name="password" required>
            <input type="password" placeholder="CONFIRM PASSWORD" name="confirm_password" required>
            <input type="text" placeholder="NAME" name="name" required>
            <input type="text" placeholder="EMAIL" name="email" required>
            <input type="date" placeholder="BIRTHDAY" name="birthday" min="1997-01-01" max="2099-12-31" required>
            <input type="text" placeholder="ADDRESS" name="address" required>
        </div>
        <div id="error-text"></div>
        <button type="submit" id="sub_btn" name="submit"><p>NEXT</p> </button>
    </main>
</body>
<script src="../app.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</html>
