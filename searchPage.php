<?php
    require 'connect.php';
    session_start();

    if (isset($_GET['search'])){
        $searhValue = $_GET['search'];
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        rel="stylesheet"
        href="./fontawesome-free-6.3.0-web/fontawsome/css/all.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap"
      rel="stylesheet"
    />
    <title>Document</title>
</head>
<body>
    <style>
        *{
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            font-family: 'IBM Plex Sans', sans-serif;
        }
        main{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        h1{
           text-align: center; 
        }
        .homepage{
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .brand{
            width: 85%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0px 4px 4px 0px #00000026;
            border-radius: 10px;
            margin-bottom: 100px;
        }
        .shoeDisplay{
            width: 100%;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-evenly;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .shoes{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            margin-right: 20px;
            margin-bottom: 30px;
        }
        .imgContain{
            position: relative;
        }
        .img2{
            position: absolute;
            left: 0px;
            z-index: -1;
        }
        .img1{
            transition: 0.25s ease-in;
            &:hover{
                opacity: 0;
            }
        }
        img{
            width: 250px;
            height: 250px;
            margin-bottom: 10px;
        }
        h4{
            margin-top: 5px;
        }
        i{
            position: absolute;
            right: 0;
            margin: 10px;
            font-size: 20px;
            z-index: 3;
        }
    </style>
    <main>
        <h1>Tìm kiếm cho "<?php echo $searhValue?>"</h1>
        <div class="homepage">
            <div class="brand">
                <div class="shoeDisplay" style="max-width: 100%;">
                    <?php
                        $queryItem = mysqli_query($conn, "SELECT * FROM giay WHERE LOWER(MAGIAY) LIKE LOWER('%$searhValue%')"); 
                        $count_query = mysqli_num_rows($queryItem);
                        if ($count_query == 0){
                            echo "<h2 style='color: red'>Không có sản phẩm nào khớp</h2>";
                        }
                        while ($rowData=mysqli_fetch_assoc($queryItem)) {
                            $arrImg = explode("|", $rowData['HINHANH']);
                    ?>
                    <div class="shoes" style="max-width: 250px;" onclick="Shoe('<?php echo $conn->real_escape_string($rowData['MAGIAY'])?>')">
                        <div class="imgContain">
                            <i class="<?php 
                            $shoe = $conn->real_escape_string($rowData['MAGIAY']);
                            if (isset($_SESSION['username'])){
                                $name = $_SESSION['username'];
                                $query = mysqli_query($conn, "SELECT SDT FROM khachhang WHERE TEN = '$name'");
                                $query = mysqli_fetch_row($query);
                                $getSDT = $query[0];
                            }
                            $query_fav = "SELECT * FROM yeuthich WHERE SDT = '$getSDT' AND MAGIAY = '$shoe'";
                            $row_query = mysqli_num_rows(mysqli_query($conn, $query_fav));
                            echo ($row_query == 1) ?  "fa-solid" :  "fa-regular";
                        ?> fa-heart"></i>
                            <img src="../images/<?php echo ltrim($arrImg[0])?>" alt="shoes" class="img1">
                            <img src="../images/<?php echo ltrim($arrImg[1])?>" alt="shoes" class="img2">
                        </div>
                        <h4 style="height: 20px; margin-bottom: 20px; text-align: center;"><?php echo $rowData['MAGIAY']?></h4>
                        <p><?php echo number_format($rowData['GIA'])?> đ</p>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="../app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</html>