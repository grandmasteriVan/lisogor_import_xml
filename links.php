<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 10.03.16
 * Time: 09:14
 */

function add_tags($text)
{
    preg_match_all("/<a href=(*)\/>/",$text,$links);
    foreach ($links as $link)
    {
        if (!preg_match('divani.com.ua',$link))
        {
            $tegpos=strpos($link,">");
            $newLink=substr_replace($link,'rel=\"nofolow\"',$tegpos-1,0);
            $newLink="<noindex>".$newLink."</noindex>";
        }
    }

}

?>