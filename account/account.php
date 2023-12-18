<?php
    require '../connect.php';
    session_start();
    if (isset($_SESSION['username'])){
        $getUser = $_SESSION['username'];
        $query = mysqli_query($conn, "SELECT * FROM khachhang WHERE TEN = '$getUser'");
        $query = mysqli_fetch_row($query);
        $getPass = $query[1];
        $getPhone = $query[0];
        $getEmail = $query[4];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="./fontawesome-free-6.3.0-web/fontawsome/css/all.min.css"
    />
    <link rel="stylesheet" href="./account.css">
    <link rel="stylesheet" href="../login-register/login.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap"
      rel="stylesheet"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
    <script>
        $(document).ready(function(){
            $("svg").click(function(){
                var html = $(".pass p").html();
                var strLen = html.length;
                var char = "*";
                var cnt = 0;
                for (let i=0; i< html.length; i++){
                    if (html[i] == char){
                        cnt+=1;
                    }
                }
                if (strLen == cnt){
                    var pass = $(".pass").attr('id');
                    $(".pass p").html(pass);
                    cnt = 0;
                }else{
                    $(".pass p").html(html.split('').map(()=>"*").join(''));
                    cnt = 0;
                }
            }) 
        })
    </script>
    <main class="account" style="margin: -20px;">
        <h1>Account</h1>
        <div class="content">
            <div class="inputBox acc">
                <p>Phone Number:</p>
                <span style="margin-left: 20px;"><?php echo $getPhone?></span>
            </div>
            <div class="inputBox acc">
                <p>Full Name:</p>
                <span style="margin-left: 20px;"><?php echo $getUser?></span>
            </div>
            <div class="inputBox acc">
                <p>Email:</p>
                <span style="margin-left: 20px;"><?php echo $getEmail?></span>
            </div>
            <div class="inputBox acc">
                <p>Password:</p>
                <div id="<?php echo $getPass?>" class="stg pass">
                    <p><?php
                        $query = mysqli_query($conn, "SELECT MATKHAU FROM khachhang WHERE SDT = '$getPhone'");
                        $query = mysqli_fetch_row($query);
                        $getPass = $query[0];
                        $len = strlen($getPass);
                        $charSecure = "*";
                        $stringSecure = "";
                        for ($i=0; $i< $len; $i++){
                            $stringSecure .= $charSecure;
                        }
                        echo $stringSecure;
                    ?></p>
                </div>
                <svg style="cursor: pointer;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
            </div>
            <div class="inputBox acc">
                <p>Address:</p>
                <div class="stg">
                    <p><?php
                        $query = mysqli_query($conn, "SELECT DIACHI FROM khachhang WHERE SDT = '$getPhone'");
                        $query = mysqli_fetch_row($query);
                        $getAddress = $query[0];
                        echo $getAddress;
                    ?></p>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="../app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</html>