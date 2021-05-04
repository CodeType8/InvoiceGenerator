<?php
require '../server/connection.php';

$name_file = $_GET['name_file'];
$type_file = $_GET['type_file'];

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
