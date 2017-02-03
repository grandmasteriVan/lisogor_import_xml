<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 06.06.16
 * Time: 16:38
 */

class ComeFor extends Universal
{

    /**
     * @param $name string[] код товара
     * @param $price int цена товара
     * записывает в поле $data наименование товара и его цену
     */
    /*public function add_price ($name, $price)
    {
        if ($name&&$price)
        {
            $this->data[]=array(
                'name'=>$name,
                'price'=>$price);
            //var_dump($this->data);
            //echo "test!";
        }

    }*/

    /**
     *вынимаем из прайса наименование товара и его цену
     * и записываем их в поле $data
     */
    public function parce_price()
    {
        if ($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows = $dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num = 1;
            //полезная инфа начинается с 15 строки!
            //артикул позиции находится в 2 ячейке
            //цена - 5 ячейка
            foreach ($rows as $row)
            {
                if ($row_num>=15)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if ($cell_num==2)
                        {
                            $name=$elem;
                        }
                        if ($cell_num==5)
                        {
                            $price=$elem;
                        }
                        $cell_num++;
                    }
                    $this->add_price($name,$price);
                }
                $row_num++;
            }
        }
        else
        {
            echo "No file, no life!";
        }
    }

    /**
     *сохраняет информацию из поля $data в базу данных сайта
     */
    public function add_db()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            $d_price=$d['kat0'];
            $factory_id=35;

            $strSQL="UPDATE goods ".
                "SET goods_pricecur=$d_price ".
                "WHERE goods.goods_article_link=$d_name AND factory_id=$factory_id";
            echo $strSQL."<br>";
            //break;
            //mysqli_query($db_connect, $strSQL);
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
        $this->findDif();
    }

}