<?php
header('Content-Type: text/html; charset=utf-8');

define ("host_ddn","es835db.mirohost.net");
define ("user_ddn", "u_fayni");
define ("pass_ddn", "ZID1c0eud3Dc");
define ("db_ddn", "ddnPZS");

class MakeDisc
{
    private function getGoods($fId)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goods_id FROM goodshasfeature WHERE feature_id=14 AND goodshasfeature_valueid=$fId AND goods_id IN (SELECT goods_id FROM goodshasfeature WHERE feature_id=6 AND goodshasfeature_valueid=55)";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $goods_straight[] = $row;
                }
        }
        else
        {
            echo "Error in SQL: $query<br>";		
        }
        $query="SELECT goods_id FROM goodshasfeature WHERE feature_id=14 AND goodshasfeature_valueid=$fId AND goods_id IN (SELECT goods_id FROM goodshasfeature WHERE feature_id=6 AND (goodshasfeature_valueid=56 OR goodshasfeature_valueid=57))";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $goods_corner[] = $row;
                }
        }
        else
        {
            echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        $goods[0]=$goods_straight;
        $goods[1]=$goods_corner;
        //var_dump ($goods);
        
        return $goods;
    }

    private function setDiscount($disc_id,$goods_id,$goods_type)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="INSERT INTO discounthasgoods (discount_id,goods_id,discounthasgoods_discountcat_id) VALUES ($disc_id,$goods_id,$goods_type)";
        echo "$query<br>";
        //mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    public function discount($fId)
    {
        $goods=$this->getGoods($fId);
        //echo "<pre>";
        //print_r ($goods);
        //echo "</pre>";
        $goods_straight=$goods[0];
        foreach ($goods_straight as $good)
        {
            $id=$good['goods_id'];
            $this->setDiscount(10,$id,1);

        }
        $goods_corner=$goods[1];
        foreach ($goods_corner as $good)
        {
            $id=$good['goods_id'];
            $this->setDiscount(10,$id,2);

        }

    }
}

$test=new MakeDisc();
$test->discount(91);
$test->discount(82);
