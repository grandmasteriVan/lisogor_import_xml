<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.04.16
 * Time: 09:35
 */

//TODO: set peice to goods table

/**
 * Class Poparada
 */
class Poparada
{
    /**
     * @var ассоциативный массив, содержащий название позиции и цены, прочитаные из прайса
     */
    private $data;
    /**
     * записывает полученные из XML значения в ассоциативный массив
     * @param $name - название или id позиции в прайсе поставщика
     * @param $kat1 - цена за первую категорию или цена за товар
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
    private function add_price($name, $kat1=0, $kat2=0, $kat3=0, $kat4=0, $kat5=0, $kat6=0, $kat7=0, $kat8=0, $kat9=0, $kat10=0)
    {
        $this->data[]=array(
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
     *вынимает нужную информацию из XML в прайсе Попарада
     */
    public function parse_price_poparada()
    {
        if ($_FILES['file']['tmp_name'])
        {
            $dom = DOMDocument::load($_FILES['file']['tmp_name']);
            $rows=$dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num=1;
            //полезная инфа начинается с 7 строки!
            //название позиции находится в первой ячейке
            //цены в 4,5,6 и 7 ячейках
            foreach ($rows as $row)
            {
                if ($row_num>=7)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    $kat_num=1;
                    foreach ($cells as $cell)
                    {
                        if ($cell_num==1)
                        {
                            $name=$cell->nodeValue;
                        }
                        if (($cell_num>=4)&&($cell_num<=7))
                        {
                            $kat[$kat_num]=$cell->nodeValue;
                            $kat_num++;
                        }
                        $cell_num++;
                    }
                    if (!empty($name))
                        add_price($name,$kat[1],$kat[2],$kat[3],$kat[4]);
                }
                $row_num++;
            }
        }
    }
    /**
     * записывает информацию из ассоциативного массива с ценами в базу данных сайта
     * (id фабрики=17)
     * id категории начинается с 500
     */
    public function add_db_poparada()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            for ($i=1;$i<=4;$i++)
            {
                //echo "inner";
                $kat_name="kat".strval($i);
                //echo $kat_name."<br>";
                $d_cat=$d[$kat_name];
                $cat_id=499+$i;
                $factory_id=17;
                $strSQL="UPDATE goodshascategory ".
                    "SET goodshascategory_price=$d_cat ".
                    "WHERE goodshascategory.goods_id= ".
                    "(SELECT goods_id FROM goods WHERE (goods.goods_article_link='$d_name') AND (goods.factory_id=$factory_id)) ".
                    "AND (goodshascategory.category_id=$cat_id)";
                //echo $strSQL."<br>";
                //break;
                mysqli_query($db_connect, $strSQL);
            }
            //break;
        }
    }
    /**
     *Для теситрования, генерит HTML код для вывода $data в виде таблицы
     */
    public function test_data()
    {
        ?>
        <!--<html>
        <body> -->
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
            <?php foreach($this->data as $row)
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
        <!-- </body>
        </html> --> <?php
    }
}

?>