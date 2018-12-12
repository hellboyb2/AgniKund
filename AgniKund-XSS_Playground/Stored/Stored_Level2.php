<?php
	$db = new SQLite3('testing.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

	// Create bmis table if it does not exists.
	$db->query(
	'CREATE TABLE IF NOT EXISTS "bmis" (
    	"name" TEXT,
    	"height" REAL,
    	"weight" REAL
  	)'
	);

	// Insert details into the table if there are appropriate parameters in query param.
	if (isset($_POST["height"]) && !empty($_POST["height"]) && isset($_POST["weight"]) && !empty($_POST["weight"]) && isset($_POST["name"]) && !empty($_POST["name"])){

		$height = $_POST["height"];
		$weight = $_POST["weight"];
		$name = $_POST["name"];

		// Filtering ',"and`.
		if (!(preg_match("/['\"`]/", $name))) {
		$sql = 'INSERT INTO bmis(name, height, weight) VALUES(:name, :height, :weight)';
		$stmnt = $db->prepare($sql);
		$stmnt->bindValue(':height', $height);
		$stmnt->bindValue(':weight', $weight);
		$stmnt->bindValue(':name', $name, SQLITE3_TEXT);
		$stmnt->execute();
		
		}
	}

	if (isset($_POST["clear"]) && !empty($_POST["clear"])){
		if ($_POST["clear"] == "yes"){
			
			// Clear the bmis table.
			$db->exec('Delete from bmis where 1=1');
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AgniKund</title>
	<style type="text/css"><?php include 'node_modules/bulma/css/bulma.css'; ?></style>
</head>
<body>

	<section class="hero is-primary">
		<div class="hero-body">
			<div class="container">
				<h1 class="title is-1">
					AgniKund
				</h1>
				<h2 class="subtitle">
					XSS Playground...
				</h2>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="columns">
			<aside class="column menu is-2 aside">
				<div>
					<div class="main menu-list">
						<ul>
						<li><a class="item" href="../index">Home</a></li>
						<li><a class="item" href="../Stored">Stored XSS</a></li>
						<li><a class="item" href="../Reflected">Reflected XSS</a></li>
						<li><a class="item" href="../Dom">DOM Based XSS</a></li>
						<li><a class="item" href="../About">About</a></li>
						</ul>
					</ul>
				</div>
					
			</aside>
			<div class="container column">
				<section class="section">
					<article class="message">
						<div class="title message-header">Stored XSS</div>
						<div class="subtitle message-header">Level 2</div>
						<div class="content message-body">
							The goal is to pop-up a dialog box telling "XSS".
							<form method="POST" action="Level2">
								<div class="field">
									<div class="control">
										<input type="hidden" name="clear" value="yes" />
									</div>
								</div>
								<div class="field">
									<div class="control">
										<button class="button is-danger" type="submit">Clear User Details</button>
									</div>
								</div>
							</form>
							<br>
							<br>
							<br>
							Please add your details in the boxes below...
							<br>
							<form method="POST" action="Level2">
								<div class="field">
									<label class="label">Name</label>
									<div class="control">
										<input class="input is-success" name="name" placeholder="Enter your name." type="text">
									</div>
								</div>
								<div class="field">
									<label class="label">Height</label>
									<div class="control">
										<input class="input is-success" name="height" placeholder="Enter your height in metre." type="text">
									</div>
								</div>
								<div class="field">
									<label class="label">Weight</label>
									<div class="control">
										<input class="input is-success" name="weight" placeholder="Enter your weight in kg." type="text">
									</div>
								</div>
								<div class="field">
									<div class="control">
										<button class="button is-link" type="submit">Save Details</button>
									</div>
								</div>
							</form>
							<br>
							<br>
							Click on this button to know your Body-Mass Index...
							<form method="POST" action="Level2">
								<div class="field">
									<label class="label">Name</label>
									<div class="control">
										<input class="input is-success" name="namebmi" placeholder="Enter your name." type="text">
									</div>
								</div>
								<div class="field">
									<div class="control">
										<button class="button is-info" type="submit">Calculate BMI</button>
									</div>
								</div>
							</form>
							<br>
							<br>
							<br>
							<?php
								if (isset($_POST["namebmi"]) && !empty($_POST["namebmi"])){
									$name = $_POST["namebmi"];
									$sql = 'SELECT * FROM bmis WHERE name=:name';
									$stmnt = $db->prepare($sql);
									$stmnt->bindValue(':name', $name, SQLITE3_TEXT);
									$details = $stmnt->execute();
									$row = $details->fetchArray(SQLITE3_ASSOC);
									if ($row) {
										echo "<article class=\"message is-success\">";
										echo "\n\t<div class=\"title message-header is-6\">BMI of \"";
										echo $row["name"];
										echo "\"</div>";
										echo "\n\t<div class=\"content message-body\">\n\t\t";
     									echo $row["weight"] / ($row["height"] * $row["height"]);
     									echo "\n\t</div>";
     									echo "\n</article>\n";
     								} else {
										echo "<article class=\"message is-success\">";
										echo "\n\t<div class=\"title message-header is-6\">The given user's details does not exist.</div>";
     								}
     							}
							?>
						</div>
					</article>
				</section>
			</div>
		</div>
	</section>
</body>
</html>

<?php
	// Close the connection
	$db->close();

?>