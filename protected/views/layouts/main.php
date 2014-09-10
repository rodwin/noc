<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui',CClientScript::POS_END);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $this->pageTitle;?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta http-equiv="X-UA-Compatible" content="IE=7; IE=EmulateIE9; IE=10" />
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->baseUrl;?>/css/custom.css" rel="stylesheet" type="text/css" />
<!--         daterange picker 
        <link href="<?php //echo Yii::app()->theme->baseUrl;?>/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />-->
        <!-- jQuery 2.0.2 -->
<!--        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>-->
        
        
<!--        <script src="<?php //echo Yii::app()->baseUrl;?>/js/jquery.min.js" type="text/javascript"></script>-->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
        
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                NOC
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
               
<!--                <div class="navbar-left">
                    <ul class="nav navbar-nav">
                         Messages: style can be found in dropdown.less
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Inventory
                            </a>
                            
                        </li>
                         Notifications: style can be found in dropdown.less 
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Admin
                            </a>
                        </li>
                    </ul>
                </div>-->
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
<!--                                <span class="label label-success">4</span>-->
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 0 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
<!--                                        <li> start message 
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/avatar3.png" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li> end message 
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?php //echo Yii::app()->theme->baseUrl;?>/img/avatar2.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    AdminLTE Design Team
                                                    <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?php //echo Yii::app()->theme->baseUrl;?>/img/avatar.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Developers
                                                    <small><i class="fa fa-clock-o"></i> Today</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?php //echo Yii::app()->theme->baseUrl;?>/img/avatar2.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Sales Department
                                                    <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?php //echo Yii::app()->theme->baseUrl;?>/img/avatar.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Reviewers
                                                    <small><i class="fa fa-clock-o"></i> 2 days</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>-->
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
<!--                                <span class="label label-warning">10</span>-->
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 0 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
<!--                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users warning"></i> 5 new members joined
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-cart success"></i> 25 sales made
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-person danger"></i> You changed your username
                                            </a>
                                        </li>-->
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
<!--                                <span class="label label-danger">9</span>-->
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 0 tasks</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
<!--                                        <li> Task item 
                                            <a href="#">
                                                <h3>
                                                    Design some buttons
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li> end task item 
                                        <li> Task item 
                                            <a href="#">
                                                <h3>
                                                    Create a nice theme
                                                    <small class="pull-right">40%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">40% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li> end task item 
                                        <li> Task item 
                                            <a href="#">
                                                <h3>
                                                    Some task I need to do
                                                    <small class="pull-right">60%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">60% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li> end task item 
                                        <li> Task item 
                                            <a href="#">
                                                <h3>
                                                    Make beautiful transitions
                                                    <small class="pull-right">80%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">80% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li> end task item -->
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo ucfirst(Yii::app()->user->userObj->first_name);?> <?php echo ucfirst(Yii::app()->user->userObj->last_name);?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
<!--                                    <img src="<?php echo Yii::app()->theme->baseUrl;?>/img/avatar3.png" class="img-circle" alt="User Image" />-->
                                    <img src="<?php echo Globals::get_gravatar(Yii::app()->user->userObj->email)?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo ucfirst(Yii::app()->user->userObj->first_name);?> <?php echo ucfirst(Yii::app()->user->userObj->last_name);?> - <?php echo ucfirst(Yii::app()->user->userObj->position);?>
                                        <small>Member since <?php echo date('M Y',strtotime(Yii::app()->user->userObj->created_date))?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
<!--                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>-->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo Yii::app()->createUrl('/admin/user/profile',array('id'=>Yii::app()->user->userObj->user_id));?>" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo Yii::app()->createUrl('/site/logout');?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo Globals::get_gravatar(Yii::app()->user->userObj->email)?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo ucfirst(Yii::app()->user->userObj->first_name);?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    
                    <?php
                    Yii::app()->controller->renderPartial('//layouts/_menu')
                    ?>
                    
                    
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo $this->pageTitle;?>
<!--                        <small>< sub title goes here></small>-->
                    </h1>
<!--                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>-->
                    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                            'links'=>$this->breadcrumbs,
                            'htmlOptions'=> array('class'=>"breadcrumb"),
                    )); ?>
                </section>

                <!-- Main content -->
                <section class="content">
                            
                                <?php echo $content; ?>
                            
                            
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        

<!--        <script src="<?php //echo Yii::app()->baseUrl;?>/js/jquery.yii.js" type="text/javascript"></script>-->
        <!-- jQuery UI 1.10.3 -->
<!--        <script src="<?php //echo Yii::app()->theme->baseUrl;?>/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>-->
        <!-- Bootstrap -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
<!--        <script src="<?php //echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?php //echo Yii::app()->baseUrl;?>/js/fnMultiFilter.js" type="text/javascript"></script>-->
        <script src="http://cdn.datatables.net/1.10.0/js/jquery.dataTables.js" type="text/javascript"></script>
        <script src="http://cdn.datatables.net/plug-ins/28e7751dbec/api/fnMultiFilter.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->baseUrl;?>/js/jquery.validate.js" type="text/javascript"></script>
<!--        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js" type="text/javascript"></script>-->
        <!-- AdminLTE App -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/AdminLTE/app.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/AdminLTE/demo.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->baseUrl;?>/js/bootstrap-growl.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->baseUrl;?>/js/global.js" type="text/javascript"></script>
        <!-- date-picker -->
<!--        <script src="<?php //echo Yii::app()->theme->baseUrl;?>/js/plugins/datepicker/datepicker.js" type="text/javascript"></script>-->
        <script type="text/javascript">
        $(function() {
        <?php
        /*
         * type: info,success,warning, danger
         */
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            $icon = "glyphicon glyphicon-info-sign";
            if($key != "success"){
                $icon = "glyphicon glyphicon-warning-sign";
            }
            echo "$.growl( '$message',{ 
                    icon: '$icon', 
                    type: '$key'
                });\n";
        }
        ?>
        });
        </script>
        

    </body>
</html>