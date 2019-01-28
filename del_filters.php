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
//define ("db", "new_fm");
define ("db", "newfm");
class CheckByCategory
{
    /**
     * выбираем товары, принадлижащие одной категории
     * @param $cat_id int айди категории
     * @return array масссив ид товаров
     */
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
        mysqli_close($db_connect);
		return $goods_all;
    }
    /**
     * выбираем количество категорий, к которым принадлижит данный товар
     * @param $id ид товара
     * @return int количество категорий, которое имеет товар
     */
    private function getCategoryForGood($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="select category_id from goodshascategory WHERE goods_id=$id";
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
		return count($goods_all);
    }
    /**
     * выводим все товары из данной категории, которые имеют больше одной категории
     * @param $cat_id int айди категории
     */
    public function test($cat_id)
    {
        $goods=$this->getGoodsByCategory($cat_id);
        if (is_array($goods))
        {
            foreach($goods as $good)
            {
                $id=$good['goods_id'];
                if ($this->getCategoryForGood($id)>1)
                {
                    echo "товар с ид=$id находится в нескольких категориях<br>";
                }
            }
        }
    }
}
class DellOldFilters
{
    /**
     * выбираем товары, принадлижащие одной категории и определенной фабрике
     * @param $cat_id int айди категории
     * @param $f_id int айди фабрики
     * @return array масссив ид товаров
     */
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
        var_dump ($goods);
		if (is_array ($goods_all))
		{
			//var_dump($goods_all);
			foreach ($goods_all as $good)
			{
				$id=$good['goods_id'];
				$features=$this->getFeaturesVal($id);
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
    
    /**
     * выбираем товары, принадлижащие одной категории
     * @param $cat_id int айди категории
     * @return array масссив ид товаров
     */
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
        mysqli_close($db_connect);
		return $goods_all;
    }
    /**
     * удаляем все значения определенного фильтра из товара
     * @param $goods_id int айди товара
     * @param $feature_id int айди фичи (фильтра)
     */
    private function delFeature($goods_id, $feature_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }
    /**
     * получаем список фильтров товара
     * @param $good_id int айди товара
     * @return array|null массив айди фичей товара
     */
    private function getFeatures($good_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="select distinct feature_id from goodshasfeature WHERE goods_id=$good_id";
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
     * получаем список фильтров и их значения для товара
     * @param $good_id int айди товара
     * @return array|null массив айди фичей и их значения для товара
     */
    private function getFeaturesVal($good_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="select feature_id,goodshasfeature_valueid from goodshasfeature WHERE goods_id=$good_id";
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
     * удаляем старые фильтры по категориям
     * @param $cat_id int ид категории, в которой надо удалить старые фильтры
     */
    public function delFilters($cat_id)
    {
        $goods=$this->getGoodsByCategory($cat_id);
        //var_dump($goods);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $features=$this->getFeatures($id);
                if ($id==27727)
                {
                    var_dump ($features);
                }
                if (is_array($features))
                {
                    foreach ($features as $feature)
                    {
                        $feature_id=$feature['feature_id'];
                        if ($cat_id==9)
                        {
                            //
                            if ($feature_id==221||$feature_id==222||$feature_id==223||$feature_id==16||$feature_id==15||$feature_id==32||$feature_id==6||$feature_id==198||$feature_id==154||$feature_id==18||$feature_id==16)
                            {
                                $this->delFeature($id,$feature_id);
                            }
                        }
                        if ($cat_id==13)
                        {
                            if ($feature_id==227||$feature_id==47||$feature_id==50||$feature_id==6||$feature_id==49||$feature_id==48||$feature_id==17||$feature_id==18||$feature_id==50||$feature_id==48)
                            {
                                $this->delFeature($id,$feature_id);
                            }
                        }
                        if ($cat_id==1)
                        {
                            //оставсляем только фильтры из списка
                            if ($feature_id!=232&&$feature_id!=235&&$feature_id!=237&&$feature_id!=238&&$feature_id!=239&&$feature_id!=240&&$feature_id!=241&&$feature_id!=242&&$feature_id!=243&&$feature_id!=244&&$feature_id!=245&&$feature_id!=246&&$feature_id!=247&&$feature_id!=248&&$feature_id!=84&&$feature_id!=85&&$feature_id!=230&&$feature_id!=234)
                            {
                                $this->delFeature($id,$feature_id);
                            }
                        }
                        
                    }
                }
            }
        }
    }

    /**
     * удаляем старые фильтры во всех товарах одной фвбрики в одной каьегории (для ткстов)
     * @param $cat_id int ид категории, в которой надо удалить старые фильтры
     *  @param $f_id int ид фабрики, в которой надо удалить старые фильтры
     */
    public function delFiltersTest($cat_id,$f_id)
    {
        $goods=$this->getGoodsByCatAndFactory($cat_id,$f_id);
        var_dump($goods);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good;
                $features=$this->getFeatures($id);
                
                if (is_array($features))
                {
                    foreach ($features as $feature)
                    {
                        $feature_id=$feature['feature_id'];
                        if ($cat_id==1)
                        {
                            if ($feature_id!=232&&$feature_id!=235&&$feature_id!=237&&$feature_id!=238&&$feature_id!=239&&$feature_id!=240&&$feature_id!=241&&$feature_id!=242&&$feature_id!=243&&$feature_id!=244&&$feature_id!=245&&$feature_id!=246&&$feature_id!=247&&$feature_id!=248&&$feature_id!=84&&$feature_id!=85&&$feature_id!=230&&$feature_id!=234)
                            {
                                $this->delFeature($id,$feature_id);
                            }
                        }
                        
                    }
                }
                //break;
            }
        }
    }
}
//$test=new CheckByCategory();
//$test->test(13);
$test1=new DellOldFilters();
$test1->delFilters(1);
//$test1->delFiltersTest(1,180);