<html>

	<head>
		<title>Food | ZooDB</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	</head>


	<body>

		<!-- Nav Bar -->
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

		<!-- Search -->
		<div class="container">
			<form method="post">
				Search by Food Name: <input type="text" name="foodName">
				<input type="submit" value="Search"> 
			</form>
		</div>

		<!-- Table and PHP -->
		<div class="container">
			<?php
				// uncomment these to display errors
				//error_reporting(E_ALL); 
				//ini_set('display_errors', 1);

				// open connection
				ini_set("allow_url_fopen", 1);

				// get url variable from config file
				$ini_array = parse_ini_file("config.ini");

				// table
				echo '<table class="table" align="left" cellspacing="5" cellpadding="8">';
				echo '<tr>';
				echo '<td><b>Name</b></td><td><b>Food Type</b></td><td><b>Cost</b></td>';
				echo '</tr>';

				// SEARCHING FOOD BY NAME
				if (isset($_POST['foodName']) && $_POST['foodName'] != '') {

					$foodName = $_POST["foodName"];
					$searchUrl = $ini_array['root'] . '/foods/search/' . $foodName;
					$searchObj = json_decode(file_get_contents($searchUrl), true);

					if($searchObj == null) {

						echo '<tr><td>No results</td><td></td><td></td></tr>';

					} else {
						// create totalCost variable
						$totalCost = 0;

						foreach($searchObj as $result) {

							echo '<tr>';
							echo '<td>' . $result['foodName'] . '</td>';
							echo '<td>' . $result['foodType'] . '</td>';
							echo '<td>' . $result['cost'] . '</td>';
							echo '</tr>';

							// add cost to totalCost
							$totalCost = $totalCost + $result['cost'];

						}

						// print totalCost
						echo '<tr><td></td><td></td><td>Total: $' . $totalCost . '</td></tr>';

					}
					
				} else {

					$url = $ini_array['root'] . '/foods';
					$obj = json_decode(file_get_contents($url), true);

					if($obj == null) {

						echo '<tr><td>No results</td><td></td><td></td></tr>';

					} else {

						$totalCost = 0;

						foreach($obj as $result) {
						
							echo '<tr>';
							echo '<td>' . $result['foodName'] . '</td>';
							echo '<td>' . $result['foodType'] . '</td>';
							echo '<td>' . $result['cost'] . '</td>';
							echo '</tr>';

							$totalCost = $totalCost + $result['cost'];

						}

						echo '<tr><td></td><td></td><td>Total: $' . $totalCost . '</td></tr>';

					}
				}

				echo '</table>';

				// ADDING FOOD 
				// if user has typed
				if (isset($_POST['foodType']) && isset($_POST['foodName']) && isset($_POST['cost'])
					&& $_POST['foodType'] != '' && $_POST['foodName'] != '' && $_POST['cost'] != '') {
					// get variables from input fields
					$foodType = $_POST["foodType"];
					$foodName = $_POST["foodName"];
					$cost = $_POST["cost"];

					// initiate cURL
					$ch = curl_init($url);
				 
					// store data in array for JSON
					// assign variables to corresponding table columns (foodType, foodName, cost)
					$jsonData = array(
					    'foodType' => $foodType,
					    'foodName' => $foodName,
					    'cost' => $cost
					);
					 
					// encode the array into JSON
					$jsonDataEncoded = json_encode($jsonData);
					 
					// tell cURL that we want to send a POST request
					curl_setopt($ch, CURLOPT_POST, 1);
					 
					// attach our encoded JSON string to the POST fields
					curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
					 
					// set the content type to application/json
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

					// prevent cURL from printing result code on page
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					 
					// execute the request
					$result = curl_exec($ch);
					$result = json_decode($result);
					curl_close($ch);

					// refresh page to update table
					echo "<meta http-equiv='refresh' content='0'>";
				}

			?>
		</div>

		<!-- Add food section -->
		<div class="container">
			<h3>Add food</h3>

			<form method="post">
				Food Type: <input type="text" name="foodType"><br>
				Food Name: <input type="text" name="foodName"><br>
				Cost: <input type="text" name="cost"><br><br>
				<input type="submit" value="Add"> 
			</form>
		</div>

	</body>

</html>