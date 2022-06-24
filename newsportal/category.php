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

        <title>News Portal | Category  Page</title>

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



            <div class="row" style="margin-top: 4%">

                <!-- Blog Entries Column -->
                <div class="col-md-8">

                    <!-- Blog Post -->
                    <?php
                    if ($_GET['catid'] != '') {
                        $_SESSION['catid'] = intval($_GET['catid']);
                    }
                    if (isset($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                    } else {
                        $pageno = 1;
                    }
                    $no_of_records_per_page = 8;
                    $offset = ($pageno - 1) * $no_of_records_per_page;

                    $total_pages_sql = "SELECT COUNT(*) FROM tblposts";
                    $result = mysqli_query($con, $total_pages_sql);
                    $total_rows = mysqli_fetch_array($result)[0];
                    $total_pages = ceil($total_rows / $no_of_records_per_page);

                    $query = mysqli_query($con, "select tblposts.id as pid,tblposts.PostTitle as posttitle,tblposts.PostImage,"
                                . "tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as "
                                . "subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,"
                                . "tblposts.PostUrl as url,(SELECT COUNT(*) FROM tblcomments c WHERE c.postId = tblposts.id AND c.status = 1) comments,"
                                . "(SELECT COUNT(*) FROM tblread r WHERE r.postid = tblposts.id) views from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId "
                                . "left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where"
                            . " tblposts.CategoryId='" . $_SESSION['catid'] . "' and tblposts.Is_Active=1 order by tblposts.id desc LIMIT $offset, $no_of_records_per_page");

                    $rowcount = mysqli_num_rows($query);
                    if ($rowcount == 0) {
                        echo "No record found";
                    } else {
                        while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <h1><?php echo htmlentities($row['category']); ?> News</h1>
                            <div class="card mb-4">
                                <img class="card-img-top" src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>">
                                <div class="card-body">
                                    <h4 class="card-title text-dark"><?php echo htmlentities($row['posttitle']); ?></h4>
                                    <p><b>Category : </b> <a href="category.php?catid=<?php echo htmlentities($row['cid']) ?>"><?php echo htmlentities($row['category']); ?></a> </p>

                                    <a href="news-details.php?nid=<?php echo htmlentities($row['pid']) ?>" class="btn btn-primary">Read More &rarr;</a>
                                </div>
                                <div class="card-footer text-muted">
                                    Posted on <?php echo date("dS F, Y", strtotime(htmlentities($row['postingdate']))); ?>&nbsp;&nbsp;
                                    <span><span class="fa fa-comment"></span> <?php echo htmlentities($row["comments"]); ?></span>&nbsp;&nbsp;
                                    <span><span class="fa fa-eye"></span> <?php echo htmlentities($row["views"]); ?></span>
                                </div>
                            </div>
                        <?php } ?>

                        <ul class="pagination justify-content-center mb-4">
                            <li class="page-item"><a href="?pageno=1"  class="page-link">First</a></li>
                            <li class="<?php
                            if ($pageno <= 1) {
                                echo 'disabled';
                            }
                            ?> page-item">
                                <a href="<?php
                                if ($pageno <= 1) {
                                    echo '#';
                                } else {
                                    echo "?pageno=" . ($pageno - 1);
                                }
                                ?>" class="page-link">Prev</a>
                            </li>
                            <li class="<?php
                            if ($pageno >= $total_pages) {
                                echo 'disabled';
                            }
                            ?> page-item">
                                <a href="<?php
                                if ($pageno >= $total_pages) {
                                    echo '#';
                                } else {
                                    echo "?pageno=" . ($pageno + 1);
                                }
                                ?> " class="page-link">Next</a>
                            </li>
                            <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
                        </ul>
                    <?php } ?>




                    <!-- Pagination -->




                </div>

                <!-- Sidebar Widgets Column -->
                <?php include('includes/sidebar.php'); ?>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

        <!-- Footer -->
        <?php include('includes/footer.php'); ?>


    </head>
</body>

</html>
