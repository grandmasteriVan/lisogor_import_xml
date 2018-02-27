<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 27.01.17
 * Time: 09:55
 */
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
//define ("host","localhost");
/**
 *
 */
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

class countTov
{
    private function countPerFactoryAll($factory_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT count(goods_id) FROM goods WHERE factory_id=$factory_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            mysqli_close($db_connect);
			//print_r ($goods);
			//echo "Y!<br>";
            return $goods['count(goods_id)'];
        }
        else
        {
            mysqli_close($db_connect);
			echo "Error<br>";
            return null;
        }
    }

    private function countPerFactoryActive($factory_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT count(goods_id) FROM goods WHERE factory_id=$factory_id AND goods_active=1 AND goods_noactual=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            mysqli_close($db_connect);
            //print_r ($goods);
            //echo "Y!<br>";
            return $goods['count(goods_id)'];
        }
        else
        {
            mysqli_close($db_connect);
            echo "Error<br>";
            return null;
        }
    }

    public function countTov()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT factory_id, factory_name FROM factory WHERE factory_active=1 factory_noactual=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($factoryes);
            while ($row = mysqli_fetch_assoc($res))
            {
                $factoryes[]=$row;
            }
            if (is_array($factoryes))
            {
                foreach ($factoryes as $factory)
                {
                    $id=$factory['factory_id'];
                    $count_tov_all=$this->countPerFactoryAll($id);
                    $count_tov_active=$this->countPerFactoryActive($id);
                    $name=$factory['factory_name'];
                    if (!is_null($count_tov))
						echo "$name Всего товаров: $count_tov_all , Из них активых: $count_tov_active<br>";
                }
            }
        }
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
        return $this->end_time-$this->start_time;
    }
}
$runtime = new Timer();
$runtime->setStartTime();
//echo "test";
$test=new countTov();
$test->countTov();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
