<?php

namespace Controller;

use App\Controller;
use Model\Post;

/**
* ContactController
*/
class ContactController extends Controller
{

	public function contact()
	{
		if ($this->request->getMethod('POST') AND !empty($this->request->getPost())) {
			if ($this->verify($this->request->getPost())) {
				$this->sendMail(); 
				$this->request->addFlashBag('success', 'Votre mail a bien été envoyé !');
				return $this->render("contact.html.twig", []);
			}
			$this->request->addFlashBag('failure', 'L\'envoi du mail a échoué, veuillez remplir correctement tous les champs.');
		}
		return $this->render("contact.html.twig", []);
	}

	public function sendMail()
	{
		// Create the Transport
		$transport = (new \Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
		  ->setUsername(getEnv("MAIL_USER"))
		  ->setPassword(getEnv("MAIL_PASSWORD"))
		;

		// Create the Mailer using your created Transport
		$mailer = new \Swift_Mailer($transport);

		// Create a message
		$message = (new \Swift_Message('blogOC'))
		  ->setFrom([$this->request->getPost('email') => $this->request->getPost('prenom')])
		  ->setTo([getEnv("MAIL_USER") => 'blogOC'])
		  ->setBody($this->request->getPost('message'))
		  ;

		// Send the message
		$result = $mailer->send($message);
	}
}