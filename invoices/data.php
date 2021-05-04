<?php
require '../server/connection.php';

$query = "SELECT * FROM invoice WHERE (filetype = 'invoice_dtrans') OR (filetype = 'invoice_ctk') ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$ups_query = "SELECT * FROM filedata WHERE ((isUsed = 0) AND (filetype = 'ups_dtrans')) OR ((isUsed = 0) AND (filetype = 'ups_ctk')) ORDER BY id DESC";
$ups_result = mysqli_query($conn, $ups_query);

$wms_query = "SELECT * FROM filedata WHERE ((isUsed = 0) AND (filetype = 'wms')) ORDER BY id DESC";
$wms_result = mysqli_query($conn, $wms_query);