<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 10.07.2018
 * Time: 10:19
 */
header('Content-type: text/html; charset=UTF-8');
//define ("host","localhost");
define ("host","localhost");
/**
 * database username
 */
//define ("user", "root");
define ("user", "fm");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "T6n7C8r1");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "fm");
class Matroluxe
{
    /**
     * @param $name
     * @return array|null
     */
    public function readFile($name)
    {
        $handle=fopen($name,"r");
        while (!feof($handle))
        {
            $str=fgets($handle);
            $str=explode(";",$str);
            //для парсинга Велам, закоментить при обычном файлке!
            //$str[0].=";";
            $arr[]=$str;
            //echo "$str<br>";
        }
        if (!empty($arr))
        {
            return $arr;
        }
        else
        {
            echo "array is empty in ReadFile";
            return null;
        }
    }
    /**
     * @param $pos
     * @return string
     */
    public function formArticle1C($pos)
    {
        $article=$pos[2]."/".$pos[3];
        return $article;
    }
    /**
     * @param $id
     * @return mixed
     */
    public function getOldPrice ($id)
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
            echo "Error in SQL getOldPrice ".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
		//var_dump($goods);
        $price=$goods[0]['goods_price'];
        return $price;
    }
    /**
     *
     */
    public function unsetStock($f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="update goods SET goods_stock=0, goods_discount=0, goods_oldprice=0 where factory_id=$f_id";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }
    /**
     * @param $oldPrice
     * @param $newPrice
     * @return float
     */
    public function getPercent($oldPrice, $newPrice)
    {
        $discount=round((1-($newPrice/$oldPrice))*100);
        return $discount;
    }
    /**
     * @param $article
     * @return array|null
     */
    public function getGood($article,$f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods WHERE goods_article_1c='$article' AND factory_id=$f_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $good = $row;
            }
        }
        else
        {
            echo "Error in SQL getGood ".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
        $tov=$good['goods_id'];
        return $tov;
    }
    /**
     * @param $oldPrice
     * @param $newPrice
     * @param $discont
     * @param $id
     */
    public function writePrice($oldPrice, $newPrice, $discont, $id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="update goods SET goods_stock=1, goods_discount=$discont, goods_oldprice=$oldPrice, goods_price=$newPrice where goods_id=$id";
        mysqli_query($db_connect,$query);
        echo "$query<br>";
        mysqli_close($db_connect);
    }
    /**
     *
     */
    public function setStock($f_id)
    {
        $price1c=$this->readFile("matroluxe.txt");
		echo "<pre>";
		print_r($price1c);
		echo "</pre>";
        if (is_array($price1c))
        {
            foreach ($price1c as $pos1c)
            {
                $article=$this->formArticle1C($pos1c);
                $good_id=$this->getGood($article,$f_id);
                $old_price=$this->getOldPrice($good_id);
                $new_price=$pos1c[6];
                $discont=$this->getPercent($old_price,$new_price);
				echo "<pre>";
				print_r($pos1c);
				echo "</pre>";
				echo "goods_id=$good_id old_price=$old_price, new_price=$new_price, discont=$discont<br>";
                if ($discont>1)
                {
                    $this->writePrice($old_price,$new_price,$discont,$good_id);
                }
				else
				{
					$old_price=round($new_price*1.2);
					$discont=$this->getPercent($old_price,$new_price);
					$this->writePrice($old_price,$new_price,$discont,$good_id);
				}
				//break;
            }
        }
        else
        {
            echo "No price!";
        }
    }
}

class Asat extends Matroluxe
{
	public function setStock($f_id)
    {
        $price1c=$this->readFile("asat.txt");
		$this->unsetStock($f_id);
		//echo "<pre>";
		//print_r($price1c);
		//echo "</pre>";
        if (is_array($price1c))
        {
            foreach ($price1c as $pos1c)
            {
                
				$article=$pos1c[2];
                $good_id=$this->getGood($article,$f_id);
                $old_price=$this->getOldPrice($good_id);
                $new_price=$pos1c[6];
                $discont=$this->getPercent($old_price,$new_price);
				echo "<pre>";
				print_r($pos1c);
				echo "</pre>";
				echo "goods_id=$good_id old_price=$old_price, new_price=$new_price, discont=$discont<br>";
                if ($discont>1)
                {
                    $this->writePrice($old_price,$new_price,$discont,$good_id);
                }
				else
				{
					$old_price=round($new_price*1.15);
					$discont=$this->getPercent($old_price,$new_price);
					$this->writePrice($old_price,$new_price,$discont,$good_id);
				}
				//break;
            }
        }
        else
        {
            echo "No price!";
        }
    }
}

class Corners extends Matroluxe
{
	public function getGood($article,$f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods WHERE goods_article_1c='$article' AND factory_id=$f_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $good[] = $row;
            }
        }
        else
        {
            echo "Error in SQL getGood ".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
        return $good;
    }
	
	public function setStock($f_id)
    {
        $price1c=$this->readFile("corners.txt");
		$this->unsetStock($f_id);
		//echo "<pre>";
		//print_r($price1c);
		//echo "</pre>";
        if (is_array($price1c))
        {
            foreach ($price1c as $pos1c)
            {
                
				$article=$pos1c[2]."/".$pos1c[3];
				echo "$article<br>";
                $goods=$this->getGood($article,$f_id);
				var_dump ($goods);
				//$goods=$this->getGood();
				if (is_array ($goods))
				{
					foreach ($goods as $good)
					{
						$good_id=$good['goods_id'];
						//var_dump($good);
						//echo "$good_id<br>";
						$old_price=$this->getOldPrice($good_id);
						$new_price=$pos1c[6];
						//$good_id=$good['goods_id'];
						$discont=$this->getPercent($old_price,$new_price);
						echo "<pre>";
						print_r($pos1c);
						echo "</pre>";
						echo "goods_id=$good_id old_price=$old_price, new_price=$new_price, discont=$discont<br>";
						if ($discont>1&&$discont<99)
						{
							$this->writePrice($old_price,$new_price,$discont,$good_id);
						}
						//else
						//{
						//	$old_price=round($new_price*1.15);
						//	$discont=$this->getPercent($old_price,$new_price);
						//	$this->writePrice($old_price,$new_price,$discont,$good_id);
						//}
						//break;
					}
				}
				else
				{
					echo "No goods!";
				}
                
            }
        }
        else
        {
            echo "No price!";
        }
    }
}


//$test=new Matroluxe();
//$test->setStock(46);
//$test=new Asat();
//$test->setStock(197);
$test=new Corners();
$test->setStock(202);

