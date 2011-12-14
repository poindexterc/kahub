<?php
$zip = new ZipArchive();
if ($zip->open('archive.zip')) {
  $fp = $zip->getStream('myfile.txt'); //file inside archive
  if(!$fp)
    die("Error: can't get stream to zipped file");
  $stat = $zip->statName('myfile.txt');

  $buf = ""; //file buffer
  ob_start(); //to capture CRC error message
    while (!feof($fp)) {
      $buf .= fread($fp, 2048); //reading more than 2156 bytes seems to disable internal CRC32 verification (bug?)
    }
    $s = ob_get_contents();
  ob_end_clean();
  if(stripos($s, "CRC error") != FALSE){
    echo 'CRC32 mismatch, current ';
    printf("%08X", crc32($buf)); //current CRC
    echo ', expected ';
    printf("%08X", $stat['crc']); //expected CRC
  }

  fclose($fp);
  $zip->close();
  //Done, unpacked file is stored in $buf
}
?>