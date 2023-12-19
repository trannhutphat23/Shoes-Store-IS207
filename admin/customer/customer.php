<?php
  require "../../connect.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="../../fontawesome-free-6.3.0-web/fontawsome/css/all.min.css"
    />
    <link rel="stylesheet" href="./customer.css" />
    <title>Document</title>
  </head>
  <body>
    <div class="customer-container">
      <h1>DANH SÁCH KHÁCH HÀNG</h1>

      <div class="advance">
        <div class="search">
          <input type="text" placeholder="Tìm kiếm..." />
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
      </div>

      <table>
        <thead>
          <tr>
            <th style="width: 8%">STT<i class="fa-solid fa-sort"></i></th>
            <th style="width: 12%">Tên<i class="fa-solid fa-sort"></i></th>
            <th style="width: 15%">
              Số điện thoại<i class="fa-solid fa-sort"></i>
            </th>
            <th style="width: 25%">Email<i class="fa-solid fa-sort"></i></th>
            <th style="width: 20%">
              Địa chỉ<i class="fa-solid fa-sort"></i>
            </th>
            <th style="width: 20%">Ngày sinh<i class="fa-solid fa-sort"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php
            $i=0;
            $query = mysqli_query($conn, "SELECT * FROM khachhang");
            while ($rowData = mysqli_fetch_assoc($query)) {
              $i++;
          ?>
            <tr onclick="GoToCustomerDetail()">
              <td><p><?php echo $i?></p></td>
              <td><p><?php echo $rowData['TEN']?></p></td>
              <td><p><?php echo $rowData['SDT']?></p></td>
              <td>
                <p><?php echo $rowData['EMAIL']?></p>
              </td>
              <td><p><?php echo $rowData['DIACHI']?></p></td>
              <td><p><?php echo $rowData['NGAYSINH']?></p></td>
            </tr>
          <?php
            }
          ?>
        </tbody>
      </table>
    </div>
  </body>
  <script src="./customer.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</html>
