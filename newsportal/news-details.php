<?php
include('includes/autoload.php');
Session::init();
//Genrating CSRF Token
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if (isset($_POST['submit'])) {
    //Verifying CSRF Token
    if (!empty(filter_input(INPUT_POST, "csrftoken", FILTER_SANITIZE_STRING))) {
        if (hash_equals($_SESSION['token'], filter_input(INPUT_POST, "csrftoken", FILTER_SANITIZE_STRING))) {
            $userid = Session::get("userid");
            $comment = (string) filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING);
            $postid = (int) filter_input(INPUT_GET, "nid", FILTER_SANITIZE_NUMBER_INT);
            $st1 = '0';
            $query = mysqli_query($con, "insert into tblcomments(postId,userid,comment,status) values({$postid},{$userid},'$comment','$st1')");
            if ($query):
                echo "<script>alert('comment successfully submit. Comment will be display after admin review ');</script>";
                unset($_SESSION['token']);
            else :
                echo "<script>alert('Something went wrong. Please try again.');</script>";

            endif;
        }
    }
} else {
    $model = new Model();
    $userid = Session::get('loggedIn') ? Session::get("userid") : 0;
    $postid = (int) filter_input(INPUT_GET, "nid", FILTER_SANITIZE_NUMBER_INT);
    $model->read_news($postid, $userid);
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>News Portal | Home Page</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/modern-business.css" rel="stylesheet">
        <link href="fonts/fontawesome-free-5.15.3-web/css/all.css" rel="stylesheet">
        <style>
            .news-details img{
/*                width: 98% !important;*/
            }
            .news-details{
                overflow: hidden;
            }
        </style>
    </head>

    <body>

        <!-- Navigation -->
        <?php include('includes/header.php'); ?>

        <!-- Page Content -->
       <div class="container" style="min-height: calc(100vh - 280px) !important">



            <div class="row" style="margin-top: 4%">

                <!-- Blog Entries Column -->
                <div class="col-md-8">

                    <!-- Blog Post -->
                    <?php
                    $pid = intval($_GET['nid']);
                    $query = mysqli_query($con, "select tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.id='$pid'");
                    while ($row = mysqli_fetch_array($query)) {
                        ?>

                        <div class="card mb-4">

                            <div class="card-body">
                                <h2 class="card-title"><?php echo htmlentities($row['posttitle']); ?></h2>
                                <p><b>Category : </b> <a href="category.php?catid=<?php echo htmlentities($row['cid']) ?>"><?php echo htmlentities($row['category']); ?></a> |
                                    <b>Sub Category : </b><?php echo htmlentities($row['subcategory']); ?> <b> Posted on </b><?php echo date("dS F, Y", strtotime(htmlentities($row['postingdate']))); ?></p>
                                <hr />

                                <img class="img-fluid rounded" src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>">

                                <div class="card-text news-details"><?php
                                    $pt = $row['postdetails'];
                                    echo (substr($pt, 0));
                                    ?></div>

                            </div>
                            <div class="card-footer text-muted">


                            </div>
                        </div>
                    <?php } ?>





                    <div class="card my-5">
                        <h5 class="card-header">Leave a Comment:</h5>
                        <div class="card-body">
                            <form name="Comment" method="post">
                                <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
                                <div class="form-group">
                                    <textarea class="form-control" name="comment" rows="3" placeholder="Comment" required></textarea>
                                </div>
                               <?php 
                               if(Session::get("userid")):
                                   ?>
                                 <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                <?php
                                else:
                                    ?>
                                 <a href="#exampleModalCenter" class="btn btn-pr id-login-modal" role="button">Submit</a>
                                 <?php
                               endif;
                               ?>
                            </form>
                        </div>
                    </div>
                    <?php
                    $sts = 1;
                    $query1 = mysqli_query($con, "select u.fullname,u.image,c.comment,c.postingDate from tblcomments c LEFT JOIN tblusers u ON u.userid = c.userid where c.postId='$pid' and c.status='$sts'");
                    while ($row = mysqli_fetch_array($query1)) {
                        ?>
                        <div class="media mb-4">
                            <img class="d-flex mr-3 rounded-circle" style="width: 50px; height: 50px" src="<?php echo empty(htmlentities($row['image'])) ? 'images/usericon.png' : URL."upload/".htmlentities($row['image']); ?> " alt="">
                            <div class="media-body">
                                <h5 class="mt-0"><?php echo empty(htmlentities($row['fullname'])) ? 'Anonynous' : htmlentities($row['fullname']); ?> <br />
                                    <span style="font-size:11px;"><b>at</b> <?php echo htmlentities($row['postingDate']); ?></span>
                                </h5>

                                <?php echo htmlentities($row['comment']); ?>            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- Sidebar Widgets Column -->
                <?php include('includes/sidebar.php'); ?>
            </div>
            <!-- /.row -->

        </div>


        <?php include('includes/footer.php'); ?>

    </body>

</html>
