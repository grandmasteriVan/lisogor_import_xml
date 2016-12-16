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

/**
 * Class CopyVid
 * класс пробегается по всем товарам, ищет в контенте товары где есть ссылка на ютуб видео и
 * помещает эту ссылку в таблицу файлов
 */
class CopyVid
{
    /**
     * @return array - массив, содержащий все актуальные товары
     */
    private function AllTovs()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0";
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

    /**
     * пробегает по всем товарам, ищет вовары, у которых в контенте есть iframe вставка
     * дальше с помошью регулярки ищем id видео
     * формируем полный путь к этому видео и вставляем получившуюся ссылку в таблицу файлов
     */
    public function FindVideo()
    {
        $goods=$this->AllTovs();
        $db_connect=mysqli_connect(host,user,pass,db);
		//print_r($goods);
		$i=0;
        foreach ($goods as $good)
        {
            $i++;
			$content=$good['goods_content'];
			//echo $content;
			//break;
            $id=$good['goods_id'];
			//если есть видео
            if (mb_strpos($content,'iframe')!=false)
            {
                //echo "Whghgh<pre>";
				preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $content, $videoId);
				//echo count ($videoId)."<br>";
                if (count ($videoId) > 0)
                {
                    //у нас есть id video, ссылка правильная
                    // $videoId[1] - ID видео
                    //все ли пошло так?
					if (mb_strpos($videoId[1],PHP_EOL)==false)
					{
						echo "$id has video $videoId[1]<br>";
						$url="https://www.youtube.com/embed/".$videoId[1];
						$query="INSERT INTO goodsfile (goodsfile_name, goodsfile_active, goodsfile_filename, goodsfile_ext, goods_id, goodsfile_actual) ".
							"VALUES ('$url',1,'video','',$id,1)";
						mysqli_query($db_connect,$query);
						echo "$query<br>";
					}
					else
					{
						//два видео на странице
					    echo "$id<br>";
					}
                    
                }
            }
        }
		echo $i;
        mysqli_close($db_connect);
    }
}
$runtime = new Timer();
$runtime->setStartTime();
$test=new CopyVid();
$test->FindVideo();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";