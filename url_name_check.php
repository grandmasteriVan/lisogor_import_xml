<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 15.05.2018
 * Time: 11:21
 */
/**
 * database host
 */
//define ("host","localhost");
define ("host","localhost");
/**
 * database username
 */
///define ("user", "root");
define ("user", "fm");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "T6n7C8r1");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "fm");


define ("host","es835db.mirohost.net");

function stripName($name)
{
    $name=str_replace("Диван ", "",$name);
    $name=str_replace(" Диван", "",$name);
    $name=str_replace("диван ", "",$name);
    $name=str_replace(" диван", "",$name);
    $name=str_replace("Угловой ", "",$name);
    $name=str_replace(" Угловой", "",$name);
    $name=str_replace("угловой ", "",$name);
    $name=str_replace(" угловой", "",$name);
    $name=str_replace("Кресло ", "",$name);
    $name=str_replace(" Кресло", "",$name);
    $name=str_replace("кресло ", "",$name);
    $name=str_replace(" кресло", "",$name);
    $name=str_replace("Пуф ", "",$name);
    $name=str_replace(" Пуф", "",$name);
    $name=str_replace("пуф ", "",$name);
    $name=str_replace(" пуф", "",$name);
    $name=str_replace("Бескаркасная ", "",$name);
    $name=str_replace(" Бескаркасная", "",$name);
    $name=str_replace("бескаркасная ", "",$name);
    $name=str_replace(" бескаркасная", "",$name);
    $name=str_replace("груша ", "",$name);
    $name=str_replace(" груша", "",$name);

    $name=strtolower($name);
    return $name;
}


$db_connect=mysqli_connect(host,user,pass,db);
$query="SELECT goods_id, goods_name, goods_url FROM goods WHERE (goods_maintcharter=1 OR goods_maintcharter=2 OR goods_maintcharter=38 OR goods_maintcharter=41) AND goods_active=1";
if ($res=mysqli_query($db_connect,$query))
{
    while ($row = mysqli_fetch_assoc($res))
    {
        $goods[] = $row;
    }
    if (is_array($goods))
    {
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            $url=$good['goods_url'];
            $name=stripName($name);

            if (strpos($url,$name)===false)
            {
                echo "$id: name=$name url=$url<br>";
            }


        }
    }
    else
    {
        echo "No array!<br>";
    }
}
mysqli_close($db_connect);