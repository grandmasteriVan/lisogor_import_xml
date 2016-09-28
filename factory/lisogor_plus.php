<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 28.09.16
 * Time: 15:25
 */

/**
 * database host
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

for ($i=1;$i<=10;$i++)
{
    $cat_id=627+$i;
    $strSQL="UPDATE goodshascategory ".
        "SET goodshascategory_price=goodshascategory_price+10 ".
        "WHERE goodshascategory.goods_id IN ".
        "(SELECT goods_id FROM goods WHERE (goods.factory_id=66)) ".
        "AND (goodshascategory.category_id=$cat_id)";
    //echo $strSQL."<br>";
    //break;
    mysqli_query($db_connect, $strSQL);
}
//записываем цену первой категории в таблицу goods
$strSQL="UPDATE goods SET goods_price=goods_price+10 WHERE factory_id=66";
mysqli_query($db_connect, $strSQL);

?>