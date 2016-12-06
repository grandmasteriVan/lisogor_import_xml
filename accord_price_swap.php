<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 06.12.16
 * Time: 11:13
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

class PriceSwap
{
    public function Swap()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT * FROM goods WHERE factory_id=142";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $price_hrn=$good['goods_price'];
                $price_dol=round($price_hrn/26.6,PHP_ROUND_HALF_UP);
                echo "$id = $price_dol<br>";
                $query="UPDATE goods SET goods_pricecur=$price_dol WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo "$query<br>";
            }

        }
        mysqli_close($db_connect);
    }
}

?>