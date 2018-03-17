
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Single product</title>
</head>
<body style="font-family: calibri; font-size: 11px">
	
<?php
if(isset($_GET['item_id'])){
$item_id = $_GET['item_id'];
	$categories = $_GET['categories'];
	$tags = $_GET['tags'];
	$txtname = $_GET['txtname'];


$appid = 'raghusin-ebaycurv-PRD-59f29112f-6ad6655b'; 

$url = "http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=JSON&appid=$appid&siteid=0&version=939&ItemID=$item_id";


	/*$params = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
    curl_setopt($ch, CURLOPT_URL, $apicall);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    $result = curl_exec($ch);
    $result = json_decode($result,true);
    
    $results = $result['result'];*/

$result = file_get_contents($url);
$result = json_decode($result, true);

$sku = $result['Item']['ItemID'];
$item_title = $_GET['item_title'];
$price = (int)(floatval($result['Item']['ConvertedCurrentPrice'])*420);

$pic_url = $result['Item']['PictureURL'];
$all_img = count($pic_url);
$images = '';
for ($i=0; $i < $all_img; $i++) {
	$images .=','.$result['Item']['PictureURL'][$i];
}
$length = strlen($images)-1;
$images = substr($images,1,$length);

$name = 'Novo u ponudi!' . date('Y.m.d - H:m');
$description = $item_title;

$list = array
(
$sku,$name,'1',$description,$price,$categories,$tags,$images
);

// SKU,Name,Published,Description,"Regular price",Categories,Tags,Images

$filename = $txtname.'.txt';

$handle = fopen($filename, "a");
fputcsv($handle, $list);
fclose($handle);
?>
	<div style="text-align: center; padding: 20px; border-bottom: 1px solid #4d4d4d">
		<h2 style='color: green;'>SAČUVANO! :)</h2>
	</div>
<?php
} else {
	$xx = $_GET['xx'];
	header('Location: index.php?xx=$xx');
}

?>
</body>
</html>