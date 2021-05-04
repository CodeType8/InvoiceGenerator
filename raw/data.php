<?php
require '../server/connection.php';

$query = "SELECT * FROM filedata WHERE (filetype = 'wms') OR (filetype = 'ups_dtrans') OR (filetype = 'ups_ctk') ORDER BY id DESC";
$result = mysqli_query($conn, $query);