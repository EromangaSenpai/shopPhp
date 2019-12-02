<?php
session_start();
require_once 'phpScripts/db.php';
require_once 'phpScripts/UserInfo.php';
require_once 'phpScripts/ServerInfo.php';


if (!R::testConnection())
    exit ('Нет соединения с базой данных');

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search']) && !empty($_GET['search']))
{
    $search = $_GET['search'];
    $goods = R::findAll('goods', "WHERE productname LIKE '%$search%' OR firmname LIKE '%$search%'");
}
else
    header('Location: MainPage.php');


if(isset($goods) || !empty($goods))
{
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

    $modal = $userInfo->ModalWindowType();
    $cartModal = $userInfo->ModalWindowCartType();
    $myCart = null;


    $text = "Catalog";
    if($serverInfo->IsMobile())
    {
        $text = "";
    }

    if(isset($_SESSION['savingCart'])) {
        $myCart = $_SESSION['savingCart'];
    }
}
else
    header("Location: MainPage.php");

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/myStyles.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <!-- Custom css -->
    <link rel="stylesheet" href="css/default.css">
    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Fontawesome css -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Ionicons css -->
    <link rel="stylesheet" href="css/ionicons.min.css">
    <!-- linearicons css -->
    <link rel="stylesheet" href="css/linearicons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="js/jsslider.min.js" type="text/javascript"></script>
    <script src="js/jsslider.js" type="text/javascript"></script>
    <script src="js/Buy.js"></script>

    <style>
        hr {
            border:1px solid rgb(211, 211, 211);
            border-bottom-width: 0;
        }

        .jssorl-009-spin img {
            animation-name: jssorl-009-spin;
            animation-duration: 1.6s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes jssorl-009-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }


        .jssorb051 .i {position:absolute;cursor:pointer;}
        .jssorb051 .i .b {fill:#fff;fill-opacity:0.5;}
        .jssorb051 .i:hover .b {fill-opacity:.7;}
        .jssorb051 .iav .b {fill-opacity: 1;}
        .jssorb051 .i.idn {opacity:.3;}


        .jssora051 {display:block;position:absolute;cursor:pointer;}
        .jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
        .jssora051:hover {opacity:.8;}
        .jssora051.jssora051dn {opacity:.5;}
        .jssora051.jssora051ds {opacity:.3;pointer-events:none;}
    </style>


    <title>Main Page</title>
<body class="background">

<div class="jumbotron text-center bg-secondary" style="margin-bottom:0">
    <h1>Welcome to our shop</h1>
    <p>We are happy to see you there</p>
</div>


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
                <th>Price</th>
            </tr>
            </thead>
            <tbody id=\"myCartTable\">
                $myCart
            </tbody>
        </table>
      </div>
      <div class=\"modal-footer\">
      <form method='post' action='phpScripts/clearCart.php'>
        <button onclick=\"clear()\" type=\"submit\" class=\"btn btn-danger\">Clear</button>
        </form>
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
    <!-- Categories -->
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
            <h4 class="text-white">Products</h4>
            <hr><br>
            <ul>
                <h3 class="text-light"><a href="MainPage.php">Main Page</a></h3>
                <li><a href="Smartphones.php">Smartphones</a></li>
                <li><a href="Laptops.php">Laptops</a></li>
                <li><a href="Tvs.php">TVs</a></li>
            </ul>
            <br><hr><br>
            <!-- Categories -->
            <!-- Searcher -->
            <!--form class="form-inline my-2 my-lg-0">
                <input name="search" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form-->
            <form method="GET" action="">
                <div class="row form-group">
                    <div class="col-sm-10">
                        <input name="search" class="form-control mr-sm-2" type="search" placeholder="I am looking for..." aria-label="Search">
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Searching</button>
                    </div>
                </div>
            </form>

            <!-- Searcher -->
            <hr><br>

            <!-- First checkbox row -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="row mb-5">
                    <div class="col-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="filterCheckBox[]" value="Apple" id="checkbox1">
                            <label class="custom-control-label text-light" for="checkbox1">
                                Apple
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="filterCheckBox[]" value="Google" id="checkbox2">
                            <label class="custom-control-label text-light" for="checkbox2">
                                Google
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="filterCheckBox[]" value="Xiaomi" id="checkbox3">
                            <label class="custom-control-label text-light" for="checkbox3">
                                Xiaomi
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="filterCheckBox[]" value="Meizu" id="checkbox4">
                            <label class="custom-control-label text-light" for="checkbox4">
                                Meizu
                            </label>
                        </div>
                    </div>
                </div>
                <!-- First checkbox row -->

                <!-- Second checkbox row -->
                <div class="row mb-5">
                    <div class="col-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="filterCheckBox[]" value="HP" id="checkbox5">
                            <label class="custom-control-label text-light" for="checkbox5">
                                HP
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="filterCheckBox[]" value="Lenovo" id="checkbox6">
                            <label class="custom-control-label text-light" for="checkbox6">
                                Lenovo
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="filterCheckBox[]" value="Huawei" id="checkbox7">
                            <label class="custom-control-label text-light" for="checkbox7">
                                Huawei
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="filterCheckBox[]" value="Samsung" id="checkbox8">
                            <label class="custom-control-label text-light" for="checkbox8">
                                Samsung
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Second checkbox row -->


                <!-- Third checkbox row -->
                <div class="row mb-5">
                    <div class="col-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="filterCheckBox[]" value="Asus" id="checkbox9">
                            <label class="custom-control-label text-light" for="checkbox9">
                                Asus
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="filterCheckBox[]" value="Acer" id="checkbox10">
                            <label class="custom-control-label text-light" for="checkbox10">
                                Acer
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="filterCheckBox[]" value="MSI" id="checkbox11">
                            <label class="custom-control-label text-light" for="checkbox11">
                                MSI
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="filterCheckBox[]" value="Razer" id="checkbox12">
                            <label class="custom-control-label text-light" for="checkbox12">
                                Razer
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Third checkbox row -->

                <div class="row">
                    <div class="col-sm">
                        <button type="submit" class="btn btn-outline-success">Sorted</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- End Navbar-->

<br>


<!-- Start Slider -->
<div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:380px;overflow:hidden;visibility:hidden;">
    <!-- Loading Screen -->
    <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
        <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="js/img/spin.svg" />
    </div>
    <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:380px;overflow:hidden;">
        <div>
            <img data-u="image" src="img/adverisment/back_to_school_desk.png" />
        </div>
        <div>
            <img data-u="image" src="img/adverisment/desktop_in_stock.png" />
        </div>
        <div>
            <img data-u="image" src="img/adverisment/mac_desk.png" />
        </div>
        <div>
            <img data-u="image" src="img/adverisment/1300x500_shop-partner_2_.jpg" />
        </div>

    </div>
    <!-- Bullet Navigator -->
    <div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
        <div data-u="prototype" class="i" style="width:16px;height:16px;">
            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <circle class="b" cx="8000" cy="8000" r="5800"></circle>
            </svg>
        </div>
    </div>
    <!-- Arrow Navigator -->
    <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
        <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
            <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
        </svg>
    </div>
    <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
        <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
            <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
        </svg>
    </div>
</div>
<!-- End Slider -->


<br><br>

<div class="container" id="maindiv">
    <center><h1 class="bg-secondary">Our products</h1></center>
    <br>
    <div class="row" id="catalog">
        <?php foreach($goods as $item):
            echo " <div class=\"col-md-3 mb-4 div-column-style\">
                    <a href='product_php.php?id=$item->id'>
                        <img src=\"$item->image_path\" class=\"img-thumbnail zoom\" style=\"background-color: $item->color; width: 304px; height:236px\" alt=\"Image\" width=\"304px\" height=\"236px\">
                        <div class=\"caption\">
                            <div class=\"vis-hidden\" style=\"visibility: hidden\">$item->id</div>
                           
                            <p class=\"mb-2 text-light\">$item->firmname $item->productname</p>
                            <hr>
                            <p class=\"mb-2 text-light\">Price: $item->price</p>
                            <hr>
                            <br>
                             </a>
                            <button type=\"button\" class=\"btn btn-outline-primary btn-block\" onclick=\"AddToCart(this, productId = $item->id, 1)\">Add to cart</button>
                        </div>
                   
                </div>";
        endforeach; ?>
    </div>

</div>




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
<script type="text/javascript">jssor_1_slider_init();</script>
</body>





