<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 27.09.16
 * Time: 09:17
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

/**
 * @param $factory_id integer - айди фабрики
 * @param $goodskind integer - вид товара
 * @return array - массив, содержащий список всех родительских позиций
 * возвращает список всех родительских товаров, которые принадлежат к оной фабрике и типу товара
 */
function parrent_matr($factory_id, $goodskind=40)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_article, goods_name FROM goods WHERE goodskind_id=$goodskind and goods_parent=0 AND factory_id=$factory_id";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $arr[] = $row;
        }
    }
    mysqli_close($db_connect);
    /*echo "<pre>";
	print_r ($arr);
	echo "</pre>";*/
    return $arr;
}

/**
 * @param $factory_id integer - айди фабрики
 * @param $goodskind integer - вид товара
 * @return array - массив, содержащий список дочерних позиций
 * возвращает список всех дочерних товаров, которые принадлежат к оной фабрике и типу товара
 */
function mod_matr($factory_id, $goodskind=40)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_article, goods_name FROM goods WHERE goodskind_id=$goodskind AND goods_parent<>0 AND factory_id=$factory_id";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $arr[] = $row;
        }
    }
    mysqli_close($db_connect);
    return $arr;
}

function count_matr($factory_id)
{
    $parrent_matr=parrent_matr($factory_id);
    $mod_matr=mod_matr($factory_id);
    $i=1;
    foreach ($parrent_matr as $parrent)
    {
        $name=$parrent['goods_name'];
        $article=$parrent['goods_article'];
        echo "$i. $article $name";
        $i++;
    }
    $i=1;
    foreach ($mod_matr as $mod)
    {
        $name=$mod['goods_name'];
        $article=$mod['goods_article'];
        echo "$i. $article $name";
        $i++;
    }
}

count_matr(137);

?>