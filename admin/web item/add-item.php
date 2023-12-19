<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../fontawesome-free-6.3.0-web/fontawsome/css/all.min.css" />
  <link rel="stylesheet" href="./web-item.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
  <style>
    input[type="submit"]:hover {
      background-color: #bbbfbc;
      cursor: pointer;
    }
  </style>
  <form class="add-item-container" id="uploadForm" enctype="multipart/form-data" action="insert_item.php" method="post">
    <!-- image container -->
    <!-- <form id="uploadForm" enctype="multipart/form-data" action="add-item.php" method="post"> -->
    <div class="image-container">
      <!-- add image button -->
      <div class="add-img-file">
        <!-- add main image -->
        <div class="add-box">
          <p>Chọn ảnh chính<b>*</b></p>
          <input type="file" id="imageInputMain" name="imageInputMain" accept="image/*" required />
          <button type="button" onclick="uploadImage()">Tải ảnh</button>
        </div>

        <!-- add side image -->
        <div class="add-box">
          <p>Chọn ảnh phụ<b>*</b></p>
          <input type="file" id="imageInputAside" name="imageInputSide[]" accept="image/*" multiple required />
          <button type="button" onclick="uploadImages()">Tải ảnh</button>
        </div>
      </div>

      <!-- main image preview -->
      <div class="preview-img" id="preview"></div>

      <!-- side image preview -->
      <aside id="aside"></aside>
    </div>

    <!-- item detail -->
    <div class="item-detail-container">
      <p>Thông tin của sản phẩm</p>
      <div class="input-box">
        <p>Tên sản phẩm<b>*</b> :</p>
        <input type="text" placeholder="Tên sản phẩm" name="name" required />
      </div>
      <div class="input-box">
        <p>Màu<b>*</b> :</p>
        <input type="text" placeholder="Màu" name="color" required />
      </div>
      <div class="input-box">
        <p>Loại<b>*</b> :</p>
        <input type="text" placeholder="Loại" name="type" required />
      </div>
      <div class="input-box">
        <p>Giá<b>*</b> :</p>
        <input type="text" placeholder="Giá" name="price" required />
      </div>
      <div class="input-box">
        <p>Hãng<b>*</b> :</p>
        <select name="brand">
          <option>NIKE</option>
          <option>ADIDAS</option>
          <option>BITIS</option>
          <option>VANS</option>
          <option>CONVERSE</option>
          <option>NEW BALANCE</option>
        </select>
      </div>
      <div class="input-box">
        <p>Thông tin liên quan<b>*</b> :</p>
        <textarea placeholder="Thông tin liên quan" name="related_info" required></textarea>
      </div>
      <input style="padding: 10px 20px; font-weight: bold" type="submit" value="Thêm sản phẩm" name="submit">
    </div>
  </form>
</body>
<script src="web-item.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</html>