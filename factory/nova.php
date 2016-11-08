<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.09.16
 * Time: 09:32
 */

//todo:разобраться с работами со вкладками в екселе
class Nova
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
     * Nova constructor.
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
     * записывает в поле $data наименование товара и его цену
     */
    private function add_price ($name, $kat1)
    {
        $this->data[]=array(
            'name'=>$name,
            'price'=>$kat1);
        //var_dump($this->data);
        //echo "test!";
    }

    /**
     * парсим прайс
     */
    public function parce_price_nova()
    {
        if ($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows=$dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num=1;
            //полезная инфа начинается с 1379 строки!
            //артикул позиции находится в 2 ячейке
            //цена - 6 ячейка
            foreach ($rows as $row)
            {
                if ($row_num>=1379)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    $isModuleTov=true;
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if ($cell_num==2)
                        {
                            $name=$elem;
                        }
                        if ($cell_num==6)
                        {
                            $price=$elem;
                        }
                        $cell_num++;
                    }
                    if ((!empty($name))&&(!empty($price)))
                    {
                        $this->add_price($name,$price);
                        //echo "Yay!";
                    }
                }
                $row_num++;
            }
        }
        else
        {
            echo "No file, no life!";
            return;
        }
    }

    /**
     *записываем распарсеный прайс в БД
     */
    public function add_db_nova()
    {
        $db_connect=mysqli_connect(host,user,pass,db);

        //ставим цены для позиций из прайса
        foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            $d_price=$d['price'];
            $factory_id=14;
            $strSQL="UPDATE goods ".
                "SET goods_price=$d_price ".
                "WHERE goods.goods_article_link='$d_name' AND factory_id=$factory_id";
            echo $strSQL."<br>";
            //break;
            mysqli_query($db_connect, $strSQL);
            //break;
        }

        //ставим цены составных позиций
        //
        //выбираем все составные товары фабрики Нова
        $strSQL="SELECT DISTINCT goods_id FROM components WHERE goods_id IN(".
            "SELECT goods_id FROM goods WHERE factory_id=14)";
        if ($res=mysqli_query($db_connect,$strSQL))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $modular_tovs[] = $row;
            }
            //для каждого модульного товара ищем сумму цен его составных частей
            foreach ($modular_tovs as $tov)
            {
                $id=$tov['goods_id'];
                $strSQL="SELECT SUM(goods_price) FROM goods WHERE goods_id IN (".
                    "SELECT component_child FROM component WHERE component_in_complect=1 AND goods_id=$id)";
                if($res=mysqli_query($db_connect,$strSQL))
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $p[] = $row;
                    }
                    //сумма цен всех составляющих товаров=цена модульного товара
                    $price=$p['SUM(goods_price)'];
                    $strSQL="UPDATE goods SET goods_price=$price WHERE goods_id=$id";
                    //если цена не ноль - записываем ее
                    if (!is_null($price))
                    {
                        echo "$strSQL <br>";
                        mysqli_query($db_connect,$strSQL);
                    }
                }

            }
        }
        else
        {
            echo "can't find ";
        }

        mysqli_close($db_connect);
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
                <th>Цена </th>
            </tr>
            <?php foreach($this->data as $row)
            {?>
                <tr>
                    <td><?php echo ($row['name']); ?></td>
                    <td><?php echo ($row['price']); ?></td>
                </tr>

            <?php } ?>

        </table>
        <!-- </body>
        </html> --> <?php
    }
}


?>