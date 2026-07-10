<?php
// 1. Memanggil file koneksi database
include_once("config.php");

// 2. Mengecek apakah tombol update/simpan sudah ditekan
if(isset($_POST['update']))
{   
    $id = $_POST['id'];
    $nama_alat = $_POST['nama_alat'];
    $tahun = $_POST['tahun'];
    $merek = $_POST['merek'];
    $lokasi = $_POST['lokasi'];
        
    // Update data ke database
    $result = mysqli_query($mysqli, "UPDATE alat SET nama_alat='$nama_alat', tahun='$tahun', merek='$merek', lokasi='$lokasi' WHERE id=$id");
    
    // Redirect kembali ke halaman utama setelah berhasil update
    header("Location: index.php");
    exit;
}
?>

<?php
// 3. Mengambil ID dari URL (contoh: edit.php?id=4)
$id = $_GET['id'];

// Ambil data alat berdasarkan ID tersebut
$result = mysqli_query($mysqli, "SELECT * FROM alat WHERE id=$id");

while($user_data = mysqli_fetch_array($result))
{
    $nama_alat = $user_data['nama_alat'];
    $tahun = $user_data['tahun'];
    $merek = $user_data['merek'];
    $lokasi = $user_data['lokasi'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Alat</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"] { width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-update { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-back { background-color: #6c757d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; margin-left: 10px; }
    </style>
</head>
<body>

    <h2>Edit Data Alat</h2>
    
    <form name="update_alat" method="post" action="edit.php">
        <div class="form-group">
            <label>Nama Alat</label>
            <input type="text" name="nama_alat" value="<?php echo $nama_alat; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Tahun</label>
            <input type="number" name="tahun" value="<?php echo $tahun; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Merek</label>
            <input type="text" name="merek" value="<?php echo $merek; ?>" required>
        </div>
        
        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" name="lokasi" value="<?php echo $lokasi; ?>" required>
        </div>
        
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        
        <input type="submit" name="update" value="Update Data" class="btn-update">
        <a href="index.php" class="btn-back">Batal</a>
    </form>
    
</body>
</html>