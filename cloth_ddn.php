<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.06.2018
 * Time: 14:14
 */
define ("host_ddn","es835db.mirohost.net");
define ("user_ddn", "u_fayni");
define ("pass_ddn", "ZID1c0eud3Dc");
define ("db_ddn", "ddnPZS");

class SetClass
{
    private function translatePos($txt)
    {
        $api_key="trnsl.1.1.20170706T112229Z.752766fa973319f4.6dcbe2932c5e110da20ee3ce61c5986e7e492e7f";
        $lang="ru-uk";
        $txt=str_replace(" ","%20",$txt);
        $link="https://translate.yandex.net/api/v1.5/tr.json/translate?key=".$api_key."&text=".$txt."&lang=".$lang;
        //echo $link."<br>";
        $result=file_get_contents($link);
        $result=json_decode($result,true);
        $ukr_txt=$result['text'][0];
        //var_dump($result);
        return $ukr_txt;
    }

    private function getCloth()
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $f_id=$this->f_id;
        $query="SELECT cloth_id, clothtype_id FROM cloth";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
        }
        else
        {
            echo "Error in SQL ".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
        if (is_array($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }

    public function setDescr()
    {
        $cloths=$this->getCloth();
        if (is_array($cloths))
        {
            foreach ($cloths as $cloth)
            {
                $id=$cloth['cloth_id'];
                $type=$cloth['clothtype_id'];

            }
        }
        else
        {
            echo "No array of Cloth<br>";
        }
    }
}