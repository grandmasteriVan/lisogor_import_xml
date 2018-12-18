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
	
	private function delFilter($goods_id, $feature_id, $value_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id AND goodshasfeature_valueid=$value_id";
		echo "$query<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
	
	private function delAllFilters($goods_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id";
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
	
	private function setHeight($goods_id,$height)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goods SET goods_height=$height where goods_id=$goods_id";
		echo "$query<br><br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
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
	
	private function getHeight($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_height from goods WHERE goods_id=$id";
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
			return $goods[0]['goods_height'];
		}
		else
		{
			return null;
		}
	}
	
	private function getSizes($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_length, goods_width from goods WHERE goods_id=$id";
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
	
	public function copyFiltersMatr($cat_id)
	{
		//var_dump($cat_id);
		$goods_all=$this->getGoodsByCategory($cat_id);
		if (is_array($goods_all))
		{
			$parrents=$this->getParrentGoods($goods_all);
			if (is_array($parrents))
			{
				foreach ($parrents as $parrent)
				{
					var_dump($parrent);
					$parent_id=$parrent;
					$parrent_features=$this->getFeatures($parent_id);
					$parrent_height=$this->getHeight($parent_id);
					$mods=$this->getModGoods($parent_id);
					var_dump ($mods);
					if (is_array($mods))
					{
						foreach ($mods as $mod)
						{
							$mod_id=$mod['goods_id'];
							$this->delAllFilters($mod_id);
							$this->setHeight($mod_id,$parrent_height);
							$sizes=$this->getSizes($mod_id);
							foreach ($parrent_features as $parrent_feature)
							{
								if ($parrent_feature['feature_id']!=276)
								{
									$this->insFilter($mod_id,$parrent_feature['feature_id'],$parrent_feature['goodshasfeature_valueid']);
								}
								else
								{
									$nostand=true;
									if ($sizes[0]['goods_width']==600&&$sizes[0]['goods_length']==1200)
									{
										$this->insFilter($mod_id,276,3405);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==700&&$sizes[0]['goods_length']==1400)
									{
										$this->insFilter($mod_id,276,3406);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==700&&$sizes[0]['goods_length']==1900)
									{
										$this->insFilter($mod_id,276,3407);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==700&&$sizes[0]['goods_length']==2000)
									{
										$this->insFilter($mod_id,276,3408);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==800&&$sizes[0]['goods_length']==1600)
									{
										$this->insFilter($mod_id,276,3409);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==800&&$sizes[0]['goods_length']==1900)
									{
										$this->insFilter($mod_id,276,3410);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==800&&$sizes[0]['goods_length']==2000)
									{
										$this->insFilter($mod_id,276,3411);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==900&&$sizes[0]['goods_length']==1900)
									{
										$this->insFilter($mod_id,276,3412);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==900&&$sizes[0]['goods_length']==2000)
									{
										$this->insFilter($mod_id,276,3413);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1000&&$sizes[0]['goods_length']==1900)
									{
										$this->insFilter($mod_id,276,3414);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1000&&$sizes[0]['goods_length']==2000)
									{
										$this->insFilter($mod_id,276,3415);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1200&&$sizes[0]['goods_length']==1900)
									{
										$this->insFilter($mod_id,276,3416);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1200&&$sizes[0]['goods_length']==2000)
									{
										$this->insFilter($mod_id,276,3417);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1400&&$sizes[0]['goods_length']==1900)
									{
										$this->insFilter($mod_id,276,3418);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1400&&$sizes[0]['goods_length']==2000)
									{
										$this->insFilter($mod_id,276,3419);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1500&&$sizes[0]['goods_length']==1900)
									{
										$this->insFilter($mod_id,276,3420);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1500&&$sizes[0]['goods_length']==2000)
									{
										$this->insFilter($mod_id,276,3421);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1600&&$sizes[0]['goods_length']==1900)
									{
										$this->insFilter($mod_id,276,3422);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1600&&$sizes[0]['goods_length']==2000)
									{
										$this->insFilter($mod_id,276,3423);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1700&&$sizes[0]['goods_length']==1900)
									{
										$this->insFilter($mod_id,276,3424);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1700&&$sizes[0]['goods_length']==2000)
									{
										$this->insFilter($mod_id,276,3425);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1800&&$sizes[0]['goods_length']==1900)
									{
										$this->insFilter($mod_id,276,3426);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1800&&$sizes[0]['goods_length']==2000)
									{
										$this->insFilter($mod_id,276,3427);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1900&&$sizes[0]['goods_length']==1900)
									{
										$this->insFilter($mod_id,276,3428);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==1900&&$sizes[0]['goods_length']==2000)
									{
										$this->insFilter($mod_id,276,3429);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==2000&&$sizes[0]['goods_length']==2000)
									{
										$this->insFilter($mod_id,276,3430);
										$nostand=false;
									}
									if ($sizes[0]['goods_width']==2000&&$sizes[0]['goods_length']==2200)
									{
										$this->insFilter($mod_id,276,3431);
										$nostand=false;
									}
									if ($nostand)
									{
										$this->insFilter($mod_id,276,3432);
									}
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
		$goods=$this->getGoodsByCategory(14);
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
			if (!in_array(276,$f_id))
			{
				echo "В товаре с ид=$id не проставлен размер!<br>";
			}
			if (!in_array(277,$f_id))
			{
				echo "В товаре с ид=$id не проставлена высота!<br>";
			}
			if (!in_array(278,$f_id))
			{
				echo "В товаре с ид=$id не проставлена нагрузка на место!<br>";
			}
			if (!in_array(379,$f_id))
			{
				echo "В товаре с ид=$id не проставлено количество мест!<br>";
			}
			if (!in_array(280,$f_id))
			{
				echo "В товаре с ид=$id не фильтр тип матраса!<br>";
			}
			if (!in_array(281,$f_id))
			{
				echo "В товаре с ид=$id не фильтр тип пружины!<br>";
			}
			if (!in_array(282,$f_id))
			{
				echo "В товаре с ид=$id не фильтр жесткость!<br>";
			}
			if (!in_array(283,$f_id))
			{
				echo "В товаре с ид=$id не фильтр наполнение!<br>";
			}
			if (!in_array(284,$f_id))
			{
				echo "В товаре с ид=$id не фильтр особенности!<br>";
			}
			if (!in_array(285,$f_id))
			{
				echo "В товаре с ид=$id не фильтр По назначению!<br>";
			}
			echo "<br><br>";
			//break;
			
		}
	}
	
	
}
$test=new CopyFilters();
//$test->copyFiltersMatr(14);
$test->test();