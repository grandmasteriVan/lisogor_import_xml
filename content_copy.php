<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 07.12.16
 * Time: 09:54
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

class ContentCopy
{

    var $factory;
    var $base;

    /**
     * ContentCopy constructor.
     * @param $factory
     */
    public function __construct($factory,$base)
    {
        $this->factory = $factory;
        $this->base = $base;
    }

    public function ContCopy()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT * FROM goods WHERE factory_id=$this->factory";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            $query="SELECT * FROM goods WHERE goods_id=$this->base";
            if ($res=mysqli_query($db_connect,$query))
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $sample_good = $row;
                }
                $sample_cont=$sample_good['goods_content'];
            }
            foreach ($goods  as $good)
            {
                $id=$good['goods_id'];
                $query="UPDATE goods SET goods_content='$sample_cont' WHERE goods_id=$id";
                //mysqli_query($db_connect,$query);
                echo "$query<br>";
            }
        }
        mysqli_close($db_connect);
    }
}
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

$runtime = new Timer();
$runtime->setStartTime();
$test=new ContentCopy(141,25328);
$test->ContCopy();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
?>