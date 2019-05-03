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

class SetFactoryClass
{
    private function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id from goodshaslang WHERE lang_id=1 AND goodshaslang_name like '%Кухня%'";
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

    private function getGoodsNoFactory()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id from goods WHERE goods_factory=0";
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



    private function setFactory($id,$f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_factory=$f_id WHERE goods_id=$id";
        echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    public function test()
    {
        $goods=$this->getGoodsNoFactory();
        var_dump($goods);

        /*$goods=$this->getGoods();
        if (is_array($goods))
        {
            foreach($goods as $good)
            {
                $id=$good['goods_id'];
                //garant shk
                //$f_id=9;
                //кухни
                $f_id=10;
                $this->setFactory($id,$f_id);
            }

        }
        else
        {
            echo "No goods!";
        }*/
    }

}

$test=new SetFactoryClass();
$test->test();