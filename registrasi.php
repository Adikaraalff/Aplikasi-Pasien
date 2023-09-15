<?php
// Connect to the database
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'datapasien';

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables for error/success messages
$registerdata_success = $registerdata_error = "";

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_pasien']);
    $nik = mysqli_real_escape_string($conn, $_POST['nik_pasien']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat_pasien']);
    $tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir_pasien']);
    $umur = mysqli_real_escape_string($conn, $_POST['umur_pasien']);
    $nohp = mysqli_real_escape_string($conn, $_POST['nohp_pasien']);
    $keluhan = mysqli_real_escape_string($conn, $_POST['keluhan_pasien']);

    $query = "INSERT INTO datapasien (nama_pasien, nik_pasien, alamat_pasien, tanggal_lahir_pasien, umur_pasien, nohp_pasien, keluhan_pasien) VALUES ('$nama', '$nik', '$alamat', '$tanggal_lahir','$umur','$nohp','$keluhan')";

    if (mysqli_query($conn, $query)) {
        $registerdata_success = "register successful. You can now <a href='index.php'>Check Data</a>.";
    } else {
        $registerdata_error = "register failed. Please try again.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for form styling */
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
        }

        .btn-primary {
            width: 100%;
        }

        .text-success {
            color: green;
        }

        .text-danger {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Register Pasien</h2>
                <?php
                // Display registration success or error messages
                if (!empty($register_success)) {
                    echo '<p class="text-success">' . $register_success . '</p>';
                } elseif (!empty($register_error)) {
                    echo '<p class="text-danger">' . $register_error . '</p>';
                }
                ?>
                <form method="POST" action="" enctype="multipart/form-data">
                    Nama Pasien :
                    <div class="form-group">
                        <input type="text" class="form-control" name="nama_pasien" required>
                    </div>
                    NIK :
                    <div class="form-group">
                        <input type="text" class="form-control" name="nik_pasien" required>
                    </div>
                    Alamat :
                    <div class="form-group">
                        <textarea name="alamat_pasien" id="" cols="70" rows="2"></textarea>
                    </div>
                    Tanggal Lahir :
                    <div class="form-group">
                        <input type="date" class="form-control" name="tanggal_lahir_pasien">
                    </div>
                    Umur :
                    <div class="form-group">
                        <input type="text" class="form-control" name="umur_pasien">
                    </div>
                    No HP :
                    <div class="form-group">
                        <input type="text" class="form-control" name="nohp_pasien">
                    </div>
                    Keluhan Pasien :
                    <div class="form-group">
                        <input type="text" class="form-control" name="keluhan_pasien">
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-primary" value="Simpan">
                    </div>
                </form>
                <?php
                if (isset($registerdata_success)) {
                    echo '<div class="alert alert-success">' . $registerdata_success . '</div>';
                } elseif (isset($registerdata_error)) {
                    echo '<div class="alert alert-danger">' . $registerdata_error . '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>