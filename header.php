<?php
$db = new Database();
$db->select('options', 'site_name,site_logo,currency_format');
$header = $db->getResult();

$cur_format = '$';
if (!empty($header[0]['currency_format'])) {
    $cur_format = $header[0]['currency_format'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <?php if (isset($title)) { ?>
        <title><?php echo $title; ?></title>
    <?php } else { ?>
        <title>Shop</title>
    <?php } ?>
    <!-- Bootstrap -->
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900|Montserrat:400,500,700,900" rel="stylesheet">
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" href="css/owl.theme.default.min.css" />
<!--  -->
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/demo.css" />
    <link rel="stylesheet" href="css/component.css" />

</head>

<body>

    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-4 ">
                    <?php
                    if (!empty($header[0]['site_logo'])) { ?>
                        <a href="<?php echo $hostname; ?>" class="logo-img"><img src="images/<?php echo $header[0]['site_logo']; ?>" alt="" class="img-fluid"></a>
                    <?php } else { ?>
                        <a href="<?php echo $hostname; ?>" class="logo"><?php echo $header[0]['site_name']; ?></a>
                    <?php } ?>
                </div>
                <!-- /LOGO -->
                <div class="col-md-4">
                    <form action="search.php" method="GET">
                        <div class="input-group search">
                            <input type="text" class="form-control" name="search" placeholder="Search for...">
                            <span class="input-group-btn">
                            <div class="td" id="s-cover" type="submit" value="Search">
                            <button type="submit">
                              <div id="s-circle"></div>
                              <span></span>
                            </button>
                          </div>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <ul class="header-info">
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                <?php
                                if (session_status() == PHP_SESSION_NONE) {
                                    session_start();
                                }
                                if (isset($_SESSION["user_role"])) { ?>
                                    Hello <?php echo $_SESSION["username"]; ?><i class="caret"></i>
                                <?php  } else { ?>
                                    <i class="fa fa-user"></i>
                                <?php  } ?>

                            </a>
                            <ul class="dropdown-menu">
                                <!-- Trigger the modal with a button -->
                                <?php
                                if (isset($_SESSION["user_role"])) { ?>
                                    <li><a href="user_profile.php" class="">
                                            <p>My Profile</p>
                                        </a></li>
                                    <li><a href="user_orders.php" class="">
                                            <p>My Orders</p>
                                        </a></li>
                                    <li><a href="javascript:void()" class="user_logout">Logout</a></li>
                                <?php  } else { ?>
                                    <li><a data-toggle="modal" data-target="#userLogin_form" href="#">login</a></li>
                                    <li><a href="register.php">Register</a></li>
                                <?php  } ?>

                            </ul>
                        </li>
                        <li>
                            <a href="wishlist.php"><i class="fa fa-heart"></i>
                                <?php if (isset($_COOKIE['wishlist_count'])) {
                                    echo '<span>' . $_COOKIE["wishlist_count"] . '</span>';
                                } ?>
                            </a>
                        </li>
                        <li>
                            <a href="cart.php"><i class="fa fa-shopping-cart"></i>
                                <?php if (isset($_COOKIE['cart_count'])) {
                                    echo '<span>' . $_COOKIE["cart_count"] . '</span>';
                                } ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="userLogin_form" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="modal-body">
                                <!-- Form --->
                                <form id="loginUser" method="POST">
                                    <div class="customer_login">
                                        <h2>login here</h2>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="email" class="form-control username" placeholder="Username" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control password" placeholder="password" autocomplete="off" required>
                                        </div>
                                        <input type="submit" name="login" class="btn" value="login" />
                                        <span>Don't Have an Account <a href="register.php">Register</a></span>
                                    </div>
                                </form>
                                <!-- /Form --->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Modal -->
            </div>
        </div>
    </div>
   
    <!-- <div id="header-menu">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="menu-list">
                        <?php
                        $db = new Database();
                        $db->select('sub_categories', '*', null, 'cat_products > 0 AND show_in_header = "1"', null, null);
                        $result = $db->getResult();
                        if (count($result) > 0) {
                            foreach ($result as $res) { ?>
                                <li><a href="category.php?cat=<?php echo $res['sub_cat_id']; ?>"><?php echo $res['sub_cat_title']; ?></a></li>
                        <?php    }
                        } ?>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div> -->
</body>


<!-- bootstrap js -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>