<?php
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
//define ("host","localhost");
/**
 *
 */
define ("host","localhost");
/**
 * database username
 */
//define ("user", "root");
define ("user", "optmebli");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "VRYA1Q0R");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "optmebli");

class Link1C
{
    public $data;
    /**
     *
     */
    public $filename;
    /**
     * Link constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    private function ReadFile()
    {
        $handle=fopen($this->filename,"r");
        while (!feof($handle))
        {
            $str=fgets($handle);
			$str=explode(";",$str);
			//для парсинга Велам, закоментить при обычном файлке!
			//$str[0].=";";
			$arr[]=$str;
            //echo "$str<br>";
        }
        if (!empty($arr))
        {
            $this->data = $arr;
        }
        else
        {
            echo "array is empty in ReadFile";
        }
    }

    public function parseGarant()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $this->ReadFile();
        foreach ($this->data as $d)
        {
            $code1c=$d[1];
            $name=$d[0];
            $name="Шкаф-купе".$name;

            $query = "UPDATE goods join goodshaslang on goods.goods_id=goodshaslang.goods_id SET goods.goods_article_1c='$code1c' WHERE goodshaslang.goodshaslang_name like '$name' and goodshaslang.lang_id=1";
            mysqli_query($db_connect,$query);
            echo "$query<br>";
        }
    }
}

class SetFilters
{
    private function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goodshaslang_name from goodshaslang WHERE lang_id=1 AND goodshaslang_active=0 AND goodshaslang_name like '%Шкаф-купе%'";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $goods[] = $row;
                }
        }
        else
        {
            echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        return $goods;
    }

    private function delFeature($goods_id, $feature_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id";
        echo "$query<br>";
        //mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    private function writeName($goods_id, $lang, $name)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goodshasfeature SET goodshaslang_name='$name' WHERE goods_id=$goods_id AND lang_id=$lang";
        echo "$query<br>";
        //mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    function insFilter($goods_id, $feature_id, $value_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="INSERT INTO goodshasfeature (goods_id, feature_id, goodshasfeature_valueid) VALUES ($goods_id, $feature_id, $value_id)";
        echo "$query<br><br>";
        //mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    public function test ()
    {
        $goods=$this->getGoods();
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $name=$good['goodshaslang_name'];
                //echo "<b>$name:</b><br>";
                //вид продукции
                $this->delFeature($id,22);
                $this->insFilter($id,22,117);

                //korpus
                $this->delFeature($id, 7);
                $this->insFilter($id,7,29);

                //cvet
                $this->delFeature($id,4);
                if (mb_stripos($name,"Орех болонья тёмный"))
                {
                    $this->insFilter($id,4,9);
                }
                if (mb_stripos($name,"Дуб сонома"))
                {
                    $this->insFilter($id,4,6);
                }
                if (mb_stripos($name,"Венге"))
                {
                    $this->insFilter($id,4,5);
                }
                if (mb_stripos($name,"Дуб молочный"))
                {
                    $this->insFilter($id,4,7);
                }
                if (mb_stripos($name,"Дуб сонома трюфель"))
                {
                    $this->insFilter($id,4,8);
                }

                //fasad
                if (mb_stripos($name,"ДСП/ДСП"))
                {
                    $this->delFeature($id,6);
                    $this->insFilter($id,6,22);
                    $name_tmp=str_ireplace("ДСП/ДСП", "2 ДСП",$name);
                }
                if (mb_stripos($name,"ДСП/Зеркал"))
                {
                    $this->delFeature($id,6);
                    $this->insFilter($id,6,17);
                    $name_tmp=str_ireplace("ДСП/Зеркало", "ДСП/Зеркало",$name);
                }
                if (mb_stripos($name,"Зеркало/Зеркало"))
                {
                    $this->delFeature($id,6);
                    $this->insFilter($id,6,23);
                    $name_tmp=str_ireplace("Зеркало/Зеркало", "2 Зеркала",$name);
                }
                if (mb_stripos($name,"ДСП/ДСП/ДСП"))
                {
                    $this->delFeature($id,6);
                    $this->insFilter($id,6,116);
                    $name_tmp=str_ireplace("ДСП/ДСП/ДСП", "3 ДСП",$name);
                }
                if (mb_stripos($name,"ДСП/ДСП/Зеркало"))
                {
                    $this->delFeature($id,6);
                    $this->insFilter($id,6,21);
                    $name_tmp=str_ireplace("ДСП/ДСП/Зеркало", "2 ДСП/Зеркало",$name);
                }
                if (mb_stripos($name,"ДСП/Зеркало/Зеркало"))
                {
                    $this->delFeature($id,6);
                    $this->insFilter($id,6,24);
                    $name_tmp=str_ireplace("ДСП/Зеркало/Зеркало", "ДСП/2 Зеркала",$name);
                }
                if (mb_stripos($name,"Зеркало/Зеркало/Зеркало"))
                {
                    $this->delFeature($id,6);
                    $this->insFilter($id,6,171);
                    $name_tmp=str_ireplace("Зеркало/Зеркало/Зеркало", "3 Зеркала",$name);
                }
                if (mb_stripos($name,"ДСП/ДСП/ДСП/ДСП"))
                {
                    $this->delFeature($id,6);
                    $this->insFilter($id,6,157);
                    $name_tmp=str_ireplace("ДСП/ДСП/ДСП/ДСП", "4 ДСП",$name);
                }
                if (mb_stripos($name,"ДСП/ДСП/ДСП/Зеркало"))
                {
                    $this->delFeature($id,6);
                    $this->insFilter($id,6,172);
                    $name_tmp=str_ireplace("ДСП/ДСП/ДСП/Зеркало", "3 ДСП/Зеркало",$name);
                }
                if (mb_stripos($name,"ДСП/ДСП/Зеркало/Зеркало"))
                {
                    $this->delFeature($id,6);
                    $this->insFilter($id,6,43);
                    $name_tmp=str_ireplace("ДСП/ДСП/Зеркало/Зеркало", "2 ДСП/2 Зеркала",$name);
                }
                if (mb_stripos($name,"ДСП/Зеркало/Зеркало/Зеркало"))
                {
                    $this->delFeature($id,6);
                    $this->insFilter($id,6,173);
                    $name_tmp=str_ireplace("ДСП/Зеркало/Зеркало/Зеркало", "ДСП/3 Зеркала",$name);
                }
                if (mb_stripos($name,"Зеркало/Зеркало/Зеркало/Зеркало"))
                {
                    $this->delFeature($id,6);
                    $this->insFilter($id,6,174);
                    $name_tmp=str_ireplace("Зеркало/Зеркало/Зеркало/Зеркало", "4 Зеркала",$name);
                }
                
                $name_tmp=str_ireplace("Шкаф-купе", "Шкаф-купе ",$name_tmp);
                $name_tmp=str_ireplace(" 4дв", "",$name_tmp);
                $name_tmp=str_ireplace(" 3дв", "",$name_tmp);
                $name_tmp=str_ireplace(" 2дв", "",$name_tmp);
                echo "<b>$name:</b>-$name_tmp<br>";
                //break;
            }
        }   
        else
        {
            echo "No array!";

        }   
    }
}

//$test=new Link1C('garant-sklad.txt');
//$test->parseGarant();
$test=new SetFilters();
$test->test();