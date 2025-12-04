<?php
$jml = $_GET['jml'];

echo "<table border=1 style='border-collapse: collapse; text-align: center;'>\n";

// Styling tabel cell
$cellStyle = "style='width:50px; height:50px;'";

for ($a = $jml; $a > 0; $a--) {
    // Hitung total untuk row ini
    $total = 0;
    for ($b = $a; $b > 0; $b--) {
        $total += $b;
    }

    // Cetak baris total di atas row
    echo "<tr><td colspan='$jml' $cellStyle>Total: $total</td></tr>\n";

    // Cetak baris angka dari kiri ke kanan
    echo "<tr>\n";
    $num = $a;
    for ($col = 1; $col <= $jml; $col++) {
        if ($num > 0) {
            echo "<td $cellStyle>$num</td>";
            $num--;
        } else {
            echo "<td $cellStyle></td>"; // isi sisanya dengan sel kosong
        }
    }
    echo "</tr>\n";
}

echo "</table>";
?>
