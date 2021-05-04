<?php
$id = $_POST['id'];
$pw = $_POST['pw'];

//admin     dkssudgktpdy**
//ctkusa    Ctk2110!@
if (($id == 'admin' && $pw == 'dkssudgktpdy**') || ($id == 'ctkusa' && $pw == 'Ctk2110!@') || ($id == 'chang.o' && $pw == '12345!@')) {
    session_start();
    $_SESSION['ctkusa_invoice'] = 1;
    $_SESSION['id'] = $id;
    $_SESSION['timezone'] = $_POST['timezone'];
    echo 'success';
} else echo 'no';