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
    $email = filter_input(INPUT_POST,'email');
    if($email)
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


          $select = "select PhoneNum from account where Email='".$email."'";
          $rs = $conn->prepare($select);
          $rs->execute();
          $phoneNum = $rs->fetchALL(PDO::FETCH_ASSOC);
          foreach($phoneNum as $num)
          {
            $userNum = $num['PhoneNum'];
          }
          
          $query = "select * from receiptdata Where PhoneNum='".$userNum."'";
          $rs = $conn->prepare($query);
          $rs->execute();
          $entry = $rs->fetchALL(PDO::FETCH_ASSOC);
          if($entry)
          {
            echo '<table style="width:50%">
                  <tr>
                  <th>Store Name</th>
                  <th>Phone Number</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Total</th>
                  <th>    Reciept ID    </th>
                  </tr>';
            foreach($entry as $row)
            {
              echo '<tr><td>'.$row['StoreName'].'</td>';
              echo '<td>'.$row['PhoneNum'].'</td>';
              echo '<td>'.$row['RDate'].'</td>';
              echo '<td>'.$row['Rtime'].'</td>';
              echo '<td>'.$row['Total'].'</td>';
              echo '<td>'.$row['ListId'].'</td></tr>';
            }
            echo '</table>';
          }
          else {
            echo"No results Found\n.";
          }
        }
        else
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
          $query = "select * from receiptdata";
          $rs = $conn->prepare($query);
          $rs->execute();
          $entry = $rs->fetchALL(PDO::FETCH_ASSOC);
          if($entry)
          {
            echo '<table style="width:50%">
                  <tr>
                  <th>Store Name</th>
                  <th>Phone Number</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Total</th>
                  <th>    Reciept ID    </th>
                  </tr>';
            foreach($entry as $row)
            {
              echo '<tr><td>'.$row['StoreName'].'</td>';
              echo '<td>'.$row['PhoneNum'].'</td>';
              echo '<td>'.$row['RDate'].'</td>';
              echo '<td>'.$row['Rtime'].'</td>';
              echo '<td>'.$row['Total'].'</td>';
              echo '<td>'.$row['ListId'].'</td></tr>';
            }
            echo '</table>';
          }

        }

      echo'
          <form action="display.html">
          <input type="submit" value="Go Back" />
          </form>

        </body>
        </html>';
  }
?>
