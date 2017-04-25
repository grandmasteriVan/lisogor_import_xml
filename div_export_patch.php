<?php
header('Content-type: text/html; charset=UTF-8');
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 21.07.16
 * Time: 11:11
 */
define ("host","localhost");
//define ("host","10.0.0.2");
/**
 * database username
 */
// define ("user", "root");
define ("user", "divani_cms");
/**
 * database password
 */
// define ("pass", "");
define ("pass", "J1p8Z6q8");
/**
 * database name
 */
define ("db", "divani_cms");
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
            //+++
            //размеры!
            $query="SELECT * FROM size WHERE goods_id=$id";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset($arr1);
                while ($row = mysqli_fetch_assoc($res))
                {
                    $arr1[] = $row;
                }
                foreach ($arr1 as $ar)
				{
					if ($arr['size_length']>2000||$arr['size_width']>2000||$arr['size_height']>2000)
					{
						$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (108,$id,11)";
						mysqli_query($db_connect,$query);
						echo $query."<br>";
					}
					//спальное место
					//односпальные
					if ($arr['size_width_sl']<=1200)
					{
						$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (114,$id,10)";
						mysqli_query($db_connect,$query);
						echo $query."<br>";
					}
					//двуспальные
					if ($arr['size_width_sl']>1200&&$arr['size_width_sl']<1800)
					{
						$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (71,$id,10)";
						mysqli_query($db_connect,$query);
						echo $query."<br>";
					}
					//трехспальные
					if ($arr['size_width_sl']>=1800)
					{
						$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (71,$id,10)";
						mysqli_query($db_connect,$query);
						echo $query."<br>";
					}
				}
				
            }
            //цена
            $price=$good['goods_price'];
            //эконом
            if ($price<=3500)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (47,$id,4)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            //недорого
            if ($price>3500&&$price<=9000)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (48,$id,4)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            //элит
            if ($price>9000)
            {
                $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (49,$id,4)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
            //модульные диваны
            //если в имени или в тексте есть модульный
            $query="SELECT * FROM goodshaslang WHERE goods_id=$id";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset($arr1);
                while ($row = mysqli_fetch_assoc($res))
                {
                    $arr1[] = $row;
                }
				//print_r($arr);
				if (!empty($arr1))
				{
					foreach ($arr1 as $ar)
					{
						$name=$ar['goodshaslang_name'];
						$name=" ".$name;
						$content=$ar['goodshaslang_content'];
						$content=" ".$content;
						//echo $name;
						if (mb_stripos("модуль",$name)||(mb_stripos("модуль",$content)))
						{
							$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (57,$id,6)";
							mysqli_query($db_connect,$query);
							echo $query."<br>";
						}
					}
				}
                
				
            }
            //+++
			$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (80,$id,13)";
            mysqli_query($db_connect,$query);
            echo $query."<br>";
            //оббивка - ставим всем экокожу по умолчанию
            $query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (81,$id,13)";
            mysqli_query($db_connect,$query);
            echo $query."<br>";
            //оббивка - кожа (ставим по умолчанию всем диванам Ливс)
            $factory=$arr[3];
            $factory=strip_tags($factory);
            $factory=str_replace("Фабрика: "," ",$factory);
			if (strcmp ($factory," Фабрика Ливс")==0)
            {
                //echo "Yay!<br>";
				$query="INSERT INTO goodshasfeature (goodshasfeature_valueid, goods_id, feature_id) VALUES (79,$id,13)";
                mysqli_query($db_connect,$query);
                echo $query."<br>";
            }
			//break;
			
			//тип дивана
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
			//диван-кровать - это кровать или (раскладывается и не кресло и не пуф)
            if ((mb_strpos ($type,"Кровать"))||(!mb_strpos ($trans,"Не раскладывается")&&!mb_strpos ($type,"Кресло")&&!mb_strpos ($type,"Пуфы")))
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
    }
    mysqli_close($db_connect);
}
function del_filters()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    //$query="DELETE FROM goodshasfeature WHERE feature_id=132 AND goodshasfeature_valueid=79";
	//mysqli_query($db_connect,$query);
	//удаляем тип дивана
	$query="DELETE FROM goodshasfeature WHERE feature_id=15";
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
