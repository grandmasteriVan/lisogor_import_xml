<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 15.12.16
 * Time: 12:32
 */
header('Content-type: text/html; charset=UTF-8');
//define ("host","localhost");
define ("host","localhost");
/**
 * database username
 */
//define ("user", "root");
define ("user", "fm");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "T6n7C8r1");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "fm");
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
class insertVid extends CopyVid
{
    private function getGoodsWithVid()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0 AND goods_content LIKE '%iframe%' AND (goodskind_id=40 OR goodskind_id=45 OR goodskind_id=88)";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
        }
        mysqli_close($db_connect);
        if (!is_array($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }
    private function getGoodsWithNoVid()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0 AND goods_content NOT LIKE '%iframe%' AND (goodskind_id=40 OR goodskind_id=45 OR goodskind_id=88)";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
        }
        mysqli_close($db_connect);
        if (!is_array($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }
    private function insertOneVideo($id, $content)
    {
        $content="";
    }
}
class insertVidBeds
{
    private function getTovNoVid()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0 AND goods_content NOT LIKE '%iframe%' AND (goodskind_id=39 OR goodskind_id=50 OR goodskind_id=121)";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (is_array($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }
    private function insertSingleVid($id, $cont)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $cont="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/EoGsmck1bZI\" style=\"text-align: center;\" width=\"380\"></iframe></p>".$cont;
        $query="UPDATE goods SET goods_content='$cont' WHERE goods_id=$id";
        mysqli_query($db_connect,$query);
        //echo "$query <br>";
        mysqli_close($db_connect);
    }
    private function getTovFirst()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0 AND (goodskind_id=39 OR goodskind_id=50 OR goodskind_id=121) AND factory_id<>32";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!empty($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }
    private function getTovLast()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0 AND (goodskind_id=39 OR goodskind_id=50 OR goodskind_id=121) AND factory_id=32";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!empty($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }
    private function insertVidFirst()
    {
    }
    private function insertVidLast($pos)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$id=$pos['goods_id'];
        $cont=$pos['goods_content'];
        $cont=substr($cont,0,-4);
        $cont.=" <iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/EoGsmck1bZI\" style=\"text-align: center;\" width=\"380\"></iframe></p>";
		$query="UPDATE goods SET goods_content='$cont' WHERE goods_id=$id";
		mysqli_query($db_connect,$query);
		//echo "$query <br>";
		mysqli_close($db_connect);
    }
	public function goLast()
	{
		$goods=$this->getTovLast();
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				//$this->insertVidLast($good);
				$this->insSP($good);
				break;
			}
		}
		else
		{
			echo "No last array!!<br>";
		}
	}
	
	private function insSP($pos)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$id=$pos['goods_id'];
        $cont=$pos['goods_content'];
		$cont1=str_ireplace("</iframe><iframe","</iframe>&#160;<iframe",$cont);
		$query="UPDATE goods SET goods_content='$cont1' WHERE goods_id=$id";
		mysqli_query($db_connect,$query);
		//echo mysqli_error($db_connect)."<br>";
		echo "$query <br>";
		mysqli_close($db_connect);
	}
	
	public function getNoVid()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods WHERE goods_active=1 AND goods_noactual=0 AND (goodskind_id=39 OR goodskind_id=50 OR goodskind_id=121) AND goods_content NOT LIKE '%EoGsmck1bZI%'";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
		//var_dump
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				echo "$id<br>";
			}
		}
		else
		{
			echo "No array!";
		}
        
	}
	
	public function goSingle()
    {
        $goods=$this->getTovNoVid();
		//var_dump($goods);
		
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $cont=$good['goods_content'];
                $this->insertSingleVid($id, $cont);
            }
        }
        else
        {
            echo "No last array!!<br>";
        }
    }
}

class insertVidMatr
{
	private $f_id;
	
	function __construct($f_id)
	{
		$this->f_id=$f_id;
	}
	
	private function delAllVid($cont)
	{
		$cont_new=preg_replace("'<iframe[^>]*?>.*?</iframe>'si","",$cont);
		return $cont_new;
	}
	
	private function getTovList()
	{
		//echo host.user.pass.db."<br>";
		$db_connect=mysqli_connect(host,user,pass,db);
		$f_id=$this->f_id;
        $query="SELECT goods_id, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0 AND factory_id=$f_id AND goods_maintcharter=14";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
        }
		else
		{
			echo "Error in SQL ".mysqli_error($db_connect)."<br>";
		}
        mysqli_close($db_connect);
        if (is_array($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
	}
	
	private function hasUpperVid($cont)
	{
		if (strripos ($cont,"JF1wYXFtPck")==false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	private function hasDownVid($cont)
	{
		if (strripos ($cont,"5HEoT874niY")==false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	private function insNewVid($cont)
	{
		//добавляем видео в начало
		$cont="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/JF1wYXFtPck\" style=\"text-align: center;\" width=\"380\"></iframe></p>".$cont;
		//добавляем видео в конец
		$cont=$cont."<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/KYTqssupjgg\" style=\"text-align: center;\" width=\"380\"></iframe>&nbsp;<iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/44DDXY4B7z4\" style=\"text-align: center;\" width=\"380\"></iframe></p>";
		return $cont;
	}
	
	private function insUpperVid($cont)
	{
		$cont="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/JF1wYXFtPck\" style=\"text-align: center;\" width=\"380\"></iframe></p>".$cont;
		return $cont;
	}
	
	private function insDownVid($cont)
	{
		$cont=$cont."<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/5HEoT874niY\" style=\"text-align: center;\" width=\"380\"></iframe></p>";
		return $cont;
	}
	
	private function updCont($id, $cont)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goods SET goods_content='$cont' WHERE goods_id=$id";
		mysqli_query($db_connect,$query);
		//echo mysqli_error($db_connect)."<br>";
		//echo "$query <br>";
		mysqli_close($db_connect);
	}
	
	public function insVidsComFor()
	{
		$goods=$this->getTovList();
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$cont=$good['goods_content'];
				//echo "$cont<br>";
				if (!$this->hasDownVid($cont))
				{
					$cont=$this->insDownVid($cont);
				}
				//echo "$cont<br>";
				if (!$this->hasUpperVid($cont))
				{
					$cont=$this->insUpperVid($cont);
				}
				echo "$id<br>";
				$this->updCont($id, $cont);
				//break;
				
			}
		}
		else
		{
			echo "No array!";
		}
	}
	
	public function insVidsMatrolux()
	{
		//echo db."<br>";
		$goods=$this->getTovList();
		if (is_array($goods))
		{
			foreach($goods as $good)
			{
				$id=$good['goods_id'];
				$cont=$good['goods_content'];
				$cont=$this->delAllVid($cont);
				$cont=$this->insNewVid($cont);
				echo "$id<br>";
				$this->updCont($id, $cont);
				//break;
			}
		}
		else
		{
			echo "No array!";
		}
	}
}
$runtime = new Timer();
$runtime->setStartTime();

//$test=new insertVidMatr(35);
//$test->insVidsComFor();

$test=new insertVidMatr(46);
$test->insVidsMatrolux();


//$test=new insertVidBeds();
//$test->getNoVid();
//$test->goSingle();
//$test->goLast();
//$test=new CopyVid();
//$test->FindVideo();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
