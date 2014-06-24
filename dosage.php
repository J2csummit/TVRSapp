<!DOCTYPE html>
<html>
	<head>
		<title>TVRS Service Survey</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/css.css" media="all">

	</head>
	<body>



		<?php

			//credentials
			include("tvrs_config.php");

			//connect to db
			$dbc = @mysqli_connect (
				$db_host,
				$db_user,
				$db_password,
				$db_name)
			OR die (
				'Could not connect to MySQL: ' . mysqli_connect_error());

			//if submit is pressed
			if(isset($_POST['submit'])) {

					//Create empty error array
					$error = array();

					//Check for names
					if(empty($_POST['providerName'])) {
						$error['providerName'] = 'Please enter your name';
					}

					if(empty($_POST['clientName'])) {
						$error['clientName'] = 'Please select the client\'s name';
					}

					//Check for services
					if(empty($_POST['service'])) {
						$error['service'] = 'Please select a service';
					}

					//Check for "other"
					if(($_POST['service']) == '15' && empty($_POST['other'])){
					$error['other'] = 'If you have selected "Other" under "Service Provided", please describe the service provided in the text box below';
					}

					if(empty($_POST['receiverGroup'])) {
						$error['receiverGroup'] = 'Please select who is receiving the service';
					}

					//Check for time
					if(empty($_POST['hours'])) {
						$error['hours'] = 'Please enter a value for number of hours';
					}
					if(empty($_POST['minutes'])) {
						$error['minutes'] = 'Please enter a value for number of minutes';
					}

					//Check for method
					if(empty($_POST['method'])) {
						$error['method'] = 'Please select a method';
					}

					//If there are no errors
					if(sizeof($error) == 0) {

						$i = 0;
						$temp = $_POST['receiverGroup'];
						foreach($temp as $each) {
							if($i==0){
								$receiver = $each;
							}else{
								$receiver = $receiver + " , " + $each;
							}
							$i++;
						}

						$elapsedTime = $_POST['hours'] . $_POST['minutes'];

						//Insert a record into the database
						$query = "INSERT INTO dosage (
							entry_id,
							providerName,
							clientName,
							services,
							receiver,
							elapsedTime,
							method,
							activity_date
						) VALUES (
							null,
							'{$_POST['providerName']}',
							'{$_POST['clientName']}',
							'{$_POST['service']}',
							$receiver,
							$elapsedTime,
							'{$_POST['method']}',
							NOW()
						)";
						mysqli_query($dbc, $query);

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

		?>

		    <div class="concolor">
		    <div class="container">
		    	<!-- <img src=""> -->
		    	<div class="row">
		    		<div class="col-md-12 col-xs-12">
		    	<h1>TVRS Service Survey</h1>
		    </div>
		    		</div>
		    	</div>
		    </div>



		<form method="post" action="dosage.php"> 


<div class="container">
	<div class="row">

				
				<div class="col-md-6 background col-xs-12"> 
				<label class="col-md-12 col-xs-12 color h4">Your Name:</label><br />
				<select name = "providerName">
					<?php 
						$query = "SELECT provider_name FROM providers ORDER BY provider_name";
						$result = mysqli_query($dbc, $query) or die('Query failed: ' . mysqli_error($dbc));
						while($row = mysqli_fetch_assoc($result))
						{
      						echo "<option value=\"{$row['provider_name']}\">{$row['provider_name']}</option>";
						}
					?>
				</select><br /><br />
			</div>
		

		
			<div class="col-md-6 col-xs-12">
				<label class="col-md-12 col-xs-12 color h4">Client Name:</label><br />
				<select name = "clientName">
					<?php 
						$query = "SELECT client_name FROM clients ORDER BY client_name";
						$result = mysqli_query($dbc, $query) or die('Query failed: ' . mysqli_error($dbc));
						while($row = mysqli_fetch_assoc($result))
						{
      						echo "<option value=\"{$row['client_name']}\">{$row['client_name']}</option>";
						}
					?>
				</select><br /><br />
			</div>
		
	

</div>
</div>



      <div class="container">
		
			<label class="col-md-12 col-xs-12 color h4">Service provided:</label><br />
			<div class="row">

			<div class="col-md-6 col-xs-12">
				<?php 
					$query = "SELECT service_code, service_text FROM service ORDER BY service_code";
					$result = mysqli_query($dbc, $query);
					$rowcount = mysqli_num_rows($result);
					$i = 0;
					while($row = mysqli_fetch_assoc($result))
					{
      					echo "<input name=\"service\" type=\"radio\" value=\"{$row['service_code']}\">{$row['service_text']}<br />";
      					$i++;

      					if ($i == floor($rowcount / 2)){
      						echo "</div><div class=\"col-md-6 col-xs-12\">";
      					}
					}
				?>
				<br />
				If you selected "Other Services", please describe the service provided
                <br />
				<input name = "other" type ="text" value="" />
                <br />

			</div>
			
	
	</div>
	</div>
	
				<p> </p>


				<div class="container">
					<div class="row">

							<div class="col-md-6 col-xs-12">
				<label class="col-md-12 color h4">Who received the service? (One or more)</label><br />
					<?php 
						$query = "SELECT receiver FROM receiver ORDER BY receiver_id";
						$result = mysqli_query($dbc, $query);
						while($row = mysqli_fetch_assoc($result))
						{
	      					echo "<input name=\"receiverGroup[]\" type=\"checkbox\" value=\"{$row['receiver']}\">{$row['receiver']}<br />";
						}
					?>
					<br />
				</div>


				<div class="col-md-6 col-xs-12">
					<label class="col-md-12 color h4">How was this service provided?</label><br />
				<input name = "method" type="radio" value="Phone" />Phone<br />
				<input name = "method" type="radio" value="In-Person" />In-Person<br />
				<input name = "method" type="radio" value="Group Format" />Group Format<br />
				<input name = "method" type="radio" value="Electronically" />Electronically<br /><br />
			</div>

		
	</div>
	</div>

<div class="container">
	<div class="row">

				
				<div class="col-md-6 col-xs-12 background"> 
				<label class="col-md-12 col-xs-12 color h4">Total Time Providing Services (Hours, Minutes)</label><br />
				<select name = "hours">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>

				<select name = "minutes">
					<option value=":00">:00</option>
					<option value=":01">:01</option>
					<option value=":02">:02</option>
					<option value=":03">:03</option>
					<option value=":04">:04</option>
					<option value=":05">:05</option>
					<option value=":06">:06</option>
					<option value=":07">:07</option>
					<option value=":08">:08</option>
					<option value=":09">:09</option>
					<option value=":10">:10</option>
					<option value=":11">:11</option>
					<option value=":12">:12</option>
					<option value=":13">:13</option>
					<option value=":14">:14</option>
					<option value=":15">:15</option>
					<option value=":16">:16</option>
					<option value=":17">:17</option>
					<option value=":18">:18</option>
					<option value=":19">:19</option>
					<option value=":20">:20</option>
					<option value=":21">:21</option>
					<option value=":22">:22</option>
					<option value=":23">:23</option>
					<option value=":24">:24</option>
					<option value=":25">:25</option>
					<option value=":26">:26</option>
					<option value=":27">:27</option>
					<option value=":28">:28</option>
					<option value=":29">:29</option>
					<option value=":30">:30</option>
					<option value=":31">:31</option>
					<option value=":32">:32</option>
					<option value=":33">:33</option>
					<option value=":34">:34</option>
					<option value=":35">:35</option>
					<option value=":36">:36</option>
					<option value=":37">:37</option>
					<option value=":38">:38</option>
					<option value=":39">:39</option>
					<option value=":40">:40</option>
					<option value=":41">:41</option>
					<option value=":42">:42</option>
					<option value=":43">:43</option>
					<option value=":44">:44</option>
					<option value=":45">:45</option>
					<option value=":46">:46</option>
					<option value=":47">:47</option>
					<option value=":48">:48</option>
					<option value=":49">:49</option>
					<option value=":50">:50</option>
					<option value=":51">:51</option>
					<option value=":52">:52</option>
					<option value=":53">:53</option>
					<option value=":54">:54</option>
					<option value=":55">:55</option>
					<option value=":56">:56</option>
					<option value=":57">:57</option>
					<option value=":58">:58</option>
					<option value=":59">:59</option>
				</select><br /><br />

			</div>
		

		</div>


		<div class="container">
			<div class="row">
				<div class="col-md-12 col-xs-12 right center">
				<button type="submit" class="btn btn-primary padsides down" value="submit">Send</button>
			</div>
		</div>
			
		</div>
		
		
</div>
</div>

</form>







	</body>
</html>