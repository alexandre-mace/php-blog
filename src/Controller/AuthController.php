<?php

namespace Controller;

use App\Controller;
use Model\AdminManager;

/**
* Authentifications controller
*/
class AuthController extends Controller
{
	
	public function showAuth()
	{
		return $this->render("auth.html.twig", []);
	}

}