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
		$this->isGranted('admin');
		$admin = new User();
		$admin->setAddedAt(new \DateTime("now", new \DateTimeZone('Europe/Paris')));
		$admin->setIsAdmin(1);
		$admin->setIsChecked(1);
		if ($this->request->getMethod() == "POST" && $admin->hydrate($this->request->getPost())->isValid()) {
			$admin->setPassword(password_hash($admin->getPassword(), PASSWORD_DEFAULT));
			$manager = $this->getDatabase()->getManager(User::class);
			$manager->insert($admin);
			$this->request->addFlashBag('success', 'Le nouvel administrateur a bien été inscrit !');
			return $this->redirect("index");
		}
		return $this->render("addAdmin.html.twig", [
			"user" => $admin
		]);
	}

	public function addUser()
	{		
		$user = new User();
		$user->setAddedAt(new \DateTime("now", new \DateTimeZone('Europe/Paris')));
		if ($this->request->getMethod() == "POST" && $user->hydrate($this->request->getPost())->isValid()) {
			$user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
			$manager = $this->getDatabase()->getManager(User::class);
			$manager->insert($user);
			$this->request->addFlashBag('success', 'Le nouvel utilisateur a bien été enregistré, il sera vérifié par un administrateur avant son inscription finale !');
			$this->request->setSession('uncheckedUsers', $manager->countUncheckedUsers());
			return $this->redirect("index");	
		}
		return $this->render("addUser.html.twig", [
			"user" => $user
		]);
	}

	public function getAdminInfos()
	{
		$postManager = $this->getDatabase()->getManager(Post::class);
		$commentManager = $this->getDatabase()->getManager(Comment::class);
		$this->request->setSession('reportedPosts', $postManager->countReportedPosts());
		$this->request->setSession('reportedComments', $commentManager->countReportedComments());
		$this->request->setSession('uncheckedComments', $commentManager->countUncheckedComments());
	}

	public function checkUser($id)
	{
		$this->isGranted('admin');
		$manager = $this->getDatabase()->getManager(User::class);
		$user = $manager->find($id);	
		if ($user) {
			$user->setIsChecked(1);
			$manager->update($user);
			$this->request->addFlashBag('success', 'L\'utilisateur a bien été validé !');
			$this->request->setSession('uncheckedUsers', $manager->countUncheckedUsers());
			return $this->redirect("uncheckedUsers", [
	            "page" => 1
	        ]);
		}
		$this->request->addFlashBag('failure', 'Aucun utilisateur correspondant à votre demande n\'a été trouvé.');
		return $this->redirect("uncheckedUsers", [
			"page" => 1
		]);
	}

	public function deleteUser($id)
	{
		$this->isGranted('admin');
		$userManager = $this->getDatabase()->getManager(User::class);
		$user = $userManager->find($id);
		if ($user) {
			$userManager->remove($user);
			$this->request->addFlashBag('success', 'L\'utilisateur a bien été supprimé !');
			$this->request->setSession('uncheckedUsers', $userManager->countUncheckedUsers());
			return $this->redirect("uncheckedUsers", [
				"page" => 1
			]);
		}
		$this->request->addFlashBag('failure', 'Aucun utilisateur correspondant à votre demande n\'a été trouvé.');
		return $this->redirect("uncheckedUsers", [
			"page" => 1
		]);
	}

	public function showUncheckedUsers($page = 1)
	{ 
		$this->isGranted('admin');
		$manager = $this->getDatabase()->getManager(User::class);
		$results = $manager->getUncheckedUsers($page);
		return $this->render("uncheckedusers.html.twig", [
            "page" => $page,
            "users" => $results['results'],
            "nbPages" => $results['nbPages']
        ]);
	}
	
}