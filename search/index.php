<!doctype html>
<html lang="en">

<head>
    <title>CTK USA Invoice Generator</title>
</head>

<body>
    <?php
    require '../templates/navbar.php';
    require '../server/connection.php';
    ?>

    <div class="w3-content" style="max-width:2000px;margin-top:60px;padding-right:30px;padding-left:30px;">
        <!-- Page content -->
        <div>
        <form class="form-horizontal well" action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Search Data</legend>
                <div class="control-group">
                    <div class="controls">
                        From:
                        <select name="file_type" id="file_type">
                            <option value="from_all">All Data</option>
                            <option value="from_num">Shipment Number</option>
                        </select>
                        <input type="text" name="search_data_info" id="search_data_info" class="input-large">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls" style="margin-top: 20px">
                        <button type="submit" id="search_data" name="search_data" class="btn btn-primary button-loading " data-loading-text="Loading...">Search</button>
                    </div>
                </div>
            </fieldset>
        </form>
        </div>
        <div>
            <?php
            if (isset($_POST["search_data"])) {
                $datatype = $_POST['file_type'];
                $datainfo = $_POST['search_data_info'];
                if ($filetype == "from_all") {
                    echo "Not yet";
                } 
                elseif ($filetype == "from_num") {
                    $query1 = "SELECT * FROM aws WHERE (shipmentid = '$datainfo') ORDER BY id DESC";
                    //$query1_1 = "SELECT column_name FROM information_schema.columns WHERE table_schema = 'invoice' AND table_name = 'aws'";
                    $query2 = "SELECT * FROM aws_ctk WHERE (shipmentid = '$datainfo') ORDER BY id DESC";
                    $query3 = "SELECT * FROM ctk_raw WHERE (lead_shipment_num = '$datainfo') ORDER BY id DESC";
                    $query4 = "SELECT * FROM dtrans_raw WHERE (lead_shipment_num = '$datainfo') ORDER BY id DESC";
                }

                //SELECT column_name FROM information_schema.columns WHERE table_schema = 'invoice' AND table_name = 'aws'
                $result1 = mysqli_query($conn, $query1);
                //$result1_1 = mysqli_query($conn, $query1_1);
                echo '<legend>From Dtrans AWS</legend>';
                echo '<table id="table" class="table table-bordered">';
                /*
                echo '<thead><tr>';
                
                echo '</tr></thead>';
                */
                echo '<tr>';
                while ($row = mysqli_fetch_array($result1)) {
                    // echoing the fetched data from the database per column names
                    echo '  
                        <tr>
                            <td>' . $row["accountid"] . '</td>
                            <td>' . $row["trans_no"] . '</td>
                            <td>' . $row["order_no"] . '</td>
                            <td>' . $row["po_no"] . '</td>
                            <td>' . $row["so_no"] . '</td>
                            <td>' . $row["ship_dt"] . '</td>
                            <td>' . $row["ship_to"] . '</td>
                            <td>' . $row["carrier"] . '</td>
                            <td>' . $row["shipmentid"] . '</td>
                            <td>' . $row["trackingid"] . '</td>
                            <td>' . $row["invoice"] . '</td>
                            <td>' . $row["actual"] . '</td>
                            <td>' . $row["effective"] . '</td>
                            <td>' . $row["zip"] . '</td>
                            <td>' . $row["weight_item"] . '</td>
                            <td>' . $row["length_item"] . '</td>
                            <td>' . $row["width"] . '</td>
                            <td>' . $row["height"] . '</td>
                        </tr>  
                        ';
                }
                echo '</tr>';
                echo '</table>';
            }
            ?>
        </div>
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
                //order: [0, "desc"],

                // ?????? ????????? ?????? ?????? ??????
                //order: []

                // ?????? ??????????????? ??????
                // ?????? ?????? true ?????? false
                //scrollX: true,

                // ?????? ??????????????? ??????
                // ?????? ?????? px??????
                //scrollY: 200

                //// ???????????? ??????
                scrollX: true,
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