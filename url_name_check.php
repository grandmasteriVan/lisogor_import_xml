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
define ("user", "root");
//define ("user", "fm");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "T6n7C8r1");
/**
 * database name
 */
define ("db", "mebli");
//define ("db", "fm");


define ("host_ddn","es835db.mirohost.net");
define ("user_ddn", "u_fayni");
define ("pass_ddn", "ZID1c0eud3Dc");
define ("db_ddn", "ddnPZS");



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
    $name=str_replace(" софа", "",$name);
    $name=str_replace("софа ", "",$name);
	$name=str_replace(" Софа", "",$name);
    $name=str_replace("Софа ", "",$name);
    
	
	$name=str_replace("уголок ", "",$name);
    $name=str_replace(" уголок", "",$name);
    $name=str_replace(" Кухонный", "",$name);
    $name=str_replace("Кухонный ", "",$name);
	
	$name=str_replace(" угол", "",$name);
    $name=str_replace("угол ", "",$name);
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
	$name=str_replace("-", " ",$name);
	$name=str_replace(" ", "-",$name);
	$name=str_replace("--", "-",$name);
	$name=str_replace("---", "-",$name);
	$name=str_replace("(", "",$name);
	$name=str_replace(")", "",$name);
	$name=str_replace("--", "-",$name);
	
    $name=mb_strtolower($name);
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
			
            $name_new=stripName($name);
			//$name_new=" ".$name_new." ";
			$url=" ".$url." ";
			
            if (!mb_strpos($url,$name_new))
            {
                echo "$id: name=<b>$name</b>/$name_new url=$url<br>";
            }
        }
    }
    else
    {
        echo "No array!<br>";
    }
}
else
{
	echo "Error in SQL ".mysqli_error($db_connect)."<br>";
}
mysqli_close($db_connect);

echo "<br><br><br><b>DDN</b><br>";
$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
$query="SELECT goodshaslang_name, goodshaslang_url FROM goodshaslang WHERE lang_id=1";
unset ($goods);
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
            //$id=$good['goods_id'];
            $name=$good['goodshaslang_name'];
            $url=$good['goodshaslang_url'];
			
            $name_new=stripName($name);
			//$name_new=" ".$name_new." ";
			$url=" ".$url." ";
			
            if (!mb_strpos($url,$name_new))
            {
                echo "name=<b>$name</b>/$name_new url=$url<br>";
            }
        }
    }
    else
    {
        echo "No array!<br>";
    }
}
else
{
	echo "Error in SQL ".mysqli_error($db_connect)."<br>";
}
mysqli_close($db_connect);
