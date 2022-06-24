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
                        <h3><i class="icon-calendar"></i>SCHEDULE
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
            <div class="span12">
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
            <!-- Student list -->
            <div class="span4">
                <div class="box pattern pattern-sandstone">
                    <div class="box-header">
                        <i class="icon-calendar"></i>
                        <h5>Schedule</h5>
                        <button class="btn btn-box-right" data-toggle="collapse" data-target=".box-list1">
                            <i class="icon-reorder"></i>
                        </button>
                    </div>
                    <div class="box-content box-list collapse in box-list1">
                     <ul>
                      <li>
                      <a href="javascript:void(0)" class="btn btn-success" id="scheAllStudents">Automatic assign all Students </a>
                      </li>
                      
                      <form class="form-horizontal" id="frmassign" method="post">
                      <li>
                      <div class="control-group">
                      <label class="span4">Student ID:</label>
                      <div class="span4">
                      <input type="hidden" class="type" name="type">
                      <input type="text" readonly value="" class="stid" required>
                      <input type="hidden" value="" class="id" name="id">
                      <input type="hidden" value="" class="dpm" name="dpm">
                      <input type="hidden" value="" class="sch" name="sch">
                      </div>
                      </div>
                      <div class="control-group">
                      <label class="span4">Choose Supervisor:</label>
                      <div class="span4">
                      			 <select id="cbsupevisor"  name="supevisor" required=''>
                                  <option value="" disabled selected>-- Choose --</option>
                                  
                                  </select>

                      </div>
                      </div>
                      <div class="control-group">
                      <label class="span4"></label>
                      <div class="span4">
                      <button class="btn btn-inverse"> <i class="icon-check"></i> Assign</button>
                      </div>
                      </div>
                      </li>
                      </form>
                      </ul>
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
			$('#li-schedule').parent('li').addClass("active");
			$.post('api/api.process?StudentList',function(html){
				$('.studentList').html(html);
			});
			$('#dpm').change(function(){
				var dpm = $(this).val();
				if(dpm==''){
					$.post('api/api.process?StudentList',function(html){
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
				$.post('api/api.process?StudentList',{dpm:dpm},function(html){
				$('.studentList').html(html);
			});
			});
			$('#txtSearch').keyup(function(){
				var txtsearch = $(this).val();
				var dpm = $('#dpm').val();
				if(dpm==''){
					$.post('api/api.process?StudentList&txtsearch='+txtsearch,function(html){
						$('.studentList').html(html);
					});
					return false;
				}
				$.post('api/api.process?StudentList&txtsearch='+txtsearch,{dpm:dpm},function(html){
				$('.studentList').html(html);
				});
			});
			//Assign Student 
			$('#frmassign').submit(function(e){
				e.preventDefault();
				var id = $('.stid').val();
				if(id=='' || 'undefined' == typeof id){
					 $.alert({
									boxWidth: '20%',
   									useBootstrap: false,
									theme: 'supervan',
									opacity: 0.5,
									icon: 'icon-remove-circle',
									type:'red',
									title:'Attention',
									animation: 'scale',
									closeAnimation: 'scale',
									content:'Please choose student and continue'
									});
						return false;
				}
				$.confirm({
                            title: 'Confirmation',
                            content: 'Are you sure you want to assign this student',
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
										var formData = $('#frmassign').serialize();
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
													url: 'api/api.process?assignStudent',
													dataType: 'json',
													method: 'get',
													data:formData
												}).done(function (rs) {
													if(rs.s==1){$('#frmassign').trigger('reset');}
													self.setContent(rs.m);
													self.setTitle(rs.t);
													self.setIcon(rs.ico);
													self.setType(rs.tp);
													var dpm = $('#dpm').val();
													if(dpm==''){
														$.post('api/api.process?StudentList',function(html){
															$('.studentList').html(html);
														});
													}else{
														$.post('api/api.process?StudentList',{dpm:dpm},function(html){
														$('.studentList').html(html);
														});
													}
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
			$('#scheAllStudents').click(function(e){
				e.preventDefault();
				var dpm = $('#dpm').val();
				var dpm_name ='';
				if(dpm==''){dpm_name='All';}else{
					var list = dpm.split(',');
					var arr = new Array();
					arr[1] = new Array('Computer Science','Science Lab. Tech.','Statistics');
					arr[2] = new Array('Accounting','Office Tech. and management');
					arr[3] = new Array('Agricultural Technology');
					var d = parseInt(list[1])-1;
					var s = parseInt(list[0]);
					dpm_name =arr[s][d];
				}
				$.confirm({
                            title: 'Confirmation',
                            content: 'Are you sure you want to assign all students in '+dpm_name+' department',
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
													url: 'api/api.process?assignAllStudent='+dpm,
													dataType: 'json',
													method: 'get'
												}).done(function (rs) {
													//alert(rs);
													self.setContent(rs.m);
													self.setTitle(rs.t);
													self.setIcon(rs.ico);
													self.setType(rs.tp);
													var dpm = $('#dpm').val();
													if(dpm==''){
														$.post('api/api.process?StudentList',function(html){
															$('.studentList').html(html);
														});
													}else{
														$.post('api/api.process?StudentList',{dpm:dpm},function(html){
														$('.studentList').html(html);
														});
													}
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
		function paggingcontrol(pageNum,totalRows){
			var dpm = $('#dpm').val();
			//alert(dpm);
	 		$.post('api/api.process?StudentList&start='+pageNum+'&totalRows='+totalRows,{dpm:dpm},function(html){
				//alert(html);
				$('.studentList').html(html);
			});
		}
		function AssignSupervisor(id){
			$.post('api/api.process?InitiateAssign='+id,function(html){
				var rs = JSON.parse(html);
					var dpm = rs.school+','+rs.department;
					$.post('api/api.process?CBoxSupevisor',{dpm:dpm},function(html){
						$('#cbsupevisor').html(html);
					});
				$('.id').val(rs.id);
				$('.dpm').val(rs.department);
				$('.sch').val(rs.school);
				$('.stid').val(rs.studentid);
				$('.type').val('Assign');
				//id dpm sch stid supevisor
			});
		}
		function ReAssignSupervisor(id){
			$.post('api/api.process?InitiateAssign='+id,function(html){
				var rs = JSON.parse(html);
					var dpm = rs.school+','+rs.department;
					$.post('api/api.process?CBoxSupevisor',{dpm:dpm},function(html){
						$('#cbsupevisor').html(html);
					});
				$('.id').val(rs.id);
				$('.dpm').val(rs.department);
				$('.sch').val(rs.school);
				$('.stid').val(rs.studentid);
				$('.type').val('Re-Assign');
				//id dpm sch stid supevisor
			});
		}
		</script>
	</body>
</html>