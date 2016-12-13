<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 13. 12. 2016
 * Time: 1:13
 */

$page = @$_REQUEST["page"];

$pages = array();
$pages["uvod"] = "Úvod";
$pages ["kontakt"] = "Kontakt";
$pages ["login"] = "Login";

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

//PRIHLASIT
$menu .="<ul class='nav navbar-nav navbar-right'>
        <li class='dropdown'>
           <a href='#' class='dropdown-toggle' data-toggle='dropdown'><b>Přihlásit se</b> <span class='caret'></span></a>
			<ul id='login-dp' class='dropdown-menu'>
				<li>
					 <div class='row'>
							<div class='col-md-12'>
							Přihlášení
								 <form class='form' method='post' id='login-nav'>
                                        <div class='form-group'>
											 <input type='email' class='form-control'  name='username' placeholder='Email address' required>
										</div>
										<div class=\"form-group\">
											 <input type='password' name='password' class=\"form-control\" id=\"exampleInputPassword2\" placeholder=\"Password\" required>
										</div>
										<div class=\"form-group\">
											 <button type=\"submit\" class=\"btn btn-primary btn-block\">Přihlásit</button>
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

$username=@$_POST["username"];
$password=@$_POST["password"];

//REGISTRACE

