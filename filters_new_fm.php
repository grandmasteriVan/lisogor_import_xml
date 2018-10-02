<?php
//header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
//define ("host","localhost");
define ("host","localhost");
/**
 * database username
 */
//define ("user", "root");
define ("user", "newfm");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "N0r7F8g6");
/**
 * database name
 */
//define ("db", "fm_new");
define ("db", "newfm");

function getGoods($cat_id=98)
{
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="select goods_id from goodshascategory WHERE category_id=$cat_id";
	if ($res=mysqli_query($db_connect,$query))
	{
			while ($row = mysqli_fetch_assoc($res))
			{
				$goods[] = $row;
			}
	}
	else
	{
		 echo "Error in SQL: $query<br>";		
	}
	mysqli_close($db_connect);
	if (is_array($goods))
	{
		return $goods;
	}
	else
	{
		return null;
	}
}

function getFeatures($good_id)
{
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="select goodshasfeature_valueid, feature_id from goodshasfeature WHERE goods_id=$good_id";
	if ($res=mysqli_query($db_connect,$query))
	{
			while ($row = mysqli_fetch_assoc($res))
			{
				$goods[] = $row;
			}
	}
	else
	{
		 echo "Error in SQL: $query<br>";		
	}
	mysqli_close($db_connect);
	if (is_array($goods))
	{
		return $goods;
	}
	else
	{
		return null;
	}
}

function delFilter($goods_id, $feature_id, $value_id)
{
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id AND goodshasfeature_valueid=$value_id";
	mysqli_query($db_connect,$query);
	mysqli_close($db_connect);
}

function delFilterNum($goods_id, $feature_id, $value_id)
{
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id AND goodshasfeature_valuenum=$value_id";
	mysqli_query($db_connect,$query);
	mysqli_close($db_connect);
}

function insFilter($goods_id, $feature_id, $value_id)
{
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="INSERT INTO goodshasfeature (goods_id, feature_id, goodshasfeature_valueid) VALUES ($goods_id, $feature_id, $value_id)";
	mysqli_query($db_connect,$query);
	mysqli_close($db_connect);
}

function insFilterNum($goods_id, $feature_id, $value_id)
{
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="INSERT INTO goodshasfeature (goods_id, feature_id, goodshasfeature_valuenum) VALUES ($goods_id, $feature_id, $value_id)";
	mysqli_query($db_connect,$query);
	mysqli_close($db_connect);
}

$goods=getGoods();
//echo "<pre>";
//print_r ($goods);
//echo "</pre>";

if (is_array($goods))
{
	foreach ($goods as $good)
	{
		$id=$good['goods_id'];
		$filters=getFeatures($id);
		echo "Old filters for $id:"; 
		echo "<pre>";
		print_r ($filters);
		echo "</pre>";
		foreach ($filters as $filter)
		{
			$value_id=$filter['goodshasfeature_valueid'];
			$feature_id=$filter['feature_id'];
			if ($feature_id==224&&$value_id==2909)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 249, 3283);
				//создаем новый фильтр в товаре
				insFilter($id, 249, 3283);
			}
			if ($feature_id==224&&$value_id==2910)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 249, 3284);
				//создаем новый фильтр в товаре
				insFilter($id, 249, 3284);
			}
			if ($feature_id==155&&$value_id==3043)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 250, 3285);
				//создаем новый фильтр в товаре
				insFilter($id, 250, 3285);
			}
			if ($feature_id==155&&$value_id==3044)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 250, 3286);
				//создаем новый фильтр в товаре
				insFilter($id, 250, 3286);
			}
			if ($feature_id==155&&$value_id==3045)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 250, 3287);
				//создаем новый фильтр в товаре
				insFilter($id, 250, 3287);
			}
			if ($feature_id==225&&$value_id==3046)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 253, 3288);
				//создаем новый фильтр в товаре
				insFilter($id, 253, 3288);
			}
			if ($feature_id==225&&$value_id==3047)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 253, 3289);
				//создаем новый фильтр в товаре
				insFilter($id, 253, 3289);
			}
			if ($feature_id==198&&$value_id==3048)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 251, 3291);
				//создаем новый фильтр в товаре
				insFilter($id, 251, 3291);
			}
			if ($feature_id==198&&$value_id==3049)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 251, 3292);
				//создаем новый фильтр в товаре
				insFilter($id, 251, 3292);
			}
			if ($feature_id==226&&$value_id==3050)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilterNum($id, 252, 4);
				//создаем новый фильтр в товаре
				insFilterNum($id, 252, 4);
			}
			if ($feature_id==226&&$value_id==3051)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilterNum($id, 252, 6);
				//создаем новый фильтр в товаре
				insFilterNum($id, 252, 6);
			}
		}
		$filters=getFeatures($id);
		echo "New filters for $id:"; 
		echo "<pre>";
		print_r ($filters);
		echo "</pre>";
	    //break;
	}
}
else
{
	echo "No goods!<br>";
}
