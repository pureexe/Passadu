<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ระบบบริหารจัดการพัสดุ</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="vendors/datatable/css/jquery.dataTables.css" rel="stylesheet">
    <link href="vendors/datetimepicker/css/datepicker3.css" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datetimepicker/js/bootstrap-datepicker.js"></script>
    <script src="vendors/datetimepicker/js/locales/bootstrap-datepicker.th.js"></script>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      
      <nav class="navbar navbar-inverse navbar-fixed-top" style="background-color: #FF6666">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      
      
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <?php if(!isset($_SESSION['user'])){?>
        <li><a href="login.php">เข้าสู่ระบบ</a></li>
        <?php }else{?>
        <li>
      
        
          <a class="glyphicon glyphicon-user" aria-label="Left Align">&nbsp;<?php echo $_SESSION['user']['firstname'].' '.$_SESSION['user']['lastname'];?> </span></a>
         
        </li>
        <?php }?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
  

  <div class="container">
    <div class="row">
        <div class="col-md-3">

          <?php if(isset($_SESSION['user']) && $_SESSION['user']['user_type']=='admin'){?>
          <div class="list-group">
              <a href="admin_dashboard.php" class="list-group-item">หน้าหลักผู้ดูแลระบบ</a>
			  <a href="search.php" class="list-group-item">ค้นหาข้อมูล</a>
              <a href="admin_user.php" class="list-group-item">จัดการข้อมูลผู้ใช้</a>
              <a href="admin_item.php" class="list-group-item">จัดการข้อมูลวัสดุ</a>
              <a href="admin_unit.php" class="list-group-item">จัดการข้อมูลหน่วย</a>
              <a href="admin_widen.php" class="list-group-item">จัดการข้อมูลการเบิกวัสดุ</a>
              
                          
              
          </div>
          <?php }?>
          
          
		  <?php if(isset($_SESSION['user']) && $_SESSION['user']['user_type']=='user'){?>
          <div class="list-group">
          
          <a href="uesr_item.php" class="list-group-item">รายละเอียดวัสดุ</a>
                           <a href="user_widen.php" class="list-group-item"> เบิกวัสดุ</a>
          </div>
           <?php }?>
          
          <div class="list-group">
            
           
            <?php if(!isset($_SESSION['user'])){?>
            
            &nbsp;
              
            <?php }else{?>
         <a href="logout.php" class="list-group-item">ออกจากระบบ</a>
                          
            <?php }?>
           
          </div>

        </div>
        <div class="col-md-9">