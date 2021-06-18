<?php

require_once "../../config/connection.php";

$latestUsers = retrieveData("SELECT * FROM users ORDER BY register_time");

$excel = new COM("Excel.Application");

$excel->Visible = 1;
$excel->DisplayAlerts = 1;

$workbook = $excel->Workbooks->Open("http://stankovic95.epizy.com/data/latest_user.xslx") or die('Did not open filename');
$sheet = $workbook->Worksheets('Sheet1');
$sheet->activate;

$br = 1;
foreach($latestUsers as $user){
    $cell = $sheet->Range("A{$br}");
    $cell->activate;
    $cell->value = $user['id'];
    $cell = $sheet->Range("B{$br}");
    $cell->activate;
    $cell->value = $user['username'];
    $cell = $sheet->Range("C{$br}");
    $cell->activate;
    $cell->value = $user['email'];
    $cell = $sheet->Range("D{$br}");
    $cell->activate;
    $cell->value = $user['register_time'];

    $br++;
}

$cell = $sheet->Range("E{$br}");
$cell->activate;
$cell->value = count($latestUsers);

$workbook->_SaveAs("http://stankovic95.epizy.com/data/latest_user.xslx", -4143);
$workbook->Save();

$workbook->Saved=true;
$workbook->Close;

$excel->Workbooks->Close();
$excel->Quit();

unset($sheet);
unset($workbook);
unset($excel);

?>
