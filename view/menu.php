<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 13. 12. 2016
 * Time: 1:13
 */

require_once('model/login.class.php');
require_once("controller/logout.inc.php");

$page = @$_REQUEST["page"];

$pages = array();
$pages["uvod"] = "Úvod";
$pages ["prispevky"] = "Příspěvky";
$pages ["kontakt"] = "Kontakt";


$menu="";
$menu .="<ul class='nav navbar-nav'>";
if($pages != null)
    foreach($pages as $key => $title)
    {
        if($page == $key) $active_pom = "class='active'";
        else $active_pom = "";
        $menu .= "<li $active_pom><a href='index.php?page=$key'>$title</a></li>";
    }
$menu .="</ul>";

//FORMULAR PRO REGISTRACI
include_once("view/registerForm.inc.twig");

// Pokud je uzivatel prihlasen
if (Login::isLog()) {
    $menu .= "<ul class='nav navbar-nav navbar-right'>
<li class='dropdown'>
<a href='#' class='dropdown-toggle' data-toggle='dropdown'> <b>" . Login::getUserInfo('NAME') . "</b> <span class='caret'></span></a>
			<ul class='dropdown-menu'>
			
				<form method='post'>
				<input type=\"hidden\" name=\"login_out\" value=\"logout\">
				<li><button class=\"btn btn-danger btn-block\" type=\"submit\" name='login_out'>Odhlásit se</button></li>
				</form>
				</ul>
				
				</li>
    
</ul>";
    $title="Moje příspěvky";
    if($page == "moje_prispevky") $active_pom = "class='active'";
        else $active_pom = "";
    $menu .="<ul class='nav navbar-nav'>";
    $menu .= "<li $active_pom><a href='index.php?page=moje_prispevky'>$title</a></li>";
    $menu .="</ul>";

    //Pokud uzivatel ma prava typu admin, zobrazi se mu tlacitko, pomoci ktereho se dostane na stranku administrace
    if(Login::getUserInfo("POWERS") == 'admin'){
        $menu .= "<ul class='nav navbar-nav navbar-right'>
                <form method='post'action = 'index.php?page=administrace'>
				<input type=\"hidden\" name=\"administration\">
				<li><button class=\"btn btn-primary btn-block\" type=\"submit\" name='administration'>Administrace </button></li>
				</form>
            </ul>";
    }
    //Pokud je uzivatel recenzent zobrazi se mu tlacitko Hodnotit, ktere odkazuje na jeho stranku, kde jsou zobrazeny prispevky, ktere muuze hodnotit
    if(Login::getUserInfo("POWERS") == 'reviewer'){
        $menu .= "<ul class='nav navbar-nav navbar-right'>
                <form method='post' action = 'index.php?page=hodnoceni'>
				<input type=\"hidden\" name=\"rating\">
				<li><button class=\"btn btn-warning btn-block\" type=\"submit\" name='rating' >Hodnocení </button></li>
				</form>
            </ul>";
    }
}


//Pokud uzivatel neni prihlasen
else {
    $menu .= "<ul class='nav navbar-nav navbar-right'>
        <li class='dropdown'>
           <a href='#' class='dropdown-toggle' data-toggle='dropdown'><b>Přihlásit se</b> <span class='caret'></span></a>
			<ul id='login-dp' class='dropdown-menu'>
				<li>
					 <div class='row'>
							<div class='col-md-12'>
							Přihlášení
								 <form class='form' method='post' id='login-nav'>
                                        <div class='form-group'>
											 <input type='text' class='form-control'  name='user[username]' placeholder='Username' required>
										</div>
										<div class=\"form-group\">
											 <input type='password' name='user[password]' class=\"form-control\" id=\"exampleInputPassword\" placeholder=\"Password\" required>
										</div>
										<div class=\"form-group\">
											 <button type=\"submit\" class=\"btn btn-primary btn-block\" name='login_go'>Přihlásit</button>
										</div>
								 </form>
							</div>
							<div class='bottom text-center'>
							Nemáte založený učet?
								<button type=\"button\" class=\"btn btn-warning btn-block\" onclick=\"document.getElementById('id01').style.display='block'\" >Registrovat</button>
							</div>
					 </div>
				</li>
				</ul>
				</li>
				</ul>";
}
