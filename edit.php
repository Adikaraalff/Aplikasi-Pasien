<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datapasien";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_id"])) {

    // die(json_encode($_POST));
    // Handle the form submission for editing here
    $edit_id = $_POST["edit_id"];
    $new_nama_pasien = $_POST["new_nama_pasien"];
    $new_nik_pasien = $_POST["new_nik_pasien"];
    $new_alamat_pasien = $_POST["new_alamat_pasien"];
    $new_tanggal_lahir_pasien = $_POST["new_tanggal_lahir_pasien"];
    $new_umur_pasien = $_POST["new_umur_pasien"];
    $new_nohp_pasien = $_POST["new_nohp_pasien"];
    $new_keluhan_pasien = $_POST["new_keluhan_pasien"];

    // die($new_tanggal_selesai);
    $sql = "UPDATE datapasien SET nama_pasien = ?, nik_pasien = ?, alamat_pasien = ?, tanggal_lahir_pasien = ?, umur_pasien = ?, nohp_pasien = ?, keluhan_pasien = ? WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $new_nama_pasien, $new_nik_pasien, $new_alamat_pasien, $new_tanggal_lahir_pasien, $new_umur_pasien, $new_nohp_pasien, $new_keluhan_pasien, $edit_id);

    if ($stmt->execute()) {
        // Edit successful
        $editfile_successs = "Edit successful. You can now <a href='index.php'>Check Data</a>.";
    } else {
        // Edit failed
        $editfile_error = "Edit failed. Please try again." . $stmt->error;
    }

    $stmt->close();
}


if (isset($_GET["id"])) {
    $edit_id = $_GET["id"];
    $sql = "SELECT * FROM datapasien WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Record not found.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Data</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Edit Record</h1>
        <form method="post" action="">
            <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
            <div class="form-group">
                <label for="new_nama_pasien">Nama Pasien :</label>
                <input type="text" class="form-control" id="new_nama_pasien" name="new_nama_pasien" value="<?php echo $row["nama_pasien"]; ?>">
            </div>
            <div class="form-group">
                <label for="new_nik_pasien">NIK Pasien :</label>
                <input type="text" class="form-control" id="new_nik_pasien" name="new_nik_pasien" value="<?php echo $row["nik_pasien"]; ?>">
            </div>
            <div class="form-group">
                <label for="new_alamat_pasien">Alamat Pasien :</label>
                <textarea name="new_alamat_pasien" id="new_alamat_pasien" cols="148" rows="2"><?php echo $row["alamat_pasien"]; ?></textarea>
            </div>
            <div class="form-group">
                <label for="new_tanggal_lahir_pasien">Tanggal Lahir:</label>
                <input type="date" class="form-control" id="new_tanggal_lahir_pasien" name="new_tanggal_lahir_pasien" value="<?php echo $row["tanggal_lahir_pasien"]; ?>">
            </div>
            <div class="form-group">
                <label for="new_umur_pasien">Umur Pasien :</label>
                <input type="text" class="form-control" id="new_umur_pasien" name="new_umur_pasien" value="<?php echo $row["umur_pasien"]; ?>">
            </div>
            <div class="form-group">
                <label for="new_nohp_pasien">NoHp Pasien :</label>
                <input type="text" class="form-control" id="new_nohp_pasien" name="new_nohp_pasien" value="<?php echo $row["nohp_pasien"]; ?>">
            </div>
            <div class="form-group">
                <label for="new_nohp_pasien">Keluhan Pasien :</label>
                <input type="text" class="form-control" id="new_keluhan_pasien" name="new_keluhan_pasien" value="<?php echo $row["keluhan_pasien"]; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <?php
        if (isset($editfile_successs)) {
            echo '<div class="alert alert-success">' . $editfile_successs . '</div>';
        } elseif (isset($editfile_error)) {
            echo '<div class="alert alert-danger">' . $editfile_error . '</div>';
        }
        ?>
    </div>

    <!-- Include Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>