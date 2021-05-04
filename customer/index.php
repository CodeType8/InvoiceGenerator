<!doctype html>
<html lang="en">

<head>
    <title>CTK USA Invoice Generator - Customer</title>
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
        <button class="open-button" onclick="openForm()">Add Customer</button>

        <div class="form-popup" id="myForm">
            <form autocomplete="off" class="form-container" action="add.php" method="post" enctype="multipart/form-data">
                <h1>Add Customer</h1>

                <label for="email"><b>Customer Name <font color="red">(Required)</font></b></label>
                <input type="text" placeholder="Enter Customer Name" name="c_name" id="c_name" required>

                <label for="psw"><b>Rate (example) 1.1 1.23 1.334 <font color="red">(Required)</font> </b></label>
                <input type="text" placeholder="Enter Rate" name="c_rate" id="c_rate" required>

                <label for="psw"><b>Remark</b></label>
                <input type="text" placeholder="Enter Remark" name="c_remark" id="c_remark">

                <button type="submit" id="submit_add" name="submit_add" class="btn">Add Customer</button>
                <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
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



        <button class="open-button1" onclick="openForm1()">Delete Customer</button>
        <div class="form-popup1" id="myForm1">
            <form autocomplete="off" class="form-container" action="delete.php" method="post" enctype="multipart/form-data">
                <h1>Delete Customer</h1>

                <label for="email"><b>Customer ID <font color="red">(Required)</font></b></label>
                <input type="text" placeholder="Enter Customer ID" name="c_id" id="c_id" required>

                <button type="submit" id="submit_del" name="submit_del" class="btn cancel">Delete Customer</button>
                <button type="button" class="btn" onclick="closeForm1()">Cancel</button>
            </form>
        </div>

        <script>
            function openForm1() {
                document.getElementById("myForm1").style.display = "block";
            }

            function closeForm1() {
                document.getElementById("myForm1").style.display = "none";
            }
        </script>

        <div>
            <!-- Page content -->
            <table id="table" class="table table-bordered">
                <thead>
                    <tr>
                        <td>Customer ID</td>
                        <td>Customer Name</td>
                        <td>Rate</td>
                        <td>Remark</td>
                    </tr>
                </thead>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    // echoing the fetched data from the database per column names
                    echo '  
                    <tr>
                        <td>' . $row["id"] . '</td>  
                        <td>' . $row["name_customer"] . '</td>  
                        <td>' . $row["rate_customer"] . '</td>  
                        <td>' . $row["remark_customer"] . '</td>
                    </tr>  
                    ';
                }
                ?>
            </table>
        </div>
        <!-- End Page Content -->
    </div>

    <script>
        jQuery(function($) {
            $("#table").DataTable({
                // 표시 건수기능 숨기기
                //lengthChange: false,
                // 검색 기능 숨기기
                //searching: false,
                // 정렬 기능 숨기기
                //ordering: false,
                // 정보 표시 숨기기
                //info: false,
                // 페이징 기능 숨기기
                //paging: false

                //1번째 항목은 내림 차순
                order: [0, "desc"],

                // 초기 표시에 경우 정렬 안함
                //order: []

                // 가로 스크롤바를 표시
                // 설정 값은 true 또는 false
                //scrollX: true,

                // 세로 스크롤바를 표시
                // 설정 값은 px단위
                //scrollY: 200

                //// 스크롤바 설정
                //scrollX: true,
                //scrollY: 200,

                // 열 넓이 설정
                columnDefs: [
                    // 2번째 항목 넓이를 100px로 설정
                    {
                        targets: 0,
                        width: 100
                    }
                ],
                // 표시 건수를 10건 단위로 설정
                lengthMenu: [10, 25, 50, 100, 200],

                // 기본 표시 건수를 50건으로 설정
                displayLength: 10,
                //scrollX: true,
                //scrollY: 200,
                //columnDefs: [
                //{ targets: 0, visible: false },
                //{ targets: 1, width: 100 }
                //]
            });
        });
        /*
        $(document).ready(function() {
            $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
        */
    </script>

    <?php
    require '../templates/footer.php';
    ?>
</body>

</html>