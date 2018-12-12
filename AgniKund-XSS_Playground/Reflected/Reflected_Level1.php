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
						<div class="subtitle message-header">Level 1</div>
						<div class="content message-body">
							This is a beginner level Reflected XSS challenge. The goal is to pop-up a dialog box telling "XSS".
							<br>
							<br>
							<br>
							What do you want me to display on your page, add in the box below...
							<br>
							<form method="GET" action="Level1">
								<div class="field">
									<label class="label">Comment</label>
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
							<?php
								if (isset($_GET["comment"]) && !empty($_GET["comment"])){
									echo "<article class=\"message is-success\">";
									echo "\n\t<div class=\"title message-header is-6\">Guest</div>";
									echo "\n\t<div class=\"content message-body\">\n\t\t";
     								echo $_GET["comment"];
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
