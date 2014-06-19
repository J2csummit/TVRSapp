<?php 

	// The configuration file
	include('tvrs_config.php');

	// Connecting to the database
	$dbc = mysqli_connect ($db_host, $db_user, $db_password, $db_name) OR die ('Could not connecto to MySQL: ' . mysqli_connect_error());

	// continue session
	session_start();

	// if the submt button has been pressed
	if(isset($_POST['submit'])) 
	{

		// create an empty error array
		$error = array();

		// check for a email
		if(empty($_POST['email']))
		{
			$error['email'] = 'Email is a required field';
		}

		if(empty($_POST['userpass']))
		{
			$error['userpass'] = 'Password is required';
		}

		// check signin credentials
		if(!empty($_POST['email']) && !empty($_POST['userpass']))
		{
			// get user_id from the users table, sha1 encodes passwords
			$query = "SELECT
						user_id,
						firstname,
						lastname
					FROM	
						users
					WHERE	
						email = '{$_POST['email']}' AND userpass = sha1('{$_POST['userpass']}')
					LIMIT 1";
			$result = mysqli_query($dbc, $query);
			$row = mysqli_fetch_assoc($result);

			// if the user is not found
			if(!$row['user_id'])
			{
				$error['user'] = 'Invalid username and/or password';
			}			
		}

		// if there are no errors
		if(sizeof($error) == 0)
		{

			// append user_id to session
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['firstname'] = $row['firstname'];
			$_SESSION['lastname'] = $row['lastname'];
			$_SESSION['valid'] = true;

			// redirect user to profile page
			header("Location: formdata.php");
			exit();
		} else {
			$_SESSION['valid'] = false;
			foreach($error as $value)
			{
				echo "<div class=\"alert alert-danger\">";
				echo $value;
				echo "</div>";
			}
		}
	}

?>

<!DOCTYPE>

<html>

<head>
<title>TVRS Dosage - Admin Page</title>
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
		    	<!-- <img src=""> -->
		    	<div class="row">
		    		<div class="col-md-12 col-xs-12">
		    	<h1>TVRS Dosage</h1>
		    </div>
		    		</div>
		    	</div>
		    </div>




	<!-- content -->
	<div class="container" style="margin-top: 20px">

		<div class="row">
		<div class="col-md-12 col-xs-12 center2">
			<h1> Sign In </h1>
		</div>
	</div>

	<!-- signin form -->
	<form method="post" action="admin.php">

		<!-- email -->
		<div class="form-group">
			<label>Email</label><br />
			<input name="email" type="text" value="<?php echo $_POST['email']; ?>" autocomplete="off" class="form-control" />
			</div>

			<!-- password -->
				<div class="form-group">
					<label for="password">Password</label><br />
					<input id="password" name="userpass" type="password" autocomplete="off" class="form-control" />
				</div>

			<!--- submit button -->
			<div class="form-group">
				<input name="submit" type="submit" value="Sign in" class="btn btn-large btn-primary" />
			</div>
	</form>
	</div>

	</body>
</html>