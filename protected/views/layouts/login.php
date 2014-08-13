<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui',CClientScript::POS_END);
?>
<!DOCTYPE html>
<html class="">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $this->pageTitle;?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo Yii::app()->theme->baseUrl;?>/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->baseUrl;?>/css/custom.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="">
        
        <?php echo $content; ?>
        <footer id="footer">
            <div class="container-fluid">
                            <div class="text-center">
                <p class="help muted">
                    <strong>NOC</strong> 
                    © <?php echo date('Y')?>
                    In1go Technologies, Inc.
                    
                </p>
               </div>
            </div>
        </footer> 
        <?php /*
        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <form action="../../index.html" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="userid" class="form-control" placeholder="User ID"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  
                    
                    <p><a href="#">I forgot my password</a></p>
                    
                    <a href="register.html" class="text-center">Register a new membership</a>
                </div>
            </form>

            <div class="margin text-center">
                <span>Sign in using social networks</span>
                <br/>
                <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

            </div>
        </div>
        */?>

        <!-- jQuery 2.0.2 -->
<!--        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>-->
        <!-- Bootstrap -->
        <script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>