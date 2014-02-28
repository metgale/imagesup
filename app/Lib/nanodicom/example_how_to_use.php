<?php

require_once 'ExtractDataFromDiCOM.php';
$x = new DicomExtractor();
$res = $x->parse("D:/projects/medical/assets/mri_small/mri", "d:/temp/mri");
print_r($res);

?>