<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 25.04.17
 * Time: 10:24
 */

header('Content-type: text/html; charset=UTF-8');
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
define ("db", "divani_new");
//define ("db", "uh333660_mebli");
/**
 * парсит фильтры со старого сайта и записывает их в соответствующие места на новом
 */
function export_filters()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    mysqli_query($db_connect,"SET NAMES 'utf8'");
    $query="SELECT goods_id, goods_price, goods_exfeature FROM goods";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            echo "ID:".$id."<br>";
            $feat=$good['goods_exfeature'];
            //$feat="fff ggg";
            $arr=explode("\n",$feat);
            //echo gettype ($arr);
            //echo $feat."<br>";
            echo "<pre>";
            print_r($arr);
            echo  "</pre>";


            //разбор параметров
            //тип дивана
            $type=$arr[1];
            $type=strip_tags($type);
            $type=str_replace("Тип дивана: "," ",$type);

            //трансформация
            $trans=$arr[2];
            $trans=strip_tags($trans);
            $trans=str_replace("Разложение: "," ",$trans);

            if (mb_strpos ($type,"Кресло"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (99,$id,15)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            if ((mb_strpos ($type,"Кровать"))||(!mb_strpos ($trans,"Не раскладывается")))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (100,$id,15)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }

            if (mb_strpos ($type,"Мини диван"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (101,$id,15)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            if (mb_strpos ($type,"Пуфы"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (102,$id,15)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            if (mb_strpos ($type,"Софа"))
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (103,$id,15)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
    }
    mysqli_close($db_connect);
}
function del_filters()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="DELETE FROM goodshasfeature WHERE feature_id==15";
    mysqli_query($db_connect,$query);
    mysqli_close($db_connect);
}
//////////////////////////////////////////
$runtime = new Timer();
$runtime->setStartTime();
echo "Deleteing old features... ";
set_time_limit(2000);
del_filters();
echo "Done!<br>";
export_filters();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
//////////////////////////////////////////
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