<?php
require '../server/connection.php';

if (isset($_POST["submit_del"])) {
    $c_id = $_POST['c_id'];


    $check_query = "SELECT * FROM filedata WHERE (id = '$c_id')";
    $check_result = mysqli_query($conn, $check_query);
    $check_data = mysqli_fetch_array($check_result);

    if ($check_data[0]) {
        $name_file = $check_data["name_file"];
        $type_file = $check_data["filetype"];

        $sql_file = "DELETE FROM filedata WHERE (name_file= '$name_file')";

        if ($type_file == "wms") {
            $sql_data = "DELETE FROM wms WHERE (name_file = '$name_file') ORDER BY id DESC";
        } elseif ($type_file == "ups_dtrans") {
            $sql_data = "DELETE FROM ups_dtrans WHERE (name_file = '$name_file') ORDER BY id DESC";
        } else {
            //raw_ctk
            $sql_data = "DELETE FROM ups_ctk WHERE (name_file = '$name_file') ORDER BY id DESC";
        }

        $var = 0;

        if (mysqli_query($conn, $sql_file)) {
            echo "FILE Record deleted successfully";
            $var += 1;
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

        if (mysqli_query($conn, $sql_data)) {
            echo "Data Record deleted successfully";
            $var += 1;
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

        if ($var == 2) {
            echo '<script>alert("Data Deleted"); window.location.href="index.php";</script>';
        }
    } else {
        echo '<script>alert("FILE Data Not Exist"); window.location.href="index.php";</script>';
    }
}

$conn->close();
