<?php

class Flerovium
{

	private $category;
	private $post;
	private $theme = 'default';
	private $renderedPage;

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
		$dir = getcwd() . '\Blog\\';
		$posts = array();
		if(is_null($cat))
		{
			$iterator = new RecursiveDirectoryIterator($dir);
			$recursiveIterator = new RecursiveIteratorIterator($iterator);
			foreach ( $recursiveIterator as $entry ) {
				$time = date("Y/m/d H:i:s",filectime($entry));

				if(in_array($time, array_keys($posts)))
				{
					$time++;
				}

				$posts[$time] = $entry->getPathname();
			}

			krsort($posts,SORT_STRING);

			//TODO : Refactor this one for something good
			//Causa this is solving the problem, but it's a true shit.


			foreach($posts as $p){
				$aux[] = explode("\\",$p);
			}


			$times = array_keys($posts);
			$posts = '';
			$i = 0;

			foreach($aux as $p){
				$posts[$i]['postTime'] = $times[$i];
				$posts[$i]['postCategory'] = $p[count($p)-2];
				$posts[$i++]['postName'] = $p[count($p)-1];
			}

		} else {
			$dir .= $cat.'\\';
			$iterator = new RecursiveDirectoryIterator($dir);
			$recursiveIterator = new RecursiveIteratorIterator($iterator);
			foreach ( $recursiveIterator as $entry ) {

				$time = date("Y/m/d H:i:s",filectime($entry));

				if(in_array($time, array_keys($posts)))
				{
					$time++;
				}

				// $posts[$time]['postCategory'] = $this->category;
				// $posts[$time]['postName'] =  $entry->getFilename();
				$posts[$time] =  $entry->getFilename();
			}

			krsort($posts,SORT_STRING);


			$times = array_keys($posts);
			$posts = array_values($posts);

			$i = 0;
			$aux = array();
			foreach($posts as $p)
			{
				$aux[$i]['postTime'] = $times[$i];
				$aux[$i]['postCategory'] = $this->category;
				$aux[$i]['postName'] = $p;
				$i++;
			}
			$posts = $aux;
		}
		return $posts;
	}

	private function generateNavFromArray($array){
		$html = '';
		$html .= '<ul>';
		foreach ($array as $item) {
			if($this->renderedPage == 'post') $html .= '<li><a href=../../'.$item.'>' . $item . '</a>';
			else $html .= '<li><a href='.$item.'>' . $item . '</a>';
			if (is_array($item)) {
				$html .= '<ul>';
				foreach ($item as $children) {
					$html .= '<li><a href='.$item.'>' . $item . '</a>';
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
			$content[$helper]['time'] = $post['postTime'];
			$content[$helper]['categoryLink'] = $post['postCategory']."/".urlencode($post['postName'])."/";
			$content[$helper++]['text'] = $this->getPostContent($post['postCategory'],$post['postName']);
		}

		return $content;
	}

	private function generatePostHTML($posts, $cat = null)
	{
		$cont = $this->generatePostArray($posts);
		$html = '';

		foreach($cont as $c){
			$html .= "<div class='post'>";
			$html .= "<h3><a href={$c['categoryLink']}>{$c['title']}</a></h3>";
			$html .= "<span>{$c['time']}</span>";
			$html .= "<p>{$c['text']}</p>";
			$html .= "</div>";
		}

		return $html;

	}

	private function parseTemplateLanguage($buffer,$postsHTML = null,$categories = null)
	{
		if(!is_null($categories)){
			$er     = "/\{\{AllCats\}\}/";
			$buffer = preg_replace($er, $this->generateNavFromArray($categories), $buffer);
		}

		if(!is_null($postsHTML)){
			$er     = "/\{\{AllPosts\}\}/";
			$buffer = preg_replace($er, $postsHTML, $buffer);
			$er     = "/\{\{CategoryPosts\}\}/";
			$buffer = preg_replace($er, $postsHTML, $buffer);
			$er     = "/\{\{ThePost\}\}/";
			$buffer = preg_replace($er, $postsHTML, $buffer);
		}

		$er     = "/\{\{Category\}\}/";
		$buffer = preg_replace($er, $this->category, $buffer);

		$er     = "/\{\{PostName\}\}/";
		$buffer = preg_replace($er, $this->post, $buffer);


		return $buffer;
	}

	private function renderHome()
	{
		$this->renderedPage =  'home';
		$categories = $this->getCategories();

		$posts = $this->getPosts();
		$posts = $this->generatePostHTML($posts);



		ob_start();
		try	{
			$buffer = file_get_contents("Template/{$this->theme}/main.php");

			$buffer = $this->parseTemplateLanguage($buffer,$posts,$categories);

			echo $buffer;

			ob_end_flush();
		} catch(Exception $e) {
			ob_clean();
			echo $e->getMessage();
			ob_end_flush();
		}

	}

	private function renderCat()
	{
		$this->renderedPage = 'category';
		$categories = $this->getCategories();
		$posts = $this->getPosts($this->category);
		$posts = $this->generatePostHTML($posts);
		ob_start();
		try	{
			$buffer = file_get_contents("Template/{$this->theme}/category.php");
			$buffer = $this->parseTemplateLanguage($buffer,$posts,$categories);
			echo $buffer;
			ob_end_flush();
		} catch(Exception $e) {
			ob_clean();
			echo $e->getMessage();
			ob_end_flush();
		}
	}

	private function renderPost()
	{
		$this->renderedPage = 'post';
		$categories = $this->getCategories();
		$post = "<p>";
		$post .= $this->getPostContent($this->category,$this->post);
		$post .= "</p>";
		ob_start();
		try	{
			$buffer = file_get_contents("Template/{$this->theme}/post.php");
			$buffer = $this->parseTemplateLanguage($buffer,$post,$categories);
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
		if(is_null($this->category) && is_null($this->post)) $this->renderHome();
		elseif(is_null($this->post) && !is_null($this->category)) $this->renderCat();
		else $this->renderPost();
	}


	function run()
	{
		$this->renderControl();
	}

}