<?php
	$db = new SQLite3('testing.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

	// Create comments table if it does not exists.
	$db->query(
	'CREATE TABLE IF NOT EXISTS "comments" (
    	"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    	"comment" VARCHAR
  	)'
	);

	// Insert comment into the table if there is a comment in query param.
	if (isset($_POST["comment"]) && !empty($_POST["comment"])){
		$comment = $_POST["comment"];
		$sql = 'INSERT INTO comments(comment) VALUES(:comment_text)';
		$stmnt = $db->prepare($sql);
		$stmnt->bindValue(':comment_text', $comment, SQLITE3_TEXT);
		$stmnt->execute();
	}


	if (isset($_POST["clear"]) && !empty($_POST["clear"])){
		if ($_POST["clear"] == "yes"){
			// Clear the comments table.
			$db->exec('Delete from comments where 1=1');
		}

	}

	// Get all the comments.
	$comments = $db->query('Select * from comments');

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
						<div class="subtitle message-header">Level 1</div>
						<div class="content message-body">
							This is a beginner level Stored XSS challenge. The goal is to pop-up a dialog box telling "XSS".
							<form method="POST" action="Level1">
								<div class="field">
									<div class="control">
										<input type="hidden" name="clear" value="yes" />
									</div>
								</div>
								<div class="field">
									<div class="control">
										<button class="button is-danger" type="submit">Clear Comments</button>
									</div>
								</div>
							</form>
							<br>
							<br>
							<br>
							Please add a review in the comment box below...
							<br>
							<form method="POST" action="Level1">
								<div class="field">
									<label class="label">Review</label>
									<div class="control">
										<textarea name="comment" id="comment" class="textarea is-success" placeholder="Textarea"></textarea>
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
							<article class="message is-success">
								<div class="title message-header is-6">Guest</div>
								<div class="content message-body">
									I am a sample comment.
								</div>
							</article>
							<?php
								while ($row = $comments->fetchArray(SQLITE3_ASSOC)) {
									echo "<article class=\"message is-success\">";
									echo "\n\t<div class=\"title message-header is-6\">Guest</div>";
									echo "\n\t<div class=\"content message-body\">\n\t\t";
     								echo $row["comment"];
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