<?php
$factoryList=array("AMF","Poparada","BRW","Gerbor","Lisogor","Vika","Domini","SidiM","Come-for","Livs","Nova", "FunDesk", "Agat-M", "Oris", "Kidigo_1", "Kidigo_2");

function CreateSelect($factoryList,$name,$selectedVal="")
{
    $htmlString="<select name='$name'>";
    foreach ($factoryList as $factory)
    {
        if ($selectedVal=$factory)
        {
            $htmlString.="<option selected value='".$factory."'>".$factory."</option>";
        }
        else
        {
            $htmlString.="<option value='".$factory."'>".$factory."</option>";
        }
    }
    $htmlString.="</select>";
    return $htmlString;
}
?>

<html>
    <body>
        <form enctype="multipart/form-data" action="import.php" method="post">
            <input type="hidden" name="MAX_FILE_SIZE" value="200000000" />
            <table width="600">
                <tr>
                    <td>File:</td>
                    <td><input type="file" name="file"/></td>
                    <td>Factory:</td>
                    <td><?echo CreateSelect($factoryList,"factory"); ?></td>
                    <td><input type="submit" value="Upload"></td>
                </tr>
            </table>
        </form>
    </body>
</html>