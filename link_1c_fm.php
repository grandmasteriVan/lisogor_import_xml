<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 18.07.17
 * Time: 16:42
 */
header('Content-Type: text/html; charset=utf-8');
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
class Link
{
    private $data;
    private function ReadFile()
    {
        $handle=fopen("oris-1.txt","r");
        while (!feof($handle))
        {
            $str=fgets($handle);
			$str=explode(";",$str);
			$arr[]=$str;
        }
        if (!empty($arr))
        {
            $this->data = $arr;
        }
    }
    
	function UTF8toCP1251($str)
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
	
	public function printData()
    {
        $this->ReadFile();
		//var_dump($this->data);
		echo "<pre>";
		print_r($this->data);
		echo "</pre>";
    }
	
	public function doLink($f_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$this->ReadFile();
		foreach ($this->data as $d)
		{
			$code1c=trim(iconv('windows-1251', 'utf-8', $d[0]));
			//$codePrice=$d[1];
			$codePrice=trim(iconv('windows-1251', 'utf-8', $d[1]))
			//$code1c=$this->UTF8toCP1251($code1c);
			//echo "$code1c - $codePrice<br>";
			$query="UPDATE goods SET goods_article_1c='$code1c' WHERE goods_article_link='$codePrice' AND factory_id=$f_id";
			mysqli_query($db_connect,$query);
            echo $query."<br>";
		}
		mysqli_close($db_connect);
	}
}

$test=new Link();
$test->doLink(151);
