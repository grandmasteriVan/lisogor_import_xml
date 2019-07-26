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
                if (strripos($name," Пескоструй")!=false)
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
    }

    private function setMod ($id,$base_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_parent=$base_id, goods_modtype=1, goods_modshow=0, goods_modfoto=0, goods_modreview=0 WHERE goods_id=$id";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }
        

    public function setModSHK()
    {
        $goods=$this->getGoodsByCatAndFactory(9,3894);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good;
                $name=$this->getName($id);
                $sizes=$this->getSize($id);
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=46618)
                    {
                        $this->setMod($id,46618);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=47113)
                    {
                        $this->setMod($id,47113);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=46673)
                    {
                        $this->setMod($id,46673);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=47173)
                    {
                        $this->setMod($id,47173);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=46728)
                    {
                        $this->setMod($id,46728);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=47133)
                    {
                        $this->setMod($id,47133);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=46783)
                    {
                        $this->setMod($id,46783);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=47153)
                    {
                        $this->setMod($id,47153);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=46838)
                    {
                        $this->setMod($id,46838);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=47233)
                    {
                        $this->setMod($id,47233);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=46893)
                    {
                        $this->setMod($id,46893);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=47253)
                    {
                        $this->setMod($id,47253);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=46948)
                    {
                        $this->setMod($id,46948);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=47193)
                    {
                        $this->setMod($id,47193);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=47003)
                    {
                        $this->setMod($id,47003);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=47213)
                    {
                        $this->setMod($id,47213);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=47058)
                    {
                        $this->setMod($id,47058);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=47273)
                    {
                        $this->setMod($id,47273);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=47293)
                    {
                        $this->setMod($id,47293);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=47788)
                    {
                        $this->setMod($id,47788);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=47348)
                    {
                        $this->setMod($id,47348);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=47848)
                    {
                        $this->setMod($id,47848);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=47403)
                    {
                        $this->setMod($id,47403);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=47808)
                    {
                        $this->setMod($id,47808);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=47458)
                    {
                        $this->setMod($id,47458);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=47828)
                    {
                        $this->setMod($id,47828);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=47513)
                    {
                        $this->setMod($id,47513);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=47908)
                    {
                        $this->setMod($id,47908);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=47568)
                    {
                        $this->setMod($id,47568);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=47928)
                    {
                        $this->setMod($id,47928);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=47623)
                    {
                        $this->setMod($id,47623);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=47868)
                    {
                        $this->setMod($id,47868);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=47678)
                    {
                        $this->setMod($id,47678);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=47888)
                    {
                        $this->setMod($id,47888);
                    }
                }

                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=47733)
                    {
                        $this->setMod($id,47733);
                    }
                }
                if ((strripos($name,"Классик 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=47948)
                    {
                        $this->setMod($id,47948);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=47968)
                    {
                        $this->setMod($id,47968);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=48463)
                    {
                        $this->setMod($id,48463);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=48023)
                    {
                        $this->setMod($id,48023);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=48523)
                    {
                        $this->setMod($id,48523);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=48078)
                    {
                        $this->setMod($id,48078);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=48483)
                    {
                        $this->setMod($id,48483);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=48133)
                    {
                        $this->setMod($id,48133);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=48503)
                    {
                        $this->setMod($id,48503);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=48188)
                    {
                        $this->setMod($id,48188);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=48583)
                    {
                        $this->setMod($id,48583);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=48243)
                    {
                        $this->setMod($id,48243);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=48603)
                    {
                        $this->setMod($id,48603);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=48298)
                    {
                        $this->setMod($id,48298);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=48543)
                    {
                        $this->setMod($id,48543);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=48353)
                    {
                        $this->setMod($id,48353);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=48563)
                    {
                        $this->setMod($id,48563);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=48408)
                    {
                        $this->setMod($id,48408);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=48623)
                    {
                        $this->setMod($id,48623);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=48643)
                    {
                        $this->setMod($id,48643);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=49138)
                    {
                        $this->setMod($id,49138);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=48698)
                    {
                        $this->setMod($id,48698);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=49198)
                    {
                        $this->setMod($id,49198);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=48753)
                    {
                        $this->setMod($id,48753);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=49158)
                    {
                        $this->setMod($id,49158);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=48808)
                    {
                        $this->setMod($id,48808);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=49178)
                    {
                        $this->setMod($id,49178);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=48863)
                    {
                        $this->setMod($id,48863);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=49258)
                    {
                        $this->setMod($id,49258);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=48918)
                    {
                        $this->setMod($id,48918);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=49278)
                    {
                        $this->setMod($id,49278);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=48973)
                    {
                        $this->setMod($id,48973);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=49218)
                    {
                        $this->setMod($id,49218);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=49028)
                    {
                        $this->setMod($id,49028);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=49238)
                    {
                        $this->setMod($id,49238);
                    }
                }

                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=49083)
                    {
                        $this->setMod($id,49083);
                    }
                }
                if ((strripos($name,"Классик 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=49298)
                    {
                        $this->setMod($id,49298);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=49318)
                    {
                        $this->setMod($id,49318);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=49813)
                    {
                        $this->setMod($id,49813);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=49373)
                    {
                        $this->setMod($id,49373);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=49873)
                    {
                        $this->setMod($id,49873);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=49428)
                    {
                        $this->setMod($id,49428);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=49833)
                    {
                        $this->setMod($id,49833);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=49483)
                    {
                        $this->setMod($id,49483);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=49853)
                    {
                        $this->setMod($id,49853);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=49538)
                    {
                        $this->setMod($id,49538);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=49933)
                    {
                        $this->setMod($id,49933);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=49593)
                    {
                        $this->setMod($id,49593);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=49953)
                    {
                        $this->setMod($id,49953);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=49648)
                    {
                        $this->setMod($id,49648);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=49893)
                    {
                        $this->setMod($id,49893);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=49703)
                    {
                        $this->setMod($id,49703);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=49913)
                    {
                        $this->setMod($id,49913);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=49758)
                    {
                        $this->setMod($id,49758);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=49973)
                    {
                        $this->setMod($id,49973);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=49993)
                    {
                        $this->setMod($id,49993);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=50488)
                    {
                        $this->setMod($id,50488);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=50048)
                    {
                        $this->setMod($id,50048);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=50548)
                    {
                        $this->setMod($id,50548);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=50103)
                    {
                        $this->setMod($id,50103);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=50508)
                    {
                        $this->setMod($id,50508);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=50158)
                    {
                        $this->setMod($id,50158);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=50528)
                    {
                        $this->setMod($id,50528);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=50213)
                    {
                        $this->setMod($id,50213);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=50608)
                    {
                        $this->setMod($id,50608);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=50268)
                    {
                        $this->setMod($id,50268);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=50628)
                    {
                        $this->setMod($id,50628);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=50323)
                    {
                        $this->setMod($id,50323);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=50568)
                    {
                        $this->setMod($id,50568);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=50378)
                    {
                        $this->setMod($id,50378);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=50588)
                    {
                        $this->setMod($id,50588);
                    }
                }

                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=50433)
                    {
                        $this->setMod($id,50433);
                    }
                }
                if ((strripos($name,"Классик 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=50648)
                    {
                        $this->setMod($id,50648);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=50668)
                    {
                        $this->setMod($id,50668);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=51163)
                    {
                        $this->setMod($id,51163);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=50723)
                    {
                        $this->setMod($id,50723);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=51223)
                    {
                        $this->setMod($id,51223);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=50778)
                    {
                        $this->setMod($id,50778);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=51183)
                    {
                        $this->setMod($id,51183);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=50833)
                    {
                        $this->setMod($id,50833);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=51203)
                    {
                        $this->setMod($id,51203);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=50888)
                    {
                        $this->setMod($id,50888);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=51283)
                    {
                        $this->setMod($id,51283);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=50943)
                    {
                        $this->setMod($id,50943);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=51303)
                    {
                        $this->setMod($id,51303);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=50998)
                    {
                        $this->setMod($id,50998);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=51243)
                    {
                        $this->setMod($id,51243);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=51053)
                    {
                        $this->setMod($id,51053);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=51263)
                    {
                        $this->setMod($id,51263);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=51108)
                    {
                        $this->setMod($id,51108);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=51323)
                    {
                        $this->setMod($id,51323);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=51343)
                    {
                        $this->setMod($id,51343);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=51838)
                    {
                        $this->setMod($id,51838);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=51398)
                    {
                        $this->setMod($id,51398);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=51898)
                    {
                        $this->setMod($id,51898);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=51453)
                    {
                        $this->setMod($id,51453);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=51858)
                    {
                        $this->setMod($id,51858);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=51508)
                    {
                        $this->setMod($id,51508);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=51878)
                    {
                        $this->setMod($id,51878);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=51563)
                    {
                        $this->setMod($id,51563);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=51958)
                    {
                        $this->setMod($id,51958);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=51618)
                    {
                        $this->setMod($id,51618);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=51978)
                    {
                        $this->setMod($id,51978);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=51673)
                    {
                        $this->setMod($id,51673);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=51918)
                    {
                        $this->setMod($id,51918);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=51728)
                    {
                        $this->setMod($id,51728);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=51938)
                    {
                        $this->setMod($id,51938);
                    }
                }

                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=51783)
                    {
                        $this->setMod($id,51783);
                    }
                }
                if ((strripos($name,"Классик 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=51998)
                    {
                        $this->setMod($id,51998);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=52018)
                    {
                        $this->setMod($id,52018);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=52513)
                    {
                        $this->setMod($id,52513);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=52073)
                    {
                        $this->setMod($id,52073);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=52573)
                    {
                        $this->setMod($id,52573);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=52128)
                    {
                        $this->setMod($id,52128);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=52533)
                    {
                        $this->setMod($id,52533);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=52183)
                    {
                        $this->setMod($id,52183);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=52553)
                    {
                        $this->setMod($id,52553);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=52238)
                    {
                        $this->setMod($id,52238);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=52633)
                    {
                        $this->setMod($id,52633);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=52293)
                    {
                        $this->setMod($id,52293);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=52653)
                    {
                        $this->setMod($id,52653);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=52348)
                    {
                        $this->setMod($id,52348);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=52593)
                    {
                        $this->setMod($id,52593);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=52403)
                    {
                        $this->setMod($id,52403);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=52613)
                    {
                        $this->setMod($id,52613);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=52458)
                    {
                        $this->setMod($id,52458);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=52673)
                    {
                        $this->setMod($id,52673);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=52693)
                    {
                        $this->setMod($id,52693);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=53188)
                    {
                        $this->setMod($id,53188);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=52748)
                    {
                        $this->setMod($id,52748);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=53248)
                    {
                        $this->setMod($id,53248);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=52803)
                    {
                        $this->setMod($id,52803);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=53208)
                    {
                        $this->setMod($id,53208);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=52858)
                    {
                        $this->setMod($id,52858);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=53228)
                    {
                        $this->setMod($id,53228);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=52913)
                    {
                        $this->setMod($id,52913);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=53308)
                    {
                        $this->setMod($id,53308);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=52968)
                    {
                        $this->setMod($id,52968);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=53328)
                    {
                        $this->setMod($id,53328);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=53023)
                    {
                        $this->setMod($id,53023);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=53268)
                    {
                        $this->setMod($id,53268);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=53078)
                    {
                        $this->setMod($id,53078);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=53288)
                    {
                        $this->setMod($id,53288);
                    }
                }

                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=53133)
                    {
                        $this->setMod($id,53133);
                    }
                }
                if ((strripos($name,"Стандарт 1")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=53348)
                    {
                        $this->setMod($id,53348);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=53368)
                    {
                        $this->setMod($id,53368);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=53863)
                    {
                        $this->setMod($id,53863);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=53423)
                    {
                        $this->setMod($id,53423);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=53923)
                    {
                        $this->setMod($id,53923);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=53478)
                    {
                        $this->setMod($id,53478);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=53883)
                    {
                        $this->setMod($id,53883);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=53533)
                    {
                        $this->setMod($id,53533);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=53903)
                    {
                        $this->setMod($id,53903);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=53588)
                    {
                        $this->setMod($id,53588);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=53983)
                    {
                        $this->setMod($id,53983);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=53643)
                    {
                        $this->setMod($id,53643);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=54003)
                    {
                        $this->setMod($id,54003);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=53698)
                    {
                        $this->setMod($id,53698);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=53943)
                    {
                        $this->setMod($id,53943);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=53753)
                    {
                        $this->setMod($id,53753);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=53963)
                    {
                        $this->setMod($id,53963);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=53808)
                    {
                        $this->setMod($id,53808);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=54023)
                    {
                        $this->setMod($id,54023);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=54043)
                    {
                        $this->setMod($id,54043);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=54538)
                    {
                        $this->setMod($id,54538);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=54098)
                    {
                        $this->setMod($id,54098);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=54598)
                    {
                        $this->setMod($id,54598);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=54153)
                    {
                        $this->setMod($id,54153);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=54558)
                    {
                        $this->setMod($id,54558);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=54208)
                    {
                        $this->setMod($id,54208);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=54578)
                    {
                        $this->setMod($id,54578);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=54263)
                    {
                        $this->setMod($id,54263);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=54658)
                    {
                        $this->setMod($id,54658);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=54318)
                    {
                        $this->setMod($id,54318);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=54678)
                    {
                        $this->setMod($id,54678);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=54373)
                    {
                        $this->setMod($id,54373);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=54618)
                    {
                        $this->setMod($id,54618);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=54428)
                    {
                        $this->setMod($id,54428);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=54638)
                    {
                        $this->setMod($id,54638);
                    }
                }

                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=54483)
                    {
                        $this->setMod($id,54483);
                    }
                }
                if ((strripos($name,"Стандарт 2")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=54698)
                    {
                        $this->setMod($id,54698);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=54718)
                    {
                        $this->setMod($id,54718);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=55213)
                    {
                        $this->setMod($id,55213);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=54773)
                    {
                        $this->setMod($id,54773);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=55273)
                    {
                        $this->setMod($id,55273);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=54828)
                    {
                        $this->setMod($id,54828);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=55233)
                    {
                        $this->setMod($id,55233);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=54883)
                    {
                        $this->setMod($id,54883);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=55253)
                    {
                        $this->setMod($id,55253);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=54938)
                    {
                        $this->setMod($id,54938);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=55333)
                    {
                        $this->setMod($id,55333);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=54993)
                    {
                        $this->setMod($id,54993);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=55353)
                    {
                        $this->setMod($id,55353);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=55048)
                    {
                        $this->setMod($id,55048);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=55293)
                    {
                        $this->setMod($id,55293);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=55103)
                    {
                        $this->setMod($id,55103);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=55313)
                    {
                        $this->setMod($id,55313);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=55158)
                    {
                        $this->setMod($id,55158);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=55373)
                    {
                        $this->setMod($id,55373);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=55393)
                    {
                        $this->setMod($id,55393);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=55888)
                    {
                        $this->setMod($id,55888);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=55448)
                    {
                        $this->setMod($id,55448);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=55948)
                    {
                        $this->setMod($id,55948);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=55503)
                    {
                        $this->setMod($id,55503);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=55908)
                    {
                        $this->setMod($id,55908);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=55558)
                    {
                        $this->setMod($id,55558);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=55928)
                    {
                        $this->setMod($id,55928);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=55613)
                    {
                        $this->setMod($id,55613);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=56008)
                    {
                        $this->setMod($id,56008);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=55668)
                    {
                        $this->setMod($id,55668);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=56028)
                    {
                        $this->setMod($id,56028);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=55723)
                    {
                        $this->setMod($id,55723);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=55968)
                    {
                        $this->setMod($id,55968);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=55778)
                    {
                        $this->setMod($id,55778);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=55988)
                    {
                        $this->setMod($id,55988);
                    }
                }

                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=55833)
                    {
                        $this->setMod($id,55833);
                    }
                }
                if ((strripos($name,"Стандарт 3")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=56048)
                    {
                        $this->setMod($id,56048);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=56068)
                    {
                        $this->setMod($id,56068);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=56563)
                    {
                        $this->setMod($id,56563);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=56123)
                    {
                        $this->setMod($id,56123);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=56623)
                    {
                        $this->setMod($id,56623);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=56178)
                    {
                        $this->setMod($id,56178);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=56583)
                    {
                        $this->setMod($id,56583);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=56233)
                    {
                        $this->setMod($id,56233);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=56603)
                    {
                        $this->setMod($id,56603);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=56288)
                    {
                        $this->setMod($id,56288);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=56683)
                    {
                        $this->setMod($id,56683);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=56343)
                    {
                        $this->setMod($id,56343);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=56703)
                    {
                        $this->setMod($id,56703);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=56398)
                    {
                        $this->setMod($id,56398);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=56643)
                    {
                        $this->setMod($id,56643);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=56453)
                    {
                        $this->setMod($id,56453);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=56663)
                    {
                        $this->setMod($id,56663);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=56508)
                    {
                        $this->setMod($id,56508);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==450)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=56723)
                    {
                        $this->setMod($id,56723);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 ДСП")!=false))
                {
                    if ($id!=56743)
                    {
                        $this->setMod($id,56743);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 ДСП")!=false))
                {
                    if ($id!=57238)
                    {
                        $this->setMod($id,57238);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Зеркала")!=false))
                {
                    if ($id!=56798)
                    {
                        $this->setMod($id,56798);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"3 Зеркала")!=false))
                {
                    if ($id!=57298)
                    {
                        $this->setMod($id,57298);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=56853)
                    {
                        $this->setMod($id,56853);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Зеркало")!=false))
                {
                    if ($id!=57258)
                    {
                        $this->setMod($id,57258);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=56908)
                    {
                        $this->setMod($id,56908);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"ДСП/Пескоструй")!=false))
                {
                    if ($id!=57278)
                    {
                        $this->setMod($id,57278);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Зеркало/Пескоструй")!=false))
                {
                    if ($id!=56963)
                    {
                        $this->setMod($id,56963);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"2 Пескоструя/Зеркало")!=false))
                {
                    if ($id!=57358)
                    {
                        $this->setMod($id,57358);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=57018)
                    {
                        $this->setMod($id,57018);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name," Пескоструй")!=false))
                {
                    if ($id!=57378)
                    {
                        $this->setMod($id,57378);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=57073)
                    {
                        $this->setMod($id,57073);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби зеркало")!=false))
                {
                    if ($id!=57318)
                    {
                        $this->setMod($id,57318);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=57128)
                    {
                        $this->setMod($id,57128);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Комби стекло")!=false))
                {
                    if ($id!=57338)
                    {
                        $this->setMod($id,57338);
                    }
                }

                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=1000&&$sizes['goods_width']<=2000)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=57183)
                    {
                        $this->setMod($id,57183);
                    }
                }
                if ((strripos($name,"Стандарт 4")!=false)&&($sizes['goods_width']>=2100&&$sizes['goods_width']<=2400)&&($sizes['goods_depth']==600)&&(strripos($name,"Фотопечать")!=false))
                {
                    if ($id!=57398)
                    {
                        $this->setMod($id,57398);
                    }
                }

            }
            
        }
        else
        {
            echo "no goods array";
        }

    }
}

class ComponentsMatroluxe
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

    private function setComp ($good_id,$comp_id]\7
    \7)
   	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="INSERT INTO component (goods_id, component_child, component_in_complect) VALUES ($good_id,$comp_id)";
		echo "$query<br><br>";
		//mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}

    public function setComponents()
    {
        $goods=$this->getGoodsByCatAndFactory(9,3894);
        $components=$this->getGoodsByCatAndFactory(154,3894);
        echo "goods=".count ($goods)."<br>";
        echo "components=".count ($components)."<br>";
        foreach ($goods as $good)
        {
            $id=$good;
            $goods_sizes=$this->getSize($id);
            $name=$this->getName($id);
            $name_explode_main=explode(" ",$name);
            //var_dump ($name_explode_main);
            $name_main_serries=$name_explode_main[1]." ".$name_explode_main[2];
            //echo "$name_main_serries <br><br>";

            //var_dump ($goods_sizes);
            //echo "<br>";
            foreach ($components as $comp) 
            {
                $name_comp=$this->getName($comp);
                $name_tmp=explode(" ",$name_comp);
                //var_dump ($name_tmp);
                $sizes_comp=$name_tmp[3];
                //формат: высота, ширина, глубина
                $sizes_comp=explode("*",$sizes_comp);
                $name_comp_series=$name_tmp[1]." ".$name_tmp[2];
                //echo "$name_comp_series<br>";
                
                if ($name_main_serries==$name_comp_series)
                {
                    //echo "попали в цикл<br>";
                    //var_dump ($sizes_comp);
                    //echo "<br>";
                    //высоты у нас, на самом деле 2
                    //глубины тоже 2
                    //а вот ширина компонента должна ряваятся ширине шкафа
                    if ($goods_sizes['goods_depth']==$sizes_comp[2])
                    {
                        //echo "нашли товар по глубине<br>";
                        if ($sizes_comp[1]==$goods_sizes['goods_width'])
                        {
                            //echo "нашли товар по ширине<br>";
                            //echo $goods_sizes['goods_height']." - ".$sizes_comp[0];
                            if(($goods_sizes['goods_height']==2000||$goods_sizes['goods_height']==2100)&&($sizes_comp[0]=='2000-2100'))
                            {
                                $this->setComp($id,$comp);
                                break;
                            }
                            if(($goods_sizes['goods_height']==2200||$goods_sizes['goods_height']==2300||$goods_sizes['goods_height']==2400)&&($sizes_comp[0]=='2200-2400'))
                            {
                                $this->setComp($id,$comp);
                                break;
                            }
                        }
                    }
                }
            }
            //break;

        }

    }
}




//$test=new LuxeStudio();
//$test->setFilters();

//$test=new ModMatroluxe();
//$test->setModSHK();

$test=new ComponentsMatroluxe();
$test->setComponents();
