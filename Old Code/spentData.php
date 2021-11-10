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
    $sort = filter_input(INPUT_POST,'sort');
    $dollar = filter_input(INPUT_POST,'dollar');
    if($sort&&$dollar)
    {
      echo '<!DOCTYPE html>
          <html>
          <head>
          <style>
          table, th, td {
            border: 1px solid black;
          }
          </style>
          </head>
          <body>';
      //echo $sort.$dollar;
      if($sort == "More")
      {
        $select = "select * from totalpercustomer where total >".$dollar;
        //echo $select;
      }
      else {
        $select = "select * from totalpercustomer where total <".$dollar;
        //echo $select;
      }
      echo'<table style="width:50%">
            <tr>
            <th>User Email</th>
            <th>Amount Spent</th>
            </tr>';
      $rs = $conn->prepare($select);
      $rs->execute();
      $users = $rs->fetchALL(PDO::FETCH_ASSOC);
      foreach($users as $user)
      {
        $select2 = "select Email from account where PhoneNum ='".$user['phoneNum']."'";
        $rs = $conn->prepare($select2);
        $rs->execute();
        $users2 = $rs->fetchALL(PDO::FETCH_ASSOC);
        foreach($users2 as $user2)
        {
          echo"<tr><td>".$user2['Email'].'</td>';
        }
        echo '<td> $'.number_format($user['total'],2).'</td></tr>';
      }
      echo '</table>';

      }
      else{
        echo "<p>One or more parameters is/are missing</p>";
      }

      echo'
          <form action="spent.html">
          <input type="submit" value="Go Back" />
          </form>

        </body>
        </html>';
  }
?>
