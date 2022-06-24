<!DOCTYPE html>
<html lang="en">
<head>
    <title>Projects Management :: Admin Dashboard</title>
    <link rel="stylesheet" href="../alert/css/jquery-confirm.css">
    <?php include('head.php'); 
	?>
    
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
                        <h3><i class="icon-user"></i>STUDENT'S
                        </h3>
                    </header>
                </div>
                <div class="page-nav-options">
                    <div class="span9">
                        <ul class="nav nav-pills">
                            <li>
                                <a href="#"><i class="icon-home icon-large"></i></a>
                            </li>
                        </ul>
                        <ul class="nav nav-tabs">
                            <li>
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
            <div class="span16">
                <div class="box pattern pattern-sandstone">
                    <div class="box-header">
                        <i class="icon-list"></i>
                        <h5>Students</h5>
                        <button class="btn btn-box-right" data-toggle="collapse" data-target=".box-list2">
                            <i class="icon-reorder"></i>
                        </button>
                    </div>
                    <div class="box-content box-list collapse in box-list2">
                        <ul>
                       		<li> 
                            <select id="dpm" class="span3" name="dpm">
                                            <option value="" selected>All</option>
                                            <option value="1,1"> Computer Science</option>
                                            <option value="1,2"> Science Lab. Tech.</option>
                                            <option value="1,3">Statistics</option>
                                            <option value="2,1">Accounting</option>
                                            <option value="2,2">Office Tech. and management</option>
                                            <option value="3,1">Agricultural Technology</option>
                                        </select>
                            <input type="text" placeholder="Search student" class="span5" id="txtSearch"/>
                            <span id="dpm_name">&nbsp;All Students</span>
                            </li>
                            <span class="studentList">
                           		
                            </span>
                        </ul>
                       
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
		$(document).ready(function(){
			$('#li-student').parent('li').addClass("active");
			$.post('api/api.process?ListOfStudent',function(html){
				$('.studentList').html(html);
			});
			$('#dpm').change(function(){
				var dpm = $(this).val();
				if(dpm==''){
					$.post('api/api.process?ListOfStudent',function(html){
						$('.studentList').html(html);
						$('#dpm_name').html("&nbsp;All Students");
					});
					return false;
				}
				var list = dpm.split(',');
				var arr = new Array();
				arr[1] = new Array('Computer Science','Science Lab. Tech.','Statistics');
				arr[2] = new Array('Accounting','Office Tech. and management');
				arr[3] = new Array('Agricultural Technology');
				var d = parseInt(list[1])-1;
				var s = parseInt(list[0]);
				$('#dpm_name').html("&nbsp; "+arr[s][d]+" students");
				$.post('api/api.process?ListOfStudent',{dpm:dpm},function(html){
				$('.studentList').html(html);
			});
			});
			$('#txtSearch').keyup(function(){
				var txtsearch = $(this).val();
				var dpm = $('#dpm').val();
				if(dpm==''){
					$.post('api/api.process?ListOfStudent&txtsearch='+txtsearch,function(html){
						$('.studentList').html(html);
					});
					return false;
				}
				$.post('api/api.process?ListOfStudent&txtsearch='+txtsearch,{dpm:dpm},function(html){
				$('.studentList').html(html);
				});
			});
		});
		function paggingcontrol(pageNum,totalRows){
			var dpm = $('#dpm').val();
			//alert(dpm);
	 		$.post('api/api.process?ListOfStudent&start='+pageNum+'&totalRows='+totalRows,{dpm:dpm},function(html){
				//alert(html);
				$('.studentList').html(html);
			});
		}
		
		</script>
	</body>
</html>