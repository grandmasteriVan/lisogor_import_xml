<?php
//header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
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

Class Vids
{
	public $f_id;
	
	function __construct($f_id)
    {
        $this->f_id=$f_id;
    }
	
	function delAllVid($cont)
	{
		//var_dump($cont);
		if ($this->f_id==35)
		{
			preg_match_all('/<img[^>]+>/i',$cont, $img); 
		}
		$arr=explode('</p>',$cont);
		//var_dump($arr);
		$cont_new=preg_replace("'<iframe[^>]*?>.*?</iframe>'si","",$arr);
		foreach($cont_new as $paragraph)
		{
			$paragraph=strip_tags($paragraph);
			$paragraph=str_ireplace(PHP_EOL,"",$paragraph);
			$paragraph=str_ireplace("	","",$paragraph);
			$paragraph=str_ireplace("&nbsp;","",$paragraph);
			//$cont_new1="";
			if ((strcmp($paragraph," ")!=0)&&(strcmp($paragraph,"")!=0))
			{
				$cont_new1[].="<p>".$paragraph."</p>";
			}
			
			
		}
		//если есть картинки - добавляем их в текст в самом начале
		if (is_array($img))
		{
			//var_dump($img);
			$imgtag=$img[0][0];
			array_unshift($cont_new1,"<p style=\"text-align: center;\">$imgtag</p>");
		}
		$cont_new1=implode("",$cont_new1);
		return $cont_new1;
	}
	function insVidMatroluxe($cont)
	{
		
		$cont="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/JF1wYXFtPck\" style=\"text-align: center;\" width=\"380\"></iframe></p>".$cont."<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/KYTqssupjgg\" style=\"text-align: center;\" width=\"380\"></iframe>\&nbsp;<iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/44DDXY4B7z4\" style=\"text-align: center;\" width=\"380\"></iframe></p>";
		return $cont;
	}
	function insVidComeFor($cont)
	{
		
		$cont="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/JF1wYXFtPck\" style=\"text-align: center;\" width=\"380\"></iframe></p>".$cont."<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/5HEoT874niY\" style=\"text-align: center;\" width=\"380\"></iframe>";
		return $cont;
	}
	function insVidAdormoHighFoamBonatoSonline($cont)
	{
		
		$cont="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/JF1wYXFtPck\" style=\"text-align: center;\" width=\"380\"></iframe></p>".$cont;
		return $cont;
	}
	
	function writeCont($cont,$id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goods SET goods_content='$cont' WHERE goods_id=$id";
		mysqli_query($db_connect,$query);
		echo "$id done!<br>";
		//echo "$query<br>";
		mysqli_close($db_connect);
	}
	
	public function insVid()
	{
		//Матролюкс
		if ($this->f_id==46)
		{
			$goods=$this->getGoodsByFactory();
			if (is_array($goods))
			{
				foreach ($goods as $good)
				{
					$id=$good['goods_id'];
					$cont=$good['goods_content'];
					
					$cont=$this->delAllVid($cont);
					
					//var_dump($cont);
					//echo "<br><br>";
					$cont=$this->insVidMatroluxe($cont);
					$this->writeCont($cont,$id);
					break;
					
				}
			}
			else
			{
				echo "Не получили массив товаров!<br>";
			}
		}
		//come-for
		if ($this->f_id==35)
		{
			$goods=$this->getGoodsByFactory();
			if (is_array($goods))
			{
				foreach ($goods as $good)
				{
					$id=$good['goods_id'];
					$cont=$good['goods_content'];
					
					$cont=$this->delAllVid($cont);
					//echo "$id<br>";
					//var_dump($cont);
					//echo "<br><br>";
					$cont=$this->insVidComeFor($cont);
					$this->writeCont($cont,$id);
					//break;
					
				}
			}
			else
			{
				echo "Не получили массив товаров!<br>";
			}
		}
	}
	
	function getGoodsByFactory()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_id, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0 AND goods_productionout=0 AND factory_id=$this->f_id";
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
}
//$temp=new Vids(46);
//$temp->insVid();

$temp=new Vids(35);
$temp->insVid();


/*
$db_connect=mysqli_connect(host,user,pass,db);
	unset ($goods);
    $query="SELECT goods_id, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0 AND goods_productionout=0 AND factory_id=74";
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
	if (is_array($goods))
	{
		foreach ($goods as $good)
		{
			$id=$good['goods_id'];
			//добавляем видео Как выбрать матрас
			$content="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/JF1wYXFtPck\" style=\"text-align: center;\" width=\"380\"></iframe></p>".$goods['goods_content'];
			$query="UPDATE goods SET goods_content='$content' WHERE goods_id=$id";
			mysqli_query($db_connect,$query);
			
		}
	}
	else
	{
		echo "No array";
	}
    mysqli_close($db_connect);
	
	*/