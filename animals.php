<html>

	<head>
		<title>Animals | ZooDB</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	</head>

	<body>

		<!--Nav Bar-->
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="index.html">ZooDB</a>
		    </div>
		    <ul class="nav navbar-nav">
		      <li><a href="index.html">Home</a></li>
		      <li class="active"><a href="animals.php">Animals</a></li>
		      <li><a href="exhibits.html">Exhibits</a></li>
		      <li><a href="food.php">Food</a></li>
		      <li><a href="zookeepers.php">Zookeepers</a></li>
		    </ul>
		  </div>
		</nav>

		<!-- Search -->
		<div class="container">
			<form method="post">
				Search by Animal Name: <input type="text" name="animalName">
				<input type="submit" value="Search"> 
			</form>
		</div>

		<!-- Table and PHP -->
		<div class="container">
			<?php
				// uncomment these to display errors
				//error_reporting(E_ALL); 
				//ini_set('display_errors', 1);

				// allow url connections
				ini_set("allow_url_fopen", 1);

				// read server url from config file
				$ini_array = parse_ini_file("config.ini");

				// build table
				echo '<table class="table" align="left" cellspacing="5" cellpadding="8">';
				echo '<tr>';
				echo '<td><b>Name</b></td><td><b>Food Type</b></td><td><b>Exhibit ID</b></td>';
				echo '</tr>';

				// if user has searched, filter results. else, show all animals
				if (isset($_POST['animalName']) && $_POST['animalName'] != '') {

					// reads user input into animalName variable
					$animalName = $_POST["animalName"];
					// append appropriate url path
					$searchUrl = $ini_array['root'] . '/animals/search/' . $animalName;
					// read JSON object from server (GET request) into searchOb variable
					$searchObj = json_decode(file_get_contents($searchUrl), true);

					// if no response, print No results
					if($searchObj == null) {

						echo '<tr><td>No results</td><td></td><td></td></tr>';

					} else {
						// iterate through results and print each animal
						foreach($searchObj as $result) {

							echo '<tr>';
							echo '<td>' . $result['name'] . '</td>';
							echo '<td>' . $result['foodType'] . '</td>';
							echo '<td>' . $result['exhibitId'] . '</td>';
							echo '</tr>';

						}
					}

				} else {

					// url is less specifc; getting all animals
					$url = $ini_array['root'] . '/animals';
					// read JSON object from server
					$obj = json_decode(file_get_contents($url), true);

					// if no response, print No results
					if($obj == null) {
						
						echo '<tr><td>No results</td><td></td><td></td></tr>';

					} else {
						// iterate through results and print each animal
						foreach($obj as $result) {

							echo '<tr>';
							echo '<td>' . $result['name'] . '</td>';
							echo '<td>' . $result['foodType'] . '</td>';
							echo '<td>' . $result['exhibitId'] . '</td>';
							echo '</tr>';

						}
					}
				}

				echo '</table>';

			?>
			
			<br><br><br><br>
			<p align="center">Safari Africa: 1 | Primate World: 2 | Florida Wildlife: 3 | Wallaroo Station: 4 | Asian Gardens: 5</p>
		</div>

	</body>

</html>