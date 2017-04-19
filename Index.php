<?php

//session_start();

if(!isset($_SESSION["session_username"]))
{
 header("location:login.php");
 }
 else
 {
 //header("Location: intropage.php");
 }
?>


<?php
if(isset($_COOKIE["DATE"]))
{
  $date = $_COOKIE["DATE"];
}
else
{
 setcookie ("DATE",date("Y-m-d")); 
 $date = $_COOKIE["DATE"];
 //header("Location: index.php");
 header("Location: intropage.php");
} 
?>

<html>
<title>Запись на СТО</title>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="tcal.css" />
	<script type="text/javascript" src="tcal.js"></script> 
</head>
<body bgcolor="#FDE297">
<div class  = "head">
</div>
<div class  = "content">


<form method = "POST">
 <input type="label" name="Text"  value = "Выберите рабочую дату" /><br/>
 <input type="text" name="My_Date" class="tcal"  value = <?php echo $date; ?> />
 <input type="submit" name = "Select_date" value = "Обновить"/>
</form>


<br/>
<br/>
<?php 

 Load_DB();
?>

<br/>
<form  name="form" method="POST" action = "Send_Data.php">
<table>
	<tr>
		<td>
		<p>Дата проведения работ :	</p>
		</td>
		<td>
		<p>Пост:<font color="#FF0000">*</font></p>
		</td>
		<td>
		<p>Время<font color="#FF0000">*</font></p>
		</td>
	</tr>
	<tr>
		<td>
		<form method = "post">
			<input required = true type="text" name="My_Date_2" class="tcal"  value = "" />
		</form>		
		</td>
		<td>
<select required name="Select2" wight ="22" size="1" title="Время проведения работ"
		style="HEIGHT: 22px; WIDTH: 200px"  >
		<option></option>
		<OPTION value="1">1</OPTION>
		<OPTION value="2">2</OPTION>
		<OPTION value="3">3</OPTION>
</select>
		</td>
		<td>
<select required name="Select1" wight ="22" size="1" title="Начало проведения работ"
		style="HEIGHT: 22px; WIDTH: 200px"  >
		<option></option>
		<OPTION value="09:00">09:00</OPTION>
		<OPTION value="10:00">10:00</OPTION>
		<OPTION value="11:00">11:00</OPTION>
		<OPTION value="12:00">12:00</OPTION>
		<OPTION value="13:00">13:00</OPTION>
		<OPTION value="14:00">14:00</OPTION>
		<OPTION value="15:00">15:00</OPTION>
		<OPTION value="16:00">16:00</OPTION>
		<OPTION value="17:00">17:00</OPTION>
		<OPTION value="18:00">18:00</OPTION>
</select>
		</td>	
	</tr>
</table>

  <p>Марка автомобиля<font color="#FF0000" >*</font></p>
	<input required = true type='text' name='u_name' size='20'  WIDTH =200px/>
  <input type="reset" name="Reset" value="Очистить"> <input type="submit" name="button1" value="Добавить запись" /> <input type="submit" name="del_but" value="Удалить запись" />
  </form>

</div>
<div class  = "footer">
</div>
</body>
</html>

<?php  // вывод текста на главной странице	 
function Load_DB()
{	
    if (isset($_POST['Select_date']))
    {
     setcookie("DATE", "");
     setcookie("DATE", $_POST['My_Date']);  
     //header("Location: index.php");
	 header("Location: intropage.php");
    }
		$date = $_COOKIE['DATE'];	
	
		require_once("Includes/connection.php");
		
		@mysql_connect($sdd_db_host,$sdd_db_user,$sdd_db_pass); // коннект с сервером бд
		@mysql_select_db($sdd_db_name); // выбор бд
		@mysql_query('SET names "utf8"');      //where Date = "2017-04-11"              //$date
		$result=mysql_query("SELECT Time, Post, Car_Name FROM `zapis` where Date = '$date' order by  Time, Post"); // запрос на выборку
		$table = "<table width = 100% cellspacing='1' cellpadding='1' border='1' align = 'left'>";
		$MyArr = array();
		$Car_Arr = array();
		$Time_arr = array("09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00");
		$Post_arr = array("1","2","3");
		$table .= "<tr>\n";
		$table .= "<th  height='40' align = 'center'>Время</th>\n";	
		$table .= "<th  align = 'center' width = 30%>ПОСТ I</th>\n";
		$table .= "<th  align = 'center' width = 30%>ПОСТ II</th>\n";
		$table .= "<th  align = 'center' width = 30%>ПОСТ III</th>\n";
		$table .= "</tr>\n";
		if($result!=0)
		{
		 while($row=mysql_fetch_array($result))
		 {
		  array_push($MyArr, $row[0],$row[1], $row[2]);
		 }
		} 
	// формируем массив записи на сервис
	if(count($MyArr)>0 )
	{
	$k = 0;	
	for($p=0; $p<10; $p++)
	{
	for($i=0; $i<3; $i++)
	{
	 if($MyArr[$k] == $Time_arr[$p])
	 {
	  if($MyArr[$k+1] == $Post_arr[$i])
	  {
	    array_push($Car_Arr,$MyArr[$k+2]);
		$k+=3;
	  }
	   else
	  {
	   array_push($Car_Arr,"&nbsp;");
	   array_push($MyArr,"");	   
	  }
	 }
	 else
	  {
	   array_push($Car_Arr,"&nbsp;");
	   array_push($MyArr,"");	   
	  }
	}
	}
   }


// рисуем таблицу записи на сто	
	$l = 0;
	 $table .= "<th height='40' align = 'center' > $Time_arr[$l]</th>";
		for($i = 0,$k=0; $i < count($Car_Arr); $i ++)
		{	
			if($k != 3)
			 {
			   $k++;
			   $table .= "<td height='40' align = 'center' class='CLICK' value = $i>$Car_Arr[$i]</td>";
			 }
			else
			{
			 $k = 1; 
			 $l++;
			 $table .= "</tr>";
			 $table .= "<tr>";
			 $table .= "<th height='40' align = 'center'>$Time_arr[$l]</th>";
			 $table .= "<td height='40' align = 'center' class='CLICK' value = $i>$Car_Arr[$i]</td>";
			}
		}
		$table .= "</tr>";
		$table .= "</table> ";
	 echo $table;
}	 
?>