<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/store.png" alt="">
      </div>

      <div class="content">
         <h3>Mengapa Memilih Kami?</h3>
         <p>Apotek SehatPlus adalah apotek online terpercaya yang bertujuan untuk memberikan akses yang mudah ke obat-obatan berkualitas tinggi dan produk kesehatan. Kami berkomitmen untuk memberikan layanan yang luar biasa dan menjamin kepuasan pelanggan. Dengan berbagai produk yang tersedia, kami berusaha memenuhi semua kebutuhan kesehatan dan kesejahteraan Anda.</p>
         <a href="contact.php" class="btn">Hubungi Kami</a>
      </div>

   </div>

</section>

<section class="reviews">
   
   <h1 class="heading">Ulasan Pelanggan</h1>

   <div class="swiper reviews-slider">

   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <img src="images/pic-1.png" alt="">
         <p>Website apotek ini sangat membantu dalam memenuhi kebutuhan obat-obatan saya. Pelayanan yang diberikan juga sangat baik dan responsif. Saya sangat puas dengan pengalaman berbelanja di sini.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>John Doe</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-2.png" alt="">
         <p>Saya merasa sangat terbantu dengan adanya website ini. Proses pembelian obat sangat mudah dan pengiriman juga cepat. Produk yang dijual juga lengkap dan berkualitas. Saya sangat merekomendasikan.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Jane Smith</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-3.png" alt="">
         <p>Saya sangat senang menemukan website ini. Semua kebutuhan kesehatan saya tersedia di sini. Informasi produk yang detail dan proses pembelian yang mudah membuat pengalaman belanja saya menjadi menyenangkan.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Michael Johnson</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-4.png" alt="">
         <p>Pelayanan pelanggan yang ramah dan profesional membuat saya merasa nyaman berbelanja di sini. Produk yang dijual juga berkualitas tinggi. Saya sangat puas dengan semua yang ditawarkan oleh website ini.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Sarah Lee</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/pic-5.png" alt="">
         <p>Website apotek ini merupakan tempat terbaik untuk membeli obat secara online. Proses pembelian yang mudah dan harga yang terjangkau. Saya sangat puas dengan pengalaman belanja di sini.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>David Williams</h3>
      </div>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>