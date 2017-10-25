<?php require_once 'include/header.php';?>

<?php
if(isset($_REQUEST['shopInstallation']) && !empty($_REQUEST['storeName'])){
  $checkValid = strpos(strtolower($_REQUEST['storeName']), '.myshopify.com');
  if($checkValid==''){
    ?> <script> window.location.href='https://<?php echo $_SERVER["HTTP_HOST"]; ?>/NewPixelApp/app/appInstall.php?shop=<?php echo strtolower($_REQUEST["storeName"]).".myshopify.com"; ?>'; </script> <?php
  } else {
    $errorMessage = "Please remove .myshopify.com from the end of the Store Name";
  }
}
?>

<div class="container">
  <br class="xs-80">
  <br class="xs-80">
  <div class="col-md-12">
      <div class="col-md-3"></div>
      <div class="col-md-6">
            <h3>Welcome to the Custom Order Fulfilment App.</h3>
            <h5>Please Enter your Shopify Store Name to install the app</h5>
            <?php if(isset($errorMessage)) { ?>
            <h5 class="alert alert-danger"><?php echo $errorMessage; ?></h5>
            <?php } ?>
            <form class="form account-form" method="POST">
                <div class="form-group">
                <label for="storeName" class="placeholder-hidden">Add Store Name Here</label>
                <input type="text" class="form-control" id="storeName" name="storeName" placeholder="Add Store Name Here" tabindex="1">
                </div>
                <div class="form-group">
                <button type="submit" name="shopInstallation" id="shopInstallation" class="btn btn-primary btn-block btn-lg" tabindex="4">
                    Install App Now <i class="fa fa-play-circle"></i>
                </button>
                </div>
            </form>
      </div>
      <div class="col-md-3"></div>
  </div>
</div>

<?php require_once 'include/footer.php';?>





