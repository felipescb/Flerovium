<?php

class Flerovium
{

	private $category;
	private $post;
	private $theme = 'default';

	function __construct($_category = null, $_post = null)
	{
		if(trim($_category) == '') $_category = null;
		if(trim($_post) == '') $_post = null;

		$this->category = $_category;
		$this->post = $_post;
	}

	private function getCategories()
	{
		$dir = getcwd() . '/Blog/';
		$iterador = new DirectoryIterator("$dir");
		foreach ( $iterador as $entrada ) {
			if(!in_array($entrada,array('.','..'))){
				$cat[] = $entrada->getFilename();
			}
		}
		return $cat;
	}

	private function getPosts($cat = null)
	{
		$dir = getcwd() . '\Blog';
		$posts = array();
		if(is_null($cat))
		{
			$iterator = new RecursiveDirectoryIterator($dir);
			$recursiveIterator = new RecursiveIteratorIterator($iterator);
			foreach ( $recursiveIterator as $entry ) {
				$posts[] = $entry->getPathname();
			}
			//TODO : Refatorar isso para algo descente
			foreach($posts as $p){
				$aux[] = explode("\\",$p);
			}

			$posts = '';
			$i = 0;

			foreach($aux as $p){
				$posts[$i]['postCategory'] = $p[count($p)-2];
				$posts[$i++]['postName'] = $p[count($p)-1];
			}
		} else {
			$dir .= $cat.'/';
			$iterator = new RecursiveDirectoryIterator($dir);
			$recursiveIterator = new RecursiveIteratorIterator($iterator);
			foreach ( $recursiveIterator as $entry ) {
				$posts[] =  $entry->getFilename();
			}
		}
		return $posts;
	}

	private function generateNavFromArray($array){
		$html = '';
		$html .= '<ul>';
		foreach ($array as $item) {
			$html .= '<li><a href="#">' . $item . '</a>';
			if (is_array($item)) {
				$html .= '<ul>';
				foreach ($item as $children) {
					$html .= '<li><a href="#">' . $item . '</a>';
				}
				$html .= '</ul>';
			}

			$html .= '</li>';
		}
		$html .= '</ul>';
		return $html;
	}

	private function getPostContent($category,$postname){
		return file_get_contents("Blog/{$category}/{$postname}");
	}

	private function generatePostArray($postsReferences)
	{
		$helper = 0;
		foreach($postsReferences as $post)
		{
			$content[$helper]['title'] = $post['postName'];
			$content[$helper++]['text'] = $this->getPostContent($post['postCategory'],$post['postName']);
		}

		return $content;
	}

	private function generatePostHTML($posts)
	{
		$cont = $this->generatePostArray($posts);
		$html = '';

		foreach($cont as $c){
			$html .= "<div class='post'>";
			$html .= "<h3>{$c['title']}</h3>";
			$html .= "<p>{$c['text']}</p>";
			$html .= "</div>";
		}

		return $html;

	}
	private function renderHome()
	{
		$categories = $this->getCategories();
		$posts = $this->getPosts();


		ob_start();
		try	{
			$buffer = file_get_contents("Template/{$this->theme}/main.php");

			$er     = "/\{\{AllCats\}\}/";
            $buffer = preg_replace($er, $this->generateNavFromArray($categories), $buffer);

            $a = $this->generatePostHTML($posts);

			$er     = "/\{\{AllPosts\}\}/";
			$buffer = preg_replace($er, $a, $buffer);

            echo $buffer;

			ob_end_flush();
		} catch(Exception $e) {
			ob_clean();
			echo $e->getMessage();
			ob_end_flush();
		}

	}

	private function renderControl()
	{
		if(is_null($this->category)) $this->renderHome();
	}


	function run()
	{
		$this->renderControl();
	}

}