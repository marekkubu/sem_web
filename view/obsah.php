<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 13. 12. 2016
 * Time: 1:51
 */

function phpWrapperFromFile($filename)
{
    ob_start();

    if (file_exists($filename) && !is_dir($filename))
    {
        include($filename);
    }

    // nacte to z outputu
    $obsah = ob_get_clean();
    return $obsah;
}

// default je uvod
if($page == "")
    $page = "uvod";

//echo "page je : $page ";

if($page == "uvod")
    $filename = "view/obsah_inc/uvod.inc.php";

elseif($page == "kontakt")
    $filename = "view/obsah_inc/kontakt.inc.twig";

else
    $filename = "view/obsah_inc/404.inc.php";


$obsah = phpWrapperFromFile($filename);