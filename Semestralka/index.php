<?php

	session_start();
	//Funkce které includne stránku, pokud ji najde
	function phpWrapperFromFile($filename) 
	{
		ob_start();
		
		if (file_exists($filename) && !is_dir($filename))
		{
			include($filename);
		}
		else
		{
			echo 'Fail';
		}
		$content = ob_get_clean();

		return $content;
 	}
 	//Získáme stránku z url
	$request_page = @$_REQUEST["page"];
	//Switch pro výběr stránky
	switch($request_page)
	{
	  case '' : 	      $filename = 'Views/about.php';
				  	      break;
	  case 'home' :       $filename = 'Views/home.php';
					      break;
	  case 'about' :	  $filename = 'Views/about.php';
	  					  break;			          
	  case 'login' :      $filename = 'Views/login.php';
					      break;
	  case 'logout' :     $filename = 'Views/logout.php';
				          break;
      case 'contact' :    $filename = 'Views/contact.php';
				          break;
      case 'register' :   $filename = 'Views/register.php';
					      break;
      case 'profile': 	  $filename = 'Views/profile.php';
	  					  break;
      case 'my_articles': $filename = 'Views/my_articles.php';
        				  break;
      case 'new_article': $filename = 'Views/new_article.php';
      					  break;
      case 'article_detail': $filename = 'Views/article_detail.php';
  	  						 break;
	  case 'review_article': $filename = 'Views/review_article.php';
	  					  	 break;  				  
  	  case 'edit_User_admin': $filename = 'Views/edit_User_admin.php';
      					      break;
      case 'change_MyArticle': $filename = 'Views/change_MyArticle.php';
	  					  	   break;
	  case 'articles_toreview': $filename = 'Views/articles_toreview.php';
	  					  		break;
	  case 'manage_users_admin': $filename = 'Views/manage_users_admin.php';
	  							 break;	
	  case 'manage_articles_admin': $filename = 'Views/manage_articles_admin.php';
	  								break;		
	  case 'add_reviewers_toArticle': $filename = 'Views/add_reviewers_toArticle.php';
	  								  break;	

	  default : $filename = 'Views/404.php';	  		  		  
	            break;
	}
 	$content = phpWrapperFromFile($filename);

 	$menu = phpWrapperFromFile('Views/menu.php');

 	// nacist twig - kopie z dokumentace
	require_once 'twig-master/lib/Twig/Autoloader.php';
	Twig_Autoloader::register();
	// cesta k adresari se sablonama - od index.php
	$loader = new Twig_Loader_Filesystem('templates');
	$twig = new Twig_Environment($loader); // takhle je to bez cache
	// nacist danou sablonu z adresare
	$template = $twig->loadTemplate('template.html');
	
	// render vrati data pro vypis nebo display je vypise
	// v poli jsou data pro vlozeni do sablony
	$template_params = array();
	$template_params["menu"] = $menu;
	//$template_params["title"] = ;
    $template_params["content"] = $content;

	echo $template->render($template_params);
