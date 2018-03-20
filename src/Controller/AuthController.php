<?php

namespace Controller;

use App\Controller;
use Model\User;
use Model\Post;

/**
* Authentifications controller
*/
class AuthController extends Controller
{
	
	public function auth($page = 1)
	{
		$userManager = $this->getDatabase()->getManager(User::class);
		$postManager = $this->getDatabase()->getManager(Post::class);

		if (isset($_POST['id'], $_POST['password'])) {
			unset($_SESSION['user']);
			$result = $userManager->isValid($_POST['id'], $_POST['password']);
			if ($result) {
				$user = $userManager->getUser($_POST['id']);
				$_SESSION['user'] = $user;
				$results = $postManager->getPaginatedPosts($page);
				$posts = $results['results'];
				$nbPages = $results['nbPages'];
				return $this->render("posts.html.twig", [
		            "user" => $user,
		            "posts" => $posts,
            		"page" => 1,
            		"nbPages" => $nbPages,
		        ]);
			}
			$results = $postManager->getPaginatedPosts($page);
			$posts = $results['results'];
			$nbPages = $results['nbPages'];
			return $this->render("posts.html.twig", [
				"posts" => $posts,
            	"page" => 1,
            	"nbPages" => $nbPages,
			]);			
		}
		return $this->render("auth.html.twig", []);

	}

}