<?php

require 'Render.php';

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
		$dir = getcwd() . '/Blog/';
		$posts = array();
		if(is_null($cat))
		{
			$iterator = new RecursiveDirectoryIterator($dir);
			$recursiveIterator = new RecursiveIteratorIterator($iterator);
			foreach ( $recursiveIterator as $entry ) {
				$posts[] = $entry->getFilename();
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

	private function renderHome()
	{
		$categories = $this->getCategories();
		$posts = $this->getPosts();


		ob_start();
		try	{
			$buffer = file_get_contents("Template/{$this->theme}/main.php");
			// include "Template/{$this->theme}/main.php";

			$er     = "/\{\{AllCats\}\}/";
            $buffer = preg_replace($er, $this->generateNavFromArray($categories), $buffer);

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