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

class ChangeFactory
{
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
        //var_dump ($goods);
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

   
    private function setNewFactory($new_f_id,$good_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goodshasfeature SET goodshasfeature_valueid=$new_f_id WHERE goods_id=$good_id AND feature_id=232";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        $query="UPDATE goods SET factory_id=$new_f_id WHERE goods_id=$good_id";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    public function setFactory($old_fid, $new_fid)
    {
        $goods=$this->getGoodsByCatAndFactory(14,$old_fid);
        var_dump($goods);
        if (is_array($goods))
        {
            foreach($goods as $good)
            {
                $id=$good;
                var_dump ($id);
                $this->setNewFactory($new_fid,$id);
            }
        }
        else
        {
            echo "No Goods!<br>";
            var_dump($goods);
        }
    }
}

$test=new ChangeFactory();
$test->setFactory(3872,3872);