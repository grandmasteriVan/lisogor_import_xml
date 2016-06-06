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

/**
 * @param $cat1 integer id первой категории цен
 * @param $cat1a integer id категории 1а
 * @param $percent integer процент, на который отличается категория 1а от 1
 * @param $currency boolean ценны в валюте. истинна - если да, ложь - если нет. По умолчанию цены в гривнах.
 * функция проставляет цены в категрии 1а
 */
function add_cat($cat1, $cat1a, $percent, $currency=false)
{
    $percent=(100-$percent)/100;
    $db_connect=mysqli_connect(host,user,pass,db);
    //prices in foreign currency
    if ($currency)
    {
        $query="SELECT goods_id, goodshascategory_pricecur FROM goodshascategory WHERE category_id=$cat1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row=mysqli_fetch_assoc($res))
            {
                $price_1cat[]=$row;
            }
            echo "<pre>";
            print_r($price_1cat);
            echo "</pre>";
            foreach($price_1cat as $div)
            {
                //set price in catrgories
                $id=$div['goods_id'];
                $price=round($div['goodshascategory_pricecur']*$percent);
                $query="UPDATE goodshascategory SET goodshascategory_active=1, ".
                    "goodshascategory_pricecur=$price ".
                    "WHERE goods_id=$id AND category_id=$cat1a";
                if ($price!=0)
                {
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                }
                //set price in goods
                $query="UPDATE goods SET goods_pricecur=$price WHERE goods_id=$id";
                if ($price!=0)
                {
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                }


            }
        }
    }
    //цены не в валюте
    else
    {
        $query="SELECT goods_id, goodshascategory_price FROM goodshascategory WHERE category_id=$cat1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row=mysqli_fetch_assoc($res))
            {
                $price_1cat[]=$row;
            }
            echo "<pre>";
            print_r($price_1cat);
            echo "</pre>";
            foreach($price_1cat as $div)
            {
                $id=$div['goods_id'];
                $price=round($div['goodshascategory_price']*$percent);
                $query="UPDATE goodshascategory SET goodshascategory_active=1, ".
                    "goodshascategory_price=$price ".
                    "WHERE goods_id=$id AND category_id=$cat1a";
                if ($price!=0)
                {
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                }
                $query="UPDATE goods SET goods_price=$price WHERE goods_id=$id";
                if ($price!=0)
                {
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                }

            }
        }
    }




}

//vika
add_cat(119,129,4,true);
//katun
add_cat(17,542,5,true);
//uyut
add_cat(33,620,4,true);

?>