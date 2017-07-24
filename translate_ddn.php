<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 06.07.17
 * Time: 11:44
 */
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */

//define ("host","localhost");
define ("host","localhost");
/**
 * database username
 */
//define ("user", "u_divani_n");
define ("user", "root");
/**
 * database password
 */
//define ("pass", "EjcwKUYK");
define ("pass", "");
/**
 * database name
 */
//define ("db", "divani_new");
define ("db", "ddn_new");
/**
 * Class Timer
 * подсчет времени выполнения скрипта
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
class WriteTranslate
{
    private $all_txt;
    private function findId($txt)
    {
        if (preg_match("#goods_id\:(.+?)\/goods_id#is",$txt,$matches))
        {
            //var_dump($matches);
			$ukr_txt=$matches[0];
			$ukr_text_s=str_replace("goods_id:","",$ukr_txt);
			$ukr_text_s=str_replace("/goods_id","",$ukr_text_s);
			$ukr_text_s=str_replace(" ","",$ukr_text_s);
        }
		else
		{
			echo "Not find text<br>";
		}
        return $ukr_text_s;
		
    }
	private function findUkrText($txt)
	{
		if (preg_match("#ukr_text\:(.+?)\/ukr_text#is",$txt,$matches))
        {
            //var_dump($matches);
			$id=$matches[0];
			$id_s=str_replace("ukr_text:","",$id);
			$id_s=str_replace("/ukr_text","",$id_s);
        }
		else
		{
			echo "Not find text<br>";
		}
        return $id_s;
	}
    private function parceAllText($txt)
    {
        //echo "txt=$txt<br>";
		$expl=explode("/ukr_text",$txt);
		
		foreach ($expl as $str)
		{
			$str=trim ($str);
			$expl1[]=$str." /ukr_text";
		}
		
		return $expl1;
		
		
    }
    private function ReadFile()
    {
        $this->all_txt=file_get_contents("texts_all.txt");
    }
	private function writeTrnan($id,$text)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goodshaslang SET goodshaslang_content='$text' WHERE goods_id=$id AND lang_id=3";
		mysqli_query($db_connect,$query);
		echo "$query<br>";
		mysqli_close($db_connect);
	}
	private function insertParagraph($txt)
	{
		//var_dump ($txt);
		//echo "<br><br>";
		$txt="<p>".$txt;
		//var_dump ($txt);
		$txt=str_replace("<br />","</p>\n<p>",$txt);
		$txt=$txt."</p>";
		//echo "<br><br>";
		//var_dump ($txt);
		
		return $txt;
	}
	private function getVidId($content)
	{
		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $content, $videoId);
		$vidId=$videoId[1];
		return $vidId;
	}
	private function getVidString($vid_id)
	{
		$vid_str="<p><iframe allowfullscreen=\"\" frameborder=\"0\" height=\"315\" src=\"https://www.youtube.com/embed/$vid_id?rel=0\" width=\"560\"></iframe></p>";
		return $vid_str;
	}
	private function searchVid($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goodshaslang_content FROM goodshaslang WHERE goods_id=$id AND lang_id=1";
		//echo "$query<br>";
		if ($res=mysqli_query($db_connect,$query))
		{
			while ($row = mysqli_fetch_assoc($res))
            {
                $content[] = $row;
            }
            if (is_array($content))
            {
                foreach ($content as $cont)
                {
                    //получаем нужный текст
                    $cont=$cont['goodshaslang_content'];
                }
            }
		}
		mysqli_close($db_connect);
		if (mb_strpos($cont,'iframe')!=false)
		{
			$vid_id=$this->getVidId($cont);
			$vid_str=$this->getVidString($vid_id);
			//echo "";
			return $vid_str;
		}
		else
		{
			return false;
		}
		
		mysqli_close($db_connect);
	}
	
    public function test()
    {
        $this->ReadFile();
		$txt=$this->all_txt;
		$txt=nl2br($txt);
		$parce=$this->parceAllText($txt);
		foreach ($parce as $div)
		{
			//echo "$div<br>";
			$ukr_text=$this->findUkrText($div);
			$ukr_text=str_replace("'","\'",$ukr_text);
			$ukr_text=$this->insertParagraph($ukr_text);
			
			$id=$this->findId($div);
			//echo "id=$id<br>";
			//echo "ukrtext= $ukr_text<br><br>";
			if ($id==908)
			{
				$vid=$this->searchVid($id);
				echo "$vid<br>";
			}
			
			//break;
		}
    }
	public function fromTxtToDb()
	{
		$this->ReadFile();
		$txt=$this->all_txt;
		$txt=nl2br($txt);
		$parce=$this->parceAllText($txt);
		foreach ($parce as $div)
		{
			//echo "$div<br>";
			$ukr_text=$this->findUkrText($div);
			$ukr_text=str_replace("'","\'",$ukr_text);
			//echo "$ukr_text<br>";
			$ukr_text=$this->insertParagraph($ukr_text);
			
			$id=$this->findId($div);
			$isVid=$this->searchVid($id);
			if ($isVid)
			{
				$ukr_text=$isVid.$ukr_text;
			}
			$this->writeTrnan($id,$ukr_text);
			
			//break;
		}
		
	}
}
/**
 * Class TranslateDdn
 */
class TranslateDdn
{
    /**
     * переводим текст с помощью Яндекс.переводчик
     * @param $txt string - текст, который нам надо перевести
     * @return string - результат перевода
     */
    private function translatePos($txt)
    {
        $api_key="trnsl.1.1.20170706T112229Z.752766fa973319f4.6dcbe2932c5e110da20ee3ce61c5986e7e492e7f";
        $lang="ru-uk";
		$txt=str_replace(" ","%20",$txt);
		$link="https://translate.yandex.net/api/v1.5/tr.json/translate?key=".$api_key."&text=".$txt."&lang=".$lang;
		//echo $link."<br>";
       	$result=file_get_contents($link);
        $result=json_decode($result,true);
        $ukr_txt=$result['text'][0];
        //var_dump($result);
		return $ukr_txt;
    }
    /**
     * Удаляем лишние символы перед тем, как скормить строку яндексу
     * @param $txt string контент, полученный из базы данных
     * @return mixed|string - строка, которую будем скармливать яндексу
     */
    private function strip($txt)
	{
		$txt=strip_tags($txt);
		
		$txt=str_replace("&laquo;","",$txt);
		$txt=str_replace("&raquo;","",$txt);
		$txt=str_replace("&amp;","",$txt);
		$txt=str_replace("&nbsp;","",$txt);
		$txt=str_replace("&quot","",$txt);
		$txt=str_replace("&","",$txt);
		$txt=str_replace(";","",$txt);
		$txt=str_replace("/","",$txt);
		//$txt=nl2br($txt);
		$txt=str_replace(array('«', '»'),'',$txt);
		$txt=trim($txt);
		//$txt=addslashes($txt);
		
		return $txt;
	}
    /**
     * получаем имя дивана
     * @param $id integer - айди дивана
     * @return mixed - имя дивана
     */
    private function getName($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_name FROM goodshaslang WHERE goods_id=$id AND lang_id=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $texts[] = $row;
            }
            if (is_array($texts))
            {
                foreach ($texts as $text)
                {
                    //получаем нужный текст
                    $name=$text['goodshaslang_name'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $name;
    }
	
    /**
     * получаем текст определенного товара
     * @param $id integer - айди товара
     * @return string - текст этого товара
     */
    private function getText($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_content FROM goodshaslang WHERE goods_id=$id AND lang_id=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $texts[] = $row;
            }
            if (is_array($texts))
            {
                foreach ($texts as $text)
                {
                    //получаем нужный текст
                    $txt=$text['goodshaslang_content'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $txt;
    }
    /**
     * возвращает список айди товаров по определенной фабрике
     * @param $factory_id integer - id фабрики
     * @return array - список айди позиций
     */
    private function getGoodsFactory($factory_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT DISTINCT goodshaslang.goods_id, goodshaslang.goodshaslang_name FROM goodshaslang join goodshasfeature on goodshaslang.goods_id=goodshasfeature.goods_id WHERE lang_id=1 AND goodshaslang_active=1 AND  goodshasfeature.goods_id in (select goodshasfeature.goods_id from goodshasfeature where feature_id=14 AND goodshasfeature_valueid=$factory_id) ORDER BY goodshaslang.goodshaslang_name ASC";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            if (is_array($goods))
            {
                unset ($ids);
                foreach ($goods as $good)
                {
                    //получаем нужный текст
                    $ids[]=$good['goods_id'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $ids;
    }
    /**
     * получаем список товаров, которые не в работе
     * @return array - список ид
     */
    private function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT DISTINCT goods.goods_id FROM goods join goodshasfeature on goods.goods_id=goodshasfeature.goods_id WHERE goodshasfeature.goods_id not in (select goodshasfeature.goods_id from goodshasfeature where feature_id=14 AND (goodshasfeature_valueid=125 OR goodshasfeature_valueid=91 OR goodshasfeature_valueid=96 OR goodshasfeature_valueid=89 OR goodshasfeature_valueid=90 OR goodshasfeature_valueid=134 OR goodshasfeature_valueid=83 OR goodshasfeature_valueid=86 OR goodshasfeature_valueid=123 OR goodshasfeature_valueid=87))";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            if (is_array($goods))
            {
                unset ($ids);
                foreach ($goods as $good)
                {
                    //получаем нужный текст
                    $ids[]=$good['goods_id'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $ids;
    }
	
	/**
     *получаем список всех ид товаров
     */
    private function getGoodsIds()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            if (is_array($goods))
            {
                unset ($ids);
                foreach ($goods as $good)
                {
                    //получаем нужный текст
                    $ids[]=$good['goods_id'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $ids;
    }
    /**
     * скармливаем айдишку товара и получаем ответ надо ли его переводить или нет
     * @param $goods_id integer - айди товара
     * @return bool -
     */
    private function getInNeed($goods_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_name, goodshaslang_content, lang_id FROM goodshaslang WHERE goods_id=$goods_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            if (is_array($goods))
            {
                foreach ($goods as $good)
                {
                    if ($good['lang_id']==1)
                    {
                        $ru_name=$good['goodshaslang_name'];
                        $ru_cont=$good['goodshaslang_content'];
                    }
                    if ($good['lang_id']==3)
                    {
                        $ukr_name=$good['goodshaslang_name'];
                        $ukr_cont=$good['goodshaslang_content'];
                    }
                }
                if (strnatcasecmp($ru_name,$ukr_name)==00&&strnatcasecmp($ru_cont,$ukr_cont)==0&&strnatcasecmp($ru_cont,""))
                {
                    mysqli_close($db_connect);
                    return true;
                }
                else
                {
                    mysqli_close($db_connect);
                    return false;
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
    }
    /**
     * создает файл с переводами текствов товаров для определенной фабрики
     * @param $factory_id integer - ай-ди фабрики
     */
    public function getTranslateFactory($factory_id)
    {
        $all_goods=$this->getGoodsFactory($factory_id);
        foreach ($all_goods as $good)
        {
            $goods_id=$good;
            //если нам нужен перевод - то мы его получаем
            if ($this->getInNeed($goods_id))
            {
                $ru_name=$this->getName($goods_id);
				$ukr_name=$this->translatePos($ru_name);
				
				
				$ru_text=$this->getText($goods_id);
				$ru_text=$this->strip($ru_text);
				if (strnatcasecmp($ru_text,"")!=0)
				{
					$ukr_text=$this->translatePos($ru_text);
					$ukr_text=str_replace("__","\n",$ukr_text);
					$file="goods_id:$goods_id /goods_id".PHP_EOL."goods_name:$ru_name-$ukr_name goods_name/".PHP_EOL."ru_text: $ru_text /ru_text".PHP_EOL."ukr_text: $ukr_text /ukr_text".PHP_EOL.PHP_EOL.PHP_EOL;
					file_put_contents("texts_$factory_id.txt",$file,FILE_APPEND);
				}	
        
            }
        }
    }
	
	/**
     *рабочая лошадка, которая вызывает другие методы
     * на выходе получаем файл с текстами и переводами
     */
    public function getTranslate()
    {
        $all_goods=$this->getGoods();
        foreach ($all_goods as $good)
        {
            $goods_id=$good;
            //если нам нужен перевод - то мы его получаем
            if ($this->getInNeed($goods_id))
            {
                $ru_name=$this->getName($goods_id);
				$ukr_name=$this->translatePos($ru_name);
				
				
				$ru_text=$this->getText($goods_id);
				$ru_text=$this->strip($ru_text);
                $ukr_text=$this->translatePos($ru_text);
				$ukr_text=str_replace("__","\n",$ukr_text);
				$file="goods_id:$goods_id /goods_id".PHP_EOL."goods_name:$ru_name-$ukr_name goods_name/".PHP_EOL."ru_text: $ru_text /ru_text".PHP_EOL."ukr_text: $ukr_text /ukr_text".PHP_EOL.PHP_EOL.PHP_EOL;
                file_put_contents("texts.txt",$file,FILE_APPEND);
            }
        }
    }
	
}
$runtime = new Timer();
set_time_limit(9000);
$runtime->setStartTime();
//$test=new TranslateDdn();
//$test->getTranslate();
//$test->getTranslateFactory(134);
$test2 = new WriteTranslate();
//$test2->test();
$test2->fromTxtToDb();
//$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
