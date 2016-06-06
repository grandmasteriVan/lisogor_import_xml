<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.04.16
 * Time: 09:41
 */

//TODO: set peice to goods table

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


/**
 * записывает информацию из ассоциативного массива с ценами в базу данных сайта
 * (id фабрики=66, id категорий начинаются с 628)
 * @param $data1 - ассоциативный массив с данными, получеными из XML
 */
function add_db_lisogor($data1)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    foreach ($data1 as $d)
    {
        $d_name=$d['name'];
        //echo $d_name."<br>";
        for ($i=1;$i<=10;$i++)
        {
            //echo "inner";
            $kat_name="kat".strval($i);
            //echo $kat_name."<br>";
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