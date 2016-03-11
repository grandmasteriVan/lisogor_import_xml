<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 10.03.16
 * Time: 09:14
 */


function add_tags($text)
{
	preg_match_all("/<a(.*?)<\/a>/",$text,$links);
	//print_r ($links);
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
			//echo " ".$link." to ".$newLink ;
			
			
			$text=str_replace ($link,$newLink,$text);
        }
    }
	//echo "<br/>";
	return $text;
}

function db_correction ()
{
    $db_connect=mysqli_connect('localhost','root','','ddn');
    $query="SELECT news_id, news_content FROM news";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row=mysqli_fetch_assoc($res))
        {
            $arr[]=$row;
        }
        foreach ($arr as $row)
        {
            $text1=$row['news_content'];
            $id=$row['news_id'];
            $text2=add_tags($text1);
            if ($text1!=$text2)
            {
                $query="UPDATE news ".
                    "SET news_content=$text2 ".
                    "WHERE news_id=$id";
                mysqli_query($db_connect,$query);
            }
        }
    }
}

//$text='ddd <a href="f.com">link</a> fff <a href="c.com">link2</a> hjhg <a href="divani.kiev.ua/links.html">divani</a> some text';
//echo $text;
//$newText= add_tags($text);
//echo " new text: ";
//echo $newText;
db_correction ();

?>