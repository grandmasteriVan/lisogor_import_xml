<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 30.08.16
 * Time: 14:45
 */

class A_Class
{

    /**
     * A_Class constructor.
     */
    public function __construct($f)
    {
        if ($f)
            $this->file1=$f;
    }
    /**
     * @var \$file1 xml файл с прайсом
     */
    private $file1;
    /**
     * @var \$data ассоциативный массив, в котором хранится информация о названии товара из прайса и его цене
     */
    private $data;

    /**
     * записывает в поле $data наименование товара и его цену
     * @param $name string - id дивана в прасе производителя
     * @param $kat0 integer цена за 0 категорию в долларах
     */
    private function add_price($name, $kat0)
    {
        $this->$data[]= [
            'name'=>$name,
            'kat0'=>$kat0
        ];
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
                    <td><?php echo ($row['kat0']); ?></td>
                </tr>

            <?php } ?>

        </table>
        <!-- </body>
        </html> --> <?php
    }
}

?>