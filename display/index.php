<!doctype html>
<html lang="en">

<head>
    <title>CTK USA Invoice Generator</title>
</head>

<body>
    <?php
    $name_file = $_GET['name_file'];
    $type_file = $_GET['type_file'];
    require '../templates/navbar.php';
    require 'data.php';
    ?>

    <div class="w3-content" style="max-width:2000px;margin-top:60px;padding-right:30px;padding-left:30px;">
        <!-- Page content -->
        <legend><?php echo $name_file; ?> File data</legend>

        <table id="table" class="table table-bordered">
            <?php
            //SELECT column_name FROM information_schema.columns WHERE table_schema = 'invoice' AND table_name = 'aws'
            if ($type_file == "wms") {
                echo '
                    <thead>
                        <tr>							  	  	  					
                            <td>accountid</td>
                            <td>trans_no</td>
                            <td>order_no</td>
                            <td>po_no</td>
                            <td>so_no</td>
                            <td>ship_dt</td>
                            <td>ship_to</td>
                            <td>carrier</td>
                            <td>shipmentid</td>
                            <td>trackingid</td>
                            <td>invoice</td>
                            <td>actual</td>
                            <td>effective</td>
                            <td>zip</td>
                            <td>weight</td>
                            <td>length</td>
                            <td>width</td>
                            <td>height</td>
                        </tr>
                    </thead>

                ';
                while ($row = mysqli_fetch_array($result)) {
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
            } elseif ($type_file == "ups_dtrans") {
                echo '
                    <thead>
                        <tr>							  	  	  					
                            <td>Version</td>
                            <td>Account Country</td>
                            <td>Invoice Date</td>
                            <td>Invoice Type Code</td>
                            <td>Invoice Type Detail Code</td>
                            <td>Account Tax ID</td>
                            <td>Pickup Record Number</td>
                            <td>Lead Shipment Number</td>
                            <td>Transaction Date</td>
                            <td>World Ease Number</td>
                            <td>Shipment Reference Number 1</td>
                            <td>Shipment Reference Number 2</td>
                            <td>Bill Option Code</td>
                            <td>Package Quantity</td>
                            <td>Oversize Quantity</td>
                            <td>Tracking Number</td>
                            <td>Package Reference Number 1</td>
                            <td>Package Reference Number 2</td>
                            <td>Package Reference Number 3</td>
                            <td>Package Reference Number 4</td>
                            <td>Package Reference Number 5</td>
                            <td>Entered Weight</td>
                            <td>Entered Weight Unit of Measure</td>
                            <td>Billed Weight</td>
                            <td>Billed Weight Unit of Measure</td>
                            <td>Container Type</td>
                            <td>Billed Weight Type</td>
                            <td>Package Dimensions</td>
                            <td>Zone</td>
                            <td>Charge Category Code</td>
                            <td>Charge Category Detail Code</td>
                            <td>Charge Source</td>
                            <td>Type Code 1</td>
                            <td>Type Detail Code 1</td>
                            <td>Type Detail Value 1</td>
                            <td>Type Code 2</td>
                            <td>Type Detail Code 2</td>
                            <td>Type Detail Value 2</td>
                            <td>Charge Classification Code</td>
                            <td>Charge Description Code</td>
                            <td>Charge Description</td>
                            <td>Transaction Currency Code</td>
                            <td>Dtrans</td>
                            <td>Miscellaneous Currency Code</td>
                            <td>Miscellaneous Incentive Amount</td>
                            <td>Miscellaneous Net Amount</td>
                            <td>Alternate Invoicing Currency Code</td>
                            <td>Alternate Invoice Amount</td>
                            <td>Invoice Exchange Rate</td>
                            <td>Tax Variance Amount</td>
                            <td>Currency Variance Amount</td>
                            <td>Invoice Level Charge</td>
                            <td>Invoice Due Date</td>
                            <td>Alternate Invoice Number</td>
                            <td>Store Number</td>
                            <td>Customer Reference Number</td>
                            <td>Sender Name</td>
                            <td>Sender Company Name</td>
                            <td>Sender Address Line 1</td>
                            <td>Sender Address Line 2</td>
                            <td>Sender City</td>
                            <td>Sender State</td>
                            <td>Sender Postal</td>
                            <td>Sender Country</td>
                            <td>Receiver Name</td>
                            <td>Receiver Company Name</td>
                            <td>Receiver Address Line 1</td>
                            <td>Receiver Address Line 2</td>
                            <td>Receiver City</td>
                            <td>Receiver State</td>
                            <td>Receiver Postal</td>
                            <td>Receiver Country</td>
                            <td>Third Party Name</td>
                            <td>Third Party Company Name</td>
                            <td>Third Party Address Line 1</td>
                            <td>Third Party Address Line 2</td>
                            <td>Third Party City</td>
                            <td>Third Party State</td>
                            <td>Third Party Postal</td>
                            <td>Third Party Country</td>
                            <td>Sold To Name</td>
                            <td>Sold To Company Name</td>
                            <td>Sold To Address Line 1</td>
                            <td>Sold To Address Line 2</td>
                            <td>Sold To City</td>
                            <td>Sold To State</td>
                            <td>Sold To Postal</td>
                            <td>Sold To Country</td>
                            <td>Miscellaneous Address Qual 1</td>
                            <td>Miscellaneous Address 1 Name</td>
                            <td>Miscellaneous Address 1 Company Name</td>
                            <td>Miscellaneous Address 1 Address Line 1</td>
                            <td>Miscellaneous Address 1 Address Line 2</td>
                            <td>Miscellaneous Address 1 City</td>
                            <td>Miscellaneous Address 1 State</td>
                            <td>Miscellaneous Address 1 Postal</td>
                            <td>Miscellaneous Address 1 Country</td>
                            <td>Miscellaneous Address Qual 2</td>
                            <td>Miscellaneous Address 2 Name</td>
                            <td>Miscellaneous Address 2 Company Name</td>
                            <td>Miscellaneous Address 2 Address Line 1</td>
                            <td>Miscellaneous Address 2 Address Line 2</td>
                            <td>Miscellaneous Address 2 City</td>
                            <td>Miscellaneous Address 2 State</td>
                            <td>Miscellaneous Address 2 Postal</td>
                            <td>Miscellaneous Address 2 Country</td>
                            <td>Shipment Date</td>
                            <td>Shipment Export Date</td>
                            <td>Shipment Import Date</td>
                            <td>Entry Date</td>
                            <td>Direct Shipment Date</td>
                            <td>Shipment Delivery Date</td>
                            <td>Shipment Release Date</td>
                            <td>Cycle Date</td>
                            <td>EFT Date</td>
                            <td>Validation Date</td>
                            <td>Entry Port</td>
                            <td>Entry Number</td>
                            <td>Export Place</td>
                            <td>Shipment Value Amount</td>
                            <td>Shipment Description</td>
                            <td>Entered Currency Code</td>
                            <td>Customs Number</td>
                            <td>Exchange Rate</td>
                            <td>Master Air Waybill Number</td>
                            <td>EPU</td>
                            <td>Entry Type</td>
                            <td>CPC Code</td>
                            <td>Line Item Number</td>
                            <td>Goods Description</td>
                            <td>Entered Value</td>
                            <td>Duty Amount</td>
                            <td>Weight</td>
                            <td>Unit of Measure</td>
                            <td>Item Quantity</td>
                            <td>Item Quantity Unit of Measure</td>
                            <td>Import Tax ID</td>
                            <td>Declaration Number</td>
                            <td>Carrier Name/Clinical Trial Identification Number/SDS ID</td>
                            <td>CCCD Number</td>
                            <td>Cycle Number</td>
                            <td>Foreign Trade Reference Number</td>
                            <td>Job Number</td>
                            <td>Transport Mode</td>
                            <td>Tax Type</td>
                            <td>Tariff Code</td>
                            <td>Tariff Rate</td>
                            <td>Tariff Treatment Number</td>
                            <td>Contact Name</td>
                            <td>Class Number</td>
                            <td>Document Type</td>
                            <td>Office Number</td>
                            <td>Document Number</td>
                            <td>Duty Value</td>
                            <td>Total Value for Duty</td>
                            <td>Excise Tax Amount</td>
                            <td>Excise Tax Rate</td>
                            <td>GST Amount</td>
                            <td>GST Rate</td>
                            <td>Order In Council</td>
                            <td>Origin Country</td>
                            <td>SIMA Access</td>
                            <td>Tax Value</td>
                            <td>Total Customs Amount</td>
                            <td>Miscellaneous Line 1</td>
                            <td>Miscellaneous Line 2</td>
                            <td>Miscellaneous Line 3</td>
                            <td>Miscellaneous Line 4</td>
                            <td>Miscellaneous Line 5</td>
                            <td>Miscellaneous Line 7</td>
                            <td>Miscellaneous Line 8</td>
                            <td>Miscellaneous Line 9</td>
                            <td>Miscellaneous Line 10</td>
                            <td>Miscellaneous Line 11</td>
                            <td>Payor Role Code</td>
                            <td>Duty Rate</td>
                            <td>VAT Basis Amount</td>
                            <td>VAT Amount</td>
                            <td>VAT Rate</td>
                            <td>Other Basis Amount</td>
                            <td>Other Amount</td>
                            <td>Other Rate</td>
                            <td>Other Customs Number Indicator</td>
                            <td>Other Customs Number</td>
                            <td>Customs Office Name</td>
                            <td>Package Dimension Unit Of Measure</td>
                            <td>Original Shipment Package Quantity</td>
                            <td>Corrected Zone</td>
                            <td>Tax Law Article Number</td>
                            <td>Tax Law Article Basis Amount</td>
                            <td>Original tracking number</td>
                            <td>Scale weight quantity</td>
                            <td>Scale Weight Unit of Measure</td>
                            <td>Raw dimension unit of measure</td>
                            <td>Raw dimension length</td>
                            <td>BOL # 1</td>
                            <td>BOL # 2</td>
                            <td>BOL # 3</td>
                            <td>BOL # 4</td>
                            <td>BOL # 5</td>
                            <td>PO # 1</td>
                            <td>PO # 2</td>
                            <td>PO # 3</td>
                            <td>PO # 4</td>
                            <td>PO # 5</td>
                            <td>PO # 6</td>
                            <td>PO # 7</td>
                            <td>PO # 8</td>
                            <td>PO # 9</td>
                            <td>PO # 10</td>
                            <td>NMFC</td>
                            <td>Detail Class</td>
                            <td>Freight Sequence Number</td>
                            <td>Declared Freight Class</td>
                            <td>EORI Number</td>
                            <td>Detail Keyed Dim</td>
                            <td>Detail Keyed Unit of Measure</td>
                            <td>Detail Keyed Billed Dimension</td>
                            <td>Detail Keyed Billed Unit of Measure</td>
                            <td>Original Service Description</td>
                            <td>Promo Discount Applied Indicator</td>
                            <td>Promo Discount Alias</td>
                            <td>SDS Match Level Cd</td>
                            <td>SDS RDR Date</td>
                            <td>SDS Delivery Date</td>
                            <td>SDS Error Code</td>
                            <td>Place Holder 46</td>
                            <td>Place Holder 47</td>
                            <td>Place Holder 48</td>
                            <td>Place Holder 49</td>
                            <td>Place Holder 50</td>
                            <td>Place Holder 51</td>
                            <td>Place Holder 52</td>
                            <td>Place Holder 53</td>
                            <td>Place Holder 54</td>
                            <td>Place Holder 55</td>
                            <td>Place Holder 56</td>
                            <td>Place Holder 57</td>
                            <td>Place Holder 58</td>
                            <td>Place Holder 59</td>
                        </tr>
                    </thead>

                ';
                while ($row = mysqli_fetch_array($result)) {
                    // echoing the fetched data from the database per column names
                    foreach ($row as &$value){
                        if (($value == -1) || ($value == "1990-09-12")){
                            $value = "";
                        }
                    }
                    echo '  
                        <tr>
                            <td>' . $row["version_item"] . '</td>
                            <td>' . $row["account_country"] . '</td>
                            <td>' . $row["invoice_date"] . '</td>
                            <td>' . $row["invoice_type"] . '</td>
                            <td>' . $row["invoice_type_detail"] . '</td>
                            <td>' . $row["account_tax_id"] . '</td>
                            <td>' . $row["pickup_record_num"] . '</td>
                            <td>' . $row["lead_shipment_num"] . '</td>
                            <td>' . $row["transaction_date"] . '</td>
                            <td>' . $row["world_ease_num"] . '</td>
                            <td>' . $row["shipment_ref_num1"] . '</td>
                            <td>' . $row["shipment_ref_num2"] . '</td>
                            <td>' . $row["bill_option"] . '</td>
                            <td>' . $row["package_qty"] . '</td>
                            <td>' . $row["oversize_qty"] . '</td>
                            <td>' . $row["tracking_num"] . '</td>
                            <td>' . $row["package_ref_num1"] . '</td>
                            <td>' . $row["package_ref_num2"] . '</td>
                            <td>' . $row["package_ref_num3"] . '</td>
                            <td>' . $row["package_ref_num4"] . '</td>
                            <td>' . $row["package_ref_num5"] . '</td>
                            <td>' . $row["entered_weight"] . '</td>
                            <td>' . $row["entered_weight_unit"] . '</td>
                            <td>' . $row["billed_weight"] . '</td>
                            <td>' . $row["billed_weight_unit"] . '</td>
                            <td>' . $row["billed_weight_type"] . '</td>
                            <td>' . $row["container_type"] . '</td>
                            <td>' . $row["package_dimensions"] . '</td>
                            <td>' . $row["zone_item"] . '</td>
                            <td>' . $row["charge_category"] . '</td>
                            <td>' . $row["charge_category_detail"] . '</td>
                            <td>' . $row["charge_source"] . '</td>
                            <td>' . $row["type1"] . '</td>
                            <td>' . $row["type_detail1"] . '</td>
                            <td>' . $row["type_detail_value1"] . '</td>
                            <td>' . $row["type2"] . '</td>
                            <td>' . $row["type_detail2"] . '</td>
                            <td>' . $row["type_detail_value2"] . '</td>
                            <td>' . $row["charge_classificataion"] . '</td>
                            <td>' . $row["charge_desc_code"] . '</td>
                            <td>' . $row["charge_desc"] . '</td>
                            <td>' . $row["transaction_currency"] . '</td>
                            <td>' . $row["dtrans"] . '</td>
                            <td>' . $row["misc_currency"] . '</td>
                            <td>' . $row["misc_incentive_amount"] . '</td>
                            <td>' . $row["misc_net_amount"] . '</td>
                            <td>' . $row["alternate_invoicing_currency"] . '</td>
                            <td>' . $row["alternate_invoice_amount"] . '</td>
                            <td>' . $row["invoice_exchange_rate"] . '</td>
                            <td>' . $row["tax_variance_amount"] . '</td>
                            <td>' . $row["currency_variance_amount"] . '</td>
                            <td>' . $row["invoice_level_charge"] . '</td>
                            <td>' . $row["invoice_due_date"] . '</td>
                            <td>' . $row["alternate_invoice_num"] . '</td>
                            <td>' . $row["store_num"] . '</td>
                            <td>' . $row["customer_ref_num"] . '</td>
                            <td>' . $row["sender_name"] . '</td>
                            <td>' . $row["sender_company"] . '</td>
                            <td>' . $row["sender_addr1"] . '</td>
                            <td>' . $row["sender_addr2"] . '</td>
                            <td>' . $row["sender_city"] . '</td>
                            <td>' . $row["sender_state"] . '</td>
                            <td>' . $row["sender_postal"] . '</td>
                            <td>' . $row["sender_country"] . '</td>
                            <td>' . $row["receiver_name"] . '</td>
                            <td>' . $row["receiver_company"] . '</td>
                            <td>' . $row["receiver_addr1"] . '</td>
                            <td>' . $row["receiver_addr2"] . '</td>
                            <td>' . $row["receiver_city"] . '</td>
                            <td>' . $row["receiver_state"] . '</td>
                            <td>' . $row["receiver_postal"] . '</td>
                            <td>' . $row["receiver_country"] . '</td>
                            <td>' . $row["third_party_name"] . '</td>
                            <td>' . $row["third_party_company"] . '</td>
                            <td>' . $row["third_party_addr1"] . '</td>
                            <td>' . $row["third_party_addr2"] . '</td>
                            <td>' . $row["third_party_city"] . '</td>
                            <td>' . $row["third_party_state"] . '</td>
                            <td>' . $row["third_party_postal"] . '</td>
                            <td>' . $row["third_party_country"] . '</td>
                            <td>' . $row["sold_to_name"] . '</td>
                            <td>' . $row["sold_to_company"] . '</td>
                            <td>' . $row["sold_to_addr1"] . '</td>
                            <td>' . $row["sold_to_addr2"] . '</td>
                            <td>' . $row["sold_to_city"] . '</td>
                            <td>' . $row["sold_to_state"] . '</td>
                            <td>' . $row["sold_to_postal"] . '</td>
                            <td>' . $row["sold_to_country"] . '</td>
                            <td>' . $row["misc_addr_qual1"] . '</td>
                            <td>' . $row["misc_addr_name1"] . '</td>
                            <td>' . $row["misc_addr_company1"] . '</td>
                            <td>' . $row["misc_addr_addr11"] . '</td>
                            <td>' . $row["misc_addr_addr12"] . '</td>
                            <td>' . $row["misc_addr_city1"] . '</td>
                            <td>' . $row["misc_addr_state1"] . '</td>
                            <td>' . $row["misc_addr_postal1"] . '</td>
                            <td>' . $row["misc_addr_country1"] . '</td>
                            <td>' . $row["misc_addr_qual2"] . '</td>
                            <td>' . $row["misc_addr_name2"] . '</td>
                            <td>' . $row["misc_addr_company2"] . '</td>
                            <td>' . $row["misc_addr_addr21"] . '</td>
                            <td>' . $row["misc_addr_addr22"] . '</td>
                            <td>' . $row["misc_addr_city2"] . '</td>
                            <td>' . $row["misc_addr_state2"] . '</td>
                            <td>' . $row["misc_addr_postal2"] . '</td>
                            <td>' . $row["misc_addr_country2"] . '</td>
                            <td>' . $row["shipment_date"] . '</td>
                            <td>' . $row["shipment_exp_date"] . '</td>
                            <td>' . $row["shipment_imp_date"] . '</td>
                            <td>' . $row["entry_date"] . '</td>
                            <td>' . $row["direct_shipment_date"] . '</td>
                            <td>' . $row["shipment_delivery_date"] . '</td>
                            <td>' . $row["shipment_release_date"] . '</td>
                            <td>' . $row["cycle_date"] . '</td>
                            <td>' . $row["eft_date"] . '</td>
                            <td>' . $row["validation_date"] . '</td>
                            <td>' . $row["entry_port"] . '</td>
                            <td>' . $row["entry_num"] . '</td>
                            <td>' . $row["exp_place"] . '</td>
                            <td>' . $row["shipment_value_amount"] . '</td>
                            <td>' . $row["shipment_desc"] . '</td>
                            <td>' . $row["entered_currency"] . '</td>
                            <td>' . $row["customer_num"] . '</td>
                            <td>' . $row["exchange_rate"] . '</td>
                            <td>' . $row["master_air_waybill_num"] . '</td>
                            <td>' . $row["epu"] . '</td>
                            <td>' . $row["entery_type"] . '</td>
                            <td>' . $row["cpc"] . '</td>
                            <td>' . $row["line_item_num"] . '</td>
                            <td>' . $row["goods_desc"] . '</td>
                            <td>' . $row["entered_value"] . '</td>
                            <td>' . $row["duty_amount"] . '</td>
                            <td>' . $row["weight_item"] . '</td>
                            <td>' . $row["unit_of_measure"] . '</td>
                            <td>' . $row["item_qty"] . '</td>
                            <td>' . $row["item_qty_unit_of_measure"] . '</td>
                            <td>' . $row["imp_tax_id"] . '</td>
                            <td>' . $row["declaration_num"] . '</td>
                            <td>' . $row["carrier_name_id_num_sds_id"] . '</td>
                            <td>' . $row["cccd_num"] . '</td>
                            <td>' . $row["cycle_num"] . '</td>
                            <td>' . $row["foreign_table_ref_num"] . '</td>
                            <td>' . $row["job_num"] . '</td>
                            <td>' . $row["transport_mode"] . '</td>
                            <td>' . $row["tax_type"] . '</td>
                            <td>' . $row["tariff"] . '</td>
                            <td>' . $row["tariff_rate"] . '</td>
                            <td>' . $row["tariff_treatment_num"] . '</td>
                            <td>' . $row["contact_name"] . '</td>
                            <td>' . $row["class_num"] . '</td>
                            <td>' . $row["doc_type"] . '</td>
                            <td>' . $row["office_num"] . '</td>
                            <td>' . $row["doc_num"] . '</td>
                            <td>' . $row["duty_value"] . '</td>
                            <td>' . $row["total_duty_value"] . '</td>
                            <td>' . $row["excise_tax_amount"] . '</td>
                            <td>' . $row["excise_tax_rate"] . '</td>
                            <td>' . $row["gst_amount"] . '</td>
                            <td>' . $row["gst_rate"] . '</td>
                            <td>' . $row["order_council"] . '</td>
                            <td>' . $row["origin_country"] . '</td>
                            <td>' . $row["sima_access"] . '</td>
                            <td>' . $row["tax_value"] . '</td>
                            <td>' . $row["total_customs_amount"] . '</td>
                            <td>' . $row["misc1"] . '</td>
                            <td>' . $row["misc2"] . '</td>
                            <td>' . $row["misc3"] . '</td>
                            <td>' . $row["misc4"] . '</td>
                            <td>' . $row["misc5"] . '</td>
                            <td>' . $row["misc7"] . '</td>
                            <td>' . $row["misc8"] . '</td>
                            <td>' . $row["misc9"] . '</td>
                            <td>' . $row["misc10"] . '</td>
                            <td>' . $row["misc11"] . '</td>
                            <td>' . $row["payer_role"] . '</td>
                            <td>' . $row["duty_rate"] . '</td>
                            <td>' . $row["vat_vasis_amount"] . '</td>
                            <td>' . $row["vat_amount"] . '</td>
                            <td>' . $row["vat_rate"] . '</td>
                            <td>' . $row["other_basis_amount"] . '</td>
                            <td>' . $row["other_amount"] . '</td>
                            <td>' . $row["other_rate"] . '</td>
                            <td>' . $row["other_customs_num_indicator"] . '</td>
                            <td>' . $row["other_customs_num"] . '</td>
                            <td>' . $row["customs_office_name"] . '</td>
                            <td>' . $row["pacakage_dimension_unit"] . '</td>
                            <td>' . $row["original_shipment_package_qty"] . '</td>
                            <td>' . $row["corrected_zone"] . '</td>
                            <td>' . $row["tax_law_article_num"] . '</td>
                            <td>' . $row["tax_law_article_basis_amount"] . '</td>
                            <td>' . $row["original_tracaking_num"] . '</td>
                            <td>' . $row["scale_weight_qty"] . '</td>
                            <td>' . $row["scale_weight_unit"] . '</td>
                            <td>' . $row["raw_dimension_unit"] . '</td>
                            <td>' . $row["raw_dimension_length"] . '</td>
                            <td>' . $row["bol1"] . '</td>
                            <td>' . $row["bol2"] . '</td>
                            <td>' . $row["bol3"] . '</td>
                            <td>' . $row["bol4"] . '</td>
                            <td>' . $row["bol5"] . '</td>
                            <td>' . $row["po1"] . '</td>
                            <td>' . $row["po2"] . '</td>
                            <td>' . $row["po3"] . '</td>
                            <td>' . $row["po4"] . '</td>
                            <td>' . $row["po5"] . '</td>
                            <td>' . $row["po6"] . '</td>
                            <td>' . $row["po7"] . '</td>
                            <td>' . $row["po8"] . '</td>
                            <td>' . $row["po9"] . '</td>
                            <td>' . $row["po10"] . '</td>
                            <td>' . $row["nmfc"] . '</td>
                            <td>' . $row["detail_class"] . '</td>
                            <td>' . $row["freight_seq_num"] . '</td>
                            <td>' . $row["declared_freight_class"] . '</td>
                            <td>' . $row["eori_num"] . '</td>
                            <td>' . $row["detail_keyed_dim"] . '</td>
                            <td>' . $row["detail_keyed_unit"] . '</td>
                            <td>' . $row["detail_keyed_billed_dimension"] . '</td>
                            <td>' . $row["detail_keyed_billed_unit"] . '</td>
                            <td>' . $row["original_service_desc"] . '</td>
                            <td>' . $row["promo_discount_aplied"] . '</td>
                            <td>' . $row["promo_discount_aliasa"] . '</td>
                            <td>' . $row["sds_match_level_cd"] . '</td>
                            <td>' . $row["sds_rdr_date"] . '</td>
                            <td>' . $row["sds_delivery_date"] . '</td>
                            <td>' . $row["sds_error"] . '</td>
                            <td>' . $row["place_holder46"] . '</td>
                            <td>' . $row["place_holder47"] . '</td>
                            <td>' . $row["place_holder48"] . '</td>
                            <td>' . $row["place_holder49"] . '</td>
                            <td>' . $row["place_holder50"] . '</td>
                            <td>' . $row["place_holder51"] . '</td>
                            <td>' . $row["place_holder52"] . '</td>
                            <td>' . $row["place_holder53"] . '</td>
                            <td>' . $row["place_holder54"] . '</td>
                            <td>' . $row["place_holder55"] . '</td>
                            <td>' . $row["place_holder56"] . '</td>
                            <td>' . $row["place_holder57"] . '</td>
                            <td>' . $row["place_holder58"] . '</td>
                            <td>' . $row["place_holder59"] . '</td>
                        </tr>  
                        ';
                }
            } else {
                //ups - ctk
                echo '
                    <thead>
                        <tr>							  	  	  					
                            <td>Version</td>
                            <td>Account Number 1</td>
                            <td>Account Number 2</td>
                            <td>Account Country</td>
                            <td>Invoice Date</td>
                            <td>Account Number 3</td>
                            <td>Invoice Type Code</td>
                            <td>Invoice Type Detail Code</td>
                            <td>Account Tax ID</td>
                            <td>Unit of Total Amount</td>
                            <td>Total Amount</td>
                            <td>Pickup Record Number</td>
                            <td>Lead Shipment Number</td>
                            <td>Transaction Date</td>
                            <td>World Ease Number</td>
                            <td>Shipment Reference Number 1</td>
                            <td>Shipment Reference Number 2</td>
                            <td>Bill Option Code</td>
                            <td>Package Quantity</td>
                            <td>Oversize Quantity</td>
                            <td>Tracking Number</td>
                            <td>Package Reference Number 1</td>
                            <td>Package Reference Number 2</td>
                            <td>Package Reference Number 3</td>
                            <td>Package Reference Number 4</td>
                            <td>Package Reference Number 5</td>
                            <td>Entered Weight</td>
                            <td>Entered Weight Unit of Measure</td>
                            <td>Billed Weight</td>
                            <td>Billed Weight Unit of Measure</td>
                            <td>Container Type</td>
                            <td>Billed Weight Type</td>
                            <td>Package Dimensions</td>
                            <td>Zone</td>
                            <td>Charge Category Code</td>
                            <td>Charge Category Detail Code</td>
                            <td>Charge Source</td>
                            <td>Type Code 1</td>
                            <td>Type Detail Code 1</td>
                            <td>Type Detail Value 1</td>
                            <td>Type Code 2</td>
                            <td>Type Detail Code 2</td>
                            <td>Type Detail Value 2</td>
                            <td>Charge Classification Code</td>
                            <td>Charge Description Code</td>
                            <td>Charge Description</td>
                            <td>Temp 6</td>
                            <td>Transaction Currency Code</td>
                            <td>Temp 7</td>
                            <td>Temp 8</td>
                            <td>Unit of Temp 9</td>
                            <td>Temp 10</td>
                            <td>Temp 11</td>
                            <td>Dtrans</td>
                            <td>Miscellaneous Currency Code</td>
                            <td>Miscellaneous Incentive Amount</td>
                            <td>Miscellaneous Net Amount</td>
                            <td>Alternate Invoicing Currency Code</td>
                            <td>Alternate Invoice Amount</td>
                            <td>Invoice Exchange Rate</td>
                            <td>Tax Variance Amount</td>
                            <td>Currency Variance Amount</td>
                            <td>Invoice Level Charge</td>
                            <td>Invoice Due Date</td>
                            <td>Alternate Invoice Number</td>
                            <td>Store Number</td>
                            <td>Customer Reference Number</td>
                            <td>Sender Name</td>
                            <td>Sender Company Name</td>
                            <td>Sender Address Line 1</td>
                            <td>Sender Address Line 2</td>
                            <td>Sender City</td>
                            <td>Sender State</td>
                            <td>Sender Postal</td>
                            <td>Sender Country</td>
                            <td>Receiver Name</td>
                            <td>Receiver Company Name</td>
                            <td>Receiver Address Line 1</td>
                            <td>Receiver Address Line 2</td>
                            <td>Receiver City</td>
                            <td>Receiver State</td>
                            <td>Receiver Postal</td>
                            <td>Receiver Country</td>
                            <td>Third Party Name</td>
                            <td>Third Party Company Name</td>
                            <td>Third Party Address Line 1</td>
                            <td>Third Party Address Line 2</td>
                            <td>Third Party City</td>
                            <td>Third Party State</td>
                            <td>Third Party Postal</td>
                            <td>Third Party Country</td>
                            <td>Sold To Name</td>
                            <td>Sold To Company Name</td>
                            <td>Sold To Address Line 1</td>
                            <td>Sold To Address Line 2</td>
                            <td>Sold To City</td>
                            <td>Sold To State</td>
                            <td>Sold To Postal</td>
                            <td>Sold To Country</td>
                            <td>Miscellaneous Address Qual 1</td>
                            <td>Miscellaneous Address 1 Name</td>
                            <td>Miscellaneous Address 1 Company Name</td>
                            <td>Miscellaneous Address 1 Address Line 1</td>
                            <td>Miscellaneous Address 1 Address Line 2</td>
                            <td>Miscellaneous Address 1 City</td>
                            <td>Miscellaneous Address 1 State</td>
                            <td>Miscellaneous Address 1 Postal</td>
                            <td>Miscellaneous Address 1 Country</td>
                            <td>Miscellaneous Address Qual 2</td>
                            <td>Miscellaneous Address 2 Name</td>
                            <td>Miscellaneous Address 2 Company Name</td>
                            <td>Miscellaneous Address 2 Address Line 1</td>
                            <td>Miscellaneous Address 2 Address Line 2</td>
                            <td>Miscellaneous Address 2 City</td>
                            <td>Miscellaneous Address 2 State</td>
                            <td>Miscellaneous Address 2 Postal</td>
                            <td>Miscellaneous Address 2 Country</td>
                            <td>Shipment Date</td>
                            <td>Shipment Export Date</td>
                            <td>Shipment Import Date</td>
                            <td>Entry Date</td>
                            <td>Direct Shipment Date</td>
                            <td>Shipment Delivery Date</td>
                            <td>Shipment Release Date</td>
                            <td>Cycle Date</td>
                            <td>EFT Date</td>
                            <td>Validation Date</td>
                            <td>Entry Port</td>
                            <td>Entry Number</td>
                            <td>Export Place</td>
                            <td>Shipment Value Amount</td>
                            <td>Shipment Description</td>
                            <td>Entered Currency Code</td>
                            <td>Customs Number</td>
                            <td>Exchange Rate</td>
                            <td>Master Air Waybill Number</td>
                            <td>EPU</td>
                            <td>Entry Type</td>
                            <td>CPC Code</td>
                            <td>Line Item Number</td>
                            <td>Goods Description</td>
                            <td>Entered Value</td>
                            <td>Duty Amount</td>
                            <td>Weight</td>
                            <td>Unit of Measure</td>
                            <td>Item Quantity</td>
                            <td>Item Quantity Unit of Measure</td>
                            <td>Import Tax ID</td>
                            <td>Declaration Number</td>
                            <td>Carrier Name/Clinical Trial Identification Number/SDS ID</td>
                            <td>CCCD Number</td>
                            <td>Cycle Number</td>
                            <td>Foreign Trade Reference Number</td>
                            <td>Job Number</td>
                            <td>Transport Mode</td>
                            <td>Tax Type</td>
                            <td>Tariff Code</td>
                            <td>Tariff Rate</td>
                            <td>Tariff Treatment Number</td>
                            <td>Contact Name</td>
                            <td>Class Number</td>
                            <td>Document Type</td>
                            <td>Office Number</td>
                            <td>Document Number</td>
                            <td>Duty Value</td>
                            <td>Total Value for Duty</td>
                            <td>Excise Tax Amount</td>
                            <td>Excise Tax Rate</td>
                            <td>GST Amount</td>
                            <td>GST Rate</td>
                            <td>Order In Council</td>
                            <td>Origin Country</td>
                            <td>SIMA Access</td>
                            <td>Tax Value</td>
                            <td>Total Customs Amount</td>
                            <td>Miscellaneous Line 1</td>
                            <td>Miscellaneous Line 2</td>
                            <td>Miscellaneous Line 3</td>
                            <td>Miscellaneous Line 4</td>
                            <td>Miscellaneous Line 5</td>
                            <td>Miscellaneous Line 7</td>
                            <td>Miscellaneous Line 8</td>
                            <td>Miscellaneous Line 9</td>
                            <td>Miscellaneous Line 10</td>
                            <td>Miscellaneous Line 11</td>
                            <td>Payor Role Code</td>
                            <td>Duty Rate</td>
                            <td>VAT Basis Amount</td>
                            <td>VAT Amount</td>
                            <td>VAT Rate</td>
                            <td>Other Basis Amount</td>
                            <td>Other Amount</td>
                            <td>Other Rate</td>
                            <td>Other Customs Number Indicator</td>
                            <td>Other Customs Number</td>
                            <td>Customs Office Name</td>
                            <td>Package Dimension Unit Of Measure</td>
                            <td>Original Shipment Package Quantity</td>
                            <td>Corrected Zone</td>
                            <td>Tax Law Article Number</td>
                            <td>Tax Law Article Basis Amount</td>
                            <td>Original tracking number</td>
                            <td>Scale weight quantity</td>
                            <td>Scale Weight Unit of Measure</td>
                            <td>Raw dimension unit of measure</td>
                            <td>Raw dimension length</td>
                            <td>BOL # 1</td>
                            <td>BOL # 2</td>
                            <td>BOL # 3</td>
                            <td>BOL # 4</td>
                            <td>BOL # 5</td>
                            <td>PO # 1</td>
                            <td>PO # 2</td>
                            <td>PO # 3</td>
                            <td>PO # 4</td>
                            <td>PO # 5</td>
                            <td>PO # 6</td>
                            <td>PO # 7</td>
                            <td>PO # 8</td>
                            <td>PO # 9</td>
                            <td>PO # 10</td>
                            <td>NMFC</td>
                            <td>Detail Class</td>
                            <td>Freight Sequence Number</td>
                            <td>Declared Freight Class</td>
                            <td>EORI Number</td>
                            <td>Detail Keyed Dim</td>
                            <td>Detail Keyed Unit of Measure</td>
                            <td>Detail Keyed Billed Dimension</td>
                            <td>Detail Keyed Billed Unit of Measure</td>
                            <td>Original Service Description</td>
                            <td>Promo Discount Applied Indicator</td>
                            <td>Promo Discount Alias</td>
                            <td>SDS Match Level Cd</td>
                            <td>SDS RDR Date</td>
                            <td>SDS Delivery Date</td>
                            <td>SDS Error Code</td>
                            <td>Place Holder 46</td>
                            <td>Place Holder 47</td>
                            <td>Place Holder 48</td>
                            <td>Place Holder 49</td>
                            <td>Place Holder 50</td>
                            <td>Place Holder 51</td>
                            <td>Place Holder 52</td>
                            <td>Place Holder 53</td>
                            <td>Place Holder 54</td>
                            <td>Place Holder 55</td>
                            <td>Place Holder 56</td>
                            <td>Place Holder 57</td>
                            <td>Place Holder 58</td>
                            <td>Place Holder 59</td>
                        </tr>
                    </thead>
                ';
                while ($row = mysqli_fetch_array($result)) {
                    // echoing the fetched data from the database per column names
                    foreach ($row as &$value){
                        if (($value == -1) || ($value == "1990-09-12")){
                            $value = "";
                        }
                    }
                    echo '  
                        <tr>
                            <td>' . $row["version_item"] . '</td>
                            <td>' . $row["account_num1"] . '</td>
                            <td>' . $row["account_num2"] . '</td>
                            <td>' . $row["account_country"] . '</td>
                            <td>' . $row["invoice_date"] . '</td>
                            <td>' . $row["account_num3"] . '</td>
                            <td>' . $row["invoice_type"] . '</td>
                            <td>' . $row["invoice_type_detail"] . '</td>
                            <td>' . $row["account_tax_id"] . '</td>
                            <td>' . $row["total_amount_unit"] . '</td>
                            <td>' . $row["total_amount"] . '</td>
                            <td>' . $row["pickup_record_num"] . '</td>
                            <td>' . $row["lead_shipment_num"] . '</td>
                            <td>' . $row["transaction_date"] . '</td>
                            <td>' . $row["world_ease_num"] . '</td>
                            <td>' . $row["shipment_ref_num1"] . '</td>
                            <td>' . $row["shipment_ref_num2"] . '</td>
                            <td>' . $row["bill_option"] . '</td>
                            <td>' . $row["package_qty"] . '</td>
                            <td>' . $row["oversize_qty"] . '</td>
                            <td>' . $row["tracking_num"] . '</td>
                            <td>' . $row["package_ref_num1"] . '</td>
                            <td>' . $row["package_ref_num2"] . '</td>
                            <td>' . $row["package_ref_num3"] . '</td>
                            <td>' . $row["package_ref_num4"] . '</td>
                            <td>' . $row["package_ref_num5"] . '</td>
                            <td>' . $row["entered_weight"] . '</td>
                            <td>' . $row["entered_weight_unit"] . '</td>
                            <td>' . $row["billed_weight"] . '</td>
                            <td>' . $row["billed_weight_unit"] . '</td>
                            <td>' . $row["billed_weight_type"] . '</td>
                            <td>' . $row["container_type"] . '</td>
                            <td>' . $row["package_dimensions"] . '</td>
                            <td>' . $row["zone_item"] . '</td>
                            <td>' . $row["charge_category"] . '</td>
                            <td>' . $row["charge_category_detail"] . '</td>
                            <td>' . $row["charge_source"] . '</td>
                            <td>' . $row["type1"] . '</td>
                            <td>' . $row["type_detail1"] . '</td>
                            <td>' . $row["type_detail_value1"] . '</td>
                            <td>' . $row["type2"] . '</td>
                            <td>' . $row["type_detail2"] . '</td>
                            <td>' . $row["type_detail_value2"] . '</td>
                            <td>' . $row["charge_classificataion"] . '</td>
                            <td>' . $row["charge_desc_code"] . '</td>
                            <td>' . $row["charge_desc"] . '</td>
                            <td>' . $row["temp6"] . '</td>
                            <td>' . $row["transaction_currency"] . '</td>
                            <td>' . $row["temp7"] . '</td>
                            <td>' . $row["temp8"] . '</td>
                            <td>' . $row["temp9_unit"] . '</td>
                            <td>' . $row["temp10"] . '</td>
                            <td>' . $row["temp11"] . '</td>
                            <td>' . $row["misc_currency"] . '</td>
                            <td>' . $row["misc_incentive_amount"] . '</td>
                            <td>' . $row["misc_net_amount"] . '</td>
                            <td>' . $row["alternate_invoicing_currency"] . '</td>
                            <td>' . $row["alternate_invoice_amount"] . '</td>
                            <td>' . $row["invoice_exchange_rate"] . '</td>
                            <td>' . $row["tax_variance_amount"] . '</td>
                            <td>' . $row["currency_variance_amount"] . '</td>
                            <td>' . $row["invoice_level_charge"] . '</td>
                            <td>' . $row["invoice_due_date"] . '</td>
                            <td>' . $row["alternate_invoice_num"] . '</td>
                            <td>' . $row["store_num"] . '</td>
                            <td>' . $row["customer_ref_num"] . '</td>
                            <td>' . $row["sender_name"] . '</td>
                            <td>' . $row["sender_company"] . '</td>
                            <td>' . $row["sender_addr1"] . '</td>
                            <td>' . $row["sender_addr2"] . '</td>
                            <td>' . $row["sender_city"] . '</td>
                            <td>' . $row["sender_state"] . '</td>
                            <td>' . $row["sender_postal"] . '</td>
                            <td>' . $row["sender_country"] . '</td>
                            <td>' . $row["receiver_name"] . '</td>
                            <td>' . $row["receiver_company"] . '</td>
                            <td>' . $row["receiver_addr1"] . '</td>
                            <td>' . $row["receiver_addr2"] . '</td>
                            <td>' . $row["receiver_city"] . '</td>
                            <td>' . $row["receiver_state"] . '</td>
                            <td>' . $row["receiver_postal"] . '</td>
                            <td>' . $row["receiver_country"] . '</td>
                            <td>' . $row["third_party_name"] . '</td>
                            <td>' . $row["third_party_company"] . '</td>
                            <td>' . $row["third_party_addr1"] . '</td>
                            <td>' . $row["third_party_addr2"] . '</td>
                            <td>' . $row["third_party_city"] . '</td>
                            <td>' . $row["third_party_state"] . '</td>
                            <td>' . $row["third_party_postal"] . '</td>
                            <td>' . $row["third_party_country"] . '</td>
                            <td>' . $row["sold_to_name"] . '</td>
                            <td>' . $row["sold_to_company"] . '</td>
                            <td>' . $row["sold_to_addr1"] . '</td>
                            <td>' . $row["sold_to_addr2"] . '</td>
                            <td>' . $row["sold_to_city"] . '</td>
                            <td>' . $row["sold_to_state"] . '</td>
                            <td>' . $row["sold_to_postal"] . '</td>
                            <td>' . $row["sold_to_country"] . '</td>
                            <td>' . $row["misc_addr_qual1"] . '</td>
                            <td>' . $row["misc_addr_name1"] . '</td>
                            <td>' . $row["misc_addr_company1"] . '</td>
                            <td>' . $row["misc_addr_addr11"] . '</td>
                            <td>' . $row["misc_addr_addr12"] . '</td>
                            <td>' . $row["misc_addr_city1"] . '</td>
                            <td>' . $row["misc_addr_state1"] . '</td>
                            <td>' . $row["misc_addr_postal1"] . '</td>
                            <td>' . $row["misc_addr_country1"] . '</td>
                            <td>' . $row["misc_addr_qual2"] . '</td>
                            <td>' . $row["misc_addr_name2"] . '</td>
                            <td>' . $row["misc_addr_company2"] . '</td>
                            <td>' . $row["misc_addr_addr21"] . '</td>
                            <td>' . $row["misc_addr_addr22"] . '</td>
                            <td>' . $row["misc_addr_city2"] . '</td>
                            <td>' . $row["misc_addr_state2"] . '</td>
                            <td>' . $row["misc_addr_postal2"] . '</td>
                            <td>' . $row["misc_addr_country2"] . '</td>
                            <td>' . $row["shipment_date"] . '</td>
                            <td>' . $row["shipment_exp_date"] . '</td>
                            <td>' . $row["shipment_imp_date"] . '</td>
                            <td>' . $row["entry_date"] . '</td>
                            <td>' . $row["direct_shipment_date"] . '</td>
                            <td>' . $row["shipment_delivery_date"] . '</td>
                            <td>' . $row["shipment_release_date"] . '</td>
                            <td>' . $row["cycle_date"] . '</td>
                            <td>' . $row["eft_date"] . '</td>
                            <td>' . $row["validation_date"] . '</td>
                            <td>' . $row["entry_port"] . '</td>
                            <td>' . $row["entry_num"] . '</td>
                            <td>' . $row["exp_place"] . '</td>
                            <td>' . $row["shipment_value_amount"] . '</td>
                            <td>' . $row["shipment_desc"] . '</td>
                            <td>' . $row["entered_currency"] . '</td>
                            <td>' . $row["customer_num"] . '</td>
                            <td>' . $row["exchange_rate"] . '</td>
                            <td>' . $row["master_air_waybill_num"] . '</td>
                            <td>' . $row["epu"] . '</td>
                            <td>' . $row["entery_type"] . '</td>
                            <td>' . $row["cpc"] . '</td>
                            <td>' . $row["line_item_num"] . '</td>
                            <td>' . $row["goods_desc"] . '</td>
                            <td>' . $row["entered_value"] . '</td>
                            <td>' . $row["duty_amount"] . '</td>
                            <td>' . $row["weight_item"] . '</td>
                            <td>' . $row["unit_of_measure"] . '</td>
                            <td>' . $row["item_qty"] . '</td>
                            <td>' . $row["item_qty_unit"] . '</td>
                            <td>' . $row["imp_tax_id"] . '</td>
                            <td>' . $row["declaration_num"] . '</td>
                            <td>' . $row["carrier_name_id_num_sds_id"] . '</td>
                            <td>' . $row["cccd_num"] . '</td>
                            <td>' . $row["cycle_num"] . '</td>
                            <td>' . $row["foreign_table_ref_num"] . '</td>
                            <td>' . $row["job_num"] . '</td>
                            <td>' . $row["transport_mode"] . '</td>
                            <td>' . $row["tax_type"] . '</td>
                            <td>' . $row["tariff"] . '</td>
                            <td>' . $row["tariff_rate"] . '</td>
                            <td>' . $row["tariff_treatment_num"] . '</td>
                            <td>' . $row["contact_name"] . '</td>
                            <td>' . $row["class_num"] . '</td>
                            <td>' . $row["doc_type"] . '</td>
                            <td>' . $row["office_num"] . '</td>
                            <td>' . $row["doc_num"] . '</td>
                            <td>' . $row["duty_value"] . '</td>
                            <td>' . $row["total_duty_value"] . '</td>
                            <td>' . $row["excise_tax_amount"] . '</td>
                            <td>' . $row["excise_tax_rate"] . '</td>
                            <td>' . $row["gst_amount"] . '</td>
                            <td>' . $row["gst_rate"] . '</td>
                            <td>' . $row["order_council"] . '</td>
                            <td>' . $row["origin_country"] . '</td>
                            <td>' . $row["sima_access"] . '</td>
                            <td>' . $row["tax_value"] . '</td>
                            <td>' . $row["total_customs_amount"] . '</td>
                            <td>' . $row["misc1"] . '</td>
                            <td>' . $row["misc2"] . '</td>
                            <td>' . $row["misc3"] . '</td>
                            <td>' . $row["misc4"] . '</td>
                            <td>' . $row["misc5"] . '</td>
                            <td>' . $row["misc7"] . '</td>
                            <td>' . $row["misc8"] . '</td>
                            <td>' . $row["misc9"] . '</td>
                            <td>' . $row["misc10"] . '</td>
                            <td>' . $row["misc11"] . '</td>
                            <td>' . $row["payer_role"] . '</td>
                            <td>' . $row["duty_rate"] . '</td>
                            <td>' . $row["vat_vasis_amount"] . '</td>
                            <td>' . $row["vat_amount"] . '</td>
                            <td>' . $row["vat_rate"] . '</td>
                            <td>' . $row["other_basis_amount"] . '</td>
                            <td>' . $row["other_amount"] . '</td>
                            <td>' . $row["other_rate"] . '</td>
                            <td>' . $row["other_customs_num_indicator"] . '</td>
                            <td>' . $row["other_customs_num"] . '</td>
                            <td>' . $row["customs_office_name"] . '</td>
                            <td>' . $row["pacakage_dimension_unit"] . '</td>
                            <td>' . $row["original_shipment_package_qty"] . '</td>
                            <td>' . $row["corrected_zone"] . '</td>
                            <td>' . $row["tax_law_article_num"] . '</td>
                            <td>' . $row["tax_law_article_basis_amount"] . '</td>
                            <td>' . $row["original_tracaking_num"] . '</td>
                            <td>' . $row["scale_weight_qty"] . '</td>
                            <td>' . $row["scale_weight_unit"] . '</td>
                            <td>' . $row["raw_dimension_unit"] . '</td>
                            <td>' . $row["raw_dimension_length"] . '</td>
                            <td>' . $row["bol1"] . '</td>
                            <td>' . $row["bol2"] . '</td>
                            <td>' . $row["bol3"] . '</td>
                            <td>' . $row["bol4"] . '</td>
                            <td>' . $row["bol5"] . '</td>
                            <td>' . $row["po1"] . '</td>
                            <td>' . $row["po2"] . '</td>
                            <td>' . $row["po3"] . '</td>
                            <td>' . $row["po4"] . '</td>
                            <td>' . $row["po5"] . '</td>
                            <td>' . $row["po6"] . '</td>
                            <td>' . $row["po7"] . '</td>
                            <td>' . $row["po8"] . '</td>
                            <td>' . $row["po9"] . '</td>
                            <td>' . $row["po10"] . '</td>
                            <td>' . $row["nmfc"] . '</td>
                            <td>' . $row["detail_class"] . '</td>
                            <td>' . $row["freight_seq_num"] . '</td>
                            <td>' . $row["declared_freight_class"] . '</td>
                            <td>' . $row["eori_num"] . '</td>
                            <td>' . $row["detail_keyed_dim"] . '</td>
                            <td>' . $row["detail_keyed_unit"] . '</td>
                            <td>' . $row["detail_keyed_billed_dimension"] . '</td>
                            <td>' . $row["detail_keyed_billed_unit"] . '</td>
                            <td>' . $row["original_service_desc"] . '</td>
                            <td>' . $row["promo_discount_aplied"] . '</td>
                            <td>' . $row["promo_discount_aliasa"] . '</td>
                            <td>' . $row["sds_match_level_cd"] . '</td>
                            <td>' . $row["sds_rdr_date"] . '</td>
                            <td>' . $row["sds_delivery_date"] . '</td>
                            <td>' . $row["sds_error"] . '</td>
                            <td>' . $row["place_holder46"] . '</td>
                            <td>' . $row["place_holder47"] . '</td>
                            <td>' . $row["place_holder48"] . '</td>
                            <td>' . $row["place_holder49"] . '</td>
                            <td>' . $row["place_holder50"] . '</td>
                            <td>' . $row["place_holder51"] . '</td>
                            <td>' . $row["place_holder52"] . '</td>
                            <td>' . $row["place_holder53"] . '</td>
                            <td>' . $row["place_holder54"] . '</td>
                            <td>' . $row["place_holder55"] . '</td>
                            <td>' . $row["place_holder56"] . '</td>
                            <td>' . $row["place_holder57"] . '</td>
                            <td>' . $row["place_holder58"] . '</td>
                            <td>' . $row["place_holder59"] . '</td>
                        </tr>  
                        ';
                }
            }
            ?>
        </table>
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