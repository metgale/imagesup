<?php

class DicomExtractor {
   
   /* @var $varName String */
   private $dir = array();
   
   public function parse($srcPath, $dstPath) {
     // echo 'Started   '.date('m/d/Y h:i:s a', time()).'<br>';                    
		$res2 = array();		
		$this->dir = $srcPath;
		$this->dstPath = $dstPath;
		if ($handle = opendir($this->dir)) {
			while (false !== ($directory = readdir($handle))) //store all dicome files names to array
			{
				if ($directory != "." && $directory != "..") {	
					$directories[] = $directory;
				}
			}
			closedir($handle);
		}
		foreach ($directories as $directory)//go each dicom file one by one
		{
			$this->parseDirectory($directory, $res2);
		}
				 
		//echo 'Finished   '.date('m/d/Y h:i:s a', time());
		return $res2;		 
	}
	
	private function parseDirectory($directory, &$res2) {
		$files = array();
		if ($handle = opendir($this->dir . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR)) {
			 while (false !== ($file = readdir($handle))) //store all dicome files names to array
				{
				 if ($file != "." && $file != "..")
						{	
					$files[] = $file;
						}
				 }
			closedir($handle);
		}

		foreach ($files as $file)//go each dicom file one by one
		{
			$this->parseFile($file, $directory, $res2);
		}
	}
	
	private function parseFile($file, $directory, &$res2) {
		$filename = $this->dir . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $file;		
		
		$dicom = Nanodicom::factory($filename, 'simple'); //get tags out of dicom
		$dicom->parse(array('WindowWidth'));
		
		if ($dicom->WindowWidth == 0)
			return;
		
		$SeriesNumber = trim($dicom->SeriesNumber);		
		$dstSubfolder = $this->dstPath . DIRECTORY_SEPARATOR . $SeriesNumber;
		
		if ( !file_exists($dstSubfolder) && !is_dir($dstSubfolder) ){ 
				mkdir($dstSubfolder, 0777);
		}
		
		$dicom = Nanodicom::factory($filename,'pixeler'); //extract jpg from dicom			  
		if (!file_exists($filename.'.0.jpg'))
		{		
			$images = $dicom->get_images();
			if ($images !== FALSE)
			{
				foreach ($images as $index => $image)
				{						
					//$dicom = Nanodicom::factory($filename, 'simple');//get tags out of dicom
					$dicom->parse(array('InstanceNumber'));

					$imgSequence=trim($dicom->InstanceNumber);						
					
					$basicFileName = $imgSequence . "_" . $file . "_" . $index;	
					$basicFullPath = $dstSubfolder . DIRECTORY_SEPARATOR . $basicFileName;
					
					$imgName = $basicFileName . '.jpg';
					$imgFullPath = $dstSubfolder . DIRECTORY_SEPARATOR . $imgName;
					
					$thumbFileName = 'thumb_' . $basicFileName . '.jpg';						
					$thumbFullPath = $dstSubfolder . DIRECTORY_SEPARATOR . $thumbFileName;
					
					$txtFileName = $basicFileName . ".txt";
					$txtFullPath = $dstSubfolder . DIRECTORY_SEPARATOR . $txtFileName;
					
					$res = $dicom->write_image($image, $basicFullPath);//write image to a file					
					if ($res == FALSE) {
						echo "[FAIL 2348723]\n";
						print_r($dicom->last_error());
						die;
					}
					
					DicomExtractor::makeThumb($imgFullPath, $thumbFullPath);//make tumbs - function is not written by me
					
					$fh = fopen($txtFullPath, 'w') or die("can't open file");
					
					if (!array_key_exists($SeriesNumber, $res2)) {
						$res2[$SeriesNumber] = array();
						$res2[$SeriesNumber]['directory'] = $SeriesNumber;
						$res2[$SeriesNumber]['title'] = trim($dicom->SeriesDescription);
						$res2[$SeriesNumber]['images'] = array();
					}
											
					$res2[$SeriesNumber]['images'][] = array(
							'title' => $file,
							'fileName' => $imgName,
							'thumbFileName' => $thumbFileName,
							'txtFileName' => $txtFileName,
							'order' => $imgSequence
					);
											
					$this->writeLine($fh, $imgFullPath, 'Patient Name:', $dicom->PatientName, 'PatientName');
					$this->writeLine($fh, $imgFullPath, 'Patient ID:', $dicom->PatientID, 'PatientID');
					$this->writeLine($fh, $imgFullPath, 'Patient Sex:', $dicom->PatientSex, 'PatientSex');
					$this->writeLine($fh, $imgFullPath, 'Patient Age:', $dicom->PatientAge, 'PatientAge');					 
					$this->writeLine($fh, $imgFullPath, 'Patient Weight:', $dicom->PatientWeight, 'PatientWeight');
					$this->writeLine($fh, $imgFullPath, 'Patient Address:', $dicom->PatientAddress, 'PatientAddress');
					$this->writeLine($fh, $imgFullPath, 'Study Date:', $dicom->StudyDate, 'StudyDate');
					$this->writeLine($fh, $imgFullPath, 'Study Time:', $dicom->StudyTime, 'StudyTime');						
					$this->writeLine($fh, $imgFullPath, 'Study ID:', $dicom->StudyID, 'StudyID');						 
					$this->writeLine($fh, $imgFullPath, 'Study Modality:', $dicom->Modality, 'Modality');						
					$this->writeLine($fh, $imgFullPath, 'Study Description:', $dicom->StudyDescription, 'StudyDescription');						
					$this->writeLine($fh, $imgFullPath, 'Series Date:', $dicom->SeriesDate, 'SeriesDate');
					$this->writeLine($fh, $imgFullPath, 'Series Time:', $dicom->SeriesTime, 'SeriesTime');						
					$this->writeLine($fh, $imgFullPath, 'Series Description:', $dicom->SeriesDescription, 'SeriesDescription');
					
					fclose($fh); 
				}
			}
			else {
				//echo "There are no DICOM images or transfer syntax not supported yet.\n";
			}
			//$images = NULL;
		}
		else {
			// echo "Image already exists\n";
		}

	}
	
	private function writeLine($fh, $imgFullPath, $title, $dicomFieldValue, $theKey) {
		$stringData = $title . $dicomFieldValue . "\r\n";
		//$this->res[$imgFullPath][$theKey] = $dicomFieldValue;
		fwrite($fh, $stringData);
	}
						
						
	//two functions below are not written by me - creating tumbnails from the jpeg files
	function ImageCopyResampleBicubic(&$dst_img, &$src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h)  {
		ImagePaletteCopy ($dst_img, $src_img);
		$rX = $src_w / $dst_w;
		$rY = $src_h / $dst_h;
		$w = 0;
		for ($y = $dst_y; $y < $dst_h; $y++)  {
			$ow = $w; 
			$w = round(($y + 1) * $rY);
			$t = 0;
			for ($x = $dst_x; $x < $dst_w; $x++)  {
				$r = $g = $b = 0; $a = 0;
				$ot = $t; 
				$t = round(($x + 1) * $rX);
				for ($u = 0; $u < ($w - $ow); $u++)  {
					for ($p = 0; $p < ($t - $ot); $p++)  {
						$c = ImageColorsForIndex ($src_img,ImageColorAt ($src_img, $ot + $p, $ow + $u));
						$r += $c['red'];
						$g += $c['green'];
						$b += $c['blue'];
						$a++;
					}
				}
				ImageSetPixel ($dst_img, $x, $y,ImageColorClosest ($dst_img, $r / $a, $g / $a, $b / $a));
			}
		}
	}
	
	function makeThumb($cale_in,$cale_out)  {
			global $thumbsize;
			$make_thumbs = "YES";
			$thumbsize[0] = 100;
			$thumbsize[1] = 75;
			
			$sursa = imagecreatefromjpeg($cale_in);
			//echo 'source file'.$cale_in.'<br>';
			$is_jpeg = getimagesize($cale_in);
			$ws = $is_jpeg[0];
			$hs = $is_jpeg[1];
			//echo 'sizeX'.$is_jpeg[0].'  sizeY'.$is_jpeg[1].'<br>';
			if($ws > $thumbsize[0] && $hs > $thumbsize[1])
			{
				$aspect = $ws/$hs;
				if($aspect <= 1.333333)  {
					$hd = $thumbsize[1];
					$wd = floor($hd*$aspect);
				}
				else  {
					$wd = $thumbsize[0];
					$hd = floor($wd/$aspect);
				}
				$Z = ceil(log(($ws*$hs)/(4*$thumbsize[0]*$thumbsize[1])))+1;
				if(log(($ws*$hs)/(4*$thumbsize[0]*$thumbsize[1])) < 0) $Z=1;
				$dx = $dy = 0;
				if($Z > 1) {
					$dest = imagecreatetruecolor(round($ws/$Z), round($hs/$Z));
					for($i=0; $i < $hs; $i+=$Z) {
						for($j=0; $j < $ws; $j+=$Z) {
							$rgb = imagecolorat($sursa, $j, $i);
							$r = ($rgb >> 16) & 0xFF;
							$g = ($rgb >> 8) & 0xFF;
							$b = $rgb & 0xFF;
							$pcol = imagecolorallocate($dest, $r, $g, $b);
							imagesetpixel($dest, $dx, $dy, $pcol);
							$dx++;
						}
						$dx=0;
						$dy++;
					}
				}
				else
				{
					$dest = imagecreatetruecolor($ws, $hs);
					imagecopy($dest, $sursa, 0, 0, 0, 0, $ws, $hs );   
				}
				imagedestroy($sursa);
				$destrs = imagecreatetruecolor($wd, $hd);
				DicomExtractor::ImageCopyResampleBicubic($destrs,$dest,0,0,0,0,$wd,$hd,round($ws/$Z),round($hs/$Z));
				ImageJpeg($destrs, $cale_out, 100);   
				//echo "Z:$Z <b>|</b> ($ws x $hs) -> ($wd x $hd) @ ".$ws/$hs;
			}   
		}
}

?>