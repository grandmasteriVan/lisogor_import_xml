<?php
header('Content-Type: text/html; charset=utf-8');
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 06.11.2017
 * Time: 10:21
 */

//define ("host","localhost");
define ("host","localhost");
/**
 * database username
 */
define ("user", "root");
//define ("user", "newfm");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "N0r7F8g6");
/**
 * database name
 */
define ("db", "fm_new");
//define ("db", "newfm");
/**
 * Class Timer
 */
 
 
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
/**
 * Class BaseTranslate
 */
class BaseTranslate
{
    /**
     * переводим текст с помощью Яндекс.переводчик
     * @param $txt string - текст, который нам надо перевести
     * @return string - результат перевода
     */
    public function translateText($txt)
    {
        //я
		$api_key="trnsl.1.1.20170706T112229Z.752766fa973319f4.6dcbe2932c5e110da20ee3ce61c5986e7e492e7f";
		//алена
        //$api_key="trnsl.1.1.20180827T115930Z.dabf581f6854b5e7.14a06f36c6a994bdfa2be1f303fd9fb71f2b3c9f";
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
    public function strip($txt)
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
}

class TranslateDiv extends BaseTranslate
{
	private function getGoods()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id from goodshascategory WHERE category_id=1";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$goods[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
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
	
	private function getTextforId($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goodshaslang_content from goodshaslang WHERE goods_id=$id AND goodshaslang_active=1 AND lang_id=1 AND goodshaslang_content NOT LIKE ''";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$text[] = $row;
				}
		}
		mysqli_close($db_connect);
		if (is_array ($text))
		{
			return $text[0]['goodshaslang_content'];
		}
		else
		{
			return null;
		}
	}
	
	public function translate()
	{
		$goods=$this->getGoods();
		if (is_array($goods))
		{
			//var_dump ($goods);
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$text=$this->getTextforId($id);
				//var_dump($text);
				//echo "$id has $text<br>";
				//break;
				if (!is_null($text))
				{
					$text=$this->strip($text);
					$ukr_text=$this->translateText($text);
					$ukr_text=str_replace("_______",PHP_EOL,$ukr_text);
					$file_string="[id]".$id."[/id]".PHP_EOL."[ru_text]".$text."[/ru_text]".PHP_EOL."[ukr_text]".$ukr_text."[/ukr_text]".PHP_EOL.PHP_EOL;
					file_put_contents("ukr_div.txt",$file_string,FILE_APPEND);
					echo "$file_string<br>";
					//break;
				}
				
			}
		}
		else
		{
			echo "No goods!";
		}
	}
}

/**
 * Class GoodsTranslate
 */
class GoodsTranslate extends BaseTranslate
{
    /**
     * @return array|null
     */
    private function selectGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_name, goods_url, goods_content FROM goods WHERE goods_active=1 AND goods_noactual=0 AND goods_id>33077 order by goods_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
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
    /**
     *
     */
    public function translate()
    {
        $goods=$this->selectGoods();
        if (!is_null($goods))
        {
            foreach ($goods as $good)
            {
                $name=$good['goods_name'];
                $text=$good['goods_content'];
                $id=$good['goods_id'];
                $text=$this->strip($text);
               
				$name_ukr=$this->translateText($name);
				$text_ukr=$this->translateText($text);
				$url="http://fayni-mebli.com/".$good['goods_url'].".html";
				$file_string="[id]".$id."[/id]".PHP_EOL.$url.PHP_EOL."[goods_name_ukr]".$name_ukr."[/goods_name_ukr]".PHP_EOL.
						"[goods_text_ukr]".$text_ukr."[/goods_text_ukr]".PHP_EOL.PHP_EOL;
				file_put_contents("goods-n.txt",$file_string,FILE_APPEND);
				
				
                //echo $file_string;
                //break;
            }
        }
        else
        {
            echo "No array of goods!!";
        }
    }
}
class ArticleTranslate extends BaseTranslate
{
    private function getArticles()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT article_id, article_url, article_content, article_preview, article_name FROM article WHERE article_active=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $articles[] = $row;
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (is_array($articles))
        {
            return $articles;
        }
        else
        {
            return null;
        }
    }
    public function translate()
    {
        $articles=$this->getArticles();
        if (!is_null($articles))
        {
            foreach ($articles as $article)
            {
                $name=$article['article_name'];
                $content=$article['article_content'];
                $preview=$article['article_preview'];
                $id=$article['article_id'];
                $content=$this->strip($content);
                $preview=$this->strip($preview);
                $content=$this->translateText($content);
                $preview=$this->translateText($preview);
                $name=$this->translateText($name);
                $url="http://fayni-mebli.com/".$article['article_url'].".html";
                $file_string="[id]".$id."[/id]".PHP_EOL.$url.PHP_EOL."[name_ukr]".$name."[/name_ukr]".PHP_EOL.
                    "[prev_ukr]".$preview."[/prev_ukr]".PHP_EOL."[text_ukr]".$content."[/text_ukr]".PHP_EOL.PHP_EOL;
                file_put_contents("articles.txt",$file_string,FILE_APPEND);
                //echo $file_string;
                //break;
            }
        }
        else
        {
            echo "No array of articles";
        }
    }
}
class cleanFile
{
    private $all_txt;
    private function readFile()
    {
        $this->all_txt=file_get_contents("Output_Packer.txt");
    }
    private function modGoods($goods_maintcharter=14)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods WHERE goods_maintcharter=$goods_maintcharter AND goods_parent<>goods_id AND goods_noactual=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row['goods_id'];
            }
        }
        mysqli_close($db_connect);
        return $arr;
    }
	
	private function getIdList($goods)
	{
		foreach ($goods as $good)
		{
			$id[]=$goods['goods_id'];
		}
		return $id;
	}
	
    private function findId($txt)
    {
        if (preg_match("#id(.+?)\/id#is",$txt,$matches))
        {
            //var_dump($matches);
            $id=$matches[1];
            $id=str_replace("]","",$id);
            $id=str_replace("[","",$id);
            //$id=str_replace(" ","",$id);
        }
        else
        {
            echo "Not find text<br>";
        }
        return $id;
    }
    private function parseAllText($txt)
    {
        //echo "txt=$txt<br>";
        $expl=explode("[/goods_text_ukr]",$txt);
        foreach ($expl as $str)
        {
            $str=trim ($str);
            $expl1[]=$str."[/goods_text_ukr]";
        }
        return $expl1;
    }
	
	public function getDiff()
	{
		$this->readFile();
		//var_dump($this->all_txt);
		$txt=$this->parseAllText($this->all_txt);
		//var_dump($txt);
		$matr=$this->modGoods(14);
		$shk=$this->modGoods(9);
		//var_dump($matr);
		$dell_goods=array_merge($matr,$shk);
		//var_dump($dell_goods);
		
		if (is_array($txt))
		{
			foreach ($txt as $good)
			{
				//var_dump($good);
				$id=$this->findId($good);
				//var_dump($id);
				$ids[]=$id;
				//break;
			}
			//var_dump($ids);
			$new_list=array_diff($ids,$dell_goods);
			//var_dump($new_list);
			foreach ($txt as $good)
			{
				$id=$this->findId($good);
				if (array_search($id,$new_list))
				{
					$new_txt[]=$good;
					//break;
				}
			}
			//var_dump($new_txt);
			foreach ($new_txt as $txt)
			{
				//var_dump ($txt);
				$text=$txt;
				//$temp="[/id]"."\r\n";
				//$text=str_replace("[/id]",$temp,$text);
				//$temp=".html"."\r\n";
				//$text=str_replace(".html",$temp,$text);
				//$temp="[/goods_name_ukr]"."\r\n";
				//$text=str_replace("/goods_name_ukr]",$temp,$text);
				$temp="[/goods_text_ukr]"."\r\n"."\r\n"."\r\n";
				$text=str_replace("[/goods_text_ukr]",$temp,$text);
				file_put_contents("goods_clean.txt",$text,FILE_APPEND);
			}
		}
	}
}



$runtime = new Timer();
set_time_limit(90000);
$runtime->setStartTime();
//$test= new cleanFile();
//$test->getDiff();


//$test=new GoodsTranslate();
$test = new TranslateDiv();
$test->translate();
//$test=new ArticleTranslate();
//$test->translate();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
