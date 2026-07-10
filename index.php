<?php 
// Memanggil koneksi ke database
include_once("config.php"); 

// Fitur Pencarian Data
$keyword = "";
if (isset($_GET['cari'])) {
    $keyword = mysqli_real_escape_string($mysqli, $_GET['keyword']);
    $query = "SELECT * FROM alat WHERE 
              nama_alat LIKE '%$keyword%' OR 
              merek LIKE '%$keyword%' OR 
              lokasi LIKE '%$keyword%' 
              ORDER BY id DESC";
} else {
    $query = "SELECT * FROM alat ORDER BY id DESC";
}

$result = mysqli_query($mysqli, $query); 
?> 
 
<!DOCTYPE html> 
<html> 
<head> 
    <title>SIMANTAN - Sistem Informasi Manajemen Peralatan Kesehatan</title> 
    <style> 
        /* Reset & Base Style */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            /* Background Gradasi Pink Cantik */
            background: linear-gradient(135deg, #ffdee9 0%, #b5fffc 100%);
            min-height: 100vh;
            padding: 40px 20px; 
            color: #495057;
        }

        /* Container Utama */
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.95); /* Putih bersih transparan sedikit */
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(230, 73, 128, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        /* Judul Utama dengan Karakter Alkes */
        h2 {
            font-size: 24px;
            color: #d63384; /* Pink Tua */
            margin-bottom: 25px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Flexbox Navigasi Atas */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        /* Style Tombol Tambah */
        .btn-tambah {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background-color: #e64980; /* Pink Rose */
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(230, 73, 128, 0.3);
            transition: all 0.2s;
        }
        .btn-tambah:hover {
            background-color: #d63384;
            transform: translateY(-1px);
        }

        /* Form Pencarian */
        .search-form {
            display: flex;
            gap: 8px;
        }
        .search-input {
            width: 280px;
            padding: 10px 15px;
            border: 2px solid #ffdeeb;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .search-input:focus {
            border-color: #f783ac;
        }
        .btn-cari {
            padding: 10px 20px;
            background-color: #f783ac;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s;
        }
        .btn-cari:hover {
            background-color: #e64980;
        }

        /* Tabel Bertema Pink */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
            font-size: 14px;
        } 
        th { 
            background-color: #fff0f6; 
            color: #c2185b; /* Teks Magenta */
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.8px;
            border-bottom: 3px solid #ff85a2; 
            padding: 15px 12px;
            text-align: left;
        } 
        td { 
            padding: 15px 12px; 
            text-align: left; 
            border-bottom: 1px solid #ffe3e8; 
        }
        tr:hover {
            background-color: #fff5f7; 
        }
        .text-bold {
            font-weight: 600;
            color: #2b2b2b;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Tombol Aksi */
        .btn-edit {
            color: #d63384;
            text-decoration: none;
            font-weight: 600;
            margin-right: 12px;
        }
        .btn-edit:hover { text-decoration: underline; }
        
        .btn-delete {
            color: #f03e3e;
            text-decoration: none;
            font-weight: 600;
        }
        .btn-delete:hover { text-decoration: underline; }

        /* Footer */
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #868e96;
            border-top: 1px solid #ffe3e8;
            padding-top: 20px;
        }
        .footer strong {
            color: #c2185b;
        }
    </style> 
</head> 
<body> 

    <div class="container">
        <h2>🏥 SIMANTAN - Sistem Informasi Manajemen Peralatan Kesehatan 🩺</h2>

        <div class="top-bar">
            <a href="tambah_alat.php" class="btn-tambah">➕ Tambah Alat Baru 💉</a>

            <form action="" method="get" class="search-form">
                <input type="text" name="keyword" class="search-input" placeholder="Cari nama alat, merek, atau lokasi.." value="<?php echo htmlspecialchars($keyword); ?>">
                <button type="submit" name="cari" class="btn-cari">🔍 Cari</button>
                <?php if($keyword != ""): ?>
                    <a href="index.php" style="padding:10px; color:#e64980; text-decoration:none; font-size:14px;">Reset</a>
                <?php endif; ?>
            </form>
        </div>

        <table> 
            <thead>
                <tr> 
                    <th style="width: 35%;">Nama Alat</th>
                    <th style="width: 12%;">Tahun</th>
                    <th style="width: 15%;">Merek</th>
                    <th style="width: 18%;">Lokasi</th>
                    <th style="width: 20%;">Aksi</th> 
                </tr> 
            </thead>
            <tbody>
                <?php 
                if(mysqli_num_rows($result) > 0) {
                    while($user_data = mysqli_fetch_array($result)) { 
                        echo "<tr>"; 
                        // Menyisipkan karakter ikon kecil di depan Nama Alat agar bernuansa alkes
                        echo "<td class='text-bold'>⚙️ ".$user_data['nama_alat']."</td>"; 
                        echo "<td>📅 ".$user_data['tahun']."</td>"; 
                        echo "<td>🏷️ ".$user_data['merek']."</td>"; 
                        echo "<td>📍 ".$user_data['lokasi']."</td>"; 
                        echo "<td>";
                        echo "<a href='edit.php?id=".$user_data['id']."' class='btn-edit'>📝 Edit</a>";
                        echo "<a href='delete.php?id=".$user_data['id']."' class='btn-delete' onclick='return confirm(\"Yakin ingin menghapus alat ini?\")'>🗑️ Delete</a>";
                        echo "</td>";
                        echo "</tr>"; 
                    } 
                } else {
                    echo "<tr><td colspan='5' style='text-align:center; padding:30px; color:#868e96;'>❌ Data alat tidak ditemukan.</td></tr>";
                }
                ?> 
            </tbody>
        </table> 

        <div class="footer">
            👩‍💻 UAS PEMROGRAMAN WEB: <strong>ARI SULISTYANINGRUM 2202505111</strong>
        </div>
    </div>

</body> 
</html>