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

class MakeDiscount
{
    private function getGoodsByCat($cat_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_id from goodshascategory WHERE category_id=$cat_id";
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

    function getGoodsByCatAndFactory($cat_id, $f_id)
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
		if (is_array ($goods_all))
		{
			//var_dump($goods_all);
			foreach ($goods_all as $good)
			{
				$id=$good['goods_id'];
				$features=$this->getFeatures($id);
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
    
    /**
     * выбираем товары, принадлижащие одной категории  кроме одной фабрики
     * @param $cat_id int айди категории
     * @param $f_id int айди фабрики, которую надо отсечь
     * @return array масссив ид товаров
     */
    private function getGoodsByCatAndNoFactory($cat_id, $f_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_id from goodshascategory WHERE category_id=$cat_id";
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
						if (($feature_id==232&&$val_id!=$f_id)&&($feature_id==232&&$val_id!=139)&&($feature_id==232&&$val_id!=34))
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
    
    /**
     * получаем список фильтров и их значения для товара
     * @param $good_id int айди товара
     * @return array|null массив айди фичей и их значения для товара
     */
    private function getFeaturesVal($good_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT feature_id,goodshasfeature_valueid from goodshasfeature WHERE goods_id=$good_id";
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

    private function getGoodsByFactory ($f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goodshasfeature WHERE feature_id=232 AND goodshasfeature_valueid=$f_id";
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

    private function getPrice($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_price FROM goods WHERE goods_id=$id";
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
            return $goods[0]['goods_price'];
        }
        else
        {
            return null;
        }
    }

    private function getOldPrice($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_oldprice FROM goods WHERE goods_id=$id";
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
            return $goods[0]['goods_oldprice'];
        }
        else
        {
            return null;
        }
    }

    private function writePrice($new_price,$old_price,$discount,$id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_price=$new_price, goods_oldprice=$old_price, goods_discount=$discount WHERE goods_id=$id";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        //var_dump(mysql_affected_rows());
        mysqli_close($db_connect);
    }

    private function addDiscount($disc_id,$goods_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="INSERT INTO discounthasgoods (discount_id,goods_id) VALUES ($disc_id,$goods_id)";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    private function isInStore($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshasfeature_valueid FROM goodshasfeature WHERE goods_id=$id AND feature_id=231";
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
        if ($goods[0]['goodshasfeature_valueid']==1)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function setDiscount($cat)
    {
        $goods=$this->getGoodsByCatAndNoFactory($cat,101);
        //var_dump($goods);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good;
                if ($this->isInStore($id)!=true)
                {
                    $new_price=$this->getOldPrice($id);
                    $this->writePrice($new_price,0,0,$id);
                    //$old_price=$this->getPrice($id);
                    //$new_price=round($old_price*0.9);
                    //$this->writePrice($new_price,$old_price,10,$id);
                    //$this->addDiscount(16,$id);
                }
                
                //break;
            }

        }
        else
        {
            echo "No goods!<br>";
        }

    }

    public function makeDiscountByFactory($f_id)
    {
        $goods=$this->getGoodsByFactory($f_id);
        //var_dump ($goods);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $old_price=$this->getPrice($id);
                $new_price=round($old_price*0.85);
                $this->writePrice($new_price,$old_price,15,$id);
                $this->addDiscount(11,$id);
            }

        }
        else
        {
            echo "No array!";
        }

    }



    public function unsetDiscount()
    {
        $goods=$this->getGoodsByCatAndNoFactory(9,101);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good;
                $new_price=$this->getOldPrice($id);
                //$new_price=round($old_price*0.85);
                $this->writePrice($new_price,0,0,$id);
               
                //$this->addDiscount(14,$id);
                //break;
            }

        }
        else
        {
            echo "No goods!<br>";
        }
    }

    public function ggg($f_id)
    {
        $goods=$this->getGoodsByFactory($f_id);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $new_price=$this->getOldPrice($id);
                //$new_price=round($old_price*0.85);
                $this->writePrice($new_price,0,0,$id);
                //$this->addDiscount(14,$id);
                //break;
            }

        }
        else
        {
            echo "No goods!<br>";
        }
    }

    public function delDiscount($discId)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="DELETE FROM discounthasgoods WHERE  discount_id=$discId";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    public function setDiscByCatAndFactory($cadId,$fId,$discId)
    {
        $goods=$this->getGoodsByCatAndFactory($cadId,$fId);
        //var_dump ($goods);
        
        foreach ($goods as $good)
        {
            
            $this->addDiscount($discId,$good);
        }
    }

    public function setDiscountByCat($catId,$discId)
    {
        $goods=$this->getGoodsByCat($catId);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $this->addDiscount($discId,$id);
                //break;
            }

        }
        else
        {
            echo "No goods!<br>";
        }
    }

}

$test=new MakeDiscount();
//$test->setDiscount();
//$test->unsetDiscount();
//$test->setDiscount(13);
//$test->setDiscount(5);
//$test->setDiscount(4);
//$test->setDiscount(10);
//$test->setDiscount(3);
//$test->setDiscount(124);
//$test->setDiscount(12);
//$test->setDiscount(125);
//$test->setDiscount(40);
//$test->setDiscount(11);
//$test->setDiscount(7);
//$test->setDiscount(59);
//$test->setDiscount(75);
//$test->setDiscount(9);
//$test->makeDiscountByFactory(136);
//$test->ggg(136);
//$test->delDiscount(16);
/*$test->setDiscountByCat(16);
$test->setDiscountByCat(34);
$test->setDiscountByCat(33);
$test->setDiscountByCat(17);
$test->setDiscountByCat(74);
$test->setDiscountByCat(71);
$test->setDiscountByCat(126);
$test->setDiscountByCat(32);
$test->setDiscountByCat(150);
$test->setDiscountByCat(151);
$test->setDiscountByCat(138);
$test->setDiscountByCat(127);*/
$test->setDiscByCatAndFactory(9,93,16);
$test->setDiscByCatAndFactory(9,101,16);
//$test->setDiscountByCat(9,16);