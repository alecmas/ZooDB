<html>

	<head>
		<title>POST Test</title>
	</head>


	<body>

		<h1 align="center">Zoo DB</h1>
		<h3 align="center">POST Test</h3>

		<table align="center" cellspacing="5" cellpadding="8">
			<tr>
				<td align="center"><a href="index.html">Home</a></td>
				<td align="center"><a href="animals.php">Animals</a></td>
				<td align="center"><a href="postTest.php">POST Test</a></td>
			</tr>
		</table>

		<h3>POST Request Example</h3>

		<form method="post">
			Email: <input type="text" name="email"><br>
			Password: <input type="text" name="password"><br>
			Phone: <input type="text" name="phone"><br>
			City: <input type="text" name="city"><br>
			Country: <input type="text" name="country"><br>
			Address: <input type="text" name="address"><br>
			First Name: <input type="text" name="firstName"><br>
			Last Name: <input type="text" name="lastName"><br>
			<input type="submit">
		</form>

		<?php

			/**  EXAMPLE OF JSON GET REQUEST **/
			ini_set("allow_url_fopen", 1);

			//API Url
			$url = 'http://ec2-52-39-104-102.us-west-2.compute.amazonaws.com/users/register';
			 
			//Initiate cURL.
			$ch = curl_init($url);

			// get variables from input fields
			$email = $_POST["email"];
			$password = $_POST["password"];
			$phone = $_POST["phone"];
			$city = $_POST["city"];
			$country = $_POST["country"];
			$address = $_POST["address"];
			$firstName = $_POST["firstName"];
			$lastName = $_POST["lastName"];

			 
			//The JSON data.
			$jsonData = array(
			    'email' => $email,
			    'password' => $password,
			    'phone' => $phone,
			    'city' => $city,
			    'country' => $country,
			    'address' => $address,
			    'firstName' => $firstName,
			    'lastName' => $lastName
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