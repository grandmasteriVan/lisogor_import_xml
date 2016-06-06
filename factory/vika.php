<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.04.16
 * Time: 09:43
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
 *вынимает нужную информацию из XML в прайсе Вика
 */
function parse_price_vika()
{
    if ($_FILES['file']['tmp_name'])
    {
        $dom=DOMDocument::load($_FILES['file']['tmp_name']);
        //print_r($dom);
        $worksheets=$dom->getElementsByTagName('Worksheet');
        foreach ($worksheets as $worksheet)
        {
            $ws_name=$worksheet->getAttribute('ss:Name');
            //echo "$ws_name vkladka <br>";

            if ($ws_name=="Розница грн.")
            {
                //echo "need vkladka <br>";
                $rows=$dom->getElementsByTagName('Row');
                //print_r($rows);
                $row_num=1;
                //полезная инфа начинается с 4 строки!
                //если первая ячейка не пустая, то название дивана находится во второй ячейке
                //цены идус с 6 ячейки через одну ячейку (6, 8, 10 и т.д.)
                foreach($rows as $row)
                {
                    //print_r($row);
                    if ($row_num>=4)
                    {
                        $cells=$row->getElementsByTagName('Cell');
                        $cell_num=1;
                        $kat_num=1;
                        $pass=false;
                        foreach ($cells as $cell)
                        {
                            $elem=$cell->nodeValue;
                            //echo "$elem $cell_num <br>";
                            if (($cell_num==1)&&(empty($elem)))
                            {
                                $pass=true;
                            }
                            if(($pass==false)&&($cell_num==2))
                            {
                                $name=$elem;
                            }
                            if (($pass==false)&&($cell_num>=6))
                            {
                                if ($cell_num%2==0)
                                {
                                    $kat[$kat_num]=$cell->nodeValue;
                                    $kat_num++;
                                }
                            }
                            $cell_num++;
                        }
                        if (($name!="Назва виробу")&&(!empty($name))&&(!empty($kat[1]))&&(!empty($kat[2]))&&(!empty($kat[3]))&&(!empty($kat[4]))&&(!empty($kat[5]))&&(!empty($kat[6]))&&(!empty($kat[7]))&&(!empty($kat[8]))&&(!empty($kat[9]))&&(!empty($kat[10])))
                            add_price($name,$kat[1],$kat[2],$kat[3],$kat[4],$kat[5],$kat[6],$kat[7],$kat[8],$kat[9],$kat[10]);
                    }
                    $row_num++;
                }
                /*echo '<pre>';
             print_r($data);
             echo '</pre>';*/
            }
        }
    }
}

/**
 * записывает информацию из ассоциативного массива с ценами в базу данных сайта
 * (id фабрики=33, id категорий начинаются с 119)
 * @param $data1 - ассоциативный массив с данными, получеными из XML
 */
function add_db_vika($data1)
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
            $cat_id=118+$i;
            $strSQL="UPDATE goodshascategory ".
                "SET goodshascategory_pricecur=$d_cat ".
                "WHERE goodshascategory.goods_id= ".
                "(SELECT goods_id FROM goods WHERE (goods.goods_article_link='$d_name') AND (goods.factory_id=33)) ".
                "AND (goodshascategory.category_id=$cat_id)";
            //echo $strSQL."<br>";
            //break;
            mysqli_query($db_connect, $strSQL);
        }
        //category 1a
        $d_cat=round($d['kat1']*0.96);
        $strSQL="UPDATE goodshascategory ".
            "SET goodshascategory_pricecur=$d_cat ".
            "WHERE goodshascategory.goods_id= ".
            "(SELECT goods_id FROM goods WHERE (goods.goods_article_link='$d_name') AND (goods.factory_id=33)) ".
            "AND (goodshascategory.category_id=129)";
        //echo $strSQL."<br>";
        //break;
        mysqli_query($db_connect, $strSQL);


        //set price
        $d_cat=round($d['kat1']*0.96);
        $strSQL="UPDATE goods ".
            "SET goods_pricecur=$d_cat ".
            "WHERE goods_article_link='$d_name' AND factory_id=33";
        //echo $strSQL."<br>";
        //break;
        mysqli_query($db_connect, $strSQL);


        //break;
    }
}



?>