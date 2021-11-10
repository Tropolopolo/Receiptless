<?php
  $host = "localhost";
  $dbusername = "root";
  $dbpassword = "";
  $dbname = "receiptless_database";
  $conn = new PDO('mysql:host='.$host.';dbname='.$dbname,$dbusername,$dbpassword);
  $myfile = fopen("Results.txt","w");
  $str = "";
  if(!$conn)
  {
    die("Connection failed");
  }
  else
  {
    $current = filter_input(INPUT_POST,'emailC');
    $new = filter_input(INPUT_POST,'emailNew');
    $phone = filter_input(INPUT_POST,'newPhone');
    $type = filter_input(INPUT_POST,'type');
    if(!$current)
    {
      $str.= "<div class='grid-item'>No email entered!</div>";
    }
    else
    {
      if($new)
      {
        $update = "Update account Set Email='".$new."' Where Email = '\".$current.\"'";
        $update2 = "Update person Set Email='".$new."' Where Email = '\".$current.\"'";
        //$str.= $update.$update2;
        if($conn->query($update)&&$conn->query($update2))
        {
          $str.= "<div class='grid-item'>Email address Updated.</div>" ;
        }
      }
	  
      if($phone)
      {
        if($new)
        {
          $select = "select PhoneNum from account where Email='".$new."'";
        }
        else {
          $select = "select PhoneNum from account where Email='".$current."'";
        }
        $rs = $conn->prepare($select);
        $rs->execute();
        $phoneNum = $rs->fetchALL(PDO::FETCH_ASSOC);
		$userNum = "";
        foreach($phoneNum as $num)
        {
          $userNum = $num['PhoneNum'];
        }
        $update = "Update account Set PhoneNum='\"$phone\"' Where PhoneNum = '\"$userNum\";'";
        $update2 = "Update receipt Set PhoneNum='\"$phone\"' Where PhoneNum = '\"$userNum\";'";
        //echo $update.$update2;
        if($conn->query($update)&&$conn->query($update2))
        {
          $str.= "<div class='grid-item'>Phone Number updated in Account and will reflect in ReceiptData.</div>" ;
        }
      }
	  
      if($type)
      {
        if($new)
        {
          $update = "Update account Set AccType='".$type."' Where Email = '".$new."'";
        }
        else {
          $update = "Update account Set AccType='".$type."' Where Email = '".$current."'";
        }
        //echo$update;
        if($conn->query($update))
        {
          $str.= "<div class='grid-item'>Account Type updated.</div>" ;
        }
      }

    }
		
	fwrite($myfile, $str);
	fclose($myfile);
  }
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Display Receipt Data</title>
	</head>
	
	<style>
        table, th, td {
			border: 1px solid black;
        }
	  
		h1 {font-weight: bold; font-size: 150%;}
		p {text-align: center;}
		.Body{
			background-color: steelblue;
		}
		
		.grid-item{
			transition-duration: 1.0s;
			background-color: hsl(180, 70%, 80%);
			font-size: inherit;
			align-content: left;
			border: solid white;
			border-radius: 4px;
			margin: 4px;
		}
		
		.grid-item:hover{
			background-color: lightcyan;
			border: solid mediumturquoise;
		}
		
		.grid-container{
			display: inline-grid;
			grid-gap: 10px;
			width: 100%;

		}
		
		.btn {
			transition-duration: 0.5s;
			background-color: hsla(0,0%,0%,0);
			border: white;
			border-width: 2px;
			width: 100%;
			height: 100%;
			font-weight: bold;
			font-size: 150%;
			text-align: center;
		}
		
		.btn:hover{
			background-color: lightcyan;
			font-size: 200%;
		}
		
		.subbtn {
			transition-duration: 0.5s;
			background-color: lightblue;
			border: white;
			border-width: 2px;
			width: 20%;
			height: 100%;
			font-weight: bold;
			font-size: 100%;
			text-align: center;
			border: solid mediumturquoise;
			margin-top: 4px;
		}
		
		.form{
			font-size: 200%;
			font-weight: bold;
		}
		
		.textbox {
		transition-duration: 0.5s;
			width: 200px;
			border-radius: 4px;
			border: solid mediumturquoise;
		}
		
		input[type=text]{
			color: black;
			background-color: lightblue;
		}
		
		input[type=text]:focus{
			font-size: 150%;
			width: 50%;
		}
		
		.fldset{
			border: solid mediumturquoise; 
		}
		
	</style>
	
	<script>
		function changeValue(id, str)
			{
				document.getElementById(id).value = str;
			}
	</script>
	
	<body class="Body">
		<div class="grid-container">
			<div class="grid-item">
				<a href="update.html">
					<input id="back" type="button" class="btn" value="Go Back" onmouseover="changeValue(\'back\', \'Click here to Go Back\')" onmouseleave="changeValue(\'back\', \'Go Back\')"/>
				</a>
			</div>
			<div class="grid-item"><h1>Result:</h1><br><div class="grid-container"><?php include('Results.txt'); ?></div></div>
		</div>
		
		
	</body>
</html>
