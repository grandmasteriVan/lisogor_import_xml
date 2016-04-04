<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.04.16
 * Time: 09:29
 */
/**
 * Class AMF
 */
class AMF
{
    /**
     * AMF constructor.
     * @param $f
     */
    function __construct($f)
    {
        //echo $f;
        if ($f)
            $this->file1=$f;
    }
    /**
     * @var
     */
    private $file1;
    /**
     * @var - ассоциативный массив, содержащий название позиции и цены, прочитаные из прайса
     */
    /*private*/
    /**
     * @var
     */
    protected $data;
    /**
     * записывает артикул и цену позиции в ассоциативный массив $data
     * @param $name - артикул позиции
     * @param $price - цена
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
     *вынимает нужную информацию из XML в прайсе АМФ
     */
    public function parse_price_amf()
    {
        if ($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows=$dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num=1;
            //полезная инфа начинается с 12 строки!
            //артикул позиции находится в 3 ячейке
            //цена - 7 ячейка умноженная на 1.3 (+30% к оптовой цене в прайсе)
            foreach ($rows as $row)
            {
                if ($row_num>=12)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    foreach ($cells as $cell)
                    {
                        if ($cell_num==3)
                        {
                            $name=$cell->nodeValue;
                            //echo "name: ".$name."<br>";
                        }
                        if ($cell_num==7)
                        {
                            $price=round($cell->nodeValue*1.3);
                            //echo "price: ".$price."<br>";
                        }
                        $cell_num++;
                    }
                    if ((!empty($name))AND(!empty($price)))
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
        //print_r($this->data);
    }
    /**
     *
     */
    public function add_db_afm()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            $d_price=$d['price'];
            $factory_id=34;
            $strSQL="UPDATE goods ".
                "SET goods_price=$d_price ".
                "WHERE goods.goods_article_link=$d_name AND factory_id=$factory_id";
            //echo $strSQL."<br>";
            //break;
            mysqli_query($db_connect, $strSQL);
            //break;
        }
    }
    /**
     *Для тесоитрования, генерит HTML код для вывода $data в виде таблицы
     */
    public function test_data()
    {
        ?>
        <!--<html>
        <body> -->
        <table>
            <tr>
                <th>Артикул</th>
                <th>цена</th>
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