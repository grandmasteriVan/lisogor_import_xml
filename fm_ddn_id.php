<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 18.07.17
 * Time: 16:42
 */
header('Content-Type: text/html; charset=utf-8');
//define ("host","localhost");
/**
 *
 */
define ("host","10.0.0.2");
/**
 * database username
 */
//define ("user", "root");
/**
 *
 */
define ("user", "uh333660_mebli");
/**
 * database password
 */
//define ("pass", "");
/**
 *
 */
define ("pass", "Z7A8JqUh");
/**
 * database name
 */
//define ("db", "mebli");
/**
 *
 */
define ("db", "uh333660_mebli");

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
        $query="SELECT goods_id FROM goods WHERE goods_id=$id AND factory_id=122 AND goods_maintcharter=9 AND goods_active=1 AND goods_noactual=0";
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
                $id=$item['goods_id'];
                $article_link=$item['goods_article_link'];
                foreach ($this->data as $d)
                {
                    $code1c=$d[0];
                    $codePrice=$d[1];
                    if ($article_link=$codePrice)
                    {
                        //пишем в базовую позицию
                        $this->writeCode1c($d,$code1c);
                        //теперь пишем и для детей тот же код
                        $childrens=$this->getChildrenByParent($id);
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
    public function ReadFile()
    {
        $handle=fopen("roko.txt","r");
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
//$test=new Link();
//$test->doLink(137);
//$test=new Rokko();
//$test->parseRoko();
$test=new KomfMebSK();
$test->parseMeb();
