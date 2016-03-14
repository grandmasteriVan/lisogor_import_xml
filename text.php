<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 14.03.16
 * Time: 09:38
 */

function get_text()
{
    $db_connect=mysqli_connect('localhost','root','','mebli');
    $query="SELECT goods_article, goods_content FROM goods";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row=mysqli_fetch_assoc($res))
        {
            $arr[]=$row;
        }
        $len=count($arr);
        for ($i=0;$i<$len;$i++)
        {
            $arr[$i]['goods_content']=strip_tags($arr[$i]['goods_content']);
            $str=$arr[$i]['goods_article']."".$arr[$i]['goods_content']."";
            file_put_contents('texts.txt',$str,FILE_APPEND);
        }
    }
}

get_text();


?>