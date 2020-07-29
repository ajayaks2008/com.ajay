<?php
require_once('loginvalidate.php');
require_once('./application/config/database.php');
$user_id = $_SESSION['cdes_user_id'];
?>
<!DOCTYPE html>
<html>
    <?php require_once './application/pages/head.php'; ?>
    <body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">
            <!-- Top Bar Start -->
            <?php require_once './application/pages/topBar.php'; ?>
            <!-- Top Bar End -->
            <!-- ========== Left Sidebar Start ========== -->
            <?php require_once './application/pages/sidebar.php'; ?>
            <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
            <!-- Left Sidebar End --> 
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="wraper container">
                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <ol class="breadcrumb">
                                    <li><a href="profile">Profile</a></li>
                                    <li class="active">Configure Mail</li>
                                </ol>
                                <div class="btn-group pull-right m-b-10">
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#MailConfig">Add Mail</a>                                    
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-body">
                                <div class="">
                                    <?php
                                    $conEmail = mysqli_query($db_con, "select * from tbl_email_config where user_id='$user_id'");
                                    $foundnum = mysqli_num_rows($conEmail);
                                    if ($foundnum > 0) {
                                        showData($conEmail, $db_con);
                                    } else {
                                        ?>
                                        <div class="form-group no-records-found"><label><i>No Emails Configured !!</i></label></div>
                                    <?php }
                                    ?>

                                </div>
                            </div>
                        </div>





                    </div>
                    <!-- END wrapper -->
                    <?php require_once './application/pages/footer.php'; ?>
                </div>
                <!-- ============================================================== -->
                <!-- End Right content here -->
                <!-- ============================================================== -->
                <!-- Right Sidebar -->
                <?php require_once './application/pages/rightSidebar.php'; ?>
                <?php require_once './application/pages/footerForjs.php'; ?>

                <script src="assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
                <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
                <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
                <script type="text/javascript" src="assets/plugins/parsleyjs/parsley.min.js"></script>
                <script type="text/javascript" src="assets/jquery.quicksearch.js"></script>
                <script type="text/javascript">

                    $(document).ready(function () {
                        $('form').parsley();
                    });
                    $(".select2").select2();
                    // jQuery('#datepicker').datepicker();
                    jQuery('#datepicker').datepicker({
                        format: "dd-mm-yyyy",
                        autoclose: true,
                        todayHighlight: true
                    });
                </script>
                <?php
                if (isset($_POST['mailConfig'])) {
                    $filters = "";
                    $fltr_sub = $_POST['fltr_sub'];
                    $fltr_sub = preg_replace("/[^a-zA-Z ]/ ", "", $fltr_sub); //filter subject
                    $fltr_sub = mysqli_real_escape_string($db_con, $fltr_sub);
                    if (!empty($fltr_sub)) {
                        if (empty($filters)) {
                            $filters .= 'SUBJECT "' . $fltr_sub . '"';
                        } else {
                            $filters .= ',SUBJECT "' . $fltr_sub . '"';
                        }
                    }
                    $fltr_body = $_POST['fltr_body'];
                    $fltr_body = preg_replace("/[^a-zA-Z0-9_@. ]/ ", "", $fltr_body); //filter body
                    $fltr_body = mysqli_real_escape_string($db_con, $fltr_body);
                    if (!empty($fltr_body)) {
                        if (empty($filters)) {
                            $filters .= 'BODY "' . $fltr_body . '"';
                        } else {
                            $filters .= ',BODY "' . $fltr_body . '"';
                        }
                    }
                    $fltr_from = $_POST['fltr_from'];
                    $fltr_from = preg_replace("/[^a-zA-Z0-9_@. ]/ ", "", $fltr_from); //filter from
                    $fltr_from = mysqli_real_escape_string($db_con, $fltr_from);
                    if (!empty($fltr_from)) {
                        if (empty($filters)) {
                            $filters .= 'FROM "' . $fltr_from . '"';
                        } else {
                            $filters .= ',FROM "' . $fltr_from . '"';
                        }
                    }
                    $fltr_to = $_POST['fltr_to'];
                    $fltr_to = preg_replace("/[^a-zA-Z0-9_@. ]/ ", "", $fltr_to); //filter to
                    $fltr_to = mysqli_real_escape_string($db_con, $fltr_to);
                    if (!empty($fltr_to)) {
                        if (empty($filters)) {
                            $filters .= 'TO "' . $fltr_to . '"';
                        } else {
                            $filters .= ',TO "' . $fltr_to . '"';
                        }
                    }
                    $fltr_date = $_POST['fltr_date'];
                    $fltr_date = mysqli_real_escape_string($db_con, $fltr_date);
                    if (!empty($fltr_date)) {
                        if (empty($filters)) {
                            $filters .= 'SINCE "' . date("d M Y", strtotime($fltr_date)) . '"';
                        } else {
                            $filters .= ',SINCE "' . date("d M Y", strtotime($fltr_date)) . '"';
                        }
                    }

                    $userid = $_POST['uid'];
                    $userid = mysqli_real_escape_string($db_con, $userid);
                    $mailServer = $_POST['mailServer'];
                    //$mailServer = preg_replace("/[^a-zA-Z0-9_@.- ]/ ", "", $mailServer); //filter mailserver
                    $mailServer = mysqli_real_escape_string($db_con, $mailServer);
                    $username = $_POST['emailid'];
                    //$username = preg_replace("/[^a-zA-Z0-9_@. ]/ ", "", $username); //filter email
                    $username = mysqli_real_escape_string($db_con, $username);
                    $password = $_POST['password'];
                    //$password = mysqli_real_escape_string($db_con, $password);
                    $port = $_POST['port'];
                    $port = preg_replace("/[^0-9]/ ", "", $port); //filter email
                    $port = mysqli_real_escape_string($db_con, $port);
                    $ssl1 = $_POST['ssl'];
                    $ssl1 = mysqli_real_escape_string($db_con, $ssl1);
                    if ($ssl1 == 1) {
                        $ssl = "ssl";
                    } else {
                        $ssl = "";
                    }
                    $valid = $_POST['valid'];
                    $valid = mysqli_real_escape_string($db_con, $valid);
                    if ($valid == 0) {
                        $validate = "novalidate-cert";
                    } else {
                        $validate = "";
                    }

                    require_once './mailServerInt.php';
                    $conEmail = connectionCheck($mailServer, $port, $ssl, $validate, $username, $password);
                    if ($conEmail) {
                        $password = urlencode(base64_encode($password));
                        $filters = mysqli_real_escape_string($db_con, $filters);
                        $check = mysqli_query($db_con, "select * from tbl_email_config where user_email='$username'");
                        if (mysqli_num_rows($check) <= 0) {
                            $mail = mysqli_query($db_con, "insert into tbl_email_config(`id`,`user_id`,`user_email`,`password`,`mailServer`,`port`,`ssl`,`validate`,`active`,`filters`) "
                                            . "values(null,'$userid','$username','$password','$mailServer','$port','$ssl1','$valid','1','$filters')") or die('Error8' . mysqli_error($db_con));
                            if ($mail) {
                                echo'<script>taskSuccess("profile","Mail configured successfully. Thanks!");</script>';
                            }
                        } else {
                            echo'<script>taskFailed("profile","Already configured with another account. please contact administrator!");</script>';
                        }
                    } else {
                        echo'<script>taskFailed("profile","unable to configure email with these settings. please check once and try again!");</script>';
                    }
                    mysqli_close($db_con);
                }
                ?>
            </div>
        </div>
        <?php

        function showData($conEmail, $db_con) {
            ?>
            <table class="table table-striped" id="gtable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Email Id</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $i += $_GET['start'];
                    while ($row = mysqli_fetch_assoc($conEmail)) {
                        ?>
                        <tr class="gradeX">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['user_email']; ?></td>
                            <td class="actions">
                                <a href="#" class="on-default edit-row btn btn-primary" data-toggle="modal" data-target="#editMailConfig" id="editRow" data="<?php echo $row['id']; ?>" onclick="setEditEmail('<?php echo $row['id']; ?>');"><i class="fa fa-pencil" ></i> Modify</a>
                                <a href="#" class="on-default remove-row btn btn-danger" data-toggle="modal" data-target="#dialog" id="removeRow" data="<?php echo $row['id']; ?>" ><i class="fa fa-trash-o"></i> Delete</a>
                                <a href="mail-lists" class="btn btn-primary" target="_blank"><i class="fa fa-eye"></i>Show Mails</a>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
            <?php
        }
        ?>
    </body>
</html>
