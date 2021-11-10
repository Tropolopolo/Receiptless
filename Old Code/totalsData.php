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

      $select = "select PhoneNum from account where Email='".$email."'";
      //echo $select;
      $rs = $conn->prepare($select);
      $rs->execute();
      $phoneNum = $rs->fetchALL(PDO::FETCH_ASSOC);
      foreach($phoneNum as $num)
      {
        $userNum = $num['PhoneNum'];
      }

      $query = "select total from totalpercustomer Where PhoneNum='".$userNum."'";
      $rs = $conn->prepare($query);
      $rs->execute();
      $entry = $rs->fetchALL(PDO::FETCH_ASSOC);
      //print_r($entry);
      if($entry)
      {
        foreach($entry as $val)
        {
          $userSpent = $val['total'];
        }
        $formattedNum = number_format($userSpent,2);
        echo"<p>User: ".$email." has spent in total: $".$formattedNum."</p>";
      }
      else {
        echo"No results Found\n.";
      }
      }

      echo'
          <form action="totals.html">
          <input type="submit" value="Go Back" />
          </form>

        </body>
        </html>';
  }
?>
