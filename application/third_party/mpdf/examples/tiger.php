<<<<<<< HEAD
<?php

if ($_GET['t']=='png') { $filename = 'tiger.png'; $mime = 'png'; }
else if ($_GET['t']=='gif') { $filename = 'tiger.gif'; $mime = 'gif'; }
else if ($_GET['t']=='jpg') { $filename = 'tiger.jpg'; $mime = 'jpeg'; }
else if ($_GET['t']=='jpeg') { $filename = 'tiger.jpg'; $mime = 'jpeg'; }
else if ($_GET['t']=='wmf') { $filename = 'tiger.wmf'; $mime = 'wmf'; }
else if ($_GET['t']=='svg') { $filename = 'tiger.wmf'; $mime = 'svg+xml'; }
else if ($_GET['t']=='bmp') { $filename = 'tiger.wmf'; $mime = 'x-ms-bmp'; }
else { exit; }


$fp = fopen($filename, 'rb');
header("Content-Type: image/".$mime);
header("Content-Length: " . filesize($filename));
fpassthru($fp);
fclose($fp);
exit;
=======
<?php

if ($_GET['t']=='png') { $filename = 'tiger.png'; $mime = 'png'; }
else if ($_GET['t']=='gif') { $filename = 'tiger.gif'; $mime = 'gif'; }
else if ($_GET['t']=='jpg') { $filename = 'tiger.jpg'; $mime = 'jpeg'; }
else if ($_GET['t']=='jpeg') { $filename = 'tiger.jpg'; $mime = 'jpeg'; }
else if ($_GET['t']=='wmf') { $filename = 'tiger.wmf'; $mime = 'wmf'; }
else if ($_GET['t']=='svg') { $filename = 'tiger.wmf'; $mime = 'svg+xml'; }
else if ($_GET['t']=='bmp') { $filename = 'tiger.wmf'; $mime = 'x-ms-bmp'; }
else { exit; }


$fp = fopen($filename, 'rb');
header("Content-Type: image/".$mime);
header("Content-Length: " . filesize($filename));
fpassthru($fp);
fclose($fp);
exit;
>>>>>>> fb1421bf144160d23d3ade7b9df1ace667368553
?>