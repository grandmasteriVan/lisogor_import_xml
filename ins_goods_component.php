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
					
					if ($depth==600&&$length==2200)
					{
						//Консоль радиусная 2200х600
						$this->insComponent(38426,$id);
						//Консоль прямая 2200х600
						$this->insComponent(38447,$id);
					}
					if ($depth==600&&$length==2400)
					{
						//Консоль прямая 2400х600
						$this->insComponent(38428,$id);
						//Консоль радиусная 2400х600
						$this->insComponent(38453,$id);
					}
					
					if ($length>=1000&&$length<=1800)
					{
						//Карниз 1000-1800
						$this->insComponent(38433,$id);
					}
					if ($length>=1900&&$length<=2700)
					{
						//Карниз 1810-2700
						$this->insComponent(38434,$id);
					}
					if ($length>=2800&&$length<=3600)
					{
						//Карниз 2710-3600
						$this->insComponent(38435,$id);
					}
					
					//Полка в пенал
					$this->insComponent(38439,$id);
					//Полка в платяное отделение
					$this->insComponent(38440,$id);
					//Стойка
					$this->insComponent(38442,$id);
					
					if ($depth==450)
					{
						//Микролифт
						$this->insComponent(38443,$id);
					}
					if ($depth==600)
					{
						//Скалка + скалкодержатель
						$this->insComponent(38441,$id);
					}
					
					if (($length==1000&&$width==600)||($length==1100&&$width==600)||($length==1200&&$width==600)||($length==1300&&$width==600)||($length==1400&&$width==600)||($length==1500&&$width==600)||($length==1900&&$width==600)||($length==2000&&$width==600)||($length==2800&&$width==600)||($length==2900&&$width==600)||($length==3000&&$width==600)||($length==3100&&$width==600)||($length==3200&&$width==600)||($length==3300&&$width==600))
					{
						//Комплект ящиков 430х600
						$this->insComponent(38430,$id);
					}
					if (($length==1000&&$width==450)||($length==1100&&$width==450)||($length==1200&&$width==450)||($length==1300&&$width==450)||($length==1400&&$width==450)||($length==1500&&$width==450)||($length==1900&&$width==450)||($length==2000&&$width==450)||($length==2800&&$width==450)||($length==2900&&$width==450)||($length==3000&&$width==450)||($length==3100&&$width==450)||($length==3200&&$width==450)||($length==3300&&$width==450))
					{
						//Комплект ящиков 430х450
						$this->insComponent(38429,$id);
					}
					if (($length==1700&&$width==600)||($length==1800&&$width==600)||($length==2100&&$width==600)||($length==2200&&$width==600)||($length==2300&&$width==600)||($length==2400&&$width==600)||($length==2500&&$width==600)||($length==2600&&$width==600)||($length==2700&&$width==600)||($length==3400&&$width==600)||($length==3500&&$width==600)||($length==3600&&$width==600))
					{
						//Комплект ящиков 600х600
						$this->insComponent(38432,$id);
					}
					if (($length==1700&&$width==450)||($length==1800&&$width==450)||($length==2100&&$width==450)||($length==2200&&$width==450)||($length==2300&&$width==450)||($length==2400&&$width==450)||($length==2500&&$width==450)||($length==2600&&$width==450)||($length==2700&&$width==450)||($length==3400&&$width==450)||($length==3500&&$width==450)||($length==3600&&$width==450))
					{
						//Комплект ящиков 600х450
						$this->insComponent(38431,$id);
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