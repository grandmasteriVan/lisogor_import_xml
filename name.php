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
 * @param $kat_id integer айди главнй категории товара
 * в зависимоти от главной категории товара меняет имена товаров по необходимой маске
 */
function ren_tov_cat($kat_id)
{
    $time_start = microtime(true);
	$db_connect=mysqli_connect(host,user,pass,db);
	$query="SELECT goods_id, goods_name FROM goods WHERE goods_maintcharter=$kat_id";
	$i=1;
	if ($res=mysqli_query($db_connect,$query))
	{
		while ($row = mysqli_fetch_assoc($res))
        {
            $tovars[] = $row;
        }
		foreach ($tovars as $tovar)
		{
			$name=$tovar['goods_name'];
            $id=$tovar['goods_id'];
			//кресла
			if ($kat_id==2)
			{
				$name=str_replace(UTF8toCP1251("Кресло"),"",$name);
				$name=str_replace(UTF8toCP1251("кресло"),"",$name);
				$name="Кресло ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
			}
			//шкафы
			if ($kat_id==10)
			{
				$name=str_replace(UTF8toCP1251("Шкаф"),"",$name);
				$name=str_replace(UTF8toCP1251("шкаф"),"",$name);
				$name="Шкаф ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
			}
			//полки
			if ($kat_id==11)
			{
				$name=str_replace(UTF8toCP1251("Полка"),"",$name);
				$name=str_replace(UTF8toCP1251("полка"),"",$name);
				$name="Полка ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
			}
			//бескаркасная мебель
			if ($kat_id==36)
			{
				$name=str_replace(UTF8toCP1251("Кресло"),"",$name);
				$name=str_replace(UTF8toCP1251("кресло"),"",$name);
				$name="Бескаркасное кресло ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
			}
            //кухонные уголки
            if ($kat_id==18||$kat_id==68)
            {
                $name=str_replace(UTF8toCP1251("Кухонный"),"",$name);
                $name=str_replace(UTF8toCP1251("кухонный"),"",$name);
                $name=str_replace(UTF8toCP1251("Уголок"),"",$name);
                $name=str_replace(UTF8toCP1251("уголок"),"",$name);
                $name=str_replace(UTF8toCP1251("угол"),"",$name);
                $name=str_replace(UTF8toCP1251("Угол"),"",$name);
                $name="Кухонный уголок ".$name;
                $name=UTF8toCP1251($name);
                $query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
            }
            //модульные кухни
            if ($kat_id==57)
            {
                $name=str_replace(UTF8toCP1251("Кухня"),"",$name);
                $name=str_replace(UTF8toCP1251("кухня"),"",$name);
                $name="Кухня ".$name;
                $name=UTF8toCP1251($name);
                $query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
            }
            //парты
            if ($kat_id==63)
            {
                $name=str_replace(UTF8toCP1251("Парта"),"",$name);
                $name=str_replace(UTF8toCP1251("парта"),"",$name);
                $name=str_replace(UTF8toCP1251("детская"),"",$name);
                $name=str_replace(UTF8toCP1251("Детская"),"",$name);
                $name="Детская парта ".$name;
                $name=UTF8toCP1251($name);
                $query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
            }
            //детский диван
            if ($kat_id==17)
            {
                $name=str_replace(UTF8toCP1251("Диван"),"",$name);
                $name=str_replace(UTF8toCP1251("диван"),"",$name);
                $name=str_replace(UTF8toCP1251("детский"),"",$name);
                $name=str_replace(UTF8toCP1251("Детский"),"",$name);
                $name="Детский диван ".$name;
                $name=UTF8toCP1251($name);
                $query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
            }
            //детский шкаф
            if ($kat_id==74)
            {
                $name=str_replace(UTF8toCP1251("Шкаф"),"",$name);
                $name=str_replace(UTF8toCP1251("шкаф"),"",$name);
                $name=str_replace(UTF8toCP1251("детский"),"",$name);
                $name=str_replace(UTF8toCP1251("Детский"),"",$name);
                $name="Детский шкаф ".$name;
                $name=UTF8toCP1251($name);
                $query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
            }
            //детские комнаты
            if ($kat_id==16)
            {
                $name=str_replace(UTF8toCP1251("Комната"),"",$name);
                $name=str_replace(UTF8toCP1251("комната"),"",$name);
                $name=str_replace(UTF8toCP1251("детская"),"",$name);
                $name=str_replace(UTF8toCP1251("Детская"),"",$name);
                $name="Детская комната ".$name;
                $name=UTF8toCP1251($name);
                $query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
            }
            //детские комоды
            if ($kat_id==32)
            {
                $name=str_replace(UTF8toCP1251("Комод"),"",$name);
                $name=str_replace(UTF8toCP1251("комод"),"",$name);
                $name=str_replace(UTF8toCP1251("детский"),"",$name);
                $name=str_replace(UTF8toCP1251("Детский"),"",$name);
                $name="Детский комод ".$name;
                $name=UTF8toCP1251($name);
                $query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                echo $i.". ".$query."<br>";
            }
			$i++;
		}
	}
	mysqli_close($db_connect);
    $time_end = microtime(true);
    $time = $time_end - $time_start;

    echo "Runtime: $time секунд\n";
}
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
			//комоды
			if ($goods_kind==38)
			{
				$name=str_replace(UTF8toCP1251("Комод "),"",$name);
				$name=str_replace(UTF8toCP1251("комод "),"",$name);
				$name="Комод ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//столы компьюторные
			if ($goods_kind==32)
			{
				$name=str_replace(UTF8toCP1251("Стол "),"",$name);
				$name=str_replace(UTF8toCP1251("стол "),"",$name);
				$name="Стол ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//столы журнальные
			if ($goods_kind==33||$goods_kind==71)
			{
				$name=str_replace(UTF8toCP1251("Стол "),"",$name);
				$name=str_replace(UTF8toCP1251("стол "),"",$name);
				$name=str_replace(UTF8toCP1251("Столик "),"",$name);
				$name=str_replace(UTF8toCP1251("столик "),"",$name);
				$name=str_replace(UTF8toCP1251("Журнальный "),"",$name);
				$name=str_replace(UTF8toCP1251("журнальный "),"",$name);
				$name="Журнальный столик ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//столы письменные
			if ($goods_kind==34)
			{
				$name=str_replace(UTF8toCP1251("Стол "),"",$name);
				$name=str_replace(UTF8toCP1251("стол "),"",$name);
				$name=str_replace(UTF8toCP1251("Письменный "),"",$name);
				$name=str_replace(UTF8toCP1251("письменный  "),"",$name);
				$name="Стол ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//столы обеденные
			if ($goods_kind==109)
			{
				$name=str_replace(UTF8toCP1251("Стол "),"",$name);
				$name=str_replace(UTF8toCP1251("стол "),"",$name);
				$name=str_replace(UTF8toCP1251("Обеденный "),"",$name);
				$name=str_replace(UTF8toCP1251("обеденный  "),"",$name);
				$name="Стол ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//тумбы для обуви
			if ($goods_kind==43)
			{
				$name=str_replace(UTF8toCP1251("Тумба "),"",$name);
				$name=str_replace(UTF8toCP1251("тумба "),"",$name);
				$name=str_replace(UTF8toCP1251("для обуви "),"",$name);
				$name=str_replace(UTF8toCP1251("обувная  "),"",$name);
				$name=str_replace(UTF8toCP1251("Обувная  "),"",$name);
				$name="Тумба ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//тумбы прикроватные
			if ($goods_kind==64)
			{
				$name=str_replace(UTF8toCP1251("Тумба "),"",$name);
				$name=str_replace(UTF8toCP1251("тумба "),"",$name);
				$name=str_replace(UTF8toCP1251("прикроватная "),"",$name);
				$name=str_replace(UTF8toCP1251("Прикроватная  "),"",$name);
				$name="Тумба ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//тумбы под тв
			if ($goods_kind==41)
			{
				$name=str_replace(UTF8toCP1251("Тумба "),"",$name);
				$name=str_replace(UTF8toCP1251("тумба "),"",$name);
				$name=str_replace(UTF8toCP1251("ТВ "),"",$name);
				$name=str_replace(UTF8toCP1251("тв  "),"",$name);
				$name=str_replace(UTF8toCP1251("Телевизор "),"",$name);
				$name=str_replace(UTF8toCP1251("телевизор  "),"",$name);
				$name="Тумба ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//туалетные столики
			if ($goods_kind==80)
			{
				$name=str_replace(UTF8toCP1251("Стол "),"",$name);
				$name=str_replace(UTF8toCP1251("стол "),"",$name);
				$name=str_replace(UTF8toCP1251("Столик "),"",$name);
				$name=str_replace(UTF8toCP1251("столик  "),"",$name);
				$name=str_replace(UTF8toCP1251("Туалетный "),"",$name);
				$name=str_replace(UTF8toCP1251("туалетный  "),"",$name);
				$name="Стол ".$name;
				$name=UTF8toCP1251($name);
				$query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
				mysqli_query($db_connect,$query);
				echo $i.". ".$query."<br>";
				//return;
			}
			//столы рабочие
			if ($goods_kind==65)
			{
				$name=str_replace(UTF8toCP1251("Стол "),"",$name);
				$name=str_replace(UTF8toCP1251("стол "),"",$name);
				$name=str_replace(UTF8toCP1251("Столик "),"",$name);
				$name=str_replace(UTF8toCP1251("столик  "),"",$name);
				$name="Стол ".$name;
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
//переименования по типу товара
//rename_tov(39);//кровати
//rename_tov(50);//детские кровати
//rename_tov(74);//еще кровати
//rename_tov(108);//входная дверь
//rename_tov(81);//межклмнатная дверь
//rename_tov(40);//матрас
//rename_tov(30);//прихожая
//rename_tov(29);//спальня
//rename_tov(38);//комоды
//rename_tov(32);//столы компьюторные
//rename_tov(33);//столы журнальные
//rename_tov(71);//столы журнальные
//rename_tov(41);//тумбы под ТВ
//rename_tov(34);//столы письменные
//rename_tov(109);//столы обеденные
//rename_tov(43);//тумбы для обуви
//rename_tov(64);//тумбы для обуви
//rename_tov(80);//туалетные столики
//rename_tov(65);//столы рабочие
//переименование по разделу каталога
//ren_tov_cat(2);//кресла 
//ren_tov_cat(10);//шкафы
//ren_tov_cat(11);//полки
//ren_tov_cat(36);//бескаркасная мебель
//ren_tov_cat(18);//Кухонные уголки
//ren_tov_cat(68);//Кухонные уголки
//ren_tov_cat(57);//кухни модульные
//ren_tov_cat(63);//парты
ren_tov_cat(17);//детский диван
//ren_tov_cat(74);//детский шкаф
//ren_tov_cat(16);//детская комната
ren_tov_cat(32);//детский комод

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
