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

class TestShk
{
    private function getGoodsByCatAndFactory($cat_id, $f_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_id FROM goodshascategory WHERE category_id=$cat_id";
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
    
    private function getFeaturesVal($good_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT feature_id,goodshasfeature_valueid FROM goodshasfeature WHERE goods_id=$good_id";
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

    private function getSize($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_width, goods_depth, goods_height FROM goods WHERE goods_id=$id";
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

    private function getName($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_name FROM goodshaslang WHERE goods_id=$id AND lang_id=1";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $names[] = $row;
                }
        }
        else
        {
             echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        if (is_array($names))
        {
            return $names[0]['goodshaslang_name'];
        }
        else
        {
            return null;
        }
    }

    private function delFeature($goods_id, $feature_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id";
        echo "$query<br>";
        //mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    private function insFilter($goods_id, $feature_id, $value_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="INSERT INTO goodshasfeature (goods_id, feature_id, goodshasfeature_valueid) VALUES ($goods_id, $feature_id, $value_id)";
        echo "$query<br><br>";
        //mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    public function test($f_id)
    {
        $goods=$this->getGoodsByCatAndFactory(9,$f_id);
        echo count ($goods)."<br>";
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good;
                $sizes=$this->getSize($id);
                $name=$this->getName($id);
                //var_dump($sizes);
                //echo "<br>";
                echo $name."<br>";
                //break;   
                if ($sizes['goods_width']==900)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,3485);
                }
                if ($sizes['goods_width']==1000)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4052);
                }
                if ($sizes['goods_width']==1100)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4053);
                } 
                if ($sizes['goods_width']==1200)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4054);
                }
                if ($sizes['goods_width']==1300)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4055);
                }
                if ($sizes['goods_width']==1400)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4056);
                }
                if ($sizes['goods_width']==1500)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4057);
                }
                if ($sizes['goods_width']==1600)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4058);
                }
                if ($sizes['goods_width']==1700)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4059);
                }
                if ($sizes['goods_width']==1800)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4060);
                }
                if ($sizes['goods_width']==1900)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4061);
                }
                if ($sizes['goods_width']==2000)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4062);
                }
                if ($sizes['goods_width']==2100)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4063);
                }
                if ($sizes['goods_width']==2200)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4064);
                }
                if ($sizes['goods_width']==2300)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4065);
                }
                if ($sizes['goods_width']==2400)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4066);
                }
                if ($sizes['goods_width']==2500)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4067);
                }
                if ($sizes['goods_width']==2600)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4068);
                }
                if ($sizes['goods_width']==2700)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4069);
                }
                if ($sizes['goods_width']==2800)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4070);
                }
                if ($sizes['goods_width']==2900)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4071);
                }
                if ($sizes['goods_width']==3000)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4072);
                }
                if ($sizes['goods_width']==3100)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4073);
                }
                if ($sizes['goods_width']==3200)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4074);
                }
                if ($sizes['goods_width']==3300)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4075);
                }
                if ($sizes['goods_width']==3400)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4076);
                }
                if ($sizes['goods_width']==3500)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4077);
                }
                if ($sizes['goods_width']==3600)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4078);
                }
                if ($sizes['goods_width']==3700)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4079);
                }
                if ($sizes['goods_width']==3800)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,4080);
                }
                //////
                if ($sizes['goods_height']==2000)
                {
                    $this->delFeature($id,287);
                    $this->insFilter($id,287,4081);
                }
                if ($sizes['goods_height']==2100)
                {
                    $this->delFeature($id,287);
                    $this->insFilter($id,287,4982);
                }
                if ($sizes['goods_height']==2200)
                {
                    $this->delFeature($id,287);
                    $this->insFilter($id,287,4083);
                }
                if ($sizes['goods_height']==2300)
                {
                    $this->delFeature($id,287);
                    $this->insFilter($id,287,4084);
                }
                if ($sizes['goods_height']==2400)
                {
                    $this->delFeature($id,287);
                    $this->insFilter($id,287,4085);
                }
                

                //материалы

                //$this->delFeature($id,290);
                if (strripos($name,"ДСП/Зеркало")!=false)
                {
                    $this->insFilter($id,290,4090);
                }
                if (strripos($name,"Пескоструй")!=false)
                {
                    $this->delFeature($id,290);
                    $this->insFilter($id,290,4088);
                }
                if (strripos($name,"Фотопечать")!=false)
                {
                    $this->delFeature($id,290);
                    $this->insFilter($id,290,4087);
                }
                if (strripos($name,"Зеркало/Пескоструй")!=false)
                {
                    $this->delFeature($id,290);
                    $this->insFilter($id,290,4094);
                    $this->insFilter($id,290,4088);
                    $this->insFilter($id,290,4094);
                }
                if (strripos($name,"ДСП/Пескоструй")!=false)
                {
                    $this->insFilter($id,290,4092);
                }
                if ((strripos($name,"зеркало")!=false)||(strripos($name,"стекло")!=false))
                {
                    $this->insFilter($id,290,3512);
                }

                

                //break;
            }
        }
    }
}

$test=new TestShk();
//$test->test(93);
$test->test(101);
//$test->test(3894);
