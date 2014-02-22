<?php

require_once 'ExtractDataFromDiCOM.php';
$x = new DicomExtractor();
$res = $x->parse("C:/source/mri", "C:/destenation/mri");
print_r($res);

?>