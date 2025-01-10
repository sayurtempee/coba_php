<?php
// Cek error keseluruhan
error_reporting(E_ALL);

include "connection.php";
session_start();
if (isset($_SESSION['login'])) {
   header('../crud/crud.php');
}

// Cek koneksi database
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

// Form handling
if (isset($_POST['submit'])) {
   $email = trim($_POST['email']);
   $password = trim($_POST['password']);

   // Validasi input
   if (empty($email) || empty($password)) {
      echo "<script>
         alert('Email dan Password harus diisi!');
         </script>";
   } else {
      // Cek email di database
      $stmt = $conn->prepare("SELECT password FROM login_siswa WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->store_result();

      // Jika email ditemukan
      if ($stmt->num_rows > 0) {
         $stmt->bind_result($hashed_password);
         $stmt->fetch();

         // Verifikasi password
         if (password_verify($password, $hashed_password)) {
            echo "<script>
               alert('Login berhasil!');
               window.location.href = './crud/crud.php'; // Redirect ke dashboard
               </script>";
         } else {
            echo "<script>
               alert('Password salah!');
               </script>";
         }
      } else {
         echo "<script>
            alert('Email tidak ditemukan!');
            </script>";
      }

      // Close statement
      $stmt->close();
   }
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="./asset/style.css">
   <link rel="shortcut icon" href="./img/logo71.png" type="image/x-icon">
   <title>Login</title>
</head>

<body>
   <h2>Login Form</h2>
   <form action="" method="post">
      <p> Email :
         <input type="text" name="email" placeholder="Masukkan Email" required>
      </p>
      <p> Password :
         <input type="password" name="password" placeholder="Masukkan Password" id="input-password" required>
         <label for="show-password">
            <input type="checkbox" id="show-password" name="show-password">
            Tampilkan Password
         </label>
      </p>
      <input type="submit" name="submit" value="Login">
      <input type="submit" value="lupa Password!!" onclick="window.location.href='forgotPassword.php'" style="color: blue;">
      <input type="submit" value="back" onclick="window.location.href='index.html'">
      <!-- <a href="signup.php">Silahkan SIGN UP</a> -->
      <!-- <a href="forgotPassword.php">Lupa Password!!</a> -->
   </form>
</body>

<script>
   // Logika untuk melihat password
   const inputPassword = document.getElementById("input-password");
   const showPassword = document.getElementById("show-password");

   showPassword.addEventListener("input", (e) => {
      if (e.target.checked) {
         inputPassword.setAttribute("type", "text");
      } else {
         inputPassword.setAttribute("type", "password");
      }
   });
</script>

</html>