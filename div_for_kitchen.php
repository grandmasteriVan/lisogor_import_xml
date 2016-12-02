<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 28.11.16
 * Time: 10:45
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
 * @param $kind integer айди вида товара
 * добавляет дополнительный каталог (диваны) кухонным уголкам со спальным местом
 */
function move($kind)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE goodskind_id=$kind";
    if ($res=mysqli_query($db_connect,$query))
    {
        unset($tovars);
        while ($row = mysqli_fetch_assoc($res))
        {
            //список всех уголков
            $tovars[] = $row;
        }
        foreach ($tovars as $tovar)
        {
            $id=$tovar['goods_id'];
            //смотрим есть ли у уголка спальное место
            $query="SELECT * FROM goodshasfeature WHERE feature_id=103 AND goods_id=$id";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset($spaln);
                while ($row = mysqli_fetch_assoc($res))
                {
                    $spaln[] = $row;
                }
                if (isset($spaln))
                {
					/*echo "<pre>";
					print_r($spaln);
					echo "</pre>";*/
					if ($spaln[0]['goodshasfeature_valueint']==1)
                    {
                        //делаем соотв запись в БД
                        $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) ".
                            "VALUES ($id, 2)";
                        //mysqli_query($db_connect,$query);
                        echo $query."<br>";
                    }
                }
            }
        }
    }
    mysqli_close($db_connect);
}

/**
 * пробегается по всем диванам и смотрит их размеры. ставит самый большой размер в длинну
 */
function swap_whith()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE goodskind_id=23";
    if ($res=mysqli_query($db_connect,$query))
    {
        unset($tovars);
        while ($row = mysqli_fetch_assoc($res))
        {
            //список всех диванов
            $tovars[] = $row;
        }
        foreach ($tovars as $tovar)
        {
            $len=$tovar['goods_length'];
            $width=$tovar['goods_width'];
            if ($width<$len)
            {
                $tmp=$width;
                $width=$len;
                $len=$tmp;
                $query="UPDATE goods SET goods_length=$len, goods_width=$width";
                //mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
        }
    }
    mysqli_close($db_connect);
}
/**
 * пробегает по всем диванам, и ставит фильтр для кухни тем, чья длинна <= 1000 мм
 */function move_width()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE goodskind_id=23 AND goods_length<1001";
    if ($res=mysqli_query($db_connect,$query))
    {
        unset($tovars);
        while ($row = mysqli_fetch_assoc($res))
        {
            //список всех диванов, которые имеют ширину 1000мм и меньше
            $tovars[] = $row;
        }
        foreach ($tovars as $tovar)
        {
            $id=$tovar['goods_id'];
			if ($tovar['goods_length']!=0)
			{
				$query="INSERT INTO goodshastcharter (goods_id, tcharter_id) ".
					"VALUES ($id, 2)";
				//mysqli_query($db_connect,$query);
				echo $query."<br>";
			}
            
        }
    }
    mysqli_close($db_connect);
}
$runtime = new Timer();
$runtime->setStartTime();
//set_time_limit(2000);
//echo "test";
//set_filters();
move (69);
move (53);
echo "<br><b>SIZE</b><br>";
swap_whith();
move_width();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
/**
 * Class Timer
 * замеряем время выполнения скрипта
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
        return $this->start_time-$this->end_time;
    }
}
?>
