<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Fleroviumm</title>

	<link href='http://fonts.googleapis.com/css_family=Lora:400,700,400italic,700italic.html' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css_family=UnifrakturMaguntia.html' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css_family=Coustard.html' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="Template/default/css/normalize.css">
	<link rel="stylesheet" href="Template/default/css/main.css">
</head>
<body>
	<header class="site-header wrapper">
		<div class="row">
			<hgroup>
				<h1 class="site-title"> <a href="index.html" title="Read" rel="home">Flerovium</a> </h1>
				<h2 class="site-description">. . . a simple php blog engine.</h2>
			</hgroup>

			<nav id="site-navigation" class="main-navigation">
				{{AllCats}}
			</nav>
		</div>
	</header>
	<div id="posts" class='readable-content'>
		{{AllPosts}}
	</div>

</body>
</html>