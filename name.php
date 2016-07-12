<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 07.07.16
 * Time: 15:44
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
 * @param $goods_kind integer айди типа товара
 * в зависимоти от типа товара меняет имена товаров по необходимой маске
 */
function rename_tov ($goods_kind)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_name FROM goods WHERE goodskind_id=$goods_kind";
	$i=1;
    if ($res=mysqli_query($db_connect,$query))
    {
        //формируем список имен позиций
        while ($row = mysqli_fetch_assoc($res))
        {
            $tovars[] = $row;
        }
        //проверяем есть ли название типа мебели в названии товара
        foreach ($tovars as $tovar)
        {
            $name=$tovar['goods_name'];
            $id=$tovar['goods_id'];
            //кровати
			if ($goods_kind==39||$goods_kind==74)
			{
				$name=str_replace(UTF8toCP1251("Кровать"),"",$name);
				$name=str_replace(UTF8toCP1251("кровать"),"",$name);
				$name="Кровать ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//детские кровати
			if ($goods_kind==50)
			{
				$name=str_replace(UTF8toCP1251("Кровать"),"",$name);
				$name=str_replace(UTF8toCP1251("кровать"),"",$name);
				$name=str_replace(UTF8toCP1251("детская"),"",$name);
				$name=str_replace(UTF8toCP1251("Детская"),"",$name);
				$name="Детская кровать ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//прихожие
			if ($goods_kind==30)
			{
				$name=str_replace(UTF8toCP1251("Прихожая"),"",$name);
				$name=str_replace(UTF8toCP1251("прихожая"),"",$name);
				
				$name="Прихожая ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//спальни
			if ($goods_kind==29)
			{
				$name=str_replace(UTF8toCP1251("Спальня"),"",$name);
				$name=str_replace(UTF8toCP1251("спальня"),"",$name);
				$name="Спальня ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//дверь входная
			if ($goods_kind==108)
			{
				$name=str_replace(UTF8toCP1251("Дверь"),"",$name);
				$name=str_replace(UTF8toCP1251("дверь"),"",$name);
				$name=str_replace(UTF8toCP1251("Входная"),"",$name);
				$name=str_replace(UTF8toCP1251("входная"),"",$name);
				$name="Входная дверь ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//дверь межкомнатная
			if ($goods_kind==81)
			{
				$name=str_replace(UTF8toCP1251("Дверь"),"",$name);
				$name=str_replace(UTF8toCP1251("дверь"),"",$name);
				$name=str_replace(UTF8toCP1251("Межкомнатная"),"",$name);
				$name=str_replace(UTF8toCP1251("межкомнатная"),"",$name);
				$name="Дверь межкомнатная ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//матрас
			if ($goods_kind==40)
			{
				$name=str_replace(UTF8toCP1251("Матрас"),"",$name);
				$name=str_replace(UTF8toCP1251("матрас"),"",$name);
				$name="Матрас ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			$i++;
        }
    }
    mysqli_close($db_connect);
}

/**
 * @param $goods_kind integer айди товара
 * печатает список всех товаров, которые имеют определенный тип
 */
function print_names ($goods_kind)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_name FROM goods WHERE goodskind_id=$goods_kind";
    if ($res=mysqli_query($db_connect,$query))
    {
        //формируем список имен позиций
        while ($row = mysqli_fetch_assoc($res))
        {
            echo $row['goods_name']."<br>";
        }
    }
    mysqli_close($db_connect);
}

//rename_tov(39);//кровати
//rename_tov(50);//детские кровати
//rename_tov(74);//еще кровати
//rename_tov(108);//входная дверь
//rename_tov(81);//межклмнатная дверь
//rename_tov(40);//матрас
//rename_tov(30);//прихожая
rename_tov(29);//спальня

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
?>
