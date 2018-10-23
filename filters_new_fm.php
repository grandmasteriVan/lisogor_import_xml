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

function getSize($id)
{
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="select goods_width, goods_length, goods_height from goods WHERE goods_id=$id";
	if ($res=mysqli_query($db_connect,$query))
	{
			while ($row = mysqli_fetch_assoc($res))
			{
				$sizes[] = $row;
			}
	}
	else
	{
		 echo "Error in SQL: $query<br>";		
	}
	mysqli_close($db_connect);
	if (is_array($sizes))
	{
		return $sizes;
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
	//echo "$query<br><br>";
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


function checkFilters ($id)
{
	$filters=getFeatures($id);
	foreach ($filters as $filter)
    {
            $feature_id[]=$filter['feature_id'];
    }
	if (!in_array(286,$feature_id))
    {
        echo "В товаре с ид=$id не проставлен размер по ширине!<br>";
    }
	if (!in_array(287,$feature_id))
    {
        echo "В товаре с ид=$id не проставлен размер по высоте!<br>";
    }
	if (!in_array(288,$feature_id))
    {
        echo "В товаре с ид=$id не проставлен размер по глубине!<br>";
    }
	if (!in_array(289,$feature_id))
    {
        echo "В товаре с ид=$id не проставлен материал корпуса!<br>";
    }
	if (!in_array(290,$feature_id))
    {
        echo "В товаре с ид=$id не проставлен материал фасада!<br>";
    }
	if (!in_array(291,$feature_id))
    {
        echo "В товаре с ид=$id не проставлено количество фасадов!<br>";
    }
	if (!in_array(315,$feature_id))
    {
        echo "В товаре с ид=$id не проставлен цвет!<br>";
    }
	if (!in_array(292,$feature_id))
    {
        echo "В товаре с ид=$id не проставлена форма!<br>";
    }
	if (!in_array(293,$feature_id))
    {
        echo "В товаре с ид=$id не проставлена особенность!<br>";
    }
	if (!in_array(294,$feature_id))
    {
        echo "В товаре с ид=$id не проставлено место расположение!<br>";
    }
	if (!in_array(295,$feature_id))
    {
        echo "В товаре с ид=$id не проставлен стиль!<br>";
    }
    
	return;
}

function setFilters($category_id)
{
	$goods=getGoods($category_id);
	if (is_array($goods))
	{
		foreach ($goods as $good)
		{
			$good_id=$good['goods_id'];
			$filters=getFeatures($good_id);
			echo "Old filters for $id:"; 
			echo "<pre>";
			print_r ($filters);
			echo "</pre>";
			
			if (is_array($filters))
			{
				foreach ($filters as $filter)
				{
					$value_id=$filter['goodshasfeature_valueid'];
					$feature_id=$filter['feature_id'];
					//делаем отдельный блок проверки фильтров для каждой категории
					//кровати
					if ($category_id==13)
					{
						if ($feature_id==227&&$value_id==3181)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 316, 3604);
							//создаем новый фильтр в товаре
							insFilter($id, 316, 3604);
						}
						if ($feature_id==227&&$value_id==3182)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 316, 3605);
							//создаем новый фильтр в товаре
							insFilter($id, 316, 3605);
						}
						if ($feature_id==227&&$value_id==3184)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 316, 3606);
							//создаем новый фильтр в товаре
							insFilter($id, 316, 3606);
						}
						if ($feature_id==227&&$value_id==3187)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 316, 3607);
							//создаем новый фильтр в товаре
							insFilter($id, 316, 3607);
						}
						if ($feature_id==227&&$value_id==3188)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 316, 3608);
							//создаем новый фильтр в товаре
							insFilter($id, 316, 3608);
						}
						if ($feature_id==227&&$value_id==3189)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 316, 3609);
							//создаем новый фильтр в товаре
							insFilter($id, 316, 3609);
						}
						if ($feature_id==227&&$value_id==3190)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 316, 3610);
							//создаем новый фильтр в товаре
							insFilter($id, 316, 3610);
						}
						if ($feature_id==227&&$value_id==3193)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 316, 3612);
							//создаем новый фильтр в товаре
							insFilter($id, 316, 3612);
						}
						if ($feature_id==227&&$value_id==3194)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 316, 3613);
							//создаем новый фильтр в товаре
							insFilter($id, 316, 3613);
						}
						if ($feature_id==227&&$value_id==3198)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 316, 3615);
							//создаем новый фильтр в товаре
							insFilter($id, 316, 3615);
						}
						if ($feature_id==227&&$value_id==3191)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 316, 3611);
							//создаем новый фильтр в товаре
							insFilter($id, 316, 3611);
						}
						if ($feature_id==227&&$value_id==3197)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 316, 3614);
							//создаем новый фильтр в товаре
							insFilter($id, 316, 3614);
						}
						
						if ($feature_id==47&&$value_id==356)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 317, 3618);
							//создаем новый фильтр в товаре
							insFilter($id, 317, 3618);
						}
						if ($feature_id==47&&$value_id==357)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 317, 3619);
							//создаем новый фильтр в товаре
							insFilter($id, 317, 3619);
						}
						if ($feature_id==47&&$value_id==359)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 317, 3620);
							//создаем новый фильтр в товаре
							insFilter($id, 317, 3620);
						}
						if ($feature_id==47&&$value_id==361)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 317, 3621);
							//создаем новый фильтр в товаре
							insFilter($id, 317, 3621);
						}
						if ($feature_id==47&&$value_id==362)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 317, 3622);
							//создаем новый фильтр в товаре
							insFilter($id, 317, 3622);
						}
						
						if ($feature_id==50&&$value_id==368)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 318, 3623);
							//создаем новый фильтр в товаре
							insFilter($id, 318, 3623);
						}
						if ($feature_id==50&&$value_id==366)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 318, 3624);
							//создаем новый фильтр в товаре
							insFilter($id, 318, 3624);
						}
						if ($feature_id==50&&$value_id==371)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 318, 3625);
							//создаем новый фильтр в товаре
							insFilter($id, 318, 3625);
						}
						if ($feature_id==50&&$value_id==369)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 318, 3626);
							//создаем новый фильтр в товаре
							insFilter($id, 318, 3626);
						}
						if ($feature_id==50&&$value_id==372)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 318, 3627);
							//создаем новый фильтр в товаре
							insFilter($id, 318, 3627);
						}
						
						if ($feature_id==6&&$value_id==577)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3298);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3298);
						}
						if ($feature_id==6&&$value_id==579)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3299);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3299);
						}
						if ($feature_id==6&&$value_id==581)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3302);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3302);
						}
						if ($feature_id==6&&$value_id==582)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3304);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3304);
						}
						if ($feature_id==6&&$value_id==573)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3306);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3306);
						}
						if ($feature_id==6&&$value_id==594)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3309);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3309);
						}
						if ($feature_id==6&&$value_id==567)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3310);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3310);
						}
						if ($feature_id==6&&$value_id==569)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3312);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3312);
						}
						if ($feature_id==6&&$value_id==574)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3601);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3601);
						}
						if ($feature_id==6&&$value_id==575)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3602);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3602);
						}
						if ($feature_id==6&&$value_id==566)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3602);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3602);
						}
						if ($feature_id==6&&$value_id==576)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3313);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3313);
						}
						if ($feature_id==6&&$value_id==586)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3314);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3314);
						}
						if ($feature_id==6&&$value_id==588)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3316);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3316);
						}
						if ($feature_id==6&&$value_id==571)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 319, 3318);
							//создаем новый фильтр в товаре
							insFilter($id, 319, 3318);
						}
						
						if ($feature_id==49&&$value_id==857)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 320, 3628);
							//создаем новый фильтр в товаре
							insFilter($id, 320, 3628);
						}
						if ($feature_id==49&&$value_id==856)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 320, 3629);
							//создаем новый фильтр в товаре
							insFilter($id, 320, 3629);
						}
						if ($feature_id==49&&$value_id==855)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 320, 3630);
							//создаем новый фильтр в товаре
							insFilter($id, 320, 3630);
						}
						if ($feature_id==49&&$value_id==858)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 320, 3630);
							//создаем новый фильтр в товаре
							insFilter($id, 320, 3630);
						}
						if ($feature_id==49&&$value_id==854)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 320, 3631);
							//создаем новый фильтр в товаре
							insFilter($id, 320, 3631);
						}
						
						if ($feature_id==48&&$value_id==848)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 321, 3633);
							//создаем новый фильтр в товаре
							insFilter($id, 321, 3633);
						}
						if ($feature_id==48&&$value_id==853)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 321, 3634);
							//создаем новый фильтр в товаре
							insFilter($id, 321, 3634);
						}
						
						if ($feature_id==17&&$value_id==725)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 324, 3641);
							//создаем новый фильтр в товаре
							insFilter($id, 324, 3641);
						}
						if ($feature_id==17&&$value_id==726)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 324, 3640);
							//создаем новый фильтр в товаре
							insFilter($id, 324, 3640);
						}
						if ($feature_id==17&&$value_id==717)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 324, 3640);
							//создаем новый фильтр в товаре
							insFilter($id, 324, 3640);
						}
						
						if ($feature_id==18&&$value_id==232)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 322, 3343);
							//создаем новый фильтр в товаре
							insFilter($id, 322, 3343);
						}
						if ($feature_id==18&&$value_id==236)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 322, 3343);
							//создаем новый фильтр в товаре
							insFilter($id, 322, 3343);
						}
						if ($feature_id==18&&$value_id==231)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 322, 3344);
							//создаем новый фильтр в товаре
							insFilter($id, 322, 3344);
						}
						if ($feature_id==18&&$value_id==227)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 322, 3344);
							//создаем новый фильтр в товаре
							insFilter($id, 322, 3344);
						}
						if ($feature_id==18&&$value_id==241)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 322, 3345);
							//создаем новый фильтр в товаре
							insFilter($id, 322, 3345);
						}
						if ($feature_id==18&&$value_id==235)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 322, 3347);
							//создаем новый фильтр в товаре
							insFilter($id, 322, 3347);
						}
						if ($feature_id==18&&$value_id==233)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 322, 3348);
							//создаем новый фильтр в товаре
							insFilter($id, 322, 3348);
						}
						
						if ($feature_id==50&&$value_id==367)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 323, 3636);
							//создаем новый фильтр в товаре
							insFilter($id, 323, 3636);
						}
						if ($feature_id==48&&$value_id==851)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 323, 3635);
							//создаем новый фильтр в товаре
							insFilter($id, 323, 3635);
						}
						if ($feature_id==48&&$value_id==849)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 323, 3635);
							//создаем новый фильтр в товаре
							insFilter($id, 323, 3635);
						}
						if ($feature_id==50&&$value_id==386)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 323, 3639);
							//создаем новый фильтр в товаре
							insFilter($id, 323, 3639);
						}	
					}
					//спальни
					if ($category_id==3)
					{
						if ($feature_id==16&&$value_id==698)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 325, 3645);
							//создаем новый фильтр в товаре
							insFilter($id, 325, 3645);
						}
						if ($feature_id==16&&$value_id==697)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 325, 3646);
							//создаем новый фильтр в товаре
							insFilter($id, 325, 3646);
						}
						if ($feature_id==16&&$value_id==700)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 325, 3646);
							//создаем новый фильтр в товаре
							insFilter($id, 325, 3646);
						}
						
						if ($feature_id==15&&$value_id==676)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 326, 3649);
							//создаем новый фильтр в товаре
							insFilter($id, 326, 3649);
						}	
						if ($feature_id==15&&$value_id==682)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 326, 3649);
							//создаем новый фильтр в товаре
							insFilter($id, 326, 3649);
						}
						if ($feature_id==15&&$value_id==675)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 326, 3650);
							//создаем новый фильтр в товаре
							insFilter($id, 326, 3650);
						}
						if ($feature_id==15&&$value_id==679)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 326, 3650);
							//создаем новый фильтр в товаре
							insFilter($id, 326, 3650);
						}
						
						if ($feature_id==6&&$value_id==579)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 327, 3299);
							//создаем новый фильтр в товаре
							insFilter($id, 327, 3299);
						}
						if ($feature_id==6&&$value_id==573)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 327, 3306);
							//создаем новый фильтр в товаре
							insFilter($id, 327, 3306);
						}
						
						if ($feature_id==18&&$value_id==232)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 328, 3343);
							//создаем новый фильтр в товаре
							insFilter($id, 328, 3343);
						}
						if ($feature_id==18&&$value_id==230)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 328, 3343);
							//создаем новый фильтр в товаре
							insFilter($id, 328, 3343);
						}
						if ($feature_id==18&&$value_id==231)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 328, 3344);
							//создаем новый фильтр в товаре
							insFilter($id, 328, 3344);
						}
						if ($feature_id==18&&$value_id==227)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 328, 3344);
							//создаем новый фильтр в товаре
							insFilter($id, 328, 3344);
						}
						if ($feature_id==18&&$value_id==227)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 328, 3344);
							//создаем новый фильтр в товаре
							insFilter($id, 328, 3344);
						}	
					
					}
					//шкафы
					if ($category_id==10)
					{
						if ($feature_id==233&&$value_id==470)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 330, 3664);
							//создаем новый фильтр в товаре
							insFilter($id, 330, 3664);
						}
						if ($feature_id==233&&$value_id==497)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 330, 3664);
							//создаем новый фильтр в товаре
							insFilter($id, 330, 3664);
						}
						if ($feature_id==201&&$value_id==2890)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 330, 3664);
							//создаем новый фильтр в товаре
							insFilter($id, 330, 3664);
						}
						if ($feature_id==233&&$value_id==498)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 330, 3665);
							//создаем новый фильтр в товаре
							insFilter($id, 330, 3665);
						}
						if ($feature_id==233&&$value_id==510)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 330, 3665);
							//создаем новый фильтр в товаре
							insFilter($id, 330, 3665);
						}
						if ($feature_id==201&&$value_id==2888)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 330, 3665);
							//создаем новый фильтр в товаре
							insFilter($id, 330, 3665);
						}
						if ($feature_id==233&&$value_id==511)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 330, 3666);
							//создаем новый фильтр в товаре
							insFilter($id, 330, 3666);
						}
						if ($feature_id==201&&$value_id==2886)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 330, 3666);
							//создаем новый фильтр в товаре
							insFilter($id, 330, 3666);
						}
						if ($feature_id==233&&$value_id==464)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 330, 3667);
							//создаем новый фильтр в товаре
							insFilter($id, 330, 3667);
						}
						if ($feature_id==233&&$value_id==465)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 330, 3667);
							//создаем новый фильтр в товаре
							insFilter($id, 330, 3667);
						}
						if ($feature_id==201&&$value_id==2887)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 330, 3667);
							//создаем новый фильтр в товаре
							insFilter($id, 330, 3667);
						}
						if ($feature_id==233&&$value_id==471)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 330, 3668);
							//создаем новый фильтр в товаре
							insFilter($id, 330, 3668);
						}
						if ($feature_id==198&&$value_id==2923)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 330, 3668);
							//создаем новый фильтр в товаре
							insFilter($id, 330, 3668);
						}
						
						if ($feature_id==16&&$value_id==696)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 332, 3670);
							//создаем новый фильтр в товаре
							insFilter($id, 332, 3670);
						}
						if ($feature_id==16&&$value_id==698)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 332, 3671);
							//создаем новый фильтр в товаре
							insFilter($id, 332, 3671);
						}
						if ($feature_id==16&&$value_id==697)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 332, 3672);
							//создаем новый фильтр в товаре
							insFilter($id, 332, 3672);
						}
						if ($feature_id==16&&$value_id==700)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 332, 3672);
							//создаем новый фильтр в товаре
							insFilter($id, 332, 3672);
						}
						if ($feature_id==16&&$value_id==699)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 332, 3674);
							//создаем новый фильтр в товаре
							insFilter($id, 332, 3674);
						}
						if ($feature_id==16&&$value_id==708)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 332, 3674);
							//создаем новый фильтр в товаре
							insFilter($id, 332, 3674);
						}
						
						if ($feature_id==215&&$value_id==352)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 333, 3675);
							//создаем новый фильтр в товаре
							insFilter($id, 333, 3675);
						}
						if ($feature_id==215&&$value_id==349)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 333, 3675);
							//создаем новый фильтр в товаре
							insFilter($id, 333, 3675);
						}
						if ($feature_id==215&&$value_id==353)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 333, 3676);
							//создаем новый фильтр в товаре
							insFilter($id, 333, 3676);
						}
						if ($feature_id==215&&$value_id==354)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 333, 3677);
							//создаем новый фильтр в товаре
							insFilter($id, 333, 3677);
						}
						if ($feature_id==215&&$value_id==350)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 333, 3677);
							//создаем новый фильтр в товаре
							insFilter($id, 333, 3677);
						}
						if ($feature_id==215&&$value_id==355)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 333, 3678);
							//создаем новый фильтр в товаре
							insFilter($id, 333, 3678);
						}
						if ($feature_id==215&&$value_id==346)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 333, 3678);
							//создаем новый фильтр в товаре
							insFilter($id, 333, 3678);
						}
						
						if ($feature_id==15&&$value_id==674)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 334, 3679);
							//создаем новый фильтр в товаре
							insFilter($id, 334, 3679);
						}
						if ($feature_id==15&&$value_id==676)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 334, 3680);
							//создаем новый фильтр в товаре
							insFilter($id, 334, 3680);
						}
						if ($feature_id==15&&$value_id==682)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 334, 3680);
							//создаем новый фильтр в товаре
							insFilter($id, 334, 3680);
						}
						if ($feature_id==15&&$value_id==688)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 334, 3680);
							//создаем новый фильтр в товаре
							insFilter($id, 334, 3680);
						}
						if ($feature_id==15&&$value_id==679)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 334, 3681);
							//создаем новый фильтр в товаре
							insFilter($id, 334, 3681);
						}
						if ($feature_id==15&&$value_id==675)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 334, 3681);
							//создаем новый фильтр в товаре
							insFilter($id, 334, 3681);
						}
						
						if ($feature_id==15&&$value_id==677)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 334, 3682);
							//создаем новый фильтр в товаре
							insFilter($id, 334, 3682);
						}
						if ($feature_id==15&&$value_id==681)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 334, 3682);
							//создаем новый фильтр в товаре
							insFilter($id, 334, 3682);
						}
						if ($feature_id==15&&$value_id==692)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 334, 3682);
							//создаем новый фильтр в товаре
							insFilter($id, 334, 3682);
						}
						if ($feature_id==15&&$value_id==684)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 334, 3684);
							//создаем новый фильтр в товаре
							insFilter($id, 334, 3684);
						}
						if ($feature_id==15&&$value_id==687)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 334, 3684);
							//создаем новый фильтр в товаре
							insFilter($id, 334, 3684);
						}
						
						if ($feature_id==6&&$value_id==579)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 331, 3299);
							//создаем новый фильтр в товаре
							insFilter($id, 331, 3299);
						}
						if ($feature_id==6&&$value_id==580)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 331, 3300);
							//создаем новый фильтр в товаре
							insFilter($id, 331, 3300);
						}
						if ($feature_id==6&&$value_id==581)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 331, 3302);
							//создаем новый фильтр в товаре
							insFilter($id, 331, 3302);
						}
						if ($feature_id==6&&$value_id==573)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 331, 3306);
							//создаем новый фильтр в товаре
							insFilter($id, 331, 3306);
						}
						if ($feature_id==6&&$value_id==591)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 331, 3306);
							//создаем новый фильтр в товаре
							insFilter($id, 331, 3306);
						}
						if ($feature_id==6&&$value_id==569)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 331, 3312);
							//создаем новый фильтр в товаре
							insFilter($id, 331, 3312);
						}
						if ($feature_id==6&&$value_id==586)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 331, 3314);
							//создаем новый фильтр в товаре
							insFilter($id, 331, 3314);
						}
						if ($feature_id==6&&$value_id==574)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 331, 3601);
							//создаем новый фильтр в товаре
							insFilter($id, 331, 3601);
						}
						if ($feature_id==6&&$value_id==575)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 331, 3602);
							//создаем новый фильтр в товаре
							insFilter($id, 331, 3602);
						}
						if ($feature_id==6&&$value_id==566)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 331, 3602);
							//создаем новый фильтр в товаре
							insFilter($id, 331, 3602);
						}
						if ($feature_id==6&&$value_id==571)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 331, 3318);
							//создаем новый фильтр в товаре
							insFilter($id, 331, 3318);
						}
						
						if ($feature_id==198&&$value_id==2916)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 336, 3687);
							//создаем новый фильтр в товаре
							insFilter($id, 336, 3687);
						}
						if ($feature_id==201&&$value_id==2881)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 336, 3689);
							//создаем новый фильтр в товаре
							insFilter($id, 336, 3689);
						}
						if ($feature_id==198&&$value_id==3020)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 336, 3689);
							//создаем новый фильтр в товаре
							insFilter($id, 336, 3689);
						}
						if ($feature_id==198&&$value_id==3053)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 336, 3689);
							//создаем новый фильтр в товаре
							insFilter($id, 336, 3689);
						}
						if ($feature_id==198&&$value_id==2989)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 336, 3690);
							//создаем новый фильтр в товаре
							insFilter($id, 336, 3690);
						}
						
						if ($feature_id==19&&$value_id==728)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 337, 3697);
							//создаем новый фильтр в товаре
							insFilter($id, 337, 3697);
						}
						if ($feature_id==19&&$value_id==734)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 337, 3697);
							//создаем новый фильтр в товаре
							insFilter($id, 337, 3697);
						}
						if ($feature_id==19&&$value_id==733)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 337, 3698);
							//создаем новый фильтр в товаре
							insFilter($id, 337, 3698);
						}
						if ($feature_id==19&&$value_id==739)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 337, 3699);
							//создаем новый фильтр в товаре
							insFilter($id, 337, 3699);
						}
						
						if ($feature_id==128&&$value_id==3112)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 338, 3701);
							//создаем новый фильтр в товаре
							insFilter($id, 338, 3701);
						}
						if ($feature_id==128&&$value_id==3120)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 338, 3702);
							//создаем новый фильтр в товаре
							insFilter($id, 338, 3702);
						}
						if ($feature_id==128&&$value_id==3119)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 338, 3702);
							//создаем новый фильтр в товаре
							insFilter($id, 338, 3702);
						}
						if ($feature_id==128&&$value_id==3121)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 338, 3704);
							//создаем новый фильтр в товаре
							insFilter($id, 338, 3704);
						}
						
						if ($feature_id==154&&$value_id==3138)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 339, 3534);
							//создаем новый фильтр в товаре
							insFilter($id, 339, 3534);
						}
						if ($feature_id==154&&$value_id==3135)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 339, 3534);
							//создаем новый фильтр в товаре
							insFilter($id, 339, 3534);
						}
						if ($feature_id==154&&$value_id==3136)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 339, 3535);
							//создаем новый фильтр в товаре
							insFilter($id, 339, 3535);
						}
						if ($feature_id==154&&$value_id==3134)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 339, 3533);
							//создаем новый фильтр в товаре
							insFilter($id, 339, 3533);
						}
						if ($feature_id==154&&$value_id==3139)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 339, 3707);
							//создаем новый фильтр в товаре
							insFilter($id, 339, 3707);
						}
						if ($feature_id==154&&$value_id==3149)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 339, 3707);
							//создаем новый фильтр в товаре
							insFilter($id, 339, 3707);
						}
						if ($feature_id==154&&$value_id==3142)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 339, 3536);
							//создаем новый фильтр в товаре
							insFilter($id, 339, 3536);
						}
						
						if ($feature_id==18&&$value_id==232)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 335, 3343);
							//создаем новый фильтр в товаре
							insFilter($id, 335, 3343);
						}
						if ($feature_id==18&&$value_id==231)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 335, 3343);
							//создаем новый фильтр в товаре
							insFilter($id, 335, 3343);
						}
						if ($feature_id==18&&$value_id==236)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 335, 3343);
							//создаем новый фильтр в товаре
							insFilter($id, 335, 3343);
						}
						if ($feature_id==18&&$value_id==237)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 335, 3343);
							//создаем новый фильтр в товаре
							insFilter($id, 335, 3343);
						}
						if ($feature_id==18&&$value_id==227)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 335, 3344);
							//создаем новый фильтр в товаре
							insFilter($id, 335, 3344);
						}
						if ($feature_id==18&&$value_id==234)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 335, 3346);
							//создаем новый фильтр в товаре
							insFilter($id, 335, 3346);
						}
						if ($feature_id==18&&$value_id==235)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 335, 3347);
							//создаем новый фильтр в товаре
							insFilter($id, 335, 3347);
						}
						if ($feature_id==18&&$value_id==228)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 335, 3349);
							//создаем новый фильтр в товаре
							insFilter($id, 335, 3349);
						}
					}
					//тумбы
					if ($category_id==124)
					{
						if ($feature_id==16&&$value_id==696)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 349, 3736);
							//создаем новый фильтр в товаре
							insFilter($id, 349, 3736);
						}
						if ($feature_id==16&&$value_id==714)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 349, 3736);
							//создаем новый фильтр в товаре
							insFilter($id, 349, 3736);
						}
						if ($feature_id==16&&$value_id==698)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 349, 3737);
							//создаем новый фильтр в товаре
							insFilter($id, 349, 3737);
						}
						if ($feature_id==16&&$value_id==700)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 349, 3738);
							//создаем новый фильтр в товаре
							insFilter($id, 349, 3738);
						}
						if ($feature_id==16&&$value_id==697)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 349, 3738);
							//создаем новый фильтр в товаре
							insFilter($id, 349, 3738);
						}
						if ($feature_id==16&&$value_id==699)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 349, 3739);
							//создаем новый фильтр в товаре
							insFilter($id, 349, 3739);
						}
						if ($feature_id==16&&$value_id==715)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 349, 3741);
							//создаем новый фильтр в товаре
							insFilter($id, 349, 3741);
						}
						
						if ($feature_id==15&&$value_id==674)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 347, 3742);
							//создаем новый фильтр в товаре
							insFilter($id, 347, 3742);
						}
						if ($feature_id==15&&$value_id==691)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 347, 3742);
							//создаем новый фильтр в товаре
							insFilter($id, 347, 3742);
						}
						if ($feature_id==15&&$value_id==679)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 347, 3744);
							//создаем новый фильтр в товаре
							insFilter($id, 347, 3744);
						}
						if ($feature_id==15&&$value_id==675)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 347, 3744);
							//создаем новый фильтр в товаре
							insFilter($id, 347, 3744);
						}
						if ($feature_id==15&&$value_id==676)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 347, 3743);
							//создаем новый фильтр в товаре
							insFilter($id, 347, 3743);
						}
						if ($feature_id==15&&$value_id==682)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 347, 3743);
							//создаем новый фильтр в товаре
							insFilter($id, 347, 3743);
						}
						if ($feature_id==15&&$value_id==680)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 347, 3748);
							//создаем новый фильтр в товаре
							insFilter($id, 347, 3748);
						}
						if ($feature_id==15&&$value_id==677)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 347, 3745);
							//создаем новый фильтр в товаре
							insFilter($id, 347, 3745);
						}
						if ($feature_id==15&&$value_id==687)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 347, 3749);
							//создаем новый фильтр в товаре
							insFilter($id, 347, 3749);
						}
						if ($feature_id==15&&$value_id==684)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 347, 3749);
							//создаем новый фильтр в товаре
							insFilter($id, 347, 3749);
						}
						
						if ($feature_id==6&&$value_id==577)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3298);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3298);
						}
						if ($feature_id==6&&$value_id==579)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3299);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3299);
						}
						if ($feature_id==6&&$value_id==580)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3300);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3300);
						}
						if ($feature_id==6&&$value_id==581)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3302);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3302);
						}
						if ($feature_id==6&&$value_id==583)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3303);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3303);
						}
						if ($feature_id==6&&$value_id==582)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3304);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3304);
						}
						if ($feature_id==6&&$value_id==583)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3306);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3306);
						}
						if ($feature_id==6&&$value_id==576)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3313);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3313);
						}
						if ($feature_id==6&&$value_id==586)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3314);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3314);
						}
						if ($feature_id==6&&$value_id==588)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3316);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3316);
						}
						if ($feature_id==6&&$value_id==574)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3601);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3601);
						}
						if ($feature_id==6&&$value_id==575)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3602);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3602);
						}
						if ($feature_id==6&&$value_id==566)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3602);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3602);
						}
						if ($feature_id==6&&$value_id==571)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 342, 3318);
							//создаем новый фильтр в товаре
							insFilter($id, 342, 3318);
						}
						
						if ($feature_id==19&&$value_id==728)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 346, 3730);
							//создаем новый фильтр в товаре
							insFilter($id, 346, 3730);
						}
						if ($feature_id==19&&$value_id==734)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 346, 3730);
							//создаем новый фильтр в товаре
							insFilter($id, 346, 3730);
						}
						
						if ($feature_id==201&&$value_id==2891)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 344, 3716);
							//создаем новый фильтр в товаре
							insFilter($id, 344, 3716);
						}
						if ($feature_id==201&&$value_id==2892)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 344, 3717);
							//создаем новый фильтр в товаре
							insFilter($id, 344, 3717);
						}
						
						if ($feature_id==147&&$value_id==281)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 343, 3709);
							//создаем новый фильтр в товаре
							insFilter($id, 343, 3709);
						}
						if ($feature_id==147&&$value_id==279)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 343, 3710);
							//создаем новый фильтр в товаре
							insFilter($id, 343, 3710);
						}
						if ($feature_id==147&&$value_id==277)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 343, 3711);
							//создаем новый фильтр в товаре
							insFilter($id, 343, 3711);
						}
						if ($feature_id==147&&$value_id==278)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 343, 3711);
							//создаем новый фильтр в товаре
							insFilter($id, 343, 3711);
						}
						
						if ($feature_id==154&&$value_id==3138)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 341, 3534);
							//создаем новый фильтр в товаре
							insFilter($id, 341, 3534);
						}
						if ($feature_id==154&&$value_id==3135)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 341, 3534);
							//создаем новый фильтр в товаре
							insFilter($id, 341, 3534);
						}
						if ($feature_id==154&&$value_id==3137)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 341, 3533);
							//создаем новый фильтр в товаре
							insFilter($id, 341, 3533);
						}
						if ($feature_id==154&&$value_id==3136)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 341, 3535);
							//создаем новый фильтр в товаре
							insFilter($id, 341, 3535);
						}
						if ($feature_id==154&&$value_id==3142)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 341, 3536);
							//создаем новый фильтр в товаре
							insFilter($id, 341, 3536);
						}
						if ($feature_id==154&&$value_id==3139)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 341, 3707);
							//создаем новый фильтр в товаре
							insFilter($id, 341, 3707);
						}
						if ($feature_id==154&&$value_id==3149)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 341, 3707);
							//создаем новый фильтр в товаре
							insFilter($id, 341, 3707);
						}
						
						if ($feature_id==18&&$value_id==231)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 340, 3343);
							//создаем новый фильтр в товаре
							insFilter($id, 340, 3343);
						}
						if ($feature_id==18&&$value_id==227)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 340, 3344);
							//создаем новый фильтр в товаре
							insFilter($id, 340, 3344);
						}
						if ($feature_id==18&&$value_id==235)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 340, 3347);
							//создаем новый фильтр в товаре
							insFilter($id, 340, 3347);
						}
						if ($feature_id==18&&$value_id==240)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 340, 3347);
							//создаем новый фильтр в товаре
							insFilter($id, 340, 3347);
						}
						if ($feature_id==18&&$value_id==228)
						{
							//удаляем старый фильтр
							//delFilter($id, $feature_id, $value_id);
							//на всякий случай удаляем новый фильтр чтоб не было дублей
							delFilter($id, 340, 3349);
							//создаем новый фильтр в товаре
							insFilter($id, 340, 3349);
						}
					}
				}
			}
			
		}
	}
	else
	{
		echo "No goods for category=$category_id"
	}
	
}

$goods=getGoods(9);
//echo "<pre>";
//print_r ($goods);
//echo "</pre>";
foreach ($goods as $good)
{
	$id=$good['goods_id'];
	checkFilters($id);
	echo "<br><br>";
	//break;
	
	
}
/*
if (is_array($goods))
{
	foreach ($goods as $good)
	{
		$id=$good['goods_id'];
		$filters=getFeatures($id);
		//echo "Old filters for $id:"; 
		//echo "<pre>";
		//print_r ($filters);
		//fecho "</pre>";
		
		$sizes=getSize($id);
		$sizes=$sizes[0];
			var_dump($sizes);
			$width=$sizes['goods_width'];
			$len=$sizes['goods_length'];
			$height=$sizes['goods_height'];
		/*
		foreach ($filters as $filter)
		{
			$value_id=$filter['goodshasfeature_valueid'];
			$feature_id=$filter['feature_id'];
			/* каркасы
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
			*/
			
			/*полки 11*/
			/*
			if ($feature_id==16&&$value_id==697)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 254, 3293);
				//создаем новый фильтр в товаре
				insFilter($id, 254, 3293);
			}
			if ($feature_id==16&&$value_id==698)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 254, 3294);
				//создаем новый фильтр в товаре
				insFilter($id, 254, 3294);
			}
			if ($feature_id==16&&$value_id==699)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 254, 3295);
				//создаем новый фильтр в товаре
				insFilter($id, 254, 3295);
			}
			if ($feature_id==16&&$value_id==716)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 254, 3296);
				//создаем новый фильтр в товаре
				insFilter($id, 254, 3296);
			}
			if ($feature_id==16&&$value_id==703)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 254, 3297);
				//создаем новый фильтр в товаре
				insFilter($id, 254, 3297);
			}
			
			if ($feature_id==6&&$value_id==14)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3298);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3298);
			}
			if ($feature_id==6&&$value_id==16)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3299);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3299);
			}
			if ($feature_id==6&&$value_id==17)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3300);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3300);
			}
			if ($feature_id==6&&$value_id==32)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3301);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3301);
			}
			if ($feature_id==6&&$value_id==18)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3302);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3302);
			}
			if ($feature_id==6&&$value_id==20)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3303);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3303);
			}
			if ($feature_id==6&&$value_id==19)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3304);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3304);
			}
			if ($feature_id==6&&$value_id==33)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3305);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3305);
			}
			if ($feature_id==6&&$value_id==10)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3306);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3306);
			}
			if ($feature_id==6&&$value_id==21)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3307);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3307);
			}
			if ($feature_id==6&&$value_id==22)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3308);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3308);
			}
			if ($feature_id==6&&$value_id==31)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3309);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3309);
			}
			if ($feature_id==6&&$value_id==4)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3310);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3310);
			}
			if ($feature_id==6&&$value_id==34)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3311);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3311);
			}
			if ($feature_id==6&&$value_id==13)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3313);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3313);
			}
			if ($feature_id==6&&$value_id==23)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3314);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3314);
			}
			if ($feature_id==6&&$value_id==24)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3315);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3315);
			}
			if ($feature_id==6&&$value_id==25)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3316);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3316);
			}
			if ($feature_id==6&&$value_id==36)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3317);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3317);
			}
			if ($feature_id==6&&$value_id==8)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 255, 3318);
				//создаем новый фильтр в товаре
				insFilter($id, 255, 3318);
			}
			
			if ($feature_id==141&&$value_id==2839)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 108, 3319);
				//создаем новый фильтр в товаре
				insFilter($id, 108, 3319);
			}
			if ($feature_id==141&&$value_id==2903)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 108, 3320);
				//создаем новый фильтр в товаре
				insFilter($id, 108, 3320);
			}
			if ($feature_id==141&&$value_id==2881)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 108, 3321);
				//создаем новый фильтр в товаре
				insFilter($id, 108, 3321);
			}
			if ($feature_id==141&&$value_id==2894)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 108, 3322);
				//создаем новый фильтр в товаре
				insFilter($id, 108, 3322);
			}
			
			if ($feature_id==128&&$value_id==3120)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 257, 3323);
				//создаем новый фильтр в товаре
				insFilter($id, 257, 3323);
			}
			if ($feature_id==128&&$value_id==3119)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 257, 3326);
				//создаем новый фильтр в товаре
				insFilter($id, 257, 3326);
			}
			
			if ($feature_id==45&&$value_id==847)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 258, 3329);
				//создаем новый фильтр в товаре
				insFilter($id, 258, 3329);
			}
			if ($feature_id==45&&$value_id==844)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 258, 3330);
				//создаем новый фильтр в товаре
				insFilter($id, 258, 3330);
			}
			if ($feature_id==45&&$value_id==845)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 258, 3331);
				//создаем новый фильтр в товаре
				insFilter($id, 258, 3331);
			}
			if ($feature_id==45&&$value_id==842)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 258, 3332);
				//создаем новый фильтр в товаре
				insFilter($id, 258, 3332);
			}
			if ($feature_id==45&&$value_id==843)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 258, 3333);
				//создаем новый фильтр в товаре
				insFilter($id, 258, 3333);
			}
			
			if ($feature_id==198&&$value_id==3042)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 259, 3335);
				//создаем новый фильтр в товаре
				insFilter($id, 259, 3335);
			}
			if ($feature_id==198&&$value_id==3054)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 259, 3336);
				//создаем новый фильтр в товаре
				insFilter($id, 259, 3336);
			}
			if ($feature_id==198&&$value_id==3053)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 259, 3337);
				//создаем новый фильтр в товаре
				insFilter($id, 259, 3337);
			}
			
			if ($feature_id==154&&$value_id==3137)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 260, 3339);
				//создаем новый фильтр в товаре
				insFilter($id, 260, 3339);
			}
			if ($feature_id==154&&$value_id==3136)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 260, 3340);
				//создаем новый фильтр в товаре
				insFilter($id, 260, 3340);
			}
			if ($feature_id==154&&$value_id==3138)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 260, 3341);
				//создаем новый фильтр в товаре
				insFilter($id, 260, 3341);
			}
			if ($feature_id==154&&$value_id==3134)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 260, 3342);
				//создаем новый фильтр в товаре
				insFilter($id, 260, 3342);
			}
			
			if ($feature_id==18&&$value_id==232)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 261, 3343);
				//создаем новый фильтр в товаре
				insFilter($id, 261, 3343);
			}
			if ($feature_id==18&&$value_id==227)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 261, 3344);
				//создаем новый фильтр в товаре
				insFilter($id, 261, 3344);
			}
			if ($feature_id==18&&$value_id==241)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 261, 3345);
				//создаем новый фильтр в товаре
				insFilter($id, 261, 3345);
			}
			if ($feature_id==18&&$value_id==234)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 261, 3346);
				//создаем новый фильтр в товаре
				insFilter($id, 261, 3346);
			}
			if ($feature_id==18&&$value_id==235)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 261, 3347);
				//создаем новый фильтр в товаре
				insFilter($id, 261, 3347);
			}
			if ($feature_id==18&&$value_id==233)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 261, 3348);
				//создаем новый фильтр в товаре
				insFilter($id, 261, 3348);
			}
			if ($feature_id==18&&$value_id==228)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 261, 3349);
				//создаем новый фильтр в товаре
				insFilter($id, 261, 3349);
			}
			*/
			/*двери входные 77*/
			/*
			if ($feature_id==132&&$value_id==2770)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 263, 3352);
				//создаем новый фильтр в товаре
				insFilter($id, 263, 3352);
			}
			if ($feature_id==132&&$value_id==2769)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 263, 3356);
				//создаем новый фильтр в товаре
				insFilter($id, 263, 3356);
			}
			
			if ($feature_id==206&&$value_id==3159)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 265, 3358);
				//создаем новый фильтр в товаре
				insFilter($id, 265, 3358);
			}
			if ($feature_id==206&&$value_id==3172)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 265, 3360);
				//создаем новый фильтр в товаре
				insFilter($id, 265, 3360);
			}
			
			if ($feature_id==208&&$value_id==3173)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 271, 3387);
				//создаем новый фильтр в товаре
				insFilter($id, 271, 3387);
			}
			if ($feature_id==208&&$value_id==3174)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 271, 3388);
				//создаем новый фильтр в товаре
				insFilter($id, 271, 3388);
			}
			
			if ($feature_id==204&&$value_id==566)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 272, 3362);
				//создаем новый фильтр в товаре
				insFilter($id, 272, 3362);
			}
			if ($feature_id==204&&$value_id==577)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 272, 3365);
				//создаем новый фильтр в товаре
				insFilter($id, 272, 3365);
			}
			if ($feature_id==204&&$value_id==575)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 272, 3366);
				//создаем новый фильтр в товаре
				insFilter($id, 272, 3366);
			}
			if ($feature_id==204&&$value_id==564)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 272, 3367);
				//создаем новый фильтр в товаре
				insFilter($id, 272, 3367);
			}
			
			if ($feature_id==205&&$value_id==3166)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 269, 3376);
				//создаем новый фильтр в товаре
				insFilter($id, 269, 3376);
			}
			if ($feature_id==205&&$value_id==3163)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 269, 3373);
				//создаем новый фильтр в товаре
				insFilter($id, 269, 3373);
			}
			if ($feature_id==205&&$value_id==3164)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 269, 3374);
				//создаем новый фильтр в товаре
				insFilter($id, 269, 3374);
			}
			
			if ($feature_id==209&&$value_id==3145)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 273, 3390);
				//создаем новый фильтр в товаре
				insFilter($id, 273, 3390);
			}
			if ($feature_id==209&&$value_id==3146)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 273, 3391);
				//создаем новый фильтр в товаре
				insFilter($id, 273, 3390);
			}
			if ($feature_id==209&&$value_id==3147)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 273, 3392);
				//создаем новый фильтр в товаре
				insFilter($id, 273, 3392);
			}
			*/
			/*межкомнатные двери 76*/
			/*
			if ($feature_id==107&&$value_id==2768)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 262, 3350);
				//создаем новый фильтр в товаре
				insFilter($id, 262, 3350);
			}
			if ($feature_id==107&&$value_id==2771)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 262, 3351);
				//создаем новый фильтр в товаре
				insFilter($id, 262, 3351);
			}
			if ($feature_id==107&&$value_id==2770)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 262, 3352);
				//создаем новый фильтр в товаре
				insFilter($id, 262, 3352);
			}
			if ($feature_id==107&&$value_id==2772)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 262, 3353);
				//создаем новый фильтр в товаре
				insFilter($id, 262, 3353);
			}
			if ($feature_id==107&&$value_id==2773)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 262, 3354);
				//создаем новый фильтр в товаре
				insFilter($id, 262, 3354);
			}
			
			if ($feature_id==204&&$value_id==573)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 266, 3361);
				//создаем новый фильтр в товаре
				insFilter($id, 266, 3361);
			}
			if ($feature_id==204&&$value_id==566)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 266, 3362);
				//создаем новый фильтр в товаре
				insFilter($id, 266, 3362);
			}
			if ($feature_id==204&&$value_id==576)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 266, 3363);
				//создаем новый фильтр в товаре
				insFilter($id, 266, 3363);
			}
			if ($feature_id==204&&$value_id==575)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 266, 3366);
				//создаем новый фильтр в товаре
				insFilter($id, 266, 3366);
			}
			if ($feature_id==204&&$value_id==564)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 266, 3367);
				//создаем новый фильтр в товаре
				insFilter($id, 266, 3367);
			}
			
			if ($feature_id==139&&$value_id==2763)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 267, 3370);
				//создаем новый фильтр в товаре
				insFilter($id, 267, 3370);
			}
			
			if ($feature_id==206&&$value_id==3159)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 264, 3358);
				//создаем новый фильтр в товаре
				insFilter($id, 264, 3358);
			}
			if ($feature_id==206&&$value_id==3159)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 264, 3358);
				//создаем новый фильтр в товаре
				insFilter($id, 264, 3358);
			}
			
			if ($feature_id==205&&$value_id==3164)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 268, 3374);
				//создаем новый фильтр в товаре
				insFilter($id, 268, 3374);
			}
			if ($feature_id==205&&$value_id==3165)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 268, 3375);
				//создаем новый фильтр в товаре
				insFilter($id, 268, 3375);
			}
			if ($feature_id==205&&$value_id==3166)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 268, 3376);
				//создаем новый фильтр в товаре
				insFilter($id, 268, 3376);
			}
			
			if ($feature_id==154&&$value_id==3140)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 270, 3380);
				//создаем новый фильтр в товаре
				insFilter($id, 270, 3380);
			}
			if ($feature_id==154&&$value_id==3142)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 270, 3381);
				//создаем новый фильтр в товаре
				insFilter($id, 270, 3381);
			}
			if ($feature_id==154&&$value_id==3143)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 270, 3382);
				//создаем новый фильтр в товаре
				insFilter($id, 270, 3382);
			}
			if ($feature_id==154&&$value_id==3144)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 270, 3383);
				//создаем новый фильтр в товаре
				insFilter($id, 270, 3383);
			}
			if ($feature_id==154&&$value_id==3148)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 270, 3384);
				//создаем новый фильтр в товаре
				insFilter($id, 270, 3384);
			}
			if ($feature_id==154&&$value_id==3135)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 270, 3385);
				//создаем новый фильтр в товаре
				insFilter($id, 270, 3385);
			}
			if ($feature_id==154&&$value_id==3136)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 270, 3388);
				//создаем новый фильтр в товаре
				insFilter($id, 270, 3386);
			}
			*/
			
			/*фурнитура дверная 79*/
			/*
			if ($feature_id==113&&$value_id==2861)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 274, 3394);
				//создаем новый фильтр в товаре
				insFilter($id, 274, 3394);
			}
			if ($feature_id==113&&$value_id==2854)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 274, 3396);
				//создаем новый фильтр в товаре
				insFilter($id, 274, 3396);
			}
			if ($feature_id==113&&$value_id==2863)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 274, 3397);
				//создаем новый фильтр в товаре
				insFilter($id, 274, 3397);
			}
			if ($feature_id==113&&$value_id==2864)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 274, 3398);
				//создаем новый фильтр в товаре
				insFilter($id, 274, 3398);
			}
			
			if ($feature_id==113&&$value_id==2864)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 274, 3398);
				//создаем новый фильтр в товаре
				insFilter($id, 274, 3398);
			}
			*/
			
			/*матрасы 14*/
			/*
			if ($feature_id==211&&$value_id==3176)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 276, 3405);
				//создаем новый фильтр в товаре
				insFilter($id, 276, 3405);
			}
			if ($feature_id==211&&$value_id==3178)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 276, 3407);
				//создаем новый фильтр в товаре
				insFilter($id, 276, 3407);
			}
			if ($feature_id==211&&$value_id==3181)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 276, 3410);
				//создаем новый фильтр в товаре
				insFilter($id, 276, 3410);
			}
			if ($feature_id==211&&$value_id==3183)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 276, 3412);
				//создаем новый фильтр в товаре
				insFilter($id, 276, 3412);
			}
			if ($feature_id==211&&$value_id==3189)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 276, 3418);
				//создаем новый фильтр в товаре
				insFilter($id, 276, 3418);
			}
			if ($feature_id==211&&$value_id==3203)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 276, 3432);
				//создаем новый фильтр в товаре
				insFilter($id, 276, 3432);
			}
			
			if ($feature_id==93&&$value_id==1043)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 277, 3433);
				//создаем новый фильтр в товаре
				insFilter($id, 277, 3433);
			}
			if ($feature_id==93&&$value_id==1044)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 277, 3434);
				//создаем новый фильтр в товаре
				insFilter($id, 277, 3434);
			}
			if ($feature_id==93&&$value_id==1045)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 277, 3435);
				//создаем новый фильтр в товаре
				insFilter($id, 277, 3435);
			}
			if ($feature_id==93&&$value_id==1046)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 277, 3436);
				//создаем новый фильтр в товаре
				insFilter($id, 277, 3436);
			}
			if ($feature_id==93&&$value_id==1047)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 277, 3437);
				//создаем новый фильтр в товаре
				insFilter($id, 277, 3437);
			}
			
			if ($feature_id==33&&$value_id==834)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 278, 3438);
				//создаем новый фильтр в товаре
				insFilter($id, 278, 3438);
			}
			if ($feature_id==33&&$value_id==835)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 278, 3439);
				//создаем новый фильтр в товаре
				insFilter($id, 278, 3439);
			}
			if ($feature_id==33&&$value_id==836)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 278, 3440);
				//создаем новый фильтр в товаре
				insFilter($id, 278, 3440);
			}
			if ($feature_id==33&&$value_id==837)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 278, 3441);
				//создаем новый фильтр в товаре
				insFilter($id, 278, 3441);
			}
			
			if ($feature_id==192&&$value_id==2059)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 279, 3442);
				//создаем новый фильтр в товаре
				insFilter($id, 279, 3442);
			}
			if ($feature_id==192&&$value_id==2065)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 279, 3442);
				//создаем новый фильтр в товаре
				insFilter($id, 279, 3442);
			}
			if ($feature_id==192&&$value_id==2061)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 279, 3443);
				//создаем новый фильтр в товаре
				insFilter($id, 279, 3443);
			}
			
			if ($feature_id==52&&$value_id==861)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 280, 3445);
				//создаем новый фильтр в товаре
				insFilter($id, 280, 3445);
			}
			if ($feature_id==52&&$value_id==872)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 280, 3446);
				//создаем новый фильтр в товаре
				insFilter($id, 280, 3446);
			}
			if ($feature_id==52&&$value_id==873)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 280, 3447);
				//создаем новый фильтр в товаре
				insFilter($id, 280, 3447);
			}
			if ($feature_id==52&&$value_id==874)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 280, 3448);
				//создаем новый фильтр в товаре
				insFilter($id, 280, 3448);
			}
			if ($feature_id==52&&$value_id==875)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 280, 3449);
				//создаем новый фильтр в товаре
				insFilter($id, 280, 3449);
			}
			
			if ($feature_id==53&&$value_id==878)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 280, 3451);
				//создаем новый фильтр в товаре
				insFilter($id, 280, 3451);
			}
			if ($feature_id==53&&$value_id==879)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 280, 3454);
				//создаем новый фильтр в товаре
				insFilter($id, 280, 3454);
			}
			if ($feature_id==53&&$value_id==876)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 280, 3455);
				//создаем новый фильтр в товаре
				insFilter($id, 280, 3455);
			}
			if ($feature_id==53&&$value_id==884)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 280, 3603);
				//создаем новый фильтр в товаре
				insFilter($id, 280, 3603);
			}
			if ($feature_id==53&&$value_id==885)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 280, 3457);
				//создаем новый фильтр в товаре
				insFilter($id, 280, 3457);
			}
			
			if ($feature_id==55&&$value_id==944)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 282, 3458);
				//создаем новый фильтр в товаре
				insFilter($id, 282, 3458);
			}
			if ($feature_id==55&&$value_id==943)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 282, 3459);
				//создаем новый фильтр в товаре
				insFilter($id, 282, 3459);
			}
			if ($feature_id==55&&$value_id==942)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 282, 3460);
				//создаем новый фильтр в товаре
				insFilter($id, 282, 3460);
			}
			if ($feature_id==55&&$value_id==947)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 282, 3461);
				//создаем новый фильтр в товаре
				insFilter($id, 282, 3461);
			}
			
			if ($feature_id==54&&$value_id==890)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 283, 3462);
				//создаем новый фильтр в товаре
				insFilter($id, 283, 3462);
			}
			if ($feature_id==54&&$value_id==889)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 283, 3463);
				//создаем новый фильтр в товаре
				insFilter($id, 283, 3463);
			}
			if ($feature_id==54&&$value_id==938)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 283, 3465);
				//создаем новый фильтр в товаре
				insFilter($id, 283, 3465);
			}
			if ($feature_id==54&&$value_id==895)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 283, 3471);
				//создаем новый фильтр в товаре
				insFilter($id, 283, 3471);
			}
			if ($feature_id==54&&$value_id==939)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 283, 3466);
				//создаем новый фильтр в товаре
				insFilter($id, 283, 3466);
			}
			if ($feature_id==54&&$value_id==940)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 283, 3467);
				//создаем новый фильтр в товаре
				insFilter($id, 283, 3467);
			}
			if ($feature_id==54&&$value_id==898)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 283, 3468);
				//создаем новый фильтр в товаре
				insFilter($id, 283, 3468);
			}
			
			if ($feature_id==56&&$value_id==394)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 284, 3476);
				//создаем новый фильтр в товаре
				insFilter($id, 284, 3476);
			}
			if ($feature_id==56&&$value_id==395)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 284, 3477);
				//создаем новый фильтр в товаре
				insFilter($id, 284, 3477);
			}
			if ($feature_id==56&&$value_id==396)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 284, 3478);
				//создаем новый фильтр в товаре
				insFilter($id, 284, 3478);
			}
			if ($feature_id==56&&$value_id==397)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 284, 3479);
				//создаем новый фильтр в товаре
				insFilter($id, 284, 3479);
			}
			if ($feature_id==56&&$value_id==378)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 284, 3480);
				//создаем новый фильтр в товаре
				insFilter($id, 284, 3480);
			}
			
			if ($feature_id==212&&$value_id==373)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 285, 3482);
				//создаем новый фильтр в товаре
				insFilter($id, 285, 3482);
			}
			if ($feature_id==212&&$value_id==398)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 285, 3483);
				//создаем новый фильтр в товаре
				insFilter($id, 285, 3483);
			}
			*/
			
			/*стенки 5*/
			/*
			if ($feature_id==16&&$value_id==698)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 296, 3538);
				//создаем новый фильтр в товаре
				insFilter($id, 296, 3538);
			}
			if ($feature_id==16&&$value_id==697)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 296, 3539);
				//создаем новый фильтр в товаре
				insFilter($id, 296, 3539);
			}
			
			if ($feature_id==15&&$value_id==676)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 297, 3543);
				//создаем новый фильтр в товаре
				insFilter($id, 297, 3543);
			}
			if ($feature_id==15&&$value_id==675)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 297, 3544);
				//создаем новый фильтр в товаре
				insFilter($id, 297, 3544);
			}
			if ($feature_id==15&&$value_id==692)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 297, 3545);
				//создаем новый фильтр в товаре
				insFilter($id, 297, 3545);
			}
			if ($feature_id==15&&$value_id==677)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 297, 3545);
				//создаем новый фильтр в товаре
				insFilter($id, 297, 3545);
			}
			if ($feature_id==15&&$value_id==680)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 297, 3548);
				//создаем новый фильтр в товаре
				insFilter($id, 297, 3548);
			}
			
			if ($feature_id==6&&$value_id==577)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 298, 3298);
				//создаем новый фильтр в товаре
				insFilter($id, 298, 3298);
			}
			if ($feature_id==6&&$value_id==579)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 298, 3299);
				//создаем новый фильтр в товаре
				insFilter($id, 298, 3299);
			}
			if ($feature_id==6&&$value_id==581)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 298, 3302);
				//создаем новый фильтр в товаре
				insFilter($id, 298, 3302);
			}
			if ($feature_id==6&&$value_id==583)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 298, 3303);
				//создаем новый фильтр в товаре
				insFilter($id, 298, 3303);
			}
			if ($feature_id==6&&$value_id==573)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 298, 3306);
				//создаем новый фильтр в товаре
				insFilter($id, 298, 3306);
			}
			if ($feature_id==6&&$value_id==576)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 298, 3306);
				//создаем новый фильтр в товаре
				insFilter($id, 298, 3306);
			}
			if ($feature_id==6&&$value_id==585)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 298, 3308);
				//создаем новый фильтр в товаре
				insFilter($id, 298, 3308);
			}
			if ($feature_id==6&&$value_id==586)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 298, 3314);
				//создаем новый фильтр в товаре
				insFilter($id, 298, 3314);
			}
			if ($feature_id==6&&$value_id==571)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 298, 3318);
				//создаем новый фильтр в товаре
				insFilter($id, 298, 3318);
			}
			
			if ($feature_id==19&&$value_id==728)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 300, 3550);
				//создаем новый фильтр в товаре
				insFilter($id, 300, 3550);
			}
			if ($feature_id==19&&$value_id==734)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 300, 3550);
				//создаем новый фильтр в товаре
				insFilter($id, 300, 3550);
			}
			if ($feature_id==19&&$value_id==741)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 300, 3552);
				//создаем новый фильтр в товаре
				insFilter($id, 300, 3552);
			}
			if ($feature_id==19&&$value_id==742)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 300, 3553);
				//создаем новый фильтр в товаре
				insFilter($id, 300, 3553);
			}
			
			if ($feature_id==219&&$value_id==786)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 301, 3554);
				//создаем новый фильтр в товаре
				insFilter($id, 301, 3554);
			}
			if ($feature_id==219&&$value_id==787)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 301, 3555);
				//создаем новый фильтр в товаре
				insFilter($id, 301, 3555);
			}
			if ($feature_id==219&&$value_id==788)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 301, 3557);
				//создаем новый фильтр в товаре
				insFilter($id, 301, 3557);
			}
			if ($feature_id==219&&$value_id==778)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 301, 3558);
				//создаем новый фильтр в товаре
				insFilter($id, 301, 3558);
			}
			if ($feature_id==219&&$value_id==789)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 301, 3559);
				//создаем новый фильтр в товаре
				insFilter($id, 301, 3559);
			}
			if ($feature_id==219&&$value_id==790)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 301, 3560);
				//создаем новый фильтр в товаре
				insFilter($id, 301, 3560);
			}
			if ($feature_id==219&&$value_id==785)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 301, 3561);
				//создаем новый фильтр в товаре
				insFilter($id, 301, 3561);
			}
			
			if ($feature_id==154&&$value_id==3138)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 302, 3563);
				//создаем новый фильтр в товаре
				insFilter($id, 302, 3563);
			}
			if ($feature_id==154&&$value_id==3135)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 302, 3563);
				//создаем новый фильтр в товаре
				insFilter($id, 302, 3563);
			}
			if ($feature_id==154&&$value_id==3134)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 302, 3563);
				//создаем новый фильтр в товаре
				insFilter($id, 302, 3563);
			}
			
			if ($feature_id==18&&$value_id==232)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 299, 3543);
				//создаем новый фильтр в товаре
				insFilter($id, 299, 3543);
			}
			if ($feature_id==18&&$value_id==277)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 299, 3544);
				//создаем новый фильтр в товаре
				insFilter($id, 299, 3544);
			}
			if ($feature_id==18&&$value_id==235)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 299, 3547);
				//создаем новый фильтр в товаре
				insFilter($id, 299, 3547);
			}
			if ($feature_id==18&&$value_id==233)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 299, 3548);
				//создаем новый фильтр в товаре
				insFilter($id, 299, 3548);
			}
			if ($feature_id==18&&$value_id==228)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 299, 3549);
				//создаем новый фильтр в товаре
				insFilter($id, 299, 3549);
			}
			*/
			
			/*прихожие 4*/
			/*
			if ($feature_id==16&&$value_id==697)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 303, 3567);
				//создаем новый фильтр в товаре
				insFilter($id, 303, 3567);
			}
			if ($feature_id==16&&$value_id==699)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 303, 3568);
				//создаем новый фильтр в товаре
				insFilter($id, 303, 3568);
			}
			
			if ($feature_id==15&&$value_id==676)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 304, 3570);
				//создаем новый фильтр в товаре
				insFilter($id, 304, 3570);
			}
			if ($feature_id==15&&$value_id==675)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 304, 3571);
				//создаем новый фильтр в товаре
				insFilter($id, 304, 3571);
			}
			if ($feature_id==15&&$value_id==692)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 304, 3572);
				//создаем новый фильтр в товаре
				insFilter($id, 304, 3572);
			}
			if ($feature_id==15&&$value_id==678)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 304, 3573);
				//создаем новый фильтр в товаре
				insFilter($id, 304, 3573);
			}
			
			if ($feature_id==6&&$value_id==577)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3298);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3298);
			}
			if ($feature_id==6&&$value_id==579)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3299);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3299);
			}
			if ($feature_id==6&&$value_id==580)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3300);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3300);
			}
			if ($feature_id==6&&$value_id==581)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3302);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3302);
			}
			if ($feature_id==6&&$value_id==583)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3303);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3303);
			}
			if ($feature_id==6&&$value_id==573)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3306);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3306);
			}
			if ($feature_id==6&&$value_id==585)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3308);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3308);
			}
			if ($feature_id==6&&$value_id==594)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3309);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3309);
			}
			if ($feature_id==6&&$value_id==586)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3314);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3314);
			}
			if ($feature_id==6&&$value_id==587)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3315);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3315);
			}
			if ($feature_id==6&&$value_id==588)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3316);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3316);
			}
			if ($feature_id==6&&$value_id==571)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3318);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3318);
			}
			if ($feature_id==6&&$value_id==574)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3601);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3601);
			}
			if ($feature_id==6&&$value_id==566)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 305, 3602);
				//создаем новый фильтр в товаре
				insFilter($id, 305, 3602);
			}
			
			if ($feature_id==19&&$value_id==728)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 306, 3550);
				//создаем новый фильтр в товаре
				insFilter($id, 306, 3550);
			}
			if ($feature_id==19&&$value_id==733)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 306, 3511);
				//создаем новый фильтр в товаре
				insFilter($id, 306, 3511);
			}
			if ($feature_id==19&&$value_id==733)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 306, 3551);
				//создаем новый фильтр в товаре
				insFilter($id, 306, 3551);
			}
			if ($feature_id==19&&$value_id==742)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 306, 3553);
				//создаем новый фильтр в товаре
				insFilter($id, 306, 3553);
			}
			
			if ($feature_id==198&&$value_id==3029)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 308, 3577);
				//создаем новый фильтр в товаре
				insFilter($id, 308, 3577);
			}
			if ($feature_id==198&&$value_id==2991)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 308, 3578);
				//создаем новый фильтр в товаре
				insFilter($id, 308, 3578);
			}
			if ($feature_id==198&&$value_id==3025)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 308, 3580);
				//создаем новый фильтр в товаре
				insFilter($id, 308, 3580);
			}
			if ($feature_id==198&&$value_id==3026)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 308, 3581);
				//создаем новый фильтр в товаре
				insFilter($id, 308, 3581);
			}
			if ($feature_id==198&&$value_id==2995)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 308, 3582);
				//создаем новый фильтр в товаре
				insFilter($id, 308, 3582);
			}
			if ($feature_id==198&&$value_id==2926)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 308, 3584);
				//создаем новый фильтр в товаре
				insFilter($id, 308, 3584);
			}
			if ($feature_id==198&&$value_id==2923)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 308, 3584);
				//создаем новый фильтр в товаре
				insFilter($id, 308, 3584);
			}
			if ($feature_id==198&&$value_id==3023)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 308, 3585);
				//создаем новый фильтр в товаре
				insFilter($id, 308, 3585);
			}
			
			if ($feature_id==18&&$value_id==232)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 307, 3343);
				//создаем новый фильтр в товаре
				insFilter($id, 307, 3343);
			}
			if ($feature_id==18&&$value_id==227)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 307, 3344);
				//создаем новый фильтр в товаре
				insFilter($id, 307, 3344);
			}
			if ($feature_id==18&&$value_id==235)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 307, 3347);
				//создаем новый фильтр в товаре
				insFilter($id, 307, 3347);
			}
			if ($feature_id==18&&$value_id==233)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 307, 3348);
				//создаем новый фильтр в товаре
				insFilter($id, 307, 3348);
			}
			if ($feature_id==18&&$value_id==228)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 307, 3349);
				//создаем новый фильтр в товаре
				insFilter($id, 307, 3349);
			}
			*/
			
			/*модульные системы 40*/
			/*
			if ($feature_id==16&&$value_id==697)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 309, 3567);
				//создаем новый фильтр в товаре
				insFilter($id, 309, 3567);
			}
			
			if ($feature_id==15&&$value_id==676)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 310, 3570);
				//создаем новый фильтр в товаре
				insFilter($id, 310, 3570);
			}
			if ($feature_id==15&&$value_id==675)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 310, 3571);
				//создаем новый фильтр в товаре
				insFilter($id, 310, 3571);
			}
			if ($feature_id==15&&$value_id==692)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 310, 3572);
				//создаем новый фильтр в товаре
				insFilter($id, 310, 3572);
			}
			
			if ($feature_id==6&&$value_id==574)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 311, 3601);
				//создаем новый фильтр в товаре
				insFilter($id, 311, 3601);
			}
			if ($feature_id==6&&$value_id==577)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 311, 3298);
				//создаем новый фильтр в товаре
				insFilter($id, 311, 3298);
			}
			if ($feature_id==6&&$value_id==579)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 311, 3299);
				//создаем новый фильтр в товаре
				insFilter($id, 311, 3299);
			}
			if ($feature_id==6&&$value_id==581)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 311, 3302);
				//создаем новый фильтр в товаре
				insFilter($id, 311, 3302);
			}
			if ($feature_id==6&&$value_id==583)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 311, 3303);
				//создаем новый фильтр в товаре
				insFilter($id, 311, 3303);
			}
			if ($feature_id==6&&$value_id==573)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 311, 3306);
				//создаем новый фильтр в товаре
				insFilter($id, 311, 3306);
			}
			if ($feature_id==6&&$value_id==586)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 311, 3314);
				//создаем новый фильтр в товаре
				insFilter($id, 311, 3314);
			}
			if ($feature_id==6&&$value_id==587)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 311, 3315);
				//создаем новый фильтр в товаре
				insFilter($id, 311, 3315);
			}
			if ($feature_id==6&&$value_id==588)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 311, 3316);
				//создаем новый фильтр в товаре
				insFilter($id, 311, 3316);
			}
			if ($feature_id==6&&$value_id==571)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 311, 3318);
				//создаем новый фильтр в товаре
				insFilter($id, 311, 3318);
			}
			
			if ($feature_id==198&&$value_id==3029)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 312, 3586);
				//создаем новый фильтр в товаре
				insFilter($id, 312, 3586);
			}
			if ($feature_id==198&&$value_id==2991)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 312, 3587);
				//создаем новый фильтр в товаре
				insFilter($id, 312, 3587);
			}
			if ($feature_id==198&&$value_id==3025)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 312, 3588);
				//создаем новый фильтр в товаре
				insFilter($id, 312, 3588);
			}
			if ($feature_id==198&&$value_id==3026)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 312, 3589);
				//создаем новый фильтр в товаре
				insFilter($id, 312, 3589);
			}
			if ($feature_id==198&&$value_id==2918)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 312, 3590);
				//создаем новый фильтр в товаре
				insFilter($id, 312, 3590);
			}
			if ($feature_id==198&&$value_id==2986)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 312, 3591);
				//создаем новый фильтр в товаре
				insFilter($id, 312, 3591);
			}
			if ($feature_id==198&&$value_id==3028)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 312, 3593);
				//создаем новый фильтр в товаре
				insFilter($id, 312, 3593);
			}
			if ($feature_id==198&&$value_id==2995)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 312, 3594);
				//создаем новый фильтр в товаре
				insFilter($id, 312, 3594);
			}
			
			if ($feature_id==154&&$value_id==3135)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 314, 3595);
				//создаем новый фильтр в товаре
				insFilter($id, 314, 3595);
			}
			if ($feature_id==154&&$value_id==3137)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 314, 3596);
				//создаем новый фильтр в товаре
				insFilter($id, 314, 3596);
			}
			if ($feature_id==154&&$value_id==3136)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 314, 3597);
				//создаем новый фильтр в товаре
				insFilter($id, 314, 3597);
			}
			if ($feature_id==154&&$value_id==3149)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 314, 3599);
				//создаем новый фильтр в товаре
				insFilter($id, 314, 3599);
			}
			if ($feature_id==18&&$value_id==232)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 313, 3343);
				//создаем новый фильтр в товаре
				insFilter($id, 313, 3343);
			}
			if ($feature_id==18&&$value_id==227)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 313, 3344);
				//создаем новый фильтр в товаре
				insFilter($id, 313, 3344);
			}
			if ($feature_id==18&&$value_id==235)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 313, 3347);
				//создаем новый фильтр в товаре
				insFilter($id, 313, 3347);
			}
			if ($feature_id==18&&$value_id==233)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 313, 3348);
				//создаем новый фильтр в товаре
				insFilter($id, 313, 3348);
			}
			*/
						
			/*шкафы-купе 9*/
			/*
			if ($feature_id==221&&$value_id==3001)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3486);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3486);
			}
			if ($feature_id==221&&$value_id==3002)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3487);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3487);
			}
			if ($feature_id==221&&$value_id==3004)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3489);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3489);
			}
			if ($feature_id==221&&$value_id==3012)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3489);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3489);
			}
			if ($feature_id==221&&$value_id==3005)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3490);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3490);
			}
			if ($feature_id==221&&$value_id==3006)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3491);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3491);
			}
			
			if ($feature_id==222&&$value_id==3009)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 287, 3494);
				//создаем новый фильтр в товаре
				insFilter($id, 287, 3494);
			}
			if ($feature_id==222&&$value_id==3003)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 287, 3495);
				//создаем новый фильтр в товаре
				insFilter($id, 287, 3495);
			}
			if ($feature_id==222&&$value_id==3010)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 287, 3495);
				//создаем новый фильтр в товаре
				insFilter($id, 287, 3495);
			}
			if ($feature_id==222&&$value_id==3011)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 287, 3496);
				//создаем новый фильтр в товаре
				insFilter($id, 287, 3496);
			}
			
			if ($feature_id==223&&$value_id==3016)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 288, 3501);
				//создаем новый фильтр в товаре
				insFilter($id, 288, 3501);
			}
			if ($feature_id==223&&$value_id==3017)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 288, 3502);
				//создаем новый фильтр в товаре
				insFilter($id, 288, 3502);
			}
			if ($feature_id==223&&$value_id==3018)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 288, 3503);
				//создаем новый фильтр в товаре
				insFilter($id, 288, 3503);
			}
			
			if ($feature_id==16&&$value_id==697)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 289, 3504);
				//создаем новый фильтр в товаре
				insFilter($id, 289, 3504);
			}
			if ($feature_id==16&&$value_id==698)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 289, 3505);
				//создаем новый фильтр в товаре
				insFilter($id, 289, 3505);
			}
			
			if ($feature_id==15&&$value_id==675)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 290, 3507);
				//создаем новый фильтр в товаре
				insFilter($id, 290, 3507);
			}
			if ($feature_id==15&&$value_id==676)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 290, 3508);
				//создаем новый фильтр в товаре
				insFilter($id, 290, 3508);
			}
			
			if ($feature_id==32&&$value_id==339)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 291, 3513);
				//создаем новый фильтр в товаре
				insFilter($id, 291, 3513);
			}
			if ($feature_id==32&&$value_id==340)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 291, 3514);
				//создаем новый фильтр в товаре
				insFilter($id, 291, 3514);
			}
			if ($feature_id==32&&$value_id==343)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 291, 3515);
				//создаем новый фильтр в товаре
				insFilter($id, 291, 3515);
			}
			if ($feature_id==32&&$value_id==341)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 291, 3516);
				//создаем новый фильтр в товаре
				insFilter($id, 291, 3516);
			}
			//что за вопросы?
			if ($feature_id==6&&$value_id==577)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 315, 3298);
				//создаем новый фильтр в товаре
				insFilter($id, 315, 3298);
			}
			if ($feature_id==6&&$value_id==576)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 315, 3299);
				//создаем новый фильтр в товаре
				insFilter($id, 315, 3299);
			}
			if ($feature_id==6&&$value_id==580)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 315, 3300);
				//создаем новый фильтр в товаре
				insFilter($id, 315, 3300);
			}
			if ($feature_id==6&&$value_id==573)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 315, 3306);
				//создаем новый фильтр в товаре
				insFilter($id, 315, 3306);
			}
			if ($feature_id==6&&$value_id==585)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 315, 3308);
				//создаем новый фильтр в товаре
				insFilter($id, 315, 3308);
			}
			if ($feature_id==6&&$value_id==588)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 315, 3316);
				//создаем новый фильтр в товаре
				insFilter($id, 315, 3316);
			}
			if ($feature_id==6&&$value_id==588)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 315, 3316);
				//создаем новый фильтр в товаре
				insFilter($id, 315, 3316);
			}
			
			if ($feature_id==198&&$value_id==2920)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 293, 3522);
				//создаем новый фильтр в товаре
				insFilter($id, 293, 3522);
			}
			if ($feature_id==198&&$value_id==2921)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 293, 3523);
				//создаем новый фильтр в товаре
				insFilter($id, 293, 3523);
			}
			
			if ($feature_id==154&&$value_id==3137)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 294, 3533);
				//создаем новый фильтр в товаре
				insFilter($id, 294, 3533);
			}
			if ($feature_id==154&&$value_id==3138)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 294, 3534);
				//создаем новый фильтр в товаре
				insFilter($id, 294, 3534);
			}
			if ($feature_id==154&&$value_id==3136)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 294, 3535);
				//создаем новый фильтр в товаре
				insFilter($id, 294, 3535);
			}
			if ($feature_id==154&&$value_id==3142)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 294, 3536);
				//создаем новый фильтр в товаре
				insFilter($id, 294, 3536);
			}
			
			if ($feature_id==18&&$value_id==227)
			{
				//delFilter($id, $feature_id, $value_id);
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 295, 3344);
				//создаем новый фильтр в товаре
				insFilter($id, 295, 3344);
			}
			
			
			
			
			//break;
			
			
		}*/
		/*
		if ($len>0&&$len<1000)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3485);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3485);
			}
			if ($len>=1000&&$len<1500)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3486);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3486);
			}
			if ($len>=1500&&$len<2000)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3487);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3487);
			}
			if ($len>=2000&&$len<2500)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3488);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3488);
			}
			if ($len>=2500&&$len<3000)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3489);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3489);
			}
			if ($len>=3000&&$len<3500)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3490);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3490);
			}
			if ($len>=3500&&$len<4000)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3055);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3055);
			}
			if ($len>=4000&&$len<4500)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3491);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3491);
			}
			if ($len>=4500)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 286, 3492);
				//создаем новый фильтр в товаре
				insFilter($id, 286, 3492);
			}
			
			if ($height>0&&$height<2000)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 287, 3493);
				//создаем новый фильтр в товаре
				insFilter($id, 287, 3493);
			}
			if ($height>=2000&&$height<2400)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 287, 3494);
				//создаем новый фильтр в товаре
				insFilter($id, 287, 3494);
			}
			if ($height>=2400&&$height<2500)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 287, 3495);
				//создаем новый фильтр в товаре
				insFilter($id, 287, 3495);
			}
			if ($height>=2500&&$height<2600)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 287, 3496);
				//создаем новый фильтр в товаре
				insFilter($id, 287, 3496);
			}
			if ($height>=2600&&$height<2700)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 287, 3497);
				//создаем новый фильтр в товаре
				insFilter($id, 287, 3497);
			}
			if ($height>=2700)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 287, 3498);
				//создаем новый фильтр в товаре
				insFilter($id, 287, 3498);
			}
			
			
			if ($width>0&&$width<430)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 288, 3499);
				//создаем новый фильтр в товаре
				insFilter($id, 288, 3499);
			}
			if ($width>=430&&$width<450)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 288, 3500);
				//создаем новый фильтр в товаре
				insFilter($id, 288, 3500);
			}
			if ($width>=450&&$width<580)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 288, 3501);
				//создаем новый фильтр в товаре
				insFilter($id, 288, 3501);
			}
			if ($width>=580&&$width<600)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 288, 3502);
				//создаем новый фильтр в товаре
				insFilter($id, 288, 3502);
			}
			if ($width>600)
			{
				//на всякий случай удаляем новый фильтр чтоб не было дублей
				delFilter($id, 288, 3503);
				//создаем новый фильтр в товаре
				insFilter($id, 288, 3503);
			}
		*/
		/*
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
}*/
