<?php
require '../server/connection.php';

$query = "SELECT * FROM customer ORDER BY id DESC";

if (isset($_POST["submit_add"])) {
    $c_name = $_POST['c_name'];
    $c_rate = $_POST['c_rate'];
    $c_remark = $_POST['c_remark'];

    $check_query = "SELECT * FROM customer WHERE (name_customer = '$c_name')";
    $check_result = mysqli_query($conn, $check_query);
    $check_data = mysqli_fetch_array($check_result, MYSQLI_NUM);

    if ($check_data[0] > 1) {
        echo '<script>alert("Customer Data Already Exist"); window.location.href="index.php";</script>';
    } else {
        $sql = "INSERT INTO customer (name_customer, rate_customer, remark_customer) VALUES ('$c_name','$c_rate','$c_remark')";
        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Customer Data Uploaded"); window.location.href="index.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
