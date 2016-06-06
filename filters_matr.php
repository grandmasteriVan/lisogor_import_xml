<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 01.06.16
 * Time: 10:22
 */

define ("host","localhost");
//define ("host","10.0.0.2");
/**
 * database username
 */
define ("user", "root");
//define ("user", "uh333660_mebli");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "Z7A8JqUh");
/**
 * database name
 */
define ("db", "mebli");
//define ("db", "uh333660_mebli");

/**
 * возвращает список всех матрасов, которые не являются модификацией (т.е. они - родительский товар)
 * @return array
 */
function parrent_matr()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE goodskinfd_id=40 and goods_parent=0";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $arr[] = $row;
        }

    }
    return $arr;
}

/**
 * возврвщает список всех матрасов, и родителей и модификаций
 * @return array
 */
function all_matr()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE goodskinfd_id=40";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $arr[] = $row;
        }

    }
    return $arr;
}

/**
 * возвращает список в котором есть только модификации матрасов
 * @return array
 */
function mod_matr()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE goodskinfd_id=40 AND goods_parent<>0";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $arr[] = $row;
        }

    }
    return $arr;
}




?>