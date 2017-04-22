<html>

	<head>
		<title>Animals</title>
	</head>


	<body>

		<h1 align="center">Zoo DB</h1>
		<h3 align="center">Animals</h3>

		<table align="center" cellspacing="5" cellpadding="8">
			<tr>
				<td align="center"><a href="index.html">Home</a></td>
				<td align="center"><a href="animals.php">Animals</a></td>
				<td align="center"><a href="postTest.php">POST Test</a></td>
			</tr>
		</table>

		<?php

			/**  EXAMPLE OF JSON GET REQUEST **/
			ini_set("allow_url_fopen", 1);

			//$url = 'http://ec2-52-39-104-102.us-west-2.compute.amazonaws.com/search/country?country=China&startDate=2017-04-01&endDate=2017-04-04';
			$url = 'https://keddbgwvpf.localtunnel.me/animals';
			$obj = json_decode(file_get_contents($url), true);
			//echo $obj['results'];

			$foodTypeArray = array();
			$nameArray = array();


			echo '<table align="left" cellspacing="5" cellpadding="8">';
			echo '<tr>';
			echo '<td>Name</td><td>Food Type</td><td>Population</td>';
			echo '</tr>';

			foreach($obj as $result) {

				array_push($foodTypeArray, $result['foodType']);
				array_push($nameArray, $result['name']);

				echo '<tr>';
				echo '<td>' . $result['name'] . '</td>';
				echo '<td>' . $result['foodType'] . '</td>';
				echo '<td>' . $result['population'] . '</td>';
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

			// eliminate duplicate food types
			$foodTypeArray = array_unique($foodTypeArray);

			///////////////////////
			// create table of food types
			///////////////////////
			echo '<h3>Animals by Diet</h3>';
			echo '<table align="left" cellspacing="5" cellpadding="8">';

			// create a row for each food type
			foreach($foodTypeArray as $foodType) {
				echo '<tr>';
				echo '<td><b>' . $foodType . '</b></td>';

				// fill in each row with animals that eat that food type
				foreach($obj as $result) {
					if ($result['foodType'] == $foodType) {
						echo '<td>' . $result['name'] . '</td>';
					}
				}
				echo '</tr>';
			}

			echo '</table>';
			///////////////////////





		?>

	</body>

</html>