<!doctype html>
<html lang="en">
<?php
    session_start();
    if (isset($_SESSION['ctkusa_invoice'])){
        header("Location: /invoice/invoices");
    }
    
?>

<head>
    <?php
    include 'templates/default_head.php';
    ?>

    <title>CTK USA Invoice Generator</title>

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            background-image: url('/invoice/images/bg.png');
            background-size: cover;
            background-repeat: no-repeat;
        }

        label {
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="h-100 row align-items-center">
        <div class="col-2"></div>
        <div class="col-8 text-center p-5" style="background-color: rgba(255, 255, 255, 0.77);font-family: aero_matics_bold;">
            <div class="d-flex flex-row">
                <img src="images/CTK_LOGO_01.png" class="pr-5 my-auto" width="20%">
                <div class="d-inline-flex flex-column w-100">
                    <div style="font-family: aero_matics_regular;font-size: 3.5rem;line-height: 1.8rem;margin-bottom: 2.2rem;">Invoicing for UPS Shipping Fees<br>
                        <span style="font-size: 1.2rem;"> We Complete Your Invoicing</span>
                    </div>
                    <form autocomplete="off">
                        <div class="form-row">
                            <div class="col">
                                <div class="row mb-2">
                                    <label class="col-5">ID</label>
                                    <div class="col">
                                        <input id="id" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="row align-items-end">
                                    <label class="col-5" style="margin-bottom: 0;">PASSWORD</label>
                                    <div class="col">
                                        <input id="pw" type="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3" style="font-family: aero_matics_regular;">
                                <button id="loginButton" type="button" class="btn btn-secondary" style="width: 80%;height: 100%;font-size: 1.5rem;display: block;" onclick="login()">Login</button>
                                <script>
                                    //"enter" key press action
                                    $('#id, #pw').keyup(function(event) {
                                        if (event.keyCode === 13) $("#loginButton").click();
                                    });

                                    //login function -> login,php
                                    function login() {
                                        var id = $('#id').val();
                                        var pw = $('#pw').val();
                                        $.ajax({
                                            type: 'POST',
                                            url: 'server/login.php',
                                            data: 'id=' + id + '&pw=' + pw + '&timezone=' + Intl.DateTimeFormat().resolvedOptions().timeZone,
                                            success: function(msg) {
                                                //log in success, send user to main
                                                if (msg == 'success') window.location.href = "invoices";
                                                else alert('Access restricted');
                                            }
                                        });
                                    }
                                </script>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</body>

</html>