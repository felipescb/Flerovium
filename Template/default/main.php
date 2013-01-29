<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>

	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/main.css">

</head>
<body>

	<header>
		<h1>Welcome to a awesome blog engine</h1>
	</header>

	<nav>
		<h4>Here go the categorys</h4>

		{{AllCats}}

	</nav>

	<div id="posts">
		<h4>Here go the posts</h4>

		{{AllPosts}}
	</div>

</body>
</html>