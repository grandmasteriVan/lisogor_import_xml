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
    public function parse_price($params)
    {
        if ($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows = $dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num = 1;
            //полезная инфа начинается с 15 строки!
            //артикул позиции находится в 3 ячейке
            //цена - 6 ячейка
            foreach ($rows as $row)
            {
                if ($row_num>=15)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    unset($name);
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if ($cell_num==3)
                        {
                            $name=$elem;
                        }
                        if ($cell_num==6)
                        {
                            $price=$elem;
                        }
                        if ($cell_num==8)
                        {
                            $price_old=$elem;
                        }
                        $cell_num++;
                    }
                    if ($name)
                    {
                        $this->add_price($name,$price,$price_old);
                    }
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
        $factory_id=35;
        foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            $d_price=$d['kat0'];
            //$factory_id=35;

            $strSQL="UPDATE goods ".
                "SET goods_price=$d_price ".
                "WHERE goods.goods_article_link='$d_name' AND factory_id=$factory_id";
            echo $strSQL."<br>";
            //break;
            mysqli_query($db_connect, $strSQL);
            //break;

        }

    }

    /**
     * Добавляем старую цену, скидку и галочку Акция для акционных матрасов (если старая и новая цены не равны)
     */
    public function addStock()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $factory_id=35;
        //сначала удаляем все акции
        $query="update goods SET goods_stock=0, goods_discount=0 where factory_id=35";
        mysqli_query($db_connect,$query);
        foreach ($this->data as $d)
        {
            $name=$d['name'];
            $price=$d['cat0'];
            $price_old=$d['cat1'];
            //если старая и новая цены отличаются - расчитываем процент скидки и проставляем акцию
            if ($price!=$price_old AND $price_old!=0)
            {
                $discount=round((1-($price/$price_old)))*100;
                $strSQL="UPDATE goods ".
                    "SET goods_oldprice=$price_old, goods_discount=$discount, goods_stock=1 ".
                    "WHERE goods.goods_article_link='$name' AND factory_id=$factory_id";
                echo $strSQL."<br>";
                //break;
                //mysqli_query($db_connect, $strSQL);
                echo "$strSQL<br>";
                //break;

            }

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