<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 06.02.17
 * Time: 17:13
 */
//header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
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
/**
 * Class comfMebPlus
 * проставляет цену за размеры шкафов big (+10% к такому же шкафу с размером small)
 */
class comfMebPlus
{
    /**
     * выбирает все шкафы заданного размер по высоте
     * @param $size int - размер шкафа
     * @return array|null - массив, содержащий все шкафы данного размера
     */
    private function selectSize($size)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT * FROM goods WHERE goods_height=$size AND factory_id=122 AND goods_active=1 AND goods_noactual=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            mysqli_close($db_connect);
            return $goods;
        }
        else
        {
            mysqli_close($db_connect);
            return null;
        }
    }
    /**
     *для каждого шкафа высотой small находим соответствующий ему (по имени) шкаф высотой big
     * и для такого шкафа ставим цену на 10% выше.
     */
    public function makePlus()
    {
		$goods_small=$this->selectSize(2350);
        $goods_big=$this->selectSize(2500);
		//var_dump ($goods_big);
        if (is_array($goods_small))
        {
            foreach ($goods_small as $good_small)
            {
                $depth_small=$good_small['goods_depth'];
                $width_small=$good_small['goods_width'];
                $name_small=$good_small['goods_name'];
				$name_small=$this->UTF8toCP1251($name_small);
                $name_small_sub=substr($name_small,0,15);
                $price=$good_small['goods_price'];
				//echo "$name_small_sub <br>";
				//echo "$name_small | $name_small_sub<br> ";
                if (is_array($goods_big))
                {
                    foreach ($goods_big as $good_big)
                    {
                        $depth_big=$good_big['goods_depth'];
                        $width_big=$good_big['goods_width'];
                        $name_big=$good_big['goods_name'];
						$name_big=$this->UTF8toCP1251($name_big);
                        $name_big_sub=substr($name_big,0,15);
						//echo "$name_big <br>";
                        $id=$good_big['goods_id'];
                        if (($depth_small==$depth_big)&&($width_small==$width_big)&&(!strcmp($name_small_sub,$name_big_sub)))
                        {
                            $this->changePrice($price,$id);
                        }
						else
						{
							//echo "$name_small_sub | $name_big_sub<br> ";
						}
                    }
                }
            }
        }
		else
		{
			echo "no small array!";
		}
        /*if (is_array($goods_small))
        {
            foreach ($goods_small as $good_small)
            {
                $name_small=$good_small['goods_name'];
				//echo $name_small." len=".strlen($name_small)."<br>";
				if (strlen($name_small)<=42)
				{
					$name_small_sub=substr($name_small,0,-4);
					//echo $name_small_sub."<br>";
				}
				else
				{
					$name_small_sub=substr($name_small,0,-11);
					//if (
					//echo $name_small_sub."<br>";
				}
                if (is_array($goods_big))
                {
                    foreach ($goods_big as $good_big)
                    {
                        $name_big=$good_big['goods_name'];
						if (strlen($name_big)<=42)
						{
							$name_big_sub=substr($name_big,0,-4);
						}
						else
						{
							$name_big_sub=substr($name_big,0,-11);
						}
						
                        if ($name_small_sub==$name_big_sub)
                        {
                            //меняем цены!
                            //отправляем цену товара за small размер и ид товара big размера
                            $this->changePrice($good_small['goods_price'],$good_big['goods_id']);
                        }
                    }
                }
            }
        }*/
    }
    /**
     * записывает изменение цен в базу данных
     * @param $price  int - цена за шкаф, высотой в small
     * @param $good_id int - ид шкафа высотой big
     */
    private function changePrice($price, $good_id)
    {
        $new_price=round($price*1,1);
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_price=$new_price WHERE goods_id=$good_id";
        mysqli_query($db_connect,$query);
        echo "$query<br>";
        mysqli_close($db_connect);
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
}
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

$runtime = new Timer();
$runtime->setStartTime();
$test=new comfMebPlus();
$test->makePlus();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
