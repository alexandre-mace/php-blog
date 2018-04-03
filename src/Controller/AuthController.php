<?php

namespace Controller;

use App\Controller;
use Model\User;

/**
* Authentifications controller
*/
class AuthController extends Controller
{
	
	public function auth()
	{
		$userManager = $this->getDatabase()->getManager(User::class);

		if (isset(($this->request->getPost())['id'])) {
			$this->request->setSession('user', "");

			if (!is_null($userManager->find($this->request->getPost()['id']))) {
				$user = $userManager->find($this->request->getPost()['id']);

				if (password_verify(($this->request->getPost())['password'], $user->getPassword()))	{
					$this->request->setSession('user', $user);
					$this->request->addFlashBag('success', 'Bonjour ' . $user->getId() . ' l\'authentification a réussi !');
					return $this->redirect("index", []);
				}
			}
		}
		$this->request->addFlashBag('failure', 'L\'authentification a échoué, veuillez rééssayer.');
		return $this->render("auth.html.twig", []);

	}

}