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

class fixFilters
{
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
		return $goods_all;
    }

    /*
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
    */
    
    private function delFilters($goods_id, $feature_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id";
		echo "$query<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
    }

    function insFilter($goods_id, $feature_id, $value_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="INSERT INTO goodshasfeature (goods_id, feature_id, goodshasfeature_valueid) VALUES ($goods_id, $feature_id, $value_id)";
        echo "$query<br><br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    private function getSize($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="select goods_width, goods_length, goods_height from goods WHERE goods_id=$id";
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
            return $sizes;
        }
        else
        {
            return null;
        }
    }

    public function setSp()
    {
        $goods=$this->getGoodsByCategory(13);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                unset($sizes);
                $id=$good['goods_id'];
                //$features=$this->getFeatures($id);
                $sizes=$this->getSize($id);
                //echo "<br>";
                //var_dump($features);

                $this->delFilters($id,317);
                //var_dump($sizes);
                //echo "<br>";
                $goods_width=$sizes[0]['goods_width'];
                echo "width=$goods_width<br>";
                if ($goods_width>0&&$goods_width<=1200)
                {
                   $this->insFilter($id,317,3618);
                }
                if ($goods_width>=1201&&$goods_width<=1600)
                {
                    $this->insFilter($id,317,3620);
                }
                if ($goods_width>=1601)
                {
                    $this->insFilter($id,317,3619);
                }
                
                /*
                $has_type=false;
                foreach ($features as $feature)
                {
                    echo "<br><br>";
                    var_dump ($feature);
                    $feature_id=$feature['feature_id'];
                    if ($feature_id==317)
                    {
                        $has_type=true;
                    }
                }

                if ($has_type==false)
                {
                    echo "<br>$id has no type<br>";
                }
                //break;
                
               
                foreach ($features as $feature)
                {
                    if ($feature['feature_id']==317)
                    {
                        $this->delFilters($id,317);
                        //var_dump($sizes);
                        //echo "<br>";
                        $goods_width=$sizes[0]['goods_width'];
                        echo "width=$goods_width<br>";
                        if ($goods_width<=1200)
                        {
                            $this->insFilter($id,317,3618);
                        }
                        if ($goods_width>=1201&&$goods_width<=1600)
                        {
                            $this->insFilter($id,317,3620);
                        }
                        if ($goods_width>=1601)
                        {
                            $this->insFilter($id,317,3619);
                        }
                    }
                    
                }*/

            }
            
        }
    }
    
    public function printFilters()
    {
        $goods=$this->getGoodsByCategory(13);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $features=$this->getFeatures($id);
                foreach ($features as $feature)
                {
                    if ($feature['feature_id']==317&&$feature['goodshasfeature_valueid']==3622)
                    {
                        echo "Чердак: $id<br>";
                    }
                    if ($feature['feature_id']==317&&$feature['goodshasfeature_valueid']==3621)
                    {
                        echo "Двухарусная: $id<br>";
                    }

                }
            }

        }
        else
        {
            echo "No Goods!";
        }
    }
}

$test=new fixFilters();
$test->setSp();