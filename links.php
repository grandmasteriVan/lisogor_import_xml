<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 10.03.16
 * Time: 09:14
 */
function add_tags($text)
{
    //preg_match_all("/<a href=*\/a>/",$text,$links);
	preg_match_all("/<a(.*?)<\/a>/",$text,$links);
	print_r ($links);
    foreach ($links[0] as $link)
    {
        //echo $link;
		//echo " ";
		$pos=strpos ($link,"divani.kiev.ua");
		if (!$pos)
        {
            $tegpos=strpos($link,">");
            $newLink=substr_replace($link,' rel="nofolow"',$tegpos,0);
            $newLink="<noindex>".$newLink."</noindex>";
			echo " ".$link." to ".$newLink ;
			
			
			$text=str_replace ($link,$newLink,$text);
        }
    }
	//echo "<br/>";
	return $text;
}

$text='ddd <a href="f.com">link</a> fff <a href="c.com">link2</a> hjhg <a href="divani.kiev.ua/links.html">divani</a> some text';
//echo $text;
$tmp= add_tags($text);
echo " new text: ";
echo $tmp;


?>