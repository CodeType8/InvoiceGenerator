<?php
require '../server/connection.php';

if (isset($_POST["submit_del"])) {
    $c_id = $_POST['c_id'];

    $check_query = "SELECT * FROM customer WHERE (id = '$c_id')";
    $check_result = mysqli_query($conn, $check_query);
    $check_data = mysqli_fetch_array($check_result, MYSQLI_NUM);

    if ($check_data[0] > 1) {
        $sql = "DELETE FROM customer WHERE id='$c_id'";
        //"INSERT INTO customer (name_customer, rate_customer, remark_customer) VALUES ('$c_name','$c_rate','$c_remark')";
        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Customer Data Deleted"); window.location.href="index.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } 
    else {
        echo '<script>alert("Customer Data Not Exist"); window.location.href="index.php";</script>';
    }
}