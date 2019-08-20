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

class FiltersFix
{
    private function getPrice ($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_priceord FROM goods WHERE goods_id=$id";
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
        if (is_array($goods_all))
        {
            return $goods_all[0]['goods_priceord'];
        }
        else
        {
            return null;
        }
    }

    private function getGoodsPrice($catId, $minPrice, $maxPrice)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_id FROM goodshascategory WHERE category_id=$catId";
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
        foreach ($goods_all as $good)
        {
            $id=$good['goods_id'];
            $price=$this->getPrice($id);
            //echo "$id=$price<br>";
            if ($price>=$minPrice&&$price<$maxPrice)
            {
                $return[]=$id;
            }

        }
        return $return;
    }

    private function delFeature($goods_id, $feature_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    private function insFilter($goods_id, $feature_id, $value_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="INSERT INTO goodshasfeature (goods_id, feature_id, goodshasfeature_valueid) VALUES ($goods_id, $feature_id, $value_id)";
        echo "$query<br><br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    public function FixPriceCat($catId)
    {
        //9000-17000-17000+
        $goods=$this->getGoodsPrice($catId,0,10000);
        //var_dump ($goods);
        foreach ($goods as $good)
        {
            $id=$good;
            $this->delFeature($id,235);
            $this->insFilter($id,235,556);
        }


    }

    private function getSize($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_width, goods_depth, goods_height, goods_length FROM goods WHERE goods_id=$id";
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
        mysqli_close($db_connect);
        if (is_array($sizes))
        {
            return $sizes[0];
        }
        else
        {
            return null;
        }
    }

    private function getGoodsByCat($catId)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_id FROM goodshascategory WHERE category_id=$catId";
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

    private function SetSizes($id,$width,$depth,$height,$length)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_width=$width, goods_depth=$depth, goods_height=$height, goods_length=$length WHERE goods_id=$id";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    private function setSliper($id,$width,$length)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goodshasfeature SET goodshasfeature_valuenum=$width WHERE goods_id=$id AND feature_id=84";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        $query="UPDATE goodshasfeature SET goodshasfeature_valuenum=$length WHERE goods_id=$id AND feature_id=85";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    private function isActual($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_noactual FROM goods WHERE goods_id=$id";
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
        if ($goods[0]['goods_noactual']==1)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function FixSizes()
    {

        $goods=$this->getGoodsByCat(38);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $sizes=$this->getSize($id);
                /*if ($sizes['goods_length']>$sizes['goods_width'])
                {
                    echo "$id длинна больше ширины<br>";
                    $this->SetSizes($id,$sizes['goods_length'],$sizes['goods_depth'],$sizes['goods_height'],$sizes['goods_width']);

                }*/
                //$this->SetSizes($id,$sizes['goods_width'],$sizes['goods_length'],$sizes['goods_height'],0);
                if ($sizes['goods_depth']==0&&$this->isActual($id))
                {
                    echo "$id<br>";
                }
            }

        }
        else
        {
            echo "No array!<br>";
        }
    }

    private function getSleeper ($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        //ширина
        $query="SELECT goodshasfeature_valuenum FROM goodshasfeature WHERE goods_id=$id AND feature_id=84";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$width[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
        }
        //длинна
        $query="SELECT goodshasfeature_valuenum FROM goodshasfeature WHERE goods_id=$id AND feature_id=85";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$length[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        $sizes['width']=(int)$width[0]['goodshasfeature_valuenum'];
        $sizes['length']=(int)$length[0]['goodshasfeature_valuenum'];
        return $sizes;

    }

    public function testSleeper ($catId)
    {
        $goods=$this->getGoodsByCat($catId);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $sizes=$this->getSleeper($id);
                
                if ($sizes['width']>$sizes['length'])
                {
                    var_dump ($sizes);
                    echo "$id<br>";
                    $this->setSliper($id,$sizes['length'],$sizes['width']);
                }

            }
        }
    }
}

$test=new FiltersFix();
$test->FixPriceCat(38);
//$test->FixSizes();
//$test->testSleeper(1);
//echo "<br><br>";
//$test->testSleeper(38);