<?php
header('Content-Type: text/html; charset=utf-8');



class Tonga
{
    private $pathOrig="https://www.tonga.in.ua/content/export/29.xml";
    private $pathOrigUkr="https://www.tonga.in.ua/content/export/0c5dedacfc968e3221db281ad8e58410.xml";
    private $pathFull="/home/notaboo2/files.tonga.in.ua/www/_prices/full.xml";
    private $pathFull1="/home/notaboo2/files.tonga.in.ua/www/_prices/full-2.xml";
    private $pathPharm="/home/notaboo2/files.tonga.in.ua/www/_prices/pharm.xml";
    private $pathUnderwear="/home/notaboo2/files.tonga.in.ua/www/_prices/underwear.xml";

    private $pathFullUkr="/home/notaboo2/files.tonga.in.ua/www/_prices/full_ukr.xml";
    private $pathFull1Ukr="/home/notaboo2/files.tonga.in.ua/www/_prices/full-2_ukr.xml";
    private $pathPharmUkr="/home/notaboo2/files.tonga.in.ua/www/_prices/pharm_ukr.xml";
    private $pathUnderwearUkr="/home/notaboo2/files.tonga.in.ua/www/_prices/underwear_ukr.xml";

    private $path2lang="/home/notaboo2/files.tonga.in.ua/www/_prices/full_2lang.xml";
    private $path2lang1="/home/notaboo2/files.tonga.in.ua/www/_prices/full-2lang1.xml";
    private $path2lang1300="/home/notaboo2/files.tonga.in.ua/www/_prices/full-2lang1300.xml";
    private $path2langPharm="/home/notaboo2/files.tonga.in.ua/www/_prices/pharm_2lang.xml";
    private $path2langUnderwear="/home/notaboo2/files.tonga.in.ua/www/_prices/underwear_2lang.xml";


    private $path2langCat="/home/notaboo2/files.tonga.in.ua/www/_prices/full_2langCat.xml";
    private $path2lang1Cat="/home/notaboo2/files.tonga.in.ua/www/_prices/full-2lang1Cat.xml";
    private $path2langPharmCat="/home/notaboo2/files.tonga.in.ua/www/_prices/pharm_2langCat.xml";
    private $path2langUnderwearCat="/home/notaboo2/files.tonga.in.ua/www/_prices/underwear_2langCat.xml";

    private $pathFullCSV="/home/notaboo2/files.tonga.in.ua/www/_prices/full.csv";
    private $pathPharmCSV="/home/notaboo2/files.tonga.in.ua/www/_prices/pharm.csv";
    private $pathUnderwearCSV="/home/notaboo2/files.tonga.in.ua/www/_prices/underwear.csv";

    private $pathFullCSVUkr="/home/notaboo2/files.tonga.in.ua/www/_prices/full_ukr.csv";
    private $pathPharmCSVUkr="/home/notaboo2/files.tonga.in.ua/www/_prices/pharm_ukr.csv";
    private $pathUnderwearCSVUkr="/home/notaboo2/files.tonga.in.ua/www/_prices/underwear_ukr.csv";

    private $pathFullCSV5="/home/notaboo2/files.tonga.in.ua/www/_prices/full_5.csv";
    private $pathFullCSV10="/home/notaboo2/files.tonga.in.ua/www/_prices/full_10.csv";

    private $pathFullXLS="/home/notaboo2/files.tonga.in.ua/www/_prices/full.xls";
    private $pathPharmXLS="/home/notaboo2/files.tonga.in.ua/www/_prices/pharm.xls";
    private $pathUnderwearXLS="/home/notaboo2/files.tonga.in.ua/www/_prices/underwear.xls";

    private $pathFullXLSUkr="/home/notaboo2/files.tonga.in.ua/www/_prices/full_ukr.xls";
    private $pathPharmXLSUkr="/home/notaboo2/files.tonga.in.ua/www/_prices/pharm_ukr.xls";
    private $pathUnderwearXLSUkr="/home/notaboo2/files.tonga.in.ua/www/_prices/underwear_ukr.xls";

    private $stockCSV="ostatki.csv";
    private $stock = "/home/notaboo2/files.tonga.in.ua/www/_prices/stock.xls";
    private $stockUkr = "/home/notaboo2/files.tonga.in.ua/www/_prices/stock_ukr.xls";

     //амурчик
    private $pathOrigAmurchik="https://www.tonga.in.ua/content/export/36.xlsx";
    private $pathAmurchik="/home/notaboo2/files.tonga.in.ua/www/_prices/amur/Amurchik.csv";
    private $pathGroup4="/home/notaboo2/files.tonga.in.ua/www/_prices/Group4.csv";
    private $pathNasoloda="/home/notaboo2/files.tonga.in.ua/www/_prices/Nasoloda.xml";
    private $pathAksenova="/home/notaboo2/files.tonga.in.ua/www/_prices/Aksenova.csv";
    private $pathAmirov="/home/notaboo2/files.tonga.in.ua/www/_prices/Amirov.csv";

    private $pathOther="/home/notaboo2/files.tonga.in.ua/www/_prices/other.csv";
    private $pathOther5="/home/notaboo2/files.tonga.in.ua/www/_prices/other5.csv";
    private $pathOther10="/home/notaboo2/files.tonga.in.ua/www/_prices/other10.csv";

    private $pathAmurchikUkr="/home/notaboo2/files.tonga.in.ua/www/_prices/amur/Amurchik_ukr.csv";
    private $pathAmirovUkr="/home/notaboo2/files.tonga.in.ua/www/_prices/Amirov_ukr.csv";

    private $pathOtherUkr="/home/notaboo2/files.tonga.in.ua/www/_prices/other_ukr.csv";

    private $specs="/home/notaboo2/files.tonga.in.ua/www/specifications.xlsx";

    private $xls;
    private $specs_mem;

    
    function __construct()
    {
        // code...
        $url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        $path = "36.xlsx";
        file_put_contents($path, file_get_contents($url));
        //chmod ($path,0777);
        //$this->pathOrigAmurchik=$path;


    }

    /*private*/ public function getSpecs()
    {
        $arr=$this->readExelFile($this->specs);
        $specs_arr=null;
        if (is_array($arr))
        {
            //var_dump($arr);
            array_unshift($arr);
            foreach ($arr as $spec)
            {
                $art=$spec[0];
                $material=$spec[3];
                $weight=$spec[6];
                $len=$spec[8];
                $batType=$spec[9];
                $vibro=$spec[10];
                $country=$spec[11];
                $height=$spec[12];
                $width=$spec[13];
                $diametr=$spec[14];
                $composition=$spec[15];
                $vol=$spec[16];
                $thickness=$spec[17];
                $colRu=$spec[18];
                $colUA=$spec[19];
                $aroma=$spec[20];
                $colorRU=$spec[21];
                $colorUA=$spec[22];

                $specs_arr[]=array($art,$material,$weight,$len,$batType,$vibro,$country,$height,$width,$diametr,$composition,$vol,$thickness,$colRu,$colUA,$aroma,$colorRU,$colorUA);
            }
        }
        //var_dump($specs_arr);
        return $specs_arr;
    }

    private function file_get_contents_curl( $url ) {

        $ch = curl_init();
      
        curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      
        $data = curl_exec( $ch );
        curl_close( $ch );
      
        return $data;
      
      }

    private function getExchangeRate($html)
    {
        //$data=$this->file_get_contents_curl($html);
        //var_dump ($data);
        $dom = new DOMDocument;
        @$dom->loadHTML($this->file_get_contents_curl($html));
        $t=$this->file_get_contents_curl($html);
        //var_dump($t);
        //$rate=preg_match_all("#<a href=\"\/\" class=\"footer__link\">(.*?)<\/a>#",$t,$matches);
        $rate=preg_match_all("#class=\"footer__link\">(.*?)<\/a>#",$t,$matches);
        //var_dump($matches);
        //echo "<pre>";print_r($matches);echo"</pre>";
        $course=$matches[1][15];
        //var_dump ($course);
        $course=explode('= ',$course);
        //var_dump ($course);
        $course=$course[1];
        $course=(float)$course;
        //echo "couirse=$course<br>";
        return $course;
        //var_dump ($dom);
        //$menuItems = $dom->getElementsByTagName('footer__link');
        //var_dump ($menuItems);
        
    }
    
    private function readFile()
    {
        $xml=file_get_contents($this->pathOrig);
        return $xml;
    }

    private function readFileUa()
    {
        $xml=file_get_contents($this->pathOrigUkr);
        return $xml;
    }

    private function stripHead($txt)
    {
        //var_dump ($txt);
        $pos=strpos($txt,"<offers>");
        //var_dump ($pos);
        $new_txt=substr($txt,$pos);
        $new_txt=str_ireplace("<offers>","",$new_txt);
        $new_txt=str_ireplace("</offers>","",$new_txt);
        return $new_txt;
    }

    private function getItemsArr ($txt)
    {
        $arr=explode("</offer>",$txt);
        foreach ($arr as $pos)
        {
            $arr1[]=$pos."</offer>";
        }
        //последий элемент полученнного макссива всегда пуст, удаляем его
        array_pop($arr1);
        return $arr1;
    }

    private function getCatId($item)
    {
        //var_dump ($item);
        /*if (preg_match("<categoryId>(.*?)<\/categoryId>",$item,$matches)==1)
        {
            $id=$matches[1];
        }
        else
        {
            echo "No catId find for item:".$item."<br>";
            return null;
        }*/
        preg_match("#<categoryId>(.*?)<\/categoryId>#",$item,$matches);
        $id=$matches[1];
        return $id;
    }

    private function getParamName($param)
    {
        if (preg_match("#\"(.+?)\"#",$param,$matches))
        {
            $paramName=$matches[1];
        }
        return $paramName;
    }

    private function getParamVal($param)
    {
        //var_dump ($param);
        if (preg_match("#>(.+?)<#",$param,$matches))
        {
            $paramVal=$matches[1];
        }
        return $paramVal;
    }

    private function getParams($item)
    {
        //var_dump ($item);
        if (preg_match_all("#<param name(.*?)<\/param>#",$item,$matches))
        {
            //var_dump ($matches);
            $params=$matches[0];
            /*foreach($matches as $param)
            {
                $params[]="<param name".$param[1]."</param>";
            }*/
        }
        /*else
        {
            $id=$this->getItemId($item);
            echo "No params found for $id<br>";
        }*/
        //var_dump ($params);
        return $params;
    }

    private function getXMLhead($txt)
    {
        $pos=strpos($txt,"</categories>");
        $xmlhead=substr($txt,0,$pos);
        return $xmlhead;
    }

    private function setPrice($item)
    {
        $params=$this->getParams($item);
        $price="0";
        if (is_array($params))
        {
            foreach ($params as $param)
            {
                $paramName=$this->getParamName($param);
                if (strcmp($paramName,"РРЦ (грн)")==0)
                {
                    $price=$this->getParamVal($param);
                }
            }
        }
        $item=preg_replace("#<price>(.*?)</price>#s","<price>$price</price>",$item);
        $item=preg_replace("#<param name=\"РРЦ \(грн\)\">(.*?)<\/param>#s","",$item);
        return $item;
    }

    private function setAviability($item, $stock)
    {
        $item=preg_replace("#available=\"(.*?)\">#s","available=\"$stock\">",$item);
        return $item;
    }

    private function getItemRRP($item)
    {
        $params=$this->getParams($item);
        $RRP="0";
        if (is_array($params))
        {
            foreach ($params as $param)
            {
                $paramName=$this->getParamName($param);
                if (strcmp($paramName,"РРЦ (грн)")==0)
                {
                    $RRP=$this->getParamVal($param);
                }
            }
        }
        return $RRP;
    }

    private function setQantity($item,$quantity)
    {
        $txt="</vendor>".PHP_EOL."<quantity>$quantity</quantity>";
        $item=preg_replace("#<\/vendor>#s",$txt,$item);
        return $item;
    }

    public function parseXML()
    {
        //читаем файл с остатками (в переменной stocks будут лежать артикул и остаток)
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            
            {
                //echo "<pre>";print_r($data);echo "</pre>";
                if ($data[1]>0)
                {
                    $data[1]="true";
                }
                else
                {
                    $data[1]="false";
                }
                $stocks[]=$data;
            }
        }
        fclose($handle);

        //додаємо параметр quantity
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)
        {

        while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                //echo "<pre>";print_r($data);echo "</pre>";
                /*if (intval($data[1])>5)
                {
                    $data[1]=">5";
                }*/
                $quantity_arr[]=$data;
            }
        }
        fclose($handle);
        //echo"<pre>";print_r($quantity_arr);echo"</pre>";


        $xml=$this->readFile();
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        if (is_array($items)&&is_array($stocks)&&is_array($quantity_arr))
        {
            foreach ($items as $item)
            {
                //тягнемо актуальну наявнісить з файлу з 1с
                $art=$this->getItemArticle($item);
                //тимчасово ек будекмо виклористовувати залишки 1с
                /*foreach ($stocks as $stock)
                {
                    if ($art==$stock[0])
                    {
                        $item=$this->setAviability($item,$stock[1]);
                    }
                }*/
                //знаходимо кількість товару
                foreach($quantity_arr as $tmp)
                {
                    $tmp_art=$tmp[0];
                    if (strcasecmp($art,$tmp_art)==0)
                    {
                        $quantity=$tmp[1];

                        break;
                    }
                }
                //echo "$art $quantity<br>";
                $quantity=intval($quantity);

                $item=$this->setQantity($item,$quantity);

                //var_dump ($item);
                $item=$this->setPrice($item);
                //полная выгрузка
                //$allItems.=$item.PHP_EOL;
                $catId=$this->getCatId($item);
                //видаляємо всі позиції виробника g-vibe
                $vendor=$this->getItemVendor($item);
                if (($catId==1197)||(strcasecmp($vendor,'Gvibe')==0)||(strcasecmp($art,'NT95304')==0))
                {
                    $item='';
                    //echo "$art<br/>";
                }
                if ($catId!=1150)
                {
                    $allItems.=$item.PHP_EOL;
                }

                if ($catId==1069||$catId==1007||$catId==1088||$catId==1089||$catId==1145||$catId==1146||$catId==1147||$catId==1090||$catId==1091||$catId==1092||$catId==1093||$catId==1094||$catId==1095||$catId==1055||$catId==1096||$catId==1097||$catId==1098||$catId==1099||$catId==1100||$catId==1008||$catId==1084||$catId==1085||$catId==1060)
                {
                    //аптека
                    $pharmItems.=$item.PHP_EOL;   
                }
                if ($catId==1062||$catId==1005||$catId==1128||$catId==1129||$catId==1130||$catId==1131||$catId==1132||$catId==1133||$catId==1134||$catId==1136||$catId==1137||$catId==1138||$catId==1139||$catId==1140||$catId==1141||$catId==1142||$catId==1143)
                {
                    //белье
                    $underwearItems.=$item.PHP_EOL;
                }
                //var_dump ($item);
                
                //break;
            }
            $allItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$allItems);
            $pharmItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$pharmItems);
            $underwearItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$underwearItems);

            //правимо шляхи до картинок
            $allItems=str_ireplace("loading=\"lazy\" src=\"/content","src=\"https://tonga.in.ua/content",$allItems);
            $allItems=str_ireplace("src=\"/content","src=\"https://tonga.in.ua/content",$allItems);
            $pharmItems=str_ireplace("loading=\"lazy\" src=\"/content","src=\"https://tonga.in.ua/content",$pharmItems);
            $pharmItems=str_ireplace("src=\"/content","src=\"https://tonga.in.ua/content",$pharmItems);
            $underwearItems=str_ireplace("loading=\"lazy\" src=\"/content","src=\"https://tonga.in.ua/content",$underwearItems);
            $underwearItems=str_ireplace("src=\"/content","src=\"https://tonga.in.ua/content",$underwearItems);
                        
            //echo "<pre>";print_r($underwearItems);echo "</pre>";
            $allItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$allItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            file_put_contents($this->pathFull,$allItems);
            //вариант с available="" вместо available="false"
            $allItems1=str_ireplace('available="false"','available=""',$allItems);
            file_put_contents($this->pathFull1,$allItems1);
            //пишем аптеку
            $pharmItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$pharmItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            file_put_contents($this->pathPharm,$pharmItems);
            //пишем белье
            $underwearItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$underwearItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            file_put_contents($this->pathUnderwear,$underwearItems);
        }
    }

    
    private function getNameUkr($item)
    {
        if (preg_match_all("#<name_ua>(.+?)<\/name_ua>#",$item,$matches))
        {
            $name=$matches[1][0];
        }
        $name=str_ireplace("<![CDATA[","",$name);
        $name=str_ireplace("]]>","",$name);
        return $name;
    }

    private function getPriceXML($item)
    {
        if (preg_match_all("#<price>(.+?)<\/price>#",$item,$matches))
        {
            $price=$matches[1][0];
        }
        return $price;
    }

    private function getDescrUkr($item)
    {
        if (preg_match_all("#<description_ua>(.+?)<\/description_ua>#",$item,$matches))
        {
            $desc=$matches[1][0];
        }
        $desc=str_ireplace("<![CDATA[","",$desc);
        $desc=str_ireplace("]]>","",$desc);
        $desc=strip_tags($desc);
        return $desc;
    }

    ###

    public function parseXML2lang()
    {
        //file_put_contents($this->pathAmurchik, '');
        //$arr=$this->readExelFile($this->pathOrigAmurchik);

        //$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        //$path = '36.xlsx';
        //file_put_contents($path, $this->file_get_contents_curl($url));
        //chmod ($path,0777);
        //$this->pathOrigAmurchik=$path;
        //$arr=$this->readExelFile($this->pathOrigAmurchik);

        //читаем файл с остатками (в переменной stocks будут лежать артикул и остаток)
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                //echo "<pre>";print_r($data);echo "</pre>";
                if ($data[1]>0)
                {
                    $data[1]="true";
                }
                else
                {
                    $data[1]="false";
                }
                $stocks[]=$data;
            }
        }
        fclose($handle);


        $xml=$this->readFileUa();
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        if (is_array($items))
        {
            foreach ($items as $item)
            {
                //var_dump ($item);
                //$art=$this->getItemArticle($item);

                //тягнемо актуальну наявнісить з файлу з 1с
                $art=$this->getItemArticle($item);
                //тимчасово не винористовуємо 1с
                /*foreach ($stocks as $stock)
                {
                    if ($art==$stock[0])
                    {
                        $item=$this->setAviability($item,$stock[1]);
                    }
                }*/

                $item=$this->setPrice($item);
                //полная выгрузка
                //$allItems.=$item.PHP_EOL;
                $catId=$this->getCatId($item);
                //видаляємо всі позиції виробника g-vibe
                $vendor=$this->getItemVendor($item);
                if (($catId==1197)||(strcasecmp($vendor,'Gvibe')==0)||(strcasecmp($art,'NT95304')==0))
                {
                    $item='';
                }
                if ($catId!=1150)
                {
                    $allItems.=$item.PHP_EOL;
                }

                if ($catId==1069||$catId==1007||$catId==1088||$catId==1089||$catId==1145||$catId==1146||$catId==1147||$catId==1090||$catId==1091||$catId==1092||$catId==1093||$catId==1094||$catId==1095||$catId==1055||$catId==1096||$catId==1097||$catId==1098||$catId==1099||$catId==1100||$catId==1008||$catId==1084||$catId==1085||$catId==1060)
                {
                    //аптека
                    $pharmItems.=$item.PHP_EOL;   
                }
                if ($catId==1062||$catId==1005||$catId==1128||$catId==1129||$catId==1130||$catId==1131||$catId==1132||$catId==1133||$catId==1134||$catId==1136||$catId==1137||$catId==1138||$catId==1139||$catId==1140||$catId==1141||$catId==1142||$catId==1143)
                {
                    //белье
                    $underwearItems.=$item.PHP_EOL;
                }
                //var_dump ($item);
                
                //break;
            }
            ###
            $allItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$allItems);
            $pharmItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$pharmItems);
            $underwearItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$underwearItems);
            //echo "<pre>";print_r($underwearItems);echo "</pre>";
            $allItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$allItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            file_put_contents($this->path2lang,$allItems);
            //вариант с available="" вместо available="false"
            $allItems1=str_ireplace('available="false"','available=""',$allItems);
            file_put_contents($this->path2lang1,$allItems1);
            //пишем аптеку
            $pharmItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$pharmItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            file_put_contents($this->path2langPharm,$pharmItems);
            //пишем белье
            $underwearItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$underwearItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            file_put_contents($this->path2langUnderwear,$underwearItems);
        }
    }

    //ціни від 300
    public function parseXML2lang300()
    {
        //file_put_contents($this->pathAmurchik, '');
        //$arr=$this->readExelFile($this->pathOrigAmurchik);

        //$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        //$path = '36.xlsx';
        //file_put_contents($path, $this->file_get_contents_curl($url));
        //chmod ($path,0777);
        //$this->pathOrigAmurchik=$path;
        //$arr=$this->readExelFile($this->pathOrigAmurchik);

        //читаем файл с остатками (в переменной stocks будут лежать артикул и остаток)
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                //echo "<pre>";print_r($data);echo "</pre>";
                if ($data[1]>0)
                {
                    $data[1]="true";
                }
                else
                {
                    $data[1]="false";
                }
                $stocks[]=$data;
            }
        }
        fclose($handle);


        $xml=$this->readFileUa();
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        if (is_array($items))
        {
            foreach ($items as $item)
            {
                //var_dump ($item);
                //$art=$this->getItemArticle($item);

                //тягнемо актуальну наявнісить з файлу з 1с
                $art=$this->getItemArticle($item);
                //тимчасово не використовуємо 1с
                foreach ($stocks as $stock)
                {
                    if ($art==$stock[0])
                    {
                        $item=$this->setAviability($item,$stock[1]);
                    }
                }

                $item=$this->setPrice($item);
                //полная выгрузка
                //$allItems.=$item.PHP_EOL;
                $catId=$this->getCatId($item);
                $price=$this->getPriceXML($item);
                if ($price>300)
                {
                    //видаляємо всі позиції виробника g-vibe
                    $vendor=$this->getItemVendor($item);
                    if (($catId==1197)||(strcasecmp($vendor,'Gvibe')==0)||(strcasecmp($art,'NT95304')==0))
                    {
                        $item='';
                    }
                    if ($catId!=1150)
                    {
                        $allItems.=$item.PHP_EOL;
                    }

                }
                
                //var_dump ($item);
                
                //break;
            }
            ###
            $allItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$allItems);
            //echo "<pre>";print_r($underwearItems);echo "</pre>";
            $allItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$allItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            
            //вариант с available="" вместо available="false"
            $allItems1=str_ireplace('available="false"','available=""',$allItems);
            file_put_contents($this->path2lang1300,$allItems1);
            
        }
    }

    public function parseXMLUk()
    {
        //file_put_contents($this->pathAmurchik, '');
        //$arr=$this->readExelFile($this->pathOrigAmurchik);

        //$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        //$path = '36.xlsx';
        //file_put_contents($path, $this->file_get_contents_curl($url));
        //chmod ($path,0777);
        //$this->pathOrigAmurchik=$path;
        //$arr=$this->readExelFile($this->pathOrigAmurchik);

        //читаем файл с остатками (в переменной stocks будут лежать артикул и остаток)
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                //echo "<pre>";print_r($data);echo "</pre>";
                if ($data[1]>0)
                {
                    $data[1]="true";
                }
                else
                {
                    $data[1]="false";
                }
                $stocks[]=$data;
            }
        }
        fclose($handle);


        $xml=$this->readFileUa();
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        if (is_array($items))
        {
            foreach ($items as $item)
            {
                //var_dump ($item);
                //тягнемо актуальну наявнісить з файлу з 1с
                $art=$this->getItemArticle($item);
                //тимчасово не використовуємо 1с
                foreach ($stocks as $stock)
                {
                    if ($art==$stock[0])
                    {
                        $item=$this->setAviability($item,$stock[1]);
                    }
                }

                $item=$this->setPrice($item);
                $name_ua=$this->getNameUkr($item);
                $descr_ua=$this->getDescrUkr($item);
                //echo "$name_ua<br>";
                $item=preg_replace("#<name><!\[CDATA\[(.*?)\]\]><\/name>#s","",$item);
                $item=preg_replace("#<name_ua><!\[CDATA\[(.*?)\]\]><\/name_ua>#s","<name><![CDATA[$name_ua]]></name>",$item);
                $item=preg_replace("#<description><!\[CDATA\[(.*?)\]\]><\/description>#s","",$item);
                $item=preg_replace("#<description_ua><!\[CDATA\[(.*?)\]\]><\/description_ua>#s","<description><![CDATA[$descr_ua]]></description>",$item);
                //полная выгрузка
                //$allItems.=$item.PHP_EOL;
                $catId=$this->getCatId($item);
                //видаляємо всі позиції виробника g-vibe
                $vendor=$this->getItemVendor($item);
                if (($catId==1197)||(strcasecmp($vendor,'Gvibe')==0)||(strcasecmp($art,'NT95304')==0))
                {
                    $item='';
                }
                if ($catId!=1150)
                {
                    $allItems.=$item.PHP_EOL;
                }

                if ($catId==1069||$catId==1007||$catId==1088||$catId==1089||$catId==1145||$catId==1146||$catId==1147||$catId==1090||$catId==1091||$catId==1092||$catId==1093||$catId==1094||$catId==1095||$catId==1055||$catId==1096||$catId==1097||$catId==1098||$catId==1099||$catId==1100||$catId==1008||$catId==1084||$catId==1085||$catId==1060)
                {
                    //аптека
                    $pharmItems.=$item.PHP_EOL;   
                }
                if ($catId==1062||$catId==1005||$catId==1128||$catId==1129||$catId==1130||$catId==1131||$catId==1132||$catId==1133||$catId==1134||$catId==1136||$catId==1137||$catId==1138||$catId==1139||$catId==1140||$catId==1141||$catId==1142||$catId==1143)
                {
                    //белье
                    $underwearItems.=$item.PHP_EOL;
                }
                //var_dump ($item);
                
                //break;
            }
            ###
            $allItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$allItems);
            $pharmItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$pharmItems);
            $underwearItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$underwearItems);
            //echo "<pre>";print_r($underwearItems);echo "</pre>";
            $allItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$allItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            file_put_contents($this->pathFullUkr,$allItems);
            //вариант с available="" вместо available="false"
            $allItems1=str_ireplace('available="false"','available=""',$allItems);
            file_put_contents($this->pathFull1Ukr,$allItems1);
            //пишем аптеку
            $pharmItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$pharmItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            file_put_contents($this->pathPharmUkr,$pharmItems);
            //пишем белье
            $underwearItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$underwearItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            file_put_contents($this->pathUnderwearUkr,$underwearItems);
        }
    }

    private function getNameUkrByArticle($id,$arr)
    {
        if (is_array($arr))
        {
            foreach ($arr as $pos)
            {
                if ($id==$pos[0])
                {
                    $name=$pos[6];
                    break;
                }
            }
        }
        return $name;
    }

    private function getPrice5($id,$arr)
    {
        if (is_array($arr))
        {
            foreach ($arr as $pos)
            {
                if ($id==$pos[0])
                {
                    $price=$pos[13];
                    break;
                }
            }
        }
        return $price;
    }

    private function getPrice10($id,$arr)
    {
        if (is_array($arr))
        {
            foreach ($arr as $pos)
            {
                if ($id==$pos[0])
                {
                    $price=$pos[11];
                    break;
                }
            }
        }
        return $price;
    }

    private function getAddSectionsByArticle($id,$arr)
    {
        if (is_array($arr))
        {
            foreach ($arr as $pos)
            {
                if ($id==$pos[0])
                {
                    $name=$pos[24];
                    break;
                }
            }
        }
        return $name;
    }

    private function getDescrUkrByArticle($id,$arr)
    {
        if (is_array($arr))
        {
            foreach ($arr as $pos)
            {
                if ($id==$pos[0])
                {
                    $name=$pos[46];
                    break;
                }
            }
        }
        return $name;
    }

    /*
    private function setPrice($item)
    {
        $params=$this->getParams($item);
        $price="0";
        if (is_array($params))
        {
            foreach ($params as $param)
            {
                $paramName=$this->getParamName($param);
                if (strcmp($paramName,"РРЦ (грн)")==0)
                {
                    $price=$this->getParamVal($param);
                }
            }
        }
        $item=preg_replace("#<price>(.*?)</price>#s","<price>$price</price>",$item);
        $item=preg_replace("#<param name=\"РРЦ \(грн\)\">(.*?)<\/param>#s","",$item);
        return $item;
    }
    */
    ###

    private function getItemArticle($item)
    {
        if (preg_match_all("#<vendorCode>(.+?)<\/vendorCode>#",$item,$matches))
        {
            $article=$matches[1][0];
        }
        return $article;
    }

    private function getItemName($item)
    {
        if (preg_match_all("#<name>(.+?)<\/name>#",$item,$matches))
        {
            $name=$matches[1][0];
        }
        $name=str_ireplace("<![CDATA[","",$name);
        $name=str_ireplace("]]>","",$name);
        return $name;
    }

    private function getItemDescription($item)
    {
        if (preg_match_all("#<description>(.+?)<\/description>#",$item,$matches))
        {
            $desc=$matches[1][0];
        }
        $desc=str_ireplace("<![CDATA[","",$desc);
        $desc=str_ireplace("]]>","",$desc);
        $desc=strip_tags($desc);
        return $desc;
    }

    private function getItemVendor($item)
    {
        if (preg_match_all("#<vendor>(.+?)<\/vendor>#",$item,$matches))
        {
            $vendor=$matches[1][0];
        }
        return $vendor;
    }

    private function getItemPrice($item)
    {
        if (preg_match_all("#<price>(.+?)<\/price>#",$item,$matches))
        {
            $price=$matches[1][0];
        }
        //echo "<pre>";print_r($matches);echo "</pre>";
        //echo "<br>price=".$price."<br>";
        return $price;
    }

    private function getItemPictures($item)
    {
        /*if (preg_match("<vendor>(.+?)<\/vendor>",$param,$matches))
        {
            $vendor=$matches[1];
        }
        return $vendor;*/
        preg_match_all("#<picture>(.+?)<\/picture>#",$item,$matches);
        //echo "<pre>";print_r($matches);echo "</pre>";
        $pics=$matches[1];
        //echo "<pre>";print_r($pics);echo "</pre>";
        $pictures="";
        if (is_array($pics))
        {
            foreach ($pics as $pic)
            {
                $pictures.=",$pic";
            }
        }
        $pictures=ltrim($pictures,",");
        //echo $pictures;
        return $pictures;
    }

    private function getId($cat)
    {
        preg_match("#category id=\"(.*?)\"#",$cat,$matches);
        $name=$matches[1];
        return $name;
    }

    private function getParrentId($cat)
    {
        preg_match("#parentId=\"(.*?)\"#",$cat,$matches);
        $name=$matches[1];
        return $name;
    }

    private function getName($cat)
    {
        preg_match("#\">(.*?)<\/category>#",$cat,$matches);
        $name=$matches[1];
        return $name;
    }

    private function getCats($xml)
    {
        //***
        preg_match("#<categories>(.*?)</categories>#s",$xml,$matches);
        $cats=$matches[1];
        //echo "<pre>";print_r($cats);echo"</pre>";
        $arr=explode("</category>",$cats);
        //echo "<pre>";print_r($arr);echo"</pre>";
        array_pop($arr);
        foreach($arr as $cat)
        {
            $cat=$cat."</category>";
            $id=$this->getId($cat);
            $parrent=$this->getParrentId($cat);
            $name=$this->getName($cat);
            //echo "$id-$parrent-$name<br>";
            $catArr[]=array('id'=>$id,'parrent'=>$parrent,'name'=>$name);
        }
        //echo "<pre>";print_r($catArr);echo"</pre>";
        return $catArr;
    }

    private function getAdditionalCats($id, $cats, $catString)
    {
        $arr=$this->xls;
        if (is_array($arr))
        {
            $catsIdArt=null;
            foreach ($arr as $tmp)
            {
                $catsIdArr=null;
                $art=$tmp[0];
                if ($id==$art)
                {
                    //echo "Yay!<br>";
                    $addCat=$tmp[24];
                    //var_dump($tmp);
                    $addCatArr=explode(';',$addCat);
                    //echo"<pre>";print_r($addCatArr);echo"</pre>";
                    //збираєм категорії з ексель
                    if (is_array($addCatArr))
                    {
                        foreach ($addCatArr as $cat)
                        {
                            $cat=trim($cat);
                            $catsTmp=explode('/',$cat);
                            //echo"<pre>";print_r($catsTmp);echo"</pre>";
                            
                            foreach ($catsTmp as $catTmp)
                            {
                                foreach ($cats as $cat1)
                                {
                                    $tmp=$cat1['name'];
                                    //echo "$tmp<br>";
                                    if (strcasecmp($tmp,$catTmp)==0)
                                    {
                                        $catsIdArr[]=$cat1['id'];
                                        //var_dump($catsIdArr);echo"<br>";
                                    }
                                }
                            }

                        }
                    }
                    //збираєм категорії з повного шляху до основної категорії
                    $catsTmp=explode('/',$catString);
                    if (is_array($catsTmp))
                    {
                        foreach ($catsTmp as $catTmp)
                        {
                            foreach ($cats as $cat1)
                            {
                                $tmp=$cat1['name'];
                                //echo "$tmp<br>";
                                if (strcasecmp($tmp,$catTmp)==0)
                                {
                                    $catsIdArr[]=$cat1['id'];
                                    //var_dump($catsIdArr);echo"<br>";
                                }
                            }
                        }
                    }

                    if (is_array($catsIdArr))
                    {
                        $catsIdArr=array_unique($catsIdArr);
                        //echo"<pre>";print_r($catsIdArr);echo"</pre>";
                        $str=implode(",", $catsIdArr);
                    }
                    return $str;
                    break;
                }
            }    
        }
    }


    private function setAddCats($item,$cats)
    {
        $txt="</categoryId>".PHP_EOL."<addCategoryId>$cats</addCategoryId>";
        $item=preg_replace("#<\/categoryId>#s",$txt,$item);
        return $item;
    }

    public function test1()
    {
        
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                //echo "<pre>";print_r($data);echo "</pre>";
                if ($data[1]>0)
                {
                    $data[1]="true";
                }
                else
                {
                    $data[1]="false";
                }
                $stocks[]=$data;
            }
        }
        fclose($handle);

        $arr_tmp=$this->xls;
        $xml=$this->readFileUa();
        $categories=$this->getCats($xml);
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);

        $cats=$this->getCats($xml);
        //echo"<pre>";print_r($cats);echo"</pre>";

        
        if (is_array($items)&&is_array($cats))
        {
            foreach ($items as $item)
            {
                $catId=$this->getCatId($item);
                $catString=$this->getCatString($catId, $cats, "");
                $id=$this->getItemArticle($item);
                $addCatStr=$this->getAdditionalCats($id,$cats,$catString);
                $art=$this->getItemArticle($item);
                //тимчасово не винористовуємо 1с
                /*foreach ($stocks as $stock)
                {
                    if ($art==$stock[0])
                    {
                        $item=$this->setAviability($item,$stock[1]);
                    }
                }*/

                $item=$this->setPrice($item);
                $item=$this->setAddCats($item, $addCatStr);
                //полная выгрузка
                //$allItems.=$item.PHP_EOL;
                $catId=$this->getCatId($item);
                //видаляємо всі позиції виробника g-vibe
                $vendor=$this->getItemVendor($item);
                if (($catId==1197)||(strcasecmp($vendor,'Gvibe')==0)||(strcasecmp($art,'NT95304')==0))
                {
                    $item='';
                }
                if ($catId!=1150)
                {
                    $allItems.=$item.PHP_EOL;
                }

                if ($catId==1069||$catId==1007||$catId==1088||$catId==1089||$catId==1145||$catId==1146||$catId==1147||$catId==1090||$catId==1091||$catId==1092||$catId==1093||$catId==1094||$catId==1095||$catId==1055||$catId==1096||$catId==1097||$catId==1098||$catId==1099||$catId==1100||$catId==1008||$catId==1084||$catId==1085||$catId==1060)
                {
                    //аптека
                    $pharmItems.=$item.PHP_EOL;   
                }
                if ($catId==1062||$catId==1005||$catId==1128||$catId==1129||$catId==1130||$catId==1131||$catId==1132||$catId==1133||$catId==1134||$catId==1136||$catId==1137||$catId==1138||$catId==1139||$catId==1140||$catId==1141||$catId==1142||$catId==1143)
                {
                    //белье
                    $underwearItems.=$item.PHP_EOL;
                }
                //var_dump ($item);
                
                //break;
                //break;
            }
            $allItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$allItems);
            $pharmItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$pharmItems);
            $underwearItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$underwearItems);
            //echo "<pre>";print_r($underwearItems);echo "</pre>";
            $allItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$allItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            file_put_contents($this->path2langCat,$allItems);
            //вариант с available="" вместо available="false"
            $allItems1=str_ireplace('available="false"','available=""',$allItems);
            file_put_contents($this->path2lang1Cat,$allItems1);
            //пишем аптеку
            $pharmItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$pharmItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            file_put_contents($this->path2langPharmCat,$pharmItems);
            //пишем белье
            $underwearItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$underwearItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            file_put_contents($this->path2langUnderwearCat,$underwearItems);
        }
    }

    private function getCatString($catId,$catArr,$catStr)
    {
        //$catString="";
        if ($catId!=1068&&$catId!=1069&&$catId!=1062&&$catId!=1061&&$catId!=1150&&$catId!=1156&&$catId!=1197)
        {
            foreach ($catArr as $cat)
            {
                if ($catId==$cat['id'])
                {
                    $name=$cat['name'];
                    //echo "$name;";
                    $catStr=$name."/".$catStr;
                    $catStr=$this->getCatString($cat['parrent'],$catArr,$catStr);
                    //echo "$name/";
                    //$catStr.=$name."/";
                }
            }
            //echo $catStr."<br>";
            
        }
        else 
        {
            foreach ($catArr as $cat)
            {
                if ($catId==$cat['id'])
                {
                    $name=$cat['name'];
                    //echo "$name<br>";
                    $catStr=$name."/".$catStr;
                    $catStr=substr($catStr,0,-1);
                    //echo $catStr."<br>";
                    //return $catStr;
                }
            }
            //echo $catStr."<br>";
            
        }
        //$catString=rtrim($catString,"/");
        //$catString=substr($catString,0,-1);
        //echo $catString;
        //return $catString;
        //echo "<br>";
        //echo $catStr;
        return $catStr;
    }

    private function getItemCat($item)
    {
        preg_match("#<categoryId>(.*?)</categoryId>#",$item,$matches);
        $name=$matches[1];
        return $name;
    }

    public function makeCSV()
    {
        //чітаємо ексельку яку генерує хорошоп
        $path = '36.xlsx';
        //$this->pathOrigAmurchik=$path;
        //$arr_tmp=$this->readExelFile($path);
        $this->xls=$this->readExelFile($path);
        $arr_tmp=$this->xls;

        /*$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        $path = "36.xlsx";
        file_put_contents($path, file_get_contents($url));
        chmod ($path,0777);
        $this->pathOrigAmurchik=$path;*/
        
        file_put_contents($this->pathFullCSV, '');
        file_put_contents($this->pathPharmCSV, '');
        file_put_contents($this->pathUnderwearCSV, '');
        $xml=$this->readFile();
        $categories=$this->getCats($xml);
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        
        $handle1=fopen($this->pathFullCSV, 'w+');
        $handle2=fopen($this->pathPharmCSV, 'w+');
        $handle3=fopen($this->pathUnderwearCSV, 'w+');
        //пишем заголовок
        $tmp=array('vendorCode','name','description','category','vendor','pictures','price','material','weight','lenght','batery type','vibro','country','height','width','diametr','composition','vol','thickness','collection','aroma','color','addCats');
        fputcsv($handle1, $tmp);
        fputcsv($handle2, $tmp);
        fputcsv($handle3, $tmp);

        $this->$specs_mem=$this->getSpecs();
        if (is_array($items)&&is_array($this->$specs_mem))
        {
            foreach ($items as $item)
            {
                $item=$this->setPrice($item);
                //var_dump($item);
                
                $article=$this->getItemArticle($item);
                foreach ($this->$specs_mem as $spec)
                {
                    if ($article==$spec[0])
                    {
                        $material=$spec[1];
                        $weight=$spec[2];
                        $len=$spec[3];
                        $batType=$spec[4];
                        $vibro=$spec[5];
                        $country=$spec[6];
                        $height=$spec[7];
                        $width=$spec[8];
                        $diametr=$spec[9];
                        $composition=$spec[10];
                        $vol=$spec[11];
                        $thickness=$spec[12];
                        $colRu=$spec[13];
                        $aroma=$spec[15];
                        $colorRU=$spec[16];
                        break;
                    }
                }

                //echo "article=".$article." ";
                $name=$this->getItemName($item);
                $description=$this->getItemDescription($item);

                $addCats=$this->getAddSectionsByArticle($article,$arr_tmp);

                $vendor=$this->getItemVendor($item);
                $pictures=$this->getItemPictures($item);
                $price=$this->getItemPrice($item);
                $catId=$this->getItemCat($item);
                $catStr=$this->getCatString($catId,$categories,"");

                //echo $catStr."<br>";
                $arr=array($article,$name,$description,$catStr,$vendor,$pictures,$price,$material,$weight,$len,$batType,$vibro,$country,$height,$width,$diametr,$composition,$vol,$thickness,$colRu,$aroma,$colorRU,$addCats);
                //отсекаем тестеры
                /*if ($catId!=1150)
                {
                    $arr1[]=$arr;
                    //echo "$catId<br>";
                }*/
                //$arr1[]=$arr;
                //echo "<pre>";print_r($arr);echo"</pre>";
                //пишем все //отсекаем тестеры
                if ($catId!=1150||$catId!=1197||strcasecmp($article,'NT95304')!=0)
                {
                    fputcsv($handle1, $arr);
                    $arr1[]=$arr;
                    //echo "art=$article<br>";
                }
                   

                if ($catId==1069||$catId==1007||$catId==1088||$catId==1089||$catId==1145||$catId==1146||$catId==1147||$catId==1090||$catId==1091||$catId==1092||$catId==1093||$catId==1094||$catId==1095||$catId==1055||$catId==1096||$catId==1097||$catId==1098||$catId==1099||$catId==1100||$catId==1008||$catId==1084||$catId==1085||$catId==1060)
                {
                    //аптека
                    fputcsv($handle2, $arr);
                    $arr2[]=$arr;   
                }
                if ($catId==1062||$catId==1005||$catId==1128||$catId==1129||$catId==1130||$catId==1131||$catId==1132||$catId==1133||$catId==1134||$catId==1136||$catId==1137||$catId==1138||$catId==1139||$catId==1140||$catId==1141||$catId==1142||$catId==1143)
                {
                    //белье
                    fputcsv($handle3, $arr);
                    $arr3[]=$arr;
                }
                //break;
            }
        }
        /*echo "<pre>";
        print_r($arr1);
        echo "</pre>";*/
        fclose($handle1);
        fclose($handle2);
        fclose($handle3);

        
        //пишем в ексельку
        require_once 'PHPExcel.php';
        //require_once 'PHPExcel/Writer/Excel5.php';
        require_once 'PHPExcel/Writer/Excel2007.php';
        
        $xls = new PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        $line = 0;
        array_unshift($arr1,$tmp);
        foreach ($arr1 as $line => $item) 
        {
            $line++;
            foreach ($item as $col => $row) 
            {
                $sheet->setCellValueByColumnAndRow($col, $line, $row);
            }
        }

        //$objWriter = new PHPExcel_Writer_Excel5($xls);
        $objWriter = new PHPExcel_Writer_Excel2007($xls);
        $objWriter->save($this->pathFullXLS);
        
        ///////////////////////////
        $xls = new PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        $line = 0;
        array_unshift($arr2,$tmp);
        foreach ($arr2 as $line => $item) 
        {
            $line++;
            foreach ($item as $col => $row) 
            {
                $sheet->setCellValueByColumnAndRow($col, $line, $row);
            }
        }

        $objWriter = new PHPExcel_Writer_Excel5($xls);
        $objWriter->save($this->pathPharmXLS);

        ///////////////////////////
        $xls = new PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        $line = 0;
        array_unshift($arr3,$tmp);
        foreach ($arr3 as $line => $item) 
        {
            $line++;
            foreach ($item as $col => $row) 
            {
                $sheet->setCellValueByColumnAndRow($col, $line, $row);
            }
        }

        $objWriter = new PHPExcel_Writer_Excel5($xls);
        $objWriter->save($this->pathUnderwearXLS);
        
    }

    public function makeCSV5()
    {
        //-$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        //--$path = '36.xlsx';
        //-file_put_contents($path, $this->file_get_contents_curl($url));
        //-chmod ($path,0777);
        //$this->pathOrigAmurchik=$path;
        //--$arr_tmp=$this->readExelFile($path);
        $arr_tmp=$this->xls;


        /*$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        $path = "36.xlsx";
        file_put_contents($path, file_get_contents($url));
        chmod ($path,0777);
        $this->pathOrigAmurchik=$path;*/
        
        file_put_contents($this->pathFullCSV5, '');
        
        $xml=$this->readFile();
        $categories=$this->getCats($xml);
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        
        $handle1=fopen($this->pathFullCSV5, 'w+');
       
        //пишем заголовок
        $tmp=array('vendorCode','name','description','category','vendor','pictures','price','price 5%','material','weight','lenght','batery type','vibro','country','height','width','diametr','composition','vol','thickness','collection','aroma','color','addCats');
        fputcsv($handle1, $tmp);
        $specs=$this->getSpecs();
        //echo "<pre>";print_r($specs);echo"</pre>";
        if (is_array($items)&&is_array($specs))
        {
            foreach ($items as $item)
            {
                $item=$this->setPrice($item);
                //var_dump($item);
                
                $article=$this->getItemArticle($item);
                foreach (/*$this->$*/$specs as $spec)
                {
                    //echo "<pre>";print_r($spec);echo"</pre>";
                    //echo "!<br>";
                    //break;
                    $art=$spec[0];
                    if ($article==$art)
                    {
                        $material=$spec[1];
                        $weight=$spec[2];
                        $len=$spec[3];
                        $batType=$spec[4];
                        $vibro=$spec[5];
                        $country=$spec[6];
                        $height=$spec[7];
                        $width=$spec[8];
                        $diametr=$spec[9];
                        $composition=$spec[10];
                        $vol=$spec[11];
                        $thickness=$spec[12];
                        $colRu=$spec[13];
                        $aroma=$spec[15];
                        $colorRU=$spec[16];
                        //var_dump($spec);echo"<br>";
                        break; 
                    }
                }
                //echo "article=".$article." ";
                $name=$this->getItemName($item);
                $description=$this->getItemDescription($item);
                $description=str_replace(array("\r\n", "\r", "\n", "\t"), '',$description);

                $addCats=$this->getAddSectionsByArticle($article,$arr_tmp);
                //$name=$this->getItemName($item);
                //$description=$this->getItemDescription($item);
                $vendor=$this->getItemVendor($item);
                $pictures=$this->getItemPictures($item);
                $price=$this->getItemPrice($item);
                $catId=$this->getItemCat($item);
                $catStr=$this->getCatString($catId,$categories,"");

                $price5=$this->getPrice5($article,$arr_tmp);

                //echo $catStr."<br>";
                $arr=array($article,$name,$description,$catStr,$vendor,$pictures,$price,$price5,$material,$weight,$len,$batType,$vibro,$country,$height,$width,$diametr,$composition,$vol,$thickness,$colUa,$aroma,$colorUa,$addCats);
                //отсекаем тестеры
                /*if ($catId!=1150)
                {
                    $arr1[]=$arr;
                    //echo "$catId<br>";
                }*/
                //$arr1[]=$arr;
                //echo "<pre>";print_r($arr);echo"</pre>";
                //пишем все //отсекаем тестеры
                if ($catId!=1150||$catId!=1197||strcasecmp($article,'NT95304')!=0)
                {
                    fputcsv($handle1, $arr);
                    $arr1[]=$arr;
                }
                   

                
                //break;
            }
        }
        else
        {
            echo "no array<br>";
        }
        fclose($handle1);
        
    }

    public function makeCSV10()
    {
        //-$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        //--$path = '36.xlsx';
        //-file_put_contents($path, $this->file_get_contents_curl($url));
        //-chmod ($path,0777);
        //$this->pathOrigAmurchik=$path;
        //--$arr_tmp=$this->readExelFile($path);
        $arr_tmp=$this->xls;


        /*$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        $path = "36.xlsx";
        file_put_contents($path, file_get_contents($url));
        chmod ($path,0777);
        $this->pathOrigAmurchik=$path;*/
        
        file_put_contents($this->pathFullCSV10, '');
        
        $xml=$this->readFile();
        $categories=$this->getCats($xml);
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        
        $handle1=fopen($this->pathFullCSV10, 'w+');
       
        //пишем заголовок
        $tmp=array('vendorCode','name','description','category','vendor','pictures','price','price 10%','material','weight','lenght','batery type','vibro','country','height','width','diametr','composition','vol','thickness','collection','aroma','color','addCats');
        fputcsv($handle1, $tmp);
        //$specs=$this->getSpecs();
        if (is_array($items)&&is_array($this->specs_mem))
        {
            foreach ($items as $item)
            {
                $item=$this->setPrice($item);
                //var_dump($item);
                
                $article=$this->getItemArticle($item);
                foreach ($this->specs_mem as $spec)
                {
                    
                    if ($article==$spec[0])
                    {
                        $material=$spec[1];
                        $weight=$spec[2];
                        $len=$spec[3];
                        $batType=$spec[4];
                        $vibro=$spec[5];
                        $country=$spec[6];
                        $height=$spec[7];
                        $width=$spec[8];
                        $diametr=$spec[9];
                        $composition=$spec[10];
                        $vol=$spec[11];
                        $thickness=$spec[12];
                        $colRu=$spec[13];
                        $aroma=$spec[15];
                        $colorRU=$spec[16];
                        break; 
                    }
                }
                //echo "article=".$article." ";
                $name=$this->getItemName($item);
                $description=$this->getItemDescription($item);
                $description=str_replace(array("\r\n", "\r", "\n", "\t"), '',$description);

                $addCats=$this->getAddSectionsByArticle($article,$arr_tmp);
                //$name=$this->getItemName($item);
                //$description=$this->getItemDescription($item);
                $vendor=$this->getItemVendor($item);
                $pictures=$this->getItemPictures($item);
                $price=$this->getItemPrice($item);
                $catId=$this->getItemCat($item);
                $catStr=$this->getCatString($catId,$categories,"");

                $price10=$this->getPrice10($article,$arr_tmp);

                //echo $catStr."<br>";
                $arr=array($article,$name,$description,$catStr,$vendor,$pictures,$price,$price5,$material,$weight,$len,$batType,$vibro,$country,$height,$width,$diametr,$composition,$vol,$thickness,$colUa,$aroma,$colorUa,$addCats);
                //отсекаем тестеры
                /*if ($catId!=1150)
                {
                    $arr1[]=$arr;
                    //echo "$catId<br>";
                }*/
                //$arr1[]=$arr;
                //echo "<pre>";print_r($arr);echo"</pre>";
                //пишем все //отсекаем тестеры
                if ($catId!=1150&&$catId!=1197&&(strcasecmp($article,'NT95304')!=0))
                {
                    fputcsv($handle1, $arr);
                    $arr1[]=$arr;
                }
                   

                
                //break;
            }
        }
        else
        {
            echo "no array<br>";
        }
        fclose($handle1);
        
    }

    public function makeCSVUkr()
    {
        //-$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        //--$path = '36.xlsx';
        //-file_put_contents($path, $this->file_get_contents_curl($url));
        //-chmod ($path,0777);
        //$this->pathOrigAmurchik=$path;
        //--$arr_tmp=$this->readExelFile($path);
        $arr_tmp=$this->xls;


        /*$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        $path = "36.xlsx";
        file_put_contents($path, file_get_contents($url));
        chmod ($path,0777);
        $this->pathOrigAmurchik=$path;*/
        
        file_put_contents($this->pathFullCSVUkr, '');
        file_put_contents($this->pathPharmCSVUkr, '');
        file_put_contents($this->pathUnderwearCSVUkr, '');
        $xml=$this->readFile();
        $categories=$this->getCats($xml);
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        
        $handle1=fopen($this->pathFullCSVUkr, 'w+');
        $handle2=fopen($this->pathPharmCSVUkr, 'w+');
        $handle3=fopen($this->pathUnderwearCSVUkr, 'w+');
        //пишем заголовок
        $tmp=array('vendorCode','name','description','category','vendor','pictures','price','material','weight','lenght','batery type','vibro','country','height','width','diametr','composition','vol','thickness','collection','aroma','color','addCats');
        fputcsv($handle1, $tmp);
        fputcsv($handle2, $tmp);
        fputcsv($handle3, $tmp);
        //$specs=$this->getSpecs();
        if (is_array($items)&&is_array($this->$specs))
        {
            foreach ($items as $item)
            {
                $item=$this->setPrice($item);
                //var_dump($item);
                
                $article=$this->getItemArticle($item);
                foreach ($this->$specs as $spec)
                {
                    if ($article==$spec[0])
                    {
                        $material=$spec[1];
                        $weight=$spec[2];
                        $len=$spec[3];
                        $batType=$spec[4];
                        $vibro=$spec[5];
                        $country=$spec[6];
                        $height=$spec[7];
                        $width=$spec[8];
                        $diametr=$spec[9];
                        $composition=$spec[10];
                        $vol=$spec[11];
                        $thickness=$spec[12];
                        $colUa=$spec[14];
                        $aroma=$spec[15];
                        $colorUa=$spec[17];
                        break;
                    }
                }
                //echo "article=".$article." ";
                $name=$this->getNameUkrByArticle($article,$arr_tmp);
                //echo "$article $name<br>";
                $description=$this->getDescrUkrByArticle($article,$arr_tmp);
                $description=str_replace(array("\r\n", "\r", "\n", "\t"), '',$description);

                $addCats=$this->getAddSectionsByArticle($article,$arr_tmp);
                //$name=$this->getItemName($item);
                //$description=$this->getItemDescription($item);
                $vendor=$this->getItemVendor($item);
                $pictures=$this->getItemPictures($item);
                $price=$this->getItemPrice($item);
                $catId=$this->getItemCat($item);
                $catStr=$this->getCatString($catId,$categories,"");
                //echo $catStr."<br>";
                $arr=array($article,$name,$description,$catStr,$vendor,$pictures,$price,$material,$weight,$len,$batType,$vibro,$country,$height,$width,$diametr,$composition,$vol,$thickness,$colUa,$aroma,$colorUa,$addCats);
                //отсекаем тестеры
                /*if ($catId!=1150)
                {
                    $arr1[]=$arr;
                    //echo "$catId<br>";
                }*/
                //$arr1[]=$arr;
                //echo "<pre>";print_r($arr);echo"</pre>";
                //пишем все //отсекаем тестеры
                if ($catId!=1150||$catId!=1197||(strcasecmp($article,'NT95304')!=0))
                {
                    fputcsv($handle1, $arr);
                    $arr1[]=$arr;
                }
                   

                if ($catId==1069||$catId==1007||$catId==1088||$catId==1089||$catId==1145||$catId==1146||$catId==1147||$catId==1090||$catId==1091||$catId==1092||$catId==1093||$catId==1094||$catId==1095||$catId==1055||$catId==1096||$catId==1097||$catId==1098||$catId==1099||$catId==1100||$catId==1008||$catId==1084||$catId==1085||$catId==1060)
                {
                    //аптека
                    fputcsv($handle2, $arr);
                    $arr2[]=$arr;   
                }
                if ($catId==1062||$catId==1005||$catId==1128||$catId==1129||$catId==1130||$catId==1131||$catId==1132||$catId==1133||$catId==1134||$catId==1136||$catId==1137||$catId==1138||$catId==1139||$catId==1140||$catId==1141||$catId==1142||$catId==1143)
                {
                    //белье
                    fputcsv($handle3, $arr);
                    $arr3[]=$arr;
                }
                //break;
            }
        }
        fclose($handle1);
        fclose($handle2);
        fclose($handle3);

        //пишим в ексельку
        require_once 'PHPExcel.php';
        //require_once 'PHPExcel/Writer/Excel5.php';
        require_once 'PHPExcel/Writer/Excel2007.php';
        
        $xls = new PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        $line = 0;
        array_unshift($arr1,$tmp);
        foreach ($arr1 as $line => $item) 
        {
            $line++;
            foreach ($item as $col => $row) 
            {
                $sheet->setCellValueByColumnAndRow($col, $line, $row);
            }
        }

        //$objWriter = new PHPExcel_Writer_Excel5($xls);
        $objWriter = new PHPExcel_Writer_Excel2007($xls);
        $objWriter->save($this->pathFullXLSUkr);
        
        ///////////////////////////
        $xls = new PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        $line = 0;
        array_unshift($arr2,$tmp);
        foreach ($arr2 as $line => $item) 
        {
            $line++;
            foreach ($item as $col => $row) 
            {
                $sheet->setCellValueByColumnAndRow($col, $line, $row);
            }
        }

        $objWriter = new PHPExcel_Writer_Excel5($xls);
        $objWriter->save($this->pathPharmXLSUkr);

        ///////////////////////////
        $xls = new PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        $line = 0;
        array_unshift($arr3,$tmp);
        foreach ($arr3 as $line => $item) 
        {
            $line++;
            foreach ($item as $col => $row) 
            {
                $sheet->setCellValueByColumnAndRow($col, $line, $row);
            }
        }

        $objWriter = new PHPExcel_Writer_Excel5($xls);
        $objWriter->save($this->pathUnderwearXLSUkr);
    }

    /*private function getItemQuantity($item)
    {
        
    }*/

    public function makeStock()
    {
        //читаем файл с остатками (в переменной stocks будут лежать артикул и остаток)
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                //echo "<pre>";print_r($data);echo "</pre>";
                if (intval($data[1])>5)
                {
                    $data[1]=">5";
                }
                $stocks[]=$data;
            }
        }
        fclose($handle);

        //читаємо штрихкоди з ексельки
        if (is_array($this->xls))
        {
            foreach ($this->xls as $elem)
            {
                $art=$elem[0];
                $barcode=$elem[66];
                $barcodes[]=array($art,$barcode);
            }
        }

        //поки не було 1с, остатки грузили з сайту
        //echo "<pre>";print_r($stocks);echo "</pre>";
        //-$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        //-$path = "36.xlsx";
        //-file_put_contents($path, file_get_contents($url));
        //-chmod ($path,0777);
        //-$this->pathOrigAmurchik=$path;

        //якщо зщапускаємо тільки це
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        //$this->xls=$this->readExelFile($path);
        //
        //var_dump($this->xls);
        //$arr=$this->$xls;
        //var_dump($arr);
        //echo "<pre>";print_r($arr);echo "</pre>";
        
        /*if (is_array($this->xls))
        {
            //array_unshift($this->xls);
            foreach ($this->xls as $elem)
            {
                $art=$elem[0];
                $quantity=$elem[23];
                //$quantity=$elem[48];
                //echo "$quantity<br>";
                if (strcmp($quantity,'Больше 5 шт.')==0)
                //if ($quantity>5)
                {
                    $quantity=">5";
                }
                else
                {
                   $quantity=preg_replace('~\W+~','', $quantity);
                    
                    if (strcmp($quantity,'')==0)
                    {
                        $quantity="0";
                    } 
                }
                //echo "$art $quantity<br>";
                $stocks[]=array($art,$quantity);
                
            }
        }
        else
        {
            echo "no arr!<br>";
        }
        //echo "<pre>";print_r($stocks);echo "</pre>";
        //break;*/
        
        //читаем xml
        $xml=$this->readFile();
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        if (is_array($items))
        {
            foreach ($items as $item)
            {
                $item=$this->setPrice($item);

                $name=$this->getItemName($item);
                $price=$this->getItemPrice($item);
                $id=trim($this->getItemArticle($item));
                //отсекаем тестера
                $catId=$this->getCatId($item);
                if ($catId!=1150||$catId!=1197||(strcasecmp($id,'NT95304')!=0))
                {
                    $xmlArr[]=array($id,$name,$price);
                    //echo "art=$id<br>";
                }
                //$xmlArr[]=array($id,$name,$price);
                
            }
        }
        //echo "<pre>";print_r($xmlArr);echo "</pre>";
        //echo "<pre>";print_r($stocks);echo "</pre>";
        //var_dump($stocks);echo"<br>";
        $tmp=null;
        if (is_array($xmlArr)&&is_array($stocks)&&is_array($barcodes))
        {
            foreach ($xmlArr as $arr)
            {
                
                $id=$arr[0];
                //echo "art=$id<br>";
                //var_dump($id);
                // echo "<br>";
                $name=$arr[1];
                $price=$arr[2];
                
                foreach ($barcodes as $bc) 
                {
                    // code...
                    $barcode=0;
                    //echo"<pre>";print_r($bc);echo"</pre>";
                    if (strcmp($id,$bc[0])==0)
                    {
                        //echo "Yay!<br>";
                        $barcode=$bc[1];
                        break;
                    }
                }

                foreach ($stocks as $stock)
                {
                    $stt=trim($stock[0]);
                    if (strcasecmp($id,$stt)==0)
                    {
                        $st=$stock[1];
                        $tmp=array($id,$st,$price,$name,$barcode);
                        $arr1[]=$tmp;
                        //echo "<pre>";print_r($tmp);echo "</pre>";
                        break;
                    }
                }
            }
            //var_dump($arr1);
            //echo "<pre>";print_r($arr1);echo "</pre>";
            require_once 'PHPExcel.php';
            require_once 'PHPExcel/Writer/Excel5.php';
            
            $xls = new PHPExcel();
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
            $tmp=array('vendorCode','stock','price','name', 'barcode');
            array_unshift($arr1,$tmp);
            $line = 0;
            foreach ($arr1 as $line => $item) 
            {
                $line++;
                foreach ($item as $col => $row) 
                {
                    $sheet->setCellValueByColumnAndRow($col, $line, $row);
                }
            }

            $objWriter = new PHPExcel_Writer_Excel5($xls);
            $objWriter->save($this->stock);
        }
        
        

        

    }

    public function makeStockUkr()
    {
        //читаем файл с остатками (в переменной stocks будут лежать артикул и остаток)
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                //echo "<pre>";print_r($data);echo "</pre>";
                if (intval($data[1])>5)
                {
                    $data[1]=">5";
                }
                $stocks[]=$data;
            }
        }
        fclose($handle);
        //echo "<pre>";print_r($stocks);echo "</pre>";
        
        //поки не було 1с, остатки грузили з сайту
        //-$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        //-$path = "36.xlsx";
        //-file_put_contents($path, file_get_contents($url));
        //-chmod ($path,0777);
        //-$this->pathOrigAmurchik=$path;
        //$arr=$this->$xls;
        //echo "<pre>";print_r($this->xls);echo "</pre>";
        /*if (is_array($this->xls))
        {
            //array_unshift($arr);
            foreach ($this->xls as $elem)
            {
                $art=$elem[0];
                $quantity=$elem[23];
                //$quantity=$elem[48];
                //echo "$quantity<br>";
                if (strcmp($quantity,'Больше 5 шт.')==0)
                //if ($quantity>5)
                {
                    $quantity=">5";
                }
                else
                {
                   $quantity=preg_replace('~\W+~','', $quantity);
                    
                    if (strcmp($quantity,'')==0)
                    {
                        $quantity="0";
                    } 
                }
                //echo "$art $quantity<br>";
                $stocks[]=array($art,$quantity);
                
            }
        }
        //echo "<pre>";print_r($stocks);echo "</pre>";
        //break;*/
        
        //читаем xml
        $xml=$this->readFileUa();
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        if (is_array($items))
        {
            foreach ($items as $item)
            {
                $item=$this->setPrice($item);
                ####
                //$name=$this->getItemName($item);
                
                $price=$this->getItemPrice($item);
                $id=$this->getItemArticle($item);

                $name=$this->getNameUkr($item);
                //отсекаем тестера
                $catId=$this->getCatId($item);
                if ($catId!=1150||$catId!=1197||strcasecmp($id,'NT95304')!=0)
                {
                    $xmlArr[]=array($id,$name,$price);
                }
                //$xmlArr[]=array($id,$name,$price);
                
            }
        }
        //echo "<pre>";print_r($xmlArr);echo "</pre>";
        $tmp=null;
        if (is_array($xmlArr)&&is_array($stocks))
        {
            foreach ($xmlArr as $arr)
            {
                
                $id=$arr[0];
                $name=$arr[1];
                $price=$arr[2];
                foreach ($stocks as $stock)
                {
                    $stt=trim($stock[0]);
                    if (strcasecmp($id,$stt)==0)
                    {
                        $st=$stock[1];
                        $tmp=array($id,$st,$price,$name);
                        $arr1[]=$tmp;
                        //echo "<pre>";print_r($tmp);echo "</pre>";
                        break;
                    }
                }
            }
            require_once 'PHPExcel.php';
            require_once 'PHPExcel/Writer/Excel5.php';
            
            $xls = new PHPExcel();
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
            $tmp=array('vendorCode','stock','price','name');
            array_unshift($arr1,$tmp);
            $line = 0;
            foreach ($arr1 as $line => $item) 
            {
                $line++;
                foreach ($item as $col => $row) 
                {
                    $sheet->setCellValueByColumnAndRow($col, $line, $row);
                }
            }

            $objWriter = new PHPExcel_Writer_Excel5($xls);
            $objWriter->save($this->stockUkr);
        }
        
        

        

    }

    private function readExelFile($filepath)
    {
        require_once 'PHPExcel.php'; //подключаем наш фреймворк
        $ar=array(); //инициализируем массив
        $inputFileType = PHPExcel_IOFactory::identify($filepath);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
        $objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
        $objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект
        $ar = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив
        return $ar; //возвращаем массив
    }

    //окрема вигрузка з оптовими цінами для програми 4
    public function makeProgram4()
    {

        //$course=$this->getExchangeRate('https://tonga.in.ua/');
        //var_dump($course);

        

        //если запускатьотдельно - раскоментить
        /*$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        $path = '36.xlsx';
        //file_put_contents($path, $this->file_get_contents_curl($url));
        chmod ($path,0777);
        $this->pathOrigAmurchik=$path;
        
        //file_put_contents($this->pathAmurchik, '');
        $arr=$this->readExelFile($this->pathOrigAmurchik);
        //echo "<pre>";print_r($arr);echo "</pre>";*/

        //$arr=$this->xls;
        
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                
                //echo "<pre>";print_r($data);echo "</pre>";

                if ($data[1]!=0)
                {
                    $data[1]=strstr($data[1], ',', true);
                }
                
                if (intval($data[1])>5)
                {
                    $data[1]=">5";
                }
                $tmp=" ".$data[0];//||strcasecmp($id,'NT95304')!=0//##
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false)&&(strripos($tmp,"Попперс")==false)&&(strripos($tmp,"NT95304")==false))
                {
                    $stocks[]=$data;
                }
                //$stocks[]=$data;
            }
        }
        fclose($handle);

        //поки не було 1с, остатки грузили з сайту
        /*if (is_array($this->xls))
        {
            //array_unshift($arr);
            foreach ($this->xls as $elem)
            {
                $art=$elem[0];
                $quantity=$elem[23];
                //echo "$quantity<br>";
                $tmp=" ".$art;
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false))
                {
                    if (strcmp($quantity,'Больше 5 шт.')==0)
                    {
                        $quantity=">5";
                    }
                    else
                    {
                       $quantity=preg_replace('~\W+~','', $quantity);
                        
                        if (strcmp($quantity,'')==0)
                        {
                            $quantity="0";
                        } 
                    }
                    //echo "$art $quantity<br>";
                    $stocks[]=array($art,$quantity);
                }
            }
        }
        //echo "<pre>";print_r($stocks);echo "</pre>";*/
        
        
        if (is_array($this->xls)&&is_array($stocks))
        {
            //echo "yay!";
            //вже не треба по курсу
            //$course=intval($this->getExchangeRate('https://tonga.in.ua/'));
            
            file_put_contents($this->pathGroup4, '');
            //file_put_contents($this->pathNasoloda, '');
            
            
            $handle=fopen($this->pathGroup4, 'w+');
            //$handle_ns=fopen($this->pathNasoloda, 'w+');
            $tmp=array('vendorCode','stock','price','name','price_wholesale','barcode','brand');
            fputcsv($handle, $tmp, ";");
            //fputcsv($handle_ns, $tmp, ";");
            foreach ($this->xls as $ar)
            {
                $id=$ar[0];
                $price=intval($ar[10]);
                $brand=$ar[7];
                if ($price==null)
                {
                    $price=0;
                }
                    
                //ціна для насолоди
                $price_ns=$price;

                //цена по курсу
                //$price=round($price/$course,2);
                //вже не трнба

                $name=$ar[5];
                $barcode=$ar[66];
                $price_opt=intval($ar[13]);
                $visible=$ar[22];
                
                //ціна для насолоди
                //$price_opt_ns=$price_opt;
                //цена по курсу (вже не треба)
                //$price_opt=round($price_opt/$course,2);
                foreach ($stocks as $stock)
                {
                    $stt=trim($stock[0]);
                    if ((strcasecmp($id,$stt)==0)&&(strcmp($visible,"Да")==0))
                    {
                        $st=$stock[1];
                        $tmp=array($id,$st,$price,$name,$price_opt,$barcode,$brand);
                        //$arr1[]=$tmp;
                        //$tmp_ns=array($id,$st,$price_ns,$name,$price_opt_ns,$barcode,$brand);
                        //$arr_ns[]=$tmp;
                        //echo "<pre>";print_r($tmp);echo "</pre>";
                        fputcsv($handle, $tmp, ";");
                        //fputcsv($handle_ns, $tmp_ns, ";");
                        break;
                    }
                }
            }
            fclose($handle);
        }
    }
    
    public function makeAmurchik()
    {

        //$course=$this->getExchangeRate('https://tonga.in.ua/');
        //var_dump($course);

        

        //если запускатьотдельно - раскоментить
        /*$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        $path = '36.xlsx';
        //file_put_contents($path, $this->file_get_contents_curl($url));
        chmod ($path,0777);
        $this->pathOrigAmurchik=$path;
        
        //file_put_contents($this->pathAmurchik, '');
        $arr=$this->readExelFile($this->pathOrigAmurchik);
        //echo "<pre>";print_r($arr);echo "</pre>";*/

        //$arr=$this->xls;
        
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                
                //echo "<pre>";print_r($data);echo "</pre>";

                if ($data[1]!=0)
                {
                    $data[1]=strstr($data[1], ',', true);
                }
                
                if (intval($data[1])>5)
                {
                    $data[1]=">5";
                }
                $tmp=" ".$data[0];//||strcasecmp($id,'NT95304')!=0//##
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false)&&(strripos($tmp,"Попперс")==false)&&(strripos($tmp,"NT95304")==false))
                {
                    $stocks[]=$data;
                }
                //$stocks[]=$data;
            }
        }
        fclose($handle);

        //поки не було 1с, остатки грузили з сайту
        /*if (is_array($this->xls))
        {
            //array_unshift($arr);
            foreach ($this->xls as $elem)
            {
                $art=$elem[0];
                $quantity=$elem[23];
                //echo "$quantity<br>";
                $tmp=" ".$art;
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false))
                {
                    if (strcmp($quantity,'Больше 5 шт.')==0)
                    {
                        $quantity=">5";
                    }
                    else
                    {
                       $quantity=preg_replace('~\W+~','', $quantity);
                        
                        if (strcmp($quantity,'')==0)
                        {
                            $quantity="0";
                        } 
                    }
                    //echo "$art $quantity<br>";
                    $stocks[]=array($art,$quantity);
                }
            }
        }
        //echo "<pre>";print_r($stocks);echo "</pre>";*/
        
        
        if (is_array($this->xls)&&is_array($stocks))
        {
            //echo "yay!";
            //вже не треба по курсу
            //$course=intval($this->getExchangeRate('https://tonga.in.ua/'));
            
            file_put_contents($this->pathAmurchik, '');
            //file_put_contents($this->pathNasoloda, '');
            
            
            $handle=fopen($this->pathAmurchik, 'w+');
            //$handle_ns=fopen($this->pathNasoloda, 'w+');
            $tmp=array('vendorCode','stock','price','name','price_wholesale','barcode','brand');
            fputcsv($handle, $tmp, ";");
            //fputcsv($handle_ns, $tmp, ";");
            foreach ($this->xls as $ar)
            {
                $id=$ar[0];
                $price=intval($ar[10]);
                $brand=$ar[7];
                if ($price==null)
                {
                    $price=0;
                }
                    
                //ціна для насолоди
                $price_ns=$price;

                //цена по курсу
                //$price=round($price/$course,2);
                //вже не трнба

                $name=$ar[5];
                $barcode=$ar[66];
                $price_opt=intval($ar[9]);
                $visible=$ar[22];
                
                //ціна для насолоди
                $price_opt_ns=$price_opt;
                //цена по курсу (вже не треба)
                //$price_opt=round($price_opt/$course,2);
                foreach ($stocks as $stock)
                {
                    $stt=trim($stock[0]);
                    if ((strcasecmp($id,$stt)==0)&&(strcmp($visible,"Да")==0))
                    {
                        $st=$stock[1];
                        $tmp=array($id,$st,$price,$name,$price_opt,$barcode,$brand);
                        $arr1[]=$tmp;
                        //$tmp_ns=array($id,$st,$price_ns,$name,$price_opt_ns,$barcode,$brand);
                        //$arr_ns[]=$tmp;
                        //echo "<pre>";print_r($tmp);echo "</pre>";
                        fputcsv($handle, $tmp, ";");
                        //fputcsv($handle_ns, $tmp_ns, ";");
                        break;
                    }
                }
            }
            fclose($handle);
        }
    }

    public function makeAmirov()
    {
        //если запускать отдельно - раскоментить
        /*$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        $path = "36.xlsx";
        //file_put_contents($path, file_get_contents($url));
        chmod ($path,0777);
        $this->pathOrigAmurchik=$path;
        
        file_put_contents($this->pathAmirov, '');
        $arr=$this->readExelFile($this->pathOrigAmurchik);
        //echo "<pre>";print_r($arr);echo "</pre>";*/

        //$arr=$this->xls;
        
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                //
                //echo "<pre>";print_r($data);echo "</pre>";
                if ($data[1]!=0)
                {
                    $data[1]=strstr($data[1], ',', true);
                }
                
                //echo "<pre>";print_r($data);echo "</pre>";
                if (intval($data[1])>5)
                {
                    $data[1]=">5";
                }
                $tmp=" ".$data[0];
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false)&&(strripos($tmp,"Попперс")==false)&&(strripos($tmp,"NT95304")==false))
                {
                    $stocks[]=$data;
                }
                //$stocks[]=$data;
            }
        }
        fclose($handle);
        

        /*if (is_array($this->xls))
        {
            //array_unshift($arr);
            foreach ($this->xls as $elem)
            {
                $art=$elem[0];
                $quantity=$elem[23];
                //echo "$quantity<br>";
                $tmp=" ".$art;
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false))
                {
                    if (strcmp($quantity,'Больше 5 шт.')==0)
                    {
                        $quantity=">5";
                    }
                    else
                    {
                       $quantity=preg_replace('~\W+~','', $quantity);
                        
                        if (strcmp($quantity,'')==0)
                        {
                            $quantity="0";
                        } 
                    }
                    //echo "$art $quantity<br>";
                    $stocks[]=array($art,$quantity);
                }
            }
        }
        //echo "<pre>";print_r($stocks);echo "</pre>";*/

        //file_put_contents($this->pathAmirov, '');
        if (is_array($this->xls)&&is_array($stocks))
        {
            //echo "yay!";
            $handle=fopen($this->pathAmirov, 'w+');
            $tmp=array('vendorCode','stock','price','name');
            fputcsv($handle, $tmp);
            foreach ($this->xls as $ar)
            {
                $id=$ar[0];
                $price=$ar[11];
                if ($price==null)
                {
                    $price=0;
                }
                $name=$ar[5];
                foreach ($stocks as $stock)
                {
                    $stt=trim($stock[0]);
                    if (strcasecmp($id,$stt)==0)
                    {
                        $st=$stock[1];
                        $tmp=array($id,$st,$price,$name);
                        $arr1[]=$tmp;
                        //echo "<pre>";print_r($tmp);echo "</pre>";
                        fputcsv($handle, $tmp);
                        break;
                    }
                }
            }
            fclose($handle);
        }
        
    }


    public function makeOtherUkr()
    {
        
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                //echo "<pre>";print_r($data);echo "</pre>";
                if (intval($data[1])>5)
                {
                    $data[1]=">5";
                }
                $tmp=" ".$data[0];
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false)&&(strripos($tmp,"Попперс")==false)&&(strripos($tmp,"NT95304")==false))
                {
                    $stocks[]=$data;
                }
                //$stocks[]=$data;
            }
        }
        fclose($handle);
        //$stocks - массив вида артикул-остаток

         //читаємо штрихкода
        /*$path = "36.xlsx";
        $arrTmp=$this->readExelFile($path);*/
        $arrTmp=$this->xls;
        if (is_array($arrTmp))
        {
            foreach ($arrTmp as $elem)
            {
                $art=$elem[0];
                $barcode=$elem[66];
                $barcodes[]=array($art,$barcode);
            }
        }

        //поки не було 1с, остатки грузили з сайту
        /*$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        $path = "36.xlsx";
        file_put_contents($path, file_get_contents($url));
        chmod ($path,0777);
        $this->pathOrigAmurchik=$path;//*/
        /*$arr=$this->readExelFile($this->pathOrigAmurchik);
        //echo "<pre>";print_r($arr);echo "</pre>";*/
        /*if (is_array($this->xls))
        {
            //array_unshift($arr);
            foreach ($this->xls as $elem)
            {
                $art=$elem[0];
                $quantity=$elem[23];
                $price=$elem[16];
                $barcode=$elem[60];
                //echo "$price";
                //break;
                //echo "$quantity<br>";
                $tmp=" ".$art;
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false))
                {
                    if (strcmp($quantity,'Больше 5 шт.')==0)
                    {
                        $quantity=">5";
                    }
                    else
                    {
                       $quantity=preg_replace('~\W+~','', $quantity);
                        
                        if (strcmp($quantity,'')==0)
                        {
                            $quantity="0";
                        } 
                    }
                    //echo "$art $quantity<br>";
                    $stocks[]=array($art,$quantity,$price,$barcode);
                }
                
                
            }
        }*/

        $xml=$this->readFileUa();
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        if (is_array($items)&&is_array($stocks)&&is_array($barcodes))
        {
            $handle=fopen($this->pathOtherUkr, 'w+');
            $tmp=array('vendorCode','name','price','РРЦ','stock','barcode');
            fputcsv($handle, $tmp, ";");
            foreach ($items as $item)
            {
                $article=$this->getItemArticle($item);
                //$name=$this->getItemName($item);
                $name=$this->getNameUkr($item);
                $RRP=$this->getItemRRP($item);

                foreach ($barcodes as $bc) 
                {
                    // code...
                    $barcode=0;
                    //echo"<pre>";print_r($bc);echo"</pre>";
                    if (strcmp($article,$bc[0])==0)
                    {
                        $barcode=$bc[1];
                        break;
                    }
                }

                foreach ($stocks as $stock)
                {
                    $stt=trim($stock[0]);
                    if (strcasecmp($article,$stt)==0)
                    {
                        $st=$stock[1];
                        $price=$stock[2];
                        //$barcode=$stock[3];
                        $tmp=array($article,$name,$price,$RRP,$st,$barcode);
                        $arr1[]=$tmp;
                        //echo "<pre>";print_r($tmp);echo "</pre>";
                        //break;//##
                        fputcsv($handle, $tmp, ";");
                        break;
                    }
                }
            }
            fclose($handle);
        }
        else
        {
            echo "No array!<br/>";
        }

        /*if (is_array($arr)&&is_array($stocks))
        {
            //echo "yay!";
            $handle=fopen($this->pathAmirov, 'w+');
            $tmp=array('vendorCode','stock','price','name');
            fputcsv($handle, $tmp);
            foreach ($arr as $ar)
            {
                $id=$ar[0];
                $price=$ar[11];
                if ($price==null)
                {
                    $price=0;
                }
                $name=$ar[5];
                foreach ($stocks as $stock)
                {
                    if (strcmp($id,$stock[0])==0)
                    {
                        $st=$stock[1];
                        $tmp=array($id,$st,$price,$name);
                        $arr1[]=$tmp;
                        //echo "<pre>";print_r($tmp);echo "</pre>";
                        fputcsv($handle, $tmp);
                        break;
                    }
                }
            }
            fclose($handle);
        }*/
        
    }


    public function makeOther()
    {
        
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                //echo "<pre>";print_r($data);echo "</pre>";
                if (intval($data[1])>5)
                {
                    $data[1]=">5";
                }
                $tmp=" ".$data[0];
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false)&&(strripos($tmp,"Попперс")==false)&&(strripos($tmp,"NT95304")==false))
                {
                    $stocks[]=$data;
                }
                //$stocks[]=$data;
            }
        }
        fclose($handle);
        //$stocks - массив вида артикул-остаток

        //читаємо штрихкода
        //$path = "36.xlsx";
        //$arrTmp=$this->readExelFile($path);
        $arrTmp=$this->xls;
        if (is_array($arrTmp))
        {
            foreach ($arrTmp as $elem)
            {
                $art=$elem[0];
                $barcode=$elem[66];
                $barcodes[]=array($art,$barcode);
            }
        }

        //поки не було 1с, остатки грузили з сайту
        /*$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        $path = "36.xlsx";
        file_put_contents($path, file_get_contents($url));
        chmod ($path,0777);
        $this->pathOrigAmurchik=$path;*/
        //$arr=$this->readExelFile($this->pathOrigAmurchik);
        //echo "<pre>";print_r($arr);echo "</pre>";
        /*if (is_array($this->xls))
        {
            //array_unshift($arr);
            foreach ($this->xls as $elem)
            {
                $art=$elem[0];
                $quantity=$elem[23];
                $price=$elem[16];
                $barcode=$elem[60];
                //echo "$price";
                //break;
                //echo "$quantity<br>";
                $tmp=" ".$art;
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false))
                {
                    if (strcmp($quantity,'Больше 5 шт.')==0)
                    {
                        $quantity=">5";
                    }
                    else
                    {
                       $quantity=preg_replace('~\W+~','', $quantity);
                        
                        if (strcmp($quantity,'')==0)
                        {
                            $quantity="0";
                        } 
                    }
                    //echo "$art $quantity<br>";
                    $stocks[]=array($art,$quantity,$price,$barcode);
                }
                
                
            }
        }*/

        $xml=$this->readFile();
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        //echo"<pre>";print_r($barcodes);echo"</pre>";
        
        if (is_array($items)&&is_array($stocks)&&is_array($barcodes))
        {
            $handle=fopen($this->pathOther, 'w+');
            $tmp=array('vendorCode','name','price','РРЦ','stock','barcode');
            fputcsv($handle, $tmp, ";");
            foreach ($items as $item)
            {
                $article=$this->getItemArticle($item);
                $name=$this->getItemName($item);
                $RRP=$this->getItemRRP($item);
                foreach ($barcodes as $bc) 
                {
                    // code...
                    $barcode=0;
                    //echo"<pre>";print_r($bc);echo"</pre>";
                    if (strcmp($article,$bc[0])==0)
                    {
                        //echo "Yay!<br>";
                        $barcode=$bc[1];
                        break;
                    }
                }

                foreach ($stocks as $stock)
                {
                    $stt=trim($stock[0]);
                    //if (strcasecmp($id,$stt)==0)
                    if (strcasecmp($article,$stt)==0)
                    {
                        $st=$stock[1];
                        $price=$stock[2];
                        //$barcode=$stock[3];
                        $tmp=array($article,$name,$price,$RRP,$st,$barcode);
                        $arr1[]=$tmp;
                        echo "<pre>";print_r($tmp);echo "</pre>";
                        fputcsv($handle, $tmp, ";");
                        break;
                    }
                }
            }
            fclose($handle);
        }

        /*if (is_array($arr)&&is_array($stocks))
        {
            //echo "yay!";
            $handle=fopen($this->pathAmirov, 'w+');
            $tmp=array('vendorCode','stock','price','name');
            fputcsv($handle, $tmp);
            foreach ($arr as $ar)
            {
                $id=$ar[0];
                $price=$ar[11];
                if ($price==null)
                {
                    $price=0;
                }
                $name=$ar[5];
                foreach ($stocks as $stock)
                {
                    if (strcmp($id,$stock[0])==0)
                    {
                        $st=$stock[1];
                        $tmp=array($id,$st,$price,$name);
                        $arr1[]=$tmp;
                        //echo "<pre>";print_r($tmp);echo "</pre>";
                        fputcsv($handle, $tmp);
                        break;
                    }
                }
            }
            fclose($handle);
        }*/
        
    }


    public function makeOther5 ()
    {
        
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                //echo "<pre>";print_r($data);echo "</pre>";
                if (intval($data[1])>5)
                {
                    $data[1]=">5";
                }
                $tmp=" ".$data[0];
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false)&&(strripos($tmp,"Попперс")==false)&&(strripos($tmp,"NT95304")==false))
                {
                    $stocks[]=$data;
                }
                //$stocks[]=$data;
            }
        }
        fclose($handle);
        //$stocks - массив вида артикул-остаток

        //читаємо штрихкода
        //$path = "36.xlsx";
        //$arrTmp=$this->readExelFile($path);
        $arrTmp=$this->xls;
        if (is_array($arrTmp))
        {
            foreach ($arrTmp as $elem)
            {
                $art=$elem[0];
                $barcode=$elem[66];
                $price5=$elem[13];
                $barcodes[]=array($art,$barcode,$price5);
                
            }
        }

        //поки не було 1с, остатки грузили з сайту
        /*$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        $path = "36.xlsx";
        file_put_contents($path, file_get_contents($url));
        chmod ($path,0777);
        $this->pathOrigAmurchik=$path;*/
        //$arr=$this->readExelFile($this->pathOrigAmurchik);
        //echo "<pre>";print_r($arr);echo "</pre>";
        /*if (is_array($this->xls))
        {
            //array_unshift($this->xls);
            foreach ($this->xls as $elem)
            {
                $art=$elem[0];
                $quantity=$elem[23];
                $price=$elem[16];
                $barcode=$elem[60];
                //echo "$price";
                //break;
                //echo "$quantity<br>";
                $tmp=" ".$art;
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false))
                {
                    if (strcmp($quantity,'Больше 5 шт.')==0)
                    {
                        $quantity=">5";
                    }
                    else
                    {
                       $quantity=preg_replace('~\W+~','', $quantity);
                        
                        if (strcmp($quantity,'')==0)
                        {
                            $quantity="0";
                        } 
                    }
                    //echo "$art $quantity<br>";
                    $stocks[]=array($art,$quantity,$price,$barcode);
                }
                
                
            }
        }*/

        $xml=$this->readFile();
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        //echo"<pre>";print_r($barcodes);echo"</pre>";
        
        if (is_array($items)&&is_array($stocks)&&is_array($barcodes))
        {
            $handle=fopen($this->pathOther5, 'w+');
            $tmp=array('vendorCode','name','price','РРЦ','price 5%','stock','barcode');
            fputcsv($handle, $tmp, ";");
            foreach ($items as $item)
            {
                $article=$this->getItemArticle($item);
                $name=$this->getItemName($item);
                $RRP=$this->getItemRRP($item);
                foreach ($barcodes as $bc) 
                {
                    // code...
                    $barcode=0;
                    //echo"<pre>";print_r($bc);echo"</pre>";
                    if (strcmp($article,$bc[0])==0)
                    {
                        $barcode=$bc[1];
                        $price5=$bc[2];
                        break;
                    }
                }

                foreach ($stocks as $stock)
                {
                    $stt=trim($stock[0]);
                    if (strcasecmp($article,$stt)==0)
                    {
                        $st=$stock[1];
                        $price=$stock[2];
                        //$barcode=$stock[3];
                        $tmp=array($article,$name,$price,$RRP,$price5,$st,$barcode);
                        $arr1[]=$tmp;
                        //echo "<pre>";print_r($tmp);echo "</pre>";
                        fputcsv($handle, $tmp, ";");
                        break;
                    }
                }
            }
            fclose($handle);
        }

        /*if (is_array($arr)&&is_array($stocks))
        {
            //echo "yay!";
            $handle=fopen($this->pathAmirov, 'w+');
            $tmp=array('vendorCode','stock','price','name');
            fputcsv($handle, $tmp);
            foreach ($arr as $ar)
            {
                $id=$ar[0];
                $price=$ar[11];
                if ($price==null)
                {
                    $price=0;
                }
                $name=$ar[5];
                foreach ($stocks as $stock)
                {
                    if (strcmp($id,$stock[0])==0)
                    {
                        $st=$stock[1];
                        $tmp=array($id,$st,$price,$name);
                        $arr1[]=$tmp;
                        //echo "<pre>";print_r($tmp);echo "</pre>";
                        fputcsv($handle, $tmp);
                        break;
                    }
                }
            }
            fclose($handle);
        }*/
        
    }

    public function makeAksenova()
    {
        //вантажимо залишки із файлу 1с
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                
                //echo "<pre>";print_r($data);echo "</pre>";

                if ($data[1]!=0)
                {
                    $data[1]=strstr($data[1], ',', true);
                }
                
                if (intval($data[1])>5)
                {
                    $data[1]=">5";
                }
                $tmp=" ".$data[0];
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false)&&(strripos($tmp,"Попперс")==false)&&(strripos($tmp,"NT95304")==false))
                {
                    $stocks[]=$data;
                }
                //$stocks[]=$data;
            }
        }
        fclose($handle);

        if (is_array($this->xls))
        {
            //пишем заголовок
            $handle=fopen($this->pathAksenova, 'w+');
            $tmp=array('barcode','purchase_price','ppc_price','stock','cont_ru','cont_uk','pic');
            fputcsv($handle, $tmp, ";");
            
            foreach ($this->xls as $pos)
            {
                $art=$pos[0];
                $barcode=$pos[66];
                $purchase_price=$pos[11];
                $ppc_price=$pos[20];
                $cont_ru=$pos[45];
                $cont_ru=preg_replace('/\s+/', ' ', $cont_ru);
                $cont_uk=$pos[46];
                $cont_uk=preg_replace('/\s+/', ' ', $cont_uk);
                $pic=$pos[25];
                $pic=str_ireplace(';',',',$pic);
                $pic = preg_replace('/\s+/', ' ', $pic); 


                foreach($stocks as $stock)
                {
                    if (strcmp($art,$stock[0])==0)
                    {
                        $st=$stock[1];
                        $tmp=array($barcode,$purchase_price,$ppc_price,$st,$cont_ru,$cont_uk,$pic);
                        $arr1[]=$tmp;
                        //echo "<pre>";print_r($tmp);echo "</pre>";
                        fputcsv($handle, $tmp, ";");
                        break;
                    }
                }
            }
            fclose($handle);
        }
        
    }

    public function makeOther10 ()
    {
        
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                //echo "<pre>";print_r($data);echo "</pre>";
                if (intval($data[1])>5)
                {
                    $data[1]=">5";
                }
                $tmp=" ".$data[0];
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false)&&(strripos($tmp,"Попперс")==false)&&(strripos($tmp,"NT95304")==false))
                {
                    $stocks[]=$data;
                }
                //$stocks[]=$data;
            }
        }
        fclose($handle);
        //$stocks - массив вида артикул-остаток

        //читаємо штрихкода
        /*$path = "36.xlsx";
        $arrTmp=$this->readExelFile($path);*/
        $arrTmp=$this->xls;
        if (is_array($arrTmp))
        {
            foreach ($arrTmp as $elem)
            {
                $art=$elem[0];
                $barcode=$elem[66];
                $price5=$elem[11];
                $barcodes[]=array($art,$barcode,$price5);
                
            }
        }

        //поки не було 1с, остатки грузили з сайту
        /*$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        $path = "36.xlsx";
        file_put_contents($path, file_get_contents($url));
        chmod ($path,0777);
        $this->pathOrigAmurchik=$path;*/
        //$arr=$this->readExelFile($this->pathOrigAmurchik);
        //echo "<pre>";print_r($arr);echo "</pre>";
        /*if (is_array($this->xls))
        {
            //array_unshift($arr);
            foreach ($this->xls as $elem)
            {
                $art=$elem[0];
                $quantity=$elem[23];
                $price=$elem[16];
                $barcode=$elem[60];
                //echo "$price";
                //break;
                //echo "$quantity<br>";
                $tmp=" ".$art;
                if ((strripos($tmp,"Тестер")==false)&&(strripos($tmp,"ТЕСТЕР")==false))
                {
                    if (strcmp($quantity,'Больше 5 шт.')==0)
                    {
                        $quantity=">5";
                    }
                    else
                    {
                       $quantity=preg_replace('~\W+~','', $quantity);
                        
                        if (strcmp($quantity,'')==0)
                        {
                            $quantity="0";
                        } 
                    }
                    //echo "$art $quantity<br>";
                    $stocks[]=array($art,$quantity,$price,$barcode);
                }
                
                
            }
        }*/

        $xml=$this->readFile();
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        //echo"<pre>";print_r($barcodes);echo"</pre>";
        
        if (is_array($items)&&is_array($stocks)&&is_array($barcodes))
        {
            $handle=fopen($this->pathOther10, 'w+');
            $tmp=array('vendorCode','name','price','РРЦ','price 10%','stock','barcode');
            fputcsv($handle, $tmp, ";");
            foreach ($items as $item)
            {
                $article=$this->getItemArticle($item);
                $name=$this->getItemName($item);
                $RRP=$this->getItemRRP($item);
                foreach ($barcodes as $bc) 
                {
                    // code...
                    $barcode=0;
                    //echo"<pre>";print_r($bc);echo"</pre>";
                    if (strcmp($article,$bc[0])==0)
                    {
                        $barcode=$bc[1];
                        $price10=$bc[2];
                        break;
                    }
                }

                foreach ($stocks as $stock)
                {
                    $stt=trim($stock[0]);
                    if (strcasecmp($article,$stt)==0)
                    {
                        $st=$stock[1];
                        $price=$stock[2];
                        //$barcode=$stock[3];
                        $tmp=array($article,$name,$price,$RRP,$price10,$st,$barcode);
                        $arr1[]=$tmp;
                        //echo "<pre>";print_r($tmp);echo "</pre>";
                        fputcsv($handle, $tmp, ";");
                        break;
                    }
                }
            }
            fclose($handle);
        }
        else
        {
            echo "no array!!<br/>";
        }

        /*if (is_array($arr)&&is_array($stocks))
        {
            //echo "yay!";
            $handle=fopen($this->pathAmirov, 'w+');
            $tmp=array('vendorCode','stock','price','name');
            fputcsv($handle, $tmp);
            foreach ($arr as $ar)
            {
                $id=$ar[0];
                $price=$ar[11];
                if ($price==null)
                {
                    $price=0;
                }
                $name=$ar[5];
                foreach ($stocks as $stock)
                {
                    if (strcmp($id,$stock[0])==0)
                    {
                        $st=$stock[1];
                        $tmp=array($id,$st,$price,$name);
                        $arr1[]=$tmp;
                        //echo "<pre>";print_r($tmp);echo "</pre>";
                        fputcsv($handle, $tmp);
                        break;
                    }
                }
            }
            fclose($handle);
        }*/
        
    }

    public function parseNasoloda()
    {
        //file_put_contents($this->pathAmurchik, '');
        //$arr=$this->readExelFile($this->pathOrigAmurchik);

        //$url = $this->pathOrigAmurchik;
        //$path = '/home/notaboo2/files.tonga.in.ua/www/36.xlsx';
        //$path = '36.xlsx';
        //file_put_contents($path, $this->file_get_contents_curl($url));
        //chmod ($path,0777);
        //$this->pathOrigAmurchik=$path;
        //$arr=$this->readExelFile($this->pathOrigAmurchik);

        //читаем файл с остатками (в переменной stocks будут лежать артикул и остаток)
        if (($handle = fopen($this->stockCSV, "r")) !== FALSE)    
        {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
            {
                //echo "<pre>";print_r($data);echo "</pre>";
                $quantity=$data;
                if ($data[1]>0)
                {
                    $data[1]="true";
                }
                else
                {
                    $data[1]="false";
                }
                $stocks[]=$data;
                $quantity_arr[]=$quantity;
            }
        }
        fclose($handle);


        $xml=$this->readFileUa();
        $xmlHead=$this->getXMLhead($xml);
        $xml_new=$this->stripHead($xml);
        $items=$this->getItemsArr($xml_new);
        if (is_array($items)&&is_array($this->xls))
        {
            foreach ($items as $item)
            {
                //var_dump ($item);
                //тягнемо актуальну наявнісить з файлу з 1с
                $art=$this->getItemArticle($item);
                //тимчасово не використовуємо 1с
                foreach ($stocks as $stock)
                {
                    if ($art==$stock[0])
                    {
                        $item=$this->setAviability($item,$stock[1]);
                        //$quantity=$stock[1];
                        break;
                    }
                }

                foreach ($quantity_arr as $q)
                {
                    if ($art==$q[0])
                    {
                        $quantity=$q[1];
                        if ($quantity>5)
                        {
                            $quantity=">5";
                        }
                    }
                }

                foreach ($this->xls as $arr)
                {
                    $art_ar=$arr[0];
                    if (strcasecmp($art,$art_ar)==0)
                    {
                        $barcode=$arr[66];
                        $rrc=$arr[19];
                        $price=$arr[14];
                        break;
                    }
                }

                $item=$this->setPriceNasoloda($item,$price);
                $item=$this->addBarcode($item,$barcode);
                $item=$this->addQuantity($item,$quantity);
                $name_ua=$this->getNameUkr($item);
                $descr_ua=$this->getDescrUkr($item);
                //echo "$name_ua<br>";
                $item=preg_replace("#<name><!\[CDATA\[(.*?)\]\]><\/name>#s","",$item);
                $item=preg_replace("#<name_ua><!\[CDATA\[(.*?)\]\]><\/name_ua>#s","<name><![CDATA[$name_ua]]></name>",$item);
                $item=preg_replace("#<description><!\[CDATA\[(.*?)\]\]><\/description>#s","",$item);
                $item=preg_replace("#<description_ua><!\[CDATA\[(.*?)\]\]><\/description_ua>#s","<description><![CDATA[$descr_ua]]></description>",$item);
                //полная выгрузка
                //$allItems.=$item.PHP_EOL;
                $catId=$this->getCatId($item);
                //видаляємо всі позиції виробника g-vibe
                $vendor=$this->getItemVendor($item);
                if ($catId==1197||strcasecmp($art,'NT95304')==0)//##
                {
                    $item='';
                }
                if ($catId!=1150)
                {
                    $allItems.=$item.PHP_EOL;
                }

               
                //var_dump ($item);
                
                //break;
            }
            ###
            $allItems=str_ireplace("<currencyId>USD</currencyId>","<currencyId>UAH</currencyId>",$allItems);
            //echo "<pre>";print_r($underwearItems);echo "</pre>";
            $allItems=$xmlHead.PHP_EOL."</categories>".PHP_EOL."<offers>".$allItems."</offers>".PHP_EOL."</shop>".PHP_EOL."</yml_catalog>";
            file_put_contents($this->pathNasoloda,$allItems);
            //вариант с available="" вместо available="false"
            
        }
    }

    private function setPriceNasoloda($item,$price)
    {
        $params=$this->getParams($item);
        $rrc="0";
        if (is_array($params))
        {
            foreach ($params as $param)
            {
                $paramName=$this->getParamName($param);
                if (strcmp($paramName,"РРЦ (грн)")==0)
                {
                    $rrc=$this->getParamVal($param);
                }
            }
        }
        $str="<price>$rrc</price>".PHP_EOL."<purchase_price>$price</purchase_price>";
        $item=preg_replace("#<price>(.*?)</price>#s",$str,$item);
        $item=preg_replace("#<param name=\"РРЦ \(грн\)\">(.*?)<\/param>#s","",$item);
        return $item;
    }

    private function addBarcode($item,$barcode)
    {   
        $st="</vendorCode>".PHP_EOL."<barcode>$barcode</barcode>";
        $item=str_ireplace("</vendorCode>",$st,$item);
        return $item;
    }

    private function addQuantity($item,$quantity)
    {   
        $st="</vendor>".PHP_EOL."<quantity>$quantity</quantity>";
        $item=str_ireplace("</vendor>",$st,$item);
        return $item;
    }





}
echo "<b>Start</b> ".date("Y-m-d H:i:s")."<br>";
set_time_limit (300000);
$test=new Tonga();//+
$test->parseXML();//+
//$test->parseXMLUk();//+
//$test->parseXML2lang();//+
$test->makeCSV();//нема наявності
//$test->makeCSVUkr();//
//$test->makeStock();
//$test->makeStockUkr();//+

/////////////////////////

$test->test1();
$test->makeCSV5();
$test->makeCSV10();
$test->parseXML2lang300();

$test->makeAmurchik();
$test->makeProgram4();
$test->parseNasoloda();
$test->makeAksenova();
$test->makeAmirov();
$test->makeOther();
$test->makeOther5();
$test->makeOther10();
$test->makeOtherUkr();//+

echo "<b>Done</b> ".date("Y-m-d H:i:s");