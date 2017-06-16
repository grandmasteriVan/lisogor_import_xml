<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 01.06.16
 * Time: 10:22
 */
define ("host","localhost");
//define ("host","10.0.0.2");
/**
 * database username
 */
define ("user", "root");
//define ("user", "uh333660_mebli");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "Z7A8JqUh");
/**
 * database name
 */
define ("db", "mebli");
//define ("db", "uh333660_mebli");
//TODO: сделать универсальный скрипт, для этого в зависимости от типа товара надо копировать нужнные фильтры и сеополя

/**
 * Class setFilters
 */
class setFilters
{
    /**
     * @param int $goods_maintcharter
     * @return array|bool
     */
    function all_matr($goods_maintcharter=14)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT * FROM goods WHERE goods_maintcharter=$goods_maintcharter AND goods_active=1 AND goods_noactual=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
                //print_r($arr);
            }
        }
        else
        {
            echo "ERROR in SQL!";
            return false;
        }
        mysqli_close($db_connect);
        return $arr;
    }

    /**
     * @param int $goods_maintcharter
     * @return array
     */
    private function modMatr($goods_maintcharter=14)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_parent, goods_width, goods_height FROM goods WHERE goods_maintcharter=$goods_maintcharter AND goods_parent<>goods_id AND goods_noactual=0 AND goods_active=1";
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

        if (!in_array(33,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлена нагрузка на место!<br>";
        }
        if (!in_array(52,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлен тип матраса!<br>";
        }
        if (!in_array(53,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлен тип пружины!<br>";
        }
        if (!in_array(55,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлена жесткость!<br>";
        }
        if (!in_array(131,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлено количество мест!<br>";
        }
        if (!in_array(193,$feature_id))
        {
            echo "В товаре с ид=$goods_id не проставлен настил!<br>";
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
        $parent_list=$this->parrentMatr();
        $mod_list=$this->modMatr();
        foreach ($parent_list as $parent)
        {
            $parent_id=$parent['goods_id'];
            //прописываем количество мест для родительского товара
            $query="DELETE FROM goodshasfeature WHERE goods_id=$parent_id AND feature_id=131";
            mysqli_query($db_connect,$query);
            //echo $query."<br>";
            $size=$parent['goods_width'];
            if ($size<=900)
            {
                $goodshasfeature_valueint=1;
            }
            if ($size>900&&$size<=1500)
            {
                $goodshasfeature_valueint=3;
            }
            if ($size>1500)
            {
                $goodshasfeature_valueint=2;
            }
            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                "goodshasfeature_valuetext, goods_id, feature_id) ".
                "VALUES ($goodshasfeature_valueint, 0, ".
                "'', $parent_id, 131)";
            mysqli_query($db_connect,$query);
            //echo "<br><br>установили размер родителя: ".$query."<br>";

            //выставляем фильтр тип матраса-тонкие
            $query="DELETE FROM goodshasfeature WHERE goods_id=$parent_id AND feature_id=52 AND goodshasfeature_valueint=25";
            mysqli_query($db_connect,$query);
            //echo $query."<br>";
            $size_h=$parent['goods_height'];
            if ($size_h<=80)
            {
                $goodshasfeature_valueint=25;
            }
            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                "goodshasfeature_valuetext, goods_id, feature_id) ".
                "VALUES ($goodshasfeature_valueint, 0, ".
                "'', $parent_id, 52)";
            mysqli_query($db_connect,$query);
            //echo "<br><br>установили размер родителя: ".$query."<br>";

            //все матрасы - ортопедические!
            $query="DELETE FROM goodshasfeature WHERE goods_id=$parent_id AND feature_id=52 AND goodshasfeature_valueint=22";
            mysqli_query($db_connect,$query);
            //echo $query."<br>";
            $this->setFilter($parent_id,52,22);

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
            $this->filtersCheck($features,$parent_id);
            /*echo "Список фич родителя:<br>";
			echo "<pre>";
			print_r($features);
			echo "</pre>";*/
            /*print_r($features);
            */
            foreach ($mod_list as $mod)
            {
                if ($parent['goods_id']==$mod['goods_parent'])
                {
                    $mod_id=$mod['goods_id'];
                    $mod_size=$mod['goods_width'];
                    //echo "<br><b>$mod_size</b><br>";
                    //дропаем старые записи
                    $query="DELETE FROM goodshasfeature WHERE goods_id=$mod_id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //для каждой фичи записываем ее в БД
                    foreach ($features as $feat)
                    {
                        $goodshasfeature_valueint=$feat['goodshasfeature_valueint'];
                        $goodshasfeature_valuefloat=$feat['goodshasfeature_valuefloat'];
                        $goodshasfeature_valuetext=$feat['goodshasfeature_valuetext'];
                        $feature_id=$feat['feature_id'];
                        //пишем размерность (одно/полтора/двуспальные)
                        if ($feature_id==131)
                        {
                            if ($mod_size<=900)
                            {
                                $goodshasfeature_valueint=1;
                            }
                            if ($mod_size>900&&$mod_size<=1500)
                            {
                                $goodshasfeature_valueint=3;
                            }
                            if ($mod_size>1500)
                            {
                                $goodshasfeature_valueint=2;
                            }
                        }
                        //не пишем ненужные значния
                        if ($feature_id==33||$feature_id==52||$feature_id==53||$feature_id==55||$feature_id==131||$feature_id==193)
                        {
                            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                                "goodshasfeature_valuetext, goods_id, feature_id) ".
                                "VALUES ($goodshasfeature_valueint, $goodshasfeature_valuefloat, ".
                                "'$goodshasfeature_valuetext', $mod_id, $feature_id)";
                            mysqli_query($db_connect,$query);
                            //echo $query."<br>";
                        }
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
