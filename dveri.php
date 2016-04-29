<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 29.04.16
 * Time: 09:36
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

function getPrice($factoryId)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_price FROM goods WHERE factory_id=$factoryId";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row=mysqli_fetch_assoc($res))
        {
            $arr[]=$row;
        }

        foreach ($arr as $tov)
        {
            $tmp=$tov['goods_id'].",".$tov['goods_price'].",".PHP_EOL;
            file_put_contents('price.csv',$tmp,FILE_APPEND);
        }
    }
}


getPrice(76);






?>