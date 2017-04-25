<html>

	<head>
		<title>Zookeepers | ZooDB</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	</head>


	<body>

		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="index.html">ZooDB</a>
		    </div>
		    <ul class="nav navbar-nav">
		      <li><a href="index.html">Home</a></li>
		      <li ><a href="animals.php">Animals</a></li>
		      <li><a href="exhibits.html">Exhibits</a></li>
		      <li><a href="food.php">Food</a></li>
		      <li class="active"><a href="zookeepers.php">Zookeepers</a></li>
		    </ul>
		  </div>
		</nav>

		<!-- Search -->
		<div class="container">
			<form method="post">
				Search by Last Name: <input type="text" name="lastName">
				<input type="submit" value="Search"> 
			</form>
		</div>

		<div class="container">
			<?php
				// uncomment these to display errors
				//error_reporting(E_ALL); 
				//ini_set('display_errors', 1);
				ini_set("allow_url_fopen", 1);

				$ini_array = parse_ini_file("config.ini");

				echo '<table class="table" align="left" cellspacing="5" cellpadding="8">';
				echo '<tr>';
				echo '<td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Exhibit ID</b></td>';
				echo '</tr>';

				// SEARCHING ZOOKEEPERS BY LAST NAME
				if (isset($_POST['lastName']) && $_POST['lastName'] != '') {

					$lastName = $_POST["lastName"];
					$searchUrl = $ini_array['root'] . '/zookeepers/search/' . $lastName;
					$searchObj = json_decode(file_get_contents($searchUrl), true);


					if($searchObj == null) {

						echo '<tr><td>No results</td><td></td><td></td></tr>';

					} else {

						foreach($searchObj as $result) {

							echo '<tr>';
							echo '<td>' . $result['firstName'] . '</td>';
							echo '<td>' . $result['lastName'] . '</td>';
							echo '<td>' . $result['exhibitId'] . '</td>';
							echo '</tr>';

						}
					}

				} else {

					$url = $ini_array['root'] . '/zookeepers';
					$obj = json_decode(file_get_contents($url), true);

					if($obj == null) {

						echo '<tr><td>No results</td><td></td><td></td></tr>';

					} else {

						foreach($obj as $result) {
					
							echo '<tr>';
							echo '<td>' . $result['firstName'] . '</td>';
							echo '<td>' . $result['lastName'] . '</td>';
							echo '<td>' . $result['exhibitId'] . '</td>';
							echo '</tr>';

						}
					}
				}

				echo '</table>';



				// ADD ZOOKEEPER
				if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['exhibitId'])) {
					
					$url = $ini_array['root'] . '/zookeepers';

					// get variables from input fields
					$firstName = $_POST["firstName"];
					$lastName = $_POST["lastName"];
					$exhibitId = $_POST["exhibitId"];

					// initiate cURL.
					$ch = curl_init($url);
				 
					// JSON data.
					$jsonData = array(
					    'firstName' => $firstName,
					    'lastName' => $lastName,
					    'exhibitId' => $exhibitId
					);
					 
					// encode the array into JSON.
					$jsonDataEncoded = json_encode($jsonData);
					 
					// tell cURL that we want to send a POST request.
					curl_setopt($ch, CURLOPT_POST, 1);
					 
					// attach our encoded JSON string to the POST fields.
					curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
					 
					// set the content type to application/json
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
					 
					// prevent cURL from printing result code on page
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

					// execute the request
					$result = curl_exec($ch);
					$result = json_decode($result);
					curl_close($ch);

					echo "<meta http-equiv='refresh' content='0'>";
				}

			?>

			<br><br><br><br>
			<p align="center">Safari Africa: 1 | Primate World: 2 | Florida Wildlife: 3 | Wallaroo Station: 4 | Asian Gardens: 5</p>
		</div>

		<div class="container">
			<h3>Add zookeeper</h3>

			<form method="post">
				First Name: <input type="text" name="firstName"><br>
				Last Name: <input type="text" name="lastName"><br>
				Exhibit ID (1-5): <input type="text" name="exhibitId"><br><br>
				<input type="submit" value="Add"> 
			</form>
		</div>

	</body>

</html>