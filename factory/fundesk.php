<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 01.11.16
 * Time: 09:36
 */
class FunDesk
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
     * FunDesk constructor.
     * @param \$f передаем файл с прайсом в конструктор
     */
    function __construct($f)
    {
        if ($f)
            $this->file1=$f;
    }
    /**
     * @param $name string[] название (код) товара
     * @param $price integer цена
     * записывает в поле $data наименование товара и его цену
     */
    private function add_price ($name, $price)
    {
        $this->data[]=array(
            'name'=>$name,
            'price'=>$price);
        //var_dump($this->data);
        //echo "test!";
    }
    /**
     * парсим прайс
     */
    public function parce_price_fundesk()
    {
        if($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows=$dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num=1;
            //полезная инфа начинается с 7 строки!
            //название позиции находится в 1 ячейке
            //цена - 4 ячейка
            foreach ($rows as $row)
            {
                if ($row_num>=3)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if ($cell_num==1)
                        {
                            $name=$elem;
                        }
                        if ($cell_num==4)
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
    public function add_db_fundesk()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            $d_price=$d['price'];
            $factory_id=139;
            $strSQL="UPDATE goods ".
                "SET goods_price=$d_price ".
                "WHERE goods.goods_article_link=$d_name AND factory_id=$factory_id";
            echo $strSQL."<br>";
            //break;
            //mysqli_query($db_connect, $strSQL);
            //break;
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
