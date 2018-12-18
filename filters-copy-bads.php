<?php
header('Content-Type: text/html; charset=utf-8');
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

class CopyFilters
{
	private function getGoodsByCategory($cat_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id from goodshascategory WHERE category_id=$cat_id";
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
		return $goods_all;
	}
	
	private function getParrentGoods($goods)
	{
		if (is_array($goods))
		{
			$db_connect=mysqli_connect(host,user,pass,db);
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				//var_dump($id);
				$query="select goods_id from goods WHERE goods_parent=$id AND goods_id=$id";
				if ($res=mysqli_query($db_connect,$query))
				{
					unset ($tmp);
					while ($row = mysqli_fetch_assoc($res))
					{
						$tmp[] = $row;
					}
					if (is_array($tmp))
					{
						$parrents[]=$tmp[0]['goods_id'];
					}
				}
				else
				{
					 echo "Error in SQL: $query<br>";		
				}
				
				
			}
			mysqli_close($db_connect);
			return $parrents;
			
		}
	}
	
	function getModGoods($parrent_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id from goods WHERE goods_parent=$parrent_id";
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
	
	private function getFeatures($good_id)
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
	
	private function delFilter($goods_id, $feature_id, $value_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id AND goodshasfeature_valueid=$value_id";
		echo "$query<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
	
	private function delFilters($goods_id, $feature_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id";
		echo "$query<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
	
	private function insFilter($goods_id, $feature_id, $value_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="INSERT INTO goodshasfeature (goods_id, feature_id, goodshasfeature_valueid) VALUES ($goods_id, $feature_id, $value_id)";
		echo "$query<br><br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
	
	public function copyFiltersBeds($cat_id)
	{
		//var_dump($cat_id);
		$goods_all=$this->getGoodsByCategory($cat_id);
		//var_dump($goods_all);
		if (is_array($goods_all))
		{
			$parrents=$this->getParrentGoods($goods_all);
			//var_dump($parrents);
			if (is_array($parrents))
			{
				foreach ($parrents as $parrent)
				{
					//var_dump($parrent);
					$parent_id=$parrent;
					$parrent_features=$this->getFeatures($parent_id);
					$mods=$this->getModGoods($parent_id);
					//var_dump ($mods);
					if (is_array($mods))
					{
						foreach ($mods as $mod)
						{
							$mod_id=$mod['goods_id'];
							//$this->delAllFilters($mod_id);
							
							//$sizes=$this->getSizes($mod_id);
							foreach ($parrent_features as $parrent_feature)
							{
								//удаляем старіе фильтрі
								
								if ($parrent_feature['feature_id']==318||$parrent_feature['feature_id']==319||$parrent_feature['feature_id']==320||$parrent_feature['feature_id']==321||$parrent_feature['feature_id']==323||$parrent_feature['feature_id']==324||$parrent_feature['feature_id']==322)
								{
									$this->delFilters($mod_id,$parrent_feature['feature_id']);
									$this->insFilter($mod_id,$parrent_feature['feature_id'],$parrent_feature['goodshasfeature_valueid']);
								}
								
								
							}
						}
					}
					else
					{
						echo "No mods<br>";
					}
					//break;
					
				}
			}
			else
			{
				echo "No parrents<br>";
			}
		}
		else
		{
			echo "No goods<br>";
		}
	}
	
	public function test()
	{
		$goods=$this->getGoodsByCategory(13);
		foreach ($goods as $good)
		{
			$id=$good['goods_id'];
			$filters=$this->getFeatures($id);
			//var_dump($id);
			$f_id=null;
			foreach ($features as $feature)
			{
				$f_id[]=$feature['feature_id'];
			}
			if (!in_array(316,$f_id))
			{
				echo "В товаре с ид=$id не проставлен размер спального места!<br>";
			}
			if (!in_array(317,$f_id))
			{
				echo "В товаре с ид=$id не проставлен фильтр по типу!<br>";
			}
			if (!in_array(318,$f_id))
			{
				echo "В товаре с ид=$id не проставлен материал!<br>";
			}
			if (!in_array(319,$f_id))
			{
				echo "В товаре с ид=$id не проставлен цвет!<br>";
			}
			if (!in_array(320,$f_id))
			{
				echo "В товаре с ид=$id не фильтр бельевая ниша!<br>";
			}
			if (!in_array(321,$f_id))
			{
				echo "В товаре с ид=$id не фильтр основание для матраса!<br>";
			}
			if (!in_array(321,$f_id))
			{
				echo "В товаре с ид=$id не фильтр особенности!<br>";
			}
			if (!in_array(321,$f_id))
			{
				echo "В товаре с ид=$id не фильтр материал оббивки!<br>";
			}
			if (!in_array(321,$f_id))
			{
				echo "В товаре с ид=$id не фильтр стиль!<br>";
			}
			echo "<br><br>";
			//break;
			
		}
	}
	
}

$test=new CopyFilters();
//$test->copyFiltersBeds(13);
$test->test();