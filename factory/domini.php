<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.04.16
 * Time: 09:46
 */

/**
 * Class Domini
 */
class Domini
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
     * Domini constructor.
     * @param \$f передаем файл с прайсом в конструктор
     */
    function __construct($f)
    {
        if ($f)
            $this->file1=$f;
    }
    /**
     * @param $name string[] название (код) товара
     * @param $price int цена товара
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
     *вынимаем из прайса наименование товара и его цену
     * и записываем их в поле $data
     */
    public function parce_price_domini()
    {
        if ($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows=$dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num=1;
            //полезная инфа начинается с 4 строки!
            //артикул позиции находится в 1 ячейке
            //цена - 9 ячейка
            foreach ($rows as $row)
            {
                if ($row_num>=4)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    $isModuleTov=false;
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if (($cell_num==1)&&(intval($elem)))
                        {
                            $name=$elem;
                        }
                        if (($cell_num==2)&&(!intval($elem)))
                        {
                            $name=$elem;
                        }
                        if ($cell_num==9)
                        {
                            $price=$elem;
                        }
                        $cell_num++;
                    }
                    if (!empty($name))
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
            echo "No file!";
        }
    }
    /**
     *сохраняет информацию из поля $data в базу данных сайта
     */
    public function add_db_domini()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        //сначала проставляем цены элементов
        foreach ($this->data as $d)
        {
            if ($d['price']!=0)
            {
                $d_name=$d['name'];
                //echo $d_name."<br>";
                $d_price=$d['price'];
                $factory_id=78;
                $strSQL="UPDATE goods ".
                    "SET goods_price=$d_price ".
                    "WHERE goods.goods_article_link=$d_name AND factory_id=$factory_id";
                //echo $strSQL."<br>";
                //break;
                mysqli_query($db_connect, $strSQL);
                //break;
            }
        }
        //потом проставляем цены модулей
        foreach ($this->data as $d)
        {
            if ($d['price']==0)
            {
                //считаем цену позиции суммируя цены ее составляющих
                $name=$d['name'];
                //echo $name."<br>";
                $strSQL="SELECT SUM(goods_price) FROM goods WHERE goods_id IN(".
                    "SELECT component_child FROM component WHERE component_in_complect=1 AND goods_id=(".
                    "SELECT goods_id FROM goods WHERE goods_article_link=$name AND factory_id=78))";
                $res=mysqli_query($db_connect,$strSQL);
                $price=mysqli_fetch_assoc($res);
                //проставляем цену позиции
                $strSQL="UPDATE goods ".
                    "SET goods_price=$price ".
                    "WHERE goods.goods_article_link= $name";
                //echo $strSQL."<br>";
                //break;
                mysqli_query($db_connect, $strSQL);
            }
        }
    }
    /**
     * для тестов
     * красиво выводим поле $data в котором лежат наименование товара и его цена
     */
    public function test_data()
    {
        ?>
        <!--<html>
        <body> -->
        <table>
            <tr>
                <th>Артикул</th>
                <th>Цена</th>
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