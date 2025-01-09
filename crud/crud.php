<?php
include '../connection.php';

session_start();  // Mulai session untuk memeriksa status login


// Menampilkan error untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Tambah Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
   $nama = $_POST["nama"];
   $kelas = $_POST["kelas"];
   $nilai = $_POST["nilai"];
   $alamat = $_POST["alamat"];
   $no_hp = $_POST["no_hp"];

   // Cek apakah nama sudah ada
   $check_sql = $conn->prepare("SELECT * FROM siswa WHERE nama = ?");
   $check_sql->bind_param("s", $nama);
   $check_sql->execute();
   $check_result = $check_sql->get_result();

   if ($check_result->num_rows > 0) {
      echo "<script>alert('Nama sudah digunakan oleh siswa lain'); window.location='crud.php';</script>";
   } else {
      // Gunakan prepared statement untuk insert
      $stmt = $conn->prepare("INSERT INTO siswa (nama, kelas, nilai, alamat, no_hp) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("ssiss", $nama, $kelas, $nilai, $alamat, $no_hp);

      if ($stmt->execute()) {
         echo "<script>alert('Data Berhasil diinput'); window.location='crud.php';</script>";
      } else {
         echo "<script>alert('Error: " . addslashes($conn->error) . "'); window.location='crud.php';</script>";
      }
      $stmt->close();
   }
}

// Update Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
   $id = $_POST["id"];
   $nama = $_POST["nama"];
   $kelas = $_POST["kelas"];
   $nilai = $_POST["nilai"];
   $alamat = $_POST["alamat"];
   $no_hp = $_POST["no_hp"];

   // Cek apakah nama sudah digunakan siswa lain
   $check_sql = $conn->prepare("SELECT id FROM siswa WHERE nama = ? AND id != ?");
   $check_sql->bind_param("si", $nama, $id);
   $check_sql->execute();
   $check_result = $check_sql->get_result();

   if ($check_result->num_rows > 0) {
      echo "<script>alert('Nama sudah digunakan oleh siswa lain'); window.location='crud.php';</script>";
   } else {
      // Update data siswa
      $stmt = $conn->prepare("UPDATE siswa SET nama = ?, kelas = ?, nilai = ?, alamat = ?, no_hp = ? WHERE id = ?");
      $stmt->bind_param("ssissi", $nama, $kelas, $nilai, $alamat, $no_hp, $id);

      if ($stmt->execute()) {
         echo "<script>alert('Data Berhasil diupdate'); window.location='crud.php';</script>";
      } else {
         echo "<script>alert('Error: " . addslashes($conn->error) . "'); window.location='crud.php';</script>";
      }
      $stmt->close();
   }
}

// Hapus Data
if (isset($_GET['delete'])) {
   $id = $_GET['delete'];
   $stmt = $conn->prepare("DELETE FROM siswa WHERE id = ?");
   $stmt->bind_param("i", $id);

   if ($stmt->execute()) {
      echo "<script>alert('Data Berhasil dihapus'); window.location='crud.php';</script>";
   } else {
      echo "<script>alert('Error: " . addslashes($conn->error) . "'); window.location='crud.php';</script>";
   }
   $stmt->close();
}

// Ambil data dari database
$sql_get = "SELECT * FROM siswa";
$result = $conn->query($sql_get);

?>

<!DOCTYPE html>
<html>

<head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../asset/crud-style.css">
   <link rel="icon" type="image/svg+xml" href="../img/akatsuki.png">
   <title>Data Nilai Siswa RPL</title>
   <script>
      function resetForm() {
         // Kosongkan semua input form
         document.getElementById("id").value = "";
         document.getElementById("nama").value = "";
         document.getElementById("kelas").value = "";
         document.getElementById("nilai").value = "";
         document.getElementById("alamat").value = "";
         document.getElementById("no_hp").value = "";
      }
   </script>
</head>

<body>
   <form action="../logout.php" method="post">
      <input type="submit" name="logout" value="Logout">
   </form>

   <h2>Nilai Siswa RPL</h2>
   <form method="POST" action="crud.php">
      <input type="hidden" name="id" id="id">
      <label for="nama">Nama:</label><br>
      <input type="text" id="nama" name="nama" required><br><br>

      <label for="kelas">Kelas:</label><br>
      <input type="text" id="kelas" name="kelas" required><br><br>

      <label for="nilai">Nilai:</label><br>
      <input type="number" id="nilai" name="nilai" required><br><br>

      <label for="alamat">Alamat:</label><br>
      <textarea id="alamat" name="alamat" required></textarea><br><br>

      <label for="no_hp">No HP:</label><br>
      <input type="text" id="no_hp" name="no_hp" required><br><br>

      <input type="submit" name="tambah" value="Tambah" style="color: white;">
      <input type="submit" name="update" value="Update" style="color: white;">
      <input type="button" value="Reset" onclick="resetForm()" style="color: white;">
   </form>

   <h2>Daftar Nilai Siswa RPL</h2>
   <table border="1" cellpadding="10" cellspacing="0">
      <thead>
         <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Nilai</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Aksi</th>
         </tr>
      </thead>
      <tbody>
         <?php
         if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               echo "<tr>
            <td data-label='ID'>" . $row['id'] . "</td>
            <td data-label='Nama'>" . $row['nama'] . "</td>
            <td data-label='Kelas'>" . $row['kelas'] . "</td>
            <td data-label='Nilai'>" . $row['nilai'] . "</td>
            <td data-label='Alamat'>" . $row['alamat'] . "</td>
            <td data-label='No HP'>" . $row['no_hp'] . "</td>
            <td data-label='Aksi'>
               <a href='crud.php?edit=" . $row['id'] . "'>Edit</a> | 
               <a href='crud.php?delete=" . $row['id'] . "' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Delete</a>
            </td>
         </tr>";
            }
         } else {
            echo "<tr><td colspan='7'>Tidak ada data!!!</td></tr>";
         }
         ?>
      </tbody>
   </table>

   <?php
   // Jika ada permintaan edit, tampilkan data di form
   if (isset($_GET['edit'])) {
      $id = $_GET['edit'];
      $sql_edit = $conn->prepare("SELECT * FROM siswa WHERE id = ?");
      $sql_edit->bind_param("i", $id);
      $sql_edit->execute();
      $result_edit = $sql_edit->get_result();

      if ($result_edit->num_rows > 0) {
         $row_edit = $result_edit->fetch_assoc();
         echo "<script>
            document.getElementById('id').value = '" . $row_edit['id'] . "';
            document.getElementById('nama').value = '" . $row_edit['nama'] . "';
            document.getElementById('kelas').value = '" . $row_edit['kelas'] . "';
            document.getElementById('nilai').value = '" . $row_edit['nilai'] . "';
            document.getElementById('alamat').value = '" . $row_edit['alamat'] . "';
            document.getElementById('no_hp').value = '" . $row_edit['no_hp'] . "';
         </script>";
      }
   }
   ?>
</body>

</html>