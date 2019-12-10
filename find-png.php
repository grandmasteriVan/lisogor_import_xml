<?php 

/**
 * Скрипт для изменений фоток галереи (для конкретного товара)
 * параметр ID обязательный
 */
header('Content-type: text/html; charset=UTF-8');
require 'autoload.php';
ini_set('display_errors', 1);
ini_set('max_execution_time', 720000);

define ("host","localhost");
define ("user", "u_ddnPZS");
define ("pass", "A8mnsoHf");
define ("db", "ddnPZS");

$db = DB::getInstance();
/*
 * @var $item - Goodsfile
 *
 * list desc-sm - список товаров, мал.фото в табличном варианте или списком
 * list desc-big - список товаров, бол.вариант отображения товара в таблице
 * list mob-sm - список товаров, вариант списком на моб устройствах
 * list mob-big - список товаров, вариант таблицей (фото на ширину экрана) на моб устройствах
 * page desc-big - страница товара большое фото (пока используется только для главной фотки товара, для галерейных - нет)
 * page prev-sm - страница товара, превью галереи
 * */
function createPreviews($item)
{
    if (!file_exists($item->getDirPreviewUpload())) {
        mkdir($item->getDirPreviewUpload(), 0775);
    }
    // определяем есть ли оригинал фото или нет (в старых товарах его нет)
    if (file_exists($item->getRealPathOriginalUpload())) {
        $path = $item->getRealPathOriginalUpload();
    } else {
        $path = $item->getRealPathPictUpload();
    }

    //var_dump ($path);
    $ext=end(explode(".", $path));
    //echo "$ext<br>";
    if (strnatcasecmp($ext,"png")==0)
    {
        echo "$path<br>";
    }
    else
    {
        
    }
    
    
    
}

function getGoodsByFactory ($f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goodshasfeature WHERE feature_id=14 AND goodshasfeature_valueid=$f_id";
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
        if (is_array($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
        
    }

    function getGoods ()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods";
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
        if (is_array($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
        
    }

    
$goods=getGoods();
//var_dump ($goods);

foreach ($goods as $good)
{
    $id=$good['goods_id'];
    if ($id>=1&&$id<20000)
    {
        $item = new Goods($id);
        $files = $item->getFiles();
        //var_dump ($files);
        foreach ($files as $file) 
        {
            //var_dump ($file);
            createPreviews($file);
            //echo "$id<br>";
            //echo '<div><img style="margin-bottom:10px;" src="'.$file->getRealPathSeoPreview('list','desc-sm').'"></div>';
        }
        //break;
    }
    else
    {
        //break;
    }
    //break;
}

echo 'DONE!';
