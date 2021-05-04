<?php
session_start();
if (!isset($_SESSION['ctkusa_invoice'])){
  header("Location: /invoice");
}   
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="icon" type="image/png" href="../images/favicon.ico" />
<style>
body {font-family: "Lato", sans-serif}
.mySlides {display: none}

.div_right {
  position: absolute;
  right: 0px;
}
.div_search {
  position: absolute;
  right: 100px;
}
</style>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-black w3-card">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="../invoices" class="w3-bar-item w3-button w3-padding-large"><img src="../images/logo.png" height="20" class="d-inline-block align-top"></a>
    <a href="../invoices" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Invoices</a>
    <a href="../raw" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Raw data</a>
    <a href="../upload" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Upload data</a>
    <a href="../customer" class="w3-bar-item w3-button w3-padding-large w3-hide-small">Customer</a>
    <!--
    <div class="w3-dropdown-hover w3-hide-small">
      <button class="w3-padding-large w3-button" title="More">test<i class="fa fa-caret-down"></i></button>     
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="#" class="w3-bar-item w3-button">1</a>
        <a href="#" class="w3-bar-item w3-button">2</a>
        <a href="#" class="w3-bar-item w3-button">3</a>
      </div>
    </div>
    -->
    <a href="../search" class="w3-bar-item w3-button div_search">Search From All</a>
    <a href="../server/logout.php" class="w3-bar-item w3-button div_right">Logout</a>
  </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/t/bs-3.3.6/jqc-1.12.0,dt-1.10.11/datatables.min.css"/> 
<script src="https://cdn.datatables.net/t/bs-3.3.6/jqc-1.12.0,dt-1.10.11/datatables.min.js"></script>
    