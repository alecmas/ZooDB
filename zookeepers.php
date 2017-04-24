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

		<h3>Add zookeeper</h3>

		<form method="post">
			First Name: <input type="text" name="firstName"><br>
			Last Name: <input type="text" name="lastName"><br>
			Exhibit ID (1-5): <input type="text" name="exhibitId"><br>
			
		
		<p>Safari Africa: 1 | Primate World: 2 | Florida Wildlife: 3 | Wallaroo Station: 4 | Asian Gardens: 5</p>

		<input type="submit"> 

		</form>

		<h3>Search by Last Name</h3>
		<form method="post">
			Last Name: <input type="text" name="lastName"><br><br>
			<input type="submit"> 
		</form>

		<?php

			error_reporting(E_ALL); 
			ini_set('display_errors', 1);
			ini_set("allow_url_fopen", 1);

			$ini_array = parse_ini_file("config.ini");

			echo '<table class="table" align="left" cellspacing="5" cellpadding="8">';
			echo '<tr>';
			echo '<td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Exhibit ID</b></td>';
			echo '</tr>';

			// SEARCHING ZOOKEEPERS BY LAST NAME
			if (isset($_POST['lastName'])) {

				$lastName = $_POST["lastName"];
				$searchUrl = $ini_array['root'] . '/zookeepers/search/' . $lastName;
				$searchObj = json_decode(file_get_contents($searchUrl), true);

				foreach($searchObj as $result) {

					echo '<tr>';
					echo '<td>' . $result['firstName'] . '</td>';
					echo '<td>' . $result['lastName'] . '</td>';
					echo '<td>' . $result['exhibitId'] . '</td>';
					echo '</tr>';

				}

				if($searchObj == null) {
					echo '<p>No results</p>';
				}


			} else {

				$url = $ini_array['root'] . '/zookeepers';
				$obj = json_decode(file_get_contents($url), true);

				foreach($obj as $result) {
				
					echo '<tr>';
					echo '<td>' . $result['firstName'] . '</td>';
					echo '<td>' . $result['lastName'] . '</td>';
					echo '<td>' . $result['exhibitId'] . '</td>';
					echo '</tr>';

				}

				if($obj == null) {
					echo '<p>No results</p>';
				}

			}

			echo '</table>';



			// ADDING ANIMAL 
			if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['exhibitId'])) {
				// get variables from input fields
				$firstName = $_POST["firstName"];
				$lastName = $_POST["lastName"];
				$exhibitId = $_POST["exhibitId"];

				//Initiate cURL.
				$ch = curl_init($url);
			 
				//The JSON data.
				$jsonData = array(
				    'firstName' => $firstName,
				    'lastName' => $lastName,
				    'exhibitId' => $exhibitId
				);
				 
				//Encode the array into JSON.
				$jsonDataEncoded = json_encode($jsonData);
				 
				//Tell cURL that we want to send a POST request.
				curl_setopt($ch, CURLOPT_POST, 1);
				 
				//Attach our encoded JSON string to the POST fields.
				curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
				 
				//Set the content type to application/json
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
				 
				//Execute the request
				$result = curl_exec($ch);
				$result = json_decode($result);
				curl_close($ch);

				echo "<meta http-equiv='refresh' content='0'>";
			}

			
			





		?>

	</body>

</html>