<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 18.07.17
 * Time: 09:27
 */
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
//define("host","localhost");
define ("host","localhost");
/**
 * database username
 */
//define ("user", "root");
define ("user", "u_divani_n");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "EjcwKUYK");
/**
 * database name
 */
//define ("db", "ddn_new");
define ("db", "divani_new");

/**
 * Class Timer
 * засекаем время выыполнения скрипта
 */
class Timer
{
    /**
     * @var время начала выпонения
     */
    private $start_time;
    /**
     * @var время конца выполнения
     */
    private $end_time;
    /**
     * встанавливаем время начала выполнения скрипта
     */
    public function setStartTime()
    {
        $this->start_time = microtime(true);
    }
    /**
     * устанавливаем время конца выполнения скрипта
     */
    public function setEndTime()
    {
        $this->end_time = microtime(true);
    }
    /**
     * @return mixed время выполения
     * возвращаем время выполнения скрипта в секундах
     */
    public function getRunTime()
    {
        return $this->end_time-$this->start_time;
    }
}

/**
 * Class SeoPage
 * заполняем нужное
 */
class SeoPage
{
    /**
     * выбираем все товары на сайте
     * @return array - возвращает массив ай-ди товаров и их артиклов
     */
    private function getGoodsId()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_article FROM goods";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            if (is_array($goods))
            {
                unset ($ids);
                foreach ($goods as $good)
                {
                    //получаем нужный текст
                    $ids[]=$good;
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $ids;
    }
    /**
     * выбираем ай-ди основного разимера
     * @param $id integer - ай-ди товара
     * @return mixed - ай-ди основного размера
     */
    private function getSizeId($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_mainsize FROM goods WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $sizes[] = $row;
            }
            if (is_array($sizes))
            {
                unset ($goodsSizeId);
                foreach ($sizes as $size)
                {
                    $goodsSizeId=$size['goods_mainsize'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $goodsSizeId;
    }
    /**
     * выбираем длинну товара
     * @param $id integer - ай-ди товара
     * @return mixed - его длина
     */
    private function getMainSizeLen($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $sizeId=$this->getSizeId($id);
        $query="SELECT size_length FROM size WHERE size_id=$sizeId";
		//echo "$query<br>";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $sizes[] = $row;
            }
            if (is_array($sizes))
            {
                unset ($goodsLen);
                foreach ($sizes as $size)
                {
                    $goodsLen=$size['size_length'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $goodsLen;
    }
    /**
     * выбираем ширину спального места
     * @param $id integer - ай-ди товара
     * @return mixed - ширина спального места
     */
    private function getMainSizeSl($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $sizeId=$this->getSizeId($id);
        $query="SELECT size_width_sl FROM size WHERE size_id=$sizeId";
		//echo "$query<br>";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $sizes[] = $row;
            }
            if (is_array($sizes))
            {
                unset ($goodsLen);
                foreach ($sizes as $size)
                {
                    $goodsLen=$size['size_width_sl'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $goodsLen;
    }
    /**
     * проверяем, является ли товар угловым
     * @param $id integer - ай-ди товара
     * @return bool true - диван угловой, false - не угловой
     */
    private function isCorner($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT * FROM goodshasfeature WHERE feature_id=6 AND goodshasfeature_valueid=56 AND goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $corners[] = $row;
            }
			//var_dump ($corners);
            if (is_array($corners))
            {
                $isCorner=true;
            }
            else
            {
                $isCorner=false;
            }
        }
        mysqli_close($db_connect);
        return $isCorner;
    }

    /**
     * удаляем ненужные фильтры по размеру спального места для определенного товара
     * @param $id integer - ай-ди товра
     */
    private function delFilterSleep($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="DELETE FROM goodshasfeature WHERE feature_id=10 AND goods_id=$id";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}

    /**
     * удаляем ненужные фильтры по цене для определенного товара
     * @param $id integer - фй-ди товара
     */
    private function delFilterPrice($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="DELETE FROM goodshasfeature WHERE feature_id=4 AND goods_id=$id";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}

    /**
     * устанавливаем вильтр "Двуспальный" для определенного товара
     * @param $id integer - ай-ди товара
     */
    private function setTwoSleep($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="INSERT INTO goodshasfeature (feature_id, goodshasfeature_valueid, goods_id) VALUES (10,71,$id)";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}

    /**
     * устанавливаем вильтр "Трехспальный" для определенного товара
     * @param $id integer - ай-ди товара
     */
    private function setThreeSleep($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="INSERT INTO goodshasfeature (feature_id, goodshasfeature_valueid, goods_id) VALUES (10,72,$id)";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}
	
    private function setOneSleep($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="INSERT INTO goodshasfeature (feature_id, goodshasfeature_valueid, goods_id) VALUES (10,114,$id)";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}

    /**
     * устанавливаем фильтр "Дешевый" для определенного товара
     * @param $id integer - ай-ди товара
     */
    private function setPriceCheep($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="INSERT INTO goodshasfeature (feature_id, goodshasfeature_valueid, goods_id) VALUES (4,47,$id)";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
	}

    /**
     * узнаем цену конкретного товара
     * @param $id integer - ай-ди товара
     * @return mixed - цена конкретного товара
     */
    private function getPrice($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT cachegoods_minprice FROM cachegoods WHERE goods_id=$id";
		if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $prices[] = $row;
            }
            if (is_array($prices))
            {
                unset ($goodsPrice);
                foreach ($prices as $price)
                {
                    $goodsPrice=$price['cachegoods_minprice'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
		mysqli_close($db_connect);
		return $goodsPrice;
	}
	
    /**
     *выбираем список маленьких угловых товаров
     */
    public function setSmallCorner()
    {
        $all_div=$this->getGoodsId();
		//echo "<pre>";
		//print_r($all_div);
		//echo "</pre>";
        $smallCornerStr="";
        foreach ($all_div as $div)
        {
            $id=$div['goods_id'];
            $article=$div['goods_article'];
            if ($this->isCorner($id))
            {
                $len=$this->getMainSizeLen($id);
				//echo "$article - $len<br>";
                if ($len<2200&&$len>0)
                {
                    $smallCornerStr.=", $article";
                }
            }
        }
        $smallCornerStr=substr($smallCornerStr,2);
		echo "str=".$smallCornerStr."<br>";
    }

    /**
     *устанавливаем размер дивана исходя из его реальных размеров
     */
    public function setSleepPlace()
	{
		$all_div=$this->getGoodsId();
		foreach ($all_div as $div)
		{
			$id=$div['goods_id'];
			$len_sl=$this->getMainSizeSl($id);
			//echo "$id - ";
			$this->delFilterSleep($id);
			if ($len_sl>1400&&$len_sl<=1600)
			{
				//двуспальные
				$this->setTwoSleep($id);
				echo "$id - $len_sl set Two<br>";
				
			}
			if ($len_sl>1600)
			{
				//трехместніе
				$this->setThreeSleep($id);
				echo "$id - $len_sl set Three<br>";
			}
			if ($len_sl<=1400&&$len_sl>0)
			{
				//одноместніе
				$this->setOneSleep($id);
				echo "$id - $len_sl set One<br>";
			}
		}
	}

    /**
     *устанавливаем ценовую категорию
     */
    public function setPriceLevel()
	{
		$all_div=$this->getGoodsId();
		foreach ($all_div as $div)
		{
			$id=$div['goods_id'];
			if ($this->isCorner($id))
			{
				//
				$price=$this->getPrice($id);
				if ($price>0&&$price<9100)
				{
					//дешевіе
					$this->delFilterPrice($id);
					$this->setPriceCheep($id);
					echo "$id - ugol - $price<br>";
				}
			}
			else
			{
				$price=$this->getPrice($id);
				if ($price>0&&$price<6500)
				{
					//дешевіе
					$this->delFilterPrice($id);
					$this->setPriceCheep($id);
					echo "$id - not_ugol - $price<br>";
				}
			}
		}
	}
}
$runtime = new Timer();
set_time_limit(9000);
$runtime->setStartTime();
$test=new SeoPage();
$test->setSmallCorner();
$test->setSleepPlace();
$test->setPriceLevel();

$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
