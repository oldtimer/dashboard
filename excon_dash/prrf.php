<?php require_once("inc/_initialize.php"); ?>
<?php include_layout_template('header.php'); ?>
<?php $e = Employees::find_by_user_id($session->user_id); ?>

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
    <script type="text/javascript">
      $(function(){
         $('#toogle-faculty').hide();

         $('#personclass').live('change',function(e){
            var n = $(this).val();

            if (n == 3)
            {
                $("div#toggle-faculty").show();
            }
            else
            {
              $("div#toggle-faculty").hide();
              $("div#toggle-faculty button").removeClass("active");
            }

         });
      });
    </script>

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
                    
                    <li><a href="#" class="hidden-phone visible-tablet visible-desktop" role="button">Settings</a></li>
                    <li id="fat-menu" class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i> <?php echo $e->first_name . " " . $e->surname;  ?>
                            <i class="icon-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="#">My Account</a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" class="visible-phone" href="#">Settings</a></li>
                            <li class="divider visible-phone"></li>
                            <li><a tabindex="-1" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                    
                </ul>
                <a class="brand" href="dashboard.php"><span class="first">JBLFMU</span> <span class="second">Employees Dashboard</span></a>
        </div>
    </div>
    


    
    <div class="sidebar-nav">
        <form class="search form-inline">
            <input type="text" placeholder="Search...">
        </form>

        <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>Dashboard</a>
        <ul id="dashboard-menu" class="nav nav-list collapse in">
            <li><a href="dashboard.php">Home</a></li>
            <li ><a href="prrf.php">Personnel Recruitment</a></li>
            <li ><a href="http://172.16.8.14/eval/main.php">Employee Evaluation</a></li>
            <li ><a href="http://172.16.8.14/acctg/leave/main.php">Leave Management System</a></li>
            <!-- <li class="active"><a href="user.html">Sample Item</a></li>
            <li ><a href="media.html">Media</a></li>
            <li ><a href="calendar.html">Calendar</a></li> -->
            
        </ul>

<!--         <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i>Applications</a>
        <ul id="accounts-menu" class="nav nav-list collapse">
            <li ><a href="http://172.16.8.14/eval/main.php">Employee Evaluation</a></li>
            <li ><a href="http://172.16.8.14/acctg/leave/employees/index.php">Leave</a></li>
        </ul> -->
    </div>
    

    
    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title">Personnel Recruitment Requisition Form</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="dashboard.php">Home</a> <span class="divider">/</span></li>
            <li class="active">Personnel Recruitment Requisition Form</li>
            <!-- <li class="active">Form</li> -->
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">

<form action="generate.php" method="POST">

<div class="btn-toolbar">
    <button class="btn btn-primary" type="submit"><i class="icon-save"></i> Save & Preview</button>
    <!-- <a href="#myModal" data-toggle="modal" class="btn">Delete</a> -->
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">Personnel Information</a></li>
      <li><a href="#minimum-qualification" data-toggle="tab">Minimum Qualification</a></li>
      <li><a href="#employment-details" data-toggle="tab">Employment Details</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
        <label>Unit Assignment</label>
        <div class="btn-group" data-toggle="buttons-radio">
          <button type="button" class="btn btn-primary" name="assign_unit" id="btn-a1" value="A">Arevalo</button>
          <button type="button" class="btn btn-primary" name="assign_unit" id="btn-a2" value="B">Bacolod</button>
          <button type="button" class="btn btn-primary" name="assign_unit" id="btn-a3" value="M">Molo</button>
          <button type="button" class="btn btn-primary" name="assign_unit" id="btn-a5" value="S">System</button>
          <button type="button" class="btn btn-primary" name="assign_unit" id="btn-a4" value="T">Training Center</button>
          <input type="hidden" name="assign_unit" value="" id="btn-assigninput" />
        </div>
        <br />
        <label>Personnel Classification</label>
        <select name="personclass" id="personclass" class="input-xlarge">
          <option value="1">Administrative Staff</option>
          <option value="2">Academic Non-Teaching Staff</option>
          <option value="3">Faculty</option>
        </select>
        <br />
                <div id="toggle-faculty" style="display:none">
          <label>Select Faculty Type</label>
          <div class="btn-group" data-toggle="buttons-radio">

            <button type="button" class="btn btn-primary" name="faculty_type" id="btn-f1" value="1">Full-Time</button>
            <button type="button" class="btn btn-primary" name="faculty_type" id="btn-f2" value="2">Part-time</button>
            <button type="button" class="btn btn-primary" name="faculty_type" id="btn-f3" value="3">General Education</button>
            <button type="button" class="btn btn-primary" name="faculty_type" id="btn-f4" value="4">Professional</button>
            <button type="button" class="btn btn-primary" name="faculty_type" id="btn-f5" value="5">Training Center</button>
            <input type="hidden" name="faculty_type" value="" id="btn-facinput" />
          </div>
        </div>
        <br />
        <label>Position</label>
         <input type="text" class="input-xlarge" name="position" id="position">
        <br />
        <label>Salary Range</label>
         <input type="text" class="input-xlarge" name="salrange" id="salrange">
        <br />
        <br />
        <label>Personnel Category</label>
        <select name="personcat" id="personcat" class="input-xlarge">
          <option value="1">Probationary</option>
          <option value="2">Casual</option>
          <option value="3">Seasonal/Temporary</option>
          <option value="4">Contractual/Daily Paid</option>
        </select>
        <p>&nbsp;</p>
        <label>Department/Office in Need</label>
         <input type="text" class="input-xlarge" name="department_in_need" id="department_in_need">
        <br/>
      </div>


      <div class="tab-pane fade" id="minimum-qualification">
        <label>Gender</label>
        <div class="btn-group" data-toggle="buttons-radio">

          <button type="button" class="btn btn-primary" name="gender" id="btn-g1" value="M">Male</button>
          <button type="button" class="btn btn-primary" name="gender" id="btn-g2" value="F">Female</button>
          <button type="button" class="btn btn-primary" name="gender" id="btn-g3" value="A">Any</button>
          <input type="hidden" name="gender" value="" id="btn-geninput" />
        </div>
        <br />
          <label>Age:</label>
          Minimum: <input type="text" maxlength="3" size="3" name="age_min" class="input-mini" id="age_min">
          Maximum: <input type="text" maxlength="3" size="3" name="age_max" class="input-mini" id="age_max">
        <br />
          <label>Educational Attainment Desired:</label>
          <input type="text" class="input-xlarge" name="educ_attain" id="educ_attain">
        <br />
          <label>Work Experience Desired:</label>
          <textarea id="work_exp" name="work_exp" rows="3" class="input-xlarge">
          </textarea>
        <br />
          <label>Other Qualification (pls. Specify):</label>
          <textarea id="other_qual" name="other_qual" rows="3" class="input-xlarge">
          </textarea>

      </div>



    <div class="tab-pane fade" id="employment-details">
        <label>Employment History with JBLF System (For Rehire) </label>
        <textarea id="employment_history" name="employment_history" rows="3" class="input-xlarge">
        </textarea>
        <br />
          <label>Expected Duration of Employment:</label>
          <input type="text" class="input-xlarge" name="employment_duration" id="employment_duration">
        <br />
          <label>Reason for Hiring:</label>
          <textarea name="hiring_reason" id="hiring_reason" rows="3" class="input-xlarge">
          </textarea>

    </div>
    <script type="text/javascript">
        var fbtns = ['btn-f1','btn-f2','btn-f3','btn-f4','btn-f5'];
        var finput = document.getElementById('btn-facinput');
        
        for (var i=0; i < fbtns.length; i++)
        {
          document.getElementById(fbtns[i]).addEventListener('click',function(){
            finput.value = this.value;
          });
        }


        var gbtns = ['btn-g1','btn-g2','btn-g3'];
        var ginput = document.getElementById('btn-geninput');

        for (var k=0;  k < gbtns.length; k++)
        {
          document.getElementById(gbtns[k]).addEventListener('click',function(){
            ginput.value = this.value;
          });
        }


        var abtns = ['btn-a1','btn-a2','btn-a3','btn-a4','btn-a5'];
        var ainput = document.getElementById('btn-assigninput');
        
        for (var x=0; x < abtns.length; x++)
        {
          document.getElementById(abtns[x]).addEventListener('click',function(){
            ainput.value = this.value;
          });
        }
    </script>
    <input type="hidden" name="myinfo" value="<?php echo $e->first_name ." ". $e->surname; ?>" id="myinfo"/>
    
  </form>

  </div>

</div>



                    
                    <footer>
                        <hr>
                        
                        <p class="pull-right">Powered by<a href="http://it.jblfmu.edu.ph" target="_blank"> SED</a></p>
                        

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


