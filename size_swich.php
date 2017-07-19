<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 19.07.17
 * Time: 12:13
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

class SizeSwich
{
    private function getSizes()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT size_id, size_length_sl, size_width_sl FROM size";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $sizes[] = $row;
            }
            if (is_array($sizes))
            {
                unset ($sizeList);
                foreach ($sizes as $size)
                {
                    //получаем нужный текст
                    $sizeList[]=$size;
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $sizeList;
    }

    private function setSize($len,$width, $id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE size SET size_length_sl=$len, size_width_sl=$width WHERE size_id=$id";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    public function shift()
    {
        $all_sizes=$this->getSizes();
        foreach ($all_sizes as $size)
        {
            $id=array_shift($size);
            $min=min($size);
            $max=max($size);
            $this->setSize($max,$min,$id);
        }
    }
}

$runtime = new Timer();
set_time_limit(9000);
$runtime->setStartTime();

$test=new SizeSwich();
$test->shift();

$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";