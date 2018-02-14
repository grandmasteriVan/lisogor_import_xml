<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 14.02.2018
 * Time: 10:40
 */
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
define ("user", "fm");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "T6n7C8r1");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "fm");
class FiltersSHK
{
    private function getAllSHK()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods WHERE goodskind_id=35";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
				//break;
            }
        }
        else
        {
            echo "Error in SQL".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
        if (is_array($arr))
        {
            return $arr;
        }
        else
        {
            return null;
        }
    }
    private function getFilterForGood($goods_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT * FROM goodshasfeature WHERE goods_id=$goods_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $filters[] = $row;
            }
        }
        else
        {
            echo "Error in SQL: ".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
        if (is_array($filters))
        {
            return $filters;
        }
        else
        {
            return null;
        }
    }
    private function writeLog($goods_id, $feature_id, $feature_val, $operation)
    {
        $file_string="ID: $goods_id FEATURE: $feature_id VALUE: $feature_val ACTION: $operation".PHP_EOL;
        echo "$file_string<br>";
		file_put_contents("filtersSHK_log.txt",$file_string,FILE_APPEND);
    }
    private function checkDuplicate($id,$feature_id,$val_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshasfeature_id FROM goodshasfeature WHERE goods_id=$id AND feature_id=$feature_id AND goodshasfeature_valueint=$val_id";
        //echo $query."<br>";
		unset($art);
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $f_ids[] = $row;
            }
            if (is_array($f_ids))
            {
                foreach ($f_ids as $article)
                {
                    //получаем нужный текст
                    $art=$article['goodshasfeature_id'];
                }
            }
        }
        else
        {
            echo "error in SQL $query<br>";
        }
        //mysqli_query($db_connect, $query);
        //var_dump ($art);
		//var_dump ($art);
		//echo "<br>";
        if (is_null($art))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    private function remFilter($goods_id,$feature_id,$val_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="DELETE FROM goodshasfeature WHERE goods_id=$goods_id AND feature_id=$feature_id AND goodshasfeature_valueint=$val_id";
        $this->writeLog($goods_id,$feature_id,$val_id,"delete");
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }
    private function setFilter($goods_id,$feature_id,$val_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
            "goodshasfeature_valuetext, goods_id, feature_id) ".
            "VALUES ($val_id,0,'',$goods_id,$feature_id)";
        //проверка нет ли уже такого фильтра
        if ($this->checkDuplicate($goods_id,$feature_id,$val_id))
        {
            echo "goods_id: $goods_id Already has feature: $feature_id and value: $val_id<br>";
        }
        else
        {
			$this->writeLog($goods_id,$feature_id,$val_id,"create");
            mysqli_query($db_connect,$query);
        }
        mysqli_close($db_connect);
    }
    public function setFiltersSHL()
    {
        $goods=$this->getAllSHK();
		//var_dump($goods);
        if (!is_null($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $filters=$this->getFilterForGood($id);
                if (!is_null($filters))
                {
                    foreach ($filters as $filter)
                    {
                        $feature_id=$filter['feature_id'];
                        $val_id=$filter['goodshasfeature_valueint'];
                        //лдсп16-дсп
                        if ($feature_id==16&&$val_id==11)
                        {
                            $this->remFilter($id,16,11);
                            $this->setFilter($id,16,3);
                        }
                        //лдсп18-дсп
                        if ($feature_id==16&&$val_id==12)
                        {
                            $this->remFilter($id,16,12);
                            $this->setFilter($id,16,3);
                        }
						//ламинир дсп-дсп
                        if ($feature_id==16&&$val_id==6)
                        {
                            $this->remFilter($id,16,6);
                            $this->setFilter($id,16,3);
                        }
                        //стиль современный
                        if ($feature_id==18&&$val_id==14)
                        {
                            $this->remFilter($id,18,14);
                            $this->setFilter($id,18,10);
                        }
                        //расположение
                        if ($feature_id==129&&$val_id==3)
                        {
                            $this->remFilter($id,129,3);
                            $this->setFilter($id,129,6);
                        }
                    }
                }
                else
                {
                    echo "No filters for id=$id<br>";
					
                }
                //break;
            }
        }
        else
        {
            echo "No goods to work with<br>";
        }
    }
}

$test=new FiltersSHK();
$test->setFiltersSHL();
