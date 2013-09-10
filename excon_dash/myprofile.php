<?php require_once("inc/_initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("index.php"); } ?>
<?php include_layout_template('header.php'); ?>
<?php 
  $e = Employees::find_by_user_id($session->user_id); 

  $usr = User::find_by_id($session->user_id);


  #print_r($_SESSION);
?>

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

  <script type="text/javascript">

  		$(document).ready(function() {
  			$("#fname").prop('disabled', true);
  			$("#lname").prop('disabled', true);
  			$("#mname").prop('disabled', true);
        $("#email").prop('disabled', true);
  		});


      // EDIT PROFILE
  		$(function(){
  			$("#btn_e").click(function()
  			{
	  			$("#fname").prop('disabled', false);
	  			$("#lname").prop('disabled', false);
	  			$("#mname").prop('disabled', false);
          $("#email").prop('disabled', false);

	  			$("#btn_e").css("display",'none');
          $("#btn_cp").css("display",'none');

          $("#btn_s").css("display",'inline');
          $("#btn_c").css("display",'inline');	  		
  			}
  			);
  		});

      // CANCEL EDIT
      $(function(){
        $("#btn_c").click(function()
        {

          $("#fname").prop('disabled', true);
          $("#lname").prop('disabled', true);
          $("#mname").prop('disabled', true);
          $("#email").prop('disabled', true);

          $("#btn_e").css("display",'inline');
          $("#btn_cp").css("display",'inline');

          $("#btn_s").css("display",'none');
          $("#btn_c").css("display",'none');  

        });
      });


      // SAVE PROFILE
      $(function(){
        $("#btn_s").click(function(){

            var id    = $("#uid").val();
            var fname = $.trim($("#fname").val());
            var lname = $.trim($("#lname").val());
            var mname = $.trim($("#mname").val());
            var email = $.trim($("#email").val());


            if(fname.length > 0 && lname.length > 0)
            {

                var dataString='id='+id+
                                '&fname='+escape(fname)+
                                '&lname='+escape(lname)+
                                '&mname='+mname+
                                '&email='+escape(email);
                $.ajax({
                  type:"POST",
                  url:"update_profile.php",
                  data:dataString,
                  dataType:"json",
                  cache:false,
                  success : function(data)
                  {
                      alert(data.mensahe);
                  }
                });
                // alert("Your Profile was updated.");
            }
            else
            {
              alert("Required data missing!");
            }
        });
      });


      //CHANGE PASSWORD
      $(function(){
        $("#btn_cp").click(function(){
            $("#update_profile").css("display",'none');
            $("#change_password").css("display",'block');
        });
      });

      // CANCEL EDIT
      $(function(){
        $("#btn_cancel_pass").click(function()
        {

            $("#update_profile").css("display",'block');
            $("#change_password").css("display",'none');
        });
      });

      // UPDATE PASSWORD
      $(function(){
        $("#btn_update_pass").click(function()
        {
            var user_id    =    $.trim($("#user_id").val());
            var new_pwd =       $.trim($("#new_pwd").val());
            var old_pwd =       $.trim($("#old_pwd").val());
            var confirm_pwd =   $.trim($("#confirm_pwd").val());

            if(new_pwd.length < 6 )
            {
                alert("Minimum of 6 characters for Passwords is required.");
                return false;
            }

            if( new_pwd.length > 0 && old_pwd.length > 0 && confirm_pwd.length > 0 )
            {
                
                if($("#new_pwd").val() == $("#confirm_pwd").val())
                {

              

                    var dataString='user_id='+user_id+
                                    '&new_pwd='+escape(new_pwd)+
                                    '&old_pwd='+escape(old_pwd)+
                                    '&confirm_pwd='+escape(confirm_pwd);
                    $.ajax({
                      type:"POST",
                      url:"update_password.php",
                      data:dataString,
                      dataType:"json",
                      cache:false,
                      success : function(data)
                      {
                        alert(data.message);
                      }
                    });

                }
                else
                {
                  alert("Passwords do not match. Try again.")
                }
            }
            else
            {
              alert("Required data missing!");
            }



        });
      });

  </script>

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
                    
                    <!-- <li><a href="#" class="hidden-phone visible-tablet visible-desktop" role="button">Settings</a></li> -->
                    <li id="fat-menu" class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i> <?php echo $e->first_name . " " . $e->surname;  ?>
                            <i class="icon-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="myprofile.php">My Profile</a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" class="visible-phone" href="#">Settings</a></li>
                            <li class="divider visible-phone"></li>
                            <li><a tabindex="-1" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                    
                </ul>
                <a class="brand" href="main.php"><span class="first">JBLFMU</span> <span class="second">e-Dashboard</span></a>
        </div>
    </div>
    


    
    <div class="sidebar-nav">
        <form class="search form-inline">
            <input type="text" placeholder="Search...">
        </form>

        <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>Dashboard</a>
        <ul id="dashboard-menu" class="nav nav-list collapse in">
            <li><a href="dashboard.php">Home</a></li>
            <!-- <li ><a href="prrf.php">Personnel Recruitment</a></li> -->
            <li ><a href="../excon_eval/main.php">JePAS</a></li>
             <li ><a href="../excon_leave/main.php">JeLMS</a></li>
             <?php if($_SESSION['user_type'] == 'Root'){ echo '<li><a href="../excon_eval/4dm1n/main.php">4DM1N</a></li> '; } ?>
              <?php if($_SESSION['user_type'] == 'Accounting'){ echo '<li><a href="../excon_eval/accounting_kra/main.php">Accounting</a></li> '; } ?>

        </ul>


<!--         <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i>Applications</a>
        <ul id="accounts-menu" class="nav nav-list collapse">
            <li ><a href="http://172.16.8.14/eval/main.php">Evaluation</a></li>
            <li ><a href="http://172.16.8.14/acctg/leave/employees/index.php">Leave</a></li>
        </ul> -->

    </div>
    

    
    <div class="content">
        
        <div class="header">
            <div class="stats">
<!--     <p class="stat"><span class="number">53</span>tickets</p>
    <p class="stat"><span class="number">27</span>tasks</p>
    <p class="stat"><span class="number">15</span>waiting</p> -->
</div>

            <h1 class="page-title">My Profile</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="dashboard.php">Home</a>
             <span class="divider">/</span>
              <li class="active">My Profile</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    

<div class="row-fluid">

<div class="row-fluid">
    <div class="block span6" id="update_profile">
        <a href="#tablewidget" class="block-heading" data-toggle="collapse">Profile Data</a>
        <div id="tablewidget" class="block-body collapse in">
        	<fieldset style="padding:10px 0px 10px 0px;">
			    <label>Last Name</label>
			    <input type="text" value="<?php echo $e->surname; ?>" name="lname" id="lname">
			    <label>First Name</label>
			    <input type="text" value="<?php echo $e->first_name; ?>" name="fname" id="fname">
			    <label>Middle Name</label>
			    <input type="text" value="<?php echo $e->middle_name; ?>" name="mname" id="mname">
          <label>E-mail Address</label>
          <input type="text" value="<?php echo $e->e_mail; ?>" name="email" id="email">
			    <br>
			    <button type="submit" class="btn btn-primary" id="btn_e">Edit</button>
			    <button type="submit" class="btn btn-primary" id="btn_cp">Change Password</button>
          <button type="submit" class="btn btn-primary" style="display:none" id="btn_s">Save</button>
          <button type="submit" class="btn" style="display:none" id="btn_c">Cancel</button>
          <input type="hidden" id="uid" name="uid" value="<?php echo $e->id; ?>">
  			</fieldset>
        </div>
    </div>   
    <div class="block span6" id="change_password" style="display:none;">
        <a href="#tablewidget" class="block-heading" data-toggle="collapse">Change Password</a>
        <div id="tablewidget" class="block-body collapse in">
          <fieldset style="padding:10px 0px 10px 0px;">
          <legend style="font-size:12px;">Passwords must be at least 6 characters long.</legend>
          <label>Old Password</label>
          <input type="password" value="" name="old_pwd" id="old_pwd">
          <label>New Password</label>
          <input type="password" value="" name="new_pwd" id="new_pwd">
          <label>Confirm Password</label>
          <input type="password" value="" name="confirm_pwd" id="confirm_pwd">
          <br>
          <button type="submit" class="btn btn-primary" id="btn_update_pass">Change Password</button>
          <button type="submit" class="btn"  id="btn_cancel_pass">Cancel</button>
          <input type="hidden" id="user_id" name="user_id" value="<?php echo $session->user_id; ?>">
        </fieldset>
        </div>
    </div>  
</div>
<footer>
    <hr>
    <!-- Purchase a site license to remove this link from the footer: http://www.portnine.com/bootstrap-themes -->
    <p class="pull-right">Powered by<a href="http://it.jblfmu.edu.ph" target="_blank"> JBLFMU-IT</a></p>
    

    <p>&copy; 2013 JBLFMU Employees Portal</p>
</footer>
                    
            </div>
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
