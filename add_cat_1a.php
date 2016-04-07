<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 07.04.16
 * Time: 10:33
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

function add_cat($cat1, $cat1a, $percent)
{
    $percent=(100-$percent)/100;
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, category_price FROM goodshascategory WHERE category_id=$cat1";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row=mysqli_fetch_assoc($res))
        {
            $price_1cat[]=$row;
        }
        foreach($price_1cat as $div)
        {
            $id=$price_1cat['goods_id'];
            $price=round($price_1cat['category_price']*$percent);
            $query="UPDATE goodshascategory SET goodshascategory_active=1 ".
                "category_price=$price ".
                "WHERE goods_id=$id AND category_id=$cat1a";
            mysqli_query($db_connect,$query);
        }
    }


}

//vika
add_cat(119,129,4);
//katun
add_cat(17,542,5);
//uyut
add_cat(33,620,4);

?>