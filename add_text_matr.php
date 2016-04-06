<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 06.04.16
 * Time: 09:20
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
function set_info()
{
    $query="SELECT goods_id, goods_content, goods_hkeyw, goods_fkeyw, goods_article FROM goods WHERE factory_id=124";
    $db_connect=mysqli_connect(host,user,pass,db);
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row=mysqli_fetch_assoc($res))
        {
            $arr[]=$row;
        }
        foreach ($arr as $row)
        {
            //$row['goods_content']=iconv("Windows-1251","UTF-8",$row['goods_content']);
			//$row['goods_hkeyw']=iconv("Windows-1251","UTF-8",$row['goods_hkeyw']);
			//$row['goods_fkeyw']=iconv("Windows-1251","UTF-8",$row['goods_fkeyw']);
			$id=$row['goods_id'];
			$admin_id=$row['goods_article'];
            $desc=$row['goods_content'].PHP_EOL."<p>Фабрика: EMM </p>";
            $header=str_replace("Мебель Сервис","Sleep&Fly",$row['goods_hkeyw']);
            $footer=str_replace("Мебелі Сервіс","Sleep&Fly",$row['goods_fkeyw']);
            $query="UPDATE goods SET goods_content='$desc', goods_hkeyw='$header', goods_fkeyw='$footer' WHERE goods_id=$id";
            mysqli_query($db_connect,$query);
            echo "$admin_id changed! $header $desc<br>";
        }
    }
}
set_info();
?>
