<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> e85f267b1bc70e8b5f740fc3646b3abfa29e11ff
<?php
	$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
	if (!$msg) $msg = "Le site du spipu\r\nhttp://spipu.net/";


	$err = isset($_GET['err']) ? $_GET['err'] : '';
	if (!in_array($err, array('L', 'M', 'Q', 'H'))) $err = 'L';
	
	require_once('qrcode.class.php');
	
	$qrcode = new QRcode(utf8_encode($msg), $err);
	$qrcode->disableBorder();
	$qrcode->displayPNG(200);
<<<<<<< HEAD
=======
=======
<?php
	$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
	if (!$msg) $msg = "Le site du spipu\r\nhttp://spipu.net/";


	$err = isset($_GET['err']) ? $_GET['err'] : '';
	if (!in_array($err, array('L', 'M', 'Q', 'H'))) $err = 'L';
	
	require_once('qrcode.class.php');
	
	$qrcode = new QRcode(utf8_encode($msg), $err);
	$qrcode->disableBorder();
	$qrcode->displayPNG(200);
>>>>>>> fb1421bf144160d23d3ade7b9df1ace667368553
>>>>>>> e85f267b1bc70e8b5f740fc3646b3abfa29e11ff
?>