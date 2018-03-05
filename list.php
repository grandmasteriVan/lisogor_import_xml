<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.03.2018
 * Time: 14:00
 */

header('Content-type: text/html; charset=UTF-8');
//define ("host","localhost");
//define ("host_ddn","localhost");
define ("host_ddn","es835db.mirohost.net");
define ("host","localhost");
/**
 * database username
 */
//define ("user", "root");
//define ("user_ddn", "root");
define ("user_ddn", "u_fayni");
define ("user", "fm");
/**
 * database password
 */
//define ("pass", "");
//define ("pass_ddn", "");
define ("pass_ddn", "ZID1c0eud3Dc");
define ("pass", "T6n7C8r1");
/**
 * database name
 */
//define ("db", "mebli");
//define ("db_ddn", "ddn_new");
define ("db_ddn", "ddnPZS");
define ("db", "fm");

class listDDN
{
    private function getAllGoods()
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goods_id, cachegoods_minprice FROM cachegoods WHERE cachegoods_minprice<15001";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
    }

    private function getUrlsById($id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goodshaslang_url FROM goodshaslang WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }

    private function getUrlidByUrl($url)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT url_id FROM url WHERE url_name='$url'";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }


    private function findRewiev($id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT review_id FROM review WHERE url_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return true;
        }
        else
        {
            return null;
        }
    }

    private function isStraight($id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goodshasfaeture_valueid FROM goodshasfaeture WHERE goods_id=$id AND faeture_id=55";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return true;
        }
        else
        {
            return null;
        }
    }

    private function isUgol($id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goodshasfaeture_valueid FROM goodshasfaeture WHERE goods_id=$id AND faeture_id=56";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return true;
        }
        else
        {
            return null;
        }
    }


    public function getList()
    {
        $goods=$this->getAllGoods();
        foreach ($goods as $good)
        {
            $id=$good('goods_id');
            $price=$good('cachegoods_minprice');
            if ($this->isStraight($id)&&$price<=10000)
            {
                $straight[]=$good;
                //break;
            }
            if ($this->isUgol($id)&&$price<=15000)
            {
                $ugol[]=$good;
            }
        }
        if (is_array($straight))
        {
            foreach ($straight as $item)
            {
                $id=$item['goods_id'];
                $url=$this->getUrlsById($id);
                $urlId=$this->getUrlidByUrl($url);
                if($this->findRewiev($urlId))
                {
                    $straigthWihtRew[]=$item;
                }
            }
        }
        var_dump($straigthWihtRew);
        echo "<br><br>";

        if (is_array($ugol))
        {
            foreach ($ugol as $item)
            {
                $id=$item['goods_id'];
                $url=$this->getUrlsById($id);
                $urlId=$this->getUrlidByUrl($url);
                if($this->findRewiev($urlId))
                {
                    $ugolWihtRew[]=$item;
                }
            }
        }
        var_dump($ugolWihtRew);
    }

}