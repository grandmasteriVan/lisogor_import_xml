<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 07.12.16
 * Time: 09:54
 */
header('Content-type: text/html; charset=UTF-8');
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
		mysqli_query($db_connect,"SET NAMES 'utf8'");
        $query="SELECT * FROM goods WHERE goods_name LIKE '%Камелот%' and factory_id=$this->factory";
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
                mysqli_query($db_connect,$query);
                echo "$query<br>";
            }
        }
		else
		{
			echo "error in SQL!";
		}
        mysqli_close($db_connect);
    }
}

Class CopyContentByList
{
    var $factory;
    public function __construct($factory)
    {
        $this->factory = $factory;
    }

    private function parrentMatr($goods_maintcharter=14)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_parent, goods_width, goods_length, goods_height, goods_maintcharter FROM goods WHERE (goods_maintcharter=$goods_maintcharter OR goods_maintcharter=150) and goods_parent=goods_id AND goods_noactual=0 AND goods_active=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
        }
        mysqli_close($db_connect);
        /*echo "<pre>";
        print_r ($arr);
        echo "</pre>";*/
        return $arr;
    }

    /**
     * @param int $goods_maintcharter
     * @return array
     */
    private function modMatr($goods_maintcharter=14)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_content, goods_parent FROM goods WHERE (goods_maintcharter=$goods_maintcharter OR goods_maintcharter=150) AND goods_parent<>goods_id AND goods_noactual=0 AND goods_active=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
        }
        mysqli_close($db_connect);
        return $arr;
    }

    private function WriteCont($id,$cont)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_content='$cont' WHERE goods_id=$id";
        mysqli_query($db_connect,$query);
        echo "$query<br>";
        mysqli_close($db_connect);
    }

    public function CopyCont()
    {
        $all_goods=$this->parrentMatr();
        $mod_goods=$this->modMatr();
        if (is_array($all_goods))
        {
            foreach ($all_goods as $good)
            {
                $cont=$good['goods_content'];
                foreach ($mod_goods as $mod_good)
                {
                    if ($good['goods_id']==$mod_good['goods_parent'])
                    {
                        $mod_id=$mod_good['goods_id'];
                        $this->WriteCont($mod_id,$cont);
                    }
                }
            }

        }
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
//$test=new ContentCopy(47,10457);
//$test->ContCopy();

$test = new CopyContentByList(124);
$test->CopyCont();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
?>
