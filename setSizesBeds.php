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

class Beds
{
    private function getGoodsByCat($cat_id)
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
        return $goods_all;
    }

    private function getGoodById($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT * FROM goods WHERE goods_id=$id";
		if ($res=mysqli_query($db_connect,$query))
		{
			while ($row = mysqli_fetch_assoc($res))
			{
		   		$good[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";		
		}
		mysqli_close($db_connect);
        //var_dump ($good);
        //array(1) { [0]=> array(42) { ["goods_id"]=> string(5) "14472" ["goods_pict"]=> string(3) "jpg" ["goods_pictnew"]=> string(0) "" ["goods_article"]=> string(7) "1414472" ["goods_similar"]=> string(0) "" ["goods_buywith"]=> string(0) "" ["goods_kindcat"]=> string(1) "0" ["goods_price"]=> string(3) "500" ["goods_pricecur"]=> string(1) "0" ["goods_oldprice"]=> string(1) "0" ["goods_discount"]=> string(1) "0" ["goods_lider"]=> string(1) "0" ["goods_lidermain"]=> string(1) "0" ["goods_popular"]=> string(1) "0" ["goods_measurement"]=> string(1) "0" ["goods_width"]=> string(3) "800" ["goods_length"]=> string(4) "1900" ["goods_height"]=> string(1) "0" ["goods_depth"]=> string(1) "0" ["goods_modtype"]=> string(1) "0" ["goods_parent"]=> string(5) "14472" ["goods_modshow"]=> string(1) "0" ["goods_modfoto"]=> string(1) "0" ["goods_modreview"]=> string(1) "0" ["goods_maintissue"]=> string(1) "0" ["goods_maincategory"]=> string(2) "14" ["goods_noactual"]=> string(1) "1" ["goods_notshowinlist"]=> string(1) "0" ["goods_doorseria"]=> string(1) "0" ["goods_priceord"]=> string(3) "500" ["goods_article_link"]=> string(45) "Наматрацник 80*190/Протект" ["goods_free_delivery"]=> string(1) "0" ["goods_counter"]=> string(3) "478" ["goods_alternative_good"]=> string(1) "0" ["goods_article_1c"]=> string(12) "ФК-0008856" ["goods_showdisc"]=> string(1) "1" ["goods_productionout"]=> string(1) "1" ["factory_id"]=> string(2) "35" ["goods_mebelis_article"]=> string(0) "" ["goods_new"]=> string(1) "0" ["goods_width_sp"]=> string(1) "0" ["goods_length_sp"]=> string(1) "0" } }
        return $good;
    }

    /*private function checkValueLang($val_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT * FROM fvaluehaslang WHERE fvalue_id=$val_id and lang_id=2";
		if ($res=mysqli_query($db_connect,$query))
		{
			while ($row = mysqli_fetch_assoc($res))
			{
				$features[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";
		}
		if (is_array($features))
		{
			return $features;
		}
		else
		{
			return false;
		}
	}*/

    private function getValForFeature($f_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT fkind_id from feature where feature_id=$f_id";
		if ($res=mysqli_query($db_connect,$query))
		{
			while ($row = mysqli_fetch_assoc($res))
			{
				$fkind[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";
		}
		if (is_array($fkind))
		{
			$fkind=$fkind[0]['fkind_id'];
			//$query="select fvalue_id from fvalue where fkind_id=$fkind";
            $query="SELECT * from fvalue where fkind_id=$fkind";
			if ($res=mysqli_query($db_connect,$query))
			{
				while ($row = mysqli_fetch_assoc($res))
				{
					$fvalue[] = $row;
				}
				//var_dump($fvalue);
				return $fvalue;
			}
			else
			{
				echo "Error in SQL: $query<br>";
			}
		}
	}

    private function setSize($id, $width, $len)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_width_sp=$width, goods_length_sp=$len WHERE goods_id=$id";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    private function checkValueLang($val_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT * from fvaluehaslang where fvalue_id=$val_id and lang_id=2";
		if ($res=mysqli_query($db_connect,$query))
		{
			while ($row = mysqli_fetch_assoc($res))
			{
				$features[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";
		}
		if (is_array($features))
		{
			//var_dump ($features);
            echo "<pre>";print_r($features);echo "</pre>";
            return true;
		}
		else
		{
			return false;
		}
	}

    private function getFilterForGood($goods_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT * FROM goodshasfeature WHERE goods_id=$goods_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $filters[] = $row;
            }
        }
        else
        {
            echo "Error in SQL: ".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
        if (is_array($filters))
        {
            //echo "<pre>";print_r($filters);echo "</pre>";
            return $filters;
        }
        else
        {
            return null;
        }
    }

    private function getSizes($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_width, goods_length FROM goods WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $sizes[] = $row;
            }
        }
        else
        {
            echo "Error in SQL: ".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
        if (is_array($sizes))
        {
            //echo "<pre>";print_r($filters);echo "</pre>";
            return $sizes[0];
        }
        else
        {
            return null;
        }
    }

    public function copySizes()
    {
        $goods=$this->getGoodsByCat(14);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $sizes=$this->getSizes($id);
                //echo "<pre>";print_r($sizes);echo "</pre>";
                $width=$sizes['goods_width'];
                $len=$sizes['goods_length'];
                $this->setSize($id,$width,$len);
                //break;
            }
        }
    }

    public function test()
    {
        $goods=$this->getGoodsByCat(13);
        //echo "<pre>";print_r($goods);echo "</pre>";
        if (is_array($goods))
        {
            //получаем список всех значений атрибута "размер спального места и их значений"
            /*$vals=$this->getValForFeature(316);
            if (is_array($vals))
            {
                foreach ($vals as $val)
                {
                    $val_id=$val['fvalue_id'];
					$this->checkValueLang($val_id);
                } 
            }*/
            
            //$this->getFilterForGood(36794);
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $this->getGoodById($id);
                $filters=$this->getFilterForGood($id);
                //break;
                if (is_array($filters))
                {
                    foreach ($filters as $filter)
                    {
                        if ($filter['feature_id']==316)
                        {
                            $filterVal=$filter['goodshasfeature_valueid'];
                            if ($filterVal==3604)
                            {
                                $width=800;
                                $len=1900;
                            }
                            if ($filterVal==3605)
                            {
                                $width=900;
                                $len=1900;
                            }
                            if ($filterVal==3606)
                            {
                                $width=900;
                                $len=2000;
                            }
                            if ($filterVal==3607)
                            {
                                $width=1200;
                                $len=1900;
                            }
                            if ($filterVal==3608)
                            {
                                $width=1200;
                                $len=2000;
                            }
                            if ($filterVal==3609)
                            {
                                $width=1400;
                                $len=1900;
                            }
                            if ($filterVal==3610)
                            {
                                $width=1400;
                                $len=2000;
                            }
                            if ($filterVal==3611)
                            {
                                $width=1500;
                                $len=1900;
                            }
                            if ($filterVal==3612)
                            {
                                $width=1600;
                                $len=1900;
                            }
                            if ($filterVal==3613)
                            {
                                $width=1600;
                                $len=2000;
                            }
                            if ($filterVal==3614)
                            {
                                $width=1800;
                                $len=1900;
                            }
                            if ($filterVal==3615)
                            {
                                $width=1800;
                                $len=2000;
                            }
                            if ($filterVal==3616)
                            {
                                $width=2000;
                                $len=2000;
                            }
                            if ($filterVal==4011)
                            {
                                $width=800;
                                $len=2000;
                            }
                            //echo "id=$id width=$width len=$len<br>";
                            $this->setSize($id,$width,$len);
                        }
                    }
                }
            }
        }

    }
}

echo "<b>Start</b> ".date("Y-m-d H:i:s")."<br>";
$test=new Beds();
$test->copySizes();
//$test->test();
echo "<b>Done</b> ".date("Y-m-d H:i:s");