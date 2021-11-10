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
    $current = filter_input(INPUT_POST,'emailC');
    $new = filter_input(INPUT_POST,'emailNew');
    $phone = filter_input(INPUT_POST,'newPhone');
    $type = filter_input(INPUT_POST,'type');
    echo '<!DOCTYPE html>
        <html>
        <body>';
    if(!$current)
    {
      echo "No email entered!";
    }
    else
    {
      if($new)
      {
        $update = "Update account Set Email='".$new."' Where Email = '".$current."'";
        $update2 = "Update person Set Email='".$new."' Where Email = '".$current."'";
        //echo $update.$update2;
        if($conn->query($update)&&$conn->query($update2))
        {
          echo "<p>Email adress Updated.</p>" ;
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
        foreach($phoneNum as $num)
        {
          $userNum = $num['PhoneNum'];
        }
        $update = "Update account Set PhoneNum='".$phone."' Where PhoneNum = '".$userNum."'";
        $update2 = "Update receiptdata Set PhoneNum='".$phone."' Where PhoneNum = '".$userNum."'";
        //echo $update.$update2;
        if($conn->query($update)&&$conn->query($update2))
        {
          echo "<p>Phone Number updated in Account and will reflect in ReceiptData.</p>" ;
        }
      }
      if($type)
      {
        if($new)
        {
          $update = "Update account Set Type='".$type."' Where Email = '".$new."'";
        }
        else {
          $update = "Update account Set Type='".$type."' Where Email = '".$current."'";
        }
        //echo$update;
        if($conn->query($update))
        {
          echo "<p>Account Type updated.</p>" ;
        }
      }

    }
    echo'<form action="update.html">
        <input type="submit" value="Go Back" />
        </form>

        </body>
        </html>';
  }
