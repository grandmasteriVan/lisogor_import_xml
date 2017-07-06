<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 29.06.17
 * Time: 12:36
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

class FM
{
    private function getTovByFactory ($f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_name FROM goods WHERE factory_id=$f_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $tovByFactoty[]=$row;
            }
        }
        else
        {
            echo "error in SQL $query<br>";
        }
        mysqli_close($db_connect);
        if (is_array($tovByFactoty))
        {
            return $tovByFactoty;
        }
        else
        {
            return null;
        }
    }

    private function getFactoryList()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT factory_id FROM factory WHERE factory_id=$f_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $tovByFactoty[]=$row;
            }
        }
        else
        {
            echo "error in SQL $query<br>";
        }
        mysqli_close($db_connect);
        if (is_array($tovByFactoty))
        {
            return $tovByFactoty;
        }
        else
        {
            return null;
        }

    }

    private function getEqual($div_fm, $div_ddb)
    {
        if (strnatcasecmp($div_fm,$div_ddb)==0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function strip($div)
    {
        $div_new=str_replace("Диван","",$div);
        $div_new=str_replace("Угловой","",$div_new);
        $div_new=str_replace("угловой","",$div_new);
        $div_new=str_replace("диван","",$div_new);

        return $div_new;
    }

    function getEqualFactory()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT factiry_id, factory_div FROM factory";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $tovByFactoty[]=$row;
            }

        }
        else
        {
            echo "Error in SQL $query<br>";
        }
        mysqli_close($db_connect);
    }
}