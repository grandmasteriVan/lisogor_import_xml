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
        $handle=fopen("sleep_and_fly.txt","r");
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
			
			$code1c=$d[0];
			//$codePrice=$d[1];
			//$code1c=trim(iconv('windows-1251', 'utf-8', $d[0]));
			$codePrice=trim(iconv('windows-1251', 'utf-8', $d[1]));
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
$test->doLink(124);
