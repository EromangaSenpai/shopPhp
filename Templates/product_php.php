<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 18.10.2019
 * Time: 2:15
 */
require_once 'phpScripts/db.php';
require_once 'phpScripts/UserInfo.php';
require_once 'phpScripts/ServerInfo.php';

if (!R::testConnection())
    exit ('Нет соединения с базой данных');

if (!isset($_SESSION))
    session_start();

if(empty($_GET['id']))
    $_GET['id'] = $_SESSION['productId'];

$product = R::findOne('goods', 'id = ?', array($_GET['id']));

if($product == null)
    header('Location: MainPage.php');

$_SESSION['productId'] = $_GET['id'];

$reviews = array();

if(isset($_SESSION['key']))
{
    $userInfo = new UserInfo($_SESSION['key'], $_SESSION['email'], $_SESSION['name']);
    $btn = $userInfo->IsAdmin();
}
else
{
    $userInfo = new UserInfo('','','');
}
$serverInfo = new ServerInfo;
$text = "Catalog";
if($serverInfo->IsMobile())
{
    $text = "";
}

$modal = $userInfo->ModalWindowType();
$cartModal = $userInfo->ModalWindowCartType();
$myCart = null;



if(isset($_SESSION['savingCart'])) {
    $myCart = $_SESSION['savingCart'];
}


?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Product title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicons -->
    <link rel="shortcut icon" href="">
    <!-- Fontawesome css -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Ionicons css -->
    <link rel="stylesheet" href="css/ionicons.min.css">
    <!-- linearicons css -->
    <link rel="stylesheet" href="css/linearicons.css">
    <!-- Nice select css -->
    <link rel="stylesheet" href="css/nice-select.css">
    <!-- Jquery fancybox css -->
    <link rel="stylesheet" href="css/jquery.fancybox.css">
    <!-- Jquery ui price slider css -->
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <!-- Meanmenu css -->
    <link rel="stylesheet" href="css/meanmenu.min.css">
    <!-- Nivo slider css -->
    <link rel="stylesheet" href="css/nivo-slider.css">
    <!-- Owl carousel css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Custom css -->
    <link rel="stylesheet" href="css/default.css">
    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">

    <!-- Modernizer js -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <style>
        .my-background{
    background: #536976;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #292E49, #536976);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #292E49, #536976); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
        .footer-background{
    background: #aabdbd91;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #7e888891, #536976);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #7e888891, #536976); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
    </style>
</head>

<body>

<!-- Start Navbar -->
<div class="pos-f-t">
    <nav id="anchor" class="navbar navbar-dark bg-dark">
        <div class="form-inline">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span> <?php echo $text?>
            </button>
            <?php if(!empty($btn)): echo $btn; endif;?>
        </div>

        <div class="form-inline">
            <a href="#" class="mr-4" data-toggle="modal" data-target="#exampleModal"><?php if(!isset($_SESSION['key'])): echo 'Hello User'; else: echo $_SESSION['name']; endif;?></a>
            <!--button class="btn btn-outline-success mr-sm-2">Compare</button-->
            <button data-toggle="modal" data-target="#cartModal" class="btn btn-outline-success my-2 my-sm-0"><span><img src="fonts/icon_cart.svg" width="20px" height="20px"></span>
                &nbsp;Cart &nbsp;<span class="badge badge-dark" id="cartCount"><?php if(isset($_SESSION['count'])): echo $_SESSION['count']; endif;?></span></button>
        </div>




        <!-- Cart Modal -->
        <?php if(empty($cartModal)): echo "<div class=\"modal fade\" id=\"cartModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLongTitle\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"cartModal\">Add to cart</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        <table class=\"table table-striped\" style=\"cursor: pointer\">
            <thead>
            <tr>
                <th>Id</th>
                <th>Product Name</th>
                <th>Firm Name</th>
                <th>Type</th>
                <th>Count</th>
            </tr>
            </thead>
            <tbody id=\"myCartTable\">
                $myCart
            </tbody>
        </table>
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
        <form method='post' action='phpScripts/buy.php'>
        <button onclick=\"buy()\" type=\"submit\" class=\"btn btn-primary\">Buy</button>
        </form>
      </div>
    </div>
  </div>
</div>"; endif;?>
        <!--End Cart Modal -->


        <!-- Cabinet Modal -->
        <?php echo $modal?>
        <!--End Cabinet Modal -->

    </nav>

    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
            <h4 class="text-white">Products</h4>
            <hr>
            <ul>
                <li><a href="Smartphones.php">Smartphones</a></li>
                <li><a href="Laptops.php">Laptops</a></li>
                <li><a href="Tvs.php">TVs</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- End Navbar-->

<!-- Main Wrapper Start Here -->
<div class="wrapper my-background">


    <!-- Product Thumbnail Start -->
    <div class="main-product-thumbnail ptb-100 ptb-sm-60">
        <div class="container">
            <div class="thumb-bg bg-dark">
                <div class="row">
                    <!-- Main Thumbnail Image Start -->
                    <div class="col-lg-5 mb-all-40">
                        <!-- Thumbnail Large Image start -->
                        <div class="tab-content">
                            <?php
                            echo "<div id=\"thumb1\" class=\"tab-pane fade show active\">
                                <a data-fancybox=\"images\" href=\"$product->image_path\"><img src=\"$product->image_path\" alt=\"product-view\"></a>
                            </div>
                            <div id=\"thumb2\" class=\"tab-pane fade\">
                                <a data-fancybox=\"images\" href=\"$product->image_path\"><img src=\"$product->image_path\" alt=\"product-view\"></a>
                            </div>
                            <div id=\"thumb3\" class=\"tab-pane fade\">
                                <a data-fancybox=\"images\" href=\"$product->image_path\"><img src=\"$product->image_path\" alt=\"product-view\"></a>
                            </div>
                            <div id=\"thumb4\" class=\"tab-pane fade\">
                                <a data-fancybox=\"images\" href=\"$product->image_path\"><img src=\"$product->image_path\" alt=\"product-view\"></a>
                            </div>
                            <div id=\"thumb5\" class=\"tab-pane fade\">
                                <a data-fancybox=\"images\" href=\"$product->image_path\"><img src=\"$product->image_path\" alt=\"product-view\"></a>
                            </div>"
                            ?>
                        </div>
                        <!-- Thumbnail Large Image End -->
                        <!-- Thumbnail Image End -->
                        <div class="product-thumbnail mt-15">
                            <?php echo "<div class=\"thumb-menu owl-carousel nav tabs-area\" role=\"tablist\">
                                <a class=\"active\" data-toggle=\"tab\" href=\"#thumb1\"><img src=\"$product->image_path\" alt=\"product-thumbnail\"></a>
                                <a data-toggle=\"tab\" href=\"#thumb2\"><img src=\"$product->image_path\" alt=\"product-thumbnail\"></a>
                                <a data-toggle=\"tab\" href=\"#thumb3\"><img src=\"$product->image_path\" alt=\"product-thumbnail\"></a>
                                <a data-toggle=\"tab\" href=\"#thumb4\"><img src=\"$product->image_path\" alt=\"product-thumbnail\"></a>
                                <a data-toggle=\"tab\" href=\"#thumb5\"><img src=\"$product->image_path\" alt=\"product-thumbnail\"></a>
                            </div>"?>
                        </div>
                        <!-- Thumbnail image end -->
                    </div>
                    <!-- Main Thumbnail Image End -->
                    <!-- Thumbnail Description Start -->
                    <div class="col-lg-7">
                        <div class="thubnail-desc fix">
                            <h3 class="text-light" class="product-header"><?php echo $product->firmname.' '.$product->productname?></h3>
                            <div class="rating-summary fix mtb-10">
                                <div class="rating">
                                    <i onclick="setRating(this)" class="fa fa-star"></i>
                                    <i onclick="setRating(this)" class="fa fa-star"></i>
                                    <i onclick="setRating(this)" class="fa fa-star"></i>
                                    <i onclick="setRating(this)" class="fa fa-star"></i>
                                    <i onclick="setRating(this)" class="fa fa-star-o"></i>
                                </div>
                                <div class="rating-feedback">
                                    <a class="text-light" href="#">(1 review)</a>
                                    <a class="text-light" href="#">add to your review</a>
                                </div>
                            </div>
                            <div class="pro-price mtb-30">
                                <p class="d-flex align-items-center"><span class="price text-light">$<?php echo $product->price?></span></p>
                            </div>
                            <p class="mb-20 pro-desc-details text-light"><?php echo $product->shortdescription ?></p>


                            <div class="box-quantity d-flex hot-product2">
                                <form action="#">
                                    <input class="quantity mr-15" type="number" min="1" value="1">
                                </form>
                                <div class="pro-actions">
                                    <div class="actions-primary ">
                                        <a href="cart.html" title="" data-original-title="Add to Cart"> + Add To Cart</a>
                                    </div>
                                    <div class="actions-secondary">
                                        <a href="compare.html" title="" data-original-title="Compare"><i class="lnr lnr-sync"></i> <span>Add To Compare</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="mt-20">
                                <p><span class="in-stock text-light"><i class="ion-checkmark-round"></i> IN STOCK</span></p>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Thumbnail Description End -->
            </div>
            <!-- Row End -->
        </div>
    </div>
    <!-- Container End -->
</div>
<!-- Product Thumbnail End -->
<!-- Product Thumbnail Description Start -->
<div class="thumnail-desc pb-100 pb-sm-60 my-background">
    <div class="container">
        <div class="row">
            <div class="thumb-bg col-sm-12 bg-dark">
                <ul class="main-thumb-desc nav tabs-area" role="tablist">
                    <li><a class="active text-light" data-toggle="tab" href="#dtail">Product Details</a></li>
                    <li><a class="text-light" data-toggle="tab" href="#review">Reviews</a></li>
                </ul>
                <!-- Product Thumbnail Tab Content Start -->
                <div class="tab-content thumb-content border-dark bg-dark">
                    <div id="dtail" class="tab-pane fade show active">
                        <p class="text-light"><?php echo $product->description?></p>
                    </div>


                    <div id="review" class="tab-pane fade">
                        <!-- Reviews Start -->
                        <div class="review border-default universal-padding">
                            <div class="group-title">
                                <h2 class="text-light">Goldshady</h2>
                            </div>
                            <p class="text-light">The Google Pixel 4 arrives alongside its larger sibling, the Google Pixel 4 XL, and offers up a cocktail of flagship photography features, including machine learning and other AI wizardry

                                It's the successor to the Google Pixel 3, but the upgrades are minimal. Google hasn't tried to break the mold with the Pixel 4, instead playing things safe with an incremental update.

It feels like Google is resting on its laurels a little, hoping the strong photography showing from the Pixel 3 continues to intrigue users and push them to check out the new Pixel 4 – and while there are some clear gains here photography-wise, those looking for worthwhile upgrades across the board will be less impressed.

The good news is that the Pixel 4's starting price is lower than that of the Pixel 3, which could help to compensate for any perceived lack of innovation when it goes on sale.</p>
                            <br>
                            <ul class="review-list">
                                <!-- Single Review List Start -->
                                <li>
                                    <span class="text-light">Quality</span>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <label class="text-light">Good</label>
                                </li>
                                <!-- Single Review List End -->
                                <!-- Single Review List Start -->
                                <li>
                                    <span class="text-light">Price</span>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <label class="text-light">Review by Goldshady</label>
                                </li>
                                <!-- Single Review List End -->
                                <!-- Single Review List Start -->
                                <li>
                                    <span class="text-light">Value</span>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <label class="text-light">Posted on 10/10/19</label>
                                </li>
                                <!-- Single Review List End -->
                            </ul>
                        </div>
                        <!-- Reviews End -->
                        <!-- Reviews Start -->
                        <div class="review border-default universal-padding mt-30">
                            <h2 class="review-title mb-30 text-light">You're reviewing: <br><span class="text-light">Google Pixel 4</span></h2>
                            <p class="review-mini-title text-light">your rating</p>
                            <ul class="review-list">
                                <!-- Single Review List Start -->
                                <li>
                                    <span class="text-light">Quality</span>
                                    <i id="star0-1" onclick="setRating(this, 1)" class="fa fa-star"></i>
                                    <i id="star0-2" onclick="setRating(this, 2)" class="fa fa-star"></i>
                                    <i id="star0-3" onclick="setRating(this, 3)" class="fa fa-star"></i>
                                    <i id="star0-4" onclick="setRating(this, 4)" class="fa fa-star-o"></i>
                                    <i id="star0-5" onclick="setRating(this, 5)" class="fa fa-star-o"></i>
                                </li>
                                <!-- Single Review List End -->
                                <!-- Single Review List Start -->
                                <li>
                                    <span class="text-light">price</span>
                                    <i id="star1-1" onclick="setRating(this, 1)" class="fa fa-star"></i>
                                    <i id="star1-2" onclick="setRating(this, 2)" class="fa fa-star"></i>
                                    <i id="star1-3" onclick="setRating(this, 3)" class="fa fa-star-o"></i>
                                    <i id="star1-4" onclick="setRating(this, 4)" class="fa fa-star-o"></i>
                                    <i id="star1-5" onclick="setRating(this, 5)" class="fa fa-star-o"></i>
                                </li>
                                <!-- Single Review List End -->
                                <!-- Single Review List Start -->
                                <li>
                                    <span class="text-light">value</span>
                                    <i id="star2-1" onclick="setRating(this, 1)" class="fa fa-star"></i>
                                    <i id="star2-2" onclick="setRating(this, 2)" class="fa fa-star"></i>
                                    <i id="star2-3" onclick="setRating(this, 3)" class="fa fa-star"></i>
                                    <i id="star2-4" onclick="setRating(this, 4)" class="fa fa-star"></i>
                                    <i id="star2-5" onclick="setRating(this, 5)" class="fa fa-star-o"></i>
                                </li>
                                <!-- Single Review List End -->
                            </ul>
                            <!-- Reviews Field Start -->
                            <div class="riview-field mt-40">
                                <form autocomplete="on" action="phpScripts/AddReview.php" method="POST">
                                    <div class="form-group">
                                        <label class="req text-light" for="sure-name">Nickname</label>
                                        <input name="nickname" type="text" class="form-control" id="sure-name" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label class="req text-light" for="comments">Review</label>
                                        <textarea name="text" class="form-control" rows="5" id="comments" required="required"></textarea>
                                    </div>
                                    <button type="submit" class="customer-btn">Submit Review</button>
                                </form>
                            </div>
                            <!-- Reviews Field Start -->
                        </div>
                        <!-- Reviews End -->
                    </div>


                </div>
                <!-- Product Thumbnail Tab Content End -->
            </div>
        </div>
        <!-- Row End -->
    </div>
    <!-- Container End -->
</div>
<!-- Product Thumbnail Description End -->

<!-- Footer Area Start Here -->
<footer class="off-white-bg2 pt-95 bdr-top pt-sm-55">
    <!-- Footer Top Start -->
    <div class="footer-top">
        <div class="container">
            <!-- Signup Newsletter Start -->
            <div class="row mb-60">
                <div class="col-xl-7 col-lg-7 ml-auto mr-auto col-md-8">
                    <div class="news-desc text-center mb-30">
                        <h3>Subscribe!</h3>
                        <p>Be nice guys and subscribe to get unuseful distribution</p>
                    </div>
                    <div class="newsletter-box">
                        <form action="#">
                            <input class="subscribe" placeholder="your email address" name="email" id="subscribe" type="text">
                            <button type="submit" class="submit">Subscribe!</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Signup-Newsletter End -->
            <div class="row">
                <!-- Single Footer Start -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="single-footer mb-sm-40">
                        <h3 class="footer-title">Information</h3>
                        <div class="footer-content">
                            <ul class="footer-list">
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Delivery info</a></li>
                                <li><a href="#">Private Policy</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Return Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-footer mb-sm-40">
                        <h3 class="footer-title">Contacts</h3>
                        <div class="footer-content">
                            <ul class="footer-list address-content">
                                <li><i class="lnr lnr-map-marker"></i> Address: Fog Street 99.</li>
                                <li><i class="lnr lnr-envelope"></i><a href="https://mail.google.com">Mail: bidshop@gmail.com</a></li>
                                <li>
                                    <i class="lnr lnr-phone-handset"></i> Telephone: (+380) 96 666 6666)
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <!-- Single Footer Start -->
            </div>
            <!-- Row End -->
        </div>
        <!-- Container End -->
    </div>
    <!-- Footer Top End -->

    <!-- Footer Bottom Start -->
    <div class="footer-bottom pb-30">
        <div class="container">

            <div class="copyright-text text-center">
                <p>Copyright © 2019 <a target="_blank" href="#">Badayindustries</a> All Rights Reserved.</p>
            </div>
        </div>
        <!-- Container End -->
    </div>
    <!-- Footer Bottom End -->
</footer>
<!-- Footer Area End Here -->

</div>
<!-- Main Wrapper End Here -->

<!-- jquery 3.2.1 -->
<script src="js/vendor/jquery-3.2.1.min.js"></script>
<!-- Countdown js -->
<script src="js/jquery.countdown.min.js"></script>
<!-- Mobile menu js -->
<script src="js/jquery.meanmenu.min.js"></script>
<!-- ScrollUp js -->
<script src="js/jquery.scrollUp.js"></script>
<!-- Nivo slider js -->
<script src="js/jquery.nivo.slider.js"></script>
<!-- Fancybox js -->
<script src="js/jquery.fancybox.min.js"></script>
<!-- Jquery nice select js -->
<script src="js/jquery.nice-select.min.js"></script>
<!-- Jquery ui price slider js -->
<script src="js/jquery-ui.min.js"></script>
<!-- Owl carousel -->
<script src="js/owl.carousel.min.js"></script>
<!-- Bootstrap popper js -->
<script src="js/popper.min.js"></script>
<!-- Bootstrap js -->
<script src="js/bootstrap.min.js"></script>
<!-- Plugin js -->
<script src="js/plugins.js"></script>
<!-- Main activaion js -->
<script src="js/main.js"></script>

<script>
    function setRating(elem, stars) {
        switch (stars) {
            case 1:
                elem.classList.remove('fa fa-star-o');
                elem.classList.add('fa fa-star');
                document.getElementById('star0-2').classList.remove('fa fa-star');
                document.getElementById('star0-2').classList.add('fa fa-star-o');
                document.getElementById('star0-3').classList.remove('fa fa-star');
                document.getElementById('star0-3').classList.add('fa fa-star-o');
                document.getElementById('star0-4').classList.remove('fa fa-star');
                document.getElementById('star0-4').classList.add('fa fa-star-o');
                document.getElementById('star0-5').classList.remove('fa fa-star');
                document.getElementById('star0-5').classList.add('fa fa-star-o');
                break;
            case 2:
                elem.classList.remove('fa fa-star-o');
                elem.classList.add('fa fa-star');
                break;
            case 3:
                day = "Tuesday";
                break;
            case 4:
                day = "Wednesday";
                break;
            case 5:
                day = "Thursday";
                break;

        }


    }
</script>
</body>

</html>