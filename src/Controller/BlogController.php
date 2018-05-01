<?php

namespace Controller;

use App\Controller;
use Model\Post;

/**
* BlogController
*/
class BlogController extends Controller
{
	public function index()
	{
		$manager = $this->getDatabase()->getManager(Post::class);
		$lastPosts = $manager->getLastPosts();
		return $this->render("index.html.twig", [
            "lastPosts" => $lastPosts,
        ]);
	}
	public function showContact()
	{
		return $this->render("contact.html.twig", []);
	}
	public function sendMail()
	{
		// Create the Transport
		$transport = (new Swift_SmtpTransport('smtp.example.org', 25));
		// Create the Mailer using your created Transport
		$mailer = new Swift_Mailer($transport);
		// Create a message
		$message = (new Swift_Message('Wonderful Subject'))
		  ->setFrom(['john@doe.com' => 'John Doe'])
		  ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
		  ->setBody('Here is the message itself')
		  ;
		// Send the message
		$result = $mailer->send($message);
	}
}