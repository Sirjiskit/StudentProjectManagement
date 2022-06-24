<?php
include('includes/autoload.php');
Session::init();
$model = new Model();
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>News Portal | Profile</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/modern-business.css" rel="stylesheet">
        <link href="fonts/fontawesome-free-5.15.3-web/css/all.css" rel="stylesheet">
    </head>

    <body>

        <!-- Navigation -->
        <?php include('includes/header.php'); ?>
        <!-- Page Content -->
        <div class="container" style="min-height: calc(100vh - 280px) !important">


            <h2 class="mt-4 mb-3">My Account Details</h2>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">Home</a>
                </li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>

            <!-- Intro Content -->
            <div class="row">
                <div class="col-lg-6 col-12 col-md-6 col-xl-6 col-sm-6 d-flex flex-row w-100">
                    <div class="p-2">
                        <img style="width: 150px; height: auto" src="<?php if (Session::get("image") != ""): ?><?php echo URL . "upload" ?>/<?php echo Session::get('image'); ?><?php else: ?><?php echo URL . "images" ?>/usericon.png<?php endif; ?>" class="thumb-img" alt="User Image">

                        <div class="form-group mt-2">
                            <button class="btn btn-primary fileUpload">
                                <label class="upload mt-1">
                                    <input name='Image' type="file"/>
                                    <span class="btn-text">Change profile pic</span>
                                </label>
                            </button>
                        </div>
                    </div>
                    <form class="w-50">
                        <div class="form-group">
                            <input type="text" value="<?php echo Session::get("fullname") ?>" class="form-control" readonly="">
                        </div>
                        <div class="form-group">
                            <input type="text" value="<?php echo Session::get("email") ?>" class="form-control" readonly="">
                        </div>
                        <div class="form-group">
                            <input type="text" value="<?php echo Session::get("phone") ?>" class="form-control" readonly="">
                        </div>
                        <div class="form-group">
                            <input type="text" value="Account type: <?php echo $model->getUserType(Session::get("email")) == 1 ? 'Student' : 'Staff' ?>" class="form-control" readonly="">
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-12 col-md-6 col-xl-6 col-sm-6">
                    <h3>Change password</h3>
                    <form action="app.php?q=change-password" id="form-change-password">
                        <div class="form-group">
                            <input type="password" name="old-password" required="" class="form-control rounded-left" placeholder="Old Password">
                        </div>
                        <div class="form-group">
                            <input type="password" name="new-password" required="" class="form-control rounded-left" placeholder="New Password">
                        </div>
                        <div class="form-group">
                            <input type="password" name="confirm-password" required="" class="form-control rounded-left" placeholder="Confirm Password">
                        </div>
                        <div class="form-group d-flex justify-content-center">
                            <button class="btn btn-primary btn-change">Change</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- /.container -->

        <!-- Footer -->
        <?php include('includes/footer.php'); ?>

    </body>

</html>
