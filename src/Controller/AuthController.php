<?php

namespace Controller;

use App\Controller;
use Model\User;
use Model\Post;
use Model\Comment;


/**
* Authentifications controller
*/
class AuthController extends Controller
{
	
	public function auth()
	{
		if (isset($this->request->getPost()['id'])) {

			$this->request->setSession('user', "");
			$userManager = $this->getDatabase()->getManager(User::class);

			if (!is_null($userManager->find($this->request->getPost()['id']))) {
				$user = $userManager->find($this->request->getPost()['id']);

				if (password_verify($this->request->getPost()['password'], $user->getPassword()))	{
					$this->request->setSession('user', $user);
					$this->request->addFlashBag('success', 'Bonjour ' . $user->getId() . ' l\'authentification a réussi !');
					if ($user->getIsAdmin() == 1) {
						$postManager = $this->getDatabase()->getManager(Post::class);
						$commentManager = $this->getDatabase()->getManager(Comment::class);
						$this->request->setSession('reportedPosts', $postManager->countReportedPosts());
						$this->request->setSession('reportedComments', $commentManager->countReportedComments());
						$this->request->setSession('uncheckedComments', $commentManager->countUncheckedComments());
					}
					return $this->redirect("index", []);
				}
			}
		}
		$this->request->addFlashBag('failure', 'L\'authentification a échoué, veuillez rééssayer.');
		return $this->render("auth.html.twig", []);

	}

}