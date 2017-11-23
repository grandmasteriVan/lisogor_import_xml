<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 23.11.2017
 * Time: 11:06
 */
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
define ("user", "fm");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "T6n7C8r1");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "fm");

class ComponentList
{
    /**
     * @var
     */
    private $factory_id;

    /**
     * ComponentList constructor.
     * @param $factory_id
     */
    public function __construct($factory_id)
    {
        $this->factory_id = $factory_id;
    }

    /** выбираем все активные, включенные товары по фабрике
     * @param $f_id
     * @return mixed
     */
    private function getAllTov($f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_url, goods_name, goods_article FROM goods WHERE factory_id=$f_id AND goods_active=1 AND goods_noactual=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $tovByFactory[]=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL fm $query<br>";
        }
        if (is_array($tovByFactory))
        {
            return $tovByFactory;
        }
        else
        {
            return null;
        }
    }
    private function getComponentForTov($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT component_child FROM component WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $components[]=$row;
            }
            //var_dump ($query);
            //var_dump ($components);
        }
        else
        {
            echo "error in SQL fm $query<br>";
        }
        if (is_array($components))
        {
            return $components;
        }
        else
        {
            return null;
        }
    }

    private function getArticleById($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_article FROM goods WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $article[]=$row;
            }
            //var_dump ($query);
            //var_dump ($article);
        }
        else
        {
            echo "error in SQL fm $query<br>";
        }
        if (is_array($article))
        {
            return $article;
        }
        else
        {
            return null;
        }
    }

    public function getCompList()
    {
        $all_tov=$this->getAllTov($this->factory_id);
        foreach ($all_tov as $item)
        {
            $id=$item['goods_id'];
            if ($comp_list=$this->getComponentForTov($id))
            {
                $article=$item['goods_article'];
                $name=$item['goods_name'];
                $url="http://fayni-mebli.com/".$item['goods_url'].".html";
                $str=$article." ".$name.";".$url.";";
                foreach ($comp_list as $comp)
                {
                    $comp_article=$this->getArticleById($comp['component_child']);
                    $str.=$comp_article['goods_article']." ";
                }
                $str.=";".PHP_EOL;
                echo $str."<br>";
            }


        }
    }

}