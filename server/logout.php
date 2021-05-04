<?php
session_start();
unset($_SESSION['ctkusa_invoice']);
header("Location: /invoice");
