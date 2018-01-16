<?php
require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../src/View/');
$twig = new Twig_Environment($loader, array(
    'cache' => false
));

echo $twig->render('home.html.twig');