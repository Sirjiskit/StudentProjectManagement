<!DOCTYPE html>
<html lang="en">
<head>
    <title>Projects Management :: Admin Topic</title>
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
                        <h3><i class="icon-user"></i>STUDENT'S SUBMITTED TOPICS
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
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="page container">
        <div class="row">
                <div class="span4">
                    <div class="blockoff-right">
                        <ul id="person-list" class="nav nav-list">
                            <li class="nav-header">Students</li>
                            <li class="active">
                                <a id="view-all" href="#">
                                    <i class="icon-chevron-right pull-right"></i>
                                    <b>View All</b>
                                </a>
                            	</li>
                            	 <?php 
										$sql =$data->query($data->StudentListAll());$i =0;
										while($row=$data->fetch_array($sql)){$i+=1;
									?>
                                <li>
                                    <a href="#Person-<?php echo $i ?>">
                                        <i class="icon-chevron-right pull-right"></i>
                                        <?php echo $row['studentid'] ?>
                                    </a>
                                </li>
                                <?php }?>
                        </ul>
                    </div>
                </div>
                <div class="span12">
                 <?php 
										$sql =$data->query($data->StudentListAll());$j =0;
										while($row=$data->fetch_array($sql)){$j+=1;
									?>
                    <div id="Person-<?php echo $j ?>" class="box">
                        <div class="box-header">
                            <i class="icon-user icon-large"></i>
                            <h5><?php echo $row['studentid'] ?><input type="hidden" id="stud_id" value="<?php echo $row['id'] ?>"></h5>
                            
                        </div>
                        <div class="box-content box-table">
                        <table class="table table-hover tablesorter">
                            <thead>
                                <tr>
                                	<th>#</th>
                                    <th>Project Topic</th>
                                    <th>Date submited</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php $cmd = $data->query("SELECT * FROM `topic` WHERE stuid=".$row['id']);$k=0;
							if($data->no_rows($cmd)>0){
								while($tr = $data->fetch_array($cmd)){$k+=1;
							?>
                                <tr>
                                	<td><?php echo $k ?></td>
                                    <td><?php echo $tr['topic'] ?></td>
                                    <td><?php echo date_format(date_create($tr['date']),"d F, Y"); ?></td>
                                    <td><?php echo $data->topicStatus($tr['status']); ?></td>
                                    <td>
                                    <?php if($tr['status']==0){?>
                                    <div class="btn-group">
								<button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
									<ul class="dropdown-menu">
									<li><a href="javascript:void(0)" onClick="approveRow(<?php echo $tr[0]?>)">Approve</a></li>
									<li><a href="javascript:void(0)" onClick="rejectRow(<?php echo $tr[0]?>)">Reject</a></li>
									<li><a href="javascript:void(0)" onClick="reframeRow(<?php echo $tr[0]?>)">Re-structure</a></li>
									 </ul>
								</div><!-- /btn-group -->
                                    <?php }?>
                                    </td>
                                    
                                </tr>
                                <?php }}else{
									?>
                                    <tr>
                                    <td colspan="5">No Project topic submitted</td>
                                    
                                	</tr>
                                    <?php
								}  ?>
                            </tbody>
                        </table>
                        </div>

                    </div>
                <?php }?>
                   
                
                </div>
            </div>
  </section>  
  </div>
  </div>
  
        <!-- Include footer here-->
        <?php include('footer.php'); ?>
        <script>
		$(document).ready(function(){
			$('#li-Topics').parent('li').addClass("active");
		});
		$(function() {
            $('#person-list.nav > li > a').click(function(e){
                if($(this).attr('id') == "view-all"){
                    $('div[id*="Person-"]').fadeIn('fast');
                }else{
                    var aRef = $(this);
                    var tablesToHide = $('div[id*="Person-"]:visible').length > 1
                            ? $('div[id*="Person-"]:visible') : $($('#person-list > li[class="active"] > a').attr('href'));

                    tablesToHide.hide();
                    $(aRef.attr('href')).fadeIn('fast');
                }
                $('#person-list > li[class="active"]').removeClass('active');
                $(this).parent().addClass('active');
                e.preventDefault();
            });

            $(function(){
                $('table').tablesorter();
                $("[rel=tooltip]").tooltip();
            });
        });
		function reframeRow(id){
			$.confirm({
			title: 'Re-structure the topic here',
            content: 'Are you sure you want to send this message',
            icon: 'icon-exclamation-sign',
            animation: 'scale',
            closeAnimation: 'scale',
			boxWidth: '30%',
   			useBootstrap: false,
            opacity: 0.5,
			theme: 'supervan',
			content: '' +
			'<form action="" class="formName">' +
			'<div class="form-group">' +
			'<input type="hidden" value="'+id+'" name="id" id="id">' +
			'<textarea placeholder="Enter the topic" class="name" required cols="" rows="3"></textarea>' +
			'</div>' +
			'</form>',
			buttons: {
				formSubmit: {
					text: 'Submit',
					btnClass: 'btn-blue',
					action: function () {
						var name = this.$content.find('.name').val();
						var id = this.$content.find('#id').val();
						var stud_id = $('#stud_id').val();
						if(!name || !id || !stud_id){
							$.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-remove-circle',
									type:'red',
									title:'Error',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'provide a valid Project Topic'});
									return false;
						}
						$.post('api/api.process?retructure&id='+id+'&topic='+name+'&stud_id='+stud_id,function(html){
							var rs = JSON.parse(html);
							 $.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-info-sign',
									type:'green',
									title:'Re-Structured',
									animation: 'scale',
									closeAnimation: 'scale',
									content:rs.m
							 });
							 if(rs.s==1){
									setTimeout(function(){ window.location='';},1000);
							 }
						});
										 //End of ajax request		
					}
				},
				cancel: function () {
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
			},
			onContentReady: function () {
				// bind to events
				var jc = this;
				this.$content.find('form').on('submit', function (e) {
					// if the user submits the form by pressing enter in the field.
					e.preventDefault();
					jc.$$formSubmit.trigger('click'); // reference the button and click it
				});
			}
		});
		}
		function approveRow(id){
			 $.confirm({
                            title: 'Confirmation',
                            content: 'Are you sure you want to approve this topic',
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
										var stud_id = $('#stud_id').val();
							$.post('api/api.process?approveRow&id='+id+'&stud_id='+stud_id,function(html){
							var rs = JSON.parse(html);
							 $.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-info-sign',
									type:'green',
									title:'Re-Structured',
									animation: 'scale',
									closeAnimation: 'scale',
									content:rs.m
							 });
							 if(rs.s==1){
									setTimeout(function(){ window.location='';},1000);
							 }
						});
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
		}
		function rejectRow(id){
			 $.confirm({
                            title: 'Confirmation',
                            content: 'Are you sure you want to reject this topic',
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
										var stud_id = $('#stud_id').val();
							$.post('api/api.process?rejectRow&id='+id+'&stud_id='+stud_id,function(html){
							var rs = JSON.parse(html);
							 $.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-info-sign',
									type:'green',
									title:'Re-Structured',
									animation: 'scale',
									closeAnimation: 'scale',
									content:rs.m
							 });
							 if(rs.s==1){
									setTimeout(function(){ window.location='';},1000);
							 }
						});
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
		}
		</script>
	</body>
</html>