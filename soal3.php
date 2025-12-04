<?php
// Koneksi ke database
$host = "localhost";
$user = "root"; 
$pass = "";     
$db   = "testdb";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil keyword pencarian jika ada
$search = isset($_GET['search']) ? $_GET['search'] : '';

// LEFT JOIN untuk menggabungkan data person dan data hobi
$sql = "SELECT person.id, person.nama, person.alamat, GROUP_CONCAT(hobi.hobi SEPARATOR ', ') AS hobi_list
        FROM person
        LEFT JOIN hobi ON person.id = hobi.person_id";

// Tambahkan kondisi pencarian
if ($search != '') {
    $search = $conn->real_escape_string($search);
    $sql .= " WHERE person.nama LIKE '%$search%' 
              OR person.alamat LIKE '%$search%' 
              OR hobi.hobi LIKE '%$search%'";
}

$sql .= " GROUP BY person.id ORDER BY person.id ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Person & Hobi</title>
    <style>
        table {
            border-collapse: 
            collapse; 
            width: 80%; 
            margin: auto; 
        }
        th, td { 
            border: 1px solid #ccc; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
        }
        form { 
            text-align: center; 
            margin-bottom: 20px; 
        }
        input[type=text] { 
            padding: 5px; 
            width: 200px; 
        }
        input[type=submit], button { 
            padding: 5px 15px; 
            margin-left:5px; 
            cursor:pointer; 
        }
        button { 
            border: 1px solid #ccc; 
            background-color: #f2f2f2; 
            border-radius: 3px; 
        }
        button:hover { 
            background-color: #e0e0e0; 
        }
    </style>
    <script>
        function clearSearch() {
            window.location.href = window.location.pathname;
        }
    </script>
</head>
<body>
<h2 style="text-align:center;">Daftar Person & Hobi</h2>

<!-- Form pencarian -->
<form method="get">
    <input type="text" name="search" id="searchInput" placeholder="Cari nama, alamat, atau hobi" value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">SUBMIT</button>
    <button type="button" onclick="clearSearch()">CLEAR</button>
</form>

<!-- Tabel data -->
<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Hobi</th>
    </tr>
<?php
if ($result->num_rows > 0) {
    $no = 1;
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$no++."</td>";
        echo "<td>".htmlspecialchars($row['nama'])."</td>";
        echo "<td>".htmlspecialchars($row['alamat'])."</td>";
        echo "<td>".htmlspecialchars($row['hobi_list'])."</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4' style='text-align:center;'>Data tidak ditemukan</td></tr>";
}
$conn->close();
?>
</table>
</body>
</html>
