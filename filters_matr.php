<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 01.06.16
 * Time: 10:22
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
define ("db", "mebli");
//define ("db", "uh333660_mebli");


//TODO: сделать универсальный скрипт, для этого в зависимости от типа товара надо копировать нужнные фильтры
//Использовать абстрактный класс!!!


/**
 * @param $factory_id integer - айди фабрики
 * @param $goodskind integer - вид товара
 * @return array - массив, содержащий список всех родительских позиций
 * возвращает список всех родительских товаров, которые принадлежат к оной фабрике и типу товара
 */
function parrent_matr($factory_id, $goodskind)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_parent, goods_width FROM goods WHERE goodskind_id=$goodskind and goods_parent=0 AND factory_id=$factory_id";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $arr[] = $row;
        }
    }
    mysqli_close($db_connect);
    /*echo "<pre>";
	print_r ($arr);
	echo "</pre>";*/
	return $arr;
}

/**
 * @param $factory_id integer - айди фабрики
 * @param $goodskind integer - вид товара
 * @return array - массив, содержащий список всех позиций
 * возвращает список всех товаров, которые принадлежат к оной фабрике и типу товара
 * НЕ ИСПОЛЬЗУЕТСЯ!!!
 */
function all_matr($factory_id, $goodskind)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_parent, goods_width FROM goods WHERE goodskinfd_id=$goodskind AND factory_id=$factory_id";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $arr[] = $row;
        }
    }
    mysqli_close($db_connect);
    return $arr;
}

/**
 * @param $factory_id integer - айди фабрики
 * @param $goodskind integer - вид товара
 * @return array - массив, содержащий список дочерних позиций
 * возвращает список всех дочерних товаров, которые принадлежат к оной фабрике и типу товара
 */
function mod_matr($factory_id, $goodskind)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods_id, goods_parent, goods_width FROM goods WHERE goodskind_id=$goodskind AND goods_parent<>0 AND factory_id=$factory_id";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $arr[] = $row;
        }
    }
    mysqli_close($db_connect);
    return $arr;
}

/**
 * @param $f_id integer - айди фабрики
 * @param $goodskind integer - вид товара
 * перезаписывает фильтры дочерних товаров беря за основу фильтры родителя
 */
function copy_filters($f_id, $goodskind)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $parent_list=parrent_matr($f_id, $goodskind);
    $mod_list=mod_matr($f_id, $goodskind);
    foreach ($parent_list as $parent)
    {
        //выбираем список фич для родительского матраса
        $parrent_id=$parent['goods_id'];
        $query="SELECT * FROM goodshasfeature WHERE goods_id=$parrent_id";
		//echo $query."<br>";
        if ($res=mysqli_query($db_connect,$query))
        {
            //не забываем обнулять список перед заполнением!
			$features=null;
			while ($row=mysqli_fetch_assoc($res))
            {
                $features[]=$row;
            }
			print_r($features);
			/*print_r($features);
			*/
        }
        foreach($mod_list as $mod)
        {
            if ($parent['goods_id']==$mod['goods_parent'])
            {
                $mod_id=$mod['goods_id'];
				$mod_size=$mod['goods_width'];
				echo "<br><b>$mod_size</b><br>";
                //дропаем старые записи
                $query="DELETE FROM goodshasfeature WHERE goods_id=$mod_id";
                mysqli_query($db_connect,$query);
				echo $query."<br>";
                //для каждой фичи записываем ее в БД
                foreach ($features as $feat)
                {
                    $goodshasfeature_valueint=$feat['goodshasfeature_valueint'];
                    $goodshasfeature_valuefloat=$feat['goodshasfeature_valuefloat'];
                    $goodshasfeature_valuetext=$feat['goodshasfeature_valuetext'];
                    $feature_id=$feat['feature_id'];
					//нишем размерность (одно/полтора/двуспальные)
					if ($feature_id==131)
					{
						if ($mod_size<=900)
						{
							$goodshasfeature_valueint=1;
						}
						if ($mod_size>900&&$mod_size<=1500)
						{
							$goodshasfeature_valueint=2;
						}
						if ($mod_size>1500)
						{
							$goodshasfeature_valueint=3;
						}
					}
					//есть только одна особенность!
					if ($feature_id==56)
					{
						if ($goodshasfeature_valueint!=14)
						{
							continue;
						}
					}
                    //меняем кодировку текстового занчения фильтра
                    if ($feature_id==127)
                    {
                        $goodshasfeature_valuetext=UTF8toCP1251($goodshasfeature_valuetext);
                    }
					//не пишем ненужные значния
					if ($feature_id==131||$feature_id==127||$feature_id==128||$feature_id==33||$feature_id==52||$feature_id==53||$feature_id==54||$feature_id==55||$feature_id==56||$feature_id==130)
					{
						$query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
							"goodshasfeature_valuetext, goods_id, feature_id) ".
							"VALUES ($goodshasfeature_valueint, $goodshasfeature_valuefloat, ".
							"$goodshasfeature_valuetext, $mod_id, $feature_id)";
						mysqli_query($db_connect,$query);
						echo $query."<br>";
					}
                    
                }
            }
        }
    }
}

set_time_limit(300);
//35 - come-for 40 - матрасы
copy_filters(35, 40);



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
