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

class CheckFilters
{
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

    private function is_active($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_noactual,goods_productionout from goods WHERE goods_id=$id";
		//echo "$query<br>";
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
		$act=$goods[0]['goods_noactual'];
		$out=$goods[0]['goods_productionout'];
		if ($act==1||$out==1)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

    public function testFilters()
    {
		//$goods=$this->getGoodsByCategory(10);
		$goods=$this->getGoodsByCategory(12);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $features=$this->getFeatures($id);
                //var_dump($features);
                if (is_array($features)&&$this->is_active($id))
                {
                    $is_new=false;
                    foreach ($features as $feature)
                    {
                        $f_id=$feature['feature_id'];
						//if ($f_id==330||$f_id==332||$f_id==333||$f_id==334||$f_id==332||$f_id==331||$f_id==336||$f_id==337||$f_id==338||$f_id==339||$f_id==335)
						if ($f_id==362||$f_id==363||$f_id==364||$f_id==365||$f_id==361||$f_id==366||$f_id==367||$f_id==368||$f_id==369||$f_id==360)
                        {
                            $is_new=true;
                        }
                    }
                    if (!$is_new)
                    {
                        echo "$id нет ни одного нового фильтра<br>";
                    }
                }
                //break;
            }
        }
        else
        {
            echo "No goods!<br>";
        }

    }
}

$test=new CheckFilters();
$test->testFilters();