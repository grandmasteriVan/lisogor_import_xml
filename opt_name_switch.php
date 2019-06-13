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

class swapName
{
    private function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goodshaslang_name from goodshaslang WHERE lang_id=3 AND goodshaslang_active=1 AND goodshaslang_name like '%Шкаф-купе%'";
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

    public function swap ()
    {
        $goods=$this->getGoods();
        $db_connect=mysqli_connect(host,user,pass,db);
        if (is_array ($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $name_ukr=$good['goodshaslang_name'];
                echo "$id $name_ukr<br>";
                $query="UPDATE goodshaslang SET goodshaslang_name='$name_ukr' WHERE goods_id=$id AND lang_id=1";
                echo "$query<br>";
                mysqli_query($db_connect,$query);

            }
            
        }
        mysqli_close($db_connect);

    }
} 

$test=new swapName();
$test->swap();