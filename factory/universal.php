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
     * @var array лог всех изменений
     */
    public $log;
    /**
     * @var int id фабрики с которой в данный момент работаем
     */
    public $factory_id;
    /**
     * @var \$file1 xml файл с прайсом
     */
    public $file1;
    /**
     * @var \$data ассоциативный массив, в котором хранится информация о названии товара из прайса и его цене
     */
    public $data;
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
    public function add_price($name, $kat0=0, $kat1=0, $kat2=0, $kat3=0, $kat4=0, $kat5=0, $kat6=0, $kat7=0, $kat8=0, $kat9=0, $kat10=0, $kat11=0, $kat12=0)
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
     * @param $params array -  именнованный массив с параметрами, содержить поля:
     * begin int - номер строки, с которой начинается прайс
     * pos_name string - номер ячейки, в котором содержится имя товара
     * pos_0 int - номер ячейки, в которой содержится цена за 0 категорию
     * pos_1 int - номер ячейки, в которой содержится цена за 1 категорию
     * pos_2 int - номер ячейки, в которой содержится цена за 2 категорию
     * pos_3 int - номер ячейки, в которой содержится цена за 3 категорию
     * pos_4 int - номер ячейки, в которой содержится цена за 4 категорию
     * pos_5 int - номер ячейки, в которой содержится цена за 5 категорию
     * pos_6 int - номер ячейки, в которой содержится цена за 6 категорию
     * pos_7 int - номер ячейки, в которой содержится цена за 7 категорию
     * pos_8 int - номер ячейки, в которой содержится цена за 8 категорию
     * pos_9 int - номер ячейки, в которой содержится цена за 9 категорию
     * pos_10 int - номер ячейки, в которой содержится цена за 10 категорию
     * pos_11 int - номер ячейки, в которой содержится цена за 11 категорию
     * pos_12 int - номер ячейки, в которой содержится цена за 12 категорию
     */
    public function parse_price($params)
    {
        if ($this->file1)
        {
            $dom=DOMDocument::load($this->file1);
            $rows=$dom->getElementsByTagName('Row');
            $row_num=1;
            foreach ($rows as $row)
            {
                if ($row_num>=$params['begin'])
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if ($cell_num==$params['pos_name'])
                        {
                            $name=$elem;
                        }
                        switch ($cell_num)
                        {
                            case $params['pos_0']:
                                $kat[0]=$elem;
                                break;
                            case $params['pos_1']:
                                $kat[1]=$elem;
                                break;
                            case $params['pos_2']:
                                $kat[2]=$elem;
                                break;
                            case $params['pos_3']:
                                $kat[3]=$elem;
                                break;
                            case $params['pos_4']:
                                $kat[4]=$elem;
                                break;
                            case $params['pos_5']:
                                $kat[5]=$elem;
                                break;
                            case $params['pos_6']:
                                $kat[6]=$elem;
                                break;
                            case $params['pos_7']:
                                $kat[7]=$elem;
                                break;
                            case $params['pos_8']:
                                $kat[8]=$elem;
                                break;
                            case $params['pos_9']:
                                $kat[9]=$elem;
                                break;
                            case $params['pos_10']:
                                $kat[10]=$elem;
                                break;
                            case $params['pos_11']:
                                $kat[11]=$elem;
                                break;
                            case $params['pos_12']:
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
                    $oldPrice=$this->findOldPriceCat($d_name,$pId[$i],true);
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
                    $oldPrice=$this->findOldPriceCat($d_name,$pId[$i],false);
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
     * выбираем старую цену товара из таблицы товара
     * @param $name string название товара в прайсе
     * @param $priceInCurr bool флажочек, означающий что прайс в валюте
     * @return array|null старая цена товара, взятая из бд
     */
    public function findOldPrice($name, $priceInCurr)
    {
        $factory_id=$this->factory_id;
        $db_connect=mysqli_connect(host,user,pass,db);
        //если в валюте, то берем цену в валюте
        if ($priceInCurr)
        {
            $query="SELECT goods_pricecur FROM goods WHERE factory_id=$factory_id AND goods_article_link='$name'";
            //echo "$query<br>";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset($oldPrice);
                while ($row = mysqli_fetch_assoc($res))
                {
                    //массив со всеми названиями товара в прайсе
                    $oldPrice = $row;
                }
                $oldPrice=$oldPrice['goods_pricecur'];
                //var_dump ($oldPrice);
            }
            mysqli_close($db_connect);
            return $oldPrice;
        }
        else //если в гривнах, то берем гривневую цену
        {
            $query="SELECT goods_price FROM goods WHERE factory_id=$factory_id AND goods_article_link='$name'";
            //echo "$query<br>";
            if ($res=mysqli_query($db_connect,$query))
            {
                unset($oldPrice);
                while ($row = mysqli_fetch_assoc($res))
                {
                    //массив со всеми названиями товара в прайсе
                    $oldPrice = $row;
                }
                $oldPrice=$oldPrice['goods_price'];
                //var_dump ($oldPrice);
            }
            mysqli_close($db_connect);
            return $oldPrice;
        }
    }
    /**
     * выбираем старую цену товара из категории
     * @param $name string название товара в прайсе
     * @param $cat_id int id категории в таблице goodshascategory
     * @param $priceInCurr bool флажочек, означающий что прайс в валюте
     * @return array|null старая цена товара, взятая из бд
     */
    public function findOldPriceCat($name, $cat_id, $priceInCurr)
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
                $oldPrice=$oldPrice['goodshascategory_pricecur'];
                //var_dump ($oldPrice);
            }
            mysqli_close($db_connect);
            return $oldPrice;
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
                $oldPrice=$oldPrice['goodshascategory_price'];
                //var_dump ($oldPrice);
            }
            mysqli_close($db_connect);
            return $oldPrice;
        }
    }
    /**
     * находим разницу между новой и старой ценами
     * @param $newPrice int новая цена товара, олученная из прайса
     * @param $oldPrice int старая цена товара, полученная из базы данных
     * @return float|int разница между новой и старой ценами в процентах
     */
    public function priceDif($newPrice, $oldPrice)
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
    /**
     * записываем лог на диск
     */
    public function logWrite()
    {
        if ($this->log)
        {
            foreach ($this->log as $logRec)
            {
                $filename=$this->makeLogName();
                $goods_id=$logRec['goods_id'];
                $cat_id=$logRec['cat_id'];
                $oldPrice=$logRec['oldPrice'];
                $newPrice=$logRec['newPrice'];
                $str="$goods_id;$cat_id;$oldPrice;$newPrice".PHP_EOL;
                file_put_contents($filename,$str,FILE_APPEND);
            }
        }
    }
    /**
     * записываем изменения в таблицу с логами
     * @param $goods_id int id товара
     * @param $cat_id int айди категории
     * @param $oldPrice int старая цена товара
     * @param $newPrice int новая цена товара
     */
    public function logForm($goods_id, $cat_id, $oldPrice, $newPrice)
    {
        $this->log[]=array(
            'goods_id'=>$goods_id,
            '$cat_id'=>$cat_id,
            'oldPrice'=>$oldPrice,
            'newPrice'=>$newPrice
        );
    }
    /**
     * получаем имя фабрики
     * @param $factory_id int id фабрики
     * @return array|null имя фабрики
     */
    public function getFactoryName($factory_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT factory_name FROM factory WHERE factory_id=$factory_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($factory_name);
            while ($row = mysqli_fetch_assoc($res))
            {
                //массив со всеми названиями товара в прайсе
                $factory_name = $row;
            }
            $factory_name=$factory_name['factory_name'];
        }
        if ($factory_name)
        {
            mysqli_close($db_connect);
            return $factory_name;
        }
        else
        {
            mysqli_close($db_connect);
            return null;
        }
    }
    /**
     * получаем имя файла для записи лога
     * @return array|null|string имя файла в формате название фабрики_дата_время.csv
     *
     */
    public function makeLogName()
    {
        $date=date('d-m-y\_H:i:s');
        $name=$this->getFactoryName();
        $name.="_$date.csv";
        return $name;
    }
    /**
     * @return array список имен позиций, которые есть в прайсе, но нет на сайте
     */
    public function findDif()
    {
        $db_connect = mysqli_connect(host, user, pass, db);
        if ($this->data)
        {
            //выбираем все названия товаров в прайсе для фабрики
            $factory_id = $this->factory_id;
			//echo "factory=".$factory_id."<br>";
            $query = "SELECT goods_article_link FROM goods WHERE factory_id=161 or factory_id=163 or factory_id=164 or factory_id=165 or factory_id=166 or factory_id=167".
                " or factory_id=168 or factory_id=169 or factory_id=170 or factory_id=171";
            if ($res = mysqli_query($db_connect, $query))
            {
                unset($site_names);
                while ($row = mysqli_fetch_assoc($res))
                {
                    //массив со всеми названиями товара в прайсе
                    $site_names[] = $row['goods_article_link'];
                }
                //дальше просто сравниваем наши загруженные названия и те, что уже есть на сайте и получаем разницу
                //выбираем в отдельный массив только полученные названия с прайса
                unset($price_names);
                foreach ($this->data as $d)
                {
                    //те названия, что мы прочитали в прайсе
                    $price_names[] = $d['name'];
                }
				//echo "<b>names</b><pre>";
				//print_r ($site_names);
				//echo "</pre>";
                //сравниваем 2 массива и получаем массив, в котором есть названия товаров, которые есть в прайсе, но нет на сайте
                $result = array_diff($price_names, $site_names);
				
				//сравниваем 2 массива и получаем массив, в котором есть названия товаров, которые есть на сайте, но нет в прайсе
				$result2 = array_diff($site_names, $price_names);
            }
        }
        if ($result||$result2)
        {
            echo "<p><b>in price but not on site</b></p>";
			echo "<pre>";
            print_r($result);
            echo "</pre>";
			
			
			echo "<p><b>on site but not in price</b></p>";
			echo "<pre>";
            print_r($result2);
            echo "</pre>";
            mysqli_close($db_connect);
            return $result;
        }
        else
        {
            mysqli_close($db_connect);
            return null;
        }
    }
}
