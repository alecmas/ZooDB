<html>

	<head>
		<title>Animals | ZooDB</title>
	</head>


	<body>

		<h1 align="center">Zoo DB</h1>
		<h3 align="center">Animals</h3>

		<table align="center" cellspacing="5" cellpadding="8">
			<tr>
				<td align="center"><a href="index.html">Home</a></td>
				<td align="center"><a href="animals.php">Animals</a></td>
				<td align="center"><a href="exhibits.html">Exhibits</a></td>
				<td align="center"><a href="food.php">Food</a></td>
				<td align="center"><a href="zookeepers.php">Zookeepers</a></td>
			</tr>
		</table>

		<h3>Search an animal</h3>
		<form method="post">
			Animal Name: <input type="text" name="animalName"><br>
			<input type="submit"> 
		</form>

		<?php

			$ini_array = parse_ini_file("config.ini");
			$url = $ini_array['animals'];

			// get url to send JSON requests to
			//include_once('config.inc.php');

			/**  EXAMPLE OF JSON GET REQUEST **/
			ini_set("allow_url_fopen", 1);

			//$url = 'http://ec2-52-39-104-102.us-west-2.compute.amazonaws.com/search/country?country=China&startDate=2017-04-01&endDate=2017-04-04';
			//$url = 'https://lqqmggiado.localtunnel.me/animals';
			$obj = json_decode(file_get_contents($url), true);
			//echo $obj['results'];

			echo '<table align="left" cellspacing="5" cellpadding="8">';
			echo '<tr>';
			echo '<td><b>Name</b></td><td><b>Food Type</b></td>';
			echo '</tr>';

			foreach($obj as $result) {

				echo '<tr>';
				echo '<td>' . $result['name'] . '</td>';
				echo '<td>' . $result['foodType'] . '</td>';
				echo '</tr>';

				/* to see all contents of JSON
			    echo 'Food Type: ' . $result['foodType'] . '<br />';
			    echo 'ID: ' . $result['id'] . '<br />';
			    echo 'Name: ' . $result['name'] . '<br />';
			    echo 'Population: ' . $result['population'] . '<br />';
			    echo '<br />';
			    */

			}

			echo '</table>';



			





		?>

	</body>

</html>