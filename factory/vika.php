<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.04.16
 * Time: 09:43
 */


class Vika
{
    /**
     * @var \$file1 xml файл с прайсом
     */
    private $file1;
    /**
     * @var \$data ассоциативный массив, в котором хранится информация о названии товара из прайса и его цене
     */
    protected $data;
    /**
     * Sidim constructor.
     * @param \$f передаем файл с прайсом в конструктор
     */
    function __construct($f)
    {
        if ($f)
            $this->file1=$f;
    }
    /**
     * @param $name string[] название (код) товара
     * @param $kat1 integer цена в первой категории ткани
     * @param $kat2 integer цена в второй категории ткани
     * @param $kat3 integer цена в третьей категории ткани
     * @param $kat4 integer цена в четвертой категории ткани
     * @param $kat5 integer цена в пятой категории ткани
     * @param $kat6 integer цена в шестой категории ткани
     * @param $kat7 integer цена в седьмой категории ткани
     * @param $kat8 integer цена в восьмой категории ткани
     * @param $kat9 integer цена в девятой категории ткани
     * @param $kat10 integer цена в десятой категории ткани
     * записывает в поле $data наименование товара и его цену
     */
    private function add_price ($name, $kat1, $kat2, $kat3, $kat4, $kat5, $kat6, $kat7, $kat8, $kat9, $kat10)
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
            'kat10'=>$kat10);
        //var_dump($this->data);
        //echo "test!";
    }

    public function parce_price_vika()
    {
        if ($this->file1)
        {
            $dom=DOMDocument::load($this->file1);
            //print_r($dom);
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
                        if($cell_num==2)
                        {
                            $name=$elem;
                        }
                        if ($cell_num>=6)
                        {
                            if ($cell_num%2==0)
                            {
                                $kat[$kat_num]=round($cell->nodeValue);
                                $kat_num++;
                            }
                        }
                        $cell_num++;
                    }
                    if ((!empty($name))&&(!empty($kat[1]))&&(!empty($kat[2]))&&(!empty($kat[3]))&&(!empty($kat[4]))&&(!empty($kat[5]))&&(!empty($kat[6]))&&(!empty($kat[7]))&&(!empty($kat[8]))&&(!empty($kat[9]))&&(!empty($kat[10])))
                        $this->add_price($name,$kat[1],$kat[2],$kat[3],$kat[4],$kat[5],$kat[6],$kat[7],$kat[8],$kat[9],$kat[10]);
                }
                $row_num++;
            }
            /*echo '<pre>';
                print_r($data);
                echo '</pre>';*/
        }
        else
        {
            echo "No file!";
        }
    }
    /**
     * записывает информацию из ассоциативного массива с ценами в базу данных сайта
     * (id фабрики=33, id категорий начинаются с 119)
     */
    function add_db_vika()
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
    /**
     * для тестов
     * "красиво" выводим поле $data в котором лежат наименование товара и его цена
     */
    public function test_data()
    {
        ?>
        <!--<html>
        <body> -->
        <table>
            <tr>
                <th>Артикул</th>
                <th>Цена 1 кат</th>
                <th>Цена 2 кат</th>
                <th>Цена 3 кат</th>
                <th>Цена 4 кат</th>
                <th>Цена 5 кат</th>
                <th>Цена 6 кат</th>
                <th>Цена 7 кат</th>
                <th>Цена 8 кат</th>
                <th>Цена 9 кат</th>
                <th>Цена 10 кат</th>
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