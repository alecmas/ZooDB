<html>

	<head>
		<title>Food | ZooDB</title>
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
		      <li class="active"><a href="food.php">Food</a></li>
		      <li><a href="zookeepers.php">Zookeepers</a></li>
		    </ul>
		  </div>
		</nav>

		<h3>Add food</h3>

		<form method="post">
			Food Type: <input type="text" name="foodType"><br>
			Food Name: <input type="text" name="foodName"><br>
			Cost: <input type="text" name="cost"><br><br>
			<input type="submit"> 
		</form>

		<h3>Search by Food Name</h3>
		<form method="post">
			Food Name: <input type="text" name="foodName"><br><br>
			<input type="submit"> 
		</form>

		<?php

			error_reporting(E_ALL); 
			ini_set('display_errors', 1);
			ini_set("allow_url_fopen", 1);

			$ini_array = parse_ini_file("config.ini");

			echo '<table class="table" align="left" cellspacing="5" cellpadding="8">';
			echo '<tr>';
			echo '<td><b>Food Name</b></td><td><b>Food Type</b></td><td><b>Cost</b></td>';
			echo '</tr>';

			// SEARCHING FOOD BY NAME
			if (isset($_POST['foodName'])) {

				$foodName = $_POST["foodName"];
				$searchUrl = $ini_array['root'] . '/foods/search/' . $foodName;
				$searchObj = json_decode(file_get_contents($searchUrl), true);

				foreach($searchObj as $result) {

					echo '<tr>';
					echo '<td>' . $result['foodName'] . '</td>';
					echo '<td>' . $result['foodType'] . '</td>';
					echo '<td>' . $result['cost'] . '</td>';
					echo '</tr>';

				}

				if($searchObj == null) {
					echo '<p>No results</p>';
				}

			} else {

				$url = $ini_array['root'] . '/foods';
				$obj = json_decode(file_get_contents($url), true);

				foreach($obj as $result) {
				
					echo '<tr>';
					echo '<td>' . $result['foodName'] . '</td>';
					echo '<td>' . $result['foodType'] . '</td>';
					echo '<td>' . $result['cost'] . '</td>';
					echo '</tr>';

				}

				if($obj == null) {
					echo '<p>No results</p>';
				}

			}

			echo '</table>';



			// ADDING ANIMAL 
			if (isset($_POST['foodType']) && isset($_POST['foodName']) && isset($_POST['cost'])) {
				// get variables from input fields
				$foodType = $_POST["foodType"];
				$foodName = $_POST["foodName"];
				$cost = $_POST["cost"];

				//Initiate cURL.
				$ch = curl_init($url);
			 
				//The JSON data.
				$jsonData = array(
				    'foodType' => $foodType,
				    'foodName' => $foodName,
				    'cost' => $cost
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