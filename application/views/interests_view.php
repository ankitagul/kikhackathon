<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>MyTrips</title>
		<meta charset="utf-8"/>
		<link rel= "stylesheet" href="../../css/interest_view.css"/>
	</head>
	
	<Body>
		<header><h1>Welcome <?php echo $username; ?>!</h1>
	    <a href="http://www.kikhackathon.com/index.php/home/logout"><h2> Logout</h2></a>
	    </header>
	   <br/>	   
		<div style="text-align: center;">
			<div style="box-sizing: border-box; display: inline-block; width: 800px; background-color: #FFFFFF; border: 2px solid #0361A8; border-radius: 5px; box-shadow: 0px 0px 8px #0361A8; margin: 80px auto auto;">
				<div style="background: ; padding: 15px">
					<form name="aform" target="_top">
						<?php if(isset($volunteerData)) { ?>
							<table style="width:100%" border="1" class='center'>
								<div style="background: #0361A8; border-radius: 5px 5px 0px 0px; padding: 15px;">
									<span style="font-family: verdana,arial; color: #D4D4D4; font-size: 1.00em; font-weight:bold;">
									Your moments on Sputnik				
									<tr>
											<th>From</th>
											<th>To</th>
											<th>Date</th>
											<th>Delete</th>
									</tr>
									</span>
								</div>
								<?php foreach($volunteerData as $row) { ?>
									<tr>
										<td><?php echo $row->from; ?></td>
										<td><?php echo $row->to; ?></td>
										<td><?php echo $row->date; ?></td>
										<td><a href="http://www.kikhackathon.com/index.php/home/delete?id=<?php echo $row->id; ?>">Delete</a></td>
									</tr>
								<?php } ?>
							</table>
						<?php } ?>					
					</form>
				</div>
			</div> 
		</div>
		<div><Footer>
			&copy; Copyright exist, just ask !! 
		<Footer></div>
	</Body>
</html>