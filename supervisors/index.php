<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Projects Management :: Students Dashboard</title>
        <?php include('head.php'); ?>
        <style>
            .myInfo li span:first-child{
                text-align:right;
            }
        </style>
    </head>
    <body>
        <!-- Include Top here-->
        <?php include('top.php'); ?>
        <div id="body-container">
            <div id="body-content">
                <!-- Include navigator here-->
                <?php include('nav.php'); ?>
                <!-- Content goes here -->
                <section class="nav nav-page">
                    <div class="container">
                        <div class="row">
                            <div class="span7">
                                <header class="page-header">
                                    <h3><i class="icon-dashboard"></i>Dashboard
                                    </h3>
                                </header>
                            </div>
                            <div class="page-nav-options">
                                <div class="span9">
                                    <ul class="nav nav-pills">
                                        <li>
                                            <a href="../supervisors"><i class="icon-home icon-large"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="page container">
                    <div class="row">
                        <div class="span8">
                            <div class="box">
                                <div class="box-header">
                                    <i class="icon-bookmark"></i>
                                    <h5>Shortcuts</h5>
                                </div>
                                <div class="box-content">
                                    <div class="btn-group-box">
                                        <button class="btn"><i class="icon-dashboard icon-large"></i><br/>Dashboard</button>
                                        <button class="btn"><i class="icon-magnet icon-large"></i><br/>Work</button>
                                        <button class="btn"><i class="icon-comment icon-large"></i><br/>Comments</button>
                                        <button class="btn"><i class="icon-list-alt icon-large"></i><br/>Reports</button>
                                        <button class="btn"><i class="icon-user icon-large"></i><br/>Students</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span8">
                            <div class="blockoff-left">
                                <legend class="lead">
                                    Welcome
                                </legend>
                                <p>
                                    Project management .<br><br><br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="span8">
                            <div class="box pattern pattern-sandstone">
                                <div class="box-header">
                                    <i class="icon-list"></i>
                                    <h5>Notifications</h5>
                                    <button class="btn btn-box-right" data-toggle="collapse" data-target=".box-list1">
                                        <i class="icon-reorder"></i>
                                    </button>
                                </div>
                                <div class="box-content box-list collapse in box-list1">
                                    <ul>
                                        <?php
                                        $sql = $data->query("SELECT * FROM `notifications` where type=1 and receiverid=$id and status=0 
						ORDER BY id DESC LIMIT 0,10");
                                        while ($row = $data->fetch_array($sql)) {
                                            ?>
                                            <li>
                                                <div>
                                                    <button class="close" onClick="closeNoties(<?php echo $row['id'] ?>, this)">&times;</button>
                                                    <a href="#" class="news-item-title"><?php echo $row['sender'] ?></a>
                                                    <p class="news-item-preview"><?php echo $row['data'] ?></p>
                                                    <p class="news-item-preview"><span class="label label-warning"><?php echo $row['date']; ?></span></p>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>

                                </div>

                            </div>
                        </div>
                        <!-- Student list -->
                        <div class="span8">
                            <div class="blockoff-left">
                                <legend class="lead">
                                    MY INFORMATIONS
                                </legend>
                                <div class="box pattern pattern-sandstone">
                                    <div class="box-content box-list collapse in">
                                        <ul class="myInfo">
                                            <?php
                                            $sql = $data->query($data->getSupervisor($id));
                                            $row = $data->fetch_assoc($sql);
                                            ?>
                                            <li><span>Staff ID:</span><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $row['staffid'] ?></span></li>
                                            <li><span>Full Name:</span><span>&nbsp;&nbsp;&nbsp;<?php echo $row['fullname'] ?></span></li>
                                            <li><span>School:</span><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $data->SchoolName($row['school']) ?></span></li>
                                            <li><span>Department:</span><span>&nbsp;<?php echo $data->DpmName($row['department'], $row['school']) ?>
                                                </span></li>
                                            <li><span>No of Students:</span><span>&nbsp;&nbsp;&nbsp;
<?php echo $data->getSupAssignedNo($id); ?></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>  
            </div>
        </div>

        <!-- Include footer here-->
<?php include('footer.php'); ?>
        <script>
            $(document).ready(function () {
                $('#dashboard').parent('li').addClass("active");
            });
            function closeNoties(id, e) {
                //alert("I LOVE YOU ESTHER");
                $.post('api/api.process?removeNotify=' + id, function (data) {
                    $(e).parent().parent().hide();
                });
            }
        </script>
    </body>
</html>