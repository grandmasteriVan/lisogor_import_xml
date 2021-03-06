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
                //var_dump ($features);
                if ($id==27727)
                {
                    var_dump ($features);
                }
                if (is_array($features))
                {
                    foreach ($features as $feature)
                    {
                        $feature_id=$feature['feature_id'];
                        //echo $feature_id." ";
                        if ($cat_id==9)
                        //шк
                        {
                            //
                            //if ($feature_id==221||$feature_id==222||$feature_id==223||$feature_id==16||$feature_id==15||$feature_id==32||$feature_id==6||$feature_id==198||$feature_id==154||$feature_id==18||$feature_id==16)
                            //{
                            //    $this->delFeature($id,$feature_id);
                            //}
                            if ($feature_id!=286&&$feature_id!=287&&$feature_id!=288&&$feature_id!=289&&$feature_id!=290&&$feature_id!=291&&$feature_id!=315&&$feature_id!=293&&$feature_id!=294&&$feature_id!=18&&$feature_id!=232&&$feature_id!=235&&$feature_id!=234&&$feature_id!=292&&$feature_id!=295)
                            {
                                $this->delFeature($id,$feature_id);
                            }

                        }
                        if ($cat_id==13)
                        //кровати
                        {
                            //if ($feature_id==227||$feature_id==47||$feature_id==50||$feature_id==6||$feature_id==49||$feature_id==48||$feature_id==17||$feature_id==18||$feature_id==50||$feature_id==48)
                            if ($feature_id!=316&&$feature_id!=317&&$feature_id!=318&&$feature_id!=319&&$feature_id!=320&&$feature_id!=321&&$feature_id!=323&&$feature_id!=324&&$feature_id!=322&&$feature_id!=232&&$feature_id!=235&&$feature_id!=234)
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
                        if ($cat_id==14)
                        //матрасы
                        {
                            //оставсляем только фильтры из списка
                            if ($feature_id!=276&&$feature_id!=277&&$feature_id!=237&&$feature_id!=278&&$feature_id!=279&&$feature_id!=280&&$feature_id!=281&&$feature_id!=282&&$feature_id!=283&&$feature_id!=284&&$feature_id!=285&&$feature_id!=232&&$feature_id!=234&&$feature_id!=235&&$feature_id!=229)
                            {
                                $this->delFeature($id,$feature_id);
                            }
                        }
                        if ($cat_id==7)
                        //журнальные столы
                        {
                            //оставсляем только фильтры из списка
                            if ($feature_id!=232&&$feature_id!=234&&$feature_id!=235&&$feature_id!=229&&$feature_id!=374&&$feature_id!=357&&$feature_id!=352&&$feature_id!=375&&$feature_id!=376&&$feature_id!=377&&$feature_id!=378&&$feature_id!=379)
                            {
                                $this->delFeature($id,$feature_id);
                            }
                        }

                        if ($cat_id==4)
                        //прихожие
                        {
                            //оставсляем только фильтры из списка
                            if ($feature_id!=232&&$feature_id!=234&&$feature_id!=235&&$feature_id!=229&&$feature_id!=303&&$feature_id!=304&&$feature_id!=305&&$feature_id!=306)
                            {
                                $this->delFeature($id,$feature_id);
                            }
                        }
                        if ($cat_id==124)
                        //тумбы
                        {
                            //оставсляем только фильтры из списка
                            if ($feature_id!=232&&$feature_id!=234&&$feature_id!=235&&$feature_id!=229&&$feature_id!=349&&$feature_id!=348&&$feature_id!=347&&$feature_id!=342&&$feature_id!=346&&$feature_id!=345&&$feature_id!=344&&$feature_id!=343&&$feature_id!=341&&$feature_id!=340)
                            {
                                $this->delFeature($id,$feature_id);
                            }
                        }
                        if ($cat_id==12)
                        //комоды
                        {
                            //оставсляем только фильтры из списка
                            if ($feature_id!=232&&$feature_id!=234&&$feature_id!=235&&$feature_id!=229&&$feature_id!=362&&$feature_id!=363&&$feature_id!=364&&$feature_id!=365&&$feature_id!=361&&$feature_id!=366&&$feature_id!=367&&$feature_id!=368&&$feature_id!=369&&$feature_id!=360)
                            {
                                $this->delFeature($id,$feature_id);
                            }
                        }
                        if ($cat_id==10)
                        //шкафы распашные
                        {
                            //оставсляем только фильтры из списка
                            if ($feature_id!=232&&$feature_id!=234&&$feature_id!=235&&$feature_id!=229&&$feature_id!=330&&$feature_id!=332&&$feature_id!=333&&$feature_id!=334&&$feature_id!=331&&$feature_id!=336&&$feature_id!=337&&$feature_id!=338&&$feature_id!=339&&$feature_id!=335)
                            {
                                $this->delFeature($id,$feature_id);
                            }
                        }
                        if ($cat_id==10)
                        //полки
                        {
                            //оставсляем только фильтры из списка
                            if ($feature_id!=232&&$feature_id!=234&&$feature_id!=235&&$feature_id!=229&&$feature_id!=254&&$feature_id!=255&&$feature_id!=256&&$feature_id!=257&&$feature_id!=258&&$feature_id!=259&&$feature_id!=260&&$feature_id!=261)
                            {
                                $this->delFeature($id,$feature_id);
                                //echo "1!<br>";
                            }
                        }
                        if ($cat_id==3)
                        //спальни
                        {
                            //оставсляем только фильтры из списка
                            if ($feature_id!=232&&$feature_id!=234&&$feature_id!=235&&$feature_id!=229&&$feature_id!=325&&$feature_id!=326&&$feature_id!=327&&$feature_id!=329&&$feature_id!=328)
                            {
                                $this->delFeature($id,$feature_id);
                                //echo "1!<br>";
                            }
                        }
                        
                    }
                }
                //break;
            }
        }
    }

    /**
     * удаляем старые фильтры во всех товарах одной фвбрики в одной категории (для ткстов)
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
$test1->delFilters(3);
//$test1->delFiltersTest(1,180);