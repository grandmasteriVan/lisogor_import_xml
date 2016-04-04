<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.04.16
 * Time: 09:37
 */

/** @var array $data */
$data= array();

/**
 * записывает полученные из XML значения в ассоциативный массив
 * @param $name string - название или id позиции в прайсе поставщика
 * @param $kat1 integer - цена за первую категорию или цена за товар
 * @param $kat2 integer - цена за втрую категорию
 * @param $kat3 integer - цена за третью категорию
 * @param $kat4 integer - цена за четвертую категорию
 * @param $kat5 integer - цена за пятую категорию
 * @param $kat6 integer - цена за шестую категорию
 * @param $kat7 integer - цена за седьмую категорию
 * @param $kat8 integer - цена за восьмую категорию
 * @param $kat9 integer - цена за девятую категорию
 * @param $kat10 integer - цена за десятую категорию
 */
function add_price($name, $kat1=0, $kat2=0, $kat3=0, $kat4=0, $kat5=0, $kat6=0, $kat7=0, $kat8=0, $kat9=0, $kat10=0)
{
    global $data;
    //echo "test!<br>";
    $data[]=array(
        'name'=>$name,
        'kat1'=>$kat1,
        'kat2'=>$kat2,
        'kat3'=>$kat3,
        'kat4'=>$kat4,
        'kat5'=>$kat5,
        'kat6'=>$kat6,
        'kat7'=>$kat7,
        'kat8'=>$kat8,
        'kat9'=>$kat9,
        'kat10'=>$kat10
    );
    //print_r($data);
}

/**
 *вынимает нужную информацию из XML в прайсе БРВ
 */
function parse_price_brw()
{
    if ($_FILES['file']['tmp_name'])
    {
        $dom=DOMDocument::load($_FILES['file']['tmp_name']);
        //print_r($dom);
        $rows=$dom->getElementsByTagName('Row');
        //print_r($rows);
        $row_num=1;
        //полезная инфа начинается с 5 строки!
        //если первая ячейка в строке - не цыфра, значит это название системы (goods.goods_article_link)
        //и ее цена находиться в в 6 ячейке строки
        //
        //если первая ячейка строки - цифра, то это элемент системы
        //3 ячейка в строке - это ее goods.goods_article_link (id товара в парйсе)
        //6 ячейка - цена
        foreach($rows as $row)
        {
            if ($row_num>=5)
            {
                $cells=$row->getElementsByTagName('Cell');
                $cell_num=1;
                $isModule=false;
                foreach ($cells as $cell)
                {
                    $elem=$cell->nodeValue;
                    //echo $cell_num." $elem<br>";

                    if (($cell_num==1)&&(!(intval($elem))))
                    {
                        $name=$elem;
                        $isModule=true;
                        //echo "enter NAME cel num:".$cell_num." $row_num <br>";
                    }

                    if (($isModule==false)and($cell_num==3))
                    {
                        $name=$elem;
                        //echo "enter ID cel num:".$cell_num."<br>";
                    }
                    if ($cell_num==6)
                    {
                        $price=$elem;
                        //echo "price=".$price."<br>";
                    }
                    $cell_num++;
                }
                //echo "name=".$name." price=".$price."<br>";
                add_price($name,$price);
            }
            $row_num++;
        }
    }
}
/**
 *вынимает нужную информацию из XML в прайсе Гербор
 */
function parse_price_gerbor()
{
    if ($_FILES['file']['tmp_name'])
    {
        $dom=DOMDocument::load($_FILES['file']['tmp_name']);
        //print_r($dom);
        $rows=$dom->getElementsByTagName('Row');
        //print_r($rows);
        $row_num=1;
        //полезная инфа начинается с 10 строки!
        //если вторая ячейка в строке - пустая, значит 3 ячейка это название системы (goods.goods_article_link)
        //и ее цена находиться в 6 ячейке строки
        //
        //если первая ячейка строки - цифра, то это элемент системы
        //4 ячейка в строке - это ее goods.goods_article_link (id товара в парйсе)
        //6 ячейка - цена
        foreach($rows as $row)
        {
            if ($row_num>=10)
            {
                $cells=$row->getElementsByTagName('Cell');
                $cell_num=1;
                $isModule=false;
                foreach ($cells as $cell)
                {
                    $elem=$cell->nodeValue;

                    if (($cell_num==2)and(empty($elem)))
                    {
                        $isModule=true;
                        //echo "enter NAME $row_num $cell_num $elem<br>";
                    }
                    if (($isModule==true)and($cell_num==3))
                    {
                        $name=$elem;
                    }
                    if (($isModule==false)and($cell_num==4))
                    {
                        $name=$elem;
                        //echo "enter ID $row_num $cell_num $elem<br>";
                    }
                    if($cell_num==6)
                    {
                        $price=$elem;
                    }
                    $cell_num++;
                }
                add_price($name,$price);
            }
            $row_num++;
        }
    }
}

/**
 * записывает информацию из ассоциативного массива с ценами в базу данных сайта
 * (id фабрики=56)
 * первым прогодом по массиву записываем цены составных компонентов
 * вторым проходом - считаем цену систем
 * @param $data1 - ассоциативный массив с данными, получеными из XML
 */
function add_db_brw_gerbor($data1)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    //print_r($data1);
    foreach ($data1 as $d)
    {
        if (intval($d['name']))
        {
            $name=$d['name'];
            //echo $name."<br>";
            $price=$d['kat1'];
            $strSQL="UPDATE goods ".
                "SET goods_price=$price ".
                "WHERE goods.goods_article_link= $name AND factory_id=56";
            //echo $strSQL."<br>";
            //break;
            mysqli_query($db_connect, $strSQL);
        }
        //break;
    }
    foreach ($data1 as $d)
    {
        if (!intval($d['name']))
        {
            //считаем цену позиции суммируя цены ее составляющих
            $name=$d['name'];
            //echo $name."<br>";
            $strSQL="SELECT SUM(goods_price) FROM goods WHERE goods_id IN(".
                "SELECT component_child FROM component WHERE component_in_complect=1 AND goods_id=(".
                "SELECT goods_id FROM goods WHERE goods_article_link='$name' AND factory_id=56))";
            echo $strSQL."<br>";
			if($res=mysqli_query($db_connect,$strSQL))
			{
				if (mysqli_num_rows($res) > 0)
				{
					echo "enter! <br>";
					$price = mysqli_fetch_assoc($res);
					foreach($price as $p)
					{
						$p1=$p;
					}
						
					echo "price=".$p1."<br>";
					//проставляем цену позиции
					$strSQL="UPDATE goods ".
					"SET goods_price=$p1 ".
					"WHERE goods.goods_article_link=$name AND factory_id=56";
					//echo $strSQL."<br>";
					//break;
					if (!is_null($p1))
					{
						mysqli_query($db_connect, $strSQL);
						echo "Yay! <br>";
					}
					
				}
			}
            //$price=mysqli_fetch_assoc($res);
			
            
        }
    }
    echo"End!";
}


?>