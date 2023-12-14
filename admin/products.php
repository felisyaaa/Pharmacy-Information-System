<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['add_product'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/' . $image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/' . $image_02;

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/' . $image_03;


   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if ($select_products->rowCount() > 0) {
      $message[] = 'Product name already exists!';
   } else {

      $insert_products = $conn->prepare("INSERT INTO `products`(name, category, details, price, image_01, image_02, image_03) VALUES(?,?,?,?,?,?,?)");
      $insert_products->execute([$name, $category, $details, $price, $image_01, $image_02, $image_03]);

      if ($insert_products) {
         if ($image_size_01 > 2000000 || $image_size_02 > 2000000 || $image_size_03 > 2000000) {
            $message[] = 'Image size is too large!';
         } else {
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'New product added!';
         }
      }
   }
}

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/' . $fetch_delete_image['image_01']);
   unlink('../uploaded_img/' . $fetch_delete_image['image_02']);
   unlink('../uploaded_img/' . $fetch_delete_image['image_03']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:products.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>


   <section class="add-products">

      <h1 class="heading">Tambah Produk</h1>

      <form action="" method="post" enctype="multipart/form-data">
         <div class="flex">
            <div class="inputBox">
               <span>Nama Produk (required)</span>
               <input type="text" class="box" required maxlength="100" placeholder="Isi Nama Produk" name="name">
            </div>
            <div class="inputBox">
               <span>Kategori (required)</span>
               <input type="text" class="box" required maxlength="100" placeholder="Isi Kategori Produk" name="category">
            </div>
            <div class="inputBox">
               <span>Harga Produk (required)</span>
               <input type="number" min="0" class="box" required max="9999999999" placeholder="Isi Harga Produk" onkeypress="if(this.value.length == 10) return false;" name="price">
            </div>
            <div class="inputBox">
               <span>image 01 (required)</span>
               <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
               <span>image 02 (required)</span>
               <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
               <span>image 03 (required)</span>
               <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
               <span>Detail Produk (required)</span>
               <textarea name="details" placeholder="Isi Detai Produk" class="box" required maxlength="500" cols="30" rows="10"></textarea>
            </div>
         </div>

         <input type="submit" value="add product" class="btn" name="add_product">
      </form>

   </section>

   <section class="show-products">

      <h1 class="heading">Produk</h1>

      <div class="box-container">

         <?php

         $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

         $select_total_products = $conn->prepare("SELECT COUNT(*) as total FROM `products`");
         $select_total_products->execute();
         $total_products = $select_total_products->fetch(PDO::FETCH_ASSOC)['total'];

         $limit = 6; // Jumlah produk per halaman
         $page = isset($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini
         $start = ($page - 1) * $limit; // Item awal untuk halaman saat ini

         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT $start, $limit");
         $select_products->execute();

         if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
         ?>

               <div class="box">
                  <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                  <div class="name"><?= $fetch_products['name']; ?></div>
                  <div class="category">
                     <p><?= $fetch_products['category']; ?></p>
                  </div>
                  <div class="price">Rp. <span><?= $fetch_products['price']; ?></span>/-</div>
                  <div class="details"><span><?= substr($fetch_products['details'], 0, 100); ?>...</span></div>

                  <div class="flex-btn">
                     <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
                     <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
                  </div>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
         ?>

      </div>

      <?php
$total_pages = ceil($total_products / $limit); // Jumlah total halaman
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini
$pagination_range = 3; // Jumlah halaman yang ditampilkan sebelum dan sesudah halaman saat ini
$start_range = max(1, $current_page - $pagination_range); // Batas awal halaman yang ditampilkan
$end_range = min($total_pages, $current_page + $pagination_range); // Batas akhir halaman yang ditampilkan
?>




      <script>
         function printData() {
            var searchQuery = '<?php echo $searchQuery; ?>';
            var printUrl = '../print.php?all=true';
            if (searchQuery) {
               printUrl += '&search=' + searchQuery;
            }
            window.location.href = printUrl;
         }
      </script>
      <div class="print-btn-container" style='float: right;'>
         <button class="btn" onclick="printData()">Print</button>
      </div>

      <div class="pagination" style="text-align: center; font-size: 20px; padding-top: 20px; ">
         <?php if ($current_page > 1) : ?>
            <a href="products.php?page=1">Sebelum</a>
         <?php endif; ?>

         <?php if ($current_page > 1) : ?>
            <a href="products.php?page=<?php echo $current_page - 1; ?>">&laquo;</a>
         <?php endif; ?>

         <?php for ($i = $start_range; $i <= $end_range; $i++) : ?>
            <?php if ($i == $current_page) : ?>
               <a class="active" href="products.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php else : ?>
               <a href="products.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
         <?php endfor; ?>

         <?php if ($current_page < $total_pages) : ?>
            <a href="products.php?page=<?php echo $current_page + 1; ?>">&raquo;</a>
         <?php endif; ?>

         <?php if ($current_page < $total_pages) : ?>
            <a href="products.php?page=<?php echo $total_pages; ?>">Sesudah</a>
         <?php endif; ?>
      </div>
   </section>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script>

   </script>


   <script src="../js/admin_script.js"></script>

</body>

</html>
