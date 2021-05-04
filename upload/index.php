<!doctype html>
<html lang="en">

<head>
    <title>CTK USA Invoice Generator - Upload Data</title>
</head>

<body>
    <?php
    require '../templates/navbar.php';
    require '../server/connection.php';
    ?>

    <div class="w3-content" style="max-width:2000px;margin-top:60px;padding-right:30px;padding-left:30px;">
        <!-- Page content -->
        <div id="wrapper">
            <!-- <form class="form-horizontal well" action="data.php" method="post" enctype="multipart/form-data"> -->
            <form class="form-horizontal well" action="" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Import File</legend>
                    <div class="control-group">
                        <div class="controls">
                            <div style="padding-bottom:20px;"><select name="file_type" id="file_type">
                                <option value="Select">Select File Type</option>
                                <option value="wms">WMS</option>
                                <option value="ups_dtrans">UPS - Dtrans</option>
                                <option value="ups_ctk">UPS - CTK</option>
                            </select></div>
                            <input type="file" name="file_data" id="file_data" class="input-large">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls" style="margin-top: 20px">
                            <button type="submit" id="check_data" name="check_data" class="btn btn-primary button-loading " data-loading-text="Loading...">Check Data</button>
                            <button type="submit" id="upload_data" name="upload_data" class="btn btn-primary button-loading " data-loading-text="Loading...">Upload Data</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div>
            <?php
            //Dtrans - WMS
            if (isset($_POST["check_data"])) {
                $filetype = $_POST['file_type'];
                $file = $_FILES["file_data"]["tmp_name"];
                if ($file == "") {
                    echo '<script>alert("Please choose the File");</script>';
                    exit();
                }
                $namedata = $_FILES['file_data']['name'];
                echo '<legend>' . $namedata . '</legend>';
                $file_open = fopen($file, "r");
                $header = fgetcsv($file_open);

                if ($filetype == "wms") {
                    //wms
                    echo '<table id="table" class="table table-bordered">';
                    echo '<thead><tr>';
                    $i_date = array();
                    $i = 0;
                    $count = 0;
                    foreach ($header as &$head) {
                        if ($head == "ship_dt") {
                            $i_date[$i] = $count;
                            $i++;
                        }
                        echo '<td>' . $head . '</td>';
                        $count++;
                    }
                    echo '</tr></thead>';

                    $i = 0;
                    $data = array();
                    while (($data[$i] = fgetcsv($file_open)) !== false) {
                        echo '<tr>';
                        $count = 0;
                        foreach ($data[$i] as &$val) {
                            foreach ($i_date as &$dateindex) {
                                if ($count == $dateindex) {  //date convert
                                    if (strlen($val) == 5) {
                                        $val = gmdate("Y-m-d", (($val - 25569) * 86400));   //index 0 should date format
                                    } elseif ((strlen($val) <= 10) && (strlen($val) >= 8)) {
                                        $val = date('Y-m-d', strtotime($val));
                                    } else {
                                        //Default value NULL data
                                        $val = null;
                                    }
                                }
                            }

                            if (is_string($val)) {
                                $val = addslashes($val);
                            }

                            $data[$i][$count] = $val;
                            echo '<td>' . $data[$i][$count] . '</td>';
                            $count++;
                        }
                        echo '</tr>';
                        $i++;
                        //unset($data);
                    }
                } elseif ($filetype == "ups_dtrans") {
                    //ups - dtrans
                    echo '<table id="table" class="table table-bordered">';
                    echo '<thead><tr>';
                    $i_date = array();
                    $i_float = array();
                    $i_int = array();
                    $i = 0;
                    $i2 = 0;
                    $i3 = 0;
                    $count = 0;
                    foreach ($header as &$head) {
                        //date check
                        if (strpos(strtolower($head), "date") !== false) {
                            $i_date[$i] = $count;
                            $i++;
                        }
                        //float check
                        //version_item dtrans misc_incentive_amount misc_net_amount alternate_invoice_amount invoice_exchange_rate tax_variance_amount currency_variance_amount invoice_level_charge shipment_value_amount exchange_rate entered_value duty_amount weight_item tariff_rate duty_value total_duty_value excise_tax_amount excise_tax_rate gst_amount gst_rate sima_access tax_value total_customs_amount duty_rate vat_vasis_amount vat_amount vat_rate other_basis_amount other_amount other_rate tax_law_article_basis_amount
                        if (
                            strpos(strtolower($head), "amount") !== false || strpos(strtolower($head), "rate") !== false || strpos(strtolower($head), "value") !== false ||
                            ($head == "Version") || ($head == "Invoice Level Charge") || ($head == "Weight") || ($head == "SIMA Access")
                        ) {
                            $i_float[$i2] = $count;
                            $i2++;
                        }

                        //int check
                        // declared_freight_class
                        if (strpos(strtolower($head), "quantity") !== false || ($head == "Line Item Number") || ($head == "Payor Role Code") || ($head == "Freight Sequence Number") || ($head == "Declared Freight Class")) {
                            $i_int[$i3] = $count;
                            $i3++;
                        }

                        echo '<td>' . $head . '</td>';
                        $count++;
                    }
                    echo '</tr></thead>';

                    $i = 0;
                    $data = array();
                    while (($data[$i] = fgetcsv($file_open)) !== false) {
                        echo '<tr>';
                        $count = 0;
                        foreach ($data[$i] as &$val) {
                            if (in_array($count, $i_date)) {
                                if (strlen($val) == 5) {
                                    $val = gmdate("Y-m-d", (($val - 25569) * 86400));   //index 0 should date format
                                } elseif ((strlen($val) <= 10) && (strlen($val) >= 8)) {
                                    $val = date('Y-m-d', strtotime($val));
                                } else {
                                    //NULL data
                                    $val = "1990-09-12";
                                }
                            }

                            if (in_array($count, $i_float)) {
                                if ($val == "" || $val == null) {
                                    $val = -1;
                                }
                            }

                            if (in_array($count, $i_int)) {
                                if ($val == "" || $val == null) {
                                    $val = -1;
                                }
                            }

                            if (is_string($val)) {
                                $val = addslashes($val);
                            }

                            $data[$i][$count] = $val;
                            echo '<td>' . $data[$i][$count] . '</td>';
                            $count++;
                        }
                    }
                } elseif ($filetype == "ups_ctk") {
                    //ups - CTK
                    echo '<table id="table" class="table table-bordered">';
                    echo '<thead><tr>';
                    echo '<td>' . "Version" . '</td>';
                    echo '<td>' . "Account Number 1" . '</td>';
                    echo '<td>' . "Account Number 2" . '</td>';
                    echo '<td>' . "Account Country" . '</td>';
                    echo '<td>' . "Invoice Date" . '</td>';
                    echo '<td>' . "Account Number3" . '</td>';
                    echo '<td>' . "Invoice Type Code" . '</td>';
                    echo '<td>' . "Invoice Type Detail Code" . '</td>';
                    echo '<td>' . "Account Tax ID" . '</td>';
                    echo '<td>' . "Unit of Total Amount" . '</td>';
                    echo '<td>' . "Total Amount" . '</td>';
                    echo '<td>' . "Transaction Date" . '</td>';
                    echo '<td>' . "Pickup Record Number" . '</td>';
                    echo '<td>' . "Lead Shipment Number" . '</td>';
                    echo '<td>' . "World Ease Number" . '</td>';
                    echo '<td>' . "Shipment" . '</td>';
                    echo '<td>' . "Reference Number 1" . '</td>';
                    echo '<td>' . "Reference Number 2" . '</td>';
                    echo '<td>' . "Bill Option Code" . '</td>';
                    echo '<td>' . "Package Quantity" . '</td>';
                    echo '<td>' . "Oversize Quantity" . '</td>';
                    echo '<td>' . "Tracking Number" . '</td>';
                    echo '<td>' . "Package Reference Number 1" . '</td>';
                    echo '<td>' . "Package Reference Number 2" . '</td>';
                    echo '<td>' . "Package Reference Number 3" . '</td>';
                    echo '<td>' . "Package Reference Number 4" . '</td>';
                    echo '<td>' . "Package Reference Number 5" . '</td>';
                    echo '<td>' . "Entered Weight" . '</td>';
                    echo '<td>' . "Entered Weight Unit of Measure" . '</td>';
                    echo '<td>' . "Billed Weight" . '</td>';
                    echo '<td>' . "Billed Weight Unit of Measure" . '</td>';
                    echo '<td>' . "Container Type" . '</td>';
                    echo '<td>' . "Billed Weight Type" . '</td>';
                    echo '<td>' . "Package Dimensions" . '</td>';
                    echo '<td>' . "Zone" . '</td>';
                    echo '<td>' . "Charge Category Code" . '</td>';
                    echo '<td>' . "Charge Category Detail Code" . '</td>';
                    echo '<td>' . "Charge Source" . '</td>';
                    echo '<td>' . "Type Code 1" . '</td>';
                    echo '<td>' . "Type Detail Code 1" . '</td>';
                    echo '<td>' . "Type Detail Value 1" . '</td>';
                    echo '<td>' . "Type Code 2" . '</td>';
                    echo '<td>' . "Type Detail Code 2" . '</td>';
                    echo '<td>' . "Type Detail Value 2" . '</td>';
                    echo '<td>' . "Charge Classification Code" . '</td>';
                    echo '<td>' . "Charge Description Code" . '</td>';
                    echo '<td>' . "Charge Description" . '</td>';
                    echo '<td>' . "Temp6" . '</td>';
                    echo '<td>' . "Transaction Currency Code" . '</td>';
                    echo '<td>' . "Temp7" . '</td>';
                    echo '<td>' . "Temp8" . '</td>';
                    echo '<td>' . "Unit of Temp9" . '</td>';
                    echo '<td>' . "Temp10" . '</td>';
                    echo '<td>' . "Temp11" . '</td>';
                    echo '<td>' . "Miscellaneous Currency Code" . '</td>';
                    echo '<td>' . "Miscellaneous Incentive Amount" . '</td>';
                    echo '<td>' . "Miscellaneous Net Amount" . '</td>';
                    echo '<td>' . "Alternate Invoicing Currency Code" . '</td>';
                    echo '<td>' . "Alternate Invoice Amount" . '</td>';
                    echo '<td>' . "Invoice Exchange Rate" . '</td>';
                    echo '<td>' . "Tax Variance Amount" . '</td>';
                    echo '<td>' . "Currency Variance Amount" . '</td>';
                    echo '<td>' . "Invoice Level Charge" . '</td>';
                    echo '<td>' . "Invoice Due Date" . '</td>';
                    echo '<td>' . "Alternate Invoice Number" . '</td>';
                    echo '<td>' . "Store Number" . '</td>';
                    echo '<td>' . "Customer Reference Number" . '</td>';
                    echo '<td>' . "Sender Name" . '</td>';
                    echo '<td>' . "Sender Company Name" . '</td>';
                    echo '<td>' . "Sender Address Line 1" . '</td>';
                    echo '<td>' . "Sender Address Line 2" . '</td>';
                    echo '<td>' . "Sender City" . '</td>';
                    echo '<td>' . "Sender State" . '</td>';
                    echo '<td>' . "Sender Postal" . '</td>';
                    echo '<td>' . "Sender Country" . '</td>';
                    echo '<td>' . "Receiver Name" . '</td>';
                    echo '<td>' . "Receiver Company Name" . '</td>';
                    echo '<td>' . "Receiver Address Line 1" . '</td>';
                    echo '<td>' . "Receiver Address Line 2" . '</td>';
                    echo '<td>' . "Receiver City" . '</td>';
                    echo '<td>' . "Receiver State" . '</td>';
                    echo '<td>' . "Receiver Postal" . '</td>';
                    echo '<td>' . "Receiver Country" . '</td>';
                    echo '<td>' . "Third Party Name" . '</td>';
                    echo '<td>' . "Third Party Company Name" . '</td>';
                    echo '<td>' . "Third Party Address Line 1" . '</td>';
                    echo '<td>' . "Third Party Address Line 2" . '</td>';
                    echo '<td>' . "Third Party City" . '</td>';
                    echo '<td>' . "Third Party State" . '</td>';
                    echo '<td>' . "Third Party Postal" . '</td>';
                    echo '<td>' . "Third Party Country" . '</td>';
                    echo '<td>' . "Sold To Name" . '</td>';
                    echo '<td>' . "Sold To Company Name" . '</td>';
                    echo '<td>' . "Sold To Address Line 1" . '</td>';
                    echo '<td>' . "Sold To Address Line 2" . '</td>';
                    echo '<td>' . "Sold To City" . '</td>';
                    echo '<td>' . "Sold To State" . '</td>';
                    echo '<td>' . "Sold To Postal" . '</td>';
                    echo '<td>' . "Sold To Country" . '</td>';
                    echo '<td>' . "Miscellaneous Address Qual 1" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 Name" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 Company Name" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 Address Line 1" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 Address Line 2" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 City" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 State" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 Postal" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 Country" . '</td>';
                    echo '<td>' . "Miscellaneous Address Qual 2" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 Name" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 Company Name" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 Address Line 1" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 Address Line 2" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 City" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 State" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 Postal" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 Country" . '</td>';
                    echo '<td>' . "Shipment Date" . '</td>';
                    echo '<td>' . "Shipment Export Date" . '</td>';
                    echo '<td>' . "Shipment Import Date" . '</td>';
                    echo '<td>' . "Entry Date" . '</td>';
                    echo '<td>' . "Direct Shipment Date" . '</td>';
                    echo '<td>' . "Shipment Delivery Date" . '</td>';
                    echo '<td>' . "Shipment Release Date" . '</td>';
                    echo '<td>' . "Cycle Date" . '</td>';
                    echo '<td>' . "EFT Date" . '</td>';
                    echo '<td>' . "Validation Date" . '</td>';
                    echo '<td>' . "Entry Port" . '</td>';
                    echo '<td>' . "Entry Number" . '</td>';
                    echo '<td>' . "Export Place" . '</td>';
                    echo '<td>' . "Shipment Value Amount" . '</td>';
                    echo '<td>' . "Shipment Description" . '</td>';
                    echo '<td>' . "Entered Currency Code" . '</td>';
                    echo '<td>' . "Customs Number" . '</td>';
                    echo '<td>' . "Exchange Rate" . '</td>';
                    echo '<td>' . "Master Air Waybill Number" . '</td>';
                    echo '<td>' . "EPU" . '</td>';
                    echo '<td>' . "Entry Type" . '</td>';
                    echo '<td>' . "CPC Code" . '</td>';
                    echo '<td>' . "Line Item Number" . '</td>';
                    echo '<td>' . "Goods Description" . '</td>';
                    echo '<td>' . "Entered Value" . '</td>';
                    echo '<td>' . "Duty Amount" . '</td>';
                    echo '<td>' . "Weight" . '</td>';
                    echo '<td>' . "Unit of Measure	Item Quantity" . '</td>';
                    echo '<td>' . "Item Quantity Unit of Measure" . '</td>';
                    echo '<td>' . "Import Tax ID" . '</td>';
                    echo '<td>' . "Declaration Number" . '</td>';
                    echo '<td>' . "Carrier Name/Clinical Trial Identification Number/SDS ID" . '</td>';
                    echo '<td>' . "CCCD Number" . '</td>';
                    echo '<td>' . "Cycle Number" . '</td>';
                    echo '<td>' . "Foreign Trade Reference Number" . '</td>';
                    echo '<td>' . "Job Number" . '</td>';
                    echo '<td>' . "Transport Mode" . '</td>';
                    echo '<td>' . "Tax Type" . '</td>';
                    echo '<td>' . "Tariff Code" . '</td>';
                    echo '<td>' . "Tariff Rate" . '</td>';
                    echo '<td>' . "Tariff Treatment Number" . '</td>';
                    echo '<td>' . "Contact Name" . '</td>';
                    echo '<td>' . "Class Number" . '</td>';
                    echo '<td>' . "Document Type" . '</td>';
                    echo '<td>' . "Office Number" . '</td>';
                    echo '<td>' . "Document Number" . '</td>';
                    echo '<td>' . "Duty Value" . '</td>';
                    echo '<td>' . "Total Value for Duty" . '</td>';
                    echo '<td>' . "Excise Tax Amount" . '</td>';
                    echo '<td>' . "Excise Tax Rate" . '</td>';
                    echo '<td>' . "GST Amount" . '</td>';
                    echo '<td>' . "GST Rate" . '</td>';
                    echo '<td>' . "Order In Council" . '</td>';
                    echo '<td>' . "Origin Country" . '</td>';
                    echo '<td>' . "SIMA Access" . '</td>';
                    echo '<td>' . "Tax Value" . '</td>';
                    echo '<td>' . "Total Customs Amount" . '</td>';
                    echo '<td>' . "Miscellaneous Line 1" . '</td>';
                    echo '<td>' . "Miscellaneous Line 2" . '</td>';
                    echo '<td>' . "Miscellaneous Line 3" . '</td>';
                    echo '<td>' . "Miscellaneous Line 4" . '</td>';
                    echo '<td>' . "Miscellaneous Line 5" . '</td>';
                    echo '<td>' . "Miscellaneous Line 7" . '</td>';
                    echo '<td>' . "Miscellaneous Line 8" . '</td>';
                    echo '<td>' . "Miscellaneous Line 9" . '</td>';
                    echo '<td>' . "Miscellaneous Line 10" . '</td>';
                    echo '<td>' . "Miscellaneous Line 11" . '</td>';
                    echo '<td>' . "Payor Role Code" . '</td>';
                    echo '<td>' . "Duty Rate" . '</td>';
                    echo '<td>' . "VAT Basis Amount" . '</td>';
                    echo '<td>' . "VAT Amount" . '</td>';
                    echo '<td>' . "VAT Rate" . '</td>';
                    echo '<td>' . "Other Basis Amount" . '</td>';
                    echo '<td>' . "Other Amount" . '</td>';
                    echo '<td>' . "Other Rate" . '</td>';
                    echo '<td>' . "Other Customs Number Indicator" . '</td>';
                    echo '<td>' . "Other Customs Number" . '</td>';
                    echo '<td>' . "Customs Office Name" . '</td>';
                    echo '<td>' . "Package Dimension Unit Of Measure" . '</td>';
                    echo '<td>' . "Original Shipment Package Quantity" . '</td>';
                    echo '<td>' . "Corrected Zone" . '</td>';
                    echo '<td>' . "Tax Law Article Number" . '</td>';
                    echo '<td>' . "Tax Law Article Basis Amount" . '</td>';
                    echo '<td>' . "Original tracking number" . '</td>';
                    echo '<td>' . "Scale weight quantity" . '</td>';
                    echo '<td>' . "Scale Weight Unit of Measure" . '</td>';
                    echo '<td>' . "Raw dimension unit of measure" . '</td>';
                    echo '<td>' . "Raw dimension length" . '</td>';
                    echo '<td>' . "BOL # 1" . '</td>';
                    echo '<td>' . "BOL # 2" . '</td>';
                    echo '<td>' . "BOL # 3" . '</td>';
                    echo '<td>' . "BOL # 4" . '</td>';
                    echo '<td>' . "BOL # 5" . '</td>';
                    echo '<td>' . "PO # 1" . '</td>';
                    echo '<td>' . "PO # 2" . '</td>';
                    echo '<td>' . "PO # 3" . '</td>';
                    echo '<td>' . "PO # 4" . '</td>';
                    echo '<td>' . "PO # 5" . '</td>';
                    echo '<td>' . "PO # 6" . '</td>';
                    echo '<td>' . "PO # 7" . '</td>';
                    echo '<td>' . "PO # 8" . '</td>';
                    echo '<td>' . "PO # 9" . '</td>';
                    echo '<td>' . "PO # 10" . '</td>';
                    echo '<td>' . "NMFC" . '</td>';
                    echo '<td>' . "Detail Class" . '</td>';
                    echo '<td>' . "Freight Sequence Number" . '</td>';
                    echo '<td>' . "Declared Freight Class" . '</td>';
                    echo '<td>' . "EORI Number" . '</td>';
                    echo '<td>' . "Detail Keyed Dim" . '</td>';
                    echo '<td>' . "Detail Keyed Unit of Measure" . '</td>';
                    echo '<td>' . "Detail Keyed Billed Dimension" . '</td>';
                    echo '<td>' . "Detail Keyed Billed Unit of Measure" . '</td>';
                    echo '<td>' . "Original Service Description" . '</td>';
                    echo '<td>' . "Promo Discount Applied Indicator" . '</td>';
                    echo '<td>' . "Promo Discount Alias" . '</td>';
                    echo '<td>' . "SDS Match Level Cd" . '</td>';
                    echo '<td>' . "SDS RDR Date" . '</td>';
                    echo '<td>' . "SDS Delivery Date" . '</td>';
                    echo '<td>' . "SDS Error Code" . '</td>';
                    echo '<td>' . "Place Holder 46" . '</td>';
                    echo '<td>' . "Place Holder 47" . '</td>';
                    echo '<td>' . "Place Holder 48" . '</td>';
                    echo '<td>' . "Place Holder 49" . '</td>';
                    echo '<td>' . "Place Holder 50" . '</td>';
                    echo '<td>' . "Place Holder 51" . '</td>';
                    echo '<td>' . "Place Holder 52" . '</td>';
                    echo '<td>' . "Place Holder 53" . '</td>';
                    echo '<td>' . "Place Holder 54" . '</td>';
                    echo '<td>' . "Place Holder 55" . '</td>';
                    echo '<td>' . "Place Holder 56" . '</td>';
                    echo '<td>' . "Place Holder 57" . '</td>';
                    echo '<td>' . "Place Holder 58" . '</td>';
                    echo '<td>' . "Place Holder 59" . '</td>';
                    echo '</tr></thead>';

                    $i = 0;
                    $data = array();
                    $i_date = array(4, 11, 62, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 233, 234);
                    $i_float = array(0, 10, 26, 28, 48, 51, 52, 54, 55, 57, 58, 59, 60, 61, 129, 133, 140, 141, 142, 156, 163, 164, 165, 166, 167, 168, 171, 172, 173, 185, 186, 187, 188, 189, 190, 191, 199);
                    $i_int = array(18, 19, 138, 144, 179, 196, 201, 222, 223);
                    while (($data[$i] = fgetcsv($file_open)) !== false) {
                        echo '<tr>';
                        $count = 0;
                        while ($count <= 249) { //($data[$i] as &$val) {
                            if (count($data[$i]) <= 250) {
                                if ($count > (count($data[$i]) - 1)) {
                                    $val = "";
                                } else {
                                    $val = $data[$i][$count];
                                }
                            }


                            //date filter
                            if (in_array($count, $i_date)) {
                                if (strlen($val) == 5) {
                                    $val = gmdate("Y-m-d", (($val - 25569) * 86400));   //index 0 should date format
                                } elseif ((strlen($val) <= 10) && (strlen($val) >= 8)) {
                                    $val = date('Y-m-d', strtotime($val));
                                } else {
                                    //NULL data
                                    $val = "1990-09-12";
                                }
                            }

                            //integer filter
                            if (in_array($count, $i_float)) {
                                if ($val == "" || $val == null) {
                                    $val = -1;
                                }
                            }

                            //float filter
                            if (in_array($count, $i_int)) {
                                if ($val == "" || $val == null) {
                                    $val = -1;
                                }
                            }

                            if (is_string($val)) {
                                $val = addslashes($val);
                            }

                            $data[$i][$count] = $val;
                            echo '<td>' . $data[$i][$count] . '</td>';
                            $count++;
                        }
                        echo '</tr>';
                        $i++;
                        //unset($data);
                    }
                } else {
                    echo '<script>alert("Please choose File Type");</script>';
                }

                fclose($file_open);
                echo '</table>';
            }

            if (isset($_POST["upload_data"])) {
                $filetype = $_POST['file_type'];
                $file = $_FILES["file_data"]["tmp_name"];
                if ($file == "") {
                    echo '<script>alert("Please choose the File");</script>';
                    exit();
                }

                $namedata = $_FILES['file_data']['name'];
                //file data exist check
                $check_aws_query = "SELECT * FROM filedata WHERE (name_file = '$namedata')";
                $check_aws_result = mysqli_query($conn, $check_aws_query);
                $check_aws_data = mysqli_fetch_array($check_aws_result, MYSQLI_NUM);

                if ($check_aws_data[0] > 1) {
                    echo '<script>alert("File Name Already in Exists");</script>';
                    exit();
                }

                echo '<legend>' . $namedata . '</legend>';
                $file_open = fopen($file, "r");
                $header = fgetcsv($file_open);
                
                if ($filetype == "wms") {
                    //wms
                    echo '<table id="table" class="table table-bordered">';
                    echo '<thead><tr>';
                    $i_date = array();
                    $i = 0;
                    $count = 0;
                    foreach ($header as &$head) {
                        if ($head == "ship_dt") {
                            $i_date[$i] = $count;
                            $i++;
                        }
                        echo '<td>' . $head . '</td>';
                        $count++;
                    }
                    echo '</tr></thead>';

                    $i = 0;
                    $data = array();
                    while (($data[$i] = fgetcsv($file_open)) !== false) {
                        echo '<tr>';
                        $count = 0;
                        foreach ($data[$i] as &$val) {
                            foreach ($i_date as &$dateindex) {
                                if ($count == $dateindex) {  //date convert
                                    if (strlen($val) == 5) {
                                        $val = gmdate("Y-m-d", (($val - 25569) * 86400));   //index 0 should date format
                                    } elseif ((strlen($val) <= 10) && (strlen($val) >= 8)) {
                                        $val = date('Y-m-d', strtotime($val));
                                    } else {
                                        //Default value NULL data
                                        $val = "1990-09-12";
                                    }
                                }
                            }

                            if (is_string($val)) {
                                $val = addslashes($val);
                            }

                            $data[$i][$count] = $val;
                            echo '<td>' . $data[$i][$count] . '</td>';
                            $count++;
                        }
                        $data2 = $data[$i];

                        if ($data2[0] != "") {
                            $sql1_1 = "INSERT INTO wms (name_file, accountid, trans_no, order_no, po_no, so_no, ship_dt, ship_to, carrier, shipmentid, trackingid, 
                                        invoice, actual, effective, zip, weight_item, length_item, width, height) 
                                        VALUES ('$namedata','$data2[0]','$data2[1]','$data2[2]','$data2[3]','$data2[4]','$data2[5]','$data2[6]','$data2[7]','$data2[8]',
                                        '$data2[9]','$data2[10]','$data2[11]','$data2[12]','$data2[13]','$data2[14]','$data2[15]','$data2[16]','$data2[17]')";
                            if (mysqli_query($conn, $sql1_1)) {
                                $result =  "New record created successfully<br>";
                            } else {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn) . "<br>";
                                print_r($data2);
                                echo "<br>";
                            }
                        }

                        echo '</tr>';
                        $i++;
                        //unset($data);
                    }
                    //file data input
                    $today = date("Y-m-d");
                    //$file_type = "aws_dtrans";
                    $sql1_2 = "INSERT INTO filedata (name_file, date_created, filetype) VALUES ('$namedata', '$today', '$filetype')";
                    if (mysqli_query($conn, $sql1_2)) {
                        echo "New FILE record created successfully<br>";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    echo '<script>alert("File data uploaded");</script>';
                } elseif ($filetype == "ups_dtrans") {
                    //ups - dtrans
                    echo '<table id="table" class="table table-bordered">';
                    echo '<thead><tr>';
                    $i_date = array();
                    $i_float = array();
                    $i_int = array();
                    $i = 0;
                    $i2 = 0;
                    $i3 = 0;
                    $count = 0;
                    foreach ($header as &$head) {
                        //date check
                        if (strpos(strtolower($head), "date") !== false) {
                            $i_date[$i] = $count;
                            $i++;
                        }
                        //float check
                        //version_item dtrans misc_incentive_amount misc_net_amount alternate_invoice_amount invoice_exchange_rate tax_variance_amount currency_variance_amount invoice_level_charge shipment_value_amount exchange_rate entered_value duty_amount weight_item tariff_rate duty_value total_duty_value excise_tax_amount excise_tax_rate gst_amount gst_rate sima_access tax_value total_customs_amount duty_rate vat_vasis_amount vat_amount vat_rate other_basis_amount other_amount other_rate tax_law_article_basis_amount
                        if (
                            strpos(strtolower($head), "amount") !== false || strpos(strtolower($head), "rate") !== false || strpos(strtolower($head), "value") !== false ||
                            ($head == "Version") || ($head == "Invoice Level Charge") || ($head == "Weight") || ($head == "SIMA Access")
                        ) {
                            $i_float[$i2] = $count;
                            $i2++;
                        }

                        //int check
                        // declared_freight_class
                        if (strpos(strtolower($head), "quantity") !== false || ($head == "Line Item Number") || ($head == "Payor Role Code") || ($head == "Freight Sequence Number") || ($head == "Declared Freight Class")) {
                            $i_int[$i3] = $count;
                            $i3++;
                        }

                        echo '<td>' . $head . '</td>';
                        $count++;
                    }
                    echo '</tr></thead>';

                    $i = 0;
                    $data = array();
                    while (($data[$i] = fgetcsv($file_open)) !== false) {
                        echo '<tr>';
                        $count = 0;
                        foreach ($data[$i] as &$val) {
                            if (in_array($count, $i_date)) {
                                if (strlen($val) == 5) {
                                    $val = gmdate("Y-m-d", (($val - 25569) * 86400));   //index 0 should date format
                                } elseif ((strlen($val) <= 10) && (strlen($val) >= 8)) {
                                    $val = date('Y-m-d', strtotime($val));
                                } else {
                                    //NULL data
                                    $val = "1990-09-12";
                                }
                            }

                            if (in_array($count, $i_float)) {
                                if ($val == "" || $val == null) {
                                    $val = -1;
                                }
                            }

                            if (in_array($count, $i_int)) {
                                if ($val == "" || $val == null) {
                                    $val = -1;
                                }
                            }

                            if (is_string($val)) {
                                $val = addslashes($val);
                            }

                            $data[$i][$count] = $val;
                            echo '<td>' . $data[$i][$count] . '</td>';
                            $count++;
                        }
                        $data2 = $data[$i];

                        //data input index 6 / 16 / 25 / 36 / 45 / 52 / 63 / 73 / 82 / 92 / 101 / 110 / 120 / 132 / 142 / 154 / 167 / 181 / 188 / 199 / 216 / 223 / 233
                        $sql2_1 = "INSERT INTO ups_dtrans (name_file, version_item, account_country, invoice_date, invoice_type, invoice_type_detail, account_tax_id, pickup_record_num, 
                        lead_shipment_num, transaction_date, world_ease_num, shipment_ref_num1, shipment_ref_num2, bill_option, package_qty, oversize_qty, tracking_num, package_ref_num1, 
                        package_ref_num2, package_ref_num3, package_ref_num4, package_ref_num5, entered_weight, entered_weight_unit, billed_weight, billed_weight_unit, billed_weight_type,
                        container_type, package_dimensions, zone_item, charge_category, charge_category_detail, charge_source, type1, type_detail1, type_detail_value1, type2, type_detail2,
                        type_detail_value2, charge_classificataion, charge_desc_code, charge_desc, transaction_currency, dtrans, misc_currency, misc_incentive_amount, misc_net_amount,
                        alternate_invoicing_currency, alternate_invoice_amount, invoice_exchange_rate, tax_variance_amount, currency_variance_amount, invoice_level_charge, invoice_due_date,
                        alternate_invoice_num, store_num, customer_ref_num, sender_name, sender_company, sender_addr1, sender_addr2, sender_city, sender_state, sender_postal, sender_country,
                        receiver_name, receiver_company, receiver_addr1, receiver_addr2, receiver_city, receiver_state, receiver_postal, receiver_country, third_party_name, third_party_company,
                        third_party_addr1, third_party_addr2, third_party_city, third_party_state, third_party_postal, third_party_country, sold_to_name, sold_to_company, sold_to_addr1, 
                        sold_to_addr2, sold_to_city, sold_to_state, sold_to_postal, sold_to_country, misc_addr_qual1, misc_addr_name1, misc_addr_company1, misc_addr_addr11, misc_addr_addr12, 
                        misc_addr_city1, misc_addr_state1, misc_addr_postal1, misc_addr_country1, misc_addr_qual2, misc_addr_name2, misc_addr_company2, misc_addr_addr21, misc_addr_addr22,
                        misc_addr_city2, misc_addr_state2, misc_addr_postal2, misc_addr_country2, shipment_date, shipment_exp_date, shipment_imp_date, entry_date, direct_shipment_date, 
                        shipment_delivery_date, shipment_release_date, cycle_date, eft_date, validation_date, entry_port, entry_num, exp_place, shipment_value_amount, shipment_desc, 
                        entered_currency, customer_num, exchange_rate, master_air_waybill_num, epu, entery_type, cpc, line_item_num, goods_desc, entered_value, duty_amount, weight_item, 
                        unit_of_measure, item_qty, item_qty_unit_of_measure, imp_tax_id, declaration_num, carrier_name_id_num_sds_id, cccd_num, cycle_num, foreign_table_ref_num, job_num, 
                        transport_mode, tax_type, tariff, tariff_rate, tariff_treatment_num, contact_name, class_num, doc_type, office_num, doc_num, duty_value, total_duty_value, 
                        excise_tax_amount, excise_tax_rate, gst_amount, gst_rate, order_council, origin_country, sima_access, tax_value, total_customs_amount, misc1, misc2, misc3, misc4, 
                        misc5, misc7, misc8, misc9, misc10, misc11, payer_role, duty_rate, vat_vasis_amount, vat_amount, vat_rate, other_basis_amount, other_amount, other_rate, 
                        other_customs_num_indicator, other_customs_num, customs_office_name, pacakage_dimension_unit, original_shipment_package_qty, corrected_zone, tax_law_article_num, 
                        tax_law_article_basis_amount, original_tracaking_num, scale_weight_qty, scale_weight_unit, raw_dimension_unit, raw_dimension_length, bol1, bol2, bol3, bol4, bol5, 
                        po1, po2, po3, po4, po5, po6, po7, po8, po9, po10, nmfc, detail_class, freight_seq_num, declared_freight_class, eori_num, detail_keyed_dim, detail_keyed_unit, 
                        detail_keyed_billed_dimension, detail_keyed_billed_unit, original_service_desc, promo_discount_aplied, promo_discount_aliasa, sds_match_level_cd, sds_rdr_date, 
                        sds_delivery_date, sds_error, place_holder46, place_holder47, place_holder48, place_holder49, place_holder50, place_holder51, place_holder52, place_holder53, 
                        place_holder54, place_holder55, place_holder56, place_holder57, place_holder58, place_holder59) 
                        VALUES ('$namedata','$data2[0]','$data2[1]','$data2[2]','$data2[3]','$data2[4]','$data2[5]','$data2[7]',
                                '$data2[8]','$data2[6]','$data2[9]','$data2[10]','$data2[11]','$data2[12]','$data2[13]','$data2[14]','$data2[15]','$data2[16]',
                                '$data2[17]','$data2[18]','$data2[19]','$data2[20]','$data2[21]','$data2[22]','$data2[23]','$data2[24]','$data2[25]',
                                '$data2[26]', '$data2[27]', '$data2[28]', '$data2[29]', '$data2[30]', '$data2[31]', '$data2[32]', '$data2[33]', '$data2[34]', '$data2[35]', '$data2[36]',
                                '$data2[37]', '$data2[38]', '$data2[39]', '$data2[40]', '$data2[41]', '$data2[42]', '$data2[43]', '$data2[44]', '$data2[45]', 
                                '$data2[46]', '$data2[47]', '$data2[48]', '$data2[49]', '$data2[50]', '$data2[51]', '$data2[52]', 
                                '$data2[53]', '$data2[54]', '$data2[55]', '$data2[56]', '$data2[57]', '$data2[58]', '$data2[59]', '$data2[60]', '$data2[61]', '$data2[62]', '$data2[63]', 
                                '$data2[64]', '$data2[65]', '$data2[66]', '$data2[67]', '$data2[68]', '$data2[69]', '$data2[70]', '$data2[71]', '$data2[72]', '$data2[73]', 
                                '$data2[74]', '$data2[75]', '$data2[76]', '$data2[77]', '$data2[78]', '$data2[79]', '$data2[80]', '$data2[81]', '$data2[82]', 
                                '$data2[83]', '$data2[84]', '$data2[85]', '$data2[86]', '$data2[87]', '$data2[88]', '$data2[89]', '$data2[90]', '$data2[91]', '$data2[92]', 
                                '$data2[93]', '$data2[94]', '$data2[95]', '$data2[96]', '$data2[97]', '$data2[98]', '$data2[99]', '$data2[100]', '$data2[101]', 
                                '$data2[102]', '$data2[103]', '$data2[104]', '$data2[105]', '$data2[106]', '$data2[107]', '$data2[108]', '$data2[109]', '$data2[110]', 
                                '$data2[111]', '$data2[112]', '$data2[113]', '$data2[114]', '$data2[115]', '$data2[116]', '$data2[117]', '$data2[118]', '$data2[119]', '$data2[120]', 
                                '$data2[121]', '$data2[122]', '$data2[123]', '$data2[124]', '$data2[125]', '$data2[126]', '$data2[127]', '$data2[128]', '$data2[129]', '$data2[130]', '$data2[131]', '$data2[132]', 
                                '$data2[133]', '$data2[134]', '$data2[135]', '$data2[136]', '$data2[137]', '$data2[138]', '$data2[139]', '$data2[140]', '$data2[141]', '$data2[142]', 
                                '$data2[143]', '$data2[144]', '$data2[145]', '$data2[146]', '$data2[147]', '$data2[148]', '$data2[149]', '$data2[150]', '$data2[151]', '$data2[152]', '$data2[153]', '$data2[154]', 
                                '$data2[155]', '$data2[156]', '$data2[157]', '$data2[158]', '$data2[159]', '$data2[160]', '$data2[161]', '$data2[162]', '$data2[163]', '$data2[164]', '$data2[165]', '$data2[166]', '$data2[167]', 
                                '$data2[168]', '$data2[170]', '$data2[171]', '$data2[172]', '$data2[173]', '$data2[174]', '$data2[169]', '$data2[175]', '$data2[176]', '$data2[177]', '$data2[178]', '$data2[179]', '$data2[180]', '$data2[181]', 
                                '$data2[182]', '$data2[183]', '$data2[184]', '$data2[185]', '$data2[186]', '$data2[187]', '$data2[188]', 
                                '$data2[189]', '$data2[190]', '$data2[191]', '$data2[192]', '$data2[193]', '$data2[194]', '$data2[195]', '$data2[196]', '$data2[197]', '$data2[198]', '$data2[199]', 
                                '$data2[200]', '$data2[201]', '$data2[202]', '$data2[203]', '$data2[204]', '$data2[205]', '$data2[206]', '$data2[207]', '$data2[208]', 
                                '$data2[209]', '$data2[210]', '$data2[211]', '$data2[212]', '$data2[213]', '$data2[214]', '$data2[215]', '$data2[216]', 
                                '$data2[217]', '$data2[218]', '$data2[219]', '$data2[220]', '$data2[221]', '$data2[222]', '$data2[223]', 
                                '$data2[224]', '$data2[225]', '$data2[226]', '$data2[227]', '$data2[228]', '$data2[229]', '$data2[230]', '$data2[231]', '$data2[232]', '$data2[233]', 
                                '$data2[234]', '$data2[235]', '$data2[236]', '$data2[237]', '$data2[238]', '$data2[239]')";

                        if (mysqli_query($conn, $sql2_1)) {
                            $result =  "New record created successfully<br>";
                        } else {
                            echo "Error: " . $sql . "<br>Description: " . mysqli_error($conn) . "<br>";
                            //unset($data2);
                            //echo "ERROR: ";
                            print_r($data2);
                            //echo "<br>";
                        }

                        echo '</tr>';
                        $i++;
                        //unset($data);
                    }
                    //file data input
                    $today = date("Y-m-d");
                    //$file_type = "aws_dtrans";
                    $sql1_2 = "INSERT INTO filedata (name_file, date_created, filetype) VALUES ('$namedata', '$today', '$filetype')";
                    if (mysqli_query($conn, $sql1_2)) {
                        echo "New FILE record created successfully<br>";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    echo '<script>alert("File data uploaded");</script>';
                } elseif ($filetype == "ups_ctk") {
                    //ups - CTK
                    echo '<table id="table" class="table table-bordered">';
                    echo '<thead><tr>';
                    echo '<td>' . "Version" . '</td>';
                    echo '<td>' . "Account Number 1" . '</td>';
                    echo '<td>' . "Account Number 2" . '</td>';
                    echo '<td>' . "Account Country" . '</td>';
                    echo '<td>' . "Invoice Date" . '</td>';
                    echo '<td>' . "Account Number3" . '</td>';
                    echo '<td>' . "Invoice Type Code" . '</td>';
                    echo '<td>' . "Invoice Type Detail Code" . '</td>';
                    echo '<td>' . "Account Tax ID" . '</td>';
                    echo '<td>' . "Unit of Total Amount" . '</td>';
                    echo '<td>' . "Total Amount" . '</td>';
                    echo '<td>' . "Transaction Date" . '</td>';
                    echo '<td>' . "Pickup Record Number" . '</td>';
                    echo '<td>' . "Lead Shipment Number" . '</td>';
                    echo '<td>' . "World Ease Number" . '</td>';
                    echo '<td>' . "Shipment" . '</td>';
                    echo '<td>' . "Reference Number 1" . '</td>';
                    echo '<td>' . "Reference Number 2" . '</td>';
                    echo '<td>' . "Bill Option Code" . '</td>';
                    echo '<td>' . "Package Quantity" . '</td>';
                    echo '<td>' . "Oversize Quantity" . '</td>';
                    echo '<td>' . "Tracking Number" . '</td>';
                    echo '<td>' . "Package Reference Number 1" . '</td>';
                    echo '<td>' . "Package Reference Number 2" . '</td>';
                    echo '<td>' . "Package Reference Number 3" . '</td>';
                    echo '<td>' . "Package Reference Number 4" . '</td>';
                    echo '<td>' . "Package Reference Number 5" . '</td>';
                    echo '<td>' . "Entered Weight" . '</td>';
                    echo '<td>' . "Entered Weight Unit of Measure" . '</td>';
                    echo '<td>' . "Billed Weight" . '</td>';
                    echo '<td>' . "Billed Weight Unit of Measure" . '</td>';
                    echo '<td>' . "Container Type" . '</td>';
                    echo '<td>' . "Billed Weight Type" . '</td>';
                    echo '<td>' . "Package Dimensions" . '</td>';
                    echo '<td>' . "Zone" . '</td>';
                    echo '<td>' . "Charge Category Code" . '</td>';
                    echo '<td>' . "Charge Category Detail Code" . '</td>';
                    echo '<td>' . "Charge Source" . '</td>';
                    echo '<td>' . "Type Code 1" . '</td>';
                    echo '<td>' . "Type Detail Code 1" . '</td>';
                    echo '<td>' . "Type Detail Value 1" . '</td>';
                    echo '<td>' . "Type Code 2" . '</td>';
                    echo '<td>' . "Type Detail Code 2" . '</td>';
                    echo '<td>' . "Type Detail Value 2" . '</td>';
                    echo '<td>' . "Charge Classification Code" . '</td>';
                    echo '<td>' . "Charge Description Code" . '</td>';
                    echo '<td>' . "Charge Description" . '</td>';
                    echo '<td>' . "Temp6" . '</td>';
                    echo '<td>' . "Transaction Currency Code" . '</td>';
                    echo '<td>' . "Temp7" . '</td>';
                    echo '<td>' . "Temp8" . '</td>';
                    echo '<td>' . "Unit of Temp9" . '</td>';
                    echo '<td>' . "Temp10" . '</td>';
                    echo '<td>' . "Temp11" . '</td>';
                    echo '<td>' . "Miscellaneous Currency Code" . '</td>';
                    echo '<td>' . "Miscellaneous Incentive Amount" . '</td>';
                    echo '<td>' . "Miscellaneous Net Amount" . '</td>';
                    echo '<td>' . "Alternate Invoicing Currency Code" . '</td>';
                    echo '<td>' . "Alternate Invoice Amount" . '</td>';
                    echo '<td>' . "Invoice Exchange Rate" . '</td>';
                    echo '<td>' . "Tax Variance Amount" . '</td>';
                    echo '<td>' . "Currency Variance Amount" . '</td>';
                    echo '<td>' . "Invoice Level Charge" . '</td>';
                    echo '<td>' . "Invoice Due Date" . '</td>';
                    echo '<td>' . "Alternate Invoice Number" . '</td>';
                    echo '<td>' . "Store Number" . '</td>';
                    echo '<td>' . "Customer Reference Number" . '</td>';
                    echo '<td>' . "Sender Name" . '</td>';
                    echo '<td>' . "Sender Company Name" . '</td>';
                    echo '<td>' . "Sender Address Line 1" . '</td>';
                    echo '<td>' . "Sender Address Line 2" . '</td>';
                    echo '<td>' . "Sender City" . '</td>';
                    echo '<td>' . "Sender State" . '</td>';
                    echo '<td>' . "Sender Postal" . '</td>';
                    echo '<td>' . "Sender Country" . '</td>';
                    echo '<td>' . "Receiver Name" . '</td>';
                    echo '<td>' . "Receiver Company Name" . '</td>';
                    echo '<td>' . "Receiver Address Line 1" . '</td>';
                    echo '<td>' . "Receiver Address Line 2" . '</td>';
                    echo '<td>' . "Receiver City" . '</td>';
                    echo '<td>' . "Receiver State" . '</td>';
                    echo '<td>' . "Receiver Postal" . '</td>';
                    echo '<td>' . "Receiver Country" . '</td>';
                    echo '<td>' . "Third Party Name" . '</td>';
                    echo '<td>' . "Third Party Company Name" . '</td>';
                    echo '<td>' . "Third Party Address Line 1" . '</td>';
                    echo '<td>' . "Third Party Address Line 2" . '</td>';
                    echo '<td>' . "Third Party City" . '</td>';
                    echo '<td>' . "Third Party State" . '</td>';
                    echo '<td>' . "Third Party Postal" . '</td>';
                    echo '<td>' . "Third Party Country" . '</td>';
                    echo '<td>' . "Sold To Name" . '</td>';
                    echo '<td>' . "Sold To Company Name" . '</td>';
                    echo '<td>' . "Sold To Address Line 1" . '</td>';
                    echo '<td>' . "Sold To Address Line 2" . '</td>';
                    echo '<td>' . "Sold To City" . '</td>';
                    echo '<td>' . "Sold To State" . '</td>';
                    echo '<td>' . "Sold To Postal" . '</td>';
                    echo '<td>' . "Sold To Country" . '</td>';
                    echo '<td>' . "Miscellaneous Address Qual 1" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 Name" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 Company Name" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 Address Line 1" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 Address Line 2" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 City" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 State" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 Postal" . '</td>';
                    echo '<td>' . "Miscellaneous Address 1 Country" . '</td>';
                    echo '<td>' . "Miscellaneous Address Qual 2" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 Name" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 Company Name" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 Address Line 1" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 Address Line 2" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 City" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 State" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 Postal" . '</td>';
                    echo '<td>' . "Miscellaneous Address 2 Country" . '</td>';
                    echo '<td>' . "Shipment Date" . '</td>';
                    echo '<td>' . "Shipment Export Date" . '</td>';
                    echo '<td>' . "Shipment Import Date" . '</td>';
                    echo '<td>' . "Entry Date" . '</td>';
                    echo '<td>' . "Direct Shipment Date" . '</td>';
                    echo '<td>' . "Shipment Delivery Date" . '</td>';
                    echo '<td>' . "Shipment Release Date" . '</td>';
                    echo '<td>' . "Cycle Date" . '</td>';
                    echo '<td>' . "EFT Date" . '</td>';
                    echo '<td>' . "Validation Date" . '</td>';
                    echo '<td>' . "Entry Port" . '</td>';
                    echo '<td>' . "Entry Number" . '</td>';
                    echo '<td>' . "Export Place" . '</td>';
                    echo '<td>' . "Shipment Value Amount" . '</td>';
                    echo '<td>' . "Shipment Description" . '</td>';
                    echo '<td>' . "Entered Currency Code" . '</td>';
                    echo '<td>' . "Customs Number" . '</td>';
                    echo '<td>' . "Exchange Rate" . '</td>';
                    echo '<td>' . "Master Air Waybill Number" . '</td>';
                    echo '<td>' . "EPU" . '</td>';
                    echo '<td>' . "Entry Type" . '</td>';
                    echo '<td>' . "CPC Code" . '</td>';
                    echo '<td>' . "Line Item Number" . '</td>';
                    echo '<td>' . "Goods Description" . '</td>';
                    echo '<td>' . "Entered Value" . '</td>';
                    echo '<td>' . "Duty Amount" . '</td>';
                    echo '<td>' . "Weight" . '</td>';
                    echo '<td>' . "Unit of Measure	Item Quantity" . '</td>';
                    echo '<td>' . "Item Quantity Unit of Measure" . '</td>';
                    echo '<td>' . "Import Tax ID" . '</td>';
                    echo '<td>' . "Declaration Number" . '</td>';
                    echo '<td>' . "Carrier Name/Clinical Trial Identification Number/SDS ID" . '</td>';
                    echo '<td>' . "CCCD Number" . '</td>';
                    echo '<td>' . "Cycle Number" . '</td>';
                    echo '<td>' . "Foreign Trade Reference Number" . '</td>';
                    echo '<td>' . "Job Number" . '</td>';
                    echo '<td>' . "Transport Mode" . '</td>';
                    echo '<td>' . "Tax Type" . '</td>';
                    echo '<td>' . "Tariff Code" . '</td>';
                    echo '<td>' . "Tariff Rate" . '</td>';
                    echo '<td>' . "Tariff Treatment Number" . '</td>';
                    echo '<td>' . "Contact Name" . '</td>';
                    echo '<td>' . "Class Number" . '</td>';
                    echo '<td>' . "Document Type" . '</td>';
                    echo '<td>' . "Office Number" . '</td>';
                    echo '<td>' . "Document Number" . '</td>';
                    echo '<td>' . "Duty Value" . '</td>';
                    echo '<td>' . "Total Value for Duty" . '</td>';
                    echo '<td>' . "Excise Tax Amount" . '</td>';
                    echo '<td>' . "Excise Tax Rate" . '</td>';
                    echo '<td>' . "GST Amount" . '</td>';
                    echo '<td>' . "GST Rate" . '</td>';
                    echo '<td>' . "Order In Council" . '</td>';
                    echo '<td>' . "Origin Country" . '</td>';
                    echo '<td>' . "SIMA Access" . '</td>';
                    echo '<td>' . "Tax Value" . '</td>';
                    echo '<td>' . "Total Customs Amount" . '</td>';
                    echo '<td>' . "Miscellaneous Line 1" . '</td>';
                    echo '<td>' . "Miscellaneous Line 2" . '</td>';
                    echo '<td>' . "Miscellaneous Line 3" . '</td>';
                    echo '<td>' . "Miscellaneous Line 4" . '</td>';
                    echo '<td>' . "Miscellaneous Line 5" . '</td>';
                    echo '<td>' . "Miscellaneous Line 7" . '</td>';
                    echo '<td>' . "Miscellaneous Line 8" . '</td>';
                    echo '<td>' . "Miscellaneous Line 9" . '</td>';
                    echo '<td>' . "Miscellaneous Line 10" . '</td>';
                    echo '<td>' . "Miscellaneous Line 11" . '</td>';
                    echo '<td>' . "Payor Role Code" . '</td>';
                    echo '<td>' . "Duty Rate" . '</td>';
                    echo '<td>' . "VAT Basis Amount" . '</td>';
                    echo '<td>' . "VAT Amount" . '</td>';
                    echo '<td>' . "VAT Rate" . '</td>';
                    echo '<td>' . "Other Basis Amount" . '</td>';
                    echo '<td>' . "Other Amount" . '</td>';
                    echo '<td>' . "Other Rate" . '</td>';
                    echo '<td>' . "Other Customs Number Indicator" . '</td>';
                    echo '<td>' . "Other Customs Number" . '</td>';
                    echo '<td>' . "Customs Office Name" . '</td>';
                    echo '<td>' . "Package Dimension Unit Of Measure" . '</td>';
                    echo '<td>' . "Original Shipment Package Quantity" . '</td>';
                    echo '<td>' . "Corrected Zone" . '</td>';
                    echo '<td>' . "Tax Law Article Number" . '</td>';
                    echo '<td>' . "Tax Law Article Basis Amount" . '</td>';
                    echo '<td>' . "Original tracking number" . '</td>';
                    echo '<td>' . "Scale weight quantity" . '</td>';
                    echo '<td>' . "Scale Weight Unit of Measure" . '</td>';
                    echo '<td>' . "Raw dimension unit of measure" . '</td>';
                    echo '<td>' . "Raw dimension length" . '</td>';
                    echo '<td>' . "BOL # 1" . '</td>';
                    echo '<td>' . "BOL # 2" . '</td>';
                    echo '<td>' . "BOL # 3" . '</td>';
                    echo '<td>' . "BOL # 4" . '</td>';
                    echo '<td>' . "BOL # 5" . '</td>';
                    echo '<td>' . "PO # 1" . '</td>';
                    echo '<td>' . "PO # 2" . '</td>';
                    echo '<td>' . "PO # 3" . '</td>';
                    echo '<td>' . "PO # 4" . '</td>';
                    echo '<td>' . "PO # 5" . '</td>';
                    echo '<td>' . "PO # 6" . '</td>';
                    echo '<td>' . "PO # 7" . '</td>';
                    echo '<td>' . "PO # 8" . '</td>';
                    echo '<td>' . "PO # 9" . '</td>';
                    echo '<td>' . "PO # 10" . '</td>';
                    echo '<td>' . "NMFC" . '</td>';
                    echo '<td>' . "Detail Class" . '</td>';
                    echo '<td>' . "Freight Sequence Number" . '</td>';
                    echo '<td>' . "Declared Freight Class" . '</td>';
                    echo '<td>' . "EORI Number" . '</td>';
                    echo '<td>' . "Detail Keyed Dim" . '</td>';
                    echo '<td>' . "Detail Keyed Unit of Measure" . '</td>';
                    echo '<td>' . "Detail Keyed Billed Dimension" . '</td>';
                    echo '<td>' . "Detail Keyed Billed Unit of Measure" . '</td>';
                    echo '<td>' . "Original Service Description" . '</td>';
                    echo '<td>' . "Promo Discount Applied Indicator" . '</td>';
                    echo '<td>' . "Promo Discount Alias" . '</td>';
                    echo '<td>' . "SDS Match Level Cd" . '</td>';
                    echo '<td>' . "SDS RDR Date" . '</td>';
                    echo '<td>' . "SDS Delivery Date" . '</td>';
                    echo '<td>' . "SDS Error Code" . '</td>';
                    echo '<td>' . "Place Holder 46" . '</td>';
                    echo '<td>' . "Place Holder 47" . '</td>';
                    echo '<td>' . "Place Holder 48" . '</td>';
                    echo '<td>' . "Place Holder 49" . '</td>';
                    echo '<td>' . "Place Holder 50" . '</td>';
                    echo '<td>' . "Place Holder 51" . '</td>';
                    echo '<td>' . "Place Holder 52" . '</td>';
                    echo '<td>' . "Place Holder 53" . '</td>';
                    echo '<td>' . "Place Holder 54" . '</td>';
                    echo '<td>' . "Place Holder 55" . '</td>';
                    echo '<td>' . "Place Holder 56" . '</td>';
                    echo '<td>' . "Place Holder 57" . '</td>';
                    echo '<td>' . "Place Holder 58" . '</td>';
                    echo '<td>' . "Place Holder 59" . '</td>';
                    echo '</tr></thead>';

                    $i = 0;
                    $data = array();
                    $i_date = array(4, 11, 62, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 233, 234);
                    $i_float = array(0, 10, 26, 28, 48, 51, 52, 54, 55, 57, 58, 59, 60, 61, 129, 133, 140, 141, 142, 156, 163, 164, 165, 166, 167, 168, 171, 172, 173, 185, 186, 187, 188, 189, 190, 191, 199);
                    $i_int = array(18, 19, 138, 144, 179, 196, 201, 222, 223);
                    while (($data[$i] = fgetcsv($file_open)) !== false) {
                        echo '<tr>';
                        $count = 0;
                        while ($count <= 249) { //($data[$i] as &$val) {
                            if (count($data[$i]) <= 250) {
                                if ($count > (count($data[$i]) - 1)) {
                                    $val = "";
                                } else {
                                    $val = $data[$i][$count];
                                }
                            }


                            //date filter
                            if (in_array($count, $i_date)) {
                                if (strlen($val) == 5) {
                                    $val = gmdate("Y-m-d", (($val - 25569) * 86400));   //index 0 should date format
                                } elseif ((strlen($val) <= 10) && (strlen($val) >= 8)) {
                                    $val = date('Y-m-d', strtotime($val));
                                } else {
                                    //NULL data
                                    $val = "1990-09-12";
                                }
                            }

                            //integer filter
                            if (in_array($count, $i_float)) {
                                if ($val == "" || $val == null) {
                                    $val = -1;
                                }
                            }

                            //float filter
                            if (in_array($count, $i_int)) {
                                if ($val == "" || $val == null) {
                                    $val = -1;
                                }
                            }

                            if (is_string($val)) {
                                $val = addslashes($val);
                            }

                            $data[$i][$count] = $val;
                            echo '<td>' . $data[$i][$count] . '</td>';
                            $count++;
                        }
                        $data2 = $data[$i];

                        $sql2_1 = "INSERT INTO ups_ctk (name_file, 
                        version_item, account_num1, account_num2, account_country, invoice_date, account_num3, invoice_type, invoice_type_detail, account_tax_id, total_amount_unit, 
                        total_amount, pickup_record_num, lead_shipment_num, transaction_date, world_ease_num, shipment_ref_num1, shipment_ref_num2, bill_option, package_qty, oversize_qty, 
                        tracking_num, package_ref_num1, package_ref_num2, package_ref_num3, package_ref_num4, package_ref_num5, entered_weight, entered_weight_unit, billed_weight, billed_weight_unit,
                        billed_weight_type, container_type, package_dimensions, zone_item, charge_category, charge_category_detail, charge_source, type1, type_detail1, type_detail_value1, 
                        type2, type_detail2, type_detail_value2, charge_classificataion, charge_desc_code, charge_desc, temp6, transaction_currency, temp7, temp8,                         
                        temp9_unit, temp10, temp11, misc_currency, misc_incentive_amount, misc_net_amount, alternate_invoicing_currency, alternate_invoice_amount, invoice_exchange_rate, tax_variance_amount, 
                        currency_variance_amount, invoice_level_charge, invoice_due_date, alternate_invoice_num, store_num, customer_ref_num, sender_name, sender_company, sender_addr1, sender_addr2, 
                        sender_city, sender_state, sender_postal, sender_country, receiver_name, receiver_company, receiver_addr1, receiver_addr2, receiver_city, receiver_state, 
                        receiver_postal, receiver_country, third_party_name, third_party_company, third_party_addr1, third_party_addr2, third_party_city, third_party_state, third_party_postal, third_party_country, 
                        sold_to_name, sold_to_company, sold_to_addr1, sold_to_addr2, sold_to_city, sold_to_state, sold_to_postal, sold_to_country, misc_addr_qual1, misc_addr_name1, 
                        misc_addr_company1, misc_addr_addr11, misc_addr_addr12, misc_addr_city1, misc_addr_state1, misc_addr_postal1, misc_addr_country1, misc_addr_qual2, misc_addr_name2, misc_addr_company2, 
                        misc_addr_addr21, misc_addr_addr22, misc_addr_city2, misc_addr_state2, misc_addr_postal2, misc_addr_country2, shipment_date, shipment_exp_date, shipment_imp_date, entry_date, 
                        direct_shipment_date, shipment_delivery_date, shipment_release_date, cycle_date, eft_date, validation_date, entry_port, entry_num, exp_place, shipment_value_amount, 
                        shipment_desc, entered_currency, customer_num, exchange_rate, master_air_waybill_num, epu, entery_type, cpc, line_item_num, goods_desc, 
                        entered_value, duty_amount, weight_item, unit_of_measure, item_qty, item_qty_unit, imp_tax_id, declaration_num, carrier_name_id_num_sds_id, cccd_num, 
                        cycle_num, foreign_table_ref_num, job_num, transport_mode, tax_type, tariff, tariff_rate, tariff_treatment_num, contact_name, class_num, 
                        doc_type, office_num, doc_num, duty_value, total_duty_value, excise_tax_amount, excise_tax_rate, gst_amount, gst_rate, order_council, 
                        origin_country, sima_access, tax_value, total_customs_amount, misc1, misc2, misc3, misc4, misc5, misc7, 
                        misc8, misc9, misc10, misc11, payer_role, duty_rate, vat_vasis_amount, vat_amount, vat_rate, other_basis_amount, 
                        other_amount, other_rate, other_customs_num_indicator, other_customs_num, customs_office_name, pacakage_dimension_unit, original_shipment_package_qty, corrected_zone, tax_law_article_num, tax_law_article_basis_amount, 
                        original_tracaking_num, scale_weight_qty, scale_weight_unit, raw_dimension_unit, raw_dimension_length, bol1, bol2, bol3, bol4, bol5, 
                        po1, po2, po3, po4, po5, po6, po7, po8, po9, po10,
                        nmfc, detail_class, freight_seq_num, declared_freight_class, eori_num, detail_keyed_dim, detail_keyed_unit, detail_keyed_billed_dimension, detail_keyed_billed_unit, original_service_desc, 
                        promo_discount_aplied, promo_discount_aliasa, sds_match_level_cd, sds_rdr_date, sds_delivery_date, sds_error, place_holder46, place_holder47, place_holder48, place_holder49, 
                        place_holder50, place_holder51, place_holder52, place_holder53, place_holder54, place_holder55, place_holder56, place_holder57, place_holder58, place_holder59) 
                        VALUES ('$namedata', '$data2[0]', '$data2[1]', '$data2[2]', '$data2[3]', '$data2[4]', '$data2[5]', '$data2[6]', '$data2[7]', '$data2[8]', '$data2[9]',
                        '$data2[10]', '$data2[12]', '$data2[13]', '$data2[11]', '$data2[14]', '$data2[15]', '$data2[16]', '$data2[17]', '$data2[18]', '$data2[19]',
                        '$data2[20]', '$data2[21]', '$data2[22]', '$data2[23]', '$data2[24]', '$data2[25]', '$data2[26]', '$data2[27]', '$data2[28]', '$data2[29]',
                        '$data2[31]', '$data2[30]', '$data2[32]', '$data2[33]', '$data2[34]', '$data2[35]', '$data2[36]', '$data2[37]', '$data2[38]', '$data2[39]',
                        '$data2[40]', '$data2[41]', '$data2[42]', '$data2[43]', '$data2[44]', '$data2[45]', '$data2[46]', '$data2[47]', '$data2[48]', '$data2[49]',
                        '$data2[50]', '$data2[51]', '$data2[52]', '$data2[53]', '$data2[54]', '$data2[55]', '$data2[56]', '$data2[57]', '$data2[58]', '$data2[59]',
                        '$data2[60]', '$data2[61]', '$data2[62]', '$data2[63]', '$data2[64]', '$data2[65]', '$data2[66]', '$data2[67]', '$data2[68]', '$data2[69]',
                        '$data2[70]', '$data2[71]', '$data2[72]', '$data2[73]', '$data2[74]', '$data2[75]', '$data2[76]', '$data2[77]', '$data2[78]', '$data2[79]',
                        '$data2[80]', '$data2[81]', '$data2[82]', '$data2[83]', '$data2[84]', '$data2[85]', '$data2[86]', '$data2[87]', '$data2[88]', '$data2[89]',
                        '$data2[90]', '$data2[91]', '$data2[92]', '$data2[93]', '$data2[94]', '$data2[95]', '$data2[96]', '$data2[97]', '$data2[98]', '$data2[99]',
                        '$data2[100]', '$data2[101]', '$data2[102]', '$data2[103]', '$data2[104]', '$data2[105]', '$data2[106]', '$data2[107]', '$data2[108]', '$data2[109]',
                        '$data2[110]', '$data2[111]', '$data2[112]', '$data2[113]', '$data2[114]', '$data2[115]', '$data2[116]', '$data2[117]', '$data2[118]', '$data2[119]',
                        '$data2[120]', '$data2[121]', '$data2[122]', '$data2[123]', '$data2[124]', '$data2[125]', '$data2[126]', '$data2[127]', '$data2[128]', '$data2[129]',
                        '$data2[130]', '$data2[131]', '$data2[132]', '$data2[133]', '$data2[134]', '$data2[135]', '$data2[136]', '$data2[137]', '$data2[138]', '$data2[139]',
                        '$data2[140]', '$data2[141]', '$data2[142]', '$data2[143]', '$data2[144]', '$data2[145]', '$data2[146]', '$data2[147]', '$data2[148]', '$data2[149]',
                        '$data2[150]', '$data2[151]', '$data2[152]', '$data2[153]', '$data2[154]', '$data2[155]', '$data2[156]', '$data2[157]', '$data2[158]', '$data2[159]',
                        '$data2[160]', '$data2[161]', '$data2[162]', '$data2[163]', '$data2[164]', '$data2[165]', '$data2[166]', '$data2[167]', '$data2[168]', '$data2[169]',
                        '$data2[170]', '$data2[171]', '$data2[172]', '$data2[173]', '$data2[174]', '$data2[175]', '$data2[176]', '$data2[177]', '$data2[178]', '$data2[180]',
                        '$data2[181]', '$data2[182]', '$data2[183]', '$data2[184]', '$data2[179]', '$data2[185]', '$data2[186]', '$data2[187]', '$data2[188]', '$data2[189]',
                        '$data2[190]', '$data2[191]', '$data2[192]', '$data2[193]', '$data2[194]', '$data2[195]', '$data2[196]', '$data2[197]', '$data2[198]', '$data2[199]',
                        '$data2[200]', '$data2[201]', '$data2[202]', '$data2[203]', '$data2[204]', '$data2[205]', '$data2[206]', '$data2[207]', '$data2[208]', '$data2[209]',
                        '$data2[210]', '$data2[211]', '$data2[212]', '$data2[213]', '$data2[214]', '$data2[215]', '$data2[216]', '$data2[217]', '$data2[218]', '$data2[219]',
                        '$data2[220]', '$data2[221]', '$data2[222]', '$data2[223]', '$data2[224]', '$data2[225]', '$data2[226]', '$data2[227]', '$data2[228]', '$data2[229]',
                        '$data2[230]', '$data2[231]', '$data2[232]', '$data2[233]', '$data2[234]', '$data2[235]', '$data2[236]', '$data2[237]', '$data2[238]', '$data2[239]',
                        '$data2[240]', '$data2[241]', '$data2[242]', '$data2[243]', '$data2[244]', '$data2[245]', '$data2[246]', '$data2[247]', '$data2[248]', '$data2[249]')";

                        if (mysqli_query($conn, $sql2_1)) {
                            $result =  "New record created successfully<br>";
                        } else {
                            echo "Error: " . $sql . "<br>Description: " . mysqli_error($conn) . "<br>";
                            print_r($data2);
                            echo "<br>";
                        }

                        echo '</tr>';
                        $i++;
                        //unset($data);
                    }
                    //file data input
                    $today = date("Y-m-d");
                    //$file_type = "aws_dtrans";
                    $sql1_2 = "INSERT INTO filedata (name_file, date_created, filetype) VALUES ('$namedata', '$today', '$filetype')";
                    if (mysqli_query($conn, $sql1_2)) {
                        echo "New FILE record created successfully<br>";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    echo '<script>alert("File data uploaded");</script>';
                } else {
                    echo '<script>alert("Please choose File Type");</script>';
                }

                fclose($file_open);
                echo '</table>';
            }
            ?>
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
                //order: [0, "desc"],

                // 초기 표시에 경우 정렬 안함
                //order: []

                // 가로 스크롤바를 표시
                // 설정 값은 true 또는 false
                //scrollX: true,

                // 세로 스크롤바를 표시
                // 설정 값은 px단위
                //scrollY: 200

                //// 스크롤바 설정
                scrollX: true,
                //scrollY: 200,

                // 열 넓이 설정
                //columnDefs: [
                // 2번째 항목 넓이를 100px로 설정
                //{ targets: 1, width: 100 }
                //]
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
    </script>

    <?php
    require '../templates/footer.php';
    ?>
</body>

</html>