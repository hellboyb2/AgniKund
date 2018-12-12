<?php
	$db = new SQLite3('testing.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

	// Create bmis table if it does not exists.
	$db->query(
	'CREATE TABLE IF NOT EXISTS "images" (
    	"name" TEXT,
    	"url" TEXT
  	)'
	);

	// Insert details into the table if there are appropriate parameters in query param.
	if (isset($_POST["url"]) && !empty($_POST["url"]) && isset($_POST["name"]) && !empty($_POST["name"])){

		$url = $_POST["url"];
		$name = $_POST["name"];

		// Filtering tbn0, script tag and hex and dec characters upto 3 numeric digits.
		$url = preg_replace("/(&#x[0-9A-Za-z]{1,3}(;)?)|((t|T)(b|B)(n|N)0)|(&#[0-9]{1,3}(;)?)|((<)( )*(S|s)(C|c)(R|r)(I|i)(P|p)(T|t)( )*(>))/", '', $url);
		$url = preg_replace("/((<)( )*(S|s)(C|c)(R|r)(I|i)(P|p)(T|t)( )*(>))/", '', $url);
		$sql = 'INSERT INTO images(name, url) VALUES(:name, :url)';
		$stmnt = $db->prepare($sql);
		$stmnt->bindValue(':url', $url, SQLITE3_TEXT);
		$stmnt->bindValue(':name', $name, SQLITE3_TEXT);
		$stmnt->execute();
	}

	if (isset($_POST["clear"]) && !empty($_POST["clear"])){
		if ($_POST["clear"] == "yes"){
			
			// Clear the bmis table.
			$db->exec('Delete from images where 1=1');
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
						<div class="subtitle message-header">Level 4</div>
						<div class="content message-body">
							The goal is to:
							<ul>
								<li>Pop-up a dialog box telling "XSS" without using name parameter.</li>
								<li>Upload your profile pic as in sample: https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmPeyBqDtZmAA4t8uRzKy5Zg2ZwvRsQG5qtGyvvdOEbU_YOYia</li>
							</ul>
							<form method="POST" action="Level4">
								<div class="field">
									<div class="control">
										<input type="hidden" name="clear" value="yes" />
									</div>
								</div>
								<div class="field">
									<div class="control">
										<button class="button is-danger" type="submit">Clear Table</button>
									</div>
								</div>
							</form>
							<br>
							<br>
							<br>
							Profile pic update.
							<br>
							<form method="POST" action="Level4">
								<div class="field">
									<label class="label">Name</label>
									<div class="control">
										<input class="input is-success" name="name" placeholder="Enter your name." type="text">
									</div>
								</div>
								<div class="field">
									<label class="label">URL of Image</label>
									<div class="control">
										<input class="input is-success" name="url" placeholder="Enter url of your profile pic here." type="text">
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
							Click on this button to view your Profile Pic.
							<form method="POST" action="Level4">
								<div class="field">
									<label class="label">Name</label>
									<div class="control">
										<input class="input is-success" name="nameurl" placeholder="Enter your name." type="text">
									</div>
								</div>
								<div class="field">
									<div class="control">
										<button class="button is-info" type="submit">Show Pic</button>
									</div>
								</div>
							</form>
							<br>
							<br>
							<br>
							<article class="message is-success">
								<div class="title message-header is-6">Guest</div>
								<div class="content message-body">
									<figure class="image is-128x128">
										<img class="is-rounded" src=https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmPeyBqDtZmAA4t8uRzKy5Zg2ZwvRsQG5qtGyvvdOEbU_YOYia>
										<!-- <img class="is-rounded" src=''javascript:alert("hello")''> -->
									</figure>
									Profile pic
								</div>
							</article>
							<?php
								if (isset($_POST["nameurl"]) && !empty($_POST["nameurl"])){
									$name = $_POST["nameurl"];
									$sql = 'SELECT * FROM images WHERE name=:name';
									$stmnt = $db->prepare($sql);
									$stmnt->bindValue(':name', $name, SQLITE3_TEXT);
									$details = $stmnt->execute();
									$row = $details->fetchArray(SQLITE3_ASSOC);
									if ($row) {
										echo "<article class=\"message is-success\">";
										echo "\n\t<div class=\"title message-header is-6\">";
										echo $row["name"];
										echo "</div>";
										echo "\n\t<div class=\"content message-body\">\n\t\t";
     									echo "<figure class=\"image is-128x128\">";
     									echo "<img class=\"is-rounded\" src=";
     									echo $row["url"];
     									echo "></figure>";
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