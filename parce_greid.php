<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 20.08.18
 * Time: 09:30
 */
 
header('Content-Type: text/html; charset=utf-8');

class ParseGreid
{
	public $file1;
	 
	function __construct($f)
	{
		if ($f)
		{
			$this->file1=$f;
		}
            
	}
	
	public function parceXml()
	{
		if ($this->file1)
		{
			$dom = DOMDocument::load($this->file1);
			//var_dump($dom);
            $rows = $dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num = 1;
			foreach ($rows as $row)
			{
				if ($row_num>=1150)
				{
					$cells=$row->getElementsByTagName('Cell');
					$cell_num=1;
					foreach ($cells as $cell)
					{
						//echo "$cell->nodeValue is $cell_num<br>";
						$elem=$cell->nodeValue;
						if ($cell_num==2)
						{
							$name=$elem;
							$name_tmp=str_replace(" топ модель","",$name);
							$name_tmp=str_replace(" боковина","",$name_tmp);
							$name_tmp=str_replace(" лівий","",$name_tmp);
							$name_tmp=str_replace(" правий","",$name_tmp);
							$name_tmp=str_replace(" н/с","",$name_tmp);
							$name_tmp=str_replace("Зразок","",$name_tmp);
							
						}
						$cell_num++;
					}
					if (is_string($name_tmp))
					{
						$short_string=substr($name_tmp,-7);
						if (strripos($name," боковина"))
						{
							$short_string.=" боковина";
						}
						if (strripos($name," лівий"))
						{
							$short_string.=" лівий";
						}
						if (strripos($name," правий"))
						{
							$short_string.=" правий";
						}
						if (strripos($name," н/с"))
						{
							$short_string.=" н/с";
						}
						if (strripos($name,"Зразок"))
						{
							$short_string.=" Зразок";
						}
						echo "$name - $short_string<br>";
						$file="$name".";"."$short_string".PHP_EOL;
						file_put_contents("greid.csv",$file,FILE_APPEND);
					}
				}
				$row_num++;
			}
			
		}
		else
		{
			echo "No file!<br>";
		}
	 }
}

$test = new ParseGreid("001.08.18.xml");
$test->parceXml();