<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 15.07.16
 * Time: 09:48
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
//define ("db", "mebli");
define ("db", "uh333660_mebli");

function change_seo($goods_kind=40)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_name, goods_title, goods_desc, goods_header FROM goods WHERE goods_kind=$goods_kind";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $header=$good['goods_header'];
            //todo: удалить название матраса (текст до первой точки) и вставить начало строку из $header
            $title=$good['goods_title'];
            //todo: удалить название матраса (текст до фразы "в интернете") и вставить начало строку из $header
            $desc=$good['goods_desc'];

            //делаем тайтл
            $title_new=substr($title,strpos(". Купить")+1);
            $title_new=$header." ".$title_new;

            //делаем дескрипшн
            $desc_new=substr($desc,strpos("в интернете")+1);
            $desc_new="Купить ".$header." ".$desc;

            //пишем изменения в бд
            $query="UPDATE goods SET goods_title='$title_new', goods_desc='$desc_new' WHERE goods_id=$id";
            //mysqli_query($db_connect,$query);
            echo $query."<br>";
        }
    }

    mysqli_close($db_connect);
}


?>