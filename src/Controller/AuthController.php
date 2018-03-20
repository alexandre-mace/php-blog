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

		if (isset($_POST['id'], $_POST['password'])) {
			unset($_SESSION['user']);
			$result = $userManager->isValid($_POST['id'], $_POST['password']);
			if ($result) {
				$user = $userManager->getUser($_POST['id']);
				$_SESSION['user'] = $user;
				return $this->redirect("posts", [
            		"page" => 1,
		        ]);
			}
			return $this->redirect("posts", [
            	"page" => 1,
			]);			
		}
		return $this->render("auth.html.twig", []);
	}

}