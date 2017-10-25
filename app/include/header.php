<?php 
include 'include/DBConnection.php'; ?>
<?php if(isset($_REQUEST['shop'])){ $_SESSION['shop']=$_REQUEST['shop']; } ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FB Track</title>
    <link rel="stylesheet" href="include/css/style.css" />
    <link rel="stylesheet" href="include/css/bootstrap.css" />
    <link rel="stylesheet" href="include/css/bootstrap-theme.css" />
    <link rel="stylesheet" href="include/css/jquery.toast.css" />
    <link rel="stylesheet" type="text/css" href="include/css/dd.css" />
    <link rel="stylesheet" href="include/css/normalize.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script type="text/javascript" src="include/js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="include/js/bootstrap.js"></script>
    <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
    <script src="include/js/jquery.toast.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <?php if(isset($_SESSION['shop'])) { ?>
  <script type="text/javascript">
      ShopifyApp.init({
         apiKey: 'be6bd1d9e3699cdc260dbab1f878829c',
         shopOrigin: 'https://<?php
         echo $_SESSION["shop"]; ?>'
      });
   </script>
   <script type="text/javascript">
      ShopifyApp.ready(function(){
         ShopifyApp.Bar.loadingOff();
         ShopifyApp.Bar.initialize({
          buttons: {
            primary: {
              label: "Save Settings", 
              callback: function(){ 
                ShopifyApp.Modal.confirm({
                  title: "Add New Pixel Id",
                  message: "Please Make Sure Pixel Id Fields aren't Empty Or Neither have Duplicate Values.",
                  cancelButton: "Cancel",
                  okButton: "Continue",
                  style: "success"
                }, function(result){
                  if(result){
                    ShopifyApp.Bar.loadingOn(); $('#pixel-form').submit();
                  }
                }); 
            },
              message: 'bar_save'
            },
            secondary:[ 
            { label: "Pixels", href: "AppMain.php"},
            { label: "FAQ", href: "" }
            ],
          },
          //title: 'Page Title'
        });
      });
   </script>
   <?php } ?>
  </head>
<body>