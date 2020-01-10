<?php
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
define ("host","localhost");
//define ("host","localhost");
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

class Garant
{
    private function getNotActiveGoodsByCatAndFactory($cat_id, $f_id)
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
                            
                            if ($this->isActive($id)==false)
                            {
                                $goods_by_factoty[]=$id;
                            }
							//break;
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

    private function isActive($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT	goodshaslang_active FROM goodshaslang WHERE goods_id=$id AND lang_id=1";
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
        if ( $goods[0]['goodshaslang_active']==0)
        {
            return false;
        }
        else
        {
            return true;
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

    /**
     * getName
     * получаем имя товара (русское)
     *
     * @param  mixed $id
     *
     * @return void
     */
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

    private function writeSizes($id,$width,$dep,$height)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_width=$width, goods_depth=$dep, goods_height=$height WHERE goods_id=$id";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    public function setSizes($f_id,$cat_id)
    {
        $goods=$this->getNotActiveGoodsByCatAndFactory($cat_id,$f_id);
        //var_dump ($goods);
        
        foreach ($goods as $good)
        {
            $id=$good;
            //отсекаем старые шк
            if ($id>50000)
            {
                $name=$this->getName($id);
                echo "$name<br>";
                $sizes=explode(" ",$name);
                //var_dump ($sizes);
                $sizes=explode("*",$sizes[0]);
                
                $width=$sizes[0];
                $depth=$sizes[1];
                $height=$sizes[2];
                $this->writeSizes($id,$width,$depth,$height);
                $this->unset1Ccodes($id);
                //break;
            }
        }
    }

    private function unset1Ccodes ($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_article_1c='' WHERE goods_id=$id";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    /**
     * getSize
     * получаем размеры определеного товара (из данных, записаных в БД)
     *
     * @param  mixed $id
     *
     * @return void
     */
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

    /**
     * delFeature
     * полностью удаляем фильтр из товара
     *
     * @param  mixed $goods_id
     * @param  mixed $feature_id
     *
     * @return void
     */
    private function delFeature($goods_id, $feature_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id";
        //echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    /**
     * insFilter
     * добавляем новый фильт и его значение в товар
     *
     * @param  mixed $goods_id
     * @param  mixed $feature_id
     * @param  mixed $value_id
     *
     * @return void
     */
    private function insFilter($goods_id, $feature_id, $value_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="INSERT INTO goodshasfeature (goods_id, feature_id, goodshasfeature_valueid) VALUES ($goods_id, $feature_id, $value_id)";
        //echo "$query<br><br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    public function setFilters($f_id,$cat_id)
    {
        $goods=$this->getNotActiveGoodsByCatAndFactory($cat_id,$f_id);
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
                if (strripos($name,"Зеркал")!=false||strripos($name,"Фотопечать")!=false||strripos($name,"Пескоструй")!=false)
                {
                    $this->insFilter($id,290,3509);
                }
                
                

                $this->delFeature($id,291);
                if (strripos($name,"2дв")!=false)
                {
                    $this->insFilter($id,291,3514);
                }
                if (strripos($name,"3дв")!=false)
                {
                    $this->insFilter($id,291,3515);
                }
                if (strripos($name,"4дв ")!=false)
                {
                    $this->insFilter($id,291,351);
                }

                $this->delFeature($id,315);
                $this->insFilter($id,315,3298);
                $this->insFilter($id,315,3299);
                $this->insFilter($id,315,3300);
                $this->insFilter($id,315,3302);
                $this->insFilter($id,315,3303);
                $this->insFilter($id,315,3308);
                $this->insFilter($id,315,3315);
                $this->insFilter($id,315,3316);

                $this->delFeature($id,292);
                $this->insFilter($id,292,3518);

                $this->delFeature($id,293);
                if (strripos($name,"Зеркал")!=false)
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

                echo "$id done <br>";
            }
        }
        else
        {
            echo "no goods array<br>";
        }
    }

    /**
     * setComp
     * добавляем составную часть в товар
     *
     * @param  mixed $good_id
     * @param  mixed $comp_id
     * @param  mixed $count
     *
     * @return void
     */
    private function setComp ($good_id,$comp_id,$count)
   	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="INSERT INTO component (goods_id, component_child, component_in_complect) VALUES ($good_id,$comp_id,$count)";
		echo "$query<br><br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}

    public function setComponents()
    {
        $goods=$this->getNotActiveGoodsByCatAndFactory(9,93);
        $components=$this->getNotActiveGoodsByCatAndFactory(154,93);
        echo "goods=".count ($goods)."<br>";
        echo "components=".count ($components)."<br>";
        foreach ($goods as $good)
        {
            $id=$good;
            $sizes=$this->getSize($id);
            $name=$this->getName($id);
            echo "$name<br>";
            //echo "<pre>";
            //print_r ($sizes);
            //echo "</pre>";
            //var_dump($sizes);
            //корпуса
            foreach ($components as $component)
            {
                $conpName=' '.$this->getName($component);
                if (strripos($conpName,"Корпус")!=false)
                {
                    
                    //echo "$conpName<br>";
                    $compSizes=explode(" ",$conpName);
                    //echo "<pre>";
                    //print_r ($compSizes);
                    //echo "</pre>";
                    $compSizes=explode("*",$compSizes[2]);
                    //echo "<pre>";
                    //print_r ($compSizes);
                    //echo "</pre>";
                    //var_dump($compSizes);
                    //$query="SELECT goods_width, goods_depth, goods_height FROM goods WHERE goods_id=$id";
                    if (strcasecmp($sizes['goods_width'],$compSizes[2])==0&&strcasecmp($sizes['goods_depth'],$compSizes[1])==0&&strcasecmp($sizes['goods_height'],$compSizes[0])==0)
                    {
                        $this->setComp($id,$component,1);
                        break;
                    }
                    //if (strcasecmp($conpName," Корпус 2400*600*1000")==0)
                    //{
                    //    echo "Yup!<br>";
                    //    echo $sizes['goods_width']."-".$compSizes[2]."<br>".$sizes['goods_depth']."-".$compSizes[1]."<br>".$sizes['goods_height']."-".$compSizes[0]."<br>";
                    //}

                }
            }
            //фасады
            
            $tmp=explode(" ",$name);
            $facade=$tmp[2];
            $count=$tmp[1];
            //$DSPcount=mb_substr_count($facade,"ДСП");
            $MIRRcount=mb_substr_count($facade,"Зеркало");
            foreach ($components as $component)
            {
                $conpName=' '.$this->getName($component);
                if (strripos($conpName,"Фасад")!=false)
                {
                    //echo "$conpName<br>";
                    $compWith=explode("*",$conpName);
                    $compWith=$compWith[1];
                    $compHeigth=explode(" ",$conpName);
                    $compHeigth=$compHeigth[2];
                    //$compType=explode("*",$conpName);
                    //$compType=$compType[0];
                    //$compType=explode(" ",$compType);
                    //$compType=$compType[2];
                    if (strcasecmp($sizes['goods_height'],$compHeigth)==0&&strcasecmp($sizes['goods_width'],$compWith)==0)
                    {
                        //нашли размер фасада
                        if ($MIRRcount>0&&strripos($conpName,"зеркало")!=false)
                        {
                            $this->setComp($id,$component,$MIRRcount);
                        }
                        if (strripos($conpName,"фотопечать")!=false&&strripos($name,"Фотопечать")!=false)
                        {
                            $this->setComp($id,$component,$count[0]);
                        }
                        if (strripos($conpName,"пескоструй")!=false&&strripos($name,"Пескоструй")!=false)
                        {
                            $this->setComp($id,$component,$count[0]);
                        }
                    }
                    
                }
                
            }
            //для одного шкафа    
            //break;
        }
    }

    /**
     * setMod
     * добавляем модификацию товара
     * 
     * @param  mixed $id
     * @param  mixed $base_id
     *
     * @return void
     */
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
        $goods=$this->getNotActiveGoodsByCatAndFactory(9,93);
        foreach ($goods as $good)
        {
            $id=$good;
            if ($id>50000)
            {
                $name=$this->getName($id);
                $sizes=$this->getSize($id);
                $doorCount=explode(" ",$name);
                $doorCount=$doorCount[1];
                $doorCount=(int)$doorCount[0];
                //$facade=explode(" ",$name);
                //$facade=$facade[2];
                echo "$name<br>";
                //var_dump ($doorCount);
                //echo $facade."-".$doorCount."<br>";
                /*var_dump($sizes);
                if (strripos($name,"ДСП/ДСП")!=false)
                {
                    echo "фасады ок - $id<br>";
                }
                if ($doorCount==2)
                {
                    echo "кол-во дверей ок - $id<br>";
                }
                if ((int)$sizes['goods_depth']==450)
                {
                    echo "ширина ок - $id<br>";
                }
                if ((int)$sizes['goods_height']==2200)
                {
                    echo "высота ок - $id<br>";
                }
                */

                if (($doorCount==2)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58497)
                    {
                        $this->setMod($id,58497);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58506)
                    {
                        $this->setMod($id,58506);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58515)
                    {
                        $this->setMod($id,58515);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Фотопечать")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58524)
                    {
                        $this->setMod($id,58524);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Пескоструй")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58533)
                    {
                        $this->setMod($id,58533);
                    }
                }

                if (($doorCount==2)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58659)
                    {
                        $this->setMod($id,58659);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58668)
                    {
                        $this->setMod($id,58668);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58677)
                    {
                        $this->setMod($id,58677);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Фотопечать")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58686)
                    {
                        $this->setMod($id,58686);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Пескоструй")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58695)
                    {
                        $this->setMod($id,58695);
                    }
                }

                if (($doorCount==2)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58821)
                    {
                        $this->setMod($id,58821);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58830)
                    {
                        $this->setMod($id,58830);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58839)
                    {
                        $this->setMod($id,58839);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Фотопечать")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58848)
                    {
                        $this->setMod($id,58848);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Пескоструй")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58848)
                    {
                        $this->setMod($id,58857);
                    }
                }

                if (($doorCount==2)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58983)
                    {
                        $this->setMod($id,58983);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58992)
                    {
                        $this->setMod($id,58992);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59001)
                    {
                        $this->setMod($id,59001);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Фотопечать")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59010)
                    {
                        $this->setMod($id,59010);
                    }
                }
                if (($doorCount==2)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Пескоструй")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59019)
                    {
                        $this->setMod($id,59019);
                    }
                }

                if (($doorCount==3)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/ДСП/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58542)
                    {
                        $this->setMod($id,58542);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/ДСП/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58569)
                    {
                        $this->setMod($id,58569);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Зеркало/Зеркало/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58560)
                    {
                        $this->setMod($id,58560);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Зеркало/Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58551)
                    {
                        $this->setMod($id,58551);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Фотопечать")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58578)
                    {
                        $this->setMod($id,58578);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Пескоструй")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58587)
                    {
                        $this->setMod($id,58587);
                    }
                }

                if (($doorCount==3)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/ДСП/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58704)
                    {
                        $this->setMod($id,58704);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/ДСП/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58731)
                    {
                        $this->setMod($id,58731);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Зеркало/Зеркало/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58722)
                    {
                        $this->setMod($id,58722);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Зеркало/Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58713)
                    {
                        $this->setMod($id,58713);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Фотопечать")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58740)
                    {
                        $this->setMod($id,58740);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Пескоструй")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58749)
                    {
                        $this->setMod($id,58749);
                    }
                }

                if (($doorCount==3)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/ДСП/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58866)
                    {
                        $this->setMod($id,58866);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/ДСП/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58893)
                    {
                        $this->setMod($id,58893);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Зеркало/Зеркало/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58884)
                    {
                        $this->setMod($id,58884);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Зеркало/Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58875)
                    {
                        $this->setMod($id,58875);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Фотопечать")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58902)
                    {
                        $this->setMod($id,58902);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Пескоструй")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58911)
                    {
                        $this->setMod($id,58911);
                    }
                }

                if (($doorCount==3)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/ДСП/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59028)
                    {
                        $this->setMod($id,59028);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/ДСП/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59055)
                    {
                        $this->setMod($id,59055);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Зеркало/Зеркало/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59046)
                    {
                        $this->setMod($id,59046);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Зеркало/Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59037)
                    {
                        $this->setMod($id,59037);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Фотопечать")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59064)
                    {
                        $this->setMod($id,59064);
                    }
                }
                if (($doorCount==3)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Пескоструй")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59073)
                    {
                        $this->setMod($id,59073);
                    }
                }

                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/ДСП/ДСП/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58596)
                    {
                        $this->setMod($id,58596);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/ДСП/ДСП/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58596)
                    {
                        $this->setMod($id,58596);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/ДСП/Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58614)
                    {
                        $this->setMod($id,58614);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Зеркало/Зеркало/Зеркало/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58632)
                    {
                        $this->setMod($id,58632);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Зеркало/Зеркало/Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58605)
                    {
                        $this->setMod($id,58605);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Фотопечать")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58641)
                    {
                        $this->setMod($id,58641);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Пескоструй")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58650)
                    {
                        $this->setMod($id,58650);
                    }
                }

                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/ДСП/ДСП/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58758)
                    {
                        $this->setMod($id,58758);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/ДСП/ДСП/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58785)
                    {
                        $this->setMod($id,58785);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/ДСП/Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58776)
                    {
                        $this->setMod($id,58776);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Зеркало/Зеркало/Зеркало/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58794)
                    {
                        $this->setMod($id,58794);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Зеркало/Зеркало/Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58767)
                    {
                        $this->setMod($id,58767);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Фотопечать")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58803)
                    {
                        $this->setMod($id,58803);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==450)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Пескоструй")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58812)
                    {
                        $this->setMod($id,58812);
                    }
                }

                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/ДСП/ДСП/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58920)
                    {
                        $this->setMod($id,58920);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/ДСП/ДСП/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58947)
                    {
                        $this->setMod($id,58947);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"ДСП/ДСП/Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58938)
                    {
                        $this->setMod($id,58938);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Зеркало/Зеркало/Зеркало/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58956)
                    {
                        $this->setMod($id,58956);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Зеркало/Зеркало/Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58929)
                    {
                        $this->setMod($id,58929);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Фотопечать")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58965)
                    {
                        $this->setMod($id,58965);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2200)&&strripos($name,"Пескоструй")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=58974)
                    {
                        $this->setMod($id,58974);
                    }
                }

                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/ДСП/ДСП/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59082)
                    {
                        $this->setMod($id,59082);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/ДСП/ДСП/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59109)
                    {
                        $this->setMod($id,59109);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"ДСП/ДСП/Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59100)
                    {
                        $this->setMod($id,59100);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Зеркало/Зеркало/Зеркало/ДСП")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59118)
                    {
                        $this->setMod($id,59118);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Зеркало/Зеркало/Зеркало/Зеркало")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59091)
                    {
                        $this->setMod($id,59091);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Фотопечать")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59127)
                    {
                        $this->setMod($id,59127);
                    }
                }
                if (($doorCount==4)&&((int)$sizes['goods_depth']==600)&&((int)$sizes['goods_height']==2400)&&strripos($name,"Пескоструй")!=false)
                {
                    //echo "Yay!<br>";
                    if ($id!=59136)
                    {
                        $this->setMod($id,59136);
                    }
                }
                //break;
            }
            
        }
    }

    public function rename()
    {
        $goods=$this->getNotActiveGoodsByCatAndFactory(9,93);
        foreach ($goods as $good)
        {
            $id=$good;
            if ($id>50000)
            {
                $name=$this->getName($id);
                $sizes=explode(" ",$name);
                $numDoors=$sizes[1];
                $material=$sizes[2];
                $sizes=$sizes[0];
                $sizes=str_ireplace("*","х",$sizes);
                $materialName="";
                //echo "$name: sizes-$sizes material-$material numDoors-$numDoors<br>";
                /*if ($material,"Зеркало/Зеркало/Зеркало"==0)
                {
                    $material="3 зеркала";
                }*/
                $countDSP=substr_count($material,"ДСП");
                if ($countDSP>1)
                {
                    $materialName.="$countDSP ДСП";
                }
                if ($countDSP==1)
                {
                    $materialName.=" ДСП ";
                }
                $MIRRcount=substr_count($material,"Зеркало");
                if ($MIRRcount>1)
                {
                    $materialName.="$MIRRcount Зеркала";
                }
                if ($MIRRcount==1)
                {
                    $materialName.=" Зеркало";
                }
                
                if (strcasecmp($material,"Фотопечать")==0)
                {
                    $materialName="Фотопечать";
                }
                if (strcasecmp($material,"Пескоструй")==0)
                {
                    $materialName="Пескоструй";
                }
                
                if (strcasecmp($numDoors,"2дв")==0)
                {
                    $numDoors="двухдверный";
                }
                if (strcasecmp($numDoors,"3дв")==0)
                {
                    $numDoors="трехдверный";
                    $contRu=$this->getCont($id,1);
                    $contUa=$this->getCont($id,2);
                    $contRu=str_ireplace("двухдверный","трехдверный",$contRu);
                    $contUa=str_ireplace("двома дверима","трьома дверима",$contUa);
                    $this->setCont($id,$contRu,1);
                    $this->setCont($id,$contUa,2);

                }
                if (strcasecmp($numDoors,"4дв")==0)
                {
                    $numDoors="четырехдверный";
                    $contRu=$this->getCont($id,1);
                    $contUa=$this->getCont($id,2);
                    $contRu=str_ireplace("двухдверный","четырехдверный",$contRu);
                    $contUa=str_ireplace("двома дверима","чотирьма дверима",$contUa);
                    $this->setCont($id,$contRu,1);
                    $this->setCont($id,$contUa,2);
                }
                $materialName=str_ireplace("ДСП2","ДСП 2",$materialName);
                $nameRu="Шкаф-купе $numDoors $sizes $materialName";
                $nameUa=str_ireplace("Шкаф","Шафа",$nameRu);
                $nameUa=str_ireplace("Зеркал","Дзеркал",$nameUa);
                $nameUa=str_ireplace("Пескоструй","Піскоструй",$nameUa);
                $nameUa=str_ireplace("двухдверный","дводверна",$nameUa);
                $nameUa=str_ireplace("трехдверный","трьохдверна",$nameUa);
                $nameUa=str_ireplace("четырехдверный","чотиридверна",$nameUa);
                $nameUa=str_ireplace("Фотопечать","Фотодрук",$nameUa);
                //echo "<b>$name</b>: Шкаф-купе $numDoors $sizes $materialName<br>";
                echo "<b>$name</b>: $nameRu - $nameUa<br>";
                //$this->setName($id,$nameRu,1);
                //$this->setName($id,$nameUa,2);
                $this->setActive($id);
                //break;

            }
        }
    }

    public function patch()
    {
        $goods=$this->getNotActiveGoodsByCatAndFactory(9,93);
        foreach ($goods as $good)
        {
            $id=$good;
            if ($id>50000)
            {
                $name=$this->getName($id);
                
                if (strripos($name,"трехдверный")>0)
                {
                    //$numDoors="трехдверный";
                    //$contRu=$this->getCont($id,1);
                    $contUa=$this->getCont($id,2);
                    //$contRu=str_ireplace("двухдверный","трехдверный",$contRu);
                    $contUa=str_ireplace("двома дверима","трьома дверима",$contUa);
                    //$this->setCont($id,$contRu,1);
                    $this->setCont($id,$contUa,2);

                }
                if ((strripos($name,"четырехдверный")>0))
                {
                    //$numDoors="четырехдверный";
                    //$contRu=$this->getCont($id,1);
                    $contUa=$this->getCont($id,2);
                    //$contRu=str_ireplace("двухдверный","четырехдверный",$contRu);
                    $contUa=str_ireplace("двома дверима","чотирьма дверима",$contUa);
                    //$this->setCont($id,$contRu,1);
                    $this->setCont($id,$contUa,2);
                }
                

            }
        }
    }
    
    
    private function setName($id,$name,$lang)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goodshaslang SET goodshaslang_name='$name' WHERE goods_id=$id AND lang_id=$lang";
		echo "$query<br>";
		//mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
    }
    private function setActive($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goodshaslang SET goodshaslang_active=1 WHERE goods_id=$id";
		echo "$query<br>";
		//mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
    }

    private function getCont ($id, $lang)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goodshaslang_content from goodshaslang WHERE goods_id=$id AND lang_id=$lang";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$cont[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
		}
		mysqli_close($db_connect);
		if (is_array($cont))
		{
			return $cont[0]['goodshaslang_content'];
		}
		else
		{
			return null;
		}
    }
    
    private function setCont($id, $cont, $lang)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goodshaslang SET goodshaslang_content='$cont' WHERE goods_id=$id AND lang_id=$lang";
		//echo "$query<br><br>";
		echo "$id content rewrited!<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
    
}

$test=new Garant();
//$test->setSizes(93,9);
//
//$test->setFilters(93,9);
//$test->setComponents();
//$test->setModSHK();
$test->rename();
//$test->patch();
echo "Done";