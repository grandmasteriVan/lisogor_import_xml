<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 26.01.17
 * Time: 15:46
 */

Class Universal
{
    /**
     * @var int id фабрики с которой в данный момент работаем
     */
    private $factory_id;
    /**
     * @var \$file1 xml файл с прайсом
     */
    private $file1;
    /**
     * @var \$data ассоциативный массив, в котором хранится информация о названии товара из прайса и его цене
     */
    private $data;
    /**
     * Universal constructor.
     * @param $f string file файл с прайсом в конструктор
     * @param $factory int id фабрики с которой в данный момент работаем
     */
    function __construct($f, $factory)
    {
        if ($f)
            $this->file1=$f;
        $this->factory_id=$factory;
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
            'kat11'=>$kat11,
            'kat12'=>$kat12);
    }

    /**
     * парсит прайс
     * @param $begin int - номер строки, с которой начинается прайс
     * @param $pos_name string - номер ячейки, в котором содержится имя товара
     * @param $pos_0 int - номер ячейки, в которой содержится цена за 0 категорию
     * @param $pos_1 int - номер ячейки, в которой содержится цена за 1 категорию
     * @param $pos_2 int - номер ячейки, в которой содержится цена за 2 категорию
     * @param $pos_3 int - номер ячейки, в которой содержится цена за 3 категорию
     * @param $pos_4 int - номер ячейки, в которой содержится цена за 4 категорию
     * @param $pos_5 int - номер ячейки, в которой содержится цена за 5 категорию
     * @param $pos_6 int - номер ячейки, в которой содержится цена за 6 категорию
     * @param $pos_7 int - номер ячейки, в которой содержится цена за 7 категорию
     * @param $pos_8 int - номер ячейки, в которой содержится цена за 8 категорию
     * @param $pos_9 int - номер ячейки, в которой содержится цена за 9 категорию
     * @param $pos_10 int - номер ячейки, в которой содержится цена за 10 категорию
     * @param $pos_11 int - номер ячейки, в которой содержится цена за 11 категорию
     * @param $pos_12 int - номер ячейки, в которой содержится цена за 12 категорию
     */
    public function parse_price($begin, $pos_name, $pos_0, $pos_1, $pos_2, $pos_3, $pos_4, $pos_5, $pos_6, $pos_7, $pos_8, $pos_9, $pos_10, $pos_11, $pos_12)
    {
        if ($this->file1)
        {
            $dom=DOMDocument::load($this->file1);
            $rows=$dom->getElementsByTagName('Row');
            $row_num=1;
            foreach ($rows as $row)
            {
                if ($row_num>=$begin)
                {

                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if ($cell_num==$pos_name)
                        {
                            $name=$elem;
                        }
                        switch ($cell_num)
                        {
                            case $pos_0:
                                $kat[0]=$elem;
                                break;
                            case $pos_1:
                                $kat[1]=$elem;
                                break;
                            case $pos_2:
                                $kat[2]=$elem;
                                break;
                            case $pos_3:
                                $kat[3]=$elem;
                                break;
                            case $pos_4:
                                $kat[4]=$elem;
                                break;
                            case $pos_5:
                                $kat[5]=$elem;
                                break;
                            case $pos_6:
                                $kat[6]=$elem;
                                break;
                            case $pos_7:
                                $kat[7]=$elem;
                                break;
                            case $pos_8:
                                $kat[8]=$elem;
                                break;
                            case $pos_9:
                                $kat[9]=$elem;
                                break;
                            case $pos_10:
                                $kat[10]=$elem;
                                break;
                            case $pos_11:
                                $kat[11]=$elem;
                                break;
                            case $pos_12:
                                $kat[12]=$elem;
                                break;

                        }
                        $cell_num++;
                    }
                    if ($name>0)
                    {
                        $this->add_price($name,$kat[0],$kat[1],$kat[2],$kat[3],$kat[4],$kat[5],$kat[6],$kat[7],$kat[8],$kat[9],$kat[10],$kat[11],$kat[12]);
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
     * записывает данные, которые получили при разборке прайса в базу данных
     * @param $pId array массив, содержащий category_id для каждой из цен в прайсе
     * @param $priceInCurr bool флажочек, означающий что прайс в валюте
     */
    public function add_db($pId, $priceInCurr)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            //set category prices
            //проверяем цены в валюте или нет
            if ($priceInCurr)
            {
                //в цыкле проходим по всем категориям и меняем цены
                for ($i = 0; $i <= count($pId); $i++)
                {
                    $oldPrice=$this->findOldPrice($d_name,$pId[$i]);
                    if ($oldPrice)
                    {
                        //echo "$oldPrice<br>";
                        $diff=$this->priceDif($d[$i],$oldPrice);
                        echo "$diff <br>";
                    }

                    $strSQL = "UPDATE goodshascategory " .
                        "SET goodshascategory_pricecur=$d[$i] " .
                        "WHERE goodshascategory.goods_id= " .
                        "(SELECT goods_id FROM goods WHERE (goods.goods_article_link='$d_name') AND (goods.factory_id=$this->factory_id)) " .
                        "AND (goodshascategory.category_id=$pId[$i])";
                    //echo "Цена за $i категорию:<br>".$strSQL."<br>";
                    //mysqli_query($db_connect, $strSQL);
                }
                //меняец цену в самом товаре (записи в таблице goods)
                $strSQL="UPDATE goods ".
                    "SET goods_pricecur=$d[0] ".
                    "WHERE goods_article_link='$d_name' AND factory_id=$this->factory_id";
                //echo $strSQL."<br>";
                echo "$d_name is OK!<br>";
                //break;
                //mysqli_query($db_connect, $strSQL);
            }
            else
            {
                //цены в гривнах
                //в цыкле проходим по всем категориям и меняем цены
                for ($i = 0; $i <= count($pId); $i++)
                {
                    $oldPrice=$this->findOldPrice($d_name,$pId[$i]);
                    if ($oldPrice)
                    {
                        //echo "$oldPrice<br>";
                        $diff=$this->priceDif($d[$i],$oldPrice);
                        echo "$diff <br>";
                    }

                    $strSQL = "UPDATE goodshascategory " .
                        "SET goodshascategory_price=$d[$i] " .
                        "WHERE goodshascategory.goods_id= " .
                        "(SELECT goods_id FROM goods WHERE (goods.goods_article_link='$d_name') AND (goods.factory_id=$this->factory_id)) " .
                        "AND (goodshascategory.category_id=$pId[$i])";
                    //echo "Цена за $i категорию:<br>".$strSQL."<br>";
                    //mysqli_query($db_connect, $strSQL);
                }
                //меняец цену в самом товаре (записи в таблице goods)
                $strSQL="UPDATE goods ".
                    "SET goods_price=$d[0] ".
                    "WHERE goods_article_link='$d_name' AND factory_id=$this->factory_id";
                //echo $strSQL."<br>";
                echo "$d_name is OK!<br>";
                //break;
                //mysqli_query($db_connect, $strSQL);
            }
        }
    }

    /**
     * выбираем старую цену товара
     * @param $name string название товара в прайсе
     * @param $cat_id int id категории в таблице goodshascategory
     * @param $priceInCurr bool флажочек, означающий что прайс в валюте
     * @return array|null старая цена товара, взятая из бд
     */
    private function findOldPrice($name, $cat_id, $priceInCurr)
    {
        $factory_id=$this->factory_id;
        $db_connect=mysqli_connect(host,user,pass,db);
        //если в валюте, то берем цену в валюте
        if ($priceInCurr)
        {
            $query="SELECT goodshascategory_pricecur FROM goodshascategory WHERE goodshascategory.goods_id= ".
                "(SELECT goods_id FROM goods WHERE (goods.goods_article_link='$name') AND (goods.factory_id=$factory_id)) ".
                "AND (goodshascategory.category_id=$cat_id)";
            //echo "$query<br>";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset($oldPrice);
                while ($row = mysqli_fetch_assoc($res))
                {
                    //массив со всеми названиями товара в прайсе
                    $oldPrice = $row;
                }
                $oldPrice=$oldPrice["goodshascategory_pricecur"];
                //var_dump ($oldPrice);
            }
            return $oldPrice;
            mysqli_close($db_connect);
        }
        else //если в гривнах, то берем гривневую цену
        {
            $query="SELECT goodshascategory_price FROM goodshascategory WHERE goodshascategory.goods_id= ".
                "(SELECT goods_id FROM goods WHERE (goods.goods_article_link='$name') AND (goods.factory_id=$factory_id)) ".
                "AND (goodshascategory.category_id=$cat_id)";
            //echo "$query<br>";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset($oldPrice);
                while ($row = mysqli_fetch_assoc($res))
                {
                    //массив со всеми названиями товара в прайсе
                    $oldPrice = $row;
                }
                $oldPrice=$oldPrice["goodshascategory_price"];
                //var_dump ($oldPrice);
            }
            return $oldPrice;
            mysqli_close($db_connect);
        }

    }

    /**
     * находим разницу между новой и старой ценами
     * @param $newPrice int новая цена товара, олученная из прайса
     * @param $oldPrice int старая цена товара, полученная из базы данных
     * @return float|int разница между новой и старой ценами в процентах
     */
    private function priceDif($newPrice, $oldPrice)
    {
        if ($newPrice>$oldPrice)
        {
            $diff=round(($newPrice/$oldPrice-1)*100);
        }
        elseif ($newPrice<$oldPrice)
        {
            $diff=round((1-$oldPrice/$newPrice)*100);
        }
        else
        {
            $diff=0;
        }
        return $diff;
    }
}