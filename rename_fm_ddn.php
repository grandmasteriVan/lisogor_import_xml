<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 12.12.2017
 * Time: 14:25
 */

header('Content-type: text/html; charset=UTF-8');
/**
 * database host
 */
//define ("host","localhost");
//define ("host_ddn","localhost");
/**
 *
 */
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
class rename
{
    //изменить сео поля после замены имени!
    /**
     * @param $goods_kind
     * @return array|null
     */
    private function getAllGoodsByTypeFM($goods_kind)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods WHERE goodskind_id=$goods_kind";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row=mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
        }
        else
        {
            echo "Error in SQL in getAllGoodsByTypeFM<br>";
            mysqli_close($db_connect);
            return null;
        }
        mysqli_close($db_connect);
        return $goods;
    }

    /**
     * @param $id
     * @return null
     */
    private function getGoodsNameByIdFM($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_name FROM goods WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row=mysqli_fetch_assoc($res))
            {
                $name=$row['goods_name'];
            }
        }
        else
        {
            echo "Error in SQL in getGoodsNameByIdFM<br>";
            mysqli_close($db_connect);
            return null;
        }
        mysqli_close($db_connect);
        return $name;

    }

    /**
     * @param $feature_id
     * @param $val_id
     * @return array|null
     */
    private function getAllGoodsByFilterDDN($feature_id, $val_id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goods_id FROM goodshasfeatuer WHERE feature_id=$feature_id AND goodshasfeature_valueid=$val_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row=mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
        }
        else
        {
            echo "Error in SQL in getAlltovByTypeFM<br>";
            mysqli_close($db_connect);
            return null;
        }
        mysqli_close($db_connect);
        return $goods;
    }

    /**
     * @param $id
     * @param $name
     */
    private function writeNameFM($id, $name)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_name='$name' WHERE goods_id=$id";
        echo "$query<br>";
        //mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    /**
     * @param $id
     * @return array|null
     */
    private function getGoodsNamesByIdDDN($id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goodshaslang_name, lang_id, goodshaslang_id FROM goodshaslang WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row=mysqli_fetch_assoc($res))
            {
                $goods_names[]=$row;
            }
        }
        else
        {
            echo "Error in SQL in getAlltovByTypeFM<br>";
            mysqli_close($db_connect);
            return null;
        }
        mysqli_close($db_connect);
        return $goods_names;
    }

    /**
     * @param $type
     */
    public function renameFM($type)
    {
        $goods=$this->getAllGoodsByTypeFM($type);
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$this->getGoodsNameByIdFM($id);
            if ($type==26)
            {
                $name=str_replace("Диван ","",$name);
                $name=str_replace("диван ","",$name);
                $name=str_replace(" Диван","",$name);
                $name=str_replace(" диван","",$name);
                $name=str_replace(" угловой","",$name);
                $name=str_replace("угловой ","",$name);
                $name=str_replace("углол ","",$name);
                $name=str_replace(" углол","",$name);
                $name=str_replace(" Угловой","",$name);
                $name=str_replace("Угловой ","",$name);


                $name="Угловой диван ".$name;
                $this->writeNameFM($id,$name);
            }
            if ($type==53)
            {
                $name=str_replace("Кухонный ","",$name);
                $name=str_replace("кухонный ","",$name);
                $name=str_replace(" Кухонный","",$name);
                $name=str_replace(" кухонный","",$name);
                $name=str_replace(" уголок","",$name);
                $name=str_replace("уголок ","",$name);
                $name=str_replace("Уголок ","",$name);
                $name=str_replace(" Уголок","",$name);
                $name=str_replace(" угол","",$name);
                $name=str_replace("угол ","",$name);


                $name=$name." кухонный уголок";
                $this->writeNameFM($id,$name);
            }
        }
    }

    /**
     * @param $goodshaslang_id
     * @param $name
     */
    private function writeNameDDN($goodshaslang_id, $name)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goodshaslang SET goodshaslang_name='$name' WHERE goodshaslang_id=$goodshaslang_id";
        echo "$query<br>";
        //mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    /**
     * @param $feature_id
     * @param $val_id
     */
    public function renameDDN($feature_id,$val_id)
    {
        $goods=$this->getAllGoodsByFilterDDN($feature_id,$val_id);
        foreach ($goods as $good)
        {

            $id=$good['goods_id'];
            $names=$this->getGoodsNamesByIdDDN($id);
            //у каждого товара два имени!
            foreach ($names as $good_name)
            {
                $name=$good['goodshaslang_name'];
                $lang_id=$good['lang_id'];
                $goodshaslang_id=$good['goodshaslang_id'];
                //украинский
                if ($lang_id==3)
                {
                    $name=str_replace("Кутовий ","",$name);
                    $name=str_replace(" Кутовий","",$name);
                    $name=str_replace("кутовий ","",$name);
                    $name=str_replace(" кутовий","",$name);
                    $name=str_replace(" куток","",$name);
                    $name=str_replace("куток ","",$name);
                    $name=str_replace("диван ","",$name);
                    $name=str_replace(" диван","",$name);
                    $name=str_replace("Диван ","",$name);
                    $name=str_replace(" Диван","",$name);

                    $name=$name." угловой";
                    $this->writeNameDDN($goodshaslang_id,$name);
                }
                //русский
                if ($lang_id==1)
                {
                    $name=str_replace("Диван ","",$name);
                    $name=str_replace("диван ","",$name);
                    $name=str_replace(" Диван","",$name);
                    $name=str_replace(" диван","",$name);
                    $name=str_replace(" угловой","",$name);
                    $name=str_replace("угловой ","",$name);
                    $name=str_replace("углол ","",$name);
                    $name=str_replace(" углол","",$name);
                    $name=str_replace(" Угловой","",$name);
                    $name=str_replace("Угловой ","",$name);

                    $name=$name." кутовий";
                    $this->writeNameDDN($goodshaslang_id,$name);

                }
            }
        }
    }
}