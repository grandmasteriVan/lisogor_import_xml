<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 15.12.16
 * Time: 12:32
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

class CopyVid
{
    private function AllTovs()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT * FROM goods";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
        }
        mysqli_close($db_connect);
        if (!empty($goods))
        {
            return $goods;
        }
        return 0;
    }

    public function FindVideo()
    {
        $goods=$this->AllTovs();
        foreach ($goods as $good)
        {
            $content=$good['goods_content'];
            $id=$good['goods_id'];
            if (stripos($content,'youtube.com')!==false)
            {
                preg_match('#v=([^\&]+)#is', $content, $videoId);
                if (count ($videoId) > 0)
                {
                    //у нас есть id video, ссылка правильная
                    // $videoId[1] - ID видео
                    echo "$id has video $videoId[1]<br>";
                }
            }
        }
    }
}

$test=new CopyVid();
$test->FindVideo();