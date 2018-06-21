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

define ("host_ddn","es835db.mirohost.net");
define ("user_ddn", "u_fayni");
define ("pass_ddn", "ZID1c0eud3Dc");
define ("db_ddn", "ddnPZS");
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
	
	private function delText($cont)
	{
		$cont_new=preg_replace("'<a[^>]*?>.*?</a>'si","",$cont);
		return $cont_new;
	}
	
	private function getTovList()
	{
		//echo host.user.pass.db."<br>";
		$db_connect=mysqli_connect(host,user,pass,db);
		$f_id=$this->f_id;
        $query="SELECT goods_id, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0 AND factory_id=$f_id";
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
		$cont="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/e99O0gDPkg8\" style=\"text-align: center;\" width=\"380\"></iframe></p>".$cont;
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
	
	public function insVidsAdormo()
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
				$cont=$this->insUpperVid($cont);
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
	
	public function insVidKH()
	{
		$goods=$this->getTovList();
		if (is_array($goods))
		{
			foreach($goods as $good)
			{
				$id=$good['goods_id'];
				$cont=$good['goods_content'];
				$cont=$this->insUpperVid($cont);
				
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
	
	public function insVidsSL()
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
				$cont=$this->delText($cont);
				
				$cont=$this->insUpperVid($cont);
				
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
class FixVidSize
{
    private function getGoods()
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT  goodshaslang_id,  goodshaslang_content FROM goodshaslang WHERE goodshaslang_content LIKE '%iframe%'";
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
        if (!empty($goods))
        {
            return $goods;
        }
        return 0;
    }
    private function getVidId($cont)
    {
        //echo "Whghgh<pre>";
        preg_match_all('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $cont, $videoId);
        //echo count ($videoId)."<br>";
        return $videoId;
    }
	private function delAllVid($cont)
	{
		$cont_new=preg_replace("'<iframe[^>]*?>.*?</iframe>'si","",$cont);
		return $cont_new;
	}
	private function writeLog($text)
	{
		file_put_contents("vid_log.txt",$text.PHP_EOL,FILE_APPEND);
	}
	private function writeCont($id, $cont)
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
		$query="UPDATE goodshaslang SET goodshaslang_content='$cont' WHERE goodshaslang_id=$id";
		mysqli_query($db_connect,$query);
        //echo "$query<br>";
		$this->writeLog($query);
		mysqli_close($db_connect);
	}
	
	private function getVidFiles()
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT  goodsfile_id,  goodsfile_link FROM goodsfile WHERE goodsfile_link!=''";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goodsfiles[] = $row;
            }
        }
        else
        {
            echo "Error in SQL ".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
        if (!empty($goodsfiles))
        {
            return $goodsfiles;
        }
        return 0;
	}
	
	private function writeGoodFileOrder($id)
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
		$query="UPDATE goodshaslang SET goodsfile_order=1 WHERE goodsfile_id=$id";
		mysqli_query($db_connect,$query);
        //echo "$query<br>";
		$this->writeLog($query);
		mysqli_close($db_connect);
	}
	
	public function VidPos()
	{
		$files=$this->getVidFiles();
		if (is_array($files))
		{
			foreach($files as $file)
			{
				$id=$file['goodsfile_id'];
				$this->writeGoodFileOrder($id);
			}
		}
		else
		{
			echo "No files!<br>";
		}
	}
    public function FixVideo()
    {
        $goods=$this->getGoods();
        if (is_array($goods))
        {
			echo count($goods)."<br>";
            foreach ($goods as $good)
            {
                //unset ($cont);
				$id=$good['goodshaslang_id'];
				//$lang_id=$good[''];
                $cont=$good['goodshaslang_content'];
				$cont_new=str_ireplace("?rel=0","",$cont);
				$cont_new=str_ireplace("></iframe></p>","",$cont_new);
				$cont_new=str_ireplace(" width=\"380\"","",$cont_new);
				$cont_new=str_ireplace(" width=\"560\"","",$cont_new);
				$cont_new=str_ireplace("allowfullscreen=\"\" frameborder=\"0\"","",$cont_new);
				$cont_new=str_ireplace(" frameborder=\"0\" allowfullscreen></iframe>","",$cont_new);
				$cont_new=str_ireplace("</iframe>&nbsp;<iframe",PHP_EOL,$cont_new);
				$cont_new=str_ireplace("\"<p>",PHP_EOL,$cont_new);
				
				
				
				$cont_new=str_ireplace("style=\"text-align: center;\"","",$cont_new);
				//unset ($vidID);
                $vidID=$this->getVidId($cont_new);
				$count=count($vidID[1]);
				
                echo "id=$id vid=$count<br>";
				echo "<pre>";
				print_r($vidID);
				echo "</pre>";
				if ($count==1)
				{
					$vid_id1=$vidID[1][0];
					$cont=$this->delAllVid($cont);
					$cont="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"315\" src=\"https://www.youtube.com/embed/$vid_id1\" style=\"text-align: center;\" width=\"560\"></iframe></p>".$cont;
					$this->writeCont($id,$cont);
					
				}
				if ($count==2)
				{
					$vid_id1=$vidID[1][0];
					$vid_id2=$vidID[1][1];
					
					$cont=$this->delAllVid($cont);
					$cont="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"220\" src=\"https://www.youtube.com/embed/$vid_id1\" style=\"text-align: center;\" width=\"380\"></iframe></p>".$cont."<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"220\" src=\"https://www.youtube.com/embed/$vid_id2\" style=\"text-align: center;\" width=\"380\"></iframe></p>";
					$this->writeCont($id,$cont);
				}
				if ($count==3)
				{
					$vid_id1=$vidID[1][0];
					$vid_id2=$vidID[1][1];
					$vid_id3=$vidID[1][2];
					
					$cont=$this->delAllVid($cont);
					$cont="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"220\" src=\"https://www.youtube.com/embed/$vid_id1\" style=\"text-align: center;\" width=\"380\"></iframe></p>".$cont."<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"220\" src=\"https://www.youtube.com/embed/$vid_id2\" style=\"text-align: center;\" width=\"380\"></iframe>&nbsp;<iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"220\" src=\"https://www.youtube.com/embed/$vid_id3\" style=\"text-align: center;\" width=\"380\"></iframe></p>";
					$this->writeCont($id,$cont);
				}
				
				/*
				if ($count==4)
				{
					$vid_id1=$vidID[1][0];
					$vid_id2=$vidID[1][1];
					$vid_id3=$vidID[1][2];
					$vid_id4=$vidID[1][3];
					
					$cont=$this->delAllVid($cont);
					$cont="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"220\" src=\"https://www.youtube.com/embed/$vid_id1\" style=\"text-align: center;\" width=\"380\"></iframe>&nbsp;<iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"220\" src=\"https://www.youtube.com/embed/$vid_id2\" style=\"text-align: center;\" width=\"380\"></iframe></p></p>".$cont."<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"220\" src=\"https://www.youtube.com/embed/$vid_id3\" style=\"text-align: center;\" width=\"380\"></iframe>&nbsp;<iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"220\" src=\"https://www.youtube.com/embed/$vid_id4\" style=\"text-align: center;\" width=\"380\"></iframe></p>";
					$this->writeCont($id,$cont);
				}*/
					
				/*if ($id==30073)
				{
					echo $cont;
					echo "<br>$id";
					echo "<pre>";
					print_r($vidID);
					echo "</pre>";
					echo count($vidID[1]);
				}
				*/	
				//var_dump($vidID);
				//echo "<pre>";
				//print_r($vidID);
				//echo "</pre>";
				//if (is_array($vidID)&&count($vidID)>2)
				//{
				//	foreach ($vidID as $vid)
				//	{
				//		echo $vid[0]."<br>";
				//	}
				//}
				//break;
            }
        }
        else
        {
            echo "No array to work with!<br>";
        }
    }
}

class EditVidSHK
{
	private function getTovList()
	{
		//echo host.user.pass.db."<br>";
		$db_connect=mysqli_connect(host,user,pass,db);
		$f_id=106;
        $query="SELECT goods_id, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0 AND factory_id=$f_id";
		//echo "$query<br>";
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
	
	private function getVidId($cont)
    {
        //echo "Whghgh<pre>";
        preg_match_all('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $cont, $videoId);
        //echo count ($videoId)."<br>";
        return $videoId;
    }
	
	private function delText($cont)
	{
		$cont=str_replace("<a href=\"https://www.youtube.com/watch?v=EmzW8ECVk1A&amp;feature=youtu.be\" target=\"_blank\"><img alt=\"\" src=\"/admin/upload/image/news/mebli/trikoz_kopiya.jpg\" style=\"width: 252px; height: 142px;\" /></a></p>","",$cont);
		$cont=str_replace("<strong>Мы собрали для Вас полезные советы в этом ролике:</strong>","",$cont);
		$cont=str_replace("<strong>Что нужно знать при выборе шкафа-купе?</strong>","",$cont);
		return $cont;
	}
	
	private function writeCont($id, $cont)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goods SET goods_content='$cont' WHERE goods_id=$id";
		//mysqli_query($db_connect,$query);
        echo "$query<br>";
		//$this->writeLog($query);
		mysqli_close($db_connect);
	}
	
	private function insUpperVid($cont)
	{
		$cont="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/oMtKQTp4xEI\" style=\"text-align: center;\" width=\"380\"></iframe>&nbsp;<iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/EmzW8ECVk1A\" style=\"text-align: center;\" width=\"380\"></iframe></p>".$cont;
		return $cont;
	}
	
	public function editSHK()
	{
		$goods=$this->getTovList();
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$cont=$good['goods_content'];
				$cont_new=$this->delText($cont);
				$cont_new=$this->insUpperVid($cont_new);
				$this->writeCont($id,$cont_new);
				//break;
			}
		}
		else
		{
			echo "No goods!<br>";
		}
		
	}
    
}

class insertVidKitchen
{
	private function getTovList()
	{
		//echo host.user.pass.db."<br>";
		$db_connect=mysqli_connect(host,user,pass,db);
		$f_id=98;
        $query="SELECT goods_id, goods_content, goods_maintcharter FROM goods WHERE goods_active=1 AND goods_noactual=0 AND factory_id=$f_id AND (goods_maintcharter=20 OR goods_maintcharter=57)";
		//echo "$query<br>";
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
	
	private function insVid($cont)
	{
		
		$cont=$cont."<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/8MQAD1i8wpQ\" style=\"text-align: center;\" width=\"380\"></iframe>";
		$cont="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/e99O0gDPkg8\" style=\"text-align: center;\" width=\"380\"></iframe>".$cont;
		return $cont;
	}
	
	private function writeCont($id, $cont)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goods SET goods_content='$cont' WHERE goods_id=$id";
		mysqli_query($db_connect,$query);
        //echo "$query<br>";
		//$this->writeLog($query);
		mysqli_close($db_connect);
	}
	
	public function editKitchen()
	{
		$goods=$this->getTovList();
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$cont="";
				$goods_maintcharter=$good['goods_maintcharter'];
				if ($goods_maintcharter==57)
				{
					$cont="<p></p><div style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px;\">
<strong style=\"margin: 0px; padding: 0px; font-size: 13.2px;\"><span style=\"color: rgb(255, 0, 0);\">Цена указана за метр погонный (без учёта столешницы).</span></strong></div>
<div style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px;\">
<strong style=\"margin: 0px; padding: 0px; font-size: 13.2px;\">Пример того, что входит в 1 погонный метр кухни:</strong></div>
<div style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px;\">
&nbsp;</div>
<div style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px; text-align: center;\">
<strong style=\"margin: 0px; padding: 0px; font-size: 13.2px;\"><img alt=\"\" src=\"/admin/upload/image/Ivanka/111_42230.jpg\" style=\"width: 390px; height: 600px;\" /></strong></div>
<p style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px; margin: 20px 0px 0px; padding: 0px;\">
<strong style=\"margin: 0px; padding: 0px;\">Кухня набирается по размерам заказчика, исходя из вариантов секций на дополнительном фото</strong></p>
<p style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px; text-align: justify;\">
Кухни фабрики &laquo;Гарант&raquo; представляют собой модульную систему. То есть, они состоят из определенного ассортимента модулей, благодаря которому возможно скомбинировать практически любой размер Вашей кухни. Корпуса и фасады упаковываются раздельно, что позволяет комбинировать цвета на ваш вкус. В ассортименте фабрики есть фасады из материала МДФ, покрытые цветной ПВХ пленкой: однотонные глянцевые, матовые со структурой дерева, с патиной.</p>
<p style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px; text-align: justify;\">
&nbsp; &nbsp;Также представлена бюджетная серия кухонь с фасадом из ДСП. Такой фасад покрыт ламинатом под структуру дерева или является просто однотонным. В стандартную комплектацию корпусов входит вся фурнитура, необходимая для полноценного функционирования кухни. В комплект выдвижных ящиков включены телескопические направляющие, которые обеспечивают полное выдвижение самого ящика и плавный ход механизма.</p>
<p style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px;\">
<strong>Технические характеристики:</strong></p>
<ul style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px;\">
<li style=\"text-align: justify;\">
- верхние тумбочки изготавливаются в двух размерах: высотой 72 см и 92 см,&nbsp;<span style=\"font-size: 13.2px;\">глубиной</span>&nbsp;30 см;</li>
<li style=\"text-align: justify;\">
- тумбочки, открывающиеся вертикально, оснащены газовыми подъёмниками;</li>
<li style=\"text-align: justify;\">
- нижние секции высотой 82 см (без учета столешницы) и глубиной 48 см;</li>
<li style=\"text-align: justify;\">
- нижние секции комплектуются регулируемыми по высоте ножками, которые можно закрыть сплошным цоколем.</li>
</ul>
<p style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px; margin: 20px 0px 0px; padding: 0px; text-align: justify;\">
Кухни торговой марки &laquo;Гарант&raquo; отличаются оптимальным соотношением доступной цены и высокого качества, что способствует большой популярности на рынке Украины.</p>";
				}
				if ($goods_maintcharter==20)
				{
					$cont="<p></p><div style=\"text-align: justify;\">
<div style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px;\">
<strong>Цена указана за комплект 2 м. без учета стоимости столешници, мойки и техники.</strong></div>
<div style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px;\">
<strong>Пример набора 2 м. на картинке ниже.</strong></div>
<div style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px;\">
&nbsp;</div>
</div>
<div style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px; text-align: center;\">
<img alt=\"\" src=\"http://fayni-mebli.com/content/goods/12269/2m_-kopiya_30789.jpg\" style=\"font-size:12pt; text-align: center; width: 400px; height: 300px;\" /></div>
<p style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px; text-align: justify;\">
&nbsp; &nbsp;Кухни фабрики &laquo;Гарант&raquo; представляют собой модульную систему. То есть, они состоят из определенного ассортимента модулей, благодаря которому возможно скомбинировать практически любой размер Вашей кухни. Корпуса и фасады упаковываются раздельно, что позволяет комбинировать цвета на ваш вкус. В ассортименте фабрики есть фасады из материала МДФ, покрытые цветной ПВХ пленкой: однотонные глянцевые, матовые со структурой дерева, с патиной.</p>
<p style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px; text-align: justify;\">
&nbsp; &nbsp;Также представлена бюджетная серия кухонь с фасадом из ДСП. Такой фасад покрыт ламинатом под структуру дерева или является просто однотонным. В стандартную комплектацию корпусов входит вся фурнитура, необходимая для полноценного функционирования кухни. В комплект выдвижных ящиков включены телескопические направляющие, которые обеспечивают полное выдвижение самого ящика и плавный ход механизма.</p>
<p style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px; text-align: justify;\">
<strong>Технические характеристики:</strong></p>
<ul style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px;\">
<li style=\"text-align: justify;\">
- верхние тумбочки изготавливаются в двух размерах: высотой 72 см и 92 см, шириной 30 см;</li>
<li style=\"text-align: justify;\">
- тумбочки, открывающиеся вертикально, оснащены газовыми подъёмниками;</li>
<li style=\"text-align: justify;\">
- нижние секции высотой 82 см (без учета столешницы) и глубиной 48 см;</li>
<li style=\"text-align: justify;\">
- нижние секции комплектуются регулируемыми по высоте ножками, которые можно закрыть сплошным цоколем.</li>
</ul>
<p style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 13.2px; margin: 20px 0px 0px; padding: 0px; text-align: justify;\">
Кухни торговой марки &laquo;Гарант&raquo; отличаются оптимальным соотношением доступной цены и высокого качества, что способствует большой популярности на рынке Украины.</p>";
				}
				
				
				$cont=$this->insVid($cont);
				$this->writeCont($id,$cont);
				//break;
			}
		}
		else
		{
			echo "No goods!<br>";
		}
		
	}
}


$runtime = new Timer();
$runtime->setStartTime();
//$test=new insertVidMatr(35);
//$test->insVidsComFor();
//$test=new insertVidMatr(46);
//$test->insVidsMatrolux();
//$test=new insertVidMatr(189);
//$test->insVidsAdormo();
//$test=new insertVidMatr(63);
//$test->insVidsAdormo();
//$test=new insertVidMatr(192);
//$test->insVidsSL();
//$test->insVidsAdormo();
//$test=new insertVidMatr(97);
//$test->insVidKH();
//$test=new insertVidBeds();
//$test->getNoVid();
//$test->goSingle();
//$test->goLast();
//$test=new CopyVid();
//$test->FindVideo();
///////////////////////
//$test=new FixVidSize();
//$test->FixVideo();
//$test->VidPos();
///////////////////
//$test=new EditVidSHK();
//$test->editSHK();

$test=new insertVidKitchen();
$test->editKitchen();

$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
