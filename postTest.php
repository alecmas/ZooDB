<html>

	<head>
		<title>POST Test | ZooDB</title>
	</head>


	<body>

		<h1 align="center">Zoo DB</h1>
		<h3 align="center">POST Test</h3>

		<table align="center" cellspacing="5" cellpadding="8">
			<tr>
				<td align="center"><a href="index.html">Home</a></td>
				<td align="center"><a href="animals.php">Animals</a></td>
				<td align="center"><a href="exhibits.html">Exhibits</a></td>
				<td align="center"><a href="food.php">Food</a></td>
				<td align="center"><a href="zookeepers.php">Zookeepers</a></td>
				<td align="center"><a href="postTest.php">POST Test</a></td>
			</tr>
		</table>

		<h3>POST Request Example</h3>

		<form method="post">
			Food Type: <input type="text" name="foodType"><br>
			Name: <input type="text" name="name"><br>
			Exhibit ID: <input type="text" name="exhibitId"><br>
			<input type="submit">
		</form>

		<?php

			/**  EXAMPLE OF JSON GET REQUEST **/
			ini_set("allow_url_fopen", 1);

			//API Url
			$url = 'https://qzmjmrgdnq.localtunnel.me/animals';
			 
			//Initiate cURL.
			$ch = curl_init($url);

			// get variables from input fields
			$foodType = $_POST["foodType"];
			$name = $_POST["name"];
			$exhibitId = $_POST["exhibitId"];

			 
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

		?>

	</body>

</html>