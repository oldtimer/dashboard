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
  			showlist('');
  		});
	
	function showlist(str){
		
		$.ajax({
					url:"emplist.php",
					type: 'GET',
					dataType: 'html',
					data:{
						strname: str
					},
					success: function(data) 
					{
						document.getElementById("select").innerHTML = data;
					}
				});
				
	}
	
	function view(id){
		
		$.ajax({
					url:"userinfo.php",
					type: 'GET',
					dataType: 'html',
					data:{
						uid: id
					},
					success: function(data) 
					{
						document.getElementById("userinfo").innerHTML = data;
						document.getElementById("hid_user_id").value = id;
						document.getElementById("newpwd").value = "";
						document.getElementById("confirmpwd").value = "";
					}
				});
				
	}
	
	function resetpwd(){
				
		var usrID = document.getElementById("hid_user_id").value;
		var newpwd = document.getElementById("newpwd").value;
		var conpwd = document.getElementById("confirmpwd").value;
		
		if (usrID==0){
			alert("Select user to reset!");
			return false;
		}
		
		if (newpwd != conpwd){
			alert("Mismatch passwords!");
			return false;
		}
		
		if(newpwd.length < 6 ){
      alert("Minimum of 6 characters for Passwords is required.");
			return false;
    }
		
		$.ajax({
					url:"resetpwd.php",
					type: 'GET',
					dataType: 'html',
					data:{
						uid: usrID,
						upwd: newpwd
					},
					success: function(data) 
					{
						if(data=="1"){
							alert("Password successfully changed");
						}else{
							alert("Failed!\nUnexpected error!");
						}
					}
				});
				
	}
	

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

            <h1 class="page-title">User Management</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="dashboard.php">Home</a>
             <span class="divider">/</span>
              <li class="active">User Management</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    

<div class="row-fluid">

<div class="row-fluid">
	<div class="block span6" id="userlist" style="float:left;padding:15px;height:280px">
		<div>
		Select Department<br /> 
			<select name="dept" onchange="showlist(this.value)" style="width:320px;">
			<option value="">--All--</option>
			<?php 
				$dpt = New Departments;
				$dp = $dpt->find_all_sorted();
				for($i=0; $i<count($dp); $i++)
					{
						echo "<option value='{$dp[$i]->id}'>";
						echo $dp[$i]->name;
						echo "</option>";
					}
			?>
			</select>
		</div>
		<div id="select"></div>
	</div>
	
	<div class="block span6" id="reset" style="padding:15px;height:280px">
		<div id="userinfo" style="height:70px">
			Name: <br />
			Username: 
		</div>
		<div>
			<table>
				<input type="hidden" id="hid_user_id" value=0>
				<tr>
					<td width="40%">New Password</td>
					<td><input type="password" id="newpwd" /></td>
				</tr>
				<tr>
					<td>Confirm</td>
					<td><input type="password" id="confirmpwd" /></td>
				</tr>
				<tr>
					<td colspan="2" align="right">
						<button type="submit" class="btn" onclick="resetpwd();">Reset Password</button>
					</td>
				</tr>
			</table>
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
