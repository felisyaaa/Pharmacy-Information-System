<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_orders->execute([$delete_id]);
   $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
   $delete_messages->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:users_accounts.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Akun Pengguna</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
   <style>
      .table-container {
         margin-top: 50px;
      }

      table {
         width: 100%;
         border-collapse: collapse;
         margin-bottom: 20px;
      }

      table th,
      table td {
         padding: 15px;
         text-align: left;
         border-bottom: 1px solid #ddd;
      }

      table th {
         background-color: #f2f2f2;
         font-size: 20px;
      }

      table td {
         font-size: 18px;
      }

      table tbody tr:nth-child(even) {
         background-color: #f9f9f9;
      }

      table tbody tr:hover {
         background-color: #f5f5f5;
      }

      .empty {
         text-align: center;
         margin: 20px;
         color: #999;
         font-size: 18px;
      }

      .delete-btn {
         color: #f2f2f2;
         cursor: pointer;
      }

      .delete-btn:hover {
         text-decoration: underline;
      }
   </style>

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="accounts">

      <h1 class="heading">Akun Pengguna</h1>

      <div class="table-container">

         <table>
            <thead>
               <tr>
                  <th>User ID</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $select_accounts = $conn->prepare("SELECT * FROM `users`");
               $select_accounts->execute();
               if ($select_accounts->rowCount() > 0) {
                  while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
                     echo "<tr>";
                     echo "<td>" . $fetch_accounts['id'] . "</td>";
                     echo "<td>" . $fetch_accounts['name'] . "</td>";
                     echo "<td>" . $fetch_accounts['email'] . "</td>";
                     echo "<td><a href=\"users_accounts.php?delete=" . $fetch_accounts['id'] . "\" onclick=\"return confirm('Delete this account? The user-related information will also be deleted!')\" class=\"delete-btn\">Delete</a></td>";
                     echo "</tr>";
                  }
               } else {
                  echo '<tr><td colspan="4" class="empty">No accounts available!</td></tr>';
               }
               ?>
            </tbody>
         </table>

      </div>

   </section>

   <script src="../js/admin_script.js"></script>

</body>

</html>