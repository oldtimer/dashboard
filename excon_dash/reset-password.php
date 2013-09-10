<?php 
    require_once("inc/_initialize.php"); 
    //print_r($_SESSION);
    $message="";

    if(isset($_POST['submit']))
    {
        $email = isset($_POST['email-add']) ? htmlentities($_POST['email-add']): "";

        if($_SESSION['secretword'] != $_POST['captcha'])
        {   
            $msg = '<div class="alert alert-error">Phrase does not match. Please try again.<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
        }
        else if(empty($email)) 
        {
            $msg = '<div class="alert alert-info">Email Address is required.<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
        }
        else
        {
            

            $esql = "SELECT user_id FROM employees WHERE e_mail = '{$_POST['email-add']}' LIMIT 1";
            $result = Employees::find_by_sql($esql);

            foreach($result as $r)
            {
                $sql = 'SELECT user_id,user_name FROM users WHERE user_id="'.$r->user_id.'" LIMIT 1';
                $res = User::find_by_sql($sql);
            }
            
            

            if(!empty($res))
            {
                
                foreach($res as $rows)
                {

                    $user = $rows->user_name;
                    $userid = $rows->user_id;
                    $pass = randomPassword();

                    //UPDATE user password
                    /*
                    $pass_update = User::find_by_id($userid);
                    $pass_update->user_password = $pass;
                    $pass_update->update();
                    */


                    $psql = 'UPDATE users SET user_password = password("'.$pass.'") WHERE user_id = '.$userid.'';
                    $res = mysql_query($psql) or die('Last query: ' . $psql . mysql_error());
                    
                    // Generate email

                    $to = $email; // Send email to user
                    $subject = 'jePAS Password Recovery Request'; // Give the email a subject

                    $message = '
                                 
                                 Good Day!

                                 Thank you for using our jePAS System.

                                 Your request for password reset was processed. Details are as follows:
                                 
                                 ------------------------------
                                 Username: '.$user.'
                                 Password: '.$pass.'
                                 ------------------------------

                                 Please change the generated password as soon as you have gained access to your dashboard.

                                 This is an automatically generated message. Please do not respond.


                                 For any questions or concerns, contact your MIS Department:

                                 Thank you.

                                 JBLFMU-IT
                                

                               '; // Our message above including the link


                    $headers = 'From:noreply@foundation.jblfmu.edu.ph' . "\r\n";  //Set fom headers
                    mail($to,$subject,$message,$headers); // send our email


                    $msg =  '<div class="alert alert-success">User Details sent successfully. Please check your email after 2 min.</div>';
                }
            }
            else
            {
                    $msg =  '<div class="alert alert-error">Your email was not found in the database. Contact your MIS Department. <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
            }

        }
                
    }


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>JBLFMU EMPLOYEES PORTAL</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.css">
    
    <link rel="stylesheet" type="text/css" href="css/theme.css">
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">

    <script src="js/jquery-1.8.2.min.js" type="text/javascript"></script>

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
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
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
                <a class="brand" href="index.html"><span class="first">JBLFMU</span> <span class="second">Employees Portal</span></a>
        </div>
    </div>
    


    

    
        <div class="row-fluid">
    <div class="dialog">
        <div class="block">
            <p class="block-heading">Reset your password</p>
            <div class="block-body">
<?php 
                    echo isset($msg) ? $msg : ""; 
?>  
                <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">
                    <label>Email Address</label>
                    <input type="text" class="span12" name="email-add"></input>
                    <div class="captcha">
                    <label>Phrase:</label>
                    <img src="inc/captcha.php" class="span12" id="captcha">
                    <p>
                        <a href="#" onclick="document.getElementById('captcha').src='inc/captcha.php?'+Math.random();document.getElementById('captcha-form').focus();" id="change-image">
                            Not readable? Change text.
                        </a>
                    </p>
                    <label>Enter Phrase:</label>
                    <input type="text" name="captcha" id="captcha-form" class="span12" />
                    </div>
                    <!-- <a href="index.html" class="btn btn-primary pull-right">Send</a> -->
                    <input type="submit" class="btn btn-primary pull-right" name="submit" value="Send">
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        <a href="index.php" style="color:#000; font-weight:bolder;">Sign in to your account</a>
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


