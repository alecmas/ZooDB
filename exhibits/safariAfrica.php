<html>

	<head>
		<title>Safari Africa | ZooDB</title>
	</head>


	<body>

		<h1 align="center">Zoo DB</h1>
		<h3 align="center">Safari Africa</h3>

		<table align="center" cellspacing="5" cellpadding="8">
			<tr>
				<td align="center"><a href="/index.html">Home</a></td>
				<td align="center"><a href="/animals.php">Animals</a></td>
				<td align="center"><a href="/exhibits.php">Exhibits</a></td>
				<td align="center"><a href="/food.php">Food</a></td>
				<td align="center"><a href="/zookeepers.php">Zookeepers</a></td>
				<td align="center"><a href="/postTest.php">POST Test</a></td>
			</tr>
		</table>

		<h3>Add an animal</h3>

		<form method="post">
			Food Type: <input type="text" name="foodType"><br>
			Name: <input type="text" name="name"><br><br>
			<input type="submit">
		</form>

		<h3>Delete an animal</h3>

		<form method="post">
			Animal ID: <input type="text" name="animalId"><br>
			<input type="submit">
		</form>

		<?php

			// get url to send JSON requests to
			//include_once('config.inc.php');

			/**  EXAMPLE OF JSON GET REQUEST **/
			ini_set("allow_url_fopen", 1);

			//API Url
			$url = 'https://lqqmggiado.localtunnel.me/animals';
			 
			//Initiate cURL.
			$ch = curl_init($url);

			// get variables from input fields
			$foodType = $_POST["foodType"];
			$name = $_POST["name"];

			// exhibit's id
			$exhibitId = 1;
		 
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




			// DELETING ANIMALS
			$ch2 = curl_init($url);

			$animalId = $_POST["animalId"];

			$jsonData2 = array (

				'animalId' => $animalId
			);

			$jsonDataEncoded2 = json_encode($jsonData2);

			curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "DELETE");

			$result2 = curl_exec($ch2);

		?>

	</body>

</html>