<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 08.06.16
 * Time: 14:38
 */

Class Livs
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
     * Livs constructor.
     * @param $f file файл с прайсом в конструктор
     */
    function __construct($f)
    {
        if ($f)
            $this->file1=$f;
    }

    /**
     * записывает в поле $data наименование товара и его цену
     * @param $name string - id дивана в прасе производителя
     * @param $kat0 integer цена за 0 категорию в долларах
     * @param $kat1 integer цена за 1 категорию в долларах
     * @param $kat2 integer цена за 2 категорию в долларах
     * @param $kat3 integer цена за 3 категорию в долларах
     * @param $kat4 integer цена за 4 категорию в долларах
     * @param $kat5 integer цена за 5 категорию в долларах
     * @param $kat6 integer цена за 6 категорию в долларах
     * @param $kat7 integer цена за 7 категорию в долларах
     * @param $kat8 integer цена за 8 категорию в долларах
     * @param $kat9 integer цена за 9 категорию в долларах
     * @param $kat10 integer цена за 10 категорию в долларах
     * @param $kat11 integer цена за 11 категорию в долларах
     * @param $kat12 integer цена за 12 категорию в долларах
     */
    private function add_price($name, $kat0, $kat1, $kat2, $kat3, $kat4, $kat5, $kat6, $kat7, $kat8, $kat9, $kat10, $kat11, $kat12)
    {
        $this->$data[]= [
            'name'=>$name,
            'kat0'=>$kat0,
            'kat1'=>$kat1,
            'kat2'=>$kat2,
            'kat3'=>$kat3,
            'kat4'=>$kat4,
            'kat5'=>$kat5,
            'kat6'=>$kat6,
            'kat7'=>$kat7,
            'kat8'=>$kat8,
            'kat9'=>$kat9,
            'kat10'=>$kat10,
            'kat11'=>$kat11,
            'kat12'=>$kat12
        ];
    }

    public function parce_price_livs()
    {
        if ($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows=$dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num=1;
            //полезная инфа начинается с 13 строки!
            //артикул позиции находится в 1 ячейке
            //цена - c 6 по 18 ячейке
            foreach ($rows as $row)
            {
                if ($row_num>=4)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    $kat_num=0;
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if ($cell_num==1)
                        {
                            $name=$elem;
                        }
                        if (($cell_num>=6)&&($cell_num<=18))
                        {
                            $kat[$kat_num]=$cell->nodeValue;
                            $kat_num++;
                        }
                        $cell_num++;
                    }
                    //
                    if ($name>0)
                    {
                        $$this->add_price($name,$kat[0],$kat[1],$kat[2],$kat[3],$kat[4],$kat[5],$kat[6],$kat[7],$kat[8],$kat[9],$kat[10],$kat[11],$kat[12]);
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


    public function add_db_livs()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            //set category prices
            for ($i=0;$i<=12;$i++)
            {
                //йади каегории зависит от номера категории
                if ($i==0||$i==1)
                {
                    $cat_id=68+$i;
                }
                else
                {
                    $cat_id=543+$i;
                }


                $kat_name="kat".strval($i);
                //echo $kat_name."<br>";
                $d_cat=$d[$kat_name];
                $strSQL="UPDATE goodshascategory ".
                    "SET goodshascategory_pricecur=$d_cat ".
                    "WHERE goodshascategory.goods_id= ".
                    "(SELECT goods_id FROM goods WHERE (goods.goods_article_link='$d_name') AND (goods.factory_id=7)) ".
                    "AND (goodshascategory.category_id=$cat_id)";
                echo $strSQL."<br>";
                //break;
                mysqli_query($db_connect, $strSQL);
            }
            //set goods price
            $d_cat=$d['kat1'];
            $strSQL="UPDATE goods ".
                "SET goods_pricecur=$d_cat ".
                "WHERE goods_article_link='$d_name' AND factory_id=7";
            echo $strSQL."<br>";
            //break;
            mysqli_query($db_connect, $strSQL);
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
                <th>Цена 11 кат</th>
                <th>Цена 12 кат</th>
                <th>Цена 13 кат</th>
            </tr>
            <?php foreach($this->data as $row)
            {?>
                <tr>
                    <td><?php echo ($row['name']); ?></td>
                    <td><?php echo ($row['kat0']); ?></td>
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
                    <td><?php echo ($row['kat11']); ?></td>
                    <td><?php echo ($row['kat12']); ?></td>
                </tr>

            <?php } ?>

        </table>
        <!-- </body>
        </html> --> <?php
    }



}