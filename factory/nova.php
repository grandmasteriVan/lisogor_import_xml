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
     * записывает в поле $data наименование товара и его цену
     */
    private function add_price ($name, $kat1)
    {
        $this->data[]=array(
            'name'=>$name,
            'kat1'=>$kat1);
        //var_dump($this->data);
        //echo "test!";
    }
}


?>