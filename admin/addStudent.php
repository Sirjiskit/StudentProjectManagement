<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Projects Management :: Admin add Students</title>
        <?php include('head.php'); ?>
        <link rel="stylesheet" href="../alert/css/jquery-confirm.css">
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
                <section class="nav nav-page"  pageVTourUrl="guide/tour/student-tour.html" pageVGuideUrl="guide/student-guide.html">
                    <div class="container">
                        <div class="row">
                            <div class="span7">
                                <header class="page-header">
                                    <h3><i class="icon-edit"></i>New Student<br><small> add new student</small>
                                    </h3>
                                </header>
                            </div>
                            <div class="span9">
                                <ul class="nav nav-pills">
                                    <li>
                                        <button id="vtour-button" rel="tooltip" title="Launch Virtual Tour" data-placement="bottom">
                                            <i class="icon-magic icon-large"></i>
                                        </button>
                                    </li>
                                    <li>
                                        <button id="vguide-button" rel="tooltip" title="Launch Guide" data-placement="bottom">
                                            <i class="icon-question-sign icon-large"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="my-account-security-form" class="page container">
                    <form id="userSecurityForm" class="form-horizontal" action="addSupervisor" method="post">
                        <div class="container">

                            <div class="alert alert-block alert-info">
                                <p>
                                    Enter the information of the student.  Fields marked with an asterisk
                                    are required.
                                </p>
                            </div>
                            <div class="row">
                                <div>
                                    <div id="new-student-info-row" class="span7">
                                        <fieldset>
                                            <legend>Student Information</legend>

                                            <div class="control-group ">
                                                <label class="control-label">Student ID: <span class="required">*</span></label>
                                                <div class="controls">
                                                    <input id="studentid-control" name="studentid" class="span4" type="text" value="" autocomplete="false" required='' pattern="^([A-Z]{2,3}?/?[A-Z]{2,3}?/?(ND/)?/?\d{2}?/?\d{3})+$" placeholder="e.g ST/CS/ND/17/008" title="e.g ST/CS/ND/17/008">

                                                </div>
                                            </div>
                                            <div class="control-group ">
                                                <label class="control-label">First Name: <span class="required">*</span></label>
                                                <div class="controls">
                                                    <input id="firstname-control" name="firstname" class="span4" type="text" value="" autocomplete="false" required='' pattern="^[A-Za-z]+$" placeholder="e.g Ali"  title="e.g Ali">

                                                </div>
                                            </div>
                                            <div class="control-group ">
                                                <label class="control-label">Othernames <span class="required">*</span></label>
                                                <div class="controls">
                                                    <input id="othernames-control" name="othernames" class="span4" type="text" value="" autocomplete="false" required='' pattern="^[A-Za-z,' ']+$" placeholder="e.g Musa" title="e.g Musa">

                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div id="new-project-row" class="span9">
                                        <fieldset>
                                            <legend>Project Information</legend>
                                            <div class="control-group">
                                                <label for="School" class="control-label">School <span class="required">*</span></label>
                                                <div class="controls">
                                                    <select id="School_control" class="span5" name="School" required=''>
                                                        <option value="" disabled selected>-- Select School --</option>
                                                        <option value="1">
                                                            Science and Technology
                                                        </option>
                                                        <option value="2">
                                                            Management and Technology
                                                        </option>
                                                        <option value="3">
                                                            Agriculture and Technology
                                                        </option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="Department" class="control-label">Department <span class="required">*</span></label>
                                                <div class="controls">
                                                    <select id="Department_control" class="span5" name="department" required=''>
                                                        <option value="" disabled selected>-- Select Department --</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="Status" class="control-label">Status <span class="required">*</span></label>
                                                <div class="controls">
                                                    <select id="Status_control" class="span5" name="Status" required=''>
                                                        <option value="" disabled selected>-- Select Status --</option>
                                                        <option value="1">
                                                            Individual Project
                                                        </option>
                                                        <option value="2">
                                                            Group Project
                                                        </option>
                                                    </select>

                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <footer id="submit-actions" class="form-actions">
                                <button id="submit-button" type="submit" class="btn btn-primary" name="action" value="CONFIRM">Save</button>
                                <button type="reset" class="btn btn-danger" name="action" value="CANCEL">Cancel</button>
                            </footer>
                        </div>
                    </form>
                </section>

            </div>
        </div>

        <!-- Include footer here-->
        <?php include('footer.php'); ?>
        <script>
            $(document).ready(function () {
                $('#li-student').parent('li').addClass("active");
                $('#School_control').change(function () {
                    var val = $(this).val();
                    var arr = new Array();
                    arr[1] = new Array('Computer Science', 'Science Lab. Tech.', 'Statistics');
                    arr[2] = new Array('Accounting', 'Office Tech. and management');
                    arr[3] = new Array('Agricultural Technology');
                    var option = '<option value="" disabled selected>-- Select Department --</option>';
                    for (var i = 0; i < arr[val].length; i++) {
                        option += '<option value="' + (i + 1) + '">' + arr[val][i] + '</option>';
                    }
                    $('#Department_control').html(option);
                });

                $('#userSecurityForm').submit(function (e) {
                    e.preventDefault();
                    //var dataForm = $(this).serialize();
                    $.confirm({
                        title: 'Confirmation',
                        content: 'Are you sure you want to add this student',
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
                                    var formData = $('#userSecurityForm').serialize();
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
                                                url: 'api/api.process?AddStudent',
                                                dataType: 'json',
                                                method: 'get',
                                                data: formData
                                            }).done(function (rs) {
                                                if (rs.s == 1) {
                                                    $('#userSecurityForm').trigger('reset');
                                                }
                                                self.setContent(rs.m);
                                                self.setTitle(rs.t);
                                                self.setIcon(rs.ico);
                                                self.setType(rs.tp);
                                            }).fail(function () {
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
                            cancel: function () {
                                $.alert({
                                    boxWidth: '20%',
                                    useBootstrap: false,
                                    theme: 'supervan',
                                    opacity: 0.5,
                                    icon: 'icon-remove-circle',
                                    type: 'red',
                                    title: 'Cancelled',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    content: 'Operation <strong>Cancelled</strong>'
                                });
                            },

                        }
                    });
                });
            });
            $(function () {
                $("[rel=tooltip]").tooltip();
                $("#vguide-button").click(function (e) {
                    new VTour(null, $('.nav-page')).tourGuide();
                    e.preventDefault();
                });
                $("#vtour-button").click(function (e) {
                    new VTour(null, $('.nav-page')).tour();
                    e.preventDefault();
                });
            });
        </script>
    </body>
</html>