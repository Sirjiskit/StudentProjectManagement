<!DOCTYPE html>
<html lang="en">
<head>
    <title>Projects Management :: Admin Dashboard</title>
    <?php include('head.php'); ?>
    <style>
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
                                <a href="../admin"><i class="icon-home icon-large"></i></a>
                            </li>
                        </ul>
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="../admin"><i class="icon-home"></i>Home</a>
                            </li>
                            <li><a href="addSupervisor">Add Supervisor</a></li>
                            <li><a href="addStudent">Add Student</a></li>
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
                            <button class="btn"><i class="icon-user icon-large"></i><br/>Students</button>
                            <button class="btn"><i class="icon-user-md icon-large"></i><br/>Staff</button>
                            <button class="btn"><i class="icon-list-alt icon-large"></i><br/>Reports</button>
                            <button class="btn"><i class="icon-bar-chart icon-large"></i><br/>Tobics</button>
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
                        <h5>Students</h5>
                        <button class="btn btn-box-right" data-toggle="collapse" data-target=".box-list">
                            <i class="icon-reorder"></i>
                        </button>
                    </div>
                    <div class="box-content box-list collapse in">
                        <ul>
                        <?php 
						$sql = $data->query($data->filter_StudentAll(0));
						while($row=$data->fetch_array($sql)){
						?>
                            <li>
                                <div>
                                    <a href="#" class="news-item-title"><?php echo $row['studentid'] ?></a>
                                    <p class="news-item-preview">Approved Project Topic</p>
                                    <p class="news-item-preview"><?php echo $data->getApprovedTopic($row['id']);?></p>
                                </div>
                            </li>
                            <?php }?>
                        </ul>
                        <div class="box-collapse">
                            <a class="btn btn-box" href="students">
                                Show More
                            </a>
                        </div>
                       
                    </div>

                </div>
            </div>
            <!-- Student list -->
            <div class="span8">
                <div class="box pattern pattern-sandstone">
                    <div class="box-header">
                        <i class="icon-list"></i>
                        <h5>Supervisors</h5>
                        <button class="btn btn-box-right" data-toggle="collapse" data-target=".box-list">
                            <i class="icon-reorder"></i>
                        </button>
                    </div>
                    <div class="box-content box-list collapse in">
                        <ul>
                        <?php $sql = $data->query("select `id`, `staffid`, CONCAT(`firstname`,' ',`othernames`) fullname, `school`, 
						`department`, `status` FROM `tb_supervisor` LIMIT 0,5"); 
						while($row=$data->fetch_array($sql)){
						?>
                            <li>
                                <div>
                                    <a href="#" class="news-item-title"><?php echo $row['fullname'] ?></a>
                                    <p class="news-item-preview">Number of students supervissing</p>
                                    <p class="news-item-preview"><?php echo $data->getSupAssignedStudents($row['id']);?></p>
                                </div>
                            </li>
                            <?php }?>
                        </ul>
                        <div class="box-collapse">
                            <a class="btn btn-box" href="Supervisors">
                                Show More
                            </a>
                        </div>
                    </div>
            <!-- end of student list -->
                 <!--End of Content -->
               
		</div>
		</div>
    </div>
  </section>  
  </div>
  </div>
  
        <!-- Include footer here-->
        <?php include('footer.php'); ?>
        <script>
		$(document).ready(function(){
			$('#dashboard').parent('li').addClass("active");
		});
		</script>
	</body>
</html>