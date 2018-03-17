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

echo 'Keywords: ' . $keywords . '<br />';
echo 'Min price: ' . $minprice . '<br />';
echo 'Max price: ' . $maxprice . '<br />';
echo 'Item per page: ' . $itemperpage . '<br />';
echo 'Sort item: ' . $sortitem . '<br />';
echo ('Product type: ' . $producttype[0]);
if(isset($producttype[1])){echo $producttype[1]. '<br />';} 
echo 'Categories: ' . $categories . '<br />';
echo 'Product tags: ' . $tags . '<br />';
echo 'Name of txt file: ' . $txtname . '<br />';
echo 'Pagination: ' . $xx . '<br />';