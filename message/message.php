<?php
include('mydb.php');
include('style.html'); 

if ($_GET['account'])
{$_SESSION['account']=$_GET['account'];
$_SESSION['password']=$_GET['password'];
}
$sql="select * from member where account='$_SESSION[account]' and password='$_SESSION[password]'";

$result=mysqli_query($conn, $sql);//执行某个针对数据库的查询。
if (!$row=mysqli_fetch_array($result))//从结果集中取得一行作为关联数组，或数字数组，或二者兼有。
{
    echo '<div class="content"> ';
    echo 'login failured<br>';
    echo "<a href =index.php>back to the login page</a>";
    die();
}
if ($_GET['account']=='root')
{   $_SESSION['flag']='1';
    header('location:manage.php');}
// if ($_GET['del'])
// {
//     $a=$_GET['del'];
//     $s="delete from member where no=$a";
// }

?>

<!-- mysqli_query($con,"SELECT * FROM websites");
mysqli_query($con,"INSERT INTO websites (name, url, alexa, country)
VALUES ('百度','https://www.baidu.com/','4','CN')"); -->
<!-- mysqli_fetch_array(result,resulttype);
mysqli_fetch_array() 函数从结果集中取得一行作为关联数组，或数字数组，或二者兼有。
resulttype	可选。规定应该产生哪种类型的数组。可以是以下值中的一个：
MYSQLI_ASSOC
MYSQLI_NUM
MYSQLI_BOTH -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>message</title>
</head>
<body>
     <div class="flex-center position-ref half-height "> 
                <div class="top-right home"> 
                        <a href="message.php?account=$_GET['account']">Message</a> 
                        <a href="index.php">Logout</a> 
                        <a href="modifymember.php">modify message</a> 
                </div>
            </div>  
    <?php 
    echo '<div class="content"> ';
    //echo '<div class="m-b-md">'; 
    echo "How are you? " . $row['account'] . '<br>Please,Leave the message';
    echo "<br>";
   
    
    //$_SESSION['no']=$row[0];
    //echo 'session:'.$_SESSION['no'];
   
    ?>
    <br>
    <div class='content'>
    <form name="form2" method="post" action="addmessage.php">
    <p>message content:</p>
    <textarea name="message" rows="10" cols="60"></textarea>
    <input type="hidden" name="no" value=<?php echo "$row[no]";?>>
    <br>
    <input type="submit"  vlaue="send">
    <input type="reset" value="rewrite"></form>
</div>     
    <?php
    $sql="SELECT m1.id,m1.content,m2.name,m1.mdate FROM message m1 join member m2 on m1.name=m2.no where m2.no='$row[no]'";
    $result=mysqli_query($conn,$sql);
    echo '<br>You have totally'.mysqli_num_rows($result).'members';

    if ($_GET['account'])
    {   
        echo "<table width=70% border=2 align=center cellpadding=0 cellspacing=0 >";
        echo "<tr bgcolor=#004466 style='color:#FFFFFF' align=center font-weight:600 >
            <td >message number</td>
            <td >message content</td>
            <td>message member</td>
            <td>message date</td>
            <td>del</td>
            </tr>";}
    while ($row=mysqli_fetch_array($result))
    {
        echo "<tr bgcolor=#FFA500 class='form2'>
        <td>$row[0]</td>
        <td>$row[1]</td>
        <td>$row[2]</td>
        <td>$row[3]</td>
        <td><a href=managemember.php?del=$row[0]>delete</a></td>
        </tr>";
    }    
    echo "</table>";
    ?>
</body>
</html>