<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.04.16
 * Time: 09:48
 */
//TODO: set peice to goods table

/**
 * Class Sidim
 */
class Sidim
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
     * записывает в поле $data наименование товара и его цену
     */
    private function add_price ($name, $kat1, $kat2, $kat3, $kat4, $kat5, $kat6, $kat7, $kat8)
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
            'kat8'=>$kat8);
        //var_dump($this->data);
        //echo "test!";
    }

    public function parce_price_sidim()
    {
        if ($this->file1)
        {
            $dom=DOMDocument::load($this->file1);
            //print_r($dom);
            $worksheets=$dom->getElementsByTagName('Worksheet');
            foreach ($worksheets as $worksheet)
            {
                $ws_name=$worksheet->getAttribute('ss:Name');
                //echo "$ws_name vkladka <br>";
                if ($ws_name=="Розница грн.")
                {
                    //echo "need vkladka <br>";
                    $rows=$dom->getElementsByTagName('Row');
                    //print_r($rows);
                    $row_num=1;
                    //полезная инфа начинается с 10 строки!
                    //название дивана находиться в первой ячейке
                    //цены - с 4 ячейки через одну (4,6,8 и т.д.)
                    foreach($rows as $row)
                    {
                        //print_r($row);
                        if ($row_num>=10)
                        {
                            $cells=$row->getElementsByTagName('Cell');
                            $cell_num=1;
                            $kat_num=1;
                            foreach ($cells as $cell)
                            {
                                $elem=$cell->nodeValue;
                                //echo "$elem $cell_num <br>";
                                if ($cell_num==1)
                                {
                                    $name=$elem;
                                }
                                if (($cell_num>=4)&&(!empty($elem)))
                                {
                                    if ($cell_num%2==0)
                                    {
                                        $kat[$kat_num]=$cell->nodeValue;
                                        $kat_num++;
                                    }
                                }
                                $cell_num++;
                            }
                            if (($name!="Назва виробу")&&(!empty($name))&&(!empty($kat[1]))&&(!empty($kat[2]))&&(!empty($kat[3]))&&(!empty($kat[4]))&&(!empty($kat[5]))&&(!empty($kat[6]))&&(!empty($kat[7]))&&(!empty($kat[8])))
                                $this->add_price($name,$kat[1],$kat[2],$kat[3],$kat[4],$kat[5],$kat[6],$kat[7],$kat[8]);
                        }
                        $row_num++;
                    }
                    /*echo '<pre>';
                 print_r($data);
                 echo '</pre>';*/
                }
            }
        }
    }

    /**
     * для тестов
     * красиво выводим поле $data в котором лежат наименование товара и его цены
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

                </tr>

            <?php } ?>

        </table>
        <!-- </body>
        </html> --> <?php
    }
}

?>