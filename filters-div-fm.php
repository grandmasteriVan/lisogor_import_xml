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

class FiltersDiv
{
    /**
     * удаляет определенное значение фильтра для товара
     * @param $goods_id int айди товара, в котором надо удалить значение фильтра
     * @param $f_id int айди фильтра
     * @param $val_id int айди значения фильтра
     */
    private function delFeatureVal($goods_id, $f_id, $val_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$f_id AND goodshasfeature_valueid=$val_id";
		echo "$query<br>";
		//mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}

    /**
     * вставляем новое значение фильтра в товар
     * @param $goods_id int айди товара
     * @param $feature_id int айди фильтра
     * @param $value_id int айди значения фильтра
     */
    private function insFeature($goods_id, $feature_id, $value_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="INSERT INTO goodshasfeature (goods_id, feature_id, goodshasfeature_valueid) VALUES ($goods_id, $feature_id, $value_id)";
		echo "$query<br><br>";
		//mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
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
     * выбираем все значения одного фильтра для определенного товара
     * @param $good_id int айди товара
     * @param $feature_id int айди фильтра
     * @return array|null массив айди значений фильтра
     */
    private function getFeature($good_id, $feature_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goodshasfeature_valueid from goodshasfeature WHERE goods_id=$good_id AND feature_id=$feature_id";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$goods[] = $row['goodshasfeature_valueid'];
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
     * вставляем новые значения фильтра Наполнение дивана в зависимости от старых значений
     */
    public function setNewFilters()
    {
        $goods=$this->getGoodsByCategory(1);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $feature_vals=$this->getFeature($id,242);
                //var_dump ($feature_vals);
                //echo "<br>";
                echo "$id ";
                $feature_vals=array_diff($feature_vals,array('3240','3241','3242','3243','3239'));
                var_dump ($feature_vals);
                echo "<br>";
                $is_new=false;
                if (count($feature_vals)==1&&in_array(3237,$feature_vals))
                {
                    echo "ППУ (3869)!<br>";
                    $is_new=true;
                }
                if (count($feature_vals)==2&&in_array(3237,$feature_vals)&&in_array(3236,$feature_vals))
                {
                    echo "Ламели+ППУ (3865)!<br>";
                    $is_new=true;
                }
                if (count($feature_vals)==3&&in_array(3236,$feature_vals)&&in_array(3238,$feature_vals)&&in_array(3237,$feature_vals))
                {
                    echo "Ламели+пружина+ППУ (3868)!<br>";
                    $is_new=true;
                }
                if ((count($feature_vals)==3&&in_array(3235,$feature_vals)&&in_array(3238,$feature_vals)&&in_array(3237,$feature_vals))||(count($feature_vals)==2&&in_array(3235,$feature_vals)&&in_array(3238,$feature_vals)))
                {
                    echo "Змейка+пружина+ППУ (3867)!<br>";
                    $is_new=true;
                }
                if ((count($feature_vals)==2&&in_array(3238,$feature_vals)&&in_array(3237,$feature_vals))||(count($feature_vals)==1&&in_array(3238,$feature_vals)))
                {
                    echo "Пружина+ППУ (3866)!<br>";
                    $is_new=true;
                }
                if (!$is_new&&!is_null($feature_vals))
                {
                    echo "Нет нового наполнения!<br>";
                }

            }
        }
    }

}

$test=new FiltersDiv();
$test->setNewFilters();