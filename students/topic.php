<!DOCTYPE html>
<html lang="en">
<head>
    <title>Projects Management :: Students Topics</title>
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
                        <h3><i class="icon-folder-open"></i>PROJECT TOPICS
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
                        <i class="icon-list"></i>
                        <h5>Projects Topics</h5>
                        <button class="btn btn-box-right" data-toggle="collapse" data-target=".box-list1">
                            <i class="icon-reorder"></i>
                        </button>
                    </div>
                    <div class="box-content box-list collapse in box-list1">
                        <ul>
                         <li class="row label label-inverse" style="color:#FFF;">
                               <div class="span9">PROJECT TOPIC</div>
                               <div class="span1">STATUS</div>
                           </li>
                       <span id="TopicList"></span>
                        </ul>
                       
                    </div>

                </div>
            </div>
            <!-- Student list -->
            <div class="span4">
                <div class="blockoff-left">
                    <legend class="lead">
                        NEW TOPIC
                    </legend>
                    <div class="box pattern pattern-sandstone">
                        <div class="box-content box-list collapse in">
                        <form class="form-horizontal" method="post" id="frmAddTopic">
                        <input type="hidden" value="<?php echo $id ?>" name="id" id="id_stud">
                        <ul>
                        <li><span>Submit new Topic</span></li>
                        <li><textarea name="topic" cols="" rows="3" required=''></textarea></li>
                        <li><button type="submit" class="btn btn-primary">Submit</button></li>
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
			$('#topic').parent('li').addClass("active");
			TopicList();
			$('#frmAddTopic').submit(function(e){
				e.preventDefault();
				var id = $('#id_stud').val();
				if(id==''){return false;}
				 $.confirm({
                            title: 'Confirmation',
                            content: 'Are you sure you want to submit this topic',
                            icon: 'icon-question-sign',
                            animation: 'scale',
                            closeAnimation: 'scale',
							boxWidth: '20%',
   							useBootstrap: false,
                            opacity: 0.5,
							theme: 'supervan',
                            buttons: {
                                'confirm': {
                                    text: '<i class="icon-ok"></i> Yes',
                                    btnClass: 'btn-blue',
									 boxWidth: '30%',
   									 useBootstrap: false,
                                    action: function () {
										//Use ajax to communicate with php here
										var formData = $('#frmAddTopic').serialize();
                                        $.confirm({
											animation: 'scale',
											closeAnimation: 'scale',
											boxWidth: '20%',
											useBootstrap: false,
											opacity: 0.5,
											theme: 'supervan',
											content: function () {
												var self = this;
												return $.ajax({
													url: 'api/api.process?AddTopic',
													dataType: 'json',
													method: 'get',
													data:formData
												}).done(function (rs) {
													if(rs.s==1){$('#frmAddTopic').trigger('reset');}
													self.setContent(rs.m);
													self.setTitle(rs.t);
													self.setIcon(rs.ico);
													self.setType(rs.tp);
													TopicList();
												}).fail(function(){
													self.setType('red');
													self.setTitle("Error");
													self.setIcon('icon-exclamation-sign');
													self.setContent('Something went wrong.');
												});
											}
										});
										 //End of ajax request
                                    }
                                },
                                cancel:function () {
                                    $.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-remove-circle',
									type:'red',
									title:'Cancelled',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'Operation <strong>Cancelled</strong>'
									});
                                },
                                
                            }
                        });
			});
			
		});
		function closeNoties(id,e){
			//alert("I LOVE YOU ESTHER");
			$.post('api/api.process?removeNotify='+id,function(data){
				$(e).parent().parent().hide();
			});
		}
		function TopicList(){
			$.post('api/api.process?TopicList=<?php echo $id; ?>',function(data){
				$('#TopicList').html(data);
			});
		}
		</script>
	</body>
</html>