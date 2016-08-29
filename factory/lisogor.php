<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.04.16
 * Time: 09:41
 */

Class Lisogor
{
    /**
     * @var array ассоциативный массив, содержащий название позиции и цены, прочитаные из прайса
     */
    private $data;

    /**
     * @var \$file1 xml файл с прайсом
     */
    private $file1;

    /**
     * Lisogor constructor.
     * @param $f file XML файл с прайсом
     */
    function __construct($f)
    {
        if ($f)
        {
            $this->file1=$f;
        }
        else
        {
            echo "Error loading file!";
            return;
        }

    }
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
    private function add_price($name, $kat1=0, $kat2=0, $kat3=0, $kat4=0, $kat5=0, $kat6=0, $kat7=0, $kat8=0, $kat9=0, $kat10=0)
    {
        global $data;
        //echo "test!<br>";
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
        //print_r($data);
    }
    /**
     *вынимает нужную информацию из XML в прайсе Лисогор
     */
    public function parse_price_lisogor()
    {
        if ($_FILES['file']['tmp_name'])
        {
            $dom=DOMDocument::load($this->file1);
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
        trunc_arr();
    }

    /**
     * записывает информацию из ассоциативного массива с ценами в базу данных сайта
     * (id фабрики=66, id категорий начинаются с 628)
     */
    public function add_db_lisogor()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        foreach ($this->data as $d)
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
            //записываем цену первой категории в таблицу goods
            $price=$d['kat1'];
            $strSQL="UPDATE goods SET goods_price=$price WHERE goods_article_link='$d_name' AND factory_id=66";
            mysqli_query($db_connect, $strSQL);
            //break;
        }
    }
    /**
     *Для теситрования, генерит HTML код для вывода $data в виде таблицы
     * @param $data1  array - ассоциативный массив с ценами
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

    /**
     * удаляет лишние строки из массива (в прайсе несколько вкладок, парсит он все, а нам надо обрабатывать только последнюю)
     */
    private function trunc_arr()
    {
        global $data;
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT COUNT(goods_id) FROM goods WHERE factory_id=66";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $num[] = $row;
            }
            //$num=$num[0];
            //$data1=$data;
            //echo "<pre>";
            var_dump($this->data);
            //echo "</pre>";
            $num=$num[0]['COUNT(goods_id)'];
            echo $num."<br>";
            $num=intval($num);
            $len=count ($data);
            $len=intval($len);
            echo $len."<br>";
            echo $len-$num."<br>";
            $tmp=$len-$num;
            //for ($i=0;$i<$len;$i++)
            //{
            //	//echo $i;
            //	if ($i>$tmp)
            //	{
            //		echo "Yay! $i ";
            //		$new_data[]=$data1[i];
            //		var_dump($data1[i]);
            //	}
            //}
            $new_data=array_slice($this->data, -$tmp);
            echo "<pre>";
            var_dump($new_data);
            echo "</pre>";
            $this->data=$new_data;
        }
        mysqli_close($db_connect);
    }

}







?>
