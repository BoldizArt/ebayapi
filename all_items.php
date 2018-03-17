<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Rezultati pretrage</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/custom.css">
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
    <ul class="pagination">
      <li class="disabled"><a href="#">&laquo;</a></li>
      <li class="active"><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">4</a></li>
      <li><a href="#">5</a></li>
      <li><a href="#">&raquo;</a></li>
    </ul>
<?php

$keywords = $minprice = $maxprice = $itemperpage = $sortitem = $types = $producttype = $producttype[0] = $producttype[1] = $categories = $tags = $txtname = '';

if (isset($_GET['submit'])) {
  $keywords = test_input($_GET['keywords']);
  $minprice = test_input($_GET['minprice']);
  $maxprice = test_input($_GET['maxprice']);
  $itemperpage = test_input($_GET['itemperpage']);
  $sortitem = test_input($_GET['sortitem']);
  $producttype = $_GET['producttype'];
  $categories = test_input($_GET['categories']);
  $tags = test_input($_GET['tags']);
  $txtname = test_input($_GET['txtname']);
  $xx = test_input($_GET['xx']);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

#### Definisanje promenljive.
$i = '0';
$results = "";
$query = $keywords; // Ključna reč za pretragu
$safequery = urlencode($query); // "URL-friendly" query

// error_reporting(E_ALL);
$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1'; // URL
$version = '1.0.0'; // API verzija
$appid = 'raghusin-ebaycurv-PRD-59f29112f-6ad6655b'; // eBay AppID
$globalid = 'EBAY-US';
$pgn='Pagination.PageNumber';

#### Podešavanje parametre za pretragu
$filterarray =
  array(
  	array(
  	'name' => 'isMultiVariationListing',
  	'value' => 'false',
    'paramName' => '',
    'paramValue' => ''),
    array(
    'name' => 'shipToLocations',
    'value' => 'Worldwide',
    'paramName' => '',
    'paramValue' => ''),
	array(
    'name' => 'MinPrice',
    'value' => $minprice,
    'paramName' => 'Currency',
    'paramValue' => 'USD'),
    array(
    'name' => 'MaxPrice',
    'value' => $maxprice,
    'paramName' => 'Currency',
    'paramValue' => 'USD'),
    array(
    'name' => 'FreeShippingOnly',
    'value' => 'true',
    'paramName' => '',
    'paramValue' => ''),
    array(
    'name' => 'ListingType',
    'value' => array('FixedPrice','StoreInventory'),
    'paramName' => '',
    'paramValue' => ''),
  );

#### 
function buildURLArray ($filterarray) {
  global $urlfilter;
  global $i;
  foreach($filterarray as $itemfilter) {
    foreach ($itemfilter as $key =>$value) {
      if(is_array($value)) {
        foreach($value as $j => $content) {
          $urlfilter .= "&itemFilter($i).$key($j)=$content";
        }
      } else if($value != "") {
        $urlfilter .= "&itemFilter($i).$key=$value";
      }
    }
    $i++;
  }
  return "$urlfilter";
  // echo $urlfilter;
}

buildURLArray($filterarray);

#### Broj stranice
if (isset($_GET["xx"])) {
  $xx=(int)$_GET["xx"];

}else{  
    $xx= 1;
}

#### HTTP GET call 
$apicall = "$endpoint?";
$apicall .= "OPERATION-NAME=findItemsByKeywords";
$apicall .= "&SERVICE-VERSION=$version";
$apicall .= "&SECURITY-APPNAME=$appid";
$apicall .= "&GLOBAL-ID=$globalid";

$apicall .= "&keywords=$safequery";
$apicall .= "&paginationInput.entriesPerPage=".$itemperpage;
$apicall .= "&paginationInput.pageNumber=".$xx;
$apicall .= "&sortOrder=".$sortitem;
$apicall .= "$urlfilter";

$resp = simplexml_load_file($apicall);

/* 	echo "<pre />";
	print_r($resp->searchResult);die; */

// Proverava konekciju
if ($resp->ack == "Success") {

  foreach($resp->searchResult->item as $item) {
// echo "<pre>";
// var_dump($item);die;
    $item_var = $item->isMultiVariationListing;
    $shipp_to = $item->shippingInfo->shipToLocations;

  	    $pic   = $item->galleryURL;
  	    $link  = $item->viewItemURL;
  	    $item_title = $item->title;
  	    $item_subtitle = $item->subtitle;
  	    $paymentMethod = $item->paymentMethod;
  	    $item_id = $item->itemId;

   	//echo "<pre />";
  	//print_r( $item->shippingInfo->shipToLocations);die;

  	$url = "http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=JSON&appid=$appid&siteid=0&version=939&ItemID=$item_id";

  	$result = file_get_contents($url);
  	$result = json_decode($result, true);

  	$pic_url = $result['Item']['PictureURL'];
  	$all_img = count($pic_url);
  	if($all_img>2){$all_img = 2;}

  	$image = "";
  	for ($i=0; $i < $all_img; $i++) {

  		$image .= '<div class="col-md-6"><img style="width:100%" src="' . $result['Item']['PictureURL'][$i] . '" alt=""><br /></div>';
  	}

  	    foreach ($resp->searchResult->item->sellingStatus as $value) {
  	          $price = $item->sellingStatus->currentPrice;
  	    }

  	    foreach ($resp->paginationOutput as $value) {
  	      $Pageno = $resp->paginationOutput->pageNumber;
  	      $totalEntries = $resp->paginationOutput->totalEntries;
  	      $totalPage = $resp->paginationOutput->totalPages;
  	    }

  		if($item_var == 'false' && isset($producttype[0])){
  	     $results .= "
          <div class='col-md-4'>
            <div class='panel panel-success'>
              <div class='panel-heading'>
                <h3 class='panel-title'>
                  <a href='$link\' target='blank'>$item_title</a>
                </h3>
              </div>
              <div class='panel-body row'>
                <div class='col-xs-8'>
                  <h5>$item_subtitle</h5>
                  <p>Price: $$price</p>
                  <p>Shipp to: $shipp_to</p>
                </div>
                <div class='col-xs-4'>
                  <a class='btn btn-success save-btn' href='single_item.php?item_id=$item_id&item_title=$item_title&xx=$xx&categories=$categories&tags=$tags&txtname=$txtname' target='_blank'>Save</a>
                </div>
              <div class='row'>
                $image
              </div>
              </div>
            </div>
          </div>";
      } else /*if(isset($producttype[1]))*/{
         $results .= "
          <div class='col-md-4'>
            <div class='panel panel-warning'>
              <div class='panel-heading'>
                <h3 class='panel-title'>
                  <a href='$link\' target='blank'>$item_title</a>
                </h3>
              </div>
              <div class='panel-body row'>
                <div class='col-xs-8'>
                  <h5>$item_subtitle</h5>
                  <p>Price: $$price</p>
                  <p>Shipp to: $shipp_to</p>
                </div>
                <div class='col-xs-4'>
                  <a class='btn btn-success save-btn' href='single_item.php?item_id=$item_id&item_title=$item_title&xx=$xx&categories=$categories&tags=$tags&txtname=$txtname' target='_blank'>Save</a>
                </div>
              <div class='row'>
                $image
              </div>
              </div>
            </div>
          </div>";
      }
  	}
  }
// Ako nije uspešna, ispiše grešku
else {
  $results  = "<h3> Ooop, nešto nije u redu! ";
  $results .= "Pokušaj ponovo. :p</h3>";
}
?>

      <div class="row">
          <?php echo $results;?>
      </div>
        <ul class="pagination">
          <li class="disabled"><a href="#">&laquo;</a></li>
          <li class="active"><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#">5</a></li>
          <li><a href="#">&raquo;</a></li>
        </ul>
    </div>
  </body>
</html>