<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 06.02.17
 * Time: 17:13
 */
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
define ("host","localhost");
//define ("host","10.0.0.2");
/**
 * database username
 */
define ("user", "root");
//define ("user", "uh333660_mebli");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "Z7A8JqUh");
/**
 * database name
 */
define ("db", "mebli");
//define ("db", "uh333660_mebli");
/**
 * Class comfMebPlus
 * проставляет цену за размеры шкафов 2500 (+10% к такому же шкафу с размером 2350)
 */
class comfMebPlus
{
    /**
     * выбирает все шкафы заданного размер по высоте
     * @param $size int - размер шкафа
     * @return array|null - массив, содержащий все шкафы данного размера
     */
    private function selectSize($size)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT * FROM goods WHERE goods_height=$size AND factory_id=122";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            mysqli_close($db_connect);
            return $goods;
        }
        else
        {
            mysqli_close($db_connect);
            return null;
        }
    }
    /**
     *для каждого шкафа высотой 2350 находим соответствующий ему (по имени) шкаф высотой 2500
     * и для такого шкафа ставим цену на 10% выше.
     */
    public function makePlus()
    {
        $goods_2350=$this->selectSize(2350);
        $goods_2500=$this->selectSize(2500);
        if (is_array($goods_2350))
        {
            foreach ($goods_2350 as $good_2350)
            {
                $name_2350=$good_2350['goods_name'];
				//echo $name_2350." len=".strlen($name_2350)."<br>";
				if (strlen($name_2350)<=42)
				{
					$name_2350_sub=substr($name_2350,0,-4);
					//echo $name_2350_sub."<br>";
				}
				else
				{
					$name_2350_sub=substr($name_2350,0,-11);
					//if (
					//echo $name_2350_sub."<br>";
				}
                if (is_array($goods_2500))
                {
                    foreach ($goods_2500 as $good_2500)
                    {
                        $name_2500=$good_2500['goods_name'];
						if (strlen($name_2500)<=42)
						{
							$name_2500_sub=substr($name_2500,0,-4);
						}
						else
						{
							$name_2500_sub=substr($name_2500,0,-11);
						}
						
                        if ($name_2350_sub==$name_2500_sub)
                        {
                            //меняем цены!
                            //отправляем цену товара за 2350 размер и ид товара 2500 размера
                            $this->changePrice($good_2350['goods_price'],$good_2500['goods_id']);
                        }
                    }
                }
            }
        }
    }
    /**
     * записывает изменение цен в базу данных
     * @param $price  int - цена за шкаф, высотой в 2350
     * @param $good_id int - ид шкафа высотой 2500
     */
    private function changePrice($price, $good_id)
    {
        $new_price=round($price*1,1);
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_price=$new_price WHERE goods_id=$good_id";
        //mysqli_query($db_connect,$query);
        echo "$query<br>";
        mysqli_close($db_connect);
    }
}

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
         return $this->start_time-$this->end_time;
     }
}

$runtime = new Timer();
$runtime->setStartTime();
$test=new comfMebPlus();
$test->makePlus();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
