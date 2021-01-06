<?php
$header = filter_input(INPUT_GET, 'id');
header('Clear-Site-Data: "cache"');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-Type: application/xml; charset=utf-8");
header("refresh:0;url=edit_images.php?id=" . $header . "");
die;
?>
