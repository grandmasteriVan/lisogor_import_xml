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
        $handle=fopen("valam.txt","r");
        while (!feof($handle))
        {
            $str=fgets($handle);
			$str=explode(";",$str);
			//для парсинга Велам, закоментить при обычном файлке!
			$str[0].=";";
			$arr[]=$str;
        }
        if (!empty($arr))
        {
            $this->data = $arr;
        }
    }
    
	public function printData()
    {
        $this->ReadFile();
		//var_dump($this->data);
		echo "<pre>";
		print_r($this->data);
		echo "</pre>";
    }
	private function parceVelam($str)
    {
        //название
        if (preg_match("#\"(.+?)\"#is",$str,$matches))
        {
            //var_dump($matches);
            $name=$matches[1];
            $name=strtolower($name);
        }
        else
        {
            echo "Not find name <br>";
        }
        //отсекаем первую двойную кавычку в тексте
        $str=mb_substr($str,1);
        if (preg_match("#\"(.+?)\;#is",$str,$matches))
        {
            //var_dump($matches);
            $sizes=$matches[1];
            $sizes=explode("x",$sizes);
        }
        else
        {
            echo "Not find sizes <br>";
        }
        echo "Name=$name size_len=$sizes[0], size_width=$sizes[1] <br>";

    }
	public function doLink($f_id)
	{
		//$db_connect=mysqli_connect(host,user,pass,db);
		$this->ReadFile();
		foreach ($this->data as $d)
		{
			
			$code1c=$d[0];
			$codePrice=$d[1];
			$this->parceVelam($code1c);
			//$query="UPDATE goods SET goods_article_1c='$code1c' WHERE goods_article_link='$codePrice' AND factory_id=$f_id";
			//mysqli_query($db_connect,$query);
            //echo $query."<br>";
		}
		mysqli_close($db_connect);
	}
}

$test=new Link();
$test->doLink(124);
