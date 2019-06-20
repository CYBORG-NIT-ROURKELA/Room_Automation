<?php
	session_start();
	if (empty(isset($_SESSION['email'])))
	{
		header('location:index.php?login_error=You have not logged in');
	}	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
        <!-- jQuery library -->
        <script src="bootstrap/js/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <link href="css/index.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>		
		<?php include 'headers.php';?>
		<div class="container-fluid height_df"><br><br><br>
			<?php 
				$thresold = 12;
				include 'dbconnection.php';
					
					$query_dist = "SELECT * from distance_details";
					$query_res_dist = mysqli_query($con, $query_dist) or die(mysqli_error($con));
					$row_d = mysqli_num_rows($query_res_dist);
					while($row_d  >10)
					{
						$query_ = "DELETE FROM distance_details LIMIT 1";
					    $query_res_ = mysqli_query($con, $query_) or die(mysqli_error($con));
					    $row_d = $row_d - 1;
					}
						if($row_d > 0)
						{
							$count = 0;
							$data = mysqli_fetch_array($query_res_dist);
							while($data)
							{
								if($data['distance'] < $thresold)
									$count = $count+1;

								$data=mysqli_fetch_array($query_res_dist);
							}
							if($count >= 5)
								{
									?>
  									<center><h3 style="color: red;">Warning</h3><span class="glyphicon glyphicon-warning-sign" style="color:red;"></span></center>									<center><h3 style="color: red;">There is danger!!</h3></center>

								<?php
									   echo '<script language="javascript">';
									   echo 'alert("DANGER")';
									   echo '</script>';
								}

						}
						mysqli_close($con);
			?>
			<br><br>
			<div style=" height: 800px;">
			<center>
			<table bgcolor="lightgray" border="2px solid green" cellspacing="0" cellpadding="7" width="50%" style="overflow: scroll">
			<caption><center><h1 style="color: black;"><u>Recent Data</u></h1></center></caption>
			<tbody style="overflow-y: auto;">
			<tr bgcolor="yellow">
				<th><b><u><strong>SL NO</strong></u></b></th>
				<th><b><u><strong>TEMPERATURE</strong></u></b></th>
				<th><b><u><strong>HUMIDITY</strong></u></b></th>
				<th><b><u><strong>TIME</strong></u></b></th>
	  		</tr>
	  		</tbody>
					<?php
							include 'dbconnection.php';
							$dt = new DateTime();

							$min = $dt->format('i');
							$hour = $dt->format('H');
							$day = $dt->format('d');
							$month = $dt->format('m');
							
							$query = "SELECT * from details ";
							$query_res = mysqli_query($con, $query) or die(mysqli_error($con));

    						$row = mysqli_num_rows($query_res);
    						
    						 while($row > 10)
    						 {
    						 	$query_del = "DELETE FROM details LIMIT 1";
                                $query_res_del = mysqli_query($con, $query_del) or die(mysqli_error($con));
                                $row = $row-1;
    						 }
    						 if($row > 0)
    						 {
    						 	$ctr = 1;
							 	$row_data=mysqli_fetch_array($query_res);
									while($row_data)
										{
						?>
											<tr bgcolor="#ddd">
											<td><?php echo $ctr ?></td>
											<td><?php echo $row_data['temperature']?></td>
											<td><?php echo $row_data['humidity']?></td>
											<td><?php echo $row_data['time']?></td>
											</tr>
						<?php
												$ctr = $ctr+1;
											$row_data=mysqli_fetch_array($query_res);
									    }

    						 }
    						 else
								{
						?>
									 <tr bgcolor="#ddd">
									   <td colspan="4">NO RECORD FOUND</td>
									</tr>
					    <?php
						       }
						       mysqli_close($con);
						      

							 /*if($row > 0)
							 {
							 	$ctr = 1;//echo "true syntax";
							 	$row_data=mysqli_fetch_array($query_res);
									while($row_data)
										{
												$flag= 0;
												$db_min = $row_data['time'][14].$row_data['time'][15];
												$db_hour = $row_data['time'][11].$row_data['time'][12];
												$db_day = $row_data['time'][8].$row_data['time'][9];	
												$db_month = $row_data['time'][5].$row_data['time'][6];	
												
												if($db_month ==  $month && $db_day ==  $day )
												{
													if($db_hour == $hour)
													{
														if($min <= 59 && ($min - $db_min <= 5))
														{
															$flag = 1;
														}
													}
													else if($hour - $db_hour == 1 && $min <=4)
													{
														$flag = 1;
													}
												}
												
												else if(($day - $db_day == 1) && $db_month ==  $month)
												{
													  if($db_hour == $hour)
													{
														if($min <= 59 && ($min - $db_min <= 5))
														{
															$flag = 1;
														}
													}
													else if($hour - $db_hour == 1 && $min <=4)
													{
														$flag = 1;
													}
												}
												//echo $flag."  ";	
																				//database time modified to get minute
												

												if($flag == 1)
												{
													?>
													<tr bgcolor="#ddd">
														<td><?php echo $ctr ?></td>
														<td><?php echo $row_data['temperature']?></td>
														<td><?php echo $row_data['humidity']?></td>
														<td><?php echo $row_data['time']?></td>
													</tr>
													<?php
														$ctr = $ctr+1;
												}										
										$row_data=mysqli_fetch_array($query_res);
									}
							 }
							 else
								{
									?>
									 <tr bgcolor="#ddd">
									   <td colspan="4">NO RECORD FOUND</td>
									</tr>
							    <?php
						       }*/
						        						
						?>						
			</table></center></div>	
			<center><form action="data_fetch.php" method="POST"><button type="submit" value="submit" name="submit">Refresh</button></form></center>		
		</div><br><br>
		<?php include 'footer.php';?>
	</body>
</html>
