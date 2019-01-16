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

class addComponents
{
	private function getGoodsByCatAndFactory($cat_id, $f_id)
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
		if (is_array ($goods_all))
		{
			//var_dump($goods_all);
			foreach ($goods_all as $good)
			{
				$id=$good['goods_id'];
				$features=$this->getFeatures($id);
				if (is_array($features))
				{
					foreach ($features as $feature)
					{
						$feature_id=$feature['feature_id'];
						$val_id=$feature['goodshasfeature_valueid'];
						if ($feature_id==232&&$val_id==$f_id)
						{
							$goods_by_factoty[]=$id;
							break;
						}
					}
				}
				
				//break;
			}
		}
		else
		{
			echo "no goods by category<br>";
		}
		
		mysqli_close($db_connect);
		if (is_array($goods_by_factoty))
		{
			return $goods_by_factoty;
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
	
	private function getGoodsName ($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goodshaslang_name from goodshaslang WHERE goods_id=$id AND lang_id=1";
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
			return $goods[0]['goodshaslang_name'];
		}
		else
		{
			return null;
		}
	}
	
	private function insComponent ($comp_id,$good_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="INSERT INTO component (goods_id, component_child) VALUES ($good_id,$comp_id)";
		echo "$query<br><br>";
		//mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
	
	private function isPart($good_id,$comp_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select component_id from component WHERE goods_id=$good_id AND component_child=$comp_id";
		$goods=null;
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
		if (is_null($goods))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	private function getArticle1CName ($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_article_1c from goods WHERE goods_id=$id";
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
			return substr($goods[0]['goods_article_1c'],13);
		}
		else
		{
			return null;
		}
	}
	
	public function test ()
	{
		//$t=$this->getArticle1CName(32109);
		//var_dump ($t);
		$goods_comp=$this->getGoodsByCatAndFactory(148,86);
		foreach ($goods_comp as $good)
		{
			$id=$good;
			$text=$this->getArticle1CName($id);
			//var_dump($text);
			//echo "$id= $text<br>";
		}
		echo "<br><br>";
		$goods=$this->getGoodsByCatAndFactory(57,86);
		if (is_array ($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good;
				$name=$this->getGoodsName($id);
				echo "<b>$name</b><br>";
				if (stripos($name,"Модест")!=false)
				{
					echo "$id=$name<br>";
					foreach ($goods_comp as $good_comp)
					{
						$comp_id=$good_comp;
						$text=$this->getArticle1CName($comp_id);
						if (stripos(" ".$text,"Модерн")!=false)
						{
							echo "$comp_id= $text<br>";
							if ($this->isPart($id,$comp_id))
							{
								echo "$comp_id уже есть частью $id<br>";		
							}
							else
							{
								$this->insComponent($comp_id,$id);
							}
						}
					}
				}
				if (stripos($name,"Гламур")!=false)
				{
					echo "$id=$name<br>";
					foreach ($goods_comp as $good_comp)
					{
						$comp_id=$good_comp;
						$text=$this->getArticle1CName($comp_id);
						if (stripos(" ".$text,"Гламур")!=false)
						{
							echo "$comp_id= $text<br>";
							if ($this->isPart($id,$comp_id))
							{
								echo "$comp_id уже есть частью $id<br>";		
							}
							else
							{
								$this->insComponent($comp_id,$id);
							}
						}
					}
				}
				if (stripos($name,"Контур")!=false)
				{
					echo "$id=$name<br>";
					foreach ($goods_comp as $good_comp)
					{
						$comp_id=$good_comp;
						$text=$this->getArticle1CName($comp_id);
						if (stripos(" ".$text,"Контур")!=false)
						{
							echo "$comp_id= $text<br>";
							if ($this->isPart($id,$comp_id))
							{
								echo "$comp_id уже есть частью $id<br>";		
							}
							else
							{
								$this->insComponent($comp_id,$id);
							}
						}
					}
				}
				if (stripos($name,"Квадрис")!=false)
				{
					echo "$id=$name<br>";
					foreach ($goods_comp as $good_comp)
					{
						$comp_id=$good_comp;
						$text=$this->getArticle1CName($comp_id);
						if (stripos(" ".$text,"Квадрис")!=false)
						{
							echo "$comp_id= $text<br>";
							if ($this->isPart($id,$comp_id))
							{
								echo "$comp_id уже есть частью $id<br>";		
							}
							else
							{
								$this->insComponent($comp_id,$id);
							}
						}
					}
				}
				if (stripos($name,"Горизонт")!=false)
				{
					echo "$id=$name<br>";
					foreach ($goods_comp as $good_comp)
					{
						$comp_id=$good_comp;
						$text=$this->getArticle1CName($comp_id);
						if (stripos(" ".$text,"Горизонт")!=false)
						{
							echo "$comp_id= $text<br>";
							if ($this->isPart($id,$comp_id))
							{
								echo "$comp_id уже есть частью $id<br>";		
							}
							else
							{
								$this->insComponent($comp_id,$id);
							}
						}
					}
				}
				if (stripos($name,"Платинум")!=false)
				{
					echo "$id=$name<br>";
					foreach ($goods_comp as $good_comp)
					{
						$comp_id=$good_comp;
						$text=$this->getArticle1CName($comp_id);
						if (stripos(" ".$text,"Платинум")!=false)
						{
							echo "$comp_id= $text<br>";
							if ($this->isPart($id,$comp_id))
							{
								echo "$comp_id уже есть частью $id<br>";		
							}
							else
							{
								$this->insComponent($comp_id,$id);
							}
						}
					}
				}
				if (stripos($name,"Санрайз")!=false)
				{
					echo "$id=$name<br>";
					foreach ($goods_comp as $good_comp)
					{
						$comp_id=$good_comp;
						$text=$this->getArticle1CName($comp_id);
						if (stripos(" ".$text,"Санрайз")!=false)
						{
							echo "$comp_id= $text<br>";
							if ($this->isPart($id,$comp_id))
							{
								echo "$comp_id уже есть частью $id<br>";		
							}
							else
							{
								$this->insComponent($comp_id,$id);
							}
						}
					}
				}
				if (stripos($name,"Фрейм")!=false)
				{
					echo "$id=$name<br>";
					foreach ($goods_comp as $good_comp)
					{
						$comp_id=$good_comp;
						$text=$this->getArticle1CName($comp_id);
						if (stripos(" ".$text,"Фрейм")!=false)
						{
							echo "$comp_id= $text<br>";
							if ($this->isPart($id,$comp_id))
							{
								echo "$comp_id уже есть частью $id<br>";		
							}
							else
							{
								$this->insComponent($comp_id,$id);
							}
						}
					}
				}
				if (stripos($name,"Элит")!=false)
				{
					echo "$id=$name<br>";
					foreach ($goods_comp as $good_comp)
					{
						$comp_id=$good_comp;
						$text=$this->getArticle1CName($comp_id);
						if (stripos(" ".$text,"Элит")!=false)
						{
							echo "$comp_id= $text<br>";
							if ($this->isPart($id,$comp_id))
							{
								echo "$comp_id уже есть частью $id<br>";		
							}
							else
							{
								$this->insComponent($comp_id,$id);
							}
						}
					}
				}

				//break;
			}
		}
		else
		{
			echo "No goods<br>";
		}
	}

	private function countElem($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select component_id from component WHERE goods_id=$id";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$elements[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
		}
		if (is_array($elements))
		{
			return count($elements);
		}
	}

	public function testCount()
	{
		$goods=$this->getGoodsByCatAndFactory(57,86);
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good;
				$count_elem=$this->countElem($id);
				if (is_null($count_elem))
				{
					$count_elem=0;
				}
				echo "$id  имеет $count_elem составных<br>";
			}
		}
	}
}

$test=new addComponents();
//$test->test();
$test->testCount();