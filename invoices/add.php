<?php
require '../server/connection.php';
//require 'vendor/autoload.php';
//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\IOFactory;
require 'PHPExcel-1.8\Classes\PHPExcel\IOFactory.php';

if (isset($_POST["submit_add"])) {

    $ups = $_POST['ups_file'];
    $wms = $_POST['wms_file'];
    $c_remark = $_POST['c_remark'];

    /* temp
    //UPS title get to check 
    $ups_name_query = "SELECT * FROM filedata WHERE (name_file = '$ups')";
    $ups_result = mysqli_query($conn, $ups_name_query);
    $ups_row = mysqli_fetch_array($ups_result);
    //$check_ups_row = mysqli_fetch_array($ups_result, MYSQLI_NUM);

    //WMS title get to check
    $wms_name_query = "SELECT * FROM filedata WHERE (name_file = '$wms')";
    $wms_result = mysqli_query($conn, $wms_name_query);
    $wms_row = mysqli_fetch_array($wms_result);
    //$check_wms_row = mysqli_fetch_array($wms_result, MYSQLI_NUM);
    */


    /*
    //check ups title exist
    if ($check_ups_row[0] > 1) {
        echo '<script>alert("UPS File is not checked"); window.location.href="index.php";</script>';
        exit();
    }
    //check wms title exist
    if ($check_wms_row[0] > 1) {
        echo '<script>alert("WMS File is not checked"); window.location.href="index.php";</script>';
        exit();
    } 

    //check ups file is correct
    if (($ups_row["filetype"] != "ups_dtrans") || ($ups_row["filetype"] != "ups_ctk")){
        echo '<script>alert("Wrong UPS file uploaded"); window.location.href="index.php";</script>'; 
        exit();       
    }
    if ()
    */

    /* temp
    //ups data get
    echo $ups_row["filetype"];
    if ($ups_row["filetype"] == "ups_dtrans") {
        $ups_data_query = "SELECT * FROM ups_dtrans WHERE (name_file = '$ups') ORDER BY id DESC";
    } elseif ($ups_row["filetype"] == "ups_ctk") {
        $ups_data_query = "SELECT * FROM ups_ctk WHERE (name_file = '$ups') ORDER BY id DESC";
    }
    $ups_data_result = mysqli_query($conn, $ups_data_query);
    while ($ups_data_row = mysqli_fetch_array($ups_data_result)) {
        print_r($ups_data_row);
    }

    //WMS data get
    $wms_data_query = "SELECT * FROM wms WHERE (name_file = '$wms') ORDER BY id DESC";
    $wms_data_result = mysqli_query($conn, $wms_data_query);
    while ($wms_data_row = mysqli_fetch_array($wms_data_result)) {
        print_r($wms_data_row);
    }
    */


    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("CTK USA")
        ->setLastModifiedBy("CTK USA")
        ->setTitle("Invoice")
        ->setSubject("Invoice")
        ->setDescription("Invoice")
        ->setKeywords("CTK USA")
        ->setCategory("Invoice");
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', "12");

    $default_border = array(
        'style' => PHPExcel_Style_Border::BORDER_THIN,
        'color' => array('rgb' => '1006A3')
    );
    $style_header = array(
        'borders' => array(
            'bottom' => $default_border,
            'left' => $default_border,
            'top' => $default_border,
            'right' => $default_border,
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'B4C6E7'),
        ),
        'font' => array(
            'bold' => true,
            'size' => 11,
        )
    );
    $style_content = array(
        'borders' => array(
            'bottom' => $default_border,
            'left' => $default_border,
            'top' => $default_border,
            'right' => $default_border,
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'eeeeee'),
        ),
        'font' => array(
            'size' => 11,
        )
    );
    // Create Header
    // 	  	  	 Charges Not Subject to Markup to be 

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Lead Shipment Number')
        ->setCellValue('B1', 'Customer')
        ->setCellValue('C1', 'Ship Date')
        ->setCellValue('D1', 'Charges from DreamTrans')
        ->setCellValue('E1', 'WMS')
        ->setCellValue('F1', 'DreamTrans Margin')
        ->setCellValue('G1', 'DreamTrans Mark-up')
        ->setCellValue('H1', 'Invoice to Customer')
        ->setCellValue('I1', 'Total Mark-up from WMS')
        ->setCellValue('J1', 'CTK Margin')
        ->setCellValue('K1', 'CTK Margin %')
        ->setCellValue('L1', 'Total WMS')
        ->setCellValue('M1', 'Charged from DreamTrans Before (DreamTrans Charge Amount)')
        ->setCellValue('N1', 'Charged from DreamTrans Before (Invoiced Amount)')
        ->setCellValue('O1', 'Charges Not Subject to Markup')
        ->setCellValue('P1', 'Charges Not Subject to Markup to be')
        ->setCellValue('A5', 'Total Shipments: ');

    $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray($style_header); // give style to header
    $objPHPExcel->getActiveSheet()->getStyle('A5:P5')->applyFromArray($style_header); // give style to header

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);
    foreach (range('B', 'P') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(12);
        //$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Create Data
    $dataku = array(
        array('RIPNDIP', 'testdata1', 'array1'),
        array('GETRAEL', 'testdata2', 'array2'),
        array('OTHERS', 'testdata3', 'array3'),
    );
    $firststyle = 'A2';
    $firststyle2 = 'A6';
    for ($i = 0; $i < count($dataku); $i++) {
        $urut = $i + 2;
        $lead_shipment_num = 'A' . $urut;
        $customer = 'B' . $urut;
        $ship_date = 'C' . $urut;
        $charges_from_dTrans = 'D' . $urut;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($lead_shipment_num, $i + 1)
            ->setCellValue($customer, $dataku[$i][0])
            ->setCellValue($ship_date, $dataku[$i][1])
            ->setCellValue($charges_from_dTrans, $dataku[$i][2]);
        $laststyle = 'P' . $urut;
    }
    
    $laststyle2 = 'P6';
    $objPHPExcel->getActiveSheet()->getStyle($firststyle . ':' . $laststyle)->applyFromArray($style_content); // give style to header
    $objPHPExcel->getActiveSheet()->getStyle($firststyle2 . ':' . $laststyle2)->applyFromArray($style_content); // give style to header

    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Summary');
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet


    //============================DreamTrans============================
    /* Create a new worksheet, after the default sheet*/
    $objPHPExcel->createSheet();
    /* Add some data to the second sheet, resembling some different data types*/
    $objPHPExcel->setActiveSheetIndex(1);
    $objPHPExcel->getActiveSheet()->setTitle('DreamTrans');


    //============================WMS============================
    /* Create a new worksheet, after the default sheet*/
    $objPHPExcel->createSheet();
    /* Add some data to the second sheet, resembling some different data types*/
    $objPHPExcel->setActiveSheetIndex(2);
    $objPHPExcel->getActiveSheet()->setTitle('WMS');
    //$objPHPExcel->getActiveSheet()


    //============================Unique Data============================
    /* Create a new worksheet, after the default sheet*/
    $objPHPExcel->createSheet();
    /* Add some data to the second sheet, resembling some different data types*/
    $objPHPExcel->setActiveSheetIndex(3);
    $objPHPExcel->getActiveSheet()->setTitle('Unique Data');
    $objPHPExcel->getActiveSheet()
        ->setCellValue('A1', 'Unique Lead Shipment Number')
        ->setCellValue('B1', 'Unique Charge Description')
        ->setCellValue('C1', 'Unique Customer');

    $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($style_header); // give style to header

    foreach (range('A', 'C') as $columnID) {
        //$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }



    //============================DreamTrans By Charge============================
    /* Create a new worksheet, after the default sheet*/
    $objPHPExcel->createSheet();
    /* Add some data to the second sheet, resembling some different data types*/
    $objPHPExcel->setActiveSheetIndex(4);
    $objPHPExcel->getActiveSheet()->setTitle('DreamTrans by Charge');

    $objPHPExcel->getActiveSheet()
        ->setCellValue('A1', 'Charge Description')
        ->setCellValue('B1', 'Total DreamTrans Charges')
        ->setCellValue('C1', 'UPS Charge');

    $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($style_header); // give style to header

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    foreach (range('B', 'D') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(12);
        //$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }

    //============================End Save data============================
    $objPHPExcel->setActiveSheetIndex(0);
    // Redirect output to a client’s web browser (Excel5)
    $today = date("Y-m-d");
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Invoice_' . $today . '.xls"'); // file name of excel
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');
    // If you're serving to IE over SSL, then the following may be needed
    //header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    $objWriter->save('test.xlsx');
    exit;


    /*
    function cellColor($cells, $color)
    {
        global $objPHPExcel;

        $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $color
            )
        ));
    }

    cellColor('B5', 'F28A8C');
    cellColor('G5', 'F28A8C');
    cellColor('A7:I7', 'F28A8C');
    cellColor('A17:I17', 'F28A8C');
    cellColor('A30:Z30', 'F28A8C');
    */
}
