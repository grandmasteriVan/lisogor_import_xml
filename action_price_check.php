<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 09.01.17
 * Time: 10:56
 */

//define ("host","localhost");
define ("host","10.0.0.2");
/**
 * database username
 */
//define ("user", "root");
define ("user", "uh333660_mebli");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "Z7A8JqUh");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "uh333660_mebli");

/**
 * Class Timer
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
 * Class Check
 * выбирает все товары, у которых старая цена меньше, чем новая. ставит старую цену равную 0
 */
class Check
{
    /**
     * возвращает список товаров, у которых старая цена больше новой, или пустую переменную если таких товаров нет
     * @return array|null - либо список товаров у которых старая цена больше новой, либо пустая переменая если таких нет
     */
    private function getWrongActionList()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT * FROM goods WHERE goods_price<goods_oldprice";
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
            return null;
        }
    }

    /**
     *выставляет товарам, у которых старая цена выше новой старую цену = 0
     */
    public function checkActions()
    {
        $goods=$this->getWrongActionList();
        $db_connect=mysqli_connect(host,user,pass,db);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$goods['goods_id'];
                $query="UPDATE goods SET goods_oldprice=0 WHERE goods_id=$id";
                //mysqli_query($db_connect,$query);
                echo "$query<br>";
            }
        }

        mysqli_close($db_connect);
    }
}

$runtime = new Timer();
$runtime->setStartTime();
$test=new Check();
$test->checkActions();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";