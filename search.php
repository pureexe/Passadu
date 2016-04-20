<?php

if(!isset($_SESSION)){
    session_start();
}

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
     $query = "SELECT * FROM `item` WHERE CONCAT(`name`,`item_code`) LIKE '%".$valueToSearch."%'";
     $search_result = filterTable($query);
	
}
 else {
    $query = "SELECT * FROM `item`";
    $search_result = filterTable($query);
}


  
// function to connect and execute the query
function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "123456789", "passadu");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}
include 'html_head.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>DATA SEARCH</title>
        <style>    
	    </style>
   
    </head>
    <body>
    	<h3>ค้นหาข้อมูลวัสดุ</h3>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="form-horizontal">

        <div class="form-group">
        <label class="control-label col-md-2" for="u-unit">ค้นหา</label>
        <div class="col-md-4">
            <form action="search.php" method="post">
         <input class="form-control" type="text" name="valueToSearch" placeholder="กรุณาใส่ข้อมูล">
          </div> 
          </div>
            <input class="btn btn-primary" type="submit" name="search" value="ค้นหา"><br><br></center>
        </div>
        
            <h3>ข้อมูลผู้ใช้งาน</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
    			<thead>
                <tr align="center">
                   <th width="41">ลำดับ</th>
                    <th width="111">ชื่อวัสดุ</th>
                    <th width="102">ซีเรียลนัมเบอร์</th>
                    <th width="60">รหัสวัสดุ</th>
                    <th width="106">จำนวนคงเหลือ</th>
                    <th width="190">รายละเอียดวัสดุ</th>
                    <th width="38">ราคา</th>
                    <th width="49">สถานะ</th> 
                  </thead>
    				<tbody>  

   
                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    	<td><?php echo $row['id'];?></td>
                   		<td><?php echo $row['name'];?></td>
                 		<td><?php echo $row['serial_no'];?></td>
                 		<td><?php echo $row['item_code'];?></td>
                  		<td><?php echo $row['in_stock'];?></td>
                  		<td><?php echo $row['item_detail'];?></td>
                  		<td><?php echo $row['price'];?></td>
                     	<td><?php echo $row['item_status'];?></td>
                </tr>
                <?php endwhile;?>
            </table> 
        </form>
        
    </body>
</html>

