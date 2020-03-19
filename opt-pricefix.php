<?php
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
//define ("host","localhost");
/**
 *
 */
define ("host","localhost");
/**
 * database username
 */
//define ("user", "root");
define ("user", "optmebli");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "VRYA1Q0R");
/**
 * database name
 */
//define ("db", "opt");
define ("db", "optmebli");

function getMainGoods()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id FROM goods WHERE goods_mod=0";
		if ($res=mysqli_query($db_connect,$query))
		{		
            while ($row = mysqli_fetch_assoc($res))
			{
				$goods_all[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
		return $goods_all;
}

function getMinPriceChild($id)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT min(goods_price) FROM goods WHERE goods_mod=$id";
		if ($res=mysqli_query($db_connect,$query))
		{		
            while ($row = mysqli_fetch_assoc($res))
			{
				$goods_all[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
		return $goods_all[0]['min(goods_price)'];
}

function updatePrice($id,$price)
{
    $db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goods SET goods_price=$price,goods_priceorder=$price  WHERE goods_id=$id";
		echo "$query<br>";
		//echo "$id rewrited!<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
}

$goodsMain=getMainGoods();
foreach ($goodsMain as $good)
{
    $id=$good['goods_id'];
    $minPrice=getMinPriceChild($id);
    echo "$id-$minPrice<br>";
    updatePrice($id,$minPrice);
}