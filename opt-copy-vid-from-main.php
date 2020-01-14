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
//define ("db", "opt");
define ("db", "optmebli");

class CopyVid
{
    private function getMainGoods($catId=4)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id from goods WHERE goods_mod=0 AND category_id=$catId";
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

    private function getAllSubordinate($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id from goods WHERE goods_mod=$id";
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

    private function getCont($id,$lang)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_content from goodshaslang WHERE goods_id=$id AND lang_id=$lang";
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
        return $goods[0]['goodshaslang_content'];
    }

    private function writeCont($id,$lang,$cont)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goodshaslang SET goodshaslang_content='$cont' WHERE goods_id=$id AND lang_id=$lang";
        //echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    private function getName($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_name from goodshaslang WHERE goods_id=$id AND lang_id=1";
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
        return $goods[0]['goodshaslang_name'];
    }

    public function copyVids()
    {
        $goods=$this->getMainGoods();
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $contMainRu=$this->getCont($id,1);
            $contMainUa=$this->getCont($id,3);
            $SubGoods=$this->getAllSubordinate($id);
            $name=$this->getName($id);
            foreach($SubGoods as $subGood)
            {
                $subId=$subGood['goods_id'];
                $this->writeCont($subId,1,$contMainRu);
                $this->writeCont($subId,3,$contMainUa);
            }
            echo "main=$id $name<br>";
            //echo "<pre>";
            //print_r ($SubGoods);
            //echo "</pre>";
            echo "$contMainRu<br>";
            //break;
        }
    }
}

$test = new CopyVid();
$test->copyVids();
