<!DOCTYPE html>
<html lang="en">
<head>
    <title>Projects Management :: Students Progress</title>
    <link rel="stylesheet" href="../alert/css/jquery-confirm.css">
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
                        <h3><i class="icon-tasks"></i>WORK PROGRESS
                        </h3>
                    </header>
                </div>
                <div class="page-nav-options">
                    <div class="span9">
                        <ul class="nav nav-pills">
                            <li>
                                <a href="../students"><i class="icon-home icon-large"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="page container">
        <div class="row">
            <div class="span12">
                <div class="box pattern pattern-sandstone">
                    <div class="box-header">
                        <i class="icon-tasks"></i>
                        <h5>WORK PROGRESS</h5>
                        <button class="btn btn-box-right" data-toggle="collapse" data-target=".box-list1">
                            <i class="icon-reorder"></i>
                        </button>
                    </div>
                    <div class="box-content box-list collapse in box-list1">
                        <ul>
                       <span id="TopicList"></span>
                        </ul>
                       
                    </div>

                </div>
            </div>
            <!-- Student list -->
            <div class="span4">
                <div class="blockoff-left">
                    <legend class="lead">
                       UPLOAD PROJECT WORK
                    </legend>
                    <div class="box pattern pattern-sandstone">
                        <div class="box-content box-list collapse in">
                        <form class="form-horizontal" method="post" id="frmUploadWork" enctype="multipart/form-data" action="">
                        <input type="hidden" value="<?php echo $id ?>" name="id" id="id_stud">
                        <ul>
                        <li><span>Upload Project Work</span></li>
                        <li><select required name="work" id="work">
                        <option selected value="" disabled>Choose Work...</option>
                        <option value="Proposal">Proposal</option>
                        <option value="Chapter One">Chapter One</option>
                        <option value="Chapter Two">Chapter Two</option>
                        <option value="Chapter Three">Chapter Three</option>
                        <option value="Chapter Four">Chapter Four</option>
                        <option value="Chapter Five">Chapter Five</option>
                        <option value="Chapter Six">Chapter Six</option>
                        <option value="Final Work">Final Work</option>
                        </select></li>
                        <li><input  type="file" name="image" id="image"/></li>
                        <li><button type="submit" class="btn btn-primary">Upload</button></li>
                        </ul>
                        </form>
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
		$(document).ready(function(){
			$('#li-Progress').parent('li').addClass("active");
			TopicList();
			$('#frmUploadWork').submit(function(e){
				e.preventDefault();
				var id = $('#id_stud').val();
				if(id==''){return false;}
				//Use ajax to communicate with php here
                                       $.ajax({
											url: "api/api.process?frmUploadWork",
											type: "POST",
											data:  new FormData(this),
											contentType: false,
											cache: false,
											processData:false,
											success: function(data)
											{
												var rs = JSON.parse(data);
												$.alert({
												boxWidth: '20%',
												useBootstrap: false,
												theme: 'supervan',
												opacity: 0.5,
												icon: 'icon-info-sign',
												type:'green',
												title:'Response',
												animation: 'scale',
												closeAnimation: 'scale',
												content:rs.m
												});
												TopicList();
											},
											error: function(){} 	        
									   });
																		 //End of ajax request
			});
			
		});
		function TopicList(){
			$.post('api/api.process?WorkProgress=<?php echo $id; ?>',function(data){
				$('#TopicList').html(data);
			});
		}
		function closeNoties(id,e){
				$(e).parent().parent().hide();
		}
		</script>
	</body>
</html>