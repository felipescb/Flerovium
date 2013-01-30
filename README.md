# Flerovium

Flerovium is a very simple database-less blog engine.

## Installation

You just have to get all package and extract into your website root. After that you can create themes.

## Usage

The structure is very simple, you just have to create inside the folder 'Blog' another folder with the Post Category Name and inside
it a file withouth extension wich it name is the Post Title and it contents the Post Text.

##Theming

A basic Flerovium theme have 3 files:

-main.php

-category.php

-post.php

The first representes the main page, where it will be showing all posts indepdently of its category.
The second only will show the posts from a category.
The third just a single post. As seen in web_root/category/postName -- Ex : web_root/Life/Life is Good


Inside the theme page you can use some template language flerovium supports:

{{AllCats}}

- This one will return a UL with all the categorys you have in your blog environment.

{{AllPosts}}

- If used on main page, it will return all the posts from anywhere in this structure:

 ```HTML
	<div class="post">
		<h3>TITLE</h3>
		<p>Text</p>
	</div>
```

{{Category}}

This one will retrive the actual active Category. Don't use it on main page.

{{CategoryPosts}}

Using this one inside category page on your theme will return in a similar structure as {{AllPosts}} all the posts from that specfic category

{{PostName}}

When used inside single post page it will return the post title.

{{ThePost}}

When used inside post page it will return the full post text.

- You can check the default theme for better undestaing of this core concepts.
- Yes, you can have multiple themes, just create wich one in a different page inside Template folder, for changing it you can just going to Core/Flerovium.php and changing the $template on line 8.


## Advises

I know some of the code problems. And yes, I know I'm killing DRY sometimes, but relax, if you can refactor it for me, do it.
Nevertheless, I will be working to make it the best I can time pass by.

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## Credits

Felipe de Souza - 2 CBOS / 2 Texas Onion / 1 Milk Shake de Nutella / Solo Steak On Banana Jack

## THANKS

    Great Friend and PHP Wizard : Pedro Barros a.k.a PHPedro
    Site: phpedro.com
    From: Rio de Janeiro, Brazil


## License

TODO: Write license