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

class LuxeStudio
{
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

    private function hasFilter($id,$feature_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="select goodshasfeature_valueid from goodshasfeature WHERE goods_id=$good_id AND feature_id=$feature_id";
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
            return true;
        }
        else
        {
            return false;
        }
    }

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

    private function getSize($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="select goods_width, goods_depth, goods_height from goods WHERE goods_id=$id";
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
        $query="SELECT goodshaslang_name from goodshaslang WHERE goods_id=$id AND lang_id=1";
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

    public function setFilters()
    {
        $goods=$this->getGoodsByCatAndFactory(9,3894);
        //var_dump ($goods);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good;
                $name=$this->getName($id);
                $sizes=$this->getSize($id);
                if ($sizes['goods_width']<1000)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,3485);
                }
                if ($sizes['goods_width']>=1000&&$sizes['goods_width']<=1499)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,3486);
                }
                if ($sizes['goods_width']>=1500&&$sizes['goods_width']<=1999)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,3487);
                } 
                if ($sizes['goods_width']>=2000&&$sizes['goods_width']<=2499)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,3488);
                }
                if ($sizes['goods_width']>=2500&&$sizes['goods_width']<=2999)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,3489);
                }
                if ($sizes['goods_width']>=3000&&$sizes['goods_width']<=3499)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,3490);
                }
                if ($sizes['goods_width']>=4000&&$sizes['goods_width']<=4499)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,3491);
                }
                if ($sizes['goods_width']>=4500)
                {
                    $this->delFeature($id,286);
                    $this->insFilter($id,286,3492);
                }

                if ($sizes['goods_height']<2000)
                {
                    $this->delFeature($id,287);
                    $this->insFilter($id,287,3493);
                }
                if ($sizes['goods_height']>=2000&&$sizes['goods_height']<=2399)
                {
                    $this->delFeature($id,287);
                    $this->insFilter($id,287,3494);
                }
                if ($sizes['goods_height']>=2400&&$sizes['goods_height']<=2499)
                {
                    $this->delFeature($id,287);
                    $this->insFilter($id,287,3495);
                }
                if ($sizes['goods_height']>=2500&&$sizes['goods_height']<=2599)
                {
                    $this->delFeature($id,287);
                    $this->insFilter($id,287,3496);
                }
                if ($sizes['goods_height']>=2600&&$sizes['goods_height']<=2699)
                {
                    $this->delFeature($id,287);
                    $this->insFilter($id,287,3497);
                }
                if ($sizes['goods_height']>=2700)
                {
                    $this->delFeature($id,287);
                    $this->insFilter($id,287,3498);
                }

                if ($sizes['goods_depth']<430)
                {
                    $this->delFeature($id,288);
                    $this->insFilter($id,288,3499);
                }
                if ($sizes['goods_depth']>=430&&$sizes['goods_depth']<=449)
                {
                    $this->delFeature($id,288);
                    $this->insFilter($id,288,3500);
                }
                if ($sizes['goods_depth']>=450&&$sizes['goods_depth']<=579)
                {
                    $this->delFeature($id,288);
                    $this->insFilter($id,288,3501);
                }
                if ($sizes['goods_depth']>=580&&$sizes['goods_depth']<=600)
                {
                    $this->delFeature($id,288);
                    $this->insFilter($id,288,3502);
                }
                if ($sizes['goods_depth']>600)
                {
                    $this->delFeature($id,288);
                    $this->insFilter($id,288,3503);
                }

                $this->delFeature($id,289);
                $this->insFilter($id,289,3504);

                $this->delFeature($id,290);
                if (strripos($name,"ДСП")!=false)
                {
                    $this->insFilter($id,290,3507);
                }
                if (strripos($name,"Зеркал")!=false||strripos($name,"зеркал")!=false||strripos($name,"Фотопечать")!=false||strripos($name,"Фотопечать")!=false||strripos($name,"стекло")!=false||strripos($name,"Пескостр")!=false)
                {
                    $this->insFilter($id,290,3509);
                }
                if (strripos($name,"Комби")!=false)
                {
                    $this->insFilter($id,290,3512);
                }
                

                $this->delFeature($id,291);
                if ($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)
                {
                    $this->insFilter($id,291,3514);
                }
                if ($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)
                {
                    $this->insFilter($id,291,3515);
                }

                $this->delFeature($id,315);
                $this->insFilter($id,315,3298);
                $this->insFilter($id,315,3330);
                $this->insFilter($id,315,3303);
                $this->insFilter($id,315,3315);
                $this->insFilter($id,315,3302);
                $this->insFilter($id,315,3306);
                $this->insFilter($id,315,3308);

                $this->delFeature($id,292);
                $this->insFilter($id,315,3518);

                $this->delFeature($id,293);
                if (strripos($name,"Зеркал")!=false||strripos($name,"зеркал")!=false)
                {
                    $this->insFilter($id,293,3521);
                }
                if (strripos($name,"Фотопечать")!=false)
                {
                    $this->insFilter($id,293,3522);
                }
                if (strripos($name,"Пескоструй")!=false)
                {
                    $this->insFilter($id,293,3523);
                }

                $this->delFeature($id,294);
                $this->insFilter($id,294,3533);
                $this->insFilter($id,294,3534);
                $this->insFilter($id,294,3535);
                $this->insFilter($id,294,3536);

                $this->delFeature($id,295);
                $this->insFilter($id,295,3543);
                $this->insFilter($id,295,3544);
                $this->insFilter($id,295,3545);
                $this->insFilter($id,295,3546);
                $this->insFilter($id,295,3547);
                $this->insFilter($id,295,3548);
                $this->insFilter($id,295,3549);



            }

        }
        else
        {
            echo "no goods array<br>";
        }
    }
}

class ModMatroluxe
{
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

    private function getSize($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="select goods_width, goods_depth, goods_height from goods WHERE goods_id=$id";
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
        $query="SELECT goodshaslang_name from goodshaslang WHERE goods_id=$id AND lang_id=1";
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

        private function setMod ($id,$base_id);
        {
            $db_connect=mysqli_connect(host,user,pass,db);
            $query="UPDATE goods SET goods_parent=$base_id, goods_modtype=1, goods_modshow=0, goods_modfoto=0, goods_modreview=0 WHERE goods_id=$id";
            echo "$query<br>";
            mysqli_query($db_connect,$query);
            mysqli_close($db_connect);
        }
        

        public function setMod()
        {
            $goods=$this->getGoodsByCatAndFactory(9,3894);
            if (is_array($goods))
            {
                $id=$good;
                $name=$this->getName($id);
                $sizes=$this->getSize($id);
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 ДСП"!=false))
                {
                    if ($id!=46618)
                    {
                        $this->setMod($id,46618);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 ДСП"!=false))
                {
                    if ($id!=47113)
                    {
                        $this->setMod($id,47113);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Зеркала"!=false))
                {
                    if ($id!=46673)
                    {
                        $this->setMod($id,46673);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 Зеркала"!=false))
                {
                    if ($id!=47173)
                    {
                        $this->setMod($id,47173);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало"!=false))
                {
                    if ($id!=46728)
                    {
                        $this->setMod($id,46728);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало"!=false))
                {
                    if ($id!=47403)
                    {
                        $this->setMod($id,47403);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй"!=false))
                {
                    if ($id!=46783)
                    {
                        $this->setMod($id,46783);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй"!=false))
                {
                    if ($id!=47233)
                    {
                        $this->setMod($id,47233);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Зеркало/Пескоструй"!=false))
                {
                    if ($id!=46838)
                    {
                        $this->setMod($id,46838);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Пескоструя/Зеркало"!=false))
                {
                    if ($id!=47233)
                    {
                        $this->setMod($id,47233);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Пескоструй"!=false))
                {
                    if ($id!=46893)
                    {
                        $this->setMod($id,46893);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Пескоструй"!=false))
                {
                    if ($id!=47253)
                    {
                        $this->setMod($id,47253);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало"!=false))
                {
                    if ($id!=46948)
                    {
                        $this->setMod($id,46948);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало"!=false))
                {
                    if ($id!=47193)
                    {
                        $this->setMod($id,47193);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло"!=false))
                {
                    if ($id!=47003)
                    {
                        $this->setMod($id,47003);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло"!=false))
                {
                    if ($id!=47213)
                    {
                        $this->setMod($id,47213);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать"!=false))
                {
                    if ($id!=47003)
                    {
                        $this->setMod($id,47003);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать"!=false))
                {
                    if ($id!=47273)
                    {
                        $this->setMod($id,47273);
                    }
                }


            }
            else
            {
                echo "no goods array";
            }

        }
    }


}

$test=new LuxeStudio();
$test->setFilters();