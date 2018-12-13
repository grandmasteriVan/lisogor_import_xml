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


class TestFeatures
{
	
	private function delFilter($goods_id, $feature_id, $value_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id AND goodshasfeature_valueid=$value_id";
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
	
	private function getFeaturesByCategory ($cat_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select feature_id from categoryhasfeature where category_id=$cat_id";
		if ($res=mysqli_query($db_connect,$query))
		{
			while ($row = mysqli_fetch_assoc($res))
			{
				$features[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";
		}
		if (is_array($features))
		{
			return $features;
		}
		else
		{
			return null;
		}
	}
	
	private function getSizes($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_width, goods_height, goods_depth  from goods where goods_id=$id";
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
		return $sizes;
	}
	
	private function checkFeatureLang($f_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select featurehaslang_id from featurehaslang where feature_id=$f_id and lang_id=2";
		if ($res=mysqli_query($db_connect,$query))
		{
			while ($row = mysqli_fetch_assoc($res))
			{
				$features[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";
		}
		if (is_array($features))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	private function checkValueLang($val_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select fvaluehaslang_id from fvaluehaslang where fvalue_id=$val_id and lang_id=2";
		if ($res=mysqli_query($db_connect,$query))
		{
			while ($row = mysqli_fetch_assoc($res))
			{
				$features[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";
		}
		if (is_array($features))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	private function getValForFeature($f_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select fkind_id from feature where feature_id=$f_id";
		if ($res=mysqli_query($db_connect,$query))
		{
			while ($row = mysqli_fetch_assoc($res))
			{
				$fkind[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";
		}
		if (is_array($fkind))
		{
			$fkind=$fkind[0]['fkind_id'];
			$query="select fvalue_id from fvalue where fkind_id=$fkind";
			if ($res=mysqli_query($db_connect,$query))
			{
				while ($row = mysqli_fetch_assoc($res))
				{
					$fvalue[] = $row;
				}
				//var_dump($fvalue);
				return $fvalue;
			}
			else
			{
				echo "Error in SQL: $query<br>";
			}
		}
	}
	
	private function getGoodsByCat($cat_id)
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
	
	private function getComponents ($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select component_child from component WHERE goods_id=$id";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$components[] = $row['component_child'];
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
		}
		return $components;
	}
	
	public function testSizes($cat_id)
	{
		$goods=$this->getGoodsByCat($cat_id);
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$sizes=$this->getSizes($id);
				if ($sizes[0]['goods_width']==0)
				{
					echo "У шкафа с id=$id не проставленв ширина<br>";
				}
				if ($sizes[0]['goods_height']==0)
				{
					echo "У шкафа с id=$id не проставленв высота<br>";
				}
				if ($sizes[0]['goods_depth']==0)
				{
					echo "У шкафа с id=$id не проставленв глубина<br>";
				}
			}
		}
	}
	
	public function setDSPtoSHK($cat_id)
	{
		$goods=$this->getGoodsByCat($cat_id);
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$this->delFilter($id,289,3504);
				$this->insFilter($id,289,3504);
				//break;
			}
			
		}
	
	}
	
	public function setFormtoSHK($cat_id)
	{
		$goods=$this->getGoodsByCat($cat_id);
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$this->delFilter($id,292,3518);
				$this->insFilter($id,292,3518);
				//break;
			}
			
		}
	
	}
	
	public function setPlacetoSHK($cat_id)
	{
		$goods=$this->getGoodsByCat($cat_id);
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$this->delFilter($id,294,3533);
				$this->insFilter($id,294,3533);
				
				$this->delFilter($id,294,3534);
				$this->insFilter($id,294,3534);
				
				$this->delFilter($id,294,3535);
				$this->insFilter($id,294,3535);
				
				$this->delFilter($id,294,3536);
				$this->insFilter($id,294,3536);
				//break;
			}
			
		}
	
	}
	
	public function setFacadetoSHK($cat_id)
	{
		$goods=$this->getGoodsByCat($cat_id);
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$this->delFilter($id,290,3507);
				$this->insFilter($id,290,3507);
				
				$this->delFilter($id,290,3509);
				$this->insFilter($id,290,3509);
				
				$this->delFilter($id,290,3512);
				$this->insFilter($id,290,3512);
				//break;
			}
			
		}
	
	}
	
	public function setFeaturestoSHK($cat_id)
	{
		$goods=$this->getGoodsByCat($cat_id);
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$sizes=$this->getSizes($id);
				$components=$this->getComponents($id);
				
				$this->delFilter($id,293,3522);
				$this->insFilter($id,293,3522);
				
				$this->delFilter($id,293,3523);
				$this->insFilter($id,293,3523);
				
				$this->delFilter($id,293,3524);
				$this->insFilter($id,293,3524);
				
				if ($sizes[0]['goods_depth']<=450)
				{
					echo "Узкий<br>";
					$this->delFilter($id,293,3529);
					$this->insFilter($id,293,3529);
				}
				
				if ($sizes[0]['goods_width']<=1100&&$sizes[0]['goods_height']<=2200)
				{
					echo "Маленький<br>";
					$this->delFilter($id,293,3530);
					$this->insFilter($id,293,3530);
				}
				
				if (is_array($components))
				{
					//var_dump ($components);
					echo "<br>";
					if (in_array("38240",$components))
					{
						echo "С полками<br>";
						$this->delFilter($id,293,3531);
						$this->insFilter($id,293,3531);
					}
					
					if (in_array("38219",$components)||in_array("38222",$components)||in_array("38220",$components)||in_array("38223",$components)||in_array("38215",$components)||in_array("38229",$components)||in_array("38231",$components))
					{
						echo "С угловыми элементами<br>";
						$this->delFilter($id,293,3532);
						$this->delFilter($id,293,3533);
						$this->insFilter($id,293,3532);
					}
				}
				//break;
			}
			
		}
	
	}
	
	public function setStyletoSHK($cat_id)
	{
		$goods=$this->getGoodsByCat($cat_id);
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$this->delFilter($id,295,3343);
				$this->insFilter($id,295,3343);
				
				$this->delFilter($id,295,3344);
				$this->insFilter($id,295,3344);
				
				$this->delFilter($id,295,3345);
				$this->insFilter($id,295,3345);
				
				$this->delFilter($id,295,3346);
				$this->insFilter($id,295,3346);
				
				$this->delFilter($id,295,3347);
				$this->insFilter($id,295,3347);
				
				$this->delFilter($id,295,3348);
				$this->insFilter($id,295,3348);
				
				$this->delFilter($id,295,3349);
				$this->insFilter($id,295,3349);
				//break;
			}
			
		}
	
	}
	
	public function test($cat_id)
	{
		echo "Тест для категории $cat_id<br>";
		$features=$this->getFeaturesByCategory($cat_id);
		if (is_array($features))
		{
			foreach ($features as $feature)
			{
				$f_id=$feature['feature_id'];
				if ($this->checkFeatureLang($f_id))
				{
					echo "у фичи $f_id есть укр язык<br>";
				}
				else
				{
					echo "у фичи $f_id <b>нет</b> укр языка <br>";
				}
				$vals=$this->getValForFeature($f_id);
				if (is_array($vals))
				{
					foreach ($vals as $val)
					{
						//var_dump($val);
						$val_id=$val['fvalue_id'];
						if ($this->checkValueLang($val_id))
						{
							echo "у значения $val_id есть укр язык<br>";
						}
						else
						{
							echo "у значения $val_id <b>нет</b> укр языка <br>";
						}
					}
				}
				else
				{
					//echo "No arr!<br>";
				}
				echo "<br><br>";
				//break;
			}
		}
	}
	
}

$test=new TestFeatures();
//$test->test(9);
//$test->testSizes(9);
//$test->setDSPtoSHK(9);
//$test->setFacadetoSHK(9);
//$test->setFormtoSHK(9);
//$test->setPlacetoSHK(9);
//$test->setStyletoSHK(9);
//$test->setFeaturestoSHK(9);