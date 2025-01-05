<?php
// Cek error keseluruhan
error_reporting(E_ALL);

include "connection.php";

// Cek koneksi database
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

$showResetForm = false; // Untuk menampilkan form reset password jika email valid
$email = ""; // Default email

// Cek jika form submit (input email)
if (isset($_POST['check_email'])) {
   $email = trim($_POST['email']);

   // Validasi input email
   if (empty($email)) {
      echo "<script>
         alert('Harap masukkan email Anda!');
      </script>";
   } else {
      // Cek email di database
      $stmt = $conn->prepare("SELECT email FROM login_siswa WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
         // Email ditemukan
         $showResetForm = true;
      } else {
         echo "<script>
            alert('Email tidak ditemukan!');
         </script>";
      }

      // Close statement
      $stmt->close();
   }
}

// Reset password jika form reset dikirim
if (isset($_POST['reset_password'])) {
   $new_password = trim($_POST['new_password']);
   $confirm_password = trim($_POST['confirm_password']);
   $email = trim($_POST['email']);

   // Validasi password
   if (empty($new_password) || empty($confirm_password)) {
      echo "<script>
         alert('Semua field password harus diisi!');
      </script>";
   } elseif ($new_password !== $confirm_password) {
      echo "<script>
         alert('Password dan konfirmasi password tidak cocok!');
      </script>";
   } else {
      // Hash password baru
      $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

      // Update password di database
      $stmt = $conn->prepare("UPDATE login_siswa SET password = ? WHERE email = ?");
      $stmt->bind_param("ss", $hashed_password, $email);

      if ($stmt->execute()) {
         echo "<script>
            alert('Password berhasil direset! Silakan login dengan password baru.');
            window.location.href = 'login.php';
         </script>";
      } else {
         echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
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
   <link rel="icon" type="image/svg+xml" href="./img/akatsuki.png">
   <title>Forgot Password</title>
</head>

<body>
   <h2>Lupa Password</h2>

   <?php if (!$showResetForm) : ?>
      <!-- Form untuk cek email -->
      <form action="" method="post">
         <p>Masukkan Email Anda:
            <input type="email" name="email" placeholder="Email" required>
         </p>
         <input type="submit" name="check_email" value="Cek Email">
         <input type="submit" value="back" onclick="window.location.href='login.php'">
      </form>
   <?php else : ?>
      <!-- Form reset password -->
      <form action="" method="post">
         <p>Email:
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
         </p>
         <p>Password Baru:
            <input type="password" name="new_password" placeholder="Password Baru" required>
         </p>
         <p>Konfirmasi Password:
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
         </p>
         <input type="submit" name="reset_password" value="Reset Password">
      </form>
   <?php endif; ?>

</body>
</html>