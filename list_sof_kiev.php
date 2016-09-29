<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 15.09.16
 * Time: 14:48
 */
/**
 * database host
 */
define ("host","localhost");
//define ("host","10.0.0.2");
/**
 * database username
 */
define ("user", "root");
//define ("user", "uh333660_mebli");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "Z7A8JqUh");
/**
 * database name
 */
define ("db", "ddn");
//define ("db", "uh333660_mebli");
/**
 *копирует отзывы со старых диванов Софиевки в новые (фабрика Киев)
 * копируются лишь те отзывы, где в тексте не упоминается старое название дивана
 */
function list_sof()
{
    //сначала мы выбираем все диваны фабрики софиевка
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM divan WHERE factory_id=4";
    if ($res=mysqli_query($db_connect,$query))
    {
        unset ($divs_sof);
		while ($row = mysqli_fetch_assoc($res))
        {
            //список всех диванв софиевки
            $divs_sof[] = $row;
        }
		echo "<pre>";
		//print_r($divs_sof);
		echo "</pre>";
        foreach ($divs_sof as $div_sof)
        {
            //находим все отзвывы к конкретному дивану
            $id_sof=$div_sof['divan_id'];
            $name_sof=$div_sof['divan_name'];
            $url_sof=$div_sof['divan_url'];
			$url_sof=UTF8toCP1251($url_sof);
            $query="SELECT * FROM divan WHERE divan_name_manager='$name_sof' AND factory_id=29";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset ($div_kiev);
				while ($row = mysqli_fetch_assoc($res))
                {
                    //все отзывы по конкретному дивану
                    $div_kiev[] = $row;
                }
				echo "<pre>";
				//print_r($div_kiev);
				echo "</pre>";
                if (is_array($div_kiev))
                {
                    foreach ($div_kiev as $div_new)
                    {
                        $name_new=$div_new['divan_name'];
                        $url_new=$div_new['divan_url'];
						$url_new=UTF8toCP1251($url_new);
                        $str= "divani.kiev.ua/$url_sof.html; divani.kiev.ua/$url_new.html".PHP_EOL;
						file_put_contents("list_dn.csv", $str, FILE_APPEND);
                    }
                }
				
            }
        }
    }
	file_put_contents("list_dn.csv", "AKCIA;AKCIA".PHP_EOL, FILE_APPEND);
	//акция
	$query="SELECT * FROM divan WHERE factory_id=18";
    if ($res=mysqli_query($db_connect,$query))
    {
        unset ($divs_sof);
		while ($row = mysqli_fetch_assoc($res))
        {
            //список всех диванв софиевки
            $divs_sof[] = $row;
        }
		echo "<pre>";
		//print_r($divs_sof);
		echo "</pre>";
        foreach ($divs_sof as $div_sof)
        {
            //находим все отзвывы к конкретному дивану
            $id_sof=$div_sof['divan_id'];
            $name_sof=$div_sof['divan_name'];
            $url_sof=$div_sof['divan_url'];
			$url_sof=UTF8toCP1251($url_sof);
			//echo $div_sof['divan_name_manager']."<br>";
            $query="SELECT * FROM divan WHERE divan_name_manager='$name_sof' AND factory_id=18";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset ($div_kiev);
				while ($row = mysqli_fetch_assoc($res))
                {
                    //все отзывы по конкретному дивану
                    $div_kiev[] = $row;
                }
				echo "<pre>";
				//print_r($div_kiev);
				echo "</pre>";
                if (is_array($div_kiev))
                {
                    foreach ($div_kiev as $div_new)
                    {
                        $name_new=$div_new['divan_name'];
                        $url_new=$div_new['divan_url'];
						$url_new=UTF8toCP1251($url_new);
                        $str= "divani.kiev.ua/$url_sof.html; divani.kiev.ua/$url_new.html".PHP_EOL;
						file_put_contents("list_dn.csv", $str, FILE_APPEND);
                    }
                }
				
            }
        }
    }
	
    mysqli_close($db_connect);
}
$runtime = new Timer();
$runtime->setStartTime();
list_sof();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
/**
 * Class Timer
 * замеряем время выполнения скрипта
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
        return $this->start_time-$this->end_time;
    }
}
/**
 * функция преобразовывает строку в кодировке  UTF-8 в строку в кодировке CP1251
 * @param $str string входящяя строка в кодировке UTF-8
 * @return string строка перобразованная в кодировку CP1251
 */
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
/*function copy_files($source, $res, $id)
{ 
	mkdir($res."/", 0777);
    $hendle = opendir($source); // открываем директорию 
    while ($file = readdir($hendle)) { 
        if (($file!=".")&&($file!="..")) { 
            if (is_dir($source."/".$file) == true) { 
                if(is_dir($res."/".$file)!=true) // существует ли папка 
                    mkdir($res."/".$file, 0777); // создаю папку 
                    copy_files ($source."/".$file, $res."/".$file); 
            } 
            else{ 
                if(!copy($source."/".$file, $res."/".$file."_$id")) {  
                    print ("при копировании файла $file произошла ошибка...<br>\n");  
                }// end if copy 
            }  
        } // else $file == .. 
    } // end while 
    closedir($hendle); 
}*/
?>
