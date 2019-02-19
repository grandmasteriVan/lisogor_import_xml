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
define ("user", "root");
//define ("user", "newfm");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "N0r7F8g6");
/**
 * database name
 */
define ("db", "new_fm");
//define ("db", "newfm");

define ("host_host","176.114.3.186");
define ("user_host", "newfm_remote");
define ("pass_host", "F8g7T7d2");
define ("db_host", "newfm");


class FixFilters
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


    private function getFeatures($good_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select feature_id, goodshasfeature_valueid from goodshasfeature WHERE goods_id=$good_id";
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


    private function delHoshFeatures($goods_id)
    {
        $db_connect=mysqli_connect(host_host,user_host,pass_host,db_host);
        $query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id";
        echo "$query<br>";
        //mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    private function insHostFeature($goods_id,$feature_id,$value_id)
    {
        $db_connect=mysqli_connect(host_host,user_host,pass_host,db_host);
        $query="INSERT INTO goodshasfeature (goods_id, feature_id, goodshasfeature_valueid) VALUES ($goods_id, $feature_id, $value_id)";
        echo "$query<br>";
        //mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    public function fix()
    {
        $local_goods=$this->getGoodsByCategory(10);
        if (is_array ($local_goods))
        {
            foreach ($local_goods as $local_good)
            {
                $local_id=$local_good['goods_id'];
                $local_features=$this->getFeatures($local_id);
                if (is_array($local_features))
                {
                    $this->delHoshFeatures($local_id);
                    var_dump ($local_features);
                    echo "<br>";
                    foreach ($local_features as $local_feature)
                    {
                        $f_id=$local_feature['feature_id'];
                        $val_id=$local_feature['goodshasfeature_valueid'];
                        $this->insHostFeature($local_id,$f_id,$val_id);
                    }
                }
            }
        }
    }


}

$test=new FixFilters();
$test->fix();