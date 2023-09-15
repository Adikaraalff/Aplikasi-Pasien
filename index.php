<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datapasien";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["delete_id"])) {
        // Handle the delete request here
        $delete_id = $_POST["delete_id"];
        $sql = "DELETE FROM datapasien WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            // Deletion successful
            echo "Record deleted successfully.";
        } else {
            // Deletion failed
            echo "Error deleting record: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST["edit_id"])) {
        // Handle the edit request here
        $edit_id = $_POST["edit_id"];
        // Redirect to an edit page with the ID
        header("Location: edit.php?id=" . $edit_id);
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Display</title>
    <!-- Add the link to the Bootstrap CSS file -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add custom CSS for styling -->
    <style>
        /* Add your custom CSS styles here */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            margin: 2px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Data Display</h1>
        <form method="post" action="">
            <table class="table table-striped">
                <thead>
                    <a class="btn btn-primary" href="registrasi.php">Tambah Data</a>
                    <tr>
                        <th>NO</th>
                        <th>Nama Pasein</th>
                        <th>NIK Pasein</th>
                        <th>Alamat Pasein</th>
                        <th>Tanggal Lahir Pasein</th>
                        <th>Umur Pasein</th>
                        <th>NoHp Pasein</th>
                        <th>Keluhan Pasien</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM datapasien";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["nama_pasien"] . "</td>";
                            echo "<td>" . $row["nik_pasien"] . "</td>";
                            echo "<td>" . $row["alamat_pasien"] . "</td>";
                            echo "<td>" . $row["tanggal_lahir_pasien"] . "</td>";
                            echo "<td>" . $row["umur_pasien"] . "</td>";
                            echo "<td>" . $row["nohp_pasien"] . "</td>";
                            echo "<td>" . $row["keluhan_pasien"] . "</td>";
                            echo "<td>
                                    <button class='btn btn-danger' type='submit' name='delete_id' value='" . $row["id"] . "'>Delete</button>
                                    <button class='btn btn-primary' type='submit' name='edit_id' value='" . $row["id"] . "'>Edit</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>

    <!-- Add the Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>