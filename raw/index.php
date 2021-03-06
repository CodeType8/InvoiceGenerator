<!doctype html>
<html lang="en">

<head>
    <title>CTK USA Invoice Generator - Raw Data</title>
</head>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    * {
        box-sizing: border-box;
    }

    /* Button used to open the contact form - fixed at the bottom of the page */
    .open-button {
        background-color: #555;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        opacity: 0.8;
        position: fixed;
        bottom: 23px;
        right: 28px;
        width: 280px;
    }

    .open-button1 {
        background-color: #555;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        opacity: 0.8;
        position: fixed;
        bottom: 23px;
        right: 330px;
        width: 280px;
    }

    /* The popup form - hidden by default */
    .form-popup {
        display: none;
        position: fixed;
        bottom: 0;
        right: 15px;
        border: 3px solid #f1f1f1;
        z-index: 9;
    }

    .form-popup1 {
        display: none;
        position: fixed;
        bottom: 0;
        right: 320px;
        border: 3px solid #f1f1f1;
        z-index: 9;
    }

    /* Add styles to the form container */
    .form-container {
        max-width: 300px;
        padding: 10px;
        background-color: white;
    }

    /* Full-width input fields */
    .form-container input[type=text],
    .form-container input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        border: none;
        background: #f1f1f1;
    }

    /* When the inputs get focus, do something */
    .form-container input[type=text]:focus,
    .form-container input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Set a style for the submit/login button */
    .form-container .btn {
        background-color: #4CAF50;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        margin-bottom: 10px;
        opacity: 0.8;
    }

    /* Add a red background color to the cancel button */
    .form-container .cancel {
        background-color: red;
    }

    /* Add some hover effects to buttons */
    .form-container .btn:hover,
    .open-button:hover {
        opacity: 1;
    }
</style>

<body>
    <?php
    require '../templates/navbar.php';
    require 'data.php';
    ?>

    <div class="w3-content" style="max-width:2000px;margin-top:60px;padding-right:30px;padding-left:30px;">
        <button class="open-button" onclick="openForm()">Delete Data</button>
        <div class="form-popup" id="myForm">
            <form autocomplete="off" class="form-container" action="delete.php" method="post" enctype="multipart/form-data">
                <h1>Delete Data</h1>

                <label for="email"><b>Data ID <font color="red">(Required)</font></b></label>
                <input type="text" placeholder="Enter Data ID" name="c_id" id="c_id" required>

                <button type="submit" id="submit_del" name="submit_del" class="btn cancel">Delete Data</button>
                <button type="button" class="btn" onclick="closeForm()">Cancel</button>
            </form>
        </div>

        <script>
            function openForm() {
                document.getElementById("myForm").style.display = "block";
            }

            function closeForm() {
                document.getElementById("myForm").style.display = "none";
            }
        </script>

        <!-- Page content -->
        <table id="table" class="table table-bordered">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Date</td>
                    <td>File Name</td>
                    <td>File Type</td>
                </tr>
            </thead>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                if ($row["filetype"] == "ups_dtrans") {
                    $filetype = "UPS - Dtrans";
                } elseif ($row["filetype"] == "ups_ctk") {
                    $filetype = "UPS - CTK";
                } else {
                    $filetype = "WMS";
                }

                // echoing the fetched data from the database per column names
                $location = '"delete.php?name_file=' . $row["name_file"] . '&type_file=' . $row["filetype"] . '"';
                echo '  
                    <tr>
                        <td>' . $row["id"] . '</td> 
                        <td>' . $row["date_created"] . '</td>  
                        <td><a href="../display/index.php?name_file=' . $row["name_file"] . '&type_file=' . $row["filetype"] . '" target="_blank">' . $row["name_file"] . '</a></td>  
                        <td>' . $filetype . '</td>
                    </tr>  
                    '; //<td><a href="javascript:openulr($location);">DELETE</a> </td>
            }
            ?>
        </table>
        <!-- End Page Content -->
    </div>

    <script>
        jQuery(function($) {
            $("#table").DataTable({
                // ?????? ???????????? ?????????
                //lengthChange: false,
                // ?????? ?????? ?????????
                //searching: false,
                // ?????? ?????? ?????????
                //ordering: false,
                // ?????? ?????? ?????????
                //info: false,
                // ????????? ?????? ?????????
                //paging: false

                //1?????? ????????? ?????? ??????
                order: [0, "desc"],

                // ?????? ????????? ?????? ?????? ??????
                //order: []

                // ?????? ??????????????? ??????
                // ?????? ?????? true ?????? false
                //scrollX: true,

                // ?????? ??????????????? ??????
                // ?????? ?????? px??????
                //scrollY: 200

                //// ???????????? ??????
                //scrollX: true,
                //scrollY: 200,

                // ??? ?????? ??????
                //columnDefs: [
                // 2?????? ?????? ????????? 100px??? ??????
                //{ targets: 1, width: 100 }
                //]
                // ?????? ????????? 10??? ????????? ??????
                lengthMenu: [10, 25, 50, 100, 200],

                // ?????? ?????? ????????? 50????????? ??????
                displayLength: 10,
                //scrollX: true,
                //scrollY: 200,
                //columnDefs: [
                //{ targets: 0, visible: false },
                //{ targets: 1, width: 100 }
                //]
            });
        });
    </script>

    <?php
    require '../templates/footer.php';
    ?>
</body>

</html>