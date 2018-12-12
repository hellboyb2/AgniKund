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
						<li><a class="item" href="index">Home</a></li>
						<li><a class="item" href="Stored">Stored XSS</a></li>
						<li><a class="item" href="Reflected">Reflected XSS</a></li>
						<li><a class="item" href="Dom">DOM Based XSS</a></li>
						<li><a class="item" href="About">About</a></li>
						</ul>
					</ul>
				</div>
					
			</aside>
			<div class="container column">
				<section class="section">
					<article class="message">
						<div class="title message-header">Reflected XSS</div>
						<div class="subtitle message-header">Non-Persistent</div>
						<div class="content message-body">
							<ul class="ul">
							<li><a href="Reflected_XSS/Level1">Introduction</a></li>
							<li><a href="Reflected_XSS/Level2">XSS Contexts</a></li>
							<li><a href="Reflected_XSS/Level3">Tags</a></li>
							<li><a href="Reflected_XSS/Level4">Custom</a></li>
							</ul>
						</div>
					</article>
				</section>
			</div>
		</div>
	</section>
</body>
</html>