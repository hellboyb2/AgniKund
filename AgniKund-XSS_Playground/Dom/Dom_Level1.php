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
						<div class="title message-header">Dom based XSS</div>
						<div class="subtitle message-header">Level 1</div>
						<div class="content message-body">
							This is a beginner level Dom based XSS challenge. The goal is to pop-up a dialog box telling "XSS".
							<br>
							<br>
							<br>
							<br>
							<article class="message is-success">
								<div id="main" class="title message-header is-6">Guest</div>
								<div class="content message-body">
									I am something generic here.
								</div>
							</article>
							<script>
								var url = document.URL;
								var cnt = url.search("#");
								var name = url.substring(cnt+1);
								document.getElementById("main").innerHTML = decodeURIComponent(name);
							</script>
						</div>
					</article>
				</section>
			</div>
		</div>
	</section>
</body>
</html>
