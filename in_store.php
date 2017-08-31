<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.04.17
 * Time: 09:56
 */

header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
define ("host","localhost");
define ("host_ddn","localhost");
//define ("host","10.0.0.2");
/**
 * database username
 */
define ("user", "root");
define ("user_ddn", "root");
//define ("user", "uh333660_mebli");
/**
 * database password
 */
define ("pass", "");
define ("pass_ddn", "");
//define ("pass", "Z7A8JqUh");
/**
 * database name
 */
define ("db", "mebli");
define ("db_ddn", "mebli");
//define ("db", "uh333660_mebli");

/**
 * Class InStoreFm
 */
class InStoreFm
{
    /**
     * @var
     */
    private $file;
    /**
     * @var
     */
    private $data;

    /**
     * InStoreFm constructor.
     */
    public function __construct($f)
    {
        if ($f)
            $this->file=$f;
    }

    /**
     * @param $article
     * @param $in_store
     */
    public function add_data($article, $in_store)
    {
        $this->data[]=array('article'=>$article, 'in_store'=>$in_store);
    }

    /**
     *
     */
    public function readFile()
    {
        if ($this->file)
        {
            $dom=DOMDocument::load($this->file1);
            $rows=$dom->getElementsByTagName('Row');
            $row_num=1;
            foreach ($rows as $row)
            {
                if ($row_num>=2)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if ($cell_num==3)
                        {
                            $article=$elem;
                        }
                        if ($cell_num==5)
                        {
                            $in_store=$elem;
                        }
                        $cell_num++;
                    }
                    if ($article>0)
                    {
                        $this->add_data($article,$in_store);
                    }

                }
                $row_num++;
            }
        }
    }

    /**
     *удаляет все отметки на складе для мягкой мебели
     */
    private function remove_instore()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_avail=0 WHERE goods_maintcharter=1 OR goods_maintcharter=2 OR goods_maintcharter=38";
        if (mysqli_query($db_connect,$query))
        {
            echo "In Store removed<br>";
        }
        else
        {
            echo "Error ".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
    }

    /**
     *
     */
    public function setInSore()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        if ($this->data)
        {
            foreach ($this->data as $d)
            {
                $article=$d['article'];
                $in_store=$d['in_store'];
                $query="UPDATE goods SET goods_avail=$in_store WHERE goods_article=$article";
                if (mysqli_query($db_connect,$query))
                {
                    echo "In Store set for $article<br>";
                    echo "$query<br>";
                }
                else
                {
                    echo "Error ".mysqli_error($db_connect)."<br>";
                    echo "$query<br>";
                }

            }
        }
        mysqli_close($db_connect);
    }

}

class SetInStoreDDN
{
    /**
     * @var
     */
    private $file;
    /**
     * @var
     */
    private $data;

    /**
     * InStoreFm constructor.
     */
    public function __construct($f)
    {
        if ($f)
            $this->file=$f;
    }

    private function getIdByArticle($article)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goods_id FROM goods WHERE goods_article=$article";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $ids[] = $row;
            }
            if (is_array($ids))
            {
                foreach ($ids as $id)
                {
                    //получаем нужный текст
                    $goods_id=$id['goods_id'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
            $goods_id=null;
        }
        mysqli_close($db_connect);
        return $goods_id;
    }

    public function readFile()
    {
        if ($this->file)
        {
            $dom=DOMDocument::load($this->file1);
            $rows=$dom->getElementsByTagName('Row');
            $row_num=1;
            foreach ($rows as $row)
            {
                if ($row_num>=2)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if ($cell_num==3)
                        {
                            $article=$elem;
                        }
                        if ($cell_num==5)
                        {
                            $in_store=$elem;
                        }
                        $cell_num++;
                    }
                    if ($article>0)
                    {
                        $this->add_data($article,$in_store);
                    }

                }
                $row_num++;
            }
        }
    }

    public function setInSore()
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        if ($this->data)
        {
            foreach ($this->data as $d)
            {
                $article=$d['article'];
                $id=$this->getIdByArticle($article);
                $in_store=$d['in_store'];
                if ($in_store==0)
                {
                    $in_store=1;
                }
                else
                {
                    $in_store=2;
                }
                $query="UPDATE goodshasfeature SET goodshasfeature_valueid=$in_store WHERE goods_id=$id AND feature_id=16";
                if (mysqli_query($db_connect,$query))
                {
                    echo "In Store set for $article<br>";
                    echo "$query<br>";
                }
                else
                {
                    echo "Error ".mysqli_error($db_connect)."<br>";
                    echo "$query<br>";
                }

            }
        }
        mysqli_close($db_connect);
    }
}