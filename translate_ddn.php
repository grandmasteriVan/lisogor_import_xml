<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 06.07.17
 * Time: 11:44
 */

header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
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

/**
 * Class TranslateDdn
 */
class TranslateDdn
{
    /**
     * переводим текст с помощью Яндекс.переводчик
     * @param $txt string - текст, который нам надо перевести
     * @return string - результат перевода
     */
    private function translatePos($txt)
    {
        $api_key="";
        $lang="ru-ua";
        $link="https://translate.yandex.ru/api/v1.5/tr.json/translate?key=".$api_key."&text=".$txt."&lang=".$lang;
        $result=file_get_contents($link);
        $result=json_decode($result,true);
        $ukr_txt=$result['text'][0];
        return $ukr_txt;
    }

    /**
     * получаем текст определенного товара
     * @param $id integer - айди товара
     * @return string - текст этого товара
     */
    private function getText($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_content FROM goodshaslang WHERE goods_id=$id AND lang_id=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $texts[] = $row;
            }
            if (is_array($texts))
            {
                foreach ($texts as $text)
                {
                    //получаем нужный текст
                    $txt=$text['goodshaslang_content'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $txt;
    }

    /**
     *получаем список всех ид товаров
     */
    private function getGoodsIds()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods";
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
     * скармливаем айдишку товара и получаем ответ надо ли его переводить или нет
     * @param $goods_id integer - айди товара
     * @return bool -
     */
    private function getInNeed($goods_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_name, goodshaslang_content, lang_id FROM goodshaslang WHERE goods_id=$goods_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
            if (is_array($goods))
            {
                foreach ($goods as $good)
                {
                    if ($good['lang_id']==1)
                    {
                        $ru_name=$good['goodshaslang_name'];
                        $ru_cont=$good['goodshaslang_content'];
                    }
                    if ($good['lang_id']==3)
                    {
                        $ukr_name=$good['goodshaslang_name'];
                        $ukr_cont=$good['goodshaslang_content'];
                    }
                }
                if (strnatcasecmp($ru_name,$ukr_name)!=00&&strnatcasecmp($ru_cont,$ukr_cont)!=0)
                {
                    mysqli_close($db_connect);
                    return true;
                }
                else
                {
                    mysqli_close($db_connect);
                    return false;
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
    }

    public function getTranslate()
    {
        $all_goods=$this->getGoodsIds();
        foreach ($all_goods as $good)
        {
            $goods_id=$good['goods_id'];
            //если нам нужен перевод - то мы его получаем
            if ($this->getInNeed($goods_id))
            {
                $ru_text=$this->getText($goods_id);
                $ukr_text=$this->translatePos($ru_text);
                $file="$goods_id;$ru_text;$ukr_text".PHP_EOL;
                file_put_contents("texts.csv",$file,FILE_APPEND);
            }
        }
    }

    public function test($test_id=null)
    {
        if ($test_id)
        {
            //если нам нужен перевод - то мы его получаем
            if ($this->getInNeed($test_id))
            {
                $ru_text=$this->getText($test_id);
                $ukr_text=$this->translatePos($ru_text);
                $file="$test_id;$ru_text;$ukr_text".PHP_EOL;
                echo $file;
            }
        }

        else
        {
            $all_goods=$this->getGoodsIds();
            foreach ($all_goods as $good)
            {
                $goods_id=$good['goods_id'];
                //если нам нужен перевод - то мы его получаем
                if ($this->getInNeed($goods_id))
                {
                    $ru_text=$this->getText($goods_id);
                    $ukr_text=$this->translatePos($ru_text);
                    $file="$goods_id;$ru_text;$ukr_text".PHP_EOL;
                    file_put_contents("texts.csv",$file,FILE_APPEND);
                }
                break;
            }
        }
    }
}