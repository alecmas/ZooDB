<html>

	<head>
		<title>Asian Gardens | ZooDB</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	</head>


	<body>

		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="index.html">ZooDB</a>
		    </div>
		    <ul class="nav navbar-nav">
		      <li><a href="/index.html">Home</a></li>
		      <li ><a href="/animals.php">Animals</a></li>
		      <li class="active"><a href="/exhibits.html">Exhibits</a></li>
		      <li><a href="/food.php">Food</a></li>
		      <li><a href="/zookeepers.php">Zookeepers</a></li>
		    </ul>
		  </div>
		</nav>

		<h3>Add an animal</h3>

		<form method="post">
			Food Type: <input type="text" name="foodType"><br>
			Name: <input type="text" name="name"><br><br>
			<input type="submit"> 
		</form>

		<?php

			//error_reporting(E_ALL); 
			//ini_set('display_errors', 1);

			// get url to send JSON requests to
			//print_r(parse_ini_file("config.ini"));

			/**  EXAMPLE OF JSON GET REQUEST **/
			ini_set("allow_url_fopen", 1);

			//API Url
			//$url = 'https://lqqmggiado.localtunnel.me/animals';

			$ini_array = parse_ini_file("config.ini");
			$url = $ini_array['root'] . '/animals';

			// GET ANIMALS
			$obj = json_decode(file_get_contents($url), true);
			//echo $obj['results'];

			echo '<table class="table" align="left" cellspacing="5" cellpadding="8">';
			echo '<tr>';
			echo '<td><b>Name</b></td><td><b>Food Type</b></td>';
			echo '</tr>';

			foreach($obj as $result) {
				if($result['exhibitId'] == 5) {
					echo '<tr>';
					echo '<td>' . $result['name'] . '</td>';
					echo '<td>' . $result['foodType'] . '</td>';
					echo '</tr>';
				}
			

				/* to see all contents of JSON
			    echo 'Food Type: ' . $result['foodType'] . '<br />';
			    echo 'ID: ' . $result['id'] . '<br />';
			    echo 'Name: ' . $result['name'] . '<br />';
			    echo 'Population: ' . $result['population'] . '<br />';
			    echo '<br />';
			    */

			}

			echo '</table>';



			// ADDING ANIMAL 
			if (isset($_POST['foodType']) && isset($_POST['name'])) {
				// get variables from input fields
				$foodType = $_POST["foodType"];
				$name = $_POST["name"];

				//Initiate cURL.
				$ch = curl_init($url);

				// exhibit's id
				$exhibitId = 5;
			 
				//The JSON data.
				$jsonData = array(
				    'foodType' => $foodType,
				    'animalName' => $name,
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