<?php 

/**
 * Скрипт для изменений фоток галереи (для конкретного товара)
 * параметр ID обязательный
 */
header('Content-type: text/html; charset=UTF-8');
//require 'autoload.php';
ini_set('display_errors', 1);
ini_set('max_execution_time', 720000);

define ("host","localhost");
define ("user", "u_ddnPZS");
define ("pass", "A8mnsoHf");
define ("db", "ddnPZS");

class Cloth

{
    private function delCloth($cloth_id)
	{
        $db_connect=mysqli_connect(host,user,pass,db);
        //удаляем ткань
		$query="DELETE FROM cloth WHERE cloth_id=$cloth_id";
		//echo "$query<br>";
        mysqli_query($db_connect,$query);
        //удаляем файлы
        $query="DELETE FROM clothfile WHERE cloth_id=$cloth_id";
		//echo "$query<br>";
        mysqli_query($db_connect,$query);
        //удаляем связанные категории
        $query="DELETE FROM clothhastissue WHERE cloth_id=$cloth_id";
		//echo "$query<br>";
        mysqli_query($db_connect,$query);
        //удаляем связанные языки
        $query="DELETE FROM clothhaslang WHERE cloth_id=$cloth_id";
		//echo "$query<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
    }

    private function getClothes()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT cloth_id, clothtype_id  from cloth";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$cloth_all[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        return $cloth_all;
    }

    private function getFiles($clothId)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT clothfile_id,clothfile_filename, clothfile_ext from clothfile where cloth_id=$clothId";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$cloth_all[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        return $cloth_all;
    }

    private function getMainColor($file)
    {
        // Файл для определения основного цвета
        $im=ImageCreateFromJPEG($file);
        
        $total_R=0;
        $total_G=0;
        $total_B=0;
        
        // Размеры изображения
        $width=ImageSX($im);
        $height=ImageSY($im);
        
        // Подсчитать суммарные значения по RGB
        for ($x=0; $x<$width; $x++) {
            for ($y=0; $y<$height; $y++) {
                $rgb=ImageColorAt($im,$x,$y);
                $total_R+=($rgb>>16) & 0xFF;
                $total_G+=($rgb>>8) & 0xFF;
                $total_B+=$rgb & 0xFF;
            }
        }
        
        // Прибраться за собой
        ImageDestroy($im);
        
        // Определение значений RGB основного цвета
        $avg_R=round($total_R/$width/$height);
        $avg_G=round($total_G/$width/$height);
        $avg_B=round($total_B/$width/$height);
        echo "$avg_R-$avg_G-$avg_B<br>";
        //делаем временное изображение
        //$im = imagecreate (10, 10) 
        //    or die ("Ошибка при создании изображения");  

        //$background = imagecolorallocate ($im, $avg_R, $avg_G, $avg_B); 
        //imagetruecolortopalette($im, false, 255);
        $colors = array(
            array(255, 0, 0),
            array(255, 102, 0),
            array(255, 153, 0),
            array(255, 204, 0),
            array(255, 255, 0),
            array(204, 255, 0),
            array(153, 255, 0),
            array(0, 255, 102),
            array(0, 255, 153),
            array(0, 255, 204),
            array(0, 204, 255),
            array(0, 153, 255),
            array(0, 102, 255),
            array(102, 0, 255),
            array(153, 0, 255),
            array(204, 0, 255),
            array(255, 0, 204),
            array(255, 0, 153),
            array(255, 0, 102),
            array(255, 0, 102),
            array(255, 255, 255),
            array(51, 51, 51),
            array(102, 102, 102),
            array(153, 153, 153),
            array(204, 204, 204),
            array(0, 0, 0),
            array(102, 51, 0),
            array(229, 114, 172),
            array(189, 121, 60),
            array(72, 159, 78),
            array(228, 178, 99),
            array(160, 11, 60),
            array(136, 156, 103),
            array(59, 34, 9),
            array(129, 12, 15),
            array(206, 40, 44)
        );
        //$i=0;
        unset ($fi);
        foreach($colors as $id => $rgb)
        {
            //$result = imagecolorclosest($im, $rgb[0], $rgb[1], $rgb[2]);
            //$result = imagecolorsforindex($im, $result);
            //$result = imagecolorsforindex($result,$im);
            //$result = "({$result['red']}, {$result['green']}, {$result['blue']})";

            //echo "#$id: Search ($rgb[0], $rgb[1], $rgb[2]); Closest match: $result.\n<br>";
            $fi[]=30*($rgb[0]-$avg_R)*($rgb[0]-$avg_R)+59*($rgb[1]-$avg_G)*($rgb[1]-$avg_G)+11*($rgb[2]-$avg_B)*($rgb[2]-$avg_B);
            //$fi[]=($rgb[0]-$avg_R)*($rgb[0]-$avg_R)+($rgb[1]-$avg_G)*($rgb[1]-$avg_G)+($rgb[2]-$avg_B)*($rgb[2]-$avg_B);
            //echo "$fi<br>";

            //$i++;

        }
        //var_dump($fi);
        //echo "<br>".min($fi)."<br>";
        //echo min($fi).'<br>';
        $num1=array_search(min($fi),$fi);
        //echo $num1."<br>";
        $color=$colors[$num1];
        print_r ($color);
        echo "<br>";
        //echo "<p style='color:#'".dechex($color[0]).dechex($color[1]).dechex($color[2]).">";
        //echo "Test";
        //echo "</p><br>";
        
        unset($fi[$num1]);
        //var_dump($fi);
        //echo "<br>".min($fi)."<br>";
        //echo min($fi).'<br>';
        $num2=array_search(min($fi),$fi);
        //echo $num2."<br>";
        $color=$colors[$num2];
        print_r ($color);
        //echo "<p style='color:#'".dechex($color[0]).dechex($color[1]).dechex($color[2]).">";
        //echo "Test";
        //echo "</p><br>";
        //*/
        
        /*
        $R=($avg_R/255);
        $G=($avg_G/255);
        $B=($avg_B/255);
        
        $maxRGB=max(array($R, $G, $B));
        $minRGB=min(array($R, $G, $B));
        $delta=$maxRGB-$minRGB;
        
        // Цветовой тон
        if ($delta!=0) 
        {
            if ($maxRGB==$R) 
            {
                $h=(($G-$B)/$delta);
            }
            elseif ($maxRGB==$G) 
            {
                $h=2+($B-$R)/$delta;
            }
            elseif ($maxRGB==$B) 
            {
                $h=4+($R-$G)/$delta;
            }
            $hue=round($h*60);
            if ($hue<0) 
            { 
                $hue+=360; 
            }
        }
        else 
        {
            $hue=0;
        }
        
        // Насыщенность
        if ($maxRGB!=0) 
        {
            $saturation=round($delta/$maxRGB*100);
        }
        else 
        {
            $saturation=0;
        }
        
        // Яркость
        $value=round($maxRGB*100);
        echo "$hue-$saturation-$value<br>";
        // Яркость меньше 30%
        if ($value<30) 
        {
            // Черный
            $color='#000000 Черный';
        }
        
        // Яркость больше 85% и насыщенность меньше 15%
        elseif ($value>85 && $saturation<15) 
        {
            // Белый
            $color='#FFFFFF Белый';
        }
        // Насыщенность меньше 25%
        elseif ($saturation<25) 
        {
            // Серый
            $color='#909090 Серый';
        }
        // Определить цвет по цветовому тону
        else 
        {
            // Красный
            if ($hue>320 || $hue<=40) 
            {
                $color='#FF0000 Красный';
            }
            // Розовый
            elseif ($hue>260 && $hue<=320) 
            {
                $color='#FF00FF Розовый';
            }
            // Синий
            elseif ($hue>190 && $hue<=260) 
            {
                $color='#0000FF Синий';
            }
            // Голубой
            elseif ($hue>175 && $hue<=190) 
            {
                $color='#00FFFF Голубой';
            }
            // Зеленый
            elseif ($hue>70 && $hue<=175) 
            {
                $color='#00FF00 Зеленый';
            }
            // Желтый
            else 
            {
                $color='#FFFF00 Желтый';
            }
        }
        return $color;
        */

        
        switch ($num1)
        {
            case 0:
                $return[1]=1;
            break;
            case 1:
                $return[1]= 3;
            break;
            case 2:
                $return[1]= 4;
            break;
            case 3:
                $return[1]= 5;
            break;
            case 4:
                $return[1]= 6;
            break;
            case 5:
                $return[1]= 7;
            break;
            case 6:
                $return[1]= 8;
            break;
            case 7:
                $return[1]= 13;
            break;
            case 8:
                $return[1]= 14;
            break;
            case 9:
                $return[1]= 15;
            break;
            case 10:
                $return[1]= 17;
            break;
            case 11:
                $return[1]= 18;
            break;
            case 12:
                $return[1]= 19;
            break;
            case 13:
                $return[1]= 23;
            break;
            case 14:
                $return[1]= 24;
            break;
            case 15:
                $return[1]= 25;
            break;
            case 16:
                $return[1]= 27;
            break;
            case 17:
                $return[1]= 29;
            break;
            case 18:
                $return[1]= 32;
            break;
            case 19:
                $return[1]= 33;
            break;
            case 20:
                $return[1]= 34;
            break;
            case 21:
                $return[1]= 35;
            break;
            case 22:
                $return[1]= 36;
            break;
            case 23:
                $return[1]= 37;
            break;
            case 24:
                $return[1]= 38;
            break;
            case 25:
                $return[1]= 42;
            break;
            case 26:
                $return[1]= 43;
            break;
            case 27:
                $return[1]= 46;
            break;
            case 28:
                $return[1]= 47;
            break;
            case 29:
                $return[1]= 48;
            break;
            case 30:
                $return[1]= 51;
            break;
            case 31:
                $return[1]= 52;
            break;
            case 32:
                $return[1]= 53;
            break;
            case 33:
                $return[1]= 54;
            break;
        }
        switch ($num2)
        {
            case 0:
                $return[2]=1;
            break;
            case 1:
                $return[2]= 3;
            break;
            case 2:
                $return[2]= 4;
            break;
            case 3:
                $return[2]= 5;
            break;
            case 4:
                $return[2]= 6;
            break;
            case 5:
                $return[2]= 7;
            break;
            case 6:
                $return[2]= 8;
            break;
            case 7:
                $return[2]= 13;
            break;
            case 8:
                $return[2]= 14;
            break;
            case 9:
                $return[2]= 15;
            break;
            case 10:
                $return[2]= 17;
            break;
            case 11:
                $return[2]= 18;
            break;
            case 12:
                $return[2]= 19;
            break;
            case 13:
                $return[2]= 23;
            break;
            case 14:
                $return[2]= 24;
            break;
            case 15:
                $return[2]= 25;
            break;
            case 16:
                $return[2]= 27;
            break;
            case 17:
                $return[2]= 29;
            break;
            case 18:
                $return[2]= 32;
            break;
            case 19:
                $return[2]= 33;
            break;
            case 20:
                $return[2]= 34;
            break;
            case 21:
                $return[2]= 35;
            break;
            case 22:
                $return[2]= 36;
            break;
            case 23:
                $return[2]= 37;
            break;
            case 24:
                $return[2]= 38;
            break;
            case 25:
                $return[2]= 42;
            break;
            case 26:
                $return[2]= 43;
            break;
            case 27:
                $return[2]= 46;
            break;
            case 28:
                $return[2]= 47;
            break;
            case 29:
                $return[2]= 48;
            break;
            case 30:
                $return[2]= 51;
            break;
            case 31:
                $return[2]= 52;
            break;
            case 32:
                $return[2]= 53;
            break;
            case 33:
                $return[2]= 54;
            break;
        }

        return $return;
        
    }

    private function writeColors($fileId,$colors)
    {
        //сначала удаляем все старые записи
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="DELETE FROM clothfilehasclothcolor WHERE clothfile_id=$fileId";
        echo "$query<br>";
        //mysqli_query($db_connect,$query);
        //потом записываем новые
        foreach ($colors as $color)
        {
            $query="INSERT INTO clothfilehasclothcolor (clothfile_id,clothcolor_id) VALUES ($fileId,$color)";
            echo "$query<br>";
            //mysqli_query($db_connect,$query);
        }
        mysqli_close($db_connect);
      
    }

    public function getColor()
    {
        if (!isset($_REQUEST['id'])) 
        {
            echo 'not found start ID';
            die();
        }
        $clothId=$_REQUEST['id'];
        $files=$this->getFiles($clothId);
        //var_dump ($files);
        //echo "<pre>";
        //print_r ($files);
        //echo "</pre>";
        foreach ($files as $file)
        {
            $namePrev="https://ddn.ua/foto/cloth/".$clothId."/preview_".$file['clothfile_id'].".".$file['clothfile_ext'];
            echo "$namePrev<br>";
            $name="https://ddn.ua/foto/cloth/".$clothId."/".$file['clothfile_filename']."_".$file['clothfile_id'].".".$file['clothfile_ext'];
            //$color=$this->getMainColor($name);
            $color=$this->getMainColor($name);
            //echo "clothcolor_id=$color<br>";
            echo '<div><img style="margin-bottom:10px;" src="'.$namePrev.'"></div>';
            //echo '<div><img style="margin-bottom:10px;" src="'.$name.'"></div>';
            //echo '<div><img style="margin-bottom:10px;" src="'.$file->getRealPathSeoPreview('list','desc-sm').'"></div>';
            $this->writeColors($file['clothfile_id'],$color);
            //break;
        }
    }

    public function test()
    {
        $clothes=$this->getClothes();
        //var_dump ($clothes);
        $currentType=1;
        $count=0;
        foreach ($clothes as $cloth)
        {
            $id=$cloth['cloth_id'];
            $type=$cloth['clothtype_id'];
            if ($type==$currentType)
            {
                echo "<pre>";
                print_r($cloth);
                echo "/<pre>";
                //var_dump ($cloth);
                //$count++;
                $currentType++;
            }
            else
            {
                $this->delCloth($id);
            }
            if ($currentType==16)
            {
                $currentType=17;
            }
            if ($currentType==20)
            {
                $currentType=22;
            }
            
        }
    }
    

}

$test = new Cloth();
//$test->test();
$test->getColor();
