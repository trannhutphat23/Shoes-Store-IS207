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
    <link rel="stylesheet" href="./order.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Document</title>
  </head>
  <body>
    <div class="order-container" id="unprocess">
      <h1>ĐƠN CHƯA XỬ LÝ</h1>

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
            <th style="width: 12%">Mã đơn<i class="fa-solid fa-sort"></i></th>
            <th style="width: 15%">
              Số điện thoại<i class="fa-solid fa-sort"></i>
            </th>
            <th style="width: 35%">Đơn hàng<i class="fa-solid fa-sort"></i></th>
            <th style="width: 20%">
              Tổng cộng<i class="fa-solid fa-sort"></i>
            </th>
            <th style="width: 10%"></th>
          </tr>
        </thead>
        <tbody>
          <?php
            $i=0;
            $query = mysqli_query($conn, "SELECT donhang.MADON AS MADON, donhang.SDT AS SDT, REPLACE(GROUP_CONCAT(DISTINCT TENGIAY), ',', '\n') as GIAY , REPLACE(GROUP_CONCAT(DISTINCT SOLUONG), ',', '\n') as SL, SUM(THANHTIEN) AS TONG FROM donhang, chitiet_donhang WHERE donhang.MADON = chitiet_donhang.MADON AND TINHTRANG = 'SHIPPING' GROUP BY donhang.MADON");
            while ($rowData = mysqli_fetch_assoc($query)) {
              $i++;
          ?>
            <tr>
              <td><p><?php echo $i?></p></td>
              <td><p><?php echo $rowData['MADON']?></p></td>
              <td><p><?php echo $rowData['SDT']?></p></td>
              <td>
                <ol>
                  <li>
                    <p style="text-align: left; padding: 10px"><?php echo $rowData['GIAY']."\n"?></p>
                    <p><?php echo $rowData['SL']."\n"?></p>
                  </li>
                </ol>
              </td>
              <td><p><?php echo number_format($rowData['TONG'])?> VNĐ</p></td>
              <td>
                <button class="delBtn" id="unprocessed" value=<?php echo $rowData['MADON']?>>
                  <p>Xóa</p>
                </button>
              </td>
            </tr>
          <?php
            }
          ?>
        </tbody>
      </table>
    </div>
  </body>
  <script src="./order.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</html>
