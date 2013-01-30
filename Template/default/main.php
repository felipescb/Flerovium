<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>

	<link rel="stylesheet" href="Template/default/css/normalize.css">
	<link rel="stylesheet" href="Template/default/css/main.css">
</head>
<body>

	<div id="page" class="hfeed site">
		<header class="site-header wrapper" role="banner">
				<div class="row">
				<hgroup>
					<h1 class="site-title"> <a href="index.html" title="Read" rel="home">Flerovium</a> </h1>
					<h2 class="site-description">. . . a simple php blog engine.</h2>
				</hgroup>

				<nav id="site-navigation" class="main-navigation" role="navigation">
					{{AllCats}}
				</nav>
				</div>
		</header>
				<div id="posts">

					<h4>Here go the posts</h4>

					{{AllPosts}}
				</div>

			</div>
		</body>
		</html>