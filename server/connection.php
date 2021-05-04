<?php
$servername = "localhost";
$username = "root";
$password = "Ctk2110";
$table = "invoice";

// 초기화
$conn = new mysqli($servername, $username, $password, $table);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

function console_log($data)
{
  echo '<script>';
  echo 'console.log(' . json_encode($data) . ')';
  echo '</script>';
}
