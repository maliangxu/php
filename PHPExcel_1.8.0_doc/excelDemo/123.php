<?php
          /* 补充说明下，很多人之所以出现各种问题，最大的原因就是导入问题，给出我 *的路径，ThinkPHP/Extend/Vendor.  放在这是因为最近用到比较多，到底放 *哪好，您自己看着办吧，如果只是偶尔用用，大可以直接扔在项目里。或者您 *干脆直接用我注释掉的路径里。我觉的这几行代码不需要什么多的注释， *我认为再多的注释都不如自己动手实验，大可以用断点法，查看所有步骤的内 *容。这比再多的注释都要来的实在 */ 
           function insertCus($file){      
            // if($_FILES['excel']['name']){    
                /*有文件上传引用上传类，返回文件名*/             
                //$fileName=$this->_upload();               
                //if($fileName){                 
                //$file='./Public/Upload/Excel/'.date('Ymd').'/'.$fileName; 
                 //导入excel类
                 require_once 'PHPClasses/PHPExcel.php';
                 require_once 'PHPClasses/PHPExcel/IOFactory.php';
                 require_once 'PHPClasses/PHPExcel/Reader/Excel5.php'; 
                 require_once 'PHPClasses/PHPExcel/Reader/Excel2007.php';               
                /* vendor('phpExcel.PHPExcel');                 
                 vendor('phpExcel.PHPExcel.IOFactory');                 
                 vendor('phpExcel.PHPExcel.Reader.Excel5');                 
                 vendor('phpExcel.PHPExcel.Reader.Excel2007'); */
 /* require_once './ThinkPHP/Extend/Library/ORG/Net/PHPExcel.class.php'; require_once './ThinkPHP/Extend/Library/ORG/Net/PHPExcel/IOFactory.php'; require_once './ThinkPHP/Extend/Library/ORG/Net/PHPExcel/Reader/Excel5.php';*/                       
                 /*获取Excel文件类型，确定版本*/                 
                 $extend=pathinfo($file);                 
                 $extend = strtolower($extend["extension"]);               
                 $extend=='xlsx'?$reader_type='Excel2007':$reader_type='Excel5';                 
                 $objReader = PHPExcel_IOFactory::createReader($reader_type);                 
                 if(!$objReader){                     
                 $this->error('抱歉！excel文件不兼容。'); //执行失败，直接抛出错误中断                 
                 }                 
                 $objPHPExcel= $objReader->load($file);                  
                 $objWorksheet= $objPHPExcel->getActiveSheet();                 
                 $highestRow= $objWorksheet->getHighestRow();                   
                 $highestColumn = $objWorksheet->getHighestColumn();                  
                 $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数                 
                 $headtitle = array();                 
                 for($cols = 0 ;$cols<=$highestColumnIndex;$cols++){                         
                    $headtitle[$cols] =(string)$objWorksheet->getCellByColumnAndRow($cols, 1)->getValue();                  
                 }                 
                 if(empty($headtitle[0])){
                       for($cols = 0 ;$cols<=$highestColumnIndex;$cols++){                         
                       $headtitle[$cols] =(string)$objWorksheet->getCellByColumnAndRow($cols, 2)->getValue();                     
                       }                 
                 }                                          
                 $strs = array();                             
                 /*第二行开始读取*/                 
                 for ($cols = 0 ;$cols<=$highestColumnIndex;$cols++){                     
                     for($row = 2;$row <= $highestRow;$row++){                         
                     $strs[$cols][$row] =(string)$objWorksheet->getCellByColumnAndRow($cols, $row)->getValue();                     
                     }                 
                 }                 
                 var_dump($strs);//显示结果             
            // }         
        // }     
     }

     insertCus('test.xlsx');
?>