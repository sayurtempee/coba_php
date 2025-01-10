<?php
// Cek error keseluruhan
error_reporting(E_ALL);

include "connection.php";

// Cek koneksi
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

// Form handling
if (isset($_POST['submit'])) {
   $email = trim($_POST['email']);
   $name = trim($_POST['username']);
   $password = trim($_POST['password']);

   // Validasi input
   if (empty($email) || empty($name) || empty($password)) {
      die("Semua field harus diisi!");
   }

   // Cek apakah email sudah ada di database
   $check_email_stmt = $conn->prepare("SELECT email FROM login_siswa WHERE email = ?");
   $check_email_stmt->bind_param("s", $email);
   $check_email_stmt->execute();
   $check_email_stmt->store_result();

   if ($check_email_stmt->num_rows > 0) {
      echo "<script>
        alert('Email sudah terdaftar, gunakan email lain!');
        </script>";
   } else {
      // Hash password
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      // Query untuk insert data
      $stmt = $conn->prepare("INSERT INTO login_siswa (email, username, password) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $email, $name, $hashed_password);

      // Eksekusi query
      if ($stmt->execute()) {
         echo "<script>
         alert('Data Berhasil Ditambahkan!');
         window.location.href = 'login.php'; // Redirect ke dashboard
         </script>";
      } else {
         echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
      }
      $stmt->close();
   }

   // Close statement
   $check_email_stmt->close();
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
   <title>SIGN UP</title>
</head>

<body>
   <h2>SIGN UP Form</h2>
   <form action="" method="post">
      <p> Email :
         <input type="text" name="email" placeholder="Masukan Email" required>
      </p>
      <p> Username :
         <input type="text" name="username" placeholder="Masukan Username" required>
      </p>
      <p> Password :
         <input type="password" name="password" placeholder="Masukan Password" id="input-password" required>
         <label for="show-password">
            <input type="checkbox" id="show-password" name="show-password">
            Tampilkan Password
         </label>
      </p>
      <input type="submit" name="submit" value="SIGN UP">
      <input type="submit" value="back" onclick="window.location.href='index.html'">
      <!-- <a href="login.php">Sudah Ada akun</a> -->
   </form>
</body>

<script>
   // Logika untuk melihat password
   const inputPassword = document.getElementById("input-password");
   const showPassword = document.getElementById("show-password");

   showPassword.addEventListener("input", (m) => {
      if (m.target.checked) {
         inputPassword.setAttribute("type", "text");
      } else {
         inputPassword.setAttribute("type", "password");
      }
   });
</script>

</html>