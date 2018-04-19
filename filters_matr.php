<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 01.06.16
 * Time: 10:22
 */
 header('Content-type: text/html; charset=UTF-8');
//define ("host","localhost");
define ("host","10.0.0.2");
/**
 * database username
 */
//define ("user", "root");
define ("user", "uh333660_mebli");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "Z7A8JqUh");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "uh333660_mebli");
//TODO: сделать универсальный скрипт, для этого в зависимости от типа товара надо копировать нужнные фильтры и сеополя

class imgCopy
{
    private function parrentMatr($goods_maintcharter=14)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_parent, goods_width, goods_height FROM goods WHERE goods_maintcharter=$goods_maintcharter and goods_parent=goods_id AND goods_noactual=0 AND goods_active=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
        }
        mysqli_close($db_connect);
        /*echo "<pre>";
        print_r ($arr);
        echo "</pre>";*/
        return $arr;
    }

    private function getMainPic($goods_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_pict FROM goods WHERE goods_id=$goods_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
            if (is_array($arr))
            {
                foreach ($arr as $ar)
                {
                    $pict=$ar['goods_pict'];
                }
            }
            else
            {
                echo "No array!";
                $pict=null;
            }

        }
        else
        {
            echo "Error in SQL in $query function getMainPic<br>";
            $pict=null;
        }
        mysqli_close($db_connect);
        return $pict;
    }

    private function getGaleryPicts($goods_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT * FROM goodsfile WHERE goods_id=$goods_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
            $pict=$arr;
        }
        else
        {
            echo "Error in SQL in $query function getGaleryPicts<br>";
            $pict=null;
        }
        mysqli_close($db_connect);
        return $pict;
    }

    private function setMainPict($goods_id, $pict)
    {

    }
}

/**
 * Class setFilters
 */
class setFilters
{
    /**
     * @param int $goods_maintcharter
     * @return array
     */
    private function modMatr($goods_maintcharter=14)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_parent, goods_width, good_length, goods_height FROM goods WHERE goods_maintcharter=$goods_maintcharter AND goods_parent<>goods_id AND goods_noactual=0 AND goods_active=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
        }
        mysqli_close($db_connect);
        return $arr;
    }
    /**
     * @param int $goods_maintcharter
     * @return array
     */
    private function parrentMatr($goods_maintcharter=14)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_parent, goods_width, good_length, goods_height FROM goods WHERE goods_maintcharter=$goods_maintcharter and goods_parent=goods_id AND goods_noactual=0 AND goods_active=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
        }
        mysqli_close($db_connect);
        /*echo "<pre>";
        print_r ($arr);
        echo "</pre>";*/
        return $arr;
    }
    /**
     * @param $filters
     * @param $goods_id
     */
    private function filtersCheck($filters, $goods_id)
    {
        unset ($feature_id);
        foreach ($filters as $filter)
        {
            $feature_id[]=$filter['feature_id'];
        }
        /*echo "<pre>";
        print_r ($feature_id);
        echo "</pre>";*/
        if (!in_array(221,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлен размер!<br>";
        }
        if (!in_array(93,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлена высота!<br>";
        }
        if (!in_array(33,$feature_id))
        {
            echo "В товаре с ид=$goods_id не прооставлена нагрузка на место!<br>";
        }
        if (!in_array(192,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлено количество мест!<br>";
        }
        if (!in_array(52,$feature_id))
        {
            echo "В товаре с ид=$goods_id не прставлен тип матраса!<br>";
        }
        if (!in_array(53,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлен тип пружины!<br>";
        }
        if (!in_array(55,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлена жесткость!<br>";
        }
        if (!in_array(54,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлено наполнение!<br>";
        }
        if (!in_array(56,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлены особенности!<br>";
        }
        if (!in_array(147,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлено назначение!<br>";
        }
        return;
    }
    private function setFilter ($goods_id,$feature_id,$goodshasfeature_valueint)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
            "goodshasfeature_valuetext, goods_id, feature_id) ".
            "VALUES ($goodshasfeature_valueint, 0, ".
            "'', $goods_id, $feature_id)";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }
    /**
     *
     */
    public function copyFilters()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        //return;
		$parent_list=$this->parrentMatr();
        $mod_list=$this->modMatr();
		//return;
        foreach ($parent_list as $parent)
        {
            $parent_id=$parent['goods_id'];


            //прописываем количество мест для родительского товара
            $query="DELETE FROM goodshasfeature WHERE goods_id=$parent_id AND feature_id=192";
            mysqli_query($db_connect,$query);
            //echo $query."<br>";
            $size=$parent['goods_width'];
            if ($size<=900)
            {
                $goodshasfeature_valueint=10;
            }
            if ($size>900&&$size<=1200)
            {
                $goodshasfeature_valueint=11;
            }
            if ($size>1200&&$size<=1400)
            {
                $goodshasfeature_valueint=12;
            }
            if ($size>1400)
            {
                $goodshasfeature_valueint=14;
            }
            $this->setFilter($parent_id,131,$goodshasfeature_valueint);
            //echo "<br><br>установили размер родителя: ".$query."<br>";
            //выставляем фильтр тип матраса-тонкие
            //$query="DELETE FROM goodshasfeature WHERE goods_id=$parent_id AND feature_id=52 AND goodshasfeature_valueint=25";
            //mysqli_query($db_connect,$query);
            //echo $query."<br>";

            //Устанавливаем высоту матраса
            $query="DELETE FROM goodshasfeature WHERE goods_id=$parent_id AND feature_id=93";
            mysqli_query($db_connect,$query);
            //echo $query."<br>";
            $size_h=$parent['goods_height'];
            if ($size_h<100)
            {
                $goodshasfeature_valueint=50;
				$this->setFilter($parent_id,93,$goodshasfeature_valueint);
            }
            if ($size_h>=100&&$size_h<=150)
            {
                $goodshasfeature_valueint=51;
                $this->setFilter($parent_id,93,$goodshasfeature_valueint);
            }
            if ($size_h>=160&&$size_h<=200)
            {
                $goodshasfeature_valueint=52;
                $this->setFilter($parent_id,93,$goodshasfeature_valueint);
            }
            if ($size_h>=210&&$size_h<=250)
            {
                $goodshasfeature_valueint=53;
                $this->setFilter($parent_id,93,$goodshasfeature_valueint);
            }
            if ($size_h>250)
            {
                $goodshasfeature_valueint=54;
                $this->setFilter($parent_id,93,$goodshasfeature_valueint);
            }
            //устанавливем размеры матраса
            $query="DELETE FROM goodshasfeature WHERE goods_id=$parent_id AND feature_id=211";
            mysqli_query($db_connect,$query);
            $size_l=$parent['good_length'];
            if ($size==600&&$size_l==1200)
            {
                $this->setFilter($parent_id,211,1);
            }
            if ($size==700&&$size_l==1400)
            {
                $this->setFilter($parent_id,211,2);
            }
            if ($size==700&&$size_l==1900)
            {
                $this->setFilter($parent_id,211,3);
            }
            if ($size==700&&$size_l==2000)
            {
                $this->setFilter($parent_id,211,4);
            }
            if ($size==800&&$size_l==1600)
            {
                $this->setFilter($parent_id,211,5);
            }
            if ($size==800&&$size_l==1900)
            {
                $this->setFilter($parent_id,211,6);
            }
            if ($size==800&&$size_l==2000)
            {
                $this->setFilter($parent_id,211,7);
            }
            if ($size==900&&$size_l==1900)
            {
                $this->setFilter($parent_id,211,8);
            }
            if ($size==900&&$size_l==2000)
            {
                $this->setFilter($parent_id,211,9);
            }
            if ($size==1000&&$size_l==1900)
            {
                $this->setFilter($parent_id,211,10);
            }
            if ($size==1000&&$size_l==2000)
            {
                $this->setFilter($parent_id,211,11);
            }
            if ($size==1200&&$size_l==1900)
            {
                $this->setFilter($parent_id,211,12);
            }
            if ($size==1200&&$size_l==2000)
            {
                $this->setFilter($parent_id,211,13);
            }
            if ($size==1400&&$size_l==1900)
            {
                $this->setFilter($parent_id,211,14);
            }
            if ($size==1400&&$size_l==2000)
            {
                $this->setFilter($parent_id,211,15);
            }
            if ($size==1500&&$size_l==1900)
            {
                $this->setFilter($parent_id,211,16);
            }
            if ($size==1500&&$size_l==2000)
            {
                $this->setFilter($parent_id,211,17);
            }
            if ($size==1600&&$size_l==1900)
            {
                $this->setFilter($parent_id,211,18);
            }
            if ($size==1600&&$size_l==2000)
            {
                $this->setFilter($parent_id,211,19);
            }
            if ($size==1700&&$size_l==1900)
            {
                $this->setFilter($parent_id,211,20);
            }
            if ($size==1700&&$size_l==2000)
            {
                $this->setFilter($parent_id,211,21);
            }
            if ($size==1800&&$size_l==1900)
            {
                $this->setFilter($parent_id,211,22);
            }
            if ($size==1800&&$size_l==2000)
            {
                $this->setFilter($parent_id,211,23);
            }
            if ($size==1900&&$size_l==1900)
            {
                $this->setFilter($parent_id,211,24);
            }
            if ($size==1900&&$size_l==2000)
            {
                $this->setFilter($parent_id,211,25);
            }
            if ($size==2000&&$size_l==2000)
            {
                $this->setFilter($parent_id,211,26);
            }
            if ($size==2000&&$size_l==2200)
            {
                $this->setFilter($parent_id,211,27);
            }






            //echo "<br><br>установили размер родителя: ".$query."<br>";
            //все матрасы - ортопедические!
            //$query="DELETE FROM goodshasfeature WHERE goods_id=$parent_id AND feature_id=52 AND goodshasfeature_valueint=22";
            //mysqli_query($db_connect,$query);
            //echo $query."<br>";
            //$this->setFilter($parent_id,52,22);
            //выбираем список фич для родительского товара
            $query="SELECT * FROM goodshasfeature WHERE goods_id=$parent_id";
            if ($res=mysqli_query($db_connect,$query))
            {
                //не забываем обнулять список перед заполнением!
                $features=null;
                while ($row=mysqli_fetch_assoc($res))
                {
                    $features[]=$row;
                }
                if (!is_array($features))
                {
                    echo "Нет списка фич родительского товара!";
                }
            }
            //нагрузка на место
            //у на в массиве уже есть список фич, сначала удаляем оригинальную фичу из БД
            //потом смотрим в сохраненом масиве ее значение и пишем в БД новое значение
            $query="DELETE FROM goodshasfeature WHERE goods_id=$parent_id AND feature_id=33";
            mysqli_query($db_connect,$query);
            //проверяем старое значение и пишем новое
            foreach ($features as $feature)
            {
                $feature_id=$feature['feature_id'];
                $f_val=$feature['goodshasfeature_valueint'];
                if ($feature_id==33&&($f_val==4||$f_val==5))
                {
                    $this->setFilter($parent_id,33,10);
                }
                if ($feature_id==33&&($f_val==6||$f_val==7||$f_val==1))
                {
                    $this->setFilter($parent_id,33,11);
                }
                if ($feature_id==33&&($f_val==8||$f_val==9))
                {
                    $this->setFilter($parent_id,33,12);
                }
                if ($feature_id==33&&($f_val==13||$f_val==2||$f_val==3))
                {
                    $this->setFilter($parent_id,33,11);
                }
            }

            //проверяем заполнение фильтров
            $query="SELECT * FROM goodshasfeature WHERE goods_id=$parent_id";
            if ($res=mysqli_query($db_connect,$query))
            {
                //не забываем обнулять список перед заполнением!
                $features=null;
                while ($row=mysqli_fetch_assoc($res))
                {
                    $features[]=$row;
                }
                if (!is_array($features))
                {
                    echo "Нет списка фич родительского товара!";
                }
            }
            $this->filtersCheck($features,$parent_id);
            /*echo "Список фич родителя:<br>";
			echo "<pre>";
			print_r($features);
			echo "</pre>";*/
            /*print_r($features);
            */
            foreach ($mod_list as $mod)
            {
                if ($parent['goods_id'] == $mod['goods_parent'])
                {
                    $mod_id = $mod['goods_id'];
                    $mod_size = $mod['goods_width'];
                    $mod_size_l = $mod['good_length'];
                    //echo "<br><b>$mod_size</b><br>";
                    //дропаем старые записи
                    $query = "DELETE FROM goodshasfeature WHERE goods_id=$mod_id";
                    mysqli_query($db_connect, $query);
                    //echo $query."<br>";
                    //для каждой фичи записываем ее в БД
                    foreach ($features as $feat)
                    {
                        //echo "копируем фильтры<br>";
                        $goodshasfeature_valueint = $feat['goodshasfeature_valueint'];
                        $goodshasfeature_valuefloat = $feat['goodshasfeature_valuefloat'];
                        $goodshasfeature_valuetext = $feat['goodshasfeature_valuetext'];
                        $feature_id = $feat['feature_id'];
                        //пишем размерность (одно/полтора/двуспальные)

                        //не пишем ненужные значния
                        if ($feature_id == 93 || $feature_id == 33 || $feature_id == 52 || $feature_id == 53 || $feature_id == 55 || $feature_id == 54 || $feature_id == 56 || $feature_id == 147) {
                            $query = "INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, " .
                                "goodshasfeature_valuetext, goods_id, feature_id) " .
                                "VALUES ($goodshasfeature_valueint, $goodshasfeature_valuefloat, " .
                                "'$goodshasfeature_valuetext', $mod_id, $feature_id)";
                            mysqli_query($db_connect, $query);
                            //echo "Удачно!<br>";
                            //echo $query."<br>";
                        }
                    }
                    //////////////////////
                    ///пишем размеры
                    if ($mod_size <= 900)
                    {
                        //$goodshasfeature_valueint=1;
                        $this->setFilter($mod_id, 192, 1);
                    }
                    if ($mod_size > 900 && $mod_size <= 1500)
                    {
                        //$goodshasfeature_valueint=3;
                        $this->setFilter($mod_id, 192, 3);
                    }
                    if ($mod_size > 1500)
                    {
                        //$goodshasfeature_valueint=2;
                        $this->setFilter($mod_id, 192, 2);
                    }
                    //пишем размер
                    if ($mod_size == 600 && $mod_size_l == 1200)
                    {
                        //$goodshasfeature_valueint=1;
                        $this->setFilter($mod_id, 211, 2);
                    }
                    if ($mod_size == 700 && $mod_size_l == 1400)
                    {
                        $this->setFilter($mod_id, 211, 2);
                    }
                    if ($mod_size == 700 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 3);
                    }
                    if ($mod_size == 700 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 4);
                    }
                    if ($mod_size == 800 && $mod_size_l == 1600)
                    {
                        $this->setFilter($mod_id, 211, 5);
                    }
                    if ($mod_size == 800 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 6);
                    }
                    if ($mod_size == 800 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 7);
                    }
                    if ($mod_size == 900 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 8);
                    }
                    if ($mod_size == 900 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 9);
                    }
                    if ($mod_size == 1000 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 10);
                    }
                    if ($mod_size == 1000 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 11);
                    }
                    if ($mod_size == 1200 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 12);
                    }
                    if ($mod_size == 1200 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 13);
                    }
                    if ($mod_size == 1400 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 14);
                    }
                    if ($mod_size == 1400 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 15);
                    }
                    if ($mod_size == 1500 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 16);
                    }
                    if ($mod_size == 1500 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 17);
                    }
                    if ($mod_size == 1600 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 18);
                    }
                    if ($mod_size == 1600 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 19);
                    }
                    if ($mod_size == 1700 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 20);
                    }
                    if ($mod_size == 1700 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 21);
                    }
                    if ($mod_size == 1800 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 22);
                    }
                    if ($mod_size == 1800 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 23);
                    }
                    if ($mod_size == 1900 && $mod_size_l == 1900)
                    {
                        $this->setFilter($mod_id, 211, 24);
                    }
                    if ($mod_size == 1900 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 25);
                    }
                    if ($mod_size == 2000 && $mod_size_l == 2000)
                    {
                        $this->setFilter($mod_id, 211, 26);
                    }
                    if ($mod_size == 2000 && $mod_size_l == 2200)
                    {
                        $this->setFilter($mod_id, 211, 27);
                    }
                }

            }

            //break;
        }
    }
}
/**
 * Class Timer
 */
class Timer
{
    /**
     * @var время начала выпонения
     */
    private $start_time;
    /**
     * @var время конца выполнения
     */
    private $end_time;
    /**
     * встанавливаем время начала выполнения скрипта
     */
    public function setStartTime()
    {
        $this->start_time = microtime(true);
    }
    /**
     * устанавливаем время конца выполнения скрипта
     */
    public function setEndTime()
    {
        $this->end_time = microtime(true);
    }
    /**
     * @return mixed время выполения
     * возвращаем время выполнения скрипта в секундах
     */
    public function getRunTime()
    {
        return $this->end_time-$this->start_time;
    }
}
$runtime = new Timer();
$runtime->setStartTime();
$test=new setFilters();
$test->copyFilters();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
