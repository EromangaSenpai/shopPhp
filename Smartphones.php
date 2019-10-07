<?php
if (!isset($_SESSION))
    session_start();

require 'phpScripts/ProductInfo.php';
require 'phpScripts/UserInfo.php';

if(isset($_SESSION['key']))
{
    $userInfo = new UserInfo($_SESSION['key'], $_SESSION['email'], $_SESSION['name']);
    $btn = $userInfo->IsAdmin();
}
else
{
    $userInfo = new UserInfo('','','');
}

$productInfo = new ProductInfo;

$info = $productInfo->info;
$goods = $productInfo->goods;
$goodsArr = $productInfo->goodsArr;
$modal = $userInfo->ModalWindowType();
$cartModal = $userInfo->ModalWindowCartType();

?>


<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/myStyles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script>
        function AddToCart() {
            var textHtml = document.getElementById('cartCount').innerHTML;
            if(textHtml == "")
            {
                var elem = 0;
                elem += 1;
            }
            else
            {
                var elem = parseInt(document.getElementById('cartCount').innerText);
                elem += 1;
            }
            document.getElementById('cartCount').innerHTML = elem;
        }
    </script>
    <style>
        hr {
            border:1px solid rgb(211, 211, 211);
            border-bottom-width: 0;
        }
    </style>
    <title>Main Page</title>
<body class="background">

<div class="pos-f-t">
    <nav id="anchor" class="navbar navbar-dark bg-dark">
        <div class="form-inline">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span> Catalog
            </button>
            <?php if(!empty($btn)): echo $btn; endif;?>
        </div>

        <div class="form-inline">
            <!--a href="phpScripts/ExitScript.php" class="mr-4 text-danger">Exit</a-->
            <a href="#" class="mr-4" data-toggle="modal" data-target="#exampleModal"><?php if(!isset($_SESSION['key'])): echo 'Hello User'; else: echo $_SESSION['name']; endif;?></a>
            <button class="btn btn-outline-success mr-sm-2">Compare</button>
            <button data-toggle="modal" data-target="#cartModal" class="btn btn-outline-success my-2 my-sm-0"><span><img src="fonts/icon_cart.svg" width="20px" height="20px"></span>
                &nbsp;Cart &nbsp;<span class="badge badge-dark" id="cartCount"></span></button>
        </div>
        <!-- Cart Modal -->
        <?php echo $cartModal?>
        <!--End Cart Modal -->


        <!-- Modal -->
        <?php echo $modal?>
        <!--End Modal -->

    </nav>

    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
            <h4 class="text-white">Products</h4>
            <hr>
            <ul>
                <h3 class="text-light"><a href="MainPage.php">Main Page</a></h3>
                <li><a href="Smartphones.php">Smartphones</a></li>
                <li><a href="Laptops.php">Laptops</a></li>
                <li><a href="Tvs.php">TVs</a></li>
            </ul>
        </div>
    </div>
</div>

<br>


<div class="container" id="maindiv">
    <center><h1 class="bg-secondary">Our smartphones catalog</h1></center>
    <?php echo $info?>
    <div class="row" id="myImg">
        <?php foreach($goodsArr['smartphones'] as $item): echo $item; endforeach; ?>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function(){
        $("#menu").on("click","a", function (event) {
            event.preventDefault();
            var id  = $(this).attr('href'),
                top = $(id).offset().top;
            $('body,html').animate({scrollTop: top}, 1500);
        });
    });
</script>
</body>
