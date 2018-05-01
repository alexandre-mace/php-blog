<?php

namespace Controller;

use App\Controller;
use Model\User;
use Model\Post;
use Model\Comment;


/**
* UserController
*/
class UserController extends Controller
{
	public function addAdmin()
	{
		if ($this->request->getMethod() == "POST") {
			if ($this->verify($this->request->getPost())) {

				$manager = $this->getDatabase()->getManager(User::class);
				if (is_null($manager->find($this->request->getPost()['id']))) {

					$admin = new User();
					$admin->setId($this->request->getPost()['id']);
					$admin->setPassword(password_hash($this->request->getPost()['password'], PASSWORD_DEFAULT));
					$admin->setIsAdmin(1);
					$manager->insert($admin);	
					$this->request->addFlashBag('success', 'Le nouvel administrateur a bien été inscrit !');
					return $this->render("addAdmin.html.twig", []);							
				}
				$this->request->addFlashBag('failure', 'L\'identifiant est déjà attribué à un autre administrateur, veuillez choisir un nouvel identifiant.');
				return $this->render("addAdmin.html.twig", []);

			}
			$this->request->addFlashBag('failure', 'L\'ajout du nouvel administrateur a échoué, veuillez remplir tous les champs.');
		}
		return $this->render("addAdmin.html.twig", []);
	}

	public function getAdminInfos()
	{
		$postManager = $this->getDatabase()->getManager(Post::class);
		$commentManager = $this->getDatabase()->getManager(Comment::class);
		$this->request->setSession('reportedPosts', $postManager->countReportedPosts());
		$this->request->setSession('reportedComments', $commentManager->countReportedComments());
		$this->request->setSession('uncheckedComments', $commentManager->countUncheckedComments());
	}
	
}