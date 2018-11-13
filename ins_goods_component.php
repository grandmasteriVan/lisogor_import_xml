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

class insGoodsComponent
{
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
	
	private function getGoods($cat_id, $f_id)
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
			}
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
	
	private function getSize($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_width, goods_height, goods_depth from goods WHERE goods_id=$id";
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
		if (is_array($sizes))
		{
			return $sizes;
		}
		else
		{
			return null;
		}
	}
	
	private function getName($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goodshaslang_name FROM goodshaslang WHERE goods_id=$id AND lang_id=1";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$name[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
		}
		if (is_array($sizes))
		{
			return $name[0]['goodshaslang_name'];
		}
		else
		{
			return null;
		}
	}
	
	private function insComponent ($comp_id,$good_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="INSERT INTO component (goods_id, component_child) VALUES ($comp_id,$good_id)";
		echo "$query<br><br>";
		//mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
	
	public function insGoodComp($cat_id, $f_id)
	{
		$goods=$this->getGoods($cat_id, $f_id);
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['good_id'];
				$sizes=$this->getSize($id);
				$depth=$sizes[0]['goods_depth'];
				$width=$sizes[0]['goods_width'];
				$length=$sizes[0]['goods_length'];
				$name=$this->getName($id);
				$name=" ".$name;
				if (mb_strpos($name, "Угловой"))
				{
					//Комплект ящиков 430х450
					$this->insComponent(38429,$id);
					//Карниз на консоль
					$this->insComponent(38436,$id);
					//Ножка Н60 D60 (алюминий)
					$this->insComponent(38437,$id);
					//Ножка регулируемая (пластик)
					$this->insComponent(38438,$id);
					//Полка в пенал
					$this->insComponent(38439,$id);
					//Полка в платяное отделение
					$this->insComponent(38440,$id);
					//Скалка + скалкодержатель
					$this->insComponent(38441,$id);
					//Стойка
					$this->insComponent(38442,$id);
					//Микролифт
					$this->insComponent(38443,$id);
					if ($depth==450&&$length==2200)
					{
						//Консоль радиусная 2200х450
						$this->insComponent(38425,$id);
						//Консоль прямая 2200х450
						$this->insComponent(38427,$id);
					}
					if ($depth==450&&$length==2400)
					{
						//Консоль прямая 2400х450
						$this->insComponent(38449,$id);
						//Консоль радиусная 2400х450
						$this->insComponent(38452,$id);
					}
				}
				else
				{
					//Карниз на консоль
					$this->insComponent(38436,$id);
					//Ножка Н60 D60 (алюминий)
					$this->insComponent(38437,$id);
					//Ножка регулируемая (пластик)
					$this->insComponent(38438,$id);
					if ($depth==450)
					{
						
					}
				}
				
			}
		}
		else
		{
			echo "No goods<br>";
		}
	}
	
}