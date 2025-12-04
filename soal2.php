<?php
// Ambil step saat ini
$step = isset($_POST['step']) ? (int)$_POST['step'] : 1;

// Ambil data yang sudah diinput sebelumnya
$nama = isset($_POST['nama']) ? $_POST['nama'] : '';
$umur = isset($_POST['umur']) ? $_POST['umur'] : '';
$hobi = isset($_POST['hobi']) ? $_POST['hobi'] : '';

// Fungsi untuk render form
function renderForm($fields, $step, $values = []) {
    echo '<div class="card">';
    echo '<form method="post">';
    echo '<input type="hidden" name="step" value="'.($step + 1).'">';

    foreach ($fields as $name => $label) {
        $val = isset($values[$name]) ? htmlspecialchars($values[$name]) : '';
        echo '<label>'.$label.': </label><br>';
        echo '<input type="text" name="'.$name.'" value="'.$val.'" required>';
        echo '<br><br>';
    }

    // Kirim data sebelumnya sebagai hidden
    foreach ($values as $k => $v) {
        if (!in_array($k, array_keys($fields))) {
            echo '<input type="hidden" name="'.$k.'" value="'.htmlspecialchars($v).'">';
        }
    }

    echo '<input type="submit" value="Submit">';
    echo '</form>';
    echo '</div>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form Multi-Step</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-top: 50px;
        }
        .card {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 300px;
            text-align: center;
        }
        input[type=text] {
            width: 90%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        input[type=submit] {
            padding: 8px 20px;
            border-radius: 4px;
            border: none;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
        h2 {
            margin-bottom: 20px;
        }
    </style>
<body>
<?php
// Render step yang dibutuhkan
switch ($step) {
    case 1:
        echo "<h2>Tampilan 1: Masukkan Nama Anda</h2>";
        renderForm(['nama' => 'Nama'], $step);
        break;

    case 2:
        echo "<h2>Tampilan 2: Masukkan Umur Anda</h2>";
        renderForm(['umur' => 'Umur'], $step, ['nama' => $nama]);
        break;

    case 3:
        echo "<h2>Tampilan 3: Masukkan Hobi Anda</h2>";
        renderForm(['hobi' => 'Hobi'], $step, ['nama' => $nama, 'umur' => $umur]);
        break;

    case 4:
        echo '<div class="card">';
        echo "<h2>Tampilan 4: Hasil Input</h2>";
        echo "<p>Nama: <b>".htmlspecialchars($nama)."</b></p>";
        echo "<p>Umur: <b>".htmlspecialchars($umur)."</b></p>";
        echo "<p>Hobi: <b>".htmlspecialchars($hobi)."</b></p>";
        echo '</div>';
        break;

    default:
        echo "<p>Step tidak valid.</p>";
}
?>
</body>
</html>
