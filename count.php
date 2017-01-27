<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 27.01.17
 * Time: 09:55
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

class countTov
{
    private function countPerFactory($factory_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT COUNT (goods_id) FROM goods WHERE factory_id=$factory_id AND goods_active=1 AND goods_noactual=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            mysqli_close($db_connect);
            return $goods['count(goods_id)'];
        }
        else
        {
            mysqli_close($db_connect);
            return null;
        }
    }

    public function countTov()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT factory_id, factory_name FROM factory WHERE factory_active=1";
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
                    $count_tov=$this->countPerFactory($id);
                    $name=$factory['factory_name'];
                    echo "$name has $count_tov goods<br>";
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

