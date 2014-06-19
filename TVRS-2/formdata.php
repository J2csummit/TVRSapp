<?php


	session_start();
	if(($_SESSION['valid']) == false || (!isset($_SESSION['valid']))) {
		header('Location: admin.php');
	}

	

	//credentials
	include("tvrs_config.php");

	//connect to db
	$dbc = mysqli_connect (
		$db_host,
		$db_user,
		$db_password,
		$db_name)
	OR die (
		'Could not connect to MySQL: ' . mysqli_connect_error());

	// check for removal
	if($_GET['action'] == 'remove')
	{		
		// check ownership
		if(($_SESSION['valid']) == true && (isset($_SESSION['valid'])))
		{
			switch ($_GET['target'])
			{
    			case "provider":
        			// delete entry
					$query = "DELETE FROM providers WHERE provider_id = '{$_GET['id']}' LIMIT 1";
					$result = @mysqli_query($dbc, $query) or die('Query failed: ' . mysqli_error($dbc));
        			break;
    			case "client":
        			$query = "DELETE FROM clients WHERE client_id = '{$_GET['id']}' LIMIT 1";
					$result = @mysqli_query($dbc, $query) or die('Query failed: ' . mysqli_error($dbc));
        			break;
   				case "service":
        			$query = "DELETE FROM service WHERE service_id = '{$_GET['id']}' LIMIT 1";
					$result = @mysqli_query($dbc, $query) or die('Query failed: ' . mysqli_error($dbc));
        			break;
        		case "receiver":
        			$query = "DELETE FROM receiver WHERE receiver_id = '{$_GET['id']}' LIMIT 1";
					$result = @mysqli_query($dbc, $query) or die('Query failed: ' . mysqli_error($dbc));
        			break;
			}		
			// display confirmation
			echo "<div class=\"alert alert-success\">Your entry has been removed</div>";
		}
	}

	//if addProvB is pressed
	if(isset($_POST['addProvB'])) {

			//Create empty error array
			$error = array();

			//Check for names
			if(empty($_POST['addProv'])) {
				$error['addProv'] = 'Please enter the name of the new provider';
			}

			//If there are no errors
			if(sizeof($error) == 0) {
				$query = "";
				$query = "INSERT INTO providers (
					provider_id,
					provider_name
				) VALUES (
					null,
					'{$_POST['addProv']}'
				)";
				
				mysqli_query($dbc, $query) or die("mysql_insert error".mysqli_error($dbc));
				//echo $query;
				//Display a confirmation
				echo "<div class=\"alert alert-success\">Thank You. Your entry has been submitted.</div>";

			} else {

					foreach($error as $value) {
							echo "<div class=\"alert alert-danger\">";
							echo $value;
							echo "</div>";
					}
			}
		
	}

	//if addClientB is pressed
	if(isset($_POST['addClientB'])) {

			//Create empty error array
			$error = array();

			//Check for names
			if(empty($_POST['addClient'])) {
				$error['addClient'] = 'Please enter the name of the new client';
			}

			//If there are no errors
			if(sizeof($error) == 0) {
				$query = "";
				$query = "INSERT INTO clients (
					client_id,
					client_name
				) VALUES (
					null,
					'{$_POST['addClient']}'
				)";
				
				mysqli_query($dbc, $query) or die("mysql_insert error".mysqli_error($dbc));
				//echo $query;
				//Display a confirmation
				echo "<div class=\"alert alert-success\">Thank You. Your entry has been submitted.</div>";

			} else {

					foreach($error as $value) {
							echo "<div class=\"alert alert-danger\">";
							echo $value;
							echo "</div>";
					}
			}
		
	}

	//if addServB is pressed
	if(isset($_POST['addServB'])) {

			//Create empty error array
			$error = array();

			//Check for names
			if(empty($_POST['addServ'])) {
				$error['addServ'] = 'Please enter the new service';
			}

			//Check for names
			if(empty($_POST['addServCode'])) {
				$error['addServCode'] = 'Please enter the new service code';
			}

			//If there are no errors
			if(sizeof($error) == 0) {
				$query = "";
				$query = "INSERT INTO service (
					service_id,
					service_code,
					service_text
				) VALUES (
					null,
					'{$_POST['addServCode']}',
					'{$_POST['addServ']}'
				)";
				
				mysqli_query($dbc, $query) or die("mysql_insert error".mysqli_error($dbc));
				//echo $query;
				//Display a confirmation
				echo "<div class=\"alert alert-success\">Thank You. Your entry has been submitted.</div>";

			} else {

					foreach($error as $value) {
							echo "<div class=\"alert alert-danger\">";
							echo $value;
							echo "</div>";
					}
			}
		
	}

	//if addReceiverB is pressed
	if(isset($_POST['addReceiverB'])) {

			//Create empty error array
			$error = array();

			//Check for names
			if(empty($_POST['addReceiver'])) {
				$error['addReceiver'] = 'Please the name of the new receiver';
			}

			//If there are no errors
			if(sizeof($error) == 0) {
				$query = "";
				$query = "INSERT INTO receiver (
					receiver_id,
					receiver
				) VALUES (
					null,
					'{$_POST['addReceiver']}'
				)";
				
				mysqli_query($dbc, $query) or die("mysql_insert error".mysqli_error($dbc));
				//echo $query;
				//Display a confirmation
				echo "<div class=\"alert alert-success\">Thank You. Your entry has been submitted.</div>";

			} else {

					foreach($error as $value) {
							echo "<div class=\"alert alert-danger\">";
							echo $value;
							echo "</div>";
					}
			}
		
	}
	//if logout is pressed
	if(isset($_POST['logout'])) {
			session_destroy();
			//echo 'Logged out... Redirecting...';
			header('Location: admin.php');
			//header('Location: admin.php');
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>TVRS Dosage - Admin Portal</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/css.css" media="all">

	</head>


	<body>



		<div class="concolor">
		    <div class="container">
		    	
		    	<div class="row">
		    		<div class="col-md-6 col-xs-6">
		    	<h1>TVRS Dosage</h1>
		    </div>


		    <div class="col-md-6 col-xs-6 right">

		    	<ul class="nav navbar-nav pull-right total2">
		    <?php

		    echo "<li class=\"more\">";
			echo "Hello " . $_SESSION['firstname'] . " " . $_SESSION['lastname'];
			echo '<li>'; 

		?>	

			<form method="post" action="formdata.php">
				<div class="paddbutton">
				<input name = "logout" type="submit" value="Log Out" class="btn btn-success" />
				</div>
			</form>

		</ul>

		

		</div>


		    </div>
		    		</div>
		    	</div>


<!-- Provider -->
		    	<div class="container white">
		    		<div class="row">
		    			<div class="col-md-12 col-xs-12 black">
		    			</div>
		    		</div>
		    		<div class="row">
		    			<div class="col-md-12 col-xs-12"><label><h3>Provider Names:</h3></label></div>
		    			</div>
		    			<div class="row">
		    			<div class="col-md-12 col-xs-12 grey">
		    			</div>
		    		</div>
		    		<div class="row total">
		    			<div class="col-md-1 col-xs-1">
		    				<!-- Empty !-->
		    			</div>
		    		<div class="col-md-2 col-xs-3 text-align dgrey">
		    			<h5>Names:</h5>
		    		</div>
		    		<div class="col-md-8 col-xs-7 scroll">
				<?php 
					$query = "SELECT provider_name, provider_id FROM providers ORDER BY provider_name";
					$result = mysqli_query($dbc, $query) or die('Query failed: ' . mysqli_error($dbc));
					while($row = mysqli_fetch_assoc($result))
					{

  						echo "<a class=\"override-button btn btn-mini btn-danger\" type=\"button\" href=\"formdata.php?action=remove&id={$row['provider_id']}&target=provider\">Del</a>{$row['provider_name']}<br />";
						
					}

				?>
				</select><br /><br />
			</div>
			<div class="col-md-1 col-xs-1">
				<!-- Empty !-->
			</div>

		</div>

			<div class="row total">
				<div class="col-md-1 col-xs-1">
					<!-- Empty !-->
				</div>

				<form method="post" action="formdata.php">
					<div class="col-md-2 col-xs-3 text-align dgrey">
					<h5>New Provider Name:</h5>
				</div>

			
					<input name = "addProv" type ="text" value="" class="col-md-3 col-xs-3 overpadd" />
					<input name = "addProvB" type="submit" value="Add" class="btn btn2 col-md-1 col-xs-2 margbut" />

				
				
				</form>
				

				<div class="col-md-5 col-xs-3">
				<!-- Empty !-->
			</div>


			</div>

	  <div class="row">
				<div class="col-md-12 col-xs-12 midgrey">
					<!-- Empty !-->
				</div>
			</div>

		  </div>


	




<!-- Clients !-->

<div class="container white">
		    		<div class="row">
		    			<div class="col-md-12 col-xs-12 black">
		    			</div>
		    		</div>
		    		<div class="row">
		    			<div class="col-md-12 col-xs-12"><label><h3>Client Names:</h3></label></div>
		    			</div>
		    			<div class="row">
		    			<div class="col-md-12 col-xs-12 grey">
		    			</div>
		    		</div>
		    		<div class="row total">
		    			<div class="col-md-1 col-xs-1">
		    				<!-- Empty !-->
		    			</div>
		    			<div class="col-md-2 col-xs-3 text-align dgrey">
		    				<h5>Names:</h5>
		    		</div>
		    		<div class="col-md-8 col-xs-7 scroll">

				<?php 
					$query = "SELECT client_name, client_id FROM clients ORDER BY client_name";
					$result = mysqli_query($dbc, $query) or die('Query failed: ' . mysqli_error($dbc));
					while($row = mysqli_fetch_assoc($result))
					{
  						echo "<a class=\"override-button btn btn-mini btn-danger\" type=\"button\" href=\"formdata.php?action=remove&id={$row['client_id']}&target=client\">Del</a>{$row['client_name']}<br />";
					}
				?>
				</select><br /><br />
			</div>

				<div class="col-md-1 col-xs-1">
				<!-- Empty !-->
			</div>

		</div>

			<div class="row total">
				<div class="col-md-1 col-xs-1">
					<!-- Empty !-->
				</div>

				<form method="post" action="formdata.php">
					<div class="col-md-2 col-xs-3 text-align dgrey">
					<h5>New Client Name:</h5>
				</div>

				
					<input name = "addClient" type ="text" value="" class="col-md-3 col-xs-3 overpadd" />
					<input name = "addClientB" type="submit" value="Add" class="btn btn2 col-md-1 col-xs-2 margbut" />
				
				</form>
		



				<div class="col-md-5 col-xs-3">
				<!-- Empty !-->
			</div>

	</div>
		

			<div class="row">
				<div class="col-md-12 col-xs-12 midgrey">
					<!-- Empty !-->
				</div>
			</div>


		  </div>
	



<!-- Services !-->				

			<div class="container white">
		    		<div class="row">
		    			<div class="col-md-12 col-xs-12 black">
		    			</div>
		    		</div>
		    		<div class="row">
		    			<div class="col-md-12 col-xs-12"><label><h3>Services:</h3></label></div>
		    			</div>
		    			<div class="row">
		    			<div class="col-md-12 col-xs-12 grey">
		    			</div>
		    		</div>
		    		<div class="row total">
		    			<div class="col-md-1 col-xs-1">
		    				<!-- Empty !-->
		    			</div>
		    			<div class="col-md-2 col-xs-3 text-align dgrey">
		    				<h5>Services:</h5>
		    		</div>
		    		<div class="col-md-8 col-xs-7 scroll">

				<?php 
					$query = "SELECT service_code, service_text, service_id FROM service ORDER BY service_code";
					$result = mysqli_query($dbc, $query);
					while($row = mysqli_fetch_assoc($result))
					{
      					echo "<a class=\"override-button btn btn-mini btn-danger\" type=\"button\" href=\"formdata.php?action=remove&id={$row['service_id']}&target=service\">Del</a>{$row['service_code']} \t {$row['service_text']}<br />";
					}
				?>
					<br />


</div>

<div class="col-md-1 col-xs-1">
				<!-- Empty !-->
			</div>

		</div>

			<div class="row total">
				<div class="col-md-1 col-xs-1">
					<!-- Empty !-->
				</div>

				<form method="post" action="formdata.php">
					<div class="col-md-2 col-xs-3 text-align dgrey">
					<h5>New Service:(Name, Code)</h5>
				</div>
				
					<input name = "addServ" type ="text" value="" class="col-md-2 col-xs-2 overpadd"/>
					<input name = "addServCode" type ="text" value="" class="col-md-2 col-xs-2 overpadd2"/>
					<input name = "addServB" type="submit" value="Add" class="btn btn2 col-md-1 col-xs-2 margbut" />
				
				</form>

				
			



				<div class="col-md-4 col-xs-2">
				<!-- Empty !-->
			</div>
			</div>




			<div class="row">
				<div class="col-md-12 col-xs-12 midgrey">
					<!-- Empty !-->
				</div>
			</div>

		  


		  </div>
	 





<!-- Receivers !-->			

			<div class="container white">
		    		<div class="row">
		    			<div class="col-md-12 col-xs-12 black">
		    			</div>
		    		</div>
		    		<div class="row">

				<div class="col-md-12 col-xs-12"><label><h3><label>Recievers:</h3></label></div>
				</div>
		    			<div class="row">
		    			<div class="col-md-12 col-xs-12 grey">
		    			</div>
		    		</div>
		    		<div class="row total">
		    			<div class="col-md-1 col-xs-1">
		    				<!-- Empty !-->
		    			</div>
		    			<div class="col-md-2 col-xs-3 text-align dgrey">	
						<h5>Who can receive the service:</h5>
						</div>
		    		<div class="col-md-8 col-xs-7 scroll">

				<?php 
					$query = "SELECT receiver, receiver_id FROM receiver ORDER BY receiver_id";
					$result = mysqli_query($dbc, $query);
					while($row = mysqli_fetch_assoc($result))
					{
      					echo "<a class=\"override-button btn btn-mini btn-danger\" type=\"button\" href=\"formdata.php?action=remove&id={$row['receiver_id']}&target=receiver\">Del</a>{$row['receiver']}<br />";
					}
				?>
					<br />
				</div>

				<div class="col-md-1 col-xs-1">
				<!-- Empty !-->
			</div>

		</div>

			<div class="row total">
				<div class="col-md-1 col-xs-1">
					<!-- Empty !-->
				</div>

				<form method="post" action="formdata.php">
					<div class="col-md-2 col-xs-3 text-align dgrey">
					<h5>New Reciever:</h5>
				</div>
				
					<input name = "addReceiver" type ="text" value="" class="col-md-3 col-xs-3 overpadd" />
					<input name = "addReceiverB" type="submit" value="Add" class="btn btn2 col-md-1 col-xs-2 margbut" />
				
				</form>

				

				<div class="col-md-5 col-xs-3">
				<!-- Empty !-->
			</div>
			
			</div>

 <div class="row">
				<div class="col-md-12 col-xs-12 midgrey">
					<!-- Empty !-->
				</div>
			</div>

		  
	 </div>

<!-- Report Button !-->

	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xs-12 center">
				<a href='report.php' class="btn btn-primary btn-lg" roll="button">Get Report</a>
			</div>
		</div>
	</div>


	</body>
</html>