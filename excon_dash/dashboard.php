<?php require_once("inc/_initialize.php"); ?>
<?php 
  if (!$session->is_logged_in()) { redirect_to("index.php"); } 
  
?>
<?php include_layout_template('header.php'); ?>
<?php 
  $e = Employees::find_by_user_id($session->user_id); 


  $sql = 'Select * FROM employees WHERE user_id = '.$session->user_id.' ORDER BY id DESC';
     
  $result = Employees::find_by_sql($sql);



  /* GET DH AND SH EMPLOYEE LIST */

  $sql_de = 'Select * FROM employees WHERE dh_id='.$e->id.' OR id='.$e->id.'';
  //echo $sql_de;
  $rec_de = Employees::find_by_sql($sql_de);
  foreach($rec_de as $rows){
    $id_e = $rows->id;    
    $dept_emp[] = "'" . $rows->id . "'";    
  }
  $_SESSION['dept_emps'] = implode(',',$dept_emp);


  $sql_se = 'Select * FROM employees WHERE sh_id='.$e->id.' OR id='.$e->id.'';
  $rec_se = Employees::find_by_sql($sql_se);
  foreach($rec_se as $rows){
    $id_e = $rows->id;    
    $sec_emp[] = "'" . $rows->id . "'";
  }
  $_SESSION['sec_emps'] = implode(',',$sec_emp);




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
<!--    <script type="text/javascript">
      $(function(){
          $('.btn').click(function(){
            $('#myModal').modal('hide');
          });
      });
    </script> -->

  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body> 
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
             <li ><a href="../jeproms/account.php">JePROMS</a></li>
             <?php if($_SESSION['user_type'] == 'Root'){ echo '<li><a href="../excon_eval/4dm1n/main.php">4DM1N</a></li> '; } ?>
              <?php if($_SESSION['user_type'] == 'Accounting'){ echo '<li><a href="../excon_eval/accounting_kra/index.php">Accounting</a></li> '; } ?>

        </ul>
        <br>
        
        <div>
          <a href="#" class="nav-header"><i class="icon-thumbs-up"></i>Last Activity Details</a>
          <ul id="dashboard-menu" class="nav nav-list collapse in">
             <!-- <li style="color:gray;font-size:11px;">Aug 14, 2013 9:31 AM / 172.16.8.14</li> -->
             <?php $la = multiexplode("/",$_SESSION['last_activity']); ?>
             <li style="color:red;font-size:11px;">Activity: <?php echo getStatus($la[0])?></li>
             <li style="color:red;font-size:11px;">Date: <?php echo date('M d, Y h:i:s',strtotime($_SESSION['last_activity_date']));?></li>
             <li style="color:red;font-size:11px;">IP: <?php echo $la[2];?></li>
             <!-- <li style="color:gray;font-size:11px;">$rows</li> -->
          </ul>
        </div>
    </div>

    
    <div class="content">
        
        <div class="header">
            <div class="stats">
<!--     <p class="stat"><span class="number">53</span>tickets</p>
    <p class="stat"><span class="number">27</span>tasks</p>
    <p class="stat"><span class="number">15</span>waiting</p> -->
</div>

            <h1 class="page-title">Welcome to JBLFMU Employee Dashboard</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="dashboard.php">Home</a> <span class="divider">/</span></li>
            <li class="active">Dashboard</li>
        </ul>

        <div class="container-fluid">
        <div class="row-fluid">
        <div class="row-fluid">


      <!-- CHAIRMAN OF THE BOARD ACCOUNT -->
          <div class="block">
              <a href="#page-stats" class="block-heading" data-toggle="collapse">JEPROMS ACTIVITY LOGS</a>
              <div id="page-stats" class="block-body collapse in">
                <div class="stat-widget-container" >
                  <div style="clear: both;"></br></div>
                  <div align="left">



<?php   
    

  //print_r($_SESSION);
    foreach($result as $rows)
    {
      
      //$pci[] = $row

      if($rows->per_cat_id == 6) // COB
      {
?>

                    <?php  
                       
                        $sql = 'SELECT * FROM tblrequest_logs where log_details like "%O:77%" GROUP BY req_id ORDER BY log_date DESC';
                        //$sql = 'SELECT * FROM tblrequest_logs where log_details like "%O:76%" OR log_details like "%O:74%" OR log_details like "%O:1%" GROUP BY date(log_date) DESC';
                        //echo 'COB:' . $sql;
                        $result = RequestLogs::find_by_sql($sql); 
                        if(count($result) > 0):
                    ?>
                    <table border="0" style="font-size:11px; width:690px;" cellpadding="2">
                      <tr>
                        <td colspan="3" style="text-align:center; background-color:#CCC; color:black; font-weight:bolder;">Chairman of the Board</td>
                      </tr> 
                      <tr style="text-align:center;">
                        <td style="text-align:center; background-color:#000; color:white; font-weight:bolder; width:150px;">Date</td>
                        <td style="width:200px; text-align:center; background-color:#000; color:white; font-weight:bolder; width:300px;">Request Details</td>
                        <td style="text-align:center; background-color:#000; color:white; font-weight:bolder; width:150px; ">Actions</td>
                       <!--  <td style="text-align:center; background-color:#000; color:white; font-weight:bolder;">Position</td> -->
                      </tr>
                      <!-- <tr><td colspan="4" style="text-align:center; background-color:#CCC; color:black; font-weight:bolder;">CEO</td></tr>  -->            
<?php 


                             foreach($result as $rows)
                             {
                                $activity = multiexplode(",",$rows->log_details);
?>
                                <?php if($activity[0] =='S:1' || $activity[0] =='S:4' || $activity[0] =='S:9'): ?>
                                <tr>
                                <?php elseif($activity[0] == 'S:2'): ?>
                                <tr>
                                <?php endif; ?>


                                    <td style="text-align:left;"><?php echo date("M d, Y / h:i:s A", strtotime($rows->log_date)); ?></td>
                                    <td style="text-align:left;">
<?php  
                                        $req_details = Request_view::find_by_req_id($rows->req_id);
                                        foreach ($req_details as $key) {
                                            // echo '<p>('.Employees::get_fullname($key->employees_id).')</p>';

                                            // echo '<p>' . $key->item_name . '</p>';
                                            
                                            // echo "<i>".$key->item_specs."</i>";
                                            echo "Item: <b><u>".$key->item_name."</u></b>";
                                            echo '<br>';
                                            echo 'Requested by: <b><u>'.Employees::get_fullname($key->employees_id)."</u></b>";
                                            
                                            
                                            echo '<br>';
                                            
                                        }

?>
                                    </td>
                                    <td style="text-align:left;"><?php echo getRequestStatus($activity[0]); ?></td>
                                 
                                </tr>
                                
<?php  
                             }
?>
                    
                    
                    </table>
<?php
                    else:
                      echo "&nbsp;";
                    endif;
?>
<?php
      } // END CB
      elseif($rows->per_cat_id == 5) // START CEO
      {
?>
<?php  
                        
                        $sql = 'SELECT * FROM tblrequest_logs where log_details like "%O:76%" GROUP BY req_id ORDER BY log_date DESC';
                        //$sql = 'SELECT * FROM tblrequest_logs where log_details like "%O:76%" OR log_details like "%O:74%" OR log_details like "%O:1%" GROUP BY date(log_date) DESC';
                       // echo "CEO: " . $sql;
                        $result = RequestLogs::find_by_sql($sql); 
                        if(count($result) > 0):
?>
                    <table border="1" style="font-size:11px; width:690px;" cellpadding="2">
                      <tr>
                        <td colspan="3" style="text-align:center; background-color:#CCC; color:black; font-weight:bolder;">CEO</td>
                      </tr> 
                      <tr style="text-align:center;">
                        <td style="text-align:center; background-color:#000; color:white; font-weight:bolder; width:150px;">Date</td>
                        <td style="width:200px; text-align:center; background-color:#000; color:white; font-weight:bolder; width:300px;">Request Details</td>
                        <td style="text-align:center; background-color:#000; color:white; font-weight:bolder; width:150px; ">Actions</td>                  
                      </tr>
<?php 
                             foreach($result as $rows)
                             {
                                $activity = multiexplode(",",$rows->log_details);
?>
                                <?php if($activity[0] =='S:1' || $activity[0] =='S:4'): ?>
                                <tr style="background-color:#FFF;">
                                <?php elseif($activity[0] == 'S:2'): ?>
                                <tr style="background-color:#FFF;">
                                <?php endif; ?>


                                    <td style="text-align:left; width:150px;"><?php echo date("M d, Y / h:i:s A", strtotime($rows->log_date)); ?></td>
                                    <td style="text-align:left;">
<?php  
                                        $req_details = Request_view::find_by_req_id($rows->req_id);
                                        foreach ($req_details as $key) {
                                            // echo '<p>('.Employees::get_fullname($key->employees_id).')</p>';

                                            // echo '<p>' . $key->item_name . '</p>';
                                            
                                            // echo "<i>".$key->item_specs."</i>";
                                            echo "Item: <b><u>".$key->item_name."</u></b>";
                                            echo '<br>';
                                            echo 'Requested by: <b><u>'.Employees::get_fullname($key->employees_id)."</u></b>";
                                        }

?>
                                    </td>
                                    <td style="text-align:left;"><?php echo getRequestStatus($activity[0]); ?></td>
                                    <!-- <td style="text-align:left;"><?php echo displayBossPosition($activity[2]); ?></td> -->
                                </tr>
                                
<?php  
                             }
?>     
                    </table>
<?php
                    else:
                      echo "&nbsp;";
                    endif;
?>
<?php
      } // END CB
      elseif($rows->per_cat_id == 1) // ADMINISTRATOR
      {
?>
  <br>   
<?php  
                        //BOSS SPECIAL ACCOUNT
                        $sql = 'SELECT * FROM tblrequest_logs where log_details like "%O:74%" GROUP BY req_id  ORDER BY log_date DESC';
                        //$sql = 'SELECT * FROM tblrequest_logs where log_details like "%O:76%" OR log_details like "%O:74%" OR log_details like "%O:1%" GROUP BY date(log_date) DESC';
                        //echo "ADMINISTRATOR: " . $sql;
                        $result = RequestLogs::find_by_sql($sql); 
                        if(count($result) > 0):
?>
                    <table border="1" style="font-size:11px; width:690px;" cellpadding="2">
                      <tr>
                        <td colspan="3" style="text-align:center; background-color:#CCC; color:black; font-weight:bolder;">ADMINISTRATOR</td>
                      </tr> 
                      <tr style="text-align:center;">
                        <td style="text-align:center; background-color:#000; color:white; font-weight:bolder; width:150px;">Date</td>
                        <td style="width:200px; text-align:center; background-color:#000; color:white; font-weight:bolder; width:300px;">Request Details</td>
                        <td style="text-align:center; background-color:#000; color:white; font-weight:bolder; width:150px; ">Actions</td>                    
                      </tr>
<?php 
                             foreach($result as $rows)
                             {
                                $activity = multiexplode(",",$rows->log_details);
?>
                                <?php if($activity[0] =='S:1' || $activity[0] =='S:4'): ?>
                                <tr style="background-color:#FFF;">
                                <?php elseif($activity[0] == 'S:2'): ?>
                                <tr style="background-color:#FFF;">
                                <?php endif; ?>


                                    <td style="text-align:left;"><?php echo date("M d, Y / h:i:s A", strtotime($rows->log_date)); ?></td>
                                    <td style="text-align:left;">
<?php  
                                        $req_details = Request_view::find_by_req_id($rows->req_id);
                                        foreach ($req_details as $key) {
                                            // echo '<p>('.Employees::get_fullname($key->employees_id).')</p>';

                                            // echo '<p>' . $key->item_name . '</p>';
                                            
                                            // echo "<i>".$key->item_specs."</i>";

                                            echo "Item: <b><u>".$key->item_name."</u></b>";
                                            echo '<br>';
                                            echo 'Requested by: <b><u>'.Employees::get_fullname($key->employees_id)."</u></b>";
                                        }

?>
                                    </td>
                                    <td style="text-align:left;"><?php echo getRequestStatus($activity[0]); ?></td>
                                    <!-- <td style="text-align:left;"><?php echo displayBossPosition($activity[2]); ?></td> -->
                                </tr>
                                
<?php  
                             }
?>     
                    </table>

<?php
                    else:
                      echo "&nbsp;";
                    endif;

?>

<?php

      }// END ADMINISTRATOR
      elseif($rows->per_cat_id == 2) // DH
      {
?>
     
<?php  
                        //BOSS SPECIAL ACCOUNT
                        //$sql = 'SELECT * FROM tblrequest_logs where log_details like "%O:74%" GROUP BY req_id  DESC';
                        $sql = 'SELECT * FROM tblrequest_logs where employee_id IN('.$_SESSION['dept_emps'].')'; 
                        $sql .= ' AND log_details LIKE "%O:'.$e->id.'%"  GROUP BY req_id ORDER BY log_date DESC';
                        //echo "DEPT HEAD: " . $sql;
                        //$sql = 'SELECT * FROM tblrequest_logs where log_details like "%O:76%" OR log_details like "%O:74%" OR log_details like "%O:1%" GROUP BY date(log_date) DESC';
                        $result = RequestLogs::find_by_sql($sql); 
                        if(count($result) > 0):
?>
                          <table border="1" style="font-size:11px; width:690px;" cellpadding="2">
                            <tr>
                              <td colspan="3" style="text-align:center; background-color:#CCC; color:black; font-weight:bolder;">DEPARTMENT HEAD</td>
                            </tr> 
                            <tr style="text-align:center;">
                              <td style="text-align:center; background-color:#000; color:white; font-weight:bolder; width:150px;">Date</td>
                              <td style="width:200px; text-align:center; background-color:#000; color:white; font-weight:bolder; width:300px;">Request Details</td>
                              <td style="text-align:center; background-color:#000; color:white; font-weight:bolder; width:150px; ">Actions</td>                      
                            </tr>
<?php 
                             foreach($result as $rows)
                             {
                                $activity = multiexplode(",",$rows->log_details);
?>
                                <?php if($activity[0] =='S:1' || $activity[0] =='S:4'): ?>
                                <tr style="background-color:#FFF;">
                                <?php elseif($activity[0] == 'S:2'): ?>
                                <tr style="background-color:#FFF;">
                                <?php endif; ?>


                                    <td style="text-align:left;"><?php echo date("M d, Y h:i:s A", strtotime($rows->log_date)); ?></td>
                                    <td style="text-align:left;">
<?php  
                                        $req_details = Request_view::find_by_req_id($rows->req_id);
                                        foreach ($req_details as $key) {
                                            // echo '<p>('.Employees::get_fullname($key->employees_id).')</p>';

                                            // echo '<p>' . $key->item_name . '</p>';
                                            
                                            // echo "<i>".$key->item_specs."</i>";

                                            echo "Item: <b><u>".$key->item_name."</u></b>";
                                            echo '<br>';
                                            echo 'Requested by: <b><u>'.Employees::get_fullname($key->employees_id)."</u></b>";
                                            echo '<br>';
                                        }

?>
                                    </td>
                                    <td style="text-align:left;"><?php echo getRequestStatus($activity[0]); ?></td>
                                    <!-- <td style="text-align:left;"><?php echo displayBossPosition($activity[2]); ?></td> -->
                                </tr>
                                
<?php  
                             }
?>     
                    </table>

<?php
                    else:
                    echo "&nbsp;";
                    endif;
?>


<?php

      }// END DH
      elseif($rows->per_cat_id == 3) // SH
      {
?>
     
<?php  
                        
                        //$sql = 'SELECT * FROM tblrequest_logs where log_details like "%O:74%" GROUP BY req_id  DESC';

                        $sql = 'SELECT * FROM tblrequest_logs where employee_id IN('.$_SESSION['sec_emps'].')';
                        $sql .= ' AND log_details LIKE "%O:'.$e->id.'%" GROUP BY req_id ORDER BY log_date DESC ';

                        
                        // $sql = 'SELECT * FROM tblrequest_logs where employee_id IN('.$_SESSION['sec_emps'].')';
                        // $sql .= ' AND log_details LIKE "%O:'.$e->id.'%" GROUP BY date(log_date) DESC ';
                        //echo "SEC HEAD: " . $sql;


                        //$sql = 'SELECT * FROM tblrequest_logs where log_details like "%O:76%" OR log_details like "%O:74%" OR log_details like "%O:1%" GROUP BY date(log_date) DESC';
                        $result = RequestLogs::find_by_sql($sql);
                        if(count($result) > 0):

?>
                        <table border="1" style="font-size:11px; width:690px;" cellpadding="2">
                          <tr>
                          <td colspan="3" style="text-align:center; background-color:#CCC; color:black; font-weight:bolder;">SECTION HEAD</td>
                          </tr> 
                          <tr style="text-align:center;">
                            <td style="text-align:center; background-color:#000; color:white; font-weight:bolder; width:150px;">Date</td>
                            <td style="width:200px; text-align:center; background-color:#000; color:white; font-weight:bolder; width:300px;">Request Details</td>
                            <td style="text-align:center; background-color:#000; color:white; font-weight:bolder; width:150px; ">Actions</td>                         
                          </tr>
<?php 
                             foreach($result as $rows)
                             {
                                $activity = multiexplode(",",$rows->log_details);
?>
                                <?php if($activity[0] =='S:4'): ?>
                                <tr style="background-color:#FFF;">
                                <?php elseif($activity[0] == 'S:2'): ?>
                                <tr style="background-color:#FFF;">
                                <?php endif; ?>


                                    <td style="text-align:left;"><?php echo date("M d, Y / h:i:s A", strtotime($rows->log_date)); ?></td>
                                    <td style="text-align:left;">
<?php  
                                        $req_details = Request_view::find_by_req_id($rows->req_id);
                                        foreach ($req_details as $key) {
                                            // echo '<p>('.Employees::get_fullname($key->employees_id).')</p>';

                                            // echo '<p>' . $key->item_name . '</p>';
                                            
                                            // echo "<i>".$key->item_specs."</i>";

                                            echo "Item: <b><u>".$key->item_name."</u></b>";
                                            echo '<br>';
                                            echo 'Requested by: <b><u>'.Employees::get_fullname($key->employees_id)."</u></b>";
                                            echo '<br>';
                                        }

?>
                                    </td>
                                    <td style="text-align:left;"><?php echo getRequestStatus($activity[0]); ?></td>
                                    <!-- <td style="text-align:left;"><?php echo displayBossPosition($activity[2]); ?></td> -->
                                </tr>
                                
<?php  
                             }
?>     
                    </table>

<?php  

                    else:
                            echo "&nbsp;";
                    endif;
?>


<?php

      }// END SH
      else
      {
        echo '<p style="text-align:center;">Activity logs not yet available.</p>';
      }
      
    } // END OF FOREACH
?>



                  </div>
                  <div style="clear: both;"></br></div>
                </div>
              </div>
          </div>

    <div class="block">
        <a href="#page-stats" class="block-heading" data-toggle="collapse">ANNOUNCEMENT / ADVISORY</a>
        <div id="page-stats" class="block-body collapse in">
          <div class="stat-widget-container" >
            <div style="clear: both;"></br></div>
            <div align="left">
              <ul>
                <li type="square" >Please be adviced that effective <strong>June 24, 2013</strong> all JBLFMU Executive Council employees are required to use JeLMS for their leave application.</li>
              </ul>
            </div>
            <div style="clear: both;"></br></div>
          </div>
        </div>
    </div>
    <!-- Modal -->
   <!--  <div id="myModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Modal header</h3>
      </div>
      <div class="modal-body">
        <p>One fine body…</p>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div> -->



    <!-- <div class="block">
        <a href="#page-stats" class="block-heading" data-toggle="collapse">Latest Stats</a>
        <div id="page-stats" class="block-body collapse in">

            <div class="stat-widget-container">
                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title">2,500</p>
                        <p class="detail">Accounts</p>
                    </div>
                </div>

                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title">3,299</p>
                        <p class="detail">Subscribers</p>
                    </div>
                </div>

                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title">$1,500</p>
                        <p class="detail">Pending</p>
                    </div>
                </div>

                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title">$12,675</p>
                        <p class="detail">Completed</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div> -->
<!-- 
<div class="row-fluid">
    <div class="block span6">
        <a href="#tablewidget" class="block-heading" data-toggle="collapse">Users<span class="label label-warning">+10</span></a>
        <div id="tablewidget" class="block-body collapse in">
            <table class="table">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Username</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Mark</td>
                  <td>Tompson</td>
                  <td>the_mark7</td>
                </tr>
                <tr>
                  <td>Ashley</td>
                  <td>Jacobs</td>
                  <td>ash11927</td>
                </tr>
                <tr>
                  <td>Audrey</td>
                  <td>Ann</td>
                  <td>audann84</td>
                </tr>
                <tr>
                  <td>John</td>
                  <td>Robinson</td>
                  <td>jr5527</td>
                </tr>
                <tr>
                  <td>Aaron</td>
                  <td>Butler</td>
                  <td>aaron_butler</td>
                </tr>
                <tr>
                  <td>Chris</td>
                  <td>Albert</td>
                  <td>cab79</td>
                </tr>
              </tbody>
            </table>
            <p><a href="users.html">More...</a></p>
        </div>
    </div>
    <div class="block span6">
        <a href="#widget1container" class="block-heading" data-toggle="collapse">Collapsible </a>
        <div id="widget1container" class="block-body collapse in">
            <h2>Using Ruby?</h2>
            <p>This template was developed with <a href="http://middlemanapp.com/" target="_blank">Middleman</a> and includes .erb layouts and views.</p>
            <p>All of the views you see here (sign in, sign up, users, etc) are already split up so you don't have to waste your time doing it yourself!</p>
            <p>The layout.erb file includes the header, footer, and side navigation and all of the views are broken out into their own files.</p>
            <p>If you aren't using Ruby, there is also a set of plain HTML files for each page, just like you would expect.</p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="block span6">
        <div class="block-heading">
            <span class="block-icon pull-right">
                <a href="#" class="demo-cancel-click" rel="tooltip" title="Click to refresh"><i class="icon-refresh"></i></a>
            </span>

            <a href="#widget2container" data-toggle="collapse">History</a>
        </div>
        <div id="widget2container" class="block-body collapse in">
            <table class="table list">
              <tbody>
                  <tr>
                      <td>
                          <p><i class="icon-user"></i> Mark Otto</p>
                      </td>
                      <td>
                          <p>Amount: $1,247</p>
                      </td>
                      <td>
                          <p>Date: 7/19/2012</p>
                          <a href="#">View Transaction</a>
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <p><i class="icon-user"></i> Audrey Ann</p>
                      </td>
                      <td>
                          <p>Amount: $2,793</p>
                      </td>
                      <td>
                          <p>Date: 7/12/2012</p>
                          <a href="#">View Transaction</a>
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <p><i class="icon-user"></i> Mark Tompson</p>
                      </td>
                      <td>
                          <p>Amount: $2,349</p>
                      </td>
                      <td>
                          <p>Date: 3/10/2012</p>
                          <a href="#">View Transaction</a>
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <p><i class="icon-user"></i> Ashley Jacobs</p>
                      </td>
                      <td>
                          <p>Amount: $1,192</p>
                      </td>
                      <td>
                          <p>Date: 1/19/2012</p>
                          <a href="#">View Transaction</a>
                      </td>
                  </tr>
                    
              </tbody>
            </table>
        </div>
    </div>
    <div class="block span6">
        <p class="block-heading">Not Collapsible</p>
        <div class="block-body">
            <h2>Tip of the Day</h2>
            <p>Fava bean jícama seakale beetroot courgette shallot amaranth pea garbanzo carrot radicchio peanut leek pea sprouts arugula brussels sprout green bean. Spring onion broccoli chicory shallot winter purslane pumpkin gumbo cabbage squash beet greens lettuce celery. Gram zucchini swiss chard mustard burdock radish brussels sprout groundnut. Asparagus horseradish beet greens broccoli brussels sprout bitterleaf groundnut cress sweet pepper leek bok choy shallot celtuce scallion chickpea radish pea sprouts.</p>
            <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
        </div>
    </div>
</div> -->


                    
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
        // $("[rel=tooltip]").tooltip();
        // $(function() {
        //     $('.demo-cancel-click').click(function(){return false;});
        // });
    </script>
    <!-- <script src="js/jquery-1.9.0.min.js" type="text/javascript"></script> -->

    <script src="js/jquery.simplemodal.js" type="text/javascript"></script>
    <script src="js/osx.js" type="text/javascript"></script>
  </body>
</html>
