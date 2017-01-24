<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 23.01.17
 * Time: 14:35
 */
class AgatM
{
    /**
     * @var \$file1 xml файл с прайсом
     */
    private $file1;
    /**
     * @var \$data ассоциативный массив, в котором хранится информация о названии товара из прайса и его цене
     */
    private $data;
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
     * @param $kat0 integer цена за 0 категорию
     * @param $kat1 integer цена за 1 категорию
     * @param $kat2 integer цена за 2 категорию
     * @param $kat3 integer цена за 3 категорию
     * @param $kat4 integer цена за 4 категорию
     * @param $kat5 integer цена за 5 категорию
     * @param $kat6 integer цена за 6 категорию
     * @param $kat7 integer цена за 7 категорию
     * @param $kat8 integer цена за 8 категорию
     * @param $kat9 integer цена за 9 категорию
     * @param $kat10 integer цена за 10 категорию
     * @param $kat11 integer цена за 11 категорию
     */
    private function add_price($name, $kat0, $kat1, $kat2, $kat3, $kat4, $kat5, $kat6, $kat7, $kat8, $kat9, $kat10, $kat11)
    {
        $this->data[]=array(
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
			'kat11'=>$kat11);
    }
    public function parse_price()
    {
        if ($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows=$dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num=1;
            //полезная инфа начинается с 5 строки!
            //артикул позиции находится в 1 ячейке
            //цена - c 4 по 26 ячейке через одну ячейку
            foreach ($rows as $row)
            {
                if (($row_num>=5)&&($row_num<=40))
                {
                    unset($name);
					$cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    $kat_num=0;
					$excess_val=false;
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        echo "$elem<br>";
						if ($cell_num==1)
                        {
                            $name=$elem;
							//echo "$elem<br>";
                        }
						if ((!$excess_val)&&($cell_num>2)&&(!is_numeric($elem)))
                        {
                            echo "$elem break<br>";
							$excess_val=true;
							//break;
                        }
                        if ((!$excess_val)&&($cell_num>=4)&&($cell_num%2==0)&&($cell_num<=26))
                        {
                            $kat[$kat_num] = round($elem);
                            $kat_num++;	
                        }
                        $cell_num++;
                    }
                    if (isset($name))
                    {
                        $this->add_price($name,$kat[0],$kat[1],$kat[2],$kat[3],$kat[4],$kat[5],$kat[6],$kat[7],$kat[8],$kat[9],$kat[10],$kat[11],$kat[12]);
						//echo "YaY!<br>";
						unset ($name, $kat);
                    }
                }
                $row_num++;
            }
        }
        else
        {
            echo "No file!";
        }
		echo "<pre>";
		print_r ($this->data);
		echo "</pre>";
    }

    public function add_db_livs()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            //set category prices
            for ($i=0;$i<=10;$i++)
            {
                //йади каегории зависит от номера категории
                if ($i>=0&&$i<=9)
                {
                    $cat_id=849+$i;
                }
                else
                {
                    $cat_id=960+$i;
                }
                $kat_name="kat".strval($i);
                //echo $kat_name."<br>";
                $d_cat=$d[$kat_name];
                $strSQL="UPDATE goodshascategory ".
                    "SET goodshascategory_pricecur=$d_cat ".
                    "WHERE goodshascategory.goods_id= ".
                    "(SELECT goods_id FROM goods WHERE (goods.goods_article_link='$d_name') AND (goods.factory_id=95)) ".
                    "AND (goodshascategory.category_id=$cat_id)";
                //echo $strSQL."<br>";
                //break;
                //if ($d_name=='1099')
                //{
                //    echo $strSQL."<br>";
                //}
                mysqli_query($db_connect, $strSQL);
            }
            //set goods price
            $d_cat=$d['kat0'];
            $strSQL="UPDATE goods ".
                "SET goods_pricecur=$d_cat ".
                "WHERE goods_article_link='$d_name' AND factory_id=95";
            //echo $strSQL."<br>";
            echo "$d_name is OK!<br>";
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
				<th>Цена light кат</th>
				<th>Цена 0 кат</th>
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
