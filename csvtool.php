<?php
error_reporting(E_ALL & ~E_NOTICE);
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CSV Tool</title>
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<body>

<h1>CSV Tool - v.1.0.3</h1>

<?php

if($_POST['send_form'] == 'yes')
{
    /*echo '<pre>';
    print_r($_FILES);
    echo '</pre>';*/
    
    /*
    Array
    (
        [file_with_csv] => Array
            (
                [name] => about.html
                [type] => text/html
                [tmp_name] => C:\xampp\tmp\phpDF39.tmp
                [error] => 0
                [size] => 27481
            )
    
    )
    */

    $IsError = false;
    
    if($_POST['separator_char'] == "")
    {
        echo '<div style="color: #600000;">No sign of record division.</div>';
        $IsError = true;
    }
    
    if(strlen($_POST['separator_char']) != 1)
    {
        echo '<div style="color: #600000;">Only one division character can be used.</div>';
        $IsError = true;
    }
     
    if($_POST['separator_char'] != "")
    {
        $SeparatorValue = $_POST['separator_char'];
    }
    
    if($_FILES['file_with_csv']['name'] == "")
    {
        echo '<div style="color: #600000;">No file has been uploaded.</div>';
        $IsError = true;
    }
    else
    {
        if($_FILES['file_with_csv']['type'] == "application/vnd.ms-excel" OR
        $_FILES['file_with_csv']['type'] == "text/csv" OR
        $_FILES['file_with_csv']['type'] == "text/plain" OR
        $_FILES['file_with_csv']['type'] == "text/x-csv"
        )
        {
            
        }
        else
        {
            echo '<div style="color: #600000;">The file has an incorrect header.</div>';
            $IsError = true;
        }
    }

    if(!$IsError)
    {
        $ToOutputFile = '<table>';
        
        $ReadyRows = file($_FILES['file_with_csv']['tmp_name']);
        
        for($i=0;$i<count($ReadyRows);$i++)
        {
            $ToOutputFile .= '<tr>';
            
            $ReadyOneRow = explode($_POST['separator_char'], $ReadyRows[$i]);
            
            for($z=0;$z<count($ReadyOneRow);$z++)
            {
                $ToOutputFile .= '<td>'.$ReadyOneRow[$z].'</td>';
            }
            
            $ToOutputFile .= '</tr>';
        }
        
        $ToOutputFile .= '</table>';
        
        file_put_contents('data.html', $ToOutputFile);
        
        echo '<a href="data.html" style="color: #ff0000;">Download the generated file</a><br />';
    }
    
    echo '<br />';
}

if($SeparatorValue == "")
{
    $SeparatorValue = ';';
}
?>

<form method="post" action="csvtool.php" enctype="multipart/form-data">
File:
<ul>
<li>Each line should contain a separate line</li>
<li>Each row should contain the same number of columns</li>
<li>The file will be converted into a table using the &lt;table&gt; tag.</li>
</ul>

File (only file<strong>.csv</strong>):<br />
<input type="file" name="file_with_csv" /><br />
<br />
Separator:<br />
<input type="text" name="separator_char" value="<?php echo $SeparatorValue; ?>" /><br />
<br />
<input type="hidden" name="send_form" value="yes" />
<input type="submit" value="Send file to program" />
</form>

</body>
</html>