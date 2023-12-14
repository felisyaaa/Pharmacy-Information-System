<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="home-bg">

<section class="home">

   <div class="swiper home-slider">
   
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/obat-img-1.png" alt="">
         </div>
         <div class="content">
            <span>Dapatkan penawaran spesial</span>
            <h3>obat dan produk kesehatan terbaru</h3>
            <a href="shop.php" class="btn">Belanja sekarang</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/obat-img-3.png" alt="">
         </div>
         <div class="content">
            <span>Dapatkan diskon hingga 50%</span>
            <h3>Produk kesehatan terbaru</h3>
            <a href="shop.php" class="btn">Belanja sekarang</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/obat-img-2.png" alt="">
         </div>
         <div class="content">
         <span>Dapatkan diskon hingga 50%</span>
            <h3>Obat-obatan terbaru</h3>
            <a href="shop.php" class="btn">Beli sekarang</a>
         </div>
      </div>

   </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

</div>
<style>
   
</style>
<section class="category">

   <h1 class="heading">Belanja berdasarkan kategori</h1>

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <a href="category.php?category=obat" class="swiper-slide slide">
      <img src="images/medicine.png" alt="">
      <h3>Obat</h3>
   </a>

   <a href="category.php?category=perawatan kulit" class="swiper-slide slide">
      <img src="images/skin.png" alt="">
      <h3>Perawatan Kulit</h3>
   </a>

   <a href="category.php?category=perawatan rambut" class="swiper-slide slide">
      <img src="images/healthy-hair.png" alt="">
      <h3>Perawatan Rambut</h3>
   </a>

   <a href="category.php?category=Vitamin dan Suplemen" class="swiper-slide slide">
      <img src="images/supplement.png" alt="">
      <h3>Vitamin dan Suplemen</h3>
   </a>

   <a href="category.php?category=Alat Kesehatan" class="swiper-slide slide">
      <img src="images/oximeter.png" alt="">
      <h3>Alat Kesehatan</h3>
   </a>

   <a href="category.php?category=Perawatan Mata dan Telinga" class="swiper-slide slide">
      <img src="images/ear-dropper.png" alt="">
      <h3>Perawatan Mata dan Telinga</h3>
   </a>

   <a href="category.php?category=Perawatan Bayi dan Ibu Hamil" class="swiper-slide slide">
      <img src="images/maternity.png" alt="">
      <h3>Perawatan Bayi dan Ibu Hamil</h3>
   </a>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>

<section class="home-products">

   <h1 class="heading">Produk Terkini</h1>

   <div class="swiper products-slider">

   <div class="swiper-wrapper">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="swiper-slide slide">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="category" value="<?= $fetch_product['category']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="name"><h4><?= $fetch_product['category']; ?></h4></div>
      <div class="flex">
         <div class="price"><span>$</span><?= $fetch_product['price']; ?><span>/-</span></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});

var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>