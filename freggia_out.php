<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 05.08.16
 * Time: 09:33
 */

//define ("host","localhost");
define ("host","10.0.0.2");
/**
 * database username
 */
//define ("user", "root");
define ("user", "uh333660_mebli");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "Z7A8JqUh");
/**
 * database name
 */
//define ("db", "mebli_new");
define ("db", "uh333660_mebli");

function out()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_content FROM goods WHERE goods_content LIKE 'freggia.ua'";
    if ($res=mysqli_query($db_connect,$query))
    {
        //формируем список позиций
        while ($row = mysqli_fetch_assoc($res))
        {
            $tovars[] = $row;
        }
        foreach ($tovars as $tovar)
        {
            $id=$tovar['goods_id'];
            $text=$tovar['goods_content'];
            $text_new=str_ireplace("http://fregia.ua/files/templates/images/ico-info.png","/admin/upload/image/quick/ico_info.png",$text);
            echo $text_new."<br>";
            $query="UPDATE goods SET goods_content='$text_new' WHERE goods_id=$id";
            mysqli_query($db_connect,$query);
            break;
        }
    }
    mysqli_close($db_connect);
}

?>