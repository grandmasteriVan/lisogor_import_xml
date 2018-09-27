<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 18.07.17
 * Time: 16:42
 */
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
//define ("host","localhost");
/**
 *
 */
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
class Estella extends Link
{
    /**Возвращает строку с первой Прописной буквой
     * @param $name string
     * @return string
     */
    private function getNameFM($name)
    {
        $name=mb_strtolower($name);
        $name_new=mb_strtoupper(mb_substr($name, 0, 1,'UTF-8'),'UTF-8').mb_substr($name, 1, mb_strlen($name,'UTF-8'),'UTF-8');
        return $name_new;
    }
    /**
     * @param $cat
     * @return array
     */
    private function getCat($cat)
    {
        $cat=explode("-",$cat);
        return $cat[1];
    }
    /**
     *
     */
    public function parseEstella()
    {
        $f_id=32;
        $db_connect=mysqli_connect(host,user,pass,db);
        $this->ReadFile();
        //$this->printData();
        foreach ($this->data as $d)
        {
            //$code1c=$d[0];
            $name=$d[1];
            $name=$this->getNameFM($name);
            //формируем нужный код 1С
            $code1c=$d[2]."/".$this->getCat($d[3]);
            $size=$this->getCat($d[3]);
            $name="Кровать ".$name;
            if ($size!="80")
            {
                $name.=" $size"."х200";
            }
            //$name=$this->UTF8toCP1251($name);
            echo "$name - $code1c<br>";
            //$code1c=$this->UTF8toCP1251($code1c);
            //$name=$this->UTF8toCP1251($name);
            $query = "UPDATE goods SET goods_article_1c='$code1c' WHERE goods_name = '$name' AND factory_id=$f_id";
            //mysqli_query($db_connect,$query);
            echo "$query<br>";
            //break;
        }
        mysqli_close($db_connect);
    }
}
class Greid extends Link
{
    public function parseGreid()
    {
        $f_id=30;
        $db_connect=mysqli_connect(host,user,pass,db);
        $this->ReadFile();
        foreach ($this->data as $d)
        {
            $code1c=$d[0];
            $name=$d[1];
            $query = "UPDATE goods SET goods_article_1c='$code1c' WHERE goods_article_link = '$name' AND factory_id=$f_id";
            //mysqli_query($db_connect,$query);
            echo "$query<br>";
        }
        mysqli_close($db_connect);
    }
}
class Nova extends Link
{
	public function parseNova()
    {
        $f_id=14;
        $db_connect=mysqli_connect(host,user,pass,db);
        $this->ReadFile();
        //$this->printData();
        foreach ($this->data as $d)
        {
            $code1c=$d[0];
            $name=$d[1];
            //$name=$this->UTF8toCP1251($name);
            echo "$name-$code1c<br>";
            $code1c=$this->UTF8toCP1251($code1c);
            $name=$this->UTF8toCP1251($name);
            $query = "UPDATE goods SET goods_article_1c='$code1c' WHERE goods_article_link = '$name' AND factory_id=$f_id";
            mysqli_query($db_connect,$query);
            echo "$query<br>";
			//break;
        }
        mysqli_close($db_connect);
    }
}
/**
* Class Tis1
*/
class Tis extends Link
{
    /**
     * @param $name
     * @return string
     */
    private function getNameFM($name)
    {
        $name=mb_strtolower($name);
		$name_new=mb_strtoupper(mb_substr($name, 0, 1,'UTF-8'),'UTF-8').mb_substr($name, 1, mb_strlen($name,'UTF-8'),'UTF-8');
        return $name_new;
    }
    /**
     * @param $name
     * @return mixed
     */
    private function getTranslate($name)
    {
        $api_key="trnsl.1.1.20170706T112229Z.752766fa973319f4.6dcbe2932c5e110da20ee3ce61c5986e7e492e7f";
        $lang="uk-ru";
        $txt=str_replace(" ","%20",$name);
        $link="https://translate.yandex.net/api/v1.5/tr.json/translate?key=".$api_key."&text=".$txt."&lang=".$lang;
        //echo $link."<br>";
        $result=file_get_contents($link);
        $result=json_decode($result,true);
        $txt=$result['text'][0];
        //var_dump($result);
        return $txt;
    }
    /**
     * @param $cat
     * @return array
     */
    private function getCat($cat)
    {
        $cat=explode("-",$cat);
        return $cat[1];
    }
    /**
     *
     */
    public function parseTis()
    {
        $f_id=37;
        $db_connect=mysqli_connect(host,user,pass,db);
        $this->ReadFile();
        //$this->printData();
        foreach ($this->data as $d)
        {
            //$code1c=$d[0];
            $name=$d[1];
			$name=$this->getNameFM($name);
            //если имя заканчивается на цифру, то делаем пробел между именем и размером
			if (is_numeric(substr($name, -1)))
			{
				$name.=" ";
			}
			//формируем нужный код 1С
			$code1c=$d[2]."/".$this->getCat($d[3]);
			$size=$this->getCat($d[3]);
            $name=$this->getTranslate($name);
			$name="Кровать ".$name;
			if ($size!="90")
			{
				$name.="$size"."х200";
			}
            //$name=$this->UTF8toCP1251($name);
            echo "$name - $code1c<br>";
            $code1c=$this->UTF8toCP1251($code1c);
            $name=$this->UTF8toCP1251($name);
            $query = "UPDATE goods SET goods_article_1c='$code1c' WHERE goods_name = '$name' AND factory_id=$f_id";
            mysqli_query($db_connect,$query);
            echo "$query<br>";
            //break;
        }
        mysqli_close($db_connect);
    }
}
/**
 * Class Novelty
 */
class Novelty extends Link
{
    /**
     *
     */
    public function parseNovelty()
    {
        $f_id=185;
        $db_connect=mysqli_connect(host,user,pass,db);
        $this->ReadFile();
        //$this->printData();
        foreach ($this->data as $d)
        {
            $code1c=$d[0];
            $name=$d[1];
            //$name=$this->UTF8toCP1251($name);
            echo "$name<br>";
            $code1c=$this->UTF8toCP1251($code1c);
            $name=$this->UTF8toCP1251($name);
            $query = "UPDATE goods SET goods_article_1c='$code1c' WHERE goods_article_link like '$name' AND factory_id=$f_id";
            mysqli_query($db_connect,$query);
            echo "$query<br>";
			//break;
        }
        mysqli_close($db_connect);
    }
}

class Miromark extends Link
{
	public function parseMiromark()
    {
        $f_id=96;
        $db_connect=mysqli_connect(host,user,pass,db);
        $this->ReadFile();
        //$this->printData();
        foreach ($this->data as $d)
        {
            $code1c=$d[0];
            $name=$d[1];
            $query = "UPDATE goods SET goods_article_1c='$code1c' WHERE goods_article_link = '$name' AND factory_id=$f_id";
            mysqli_query($db_connect,$query);
            echo "$query<br>";
        }
        mysqli_close($db_connect);
    }
}

/**
 * Class Green
 */
class Green extends Link
{
    /**
     *
     */
    public function parseGreen()
    {
        $f_id=176;
        $db_connect=mysqli_connect(host,user,pass,db);
        $this->ReadFile();
        //$this->printData();
        foreach ($this->data as $d)
        {
            $code1c=$d[1];
            $name=$d[0];
            $name=$this->UTF8toCP1251($name);
            //echo "$name<br>";
            $code1c=$this->UTF8toCP1251($code1c);
            //$name=$this->UTF8toCP1251($name);
            $query = "UPDATE goods SET goods_article_1c='$code1c' WHERE goods_name like '%$name' AND factory_id=$f_id";
            mysqli_query($db_connect,$query);
            echo "$query<br>";
        }
        mysqli_close($db_connect);
    }
}
/**
 * Class Rokko
 */
class Rokko extends Link
{
    /**
     * @param $str
     * @return mixed
     */
    private function makeName($str)
    {
        $name=$str;
        //$name="Шкаф-купе ".$name;
        $name=str_replace("*"," (",$name);
        //$name.=")";
        return $name;
    }
    /**
     *
     */
    public function parseRoko()
    {
        $f_id=141;
        $db_connect=mysqli_connect(host,user,pass,db);
        $this->ReadFile();
        //$this->printData();
        foreach ($this->data as $d)
        {
            $code1c=$d[0];
            $name=$d[1];
            $name=$this->makeName($name);
            //echo "$name<br>";
            $code1c=$this->UTF8toCP1251($code1c);
            //$name=$this->UTF8toCP1251($name);
            $query = "UPDATE goods SET goods_article_1c='$code1c' WHERE goods_name like '%$name%' AND factory_id=$f_id";
            mysqli_query($db_connect,$query);
            echo "$query<br>";
        }
        mysqli_close($db_connect);
    }
}
/**
 * Class KomfMebSK
 */
class KomfMebSK extends Link
{
    /**
     * @return array|null
     */
    private function getAllBaseSK ()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_article_link FROM goods WHERE goods_id=goods_parent AND factory_id=122 AND goods_maintcharter=9 AND goods_active=1 AND goods_noactual=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row=mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
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
     * @param $id
     * @return array|null
     */
    private function getChildrenByParent($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods WHERE goods_parent=$id AND factory_id=122 AND goods_maintcharter=9 AND goods_active=1 AND goods_noactual=0";
		//echo "$query<br>";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row=mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
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
     * @param $id
     * @param $code
     */
    private function writeCode1c ($id, $code)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$code=$this->UTF8toCP1251($code);
        $query = "UPDATE goods SET goods_article_1c='$code' WHERE goods_id=$id";
        mysqli_query($db_connect,$query);
        echo $query."<br>";
        mysqli_close($db_connect);
    }
    /**
     *
     */
    public function parseMeb()
    {
        $basic=$this->getAllBaseSK();
        $this->readFile();
        if (is_array($basic))
        {
            foreach ($basic as $item)
            {
                //var_dump($item);
				$id=$item['goods_id'];
                $article_link1=$item['goods_article_link'];
				$article_link1=mb_substr($article_link1,1);
				$article_link1="Ф-".$article_link1;
				echo "article_link=$article_link1<br>";
				
                foreach ($this->data as $d)
                {
                    $code1c=$d[0];
                    $codePrice=$d[1];
                    if ($article_link1==$codePrice AND $id<>19294)
                    {
                        echo "$article_link1 - $codePrice<br>";
						//пишем в базовую позицию
                        //$this->writeCode1c($id,$code1c);
                        //теперь пишем и для детей тот же код
                        $childrens=$this->getChildrenByParent($id);
						//var_dump;
                        if (is_array($childrens))
                        {
                            foreach ($childrens as $child)
                            {
                                $child_id=$child['goods_id'];
                                $this->writeCode1c($child_id,$code1c);
                            }
                        }
						break;
                    }
                }
				//break 2;
            }
        }
    }
}
/**
 * Class Link
 */
class Link
{
    /**
     * @var
     */
    public $data;
    /**
     *
     */
    public $filename;
    /**
     * Link constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    /**
     *
     */
    public function ReadFile()
    {
        $handle=fopen($this->filename,"r");
        while (!feof($handle))
        {
            $str=fgets($handle);
			$str=explode(";",$str);
			//для парсинга Велам, закоментить при обычном файлке!
			//$str[0].=";";
			$arr[]=$str;
            //echo "$str<br>";
        }
        if (!empty($arr))
        {
            $this->data = $arr;
        }
        else
        {
            echo "array is empty in ReadFile";
        }
    }
    /**
     *
     */
    public function printData()
    {
        $this->ReadFile();
		//var_dump($this->data);
		echo "<pre>";
		print_r($this->data);
		echo "</pre>";
    }
    /**
     * @param $str
     * @return mixed
     */
    private function parseVelam($str)
    {
        //название
        if (preg_match("#\"(.+?)\"#is",$str,$matches))
        {
            //var_dump($matches);
            $name=$matches[1];
            $name=mb_strtolower($name);
			//$name=ucfirst($name);
			$name=mb_convert_case($name,MB_CASE_TITLE);
        }
        else
        {
            echo "Not find name <br>";
        }
        //отсекаем первую двойную кавычку в тексте
        $str1=mb_substr($str,2);
        if (preg_match("#\"(.+?)\;#is",$str1,$matches))
        {
            //var_dump($matches);
            $sizes=$matches[1];
            $sizes=explode("х",$sizes);
        }
        else
        {
            echo "Not find sizes <br>";
        }
        echo "Name=$name size_len=$sizes[0], size_width=$sizes[1] <br>";
		$arr['name']=$name;
		$arr['len']=$sizes[0];
		$arr['width']=$sizes[1];
		return $arr;
		
    }
    /**
     * @param $str
     * @return mixed
     */
    public function UTF8toCP1251($str)
	{ // by SiMM, $table from http://ru.wikipedia.org/wiki/CP1251
		static $table = array("\xD0\x81" => "\xA8", // Ё
			"\xD1\x91" => "\xB8", // ё
			// украинские символы
			"\xD0\x8E" => "\xA1", // Ў (У)
			"\xD1\x9E" => "\xA2", // ў (у)
			"\xD0\x84" => "\xAA", // Є (Э)
			"\xD0\x87" => "\xAF", // Ї (I..)
			"\xD0\x86" => "\xB2", // I (I)
			"\xD1\x96" => "\xB3", // i (i)
			"\xD1\x94" => "\xBA", // є (э)
			"\xD1\x97" => "\xBF", // ї (i..)
			// чувашские символы
			"\xD3\x90" => "\x8C", // &#1232; (А)
			"\xD3\x96" => "\x8D", // &#1238; (Е)
			"\xD2\xAA" => "\x8E", // &#1194; (С)
			"\xD3\xB2" => "\x8F", // &#1266; (У)
			"\xD3\x91" => "\x9C", // &#1233; (а)
			"\xD3\x97" => "\x9D", // &#1239; (е)
			"\xD2\xAB" => "\x9E", // &#1195; (с)
			"\xD3\xB3" => "\x9F", // &#1267; (у)
		);
		//цифровая магия
		$str = preg_replace('#([\xD0-\xD1])([\x80-\xBF])#se',
			'isset($table["$0"]) ? $table["$0"] :
							 chr(ord("$2")+("$1" == "\xD0" ? 0x30 : 0x70))
							',
			$str
		);
		$str = str_replace("i", "і", $str);
		$str = str_replace("I", "І", $str);
		return $str;
	}
    /**
     * @param $f_id
     */
    public function doLink($f_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$this->ReadFile();
		foreach ($this->data as $d)
		{
			
			$code1c=$d[0];
			$codePrice=$d[1];
			$arr=$this->parseVelam($code1c);
			$name=$arr['name'];
			$len=$arr['len'];
			$len.=0;
			$width=$arr['width'];
			$width.=0;
			//$name=iconv("UTF-8","CP-1251",$name);
			$name=$this->UTF8toCP1251($name);
			$codePrice=$this->UTF8toCP1251($codePrice);
			$query = "UPDATE goods SET goods_article_1c='$codePrice' WHERE goods_name like '%$name%' AND goods_length=$len AND goods_width=$width AND factory_id=$f_id";
			//$query="UPDATE goods SET goods_article_1c='$code1c' WHERE goods_article_link='$codePrice' AND factory_id=$f_id";
			mysqli_query($db_connect,$query);
            echo $query."<br>";
			//break;
		}
		//mysqli_close($db_connect);
	}
}
/**
 * Class MebelStar
 */
class MebelStar extends Link
{
    /**
     * @param $name
     * @return array
     */
    private function parseNameSite($name)
    {
        $name=str_replace("Шкаф-купе ","",$name);
        $name=str_replace("Угловой шкаф-купе ","",$name);
        if (mb_stripos($name," Уни"))
        {
            $name=str_replace(" Уни","",$name);
            $uni=true;
        }
        $name.="*";
        $sizes=explode("*",$name);
        if ($uni)
        {
            $sizes[3]=true;
        }
        return $sizes;
    }
    /**
     * @param $arr
     * @return string
     */
    private function generateNameSite($arr)
    {
        $name=$arr[0]."*".$arr[1]."*".$arr[2];
        if ($arr[3]==true)
        {
            $name.=" Уни";
        }
        return $name;
    }
    /**
     * @param $name
     * @return array
     */
    private function parseName1C($name)
    {
        $name.="*";
        if (mb_stripos($name," Уни"))
        {
            $name=str_replace(" Уни","",$name);
            $uni=true;
        }
        $sizes=explode("*",$name);
        if ($uni)
        {
            $sizes[3]=true;
        }
        return $sizes;
    }
    /**
     *
     */
    public function doLinkStar()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $this->ReadFile();
        foreach ($this->data as $pos)
        {
            $code1c=$pos[1];
            $name1c=$pos[0];
            $name1c_arr=$this->parseName1C($name1c);
            $name_site=$this->generateNameSite($name1c_arr);
			$code1c=$this->UTF8toCP1251($code1c);
			$name_site=$this->UTF8toCP1251($name_site);
			
            $query="UPDATE goods SET goods_article_1c='$code1c' WHERE goods_name like '%$name_site%' AND factory_id=184";
            mysqli_query($db_connect,$query);
            echo $query."<br>";
        }
        mysqli_close($db_connect);
    }
}
/**
 * Class Sonline
 */
class Sonline extends Link
{
    /**
     * @param $name1c
     * @return mixed
     */
    private function parseSonline($name1c)
    {
        $name1c.=";";
		if (preg_match("#\'(.+?)\'#is",$name1c,$matches))
        {
            //var_dump($matches);
            $name=$matches[1];
            $name=mb_strtolower($name);
            //$name=ucfirst($name);
            $name=mb_convert_case($name,MB_CASE_TITLE);
        }
        else
        {
            echo "Not find name <br>";
        }
        $str1=mb_substr($name1c,2);
        if (preg_match("#\'(.+?)\;#is",$str1,$matches))
        {
            //var_dump($matches);
            $size=$matches[1];
        }
        else
        {
            echo "Not find sizes <br>";
        }
        //echo "mane=$name size=$size<br>";
		$return['name']=$name;
		$return['size']=$size;
		//echo "<pre>";
		//print_r($return);
		//echo "</pre>";
		return $return;
    }
    /**
     *
     */
    public function doLinkSonline()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $this->ReadFile();
        foreach ($this->data as $d)
        {
            $name1c=$d[1];
			$code=$d[0];
            $pos=$this->parseSonline($name1c);
			//echo "<pre>";
			//print_r($pos);
			//echo "</pre>";
			$name=$pos['name'];
			//$code=$d[0];
			$size=$pos['size'];
			$this->setLink($name,$code,$size);
			
        }
        mysqli_close($db_connect);
    }
    /**
     * @param $name
     * @param $code1c
     * @param $size
     */
    private function setLink($name, $code1c, $size)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$code1c=$this->UTF8toCP1251($code1c);
		$name=$this->UTF8toCP1251($name);
		echo "size in link=$size<br>";
		if ($size==190)
		{
			$query = "UPDATE goods SET goods_article_1c='$code1c/70' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=1900 AND goods_width=700";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/80' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=1900 AND goods_width=800";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/90' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=1900 AND goods_width=900";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/120' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=1900 AND goods_width=1200";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/140' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=1900 AND goods_width=1400";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/150' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=1900 AND goods_width=1500";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/160' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=1900 AND goods_width=1600";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/180' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=1900 AND goods_width=1800";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
		}
		if ($size==200)
		{
			$query = "UPDATE goods SET goods_article_1c='$code1c/70' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=2000 AND goods_width=700";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/80' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=2000 AND goods_width=800";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/90' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=2000 AND goods_width=900";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/120' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=2000 AND goods_width=1200";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/140' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=2000 AND goods_width=1400";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/150' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=2000 AND goods_width=1500";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/160' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=2000 AND goods_width=1600";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
			
			$query = "UPDATE goods SET goods_article_1c='$code1c/180' WHERE goods_name like '%$name%' AND factory_id=63 AND goods_length=2000 AND goods_width=1800";
			mysqli_query($db_connect,$query);
			echo $query."<br>";
		}
        
        mysqli_query($db_connect,$query);
        echo $query."<br>";
        mysqli_close($db_connect);
	}
}
set_time_limit(9000);
$time_start = microtime(true);
//$test=new Link();
//$test->doLink(137);
//$test=new Rokko();
//$test->parseRoko();
//$test=new KomfMebSK();
//$test->parseMeb();
//$test=new Sonline("sonline.txt");
//$test->doLinkSonline();
//$test=new MebelStar("star.txt");
//$test->doLinkStar();
//$test=new Green("green-1.txt");
//$test->parseGreen();
//$test = new Novelty("novelty.txt");
//$test->parseNovelty();
//$test=new Tis("tis.txt");
//$test->parseTis();
//$test=new Nova("nova-2.txt");
//$test->parseNova();


$test=new Greid("greid.txt");
$test->parseGreid();
//$test=new Estella("estela.txt");
//$test->parseEstella();

//$test=new Miromark("miromark.txt");
//$test->parseMiromark();

$time_end = microtime(true);
$time = $time_end - $time_start;
echo "Runtime: $time sec<br>";
