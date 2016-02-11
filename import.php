<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 01.02.16
 * Time: 10:18
 */
$data=array();

/**
 * записывает полученные из XML значения в ассоциативный массив
 * @param $name - название дивана в прайсе поставщика
 * @param $kat1 - цена за первую категорию
 * @param $kat2 - цена за втрую категорию
 * @param $kat3 - цена за третью категорию
 * @param $kat4 - цена за четвертую категорию
 * @param $kat5 - цена за пятую категорию
 * @param $kat6 - цена за шестую категорию
 * @param $kat7 - цена за седьмую категорию
 * @param $kat8 - цена за восьмую категорию
 * @param $kat9 - цена за девятую категорию
 * @param $kat10 - цена за десятую категорию
 */
function add_price($name, $kat1=0, $kat2=0, $kat3=0, $kat4=0, $kat5=0, $kat6=0, $kat7=0, $kat8=0, $kat9=0, $kat10=0)
{
    global $data;

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
                foreach ($cells as $cell)
                {
                    $elem=$cell->nodeValue;
                    $isModule=false;
                    if (($cell_num==1)&&(is_string($elem)))
                    {
                        $name=$elem;
                        $isModule=true;
                    }
                    if ((!$isModule)&&($cell_num==3))
                    {
                        $name=$elem;
                    }
                    if ($cell_num=6)
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
        //если вторая ячейка в строке - пустая, значит это название системы (goods.goods_article_link)
        //и ее цена находиться в 8 ячейке строки
        //
        //если первая ячейка строки - цифра, то это элемент системы
        //6 ячейка в строке - это ее goods.goods_article_link (id товара в парйсе)
        //8 ячейка - цена
        foreach($rows as $row)
        {
            if ($row_num>=10)
            {
                $cells=$row->getElementsByTagName('Cell');
                $cell_num=1;
                foreach ($cells as $cell)
                {
                    $elem=$cell->nodeValue;
                    $isModule=false;
                    if (($cell_num==2)&&(empty($elem)))
                    {
                        $isModule=true;
                    }
                    if (($isModule)&&($cell_num==3))
                    {
                        $name=$elem;
                    }
                    if ((!$isModule)&&($cell_num==6))
                    {
                        $name=$elem;
                    }
                    if($cell_num==8)
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
 *вынимает нужную информацию из XML в прайсе Лисогор
 */
function parse_price_lisogor()
{
    if ($_FILES['file']['tmp_name'])
    {
        $dom=DOMDocument::load($_FILES['file']['tmp_name']);
        //print_r($dom);
        $rows=$dom->getElementsByTagName('Row');
        //print_r($rows);
        $row_num=1;
        //полезная инфа начинается с 5 строки!
        //в нечетной строке у нас идет название дивана во второй ячейке
        //в четной, с 3 по 21 идут цены (при этом они идут через одну ячейку, например 3,5,8 и т.д.
        foreach($rows as $row)
        {
            //print_r($row);
            if ($row_num>=5)
            {
                if (!($row_num%2==0))
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    foreach ($cells as $cell)
                    {
                        if ($cell_num==2)
                        {
                            $name=$cell->nodeValue;
                            //echo " name=".$name;
                            //имя дивана находится во второй ячейке
                        }
                        $cell_num++;
                    }
                }
                else
                {
                    //начиная с третей ячейки через одну читаем цены
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    $kat_num=1;
                    foreach ($cells as $cell)
                    {
                        if ($cell_num>=3)
                        {
                            if (!($cell_num%2==0))

                            {
                                $kat[$kat_num]=round($cell->nodeValue);
                                $kat_num++;
                            }
                        }
                        $cell_num++;
                    }
                    add_price($name,$kat[1],$kat[2],$kat[3],$kat[4],$kat[5],$kat[6],$kat[7],$kat[8],$kat[9],$kat[10]);
                }
            }
            $row_num++;
        }
        /*echo '<pre>';
     print_r($data);
     echo '</pre>';*/

    }
}
//print_r($_FILES['file']['tmp_name']);

parse_price_lisogor();
add_db_lisogor($data);

/**
 * записывает информацию из ассоциативного массива с ценами в базу данных сайта
 * (id фабрики=66, id категорий начинаются с 628)
 * @param $data1 - ассоциативный массив с данными, получеными из XML
 */
function add_db_lisogor($data1)
{
	$db_connect=mysqli_connect('localhost','root','','mebli');
	foreach ($data1 as $d)
	{
		
		$d_name=$d['name'];
		echo $d_name."<br>";
		for ($i=1;$i<=10;$i++)
		{
			//echo "inner";
			$kat_name="kat".strval($i);
			echo $kat_name."<br>";
			$d_cat=$d[$kat_name];
			$cat_id=627+$i;
			
			$strSQL="UPDATE goodshascategory ".
					"SET goodshascategory_price=$d_cat ".
					"WHERE goodshascategory.goods_id= ".
					"(SELECT goods_id FROM goods WHERE (goods.goods_article_link='$d_name') AND (goods.factory_id=66)) ".
					"AND (goodshascategory.category_id=$cat_id)";
			//echo $strSQL."<br>";
			//break;
			mysqli_query($db_connect, $strSQL);
		}
		//break;
	}
}


?>

<html>
    <body>
        <table>
            <tr>
                <th>Диван</th>
                <th>kat 1</th>
                <th>kat 2</th>
                <th>kat 3</th>
                <th>kat 4</th>
                <th>kat 5</th>
                <th>kat 6</th>
                <th>kat 7</th>
                <th>kat 8</th>
                <th>kat 9</th>
                <th>kat 10</th>
            </tr>
            <?php foreach($data as $row)
                {?>
            <tr>
                <td><?php echo ($row['name']); ?></td>
                <td><?php echo ($row['kat1']); ?></td>
                <td><?php echo ($row['kat2']); ?></td>
                <td><?php echo ($row['kat3']); ?></td>
                <td><?php echo ($row['kat4']); ?></td>
                <td><?php echo ($row['kat5']); ?></td>
                <td><?php echo ($row['kat6']); ?></td>
                <td><?php echo ($row['kat7']); ?></td>
                <td><?php echo ($row['kat8']); ?></td>
                <td><?php echo ($row['kat9']); ?></td>
                <td><?php echo ($row['kat10']); ?></td>
            </tr>

                <?php } ?>

        </table>
    </body>
</html>