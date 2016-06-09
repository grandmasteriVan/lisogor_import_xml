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
    $query="SELECT goods_id, goods_parent, goods_width FROM goods WHERE goodskinfd_id=40 and goods_parent=0";
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

/**
 * возврвщает список всех матрасов, и родителей и модификаций
 * @return array
 */
function all_matr()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_parent, goods_width FROM goods WHERE goodskinfd_id=40";
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

/**
 * возвращает список в котором есть только модификации матрасов
 * @return array
 */
function mod_matr()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_parent, goods_width FROM goods WHERE goodskinfd_id=40 AND goods_parent<>0";
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

/**
 *
 */
function copy_filters()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $parent_list=parrent_matr();
    $mod_list=mod_matr();

    foreach ($parent_list as $parent)
    {
        //выбираем список фич для родительского матраса
        $parrent_id=$parent['goods_id'];
        $query="SELECT * FROM goodshasfeature WHERE goods_id=$parrent_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row=mysqli_fetch_assoc($res))
            {
                $features[]=$row;
            }
        }
        foreach($mod_list as $mod)
        {
            if ($parent['goods_id']==$mod['goods_parent'])
            {
                $mod_id=$mod['goods_id'];
                //дропаем старые записи
                $query="DELETE FROM goodshasfeature WHERE goods_id=$mod_id";
                mysqli_query($db_connect,$query);
                //для каждой фичи записываем ее в БД
                foreach ($features as $feat)
                {
                    $goodshasfeature_valueint=$feat['goodshasfeature_valueint'];
                    $goodshasfeature_valuefloat=$feat['goodshasfeature_valuefloat'];
                    $goodshasfeature_valuetext=$feat['goodshasfeature_valuetext'];
                    $feature_id=$feat['feature_id'];
                    $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                        "goodshasfeature_valuetext, goods_id, feature_id) ".
                        "VALUES ($fgoodshasfeature_valueint, $goodshasfeature_valuefloat, ".
                        "$goodshasfeature_valuetext, $mod_id, $feature_id)";
                    mysqli_query($db_connect,$query);
                }


            }
        }
    }

}


?>