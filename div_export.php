<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 21.07.16
 * Time: 11:11
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
define ("db", "divani_new");
//define ("db", "uh333660_mebli");

function export()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_exfeature FROM goods";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $feat=$good['goods_exfeature'];
            $arr=explode("\n",$feat);
            echo "<pre>";
            printf($arr);
            echo  "</pre>";

        }
    }
    mysqli_close($db_connect);
}

?>