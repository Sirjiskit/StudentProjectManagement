<?php
include('includes/autoload.php');
Session::init();
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>News Portal | Contact us</title>

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

            <?php
            $pagetype = 'contactus';
            $query = mysqli_query($con, "select PageTitle,Description from tblpages where PageName='$pagetype'");
            while ($row = mysqli_fetch_array($query)) {
                ?>
                <h1 class="mt-4 mb-3"><?php echo htmlentities($row['PageTitle']) ?>

                </h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Contact</li>
                </ol>

                <!-- Intro Content -->
                <div class="row">

                    <div class="col-lg-12">

                        <p><?php echo $row['Description']; ?></p>
                    </div>
                </div>
                <!-- /.row -->
            <?php } ?>

        </div>
        <!-- /.container -->

        <!-- Footer -->
        <?php include('includes/footer.php'); ?>

    </body>

</html>
