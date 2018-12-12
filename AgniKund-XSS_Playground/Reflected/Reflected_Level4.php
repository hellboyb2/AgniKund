<?php
	$db = new SQLite3('testing.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

	// Create contexts table if it does not exists.
	// At id=1, preinput; id=2, postinput; id=3 filter; id=4 replacement;
	$db->query(
	'CREATE TABLE IF NOT EXISTS "payloads" (
    	"id" INTEGER PRIMARY KEY NOT NULL,
    	"str" VARCHAR
  	)'
	);


	// Insert/Update preinput into db.
	if (isset($_POST["preinput"]) && !empty($_POST["preinput"])){
		$str = $_POST["preinput"];
		if ($str == "no"){
			$str="";
		}

		if ($db->query('Select * from payloads where id=1')->fetchArray(SQLITE3_ASSOC)) {
			$sql = 'UPDATE payloads SET str=:str WHERE id=1';
			$stmnt = $db->prepare($sql);
			$stmnt->bindValue(':str', $str, SQLITE3_TEXT);
			$stmnt->execute();
		}
		else {
			$sql = 'INSERT INTO payloads(id, str) VALUES(1, :str)';
			$stmnt = $db->prepare($sql);
			$stmnt->bindValue(':str', $str, SQLITE3_TEXT);
			$stmnt->execute();
		}
	}

	// Insert/Update postinput into db.
	if (isset($_POST["postinput"]) && !empty($_POST["postinput"])){
		$str = $_POST["postinput"];
		if ($str == "no"){
			$str="";
		}

		if ($db->query('Select * from payloads where id=2')->fetchArray(SQLITE3_ASSOC)) {
			$sql = 'UPDATE payloads SET str=:str WHERE id=2';
			$stmnt = $db->prepare($sql);
			$stmnt->bindValue(':str', $str, SQLITE3_TEXT);
			$stmnt->execute();
		}
		else {
			$sql = 'INSERT INTO payloads(id, str) VALUES(2, :str)';
			$stmnt = $db->prepare($sql);
			$stmnt->bindValue(':str', $str, SQLITE3_TEXT);
			$stmnt->execute();
		}
	}

	// Insert/Update filter into db.
	if (isset($_POST["filter"]) && !empty($_POST["filter"])){
		$str = $_POST["filter"];
		if ($str == "no"){
			$str="";
		}

		if ($db->query('Select * from payloads where id=3')->fetchArray(SQLITE3_ASSOC)) {
			$sql = 'UPDATE payloads SET str=:str WHERE id=3';
			$stmnt = $db->prepare($sql);
			$stmnt->bindValue(':str', $str, SQLITE3_TEXT);
			$stmnt->execute();
		}
		else {
			$sql = 'INSERT INTO payloads(id, str) VALUES(3, :str)';
			$stmnt = $db->prepare($sql);
			$stmnt->bindValue(':str', $str, SQLITE3_TEXT);
			$stmnt->execute();
		}
	}

	// Insert/Update replacement into db.
	if (isset($_POST["replacement"]) && !empty($_POST["replacement"])){
		$str = $_POST["replacement"];
		if ($str == "no"){
			$str="";
		}

		if ($db->query('Select * from payloads where id=4')->fetchArray(SQLITE3_ASSOC)) {
			$sql = 'UPDATE payloads SET str=:str WHERE id=4';
			$stmnt = $db->prepare($sql);
			$stmnt->bindValue(':str', $str, SQLITE3_TEXT);
			$stmnt->execute();
		}
		else {
			$sql = 'INSERT INTO payloads(id, str) VALUES(4, :str)';
			$stmnt = $db->prepare($sql);
			$stmnt->bindValue(':str', $str, SQLITE3_TEXT);
			$stmnt->execute();
		}
	}

	// Get the preinput.
	$preinput = $db->query('Select * from payloads where id=1');
	// Get the postinput.
	$postinput = $db->query('Select * from payloads where id=2');
	// Get the filter.
	$filter = $db->query('Select * from payloads where id=3');
	// Get the replacement.
	$replacement = $db->query('Select * from payloads where id=4');

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
						<div class="title message-header">Reflected XSS</div>
						<div class="subtitle message-header">Level 4</div>
						<div class="content message-body">
							The whole html should be divided into four parts. If any field's value is given as <b>no</b> then it will be kept empty.
							<br>
							<i>{Preinput}preg_replace("/{Filter}/", {Replacement}, {payload}){PostInput}</i>
							<ul>
								<li class="item"><b>Preinput</b>: The part of syntax which should be put before user input.</li>
								<li class="item"><b>Postinput</b>: The part of syntax which should be put after user input.</li>
								<li class="item"><b>Filter</b>: The regex which should be used to filter the user input.</li>
								<li class="item"><b>Replacement</b>: The string which should be used to replace regex-match.</li>
							</ul>
							<br>
							<form method="POST" action="Level4">
								<div class="field">
									<label class="label">Insert <i>Preinput</i> syntax Here...</label>
									<div class="control">
										<textarea name="preinput" id="comment" class="textarea is-success" placeholder="<img src="></textarea>
									</div>
								</div>
								<div class="field">
									<label class="label">Insert <i>Postinput</i> syntax Here...</label>
									<div class="control">
										<textarea name="postinput" id="comment" class="textarea is-success" placeholder="/>"></textarea>
									</div>
								</div>
								<div class="field">
									<label class="label">Insert <i>Filter</i> regex Here...</label>
									<div class="control">
										<textarea name="filter" id="comment" class="textarea is-success" placeholder="['`]|(XSS)"></textarea>
									</div>
								</div>
								<div class="field">
									<label class="label">Insert <i>Replacement</i> string Here...</label>
									<div class="control">
										<input name="replacement" id="comment" class="input is-success" placeholder="_"></input>
									</div>
								</div>
								<div class="field">
									<div class="control">
										<button class="button is-link" type="submit">Submit</button>
									</div>
								</div>
							</form>
							<br>
							<br>
							<form method="GET" action="Level4">
								<div class="field">
									<label class="label">Insert Payload Here...</label>
									<div class="control">
										<textarea name="payload" id="comment" class="textarea is-success" placeholder="Textarea"></textarea>
									</div>
								</div>
								<div class="field">
									<div class="control">
										<button class="button is-link" type="submit">Submit</button>
									</div>
								</div>
							</form>
							<br>
							<br>
							<br>
							<?php

								$row = $preinput->fetchArray(SQLITE3_ASSOC);
								if ($row){
									$tagprefix = $row["str"];
								} else {
									$tagprefix = "";
								}

								$row = $postinput->fetchArray(SQLITE3_ASSOC);
								if ($row){
									$tagpostfix = $row["str"];
								} else {
									$tagpostfix = "";
								}

								$row = $filter->fetchArray(SQLITE3_ASSOC);
								if ($row){
									$filterReg = $row["str"];
								} else {
									$filterReg = "";
								}

								$row = $replacement->fetchArray(SQLITE3_ASSOC);
								if ($row){
									$repl = $row["str"];
								} else {
									$repl = "";
								}

								echo "<article class=\"message is-success\">";
								echo "\n\t<div class=\"title message-header is-6\">Parameters</div>";
								echo "\n\t<div class=\"content message-body\">\n\t\t";
								echo "Preinput: ".htmlentities($tagprefix)."<br>";
								echo "Postinput: ".htmlentities($tagpostfix)."<br>";
								echo "Filter: ".htmlentities($filterReg)."<br>";
								echo "Replacement: ".htmlentities($repl);
								echo "\n\t</div>";
 								echo "\n</article>\n";

								echo "<article class=\"message is-success\">";
								echo "\n\t<div class=\"title message-header is-6\">Playground</div>";
								echo "\n\t<div class=\"content message-body\">\n\t\t";
 								echo $tagprefix;
 								if ($filterReg == "") {
 									echo $_GET["payload"];
 								} else {
 									echo preg_replace($filterReg, $repl, $_GET["payload"]);
 								}
 								echo $tagpostfix;
 								echo "\n\t</div>";
 								echo "\n</article>\n";
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