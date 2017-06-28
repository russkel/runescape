<?php

  
  
  if($_POST["apply"]){
    //Connect to database
    mysql_connect("localhost", "aivars", "cby1*lyz") or
        die("Could not connect. The SQL server is down.");
    mysql_select_db("aivars");
  
    echo "<b>Thank you, your application will be reviewed in next 2 days.</b><br><br>";


    $result = mysql_query("INSERT INTO ARApp (accname, accpass, email, OS, botsused, trust, known, findout, pay, age) VALUES ('" . $_POST['accname'] . "', '" . $_POST['accpass'] . "', '" . $_POST['email'] . "', '" . $_POST['winvers'] . "', '" . $_POST['botsused'] . "', '" . $_POST['trust'] . "', '" . $_POST['known'] . "', '" . $_POST['findout'] . "', '" . $_POST['pay'] . "', '" . $_POST['age'] . "')");
    echo (mysql_error());

  }else{

  /*
  echo "The applications are closed again. Please check back again when we decide to do the next re-opening.";
  */

?>

  <center><h1>AutoRune Community Application Form</h1></center><br><br>
  To join the community you must fill in this form. We will review the application in 48 hours and either
  accept or reject it. After it's accepted you will get the trial version to test and if you like it,
  you will be given a chance to buy the full version.<br><br>
  
  <form action="apply.php" method=POST>
  Preffered account name (NOT RScape name, don't use spaces, use ONLY letters and digits):<br>
  <input name="accname" type="text" size="20" maxlength="20"><br><br>
  Preffered password (use ONLY letters and digits):<br>
  <input name="accpass" type="text" size="20" maxlength="20"><br><br>
  Contact e-mail (All info will be sent there):<br>
  <input name="email" type="text" size="20" maxlength="30"><br><br>
  Your Windows version:<br>
  <input name="winvers" type="text" size="20" maxlength="20"><br><br>
  Have you used bots before? List them:<br>
  <textarea name="botsused" rows="6" cols="20"></textarea><br><br>
  Why should we trust you?<br>
  <textarea name="trust" rows="6" cols="20"></textarea><br><br>
  Do you know anyone of AutoRune community? Whom?<br>
  <textarea name="known" rows="6" cols="20"></textarea><br><br>
  Where did you find out about AutoRune?<br>
  <textarea name="findout" rows="6" cols="20"></textarea><br><br>
  Would you pay $20 for AR if it works fine? How?<br>
  <input type="radio" name="pay" value="no" checked="checked">No
  <input type="radio" name="pay" value="credc">Credit Card
  <input type="radio" name="pay" value="wire">Wire Transfer
  <input type="radio" name="pay" value="check">Send Check
  <input type="radio" name="pay" value="cash">Send Cash<br><br>
  How old are you?<br>
  <input name="age" type="text" size="2" maxlength="2"><br><br>
  <input type="submit" name="apply" value="Send Application">
  </form>
  

    <?php

  }
?>
