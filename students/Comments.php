<!DOCTYPE html>
<html lang="en">
<head>
    <title>Projects Management :: Students Message</title>
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
                        <h3><i class="icon-comment"></i>CONTACT YOUR SUPERVISOR
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
                        <i class="icon-inbox"></i>
                        <h5>Messages</h5>
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
                        NEW MESSAGE
                    </legend>
                    <div class="box pattern pattern-sandstone">
                        <div class="box-content box-list collapse in">
                        <form class="form-horizontal" method="post" id="frmAddMessage">
                        <input type="hidden" value="<?php echo $id ?>" name="id" id="id_stud">
                        <ul>
                        <li><span>Send new Message</span></li>
                        <li><textarea name="message" cols="" rows="5" required=''></textarea></li>
                        <li><button type="submit" class="btn btn-primary">Send</button></li>
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
			$('#li-Comments').parent('li').addClass("active");
			TopicList();
			$('#frmAddMessage').submit(function(e){
				e.preventDefault();
				var id = $('#id_stud').val();
				if(id==''){return false;}
				 $.confirm({
                            title: 'Confirmation',
                            content: 'Are you sure you want to send this message',
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
										var formData = $('#frmAddMessage').serialize();
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
													url: 'api/api.process?SendMessage',
													dataType: 'json',
													method: 'get',
													data:formData
												}).done(function (rs) {
													if(rs.s==1){$('#frmAddMessage').trigger('reset');}
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
		function TopicList(){
			$.post('api/api.process?MessageList=<?php echo $id; ?>',function(data){
				$('#TopicList').html(data);
			});
		}
		function closeNoties(id,e){
				$(e).parent().parent().hide();
		}
		</script>
	</body>
</html>