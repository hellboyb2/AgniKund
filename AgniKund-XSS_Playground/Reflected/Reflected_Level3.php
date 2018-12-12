<?php
	$db = new SQLite3('testing.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

	// Create contexts table if it does not exists.
	$db->query(
	'CREATE TABLE IF NOT EXISTS "tags1" (
    	"id" INTEGER PRIMARY KEY NOT NULL,
    	"tag" VARCHAR
  	)'
	);

	// Create contexts table if it does not exists.
	$db->query(
	'CREATE TABLE IF NOT EXISTS "filters" (
    	"id" INTEGER PRIMARY KEY NOT NULL,
    	"filter" VARCHAR
  	)'
	);

	// Insert/Update context into db.
	if (isset($_POST["tag"]) && !empty($_POST["tag"])){
		$tag = $_POST["tag"];

		if ($db->query('Select * from tags1 where id=1')->fetchArray(SQLITE3_ASSOC)) {
			$sql = 'UPDATE tags1 SET tag=:tag WHERE id=1';
			$stmnt = $db->prepare($sql);
			$stmnt->bindValue(':tag', $tag, SQLITE3_TEXT);
			$stmnt->execute();
		}
		else {
			$sql = 'INSERT INTO tags1(id, tag) VALUES(1, :tag)';
			$stmnt = $db->prepare($sql);
			$stmnt->bindValue(':tag', $tag, SQLITE3_TEXT);
			$stmnt->execute();
		}
	}

	// Insert/Update context into db.
	if (isset($_POST["filter"]) && !empty($_POST["filter"])){
		$filter = $_POST["filter"];

		if ($db->query('Select * from filters where id=1')->fetchArray(SQLITE3_ASSOC)) {
			$sql = 'UPDATE filters SET filter=:filter WHERE id=1';
			$stmnt = $db->prepare($sql);
			$stmnt->bindValue(':filter', $filter, SQLITE3_TEXT);
			$stmnt->execute();
		}
		else {
			$sql = 'INSERT INTO filters(id, filter) VALUES(1, :filter)';
			$stmnt = $db->prepare($sql);
			$stmnt->bindValue(':filter', $filter, SQLITE3_TEXT);
			$stmnt->execute();
		}
	}

	// Get the context.
	$tag = $db->query('Select * from tags1 where id=1');

	// Get the filter.
	$filter = $db->query('Select * from filters where id=1');

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
						<div class="subtitle message-header">Level 3</div>
						<div class="content message-body">
							The goal is to pop-up a dialog box telling "XSS".
							<br>
							<section class="section">
								<div class="columns">
									<div class="column is-3">
										<form method="POST" action="Level3">
											<label class="label">Choose Tag</label>
											<div class="field">
												<div class="control">
													<div class="select is-info is-medium is-rounded">
														<select name="tag" >
						  									<option value="tag1">img-src</option>
										  					<option value="tag2">img-onerror</option>
										  					<option value="tag3">&lt;script&gt;</option>
										  					<option value="tag4">input-type</option>
										  					<option value="tag5">input-text-value</option>
										  					<option value="tag6">simple html</option>
														</select>
													</div>
												</div>
											</div>
											<div class="field">
												<div class="control">
													<button class="button is-link" type="submit">Submit</button>
												</div>
											</div>
										</form>
									</div>
									<div class="column">
										<form method="POST" action="Level3">
											<label class="label">Choose Filter</label>
			  								<div class="field">
			  									<div class="control">
			    									<div class="select is-info is-medium is-rounded">
														<select name="filter" >
										  					<option value="filter1">['\"`]</option>
										  					<option value="filter2">((<)( )*(S|s)(C|c)(R|r)(I|i)(P|p)(T|t)( )*(>))</option>
										  					<option value="filter3">(&#x[0-9A-Za-z]{1,3}(;)?)|(&#[0-9]{1,3}(;)?)</option>
										  					<option value="filter4">(S|s)(T|t)(R|r)(I|i)(N|n)(G|g)|(X|x)(S|s){2}</option>
										  					<option value="filter5">(&#x[0-9A-Za-z]{1,3}(;)?)|(&#[0-9]{1,3}(;)?)|['\"`]</option>
										  					<option value="noFilter">No Filter</option>
														</select>
													</div>
												</div>
											</div>
											<div class="field">
												<div class="control">
													<button class="button is-link" type="submit">Submit</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</section>
							<br>
							<br>
							<form method="GET" action="Level3">
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
								$row = $tag->fetchArray(SQLITE3_ASSOC);
								if ($row) {
									if ($row["tag"] == "tag1") {
										$tagprefix = '<img src="';
										$tagpostfix = '" />';
									} elseif ($row["tag"] == "tag2") {
										$tagprefix = '<img src=ab onerror="';
										$tagpostfix = '" />';
									} elseif ($row["tag"] == "tag3") {
										$tagprefix = "<script>";
										$tagpostfix = "</script>";
									} elseif ($row["tag"] == "tag4") {
										$tagprefix = '<input type="';
										$tagpostfix = '">';
									} elseif ($row["tag"] == "tag5") {
										$tagprefix = '<input type="text" value="';
										$tagpostfix = '">';
									} else {
										$tagprefix = "";
										$tagpostfix = "";
									}
     								$row2 = $filter->fetchArray(SQLITE3_ASSOC);
									echo "<article class=\"message is-success\">";
									echo "\n\t<div class=\"title message-header is-6\">Playground: ";
									if ($row2){
									echo "filter = ".$row2["filter"];
									}
									echo "</div>";
									echo "\n\t<div class=\"content message-body\">\n\t\t";
     								echo $tagprefix;
     								if ($row2["filter"] == "noFilter") {
     									echo $_GET["payload"];
     								} else {
     									if ($row2["filter"] == "filter1"){
     										echo preg_replace("/['\"`]/", '', $_GET["payload"]);
     									} elseif ($row2["filter"] == "filter2"){
     										echo preg_replace("/((<)( )*(S|s)(C|c)(R|r)(I|i)(P|p)(T|t)( )*(>))/", '', $_GET["payload"]);
     									} elseif ($row2["filter"] == "filter3"){
     										echo preg_replace("/(&#x[0-9A-Za-z]{1,3}(;)?)|(&#[0-9]{1,3}(;)?)/", '', $_GET["payload"]);
     									} elseif ($row2["filter"] == "filter4"){
     										echo preg_replace("/(S|s)(T|t)(R|r)(I|i)(N|n)(G|g)|(X|x)(S|s){2}/", '', $_GET["payload"]);
     									} elseif ($row2["filter"] == "filter5"){
     										echo preg_replace("/(&#x[0-9A-Za-z]{1,3}(;)?)|(&#[0-9]{1,3}(;)?)|['\"`]/", '', $_GET["payload"]);
     									}
     								}
     								echo $tagpostfix;
     								echo "\n\t</div>";
     								echo "\n</article>\n";
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