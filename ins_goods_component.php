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
//define ("user", "newfm");
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
/**
 * Class insGoodsComponent
 */
class insGoodsComponent
{
    /**
     * получаем массив со всеми фильтрами товара
     * @param $good_id int айди товара
     * @return array|null массив со всеми фильтрами и их значениями заданного товара
     */
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
    /**
     * удаляем все составные для определенного товара
     * @param $id int айди товара? для которого надо удалить все составные
     */
    private function delComponents ($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="DELETE FROM component WHERE goods_id=$id";
		echo "$query<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
    /**
     * Получаем все товараы определенной фабрики которые находятся в поределенном раздле
     * @param $cat_id int айди категории
     * @param $f_id int айди фабрики
     * @return array|null массив с ид товаров которые находятся в определенной категории и принадлежжат определенной фабрике
     */
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
    /**
     * получаем размеры товаров
     * @param $id int ид товара
     * @return array|null массив с размерами товара
     */
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
    /**
     * получаем имя njdfhf
     * @param $id int ид товара
     * @return null|string имя товара
     */
    private function getName($id, $lang=1)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goodshaslang_name FROM goodshaslang WHERE goods_id=$id AND lang_id=$lang";
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
		/*echo "<pre>";
		print_r($name);
		echo "</pre>";*/
		if (is_array($name))
		{
			return $name[0]['goodshaslang_name'];
			
		}
		else
		{
			return null;
		}
	}
    /**
     * вставляем составную часть (компонент) в товар
     * @param $comp_id int ид компонента, который надо вставить в товар
     * @param $good_id int товар, в который вставляем компонент
     */
    private function insComponent ($comp_id, $good_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="INSERT INTO component (goods_id, component_child) VALUES ($good_id,$comp_id)";
		echo "$query<br><br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
    /**
     * вставляем составные части в шкафы купе
     * @param $cat_id int ид категории
     * @param $f_id int ид фабрики
     */
    public function insGoodComp($cat_id, $f_id)
	{
		$goods=$this->getGoods($cat_id, $f_id);
		if (is_array($goods))
		{
			var_dump($goods);
			foreach ($goods as $good)
			{
				$id=$good;
				$sizes=$this->getSize($id);
				$depth=$sizes[0]['goods_depth'];
				$width=$sizes[0]['goods_width'];
				$length=$sizes[0]['goods_height'];
				$height=$sizes[0]['goods_height'];
				$name=$this->getName($id);
				var_dump ($name);
				$name=" ".$name;
				//var_dump($name);
				$this->delComponents ($id);
				if ($id==28318)
				{
					echo "<br>$name id=$id depth=$depth width=$width length=$length<br><br>";
				}
				
				if (mb_strpos($name, "Угловой"))
				{
					//Комплект ящиков 430х450
					$this->insComponent(38221,$id);
					//Карниз на консоль
					$this->insComponent(38236,$id);
					//Ножка Н60 D60 (алюминий)
					$this->insComponent(38237,$id);
					//Ножка регулируемая (пластик)
					$this->insComponent(38238,$id);
					//Полка в пенал
					$this->insComponent(38242,$id);
					//Полка в платяное отделение
					$this->insComponent(38240,$id);
					//Скалка + скалкодержатель
					$this->insComponent(38243,$id);
					//Стойка
					$this->insComponent(38246,$id);
					//Микролифт
					$this->insComponent(38245,$id);
					if ($depth==450&&$length==2200)
					{
						//Консоль радиусная 2200х450
						$this->insComponent(38425,$id);
						//Консоль прямая 2200х450
						$this->insComponent(38215,$id);
					}
					if ($depth==450&&$length==2400)
					{
						//Консоль прямая 2400х450
						$this->insComponent(38222,$id);
						//Консоль радиусная 2400х450
						$this->insComponent(38229,$id);
					}
				}
				else
				{
					//Карниз на консоль
					$this->insComponent(38236,$id);
					//Ножка Н60 D60 (алюминий)
					$this->insComponent(38237,$id);
					//Ножка регулируемая (пластик)
					$this->insComponent(38238,$id);
					if ($depth==450&&$length==2200)
					{
						//Консоль радиусная 2200х450
						$this->insComponent(38425,$id);
						//Консоль прямая 2200х450
						$this->insComponent(38215,$id);
					}
					if ($depth==450&&$length==2400)
					{
						//Консоль прямая 2400х450
						$this->insComponent(38222,$id);
						//Консоль радиусная 2400х450
						$this->insComponent(38229,$id);
					}
					
					if ($depth==600&&$length==2200)
					{
						//Консоль радиусная 2200х600
						$this->insComponent(38217,$id);
						//Консоль прямая 2200х600
						$this->insComponent(38215,$id);
					}
					if ($depth==600&&$length==2400)
					{
						//Консоль прямая 2400х600
						$this->insComponent(38223,$id);
						//Консоль радиусная 2400х600
						$this->insComponent(38231,$id);
					}
					
					if ($length>=1000&&$length<=1800)
					{
						//Карниз 1000-1800
						$this->insComponent(38232,$id);
					}
					if ($length>=1900&&$length<=2700)
					{
						//Карниз 1810-2700
						$this->insComponent(38234,$id);
					}
					if ($length>=2800&&$length<=3600)
					{
						//Карниз 2710-3600
						$this->insComponent(38235,$id);
					}
					
					//Полка в пенал
					$this->insComponent(38242,$id);
					//Полка в платяное отделение
					$this->insComponent(38240,$id);
					//Стойка
					$this->insComponent(38246,$id);
					
					if ($depth==450)
					{
						//Микролифт
						$this->insComponent(38245,$id);
					}
					if ($depth==600)
					{
						//Скалка + скалкодержатель
						$this->insComponent(38243,$id);
					}
					
					if (($width==1000&&$depth==600)||($width==1100&&$depth==600)||($width==1200&&$depth==600)||($width==1300&&$depth==600)||($width==1400&&$depth==600)||($width==1500&&$depth==600)||($width==1900&&$depth==600)||($width==2000&&$depth==600)||($width==2800&&$depth==600)||($width==2900&&$depth==600)||($width==3000&&$depth==600)||($width==3100&&$depth==600)||($width==3200&&$depth==600)||($width==3300&&$depth==600))
					{
						//Комплект ящиков 430х600
						$this->insComponent(38225,$id);
					}
					if (($width==1000&&$depth==450)||($width==1100&&$depth==450)||($width==1200&&$depth==450)||($width==1300&&$depth==450)||($width==1400&&$depth==450)||($width==1500&&$depth==450)||($width==1900&&$depth==450)||($width==2000&&$depth==450)||($width==2800&&$depth==450)||($width==2900&&$depth==450)||($width==3000&&$depth==450)||($width==3100&&$depth==450)||($width==3200&&$depth==450)||($width==3300&&$depth==450))
					{
						//Комплект ящиков 430х450
						$this->insComponent(38221,$id);
					}
					if (($width==1700&&$depth==600)||($width==1800&&$depth==600)||($width==2100&&$depth==600)||($width==2200&&$depth==600)||($width==2300&&$depth==600)||($width==2400&&$depth==600)||($width==2500&&$depth==600)||($width==2600&&$depth==600)||($width==2700&&$depth==600)||($width==3400&&$depth==600)||($width==3500&&$depth==600)||($width==3600&&$depth==600))
					{
						//Комплект ящиков 600х600
						$this->insComponent(38227,$id);
					}
					if (($width==1700&&$depth==450)||($width==1800&&$depth==450)||($width==2100&&$depth==450)||($width==2200&&$depth==450)||($width==2300&&$depth==450)||($width==2400&&$depth==450)||($width==2500&&$depth==450)||($width==2600&&$depth==450)||($width==2700&&$depth==450)||($width==3400&&$depth==450)||($width==3500&&$depth==450)||($width==3600&&$depth==450))
					{
						//Комплект ящиков 600х450
						$this->insComponent(38226,$id);
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
$test=new insGoodsComponent();
$test->insGoodComp(9, 93);