<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 12. 12. 2016
 * Time: 19:49
 */


require_once 'Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();
// cesta k adresari se sablonama - od index.php
$loader = new Twig_Loader_Filesystem('view');
$twig = new Twig_Environment($loader); // takhle je to bez cache
// nacist danou sablonu z adresare
$template = $twig->loadTemplate('default.twig');

// render vrati data pro vypis nebo display je vypise
// v poli jsou data pro vlozeni do sablony
$template_params = array();

require 'view/menu.php';
$template_params["menu"] = $menu;

require 'view/obsah.php';
$template_params["obsah"] = $obsah;

echo $template->render($template_params);

require_once ("config.php");
spl_autoload_register('autoloader');