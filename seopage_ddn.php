<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 18.07.17
 * Time: 09:27
 */
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
define("host","localhost");
//define ("host","localhost");
/**
 * database username
 */
define ("user", "root");
//define ("user", "u_divani_n");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "EjcwKUYK");
/**
 * database name
 */
define ("db", "ddn_new");
//define ("db", "divani_new");

class SeoPage
{
    /**
     * @return array
     */
    private function getGoodsId()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_article FROM goods";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            if (is_array($goods))
            {
                unset ($ids);
                foreach ($goods as $good)
                {
                    //получаем нужный текст
                    $ids[]=$good['goods_id'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $ids;
    }

    /**
     * @param $id
     * @return mixed
     */
    private function getSizeId($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_mainsize FROM goods WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $sizes[] = $row;
            }
            if (is_array($sizes))
            {
                unset ($goodsSizeId);
                foreach ($sizes as $size)
                {
                    $goodsSizeId=$size['goods_mainsize'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $goodsSizeId;
    }

    /**
     * @param $id
     * @return mixed
     */
    private function getMainSizeLen($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $sizeId=$this->getSizeId($id);
        $query="SELECT size_len FROM size WHERE size_id=$sizeId";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $sizes[] = $row;
            }
            if (is_array($sizes))
            {
                unset ($goodsLen);
                foreach ($sizes as $size)
                {
                    $goodsLen=$size['goods_mainsize'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $goodsLen;

    }

    /**
     * @param $id
     * @return mixed
     */
    private function getMainSizeSl($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $sizeId=$this->getSizeId($id);
        $query="SELECT size_len FROM size WHERE size_id=$sizeId";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $sizes[] = $row;
            }
            if (is_array($sizes))
            {
                unset ($goodsLen);
                foreach ($sizes as $size)
                {
                    $goodsLen=$size['goods_mainsize'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $goodsLen;
    }

    /**
     * @param $id
     * @return bool
     */
    private function isCorner($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goodshasfeature WHERE feature_id=14 AND goodshasfeature_valueid=56 AND goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $corners[] = $row;
            }
            if (is_array($corners))
            {
                $isCorner=true;
            }
            else
            {
                $isCorner=false;
            }
        }
        mysqli_close($db_connect);
        return $isCorner;
    }

    /**
     *
     */
    public function setSmallCorner()
    {
        $all_div=$this->getGoodsId();
        $smallCornerStr="";
        foreach ($all_div as $div)
        {
            $id=$div['goods_id'];
            $article=$div['goods_article'];
            if ($this->isCorner($id))
            {
                $len=$this->getMainSizeLen($id);
                if ($len<2200)
                {
                    $smallCornerStr.=", $article";
                }
            }
        }
        echo $smallCornerStr."<br>";
    }
}

$test=new SeoPage();
$test->setSmallCorner();