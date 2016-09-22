<?php
/**
 * @desc PHPEXCEL导入
 * return array();
 */
function importExcel($file)
{
    require_once 'PHPClasses/PHPExcel.php';
    require_once 'PHPClasses/PHPExcel/IOFactory.php';
    require_once 'PHPClasses/PHPExcel/Reader/Excel2007.php';  
    require_once 'PHPClasses/PHPExcel/Reader/Excel5.php';

    $extend=pathinfo($file);                 
    $extend = strtolower($extend["extension"]);               
    $extend=='xlsx'?$reader_type='Excel2007':$reader_type='Excel5'; 
    $objReader = PHPExcel_IOFactory::createReader($reader_type);//use excel2007 for 2007 format
    if(!$objReader){                     
        $this->error('抱歉！excel文件不兼容。'); //执行失败，直接抛出错误中断                 
    } 
    $objPHPExcel = $objReader->load($file);

    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow(); // 取得总行数
    $highestColumn = $sheet->getHighestColumn(); // 取得总列数
    $objWorksheet = $objPHPExcel->getActiveSheet();
 
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $excelData = array();
    for ($col = 0; $col < $highestColumnIndex; $col++) {
        for ($row = 1; $row <= $highestRow; $row++) {
            $excelData[$col][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
        }
    }
    return $excelData;
}

//用法：
var_dump(importExcel('1.xls'));

?>