<?php
  $host = "localhost";
  $dbusername = "root";
  $dbpassword = "";
  $dbname = "phase3";
  $conn = new PDO('mysql:host='.$host.';dbname='.$dbname,$dbusername,$dbpassword);

  if(!$conn)
  {
    die("Connection failed");
  }
  else
  {
    $listId = filter_input(INPUT_POST,'listId');
    echo '<!DOCTYPE html>
        <html>
        <body>';

    if($listId)
    {
      $delete = "Delete From receiptdata where listId ='".$listId."'";
      $delete2 = "Delete From item where itemList ='".$listId."'";
      //echo $delete.$delete2;
      if($conn->query($delete)&&$conn->query($delete2))
      {
        echo "<p>Receipt Removed.</p>" ;
      }
    }
    else {
      echo "Please enter a Receipt ID.";
    }
    echo'<form action="delete.html">
        <input type="submit" value="Go Back" />
        </form>

        </body>
        </html>';
  }
