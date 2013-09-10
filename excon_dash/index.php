<?php require_once("inc/_initialize.php"); ?>
<?php include_layout_template('header.php'); ?>
    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
<!--     <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png"> -->

    <?php 
    $message = "";

    // $_SESSION['unit_token'] = 'EXCONUNIT';
    // print_r($_SESSION);

    if(isset($_POST['submit']))
    {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        //Check database to see if username/password exists.
        $found_user = User::authenticate($username,$password);

        if($found_user){
            $session->login($found_user->user_id,$found_user->user_type,$found_user->user_unit);
              // print_r($found_user);
              // die();
              
              // QUERY EMPLOYEES AND GET id
              // $sql = "SELECT id FROM employees WHERE user_id = " . $found_user->user_id;


             log_action('Login', "{$found_user->user_name} logged in.");
             /* per day log */
             daily_log_action('Login', "{$found_user->user_name} log-in successfull.");

            $e = Employees::find_by_user_id($found_user->user_id); 

            // GET LAST ACCOUNT LOGIN AND SAVE IT TO SESSION
            $sql = "SELECT activity_details,activity_date FROM tblactivity_logs WHERE employee_id = $e->id ORDER BY activity_date DESC LIMIT 1";
            $result = ActivityLogs::find_by_sql($sql);

            foreach($result as $rows)
            {
                $_SESSION['last_activity'] = $rows->activity_details;
                $_SESSION['last_activity_date'] = $rows->activity_date;
            }

            $log_activity = new ActivityLogs();
            $log_activity->activity_details = 'LI:'.$e->id."/".date('Y-m-d H:i:s')."/".get_client_ip();
            $log_activity->activity_date = date('Y-m-d H:i:s');
            $log_activity->employee_id = $e->id;
            $log_activity->save();



             redirect_to('dashboard.php');
        }
        else
        {
            // username/password combo was not found in the database.
            //$message = '<div class="error">Login failed; Invalid username or password</div>';
             daily_log_action('Login', "{$username} log-in failed.");

            $message = '<div class="alert alert-error">  
                        <a class="close" data-dismiss="alert">×</a>  
                        <strong>Login failed! </strong> Invalid username or password.  
                        </div> ';
            // $msgtype = "error";
        }
    }
    else 
    { // Form has not been submitted.
        $username ="";
        $password ="";
    }

    ?>
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body class=""> 
  <!--<![endif]-->
    
    <div class="navbar">
        <div class="navbar-inner">
                <ul class="nav pull-right">
                    
                </ul>
                <a class="brand" href="index.php"><span class="first">JBLFMU</span> <span class="second">e-Dashboard</span></a>
        </div>
    </div>
    


    

    
        <div class="row-fluid">
    <div class="dialog">
        
        <div class="block">
            <p class="block-heading">Sign In</p>
            <div class="block-body">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label>Username</label>
                    <input type="text" class="span12" value="" name="username" id="username">
                    <label>Password</label>
                    <input type="password" class="span12" value="" name="password" id="password">
                    <!-- <a href="index.php" class="btn btn-primary pull-right">Sign In</a> -->
                    <input type="submit" id="submit" name="submit" class="btn btn-primary pull-right" value="Sign In" />
                    <!-- <label class="remember-me"><input type="checkbox"> Remember me</label> -->
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        <?php echo $message; ?>
        <p class="pull-right" style=""><a href="http://it.jblfmu.edu.ph" target="blank" style="font-weight:bold;color:#000;">Powered by JBLFMU - IT</a></p>
        <p><a href="reset-password.php" style="color:#000; font-weight:bolder;">Forgot your password?</a></p>
    </div>
</div>

    <script src="js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  </body>
</html>


