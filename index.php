<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ebay API</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/custom.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>

</head>
<body>

<div class="container">
	<div class="row">
		<div class="okvir col-xs-10 col-sm-8 col-md-6 col-xs-offset-1 col-sm-offset-2 col-md-offset-3">
<form method="GET" action="all_items.php" class="form-horizontal AVAST_PAM_loginform">
  <fieldset>
  <input type="text" value="1" name="xx" class="hidden">
    <legend>WooCommerce - ebay API</legend>
    <div class="form-group">
      <label for="inputKeywords" class="col-lg-2 control-label">Keywords</label>
      <div class="col-lg-10">
        <input type="text" name="keywords" class="form-control" id="inputKeywords" placeholder="Keywords" required>
      </div>
    </div>

    <div class="form-group">
      <label for="inputPrice" class="col-lg-2 control-label">Price ($)</label>
      <div class="col-lg-5">
        <input type="number"  step="0.01" name="minprice" class="form-control" id="inputPrice" placeholder="Min Price" required>
      </div>
      <div class="col-lg-5">
        <input type="number"  step="0.01" name="maxprice" class="form-control" placeholder="Max Price" required>
      </div>
      <div class="col-lg-10 col-lg-offset-2">
      	<span class="help-block">Enter the prices of products from min to max (e.g. 0.5 - 2.5)</span>
  	  </div>
    </div>

    <div class="form-group">
      <label for="inputItemPerPage" class="col-lg-2 control-label">Item / page</label>
      <div class="col-lg-10">
        <input type="text" name="itemperpage" class="form-control" id="inputItemPerPage" placeholder="Number of products per page" required>
      </div>
    </div>

	<div class="form-group">
      <label for="sortItem" class="col-lg-2 control-label">Sort item</label>
      <div class="col-lg-10">
        <select name="sortitem" class="form-control" id="sortItem" required>
          <option value="PricePlusShippingLowest">Lowest first</option>
          <option value="PricePlusShippingHighest">Higest first</option>
          <option value="">Popular items</option>
          <option value="">New items</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-lg-2 control-label">Type</label>
      <div class="col-lg-10">
        <div class="checkbox">
          <label>
            <input type="checkbox" name="producttype[]" id="single" value="single" checked="">
            Single product
          </label>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" name="producttype[]" id="variations" value="variations">
            Product with variations
          </label>
        </div>
      </div>
    </div>

    <legend class="second">WooCommerce products info</legend>

    <div class="form-group">
      <label for="Categories" class="col-lg-2 control-label">Categories</label>
      <div class="col-lg-10">
        <input type="text" name="categories" class="form-control" id="Categories" placeholder="Categories" required>
      </div>
    </div>

    <div class="form-group">
      <label for="productTags" class="col-lg-2 control-label">Product tags</label>
      <div class="col-lg-10">
        <input type="text" name="tags" class="form-control" id="productTags" placeholder="Product tags" required>
      </div>
    </div>

    <div class="form-group">
      <label for="txtName" class="col-lg-2 control-label">Name of txt file</label>
      <div class="col-lg-10">
        <input type="text" name="txtname" class="form-control" id="txtName" placeholder="Name of txt file" required>
      </div>
    </div>


    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default">Cancel</button>
        <input type="submit" class="btn btn-primary" value="Submit" name="submit" />
      </div>
    </div>
  </fieldset>
</form>

		</div>
	</div>
</div>

<div class="wait">
	<div class="wait-text">
		Please wait...
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('input.btn-primary').click(function(){
			$('.wait').css({"opacity": "1", "display": "block"});
		});
	});
</script>


</body>
</html>