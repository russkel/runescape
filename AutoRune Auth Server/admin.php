<?php

  $user = $_POST["user"];

  $pass = $_POST["pass"];





  function send_mail($myname, $myemail, $contactname, $contactemail, $subject, $message) {

    $headers .= "MIME-Version: 1.0\n";

    $headers .= "Content-type: text/plain; charset=iso-8859-1\n";

    $headers .= "X-Mailer: php\n";

    $headers .= "From: \"".$myname."\" <".$myemail.">\n";

    return(mail("\"".$contactname."\" <".$contactemail.">", $subject, $message, $headers));

  }







  If(($user == "kamu")and($pass == "kamukorp")){



    //Connect to database

    mysql_connect("localhost", "kamu", "jason10") or

        die(Chr(0) . Chr(1) . Encrypt(SaXoro("Could not connect. The SQL server is down.","Wait")));

    mysql_select_db("autorune");



    echo "<b>AutoRune user management</b><br><br>";





    If($_POST["action"]=="adduser"){

      $result = mysql_query("INSERT INTO ARusers (User, Pass, Email, Description) VALUES ('" . $_POST["newuser"] . "', '" . $_POST["newpass"] . "', '" . $_POST["newemail"] . "', '" . $_POST["newdescr"] . "')");

      echo ("<font color=#FF0000>" . mysql_error() . "</font>");

      //send_mail("Kaitnieks", "aivars@sos.lv", $_POST["newuser"], $_POST["newemail"], "AutoRune account", "Your AutoRune account has just been created\n\nUsername: " . $_POST["newuser"] . "\nPassword: " . $_POST["newpass"] . "\n\nYou can download AutoRune trial at\nhttp://www.ltn.lv/~aivars27/ARtrial.zip\n\nYou are not allowed to download or open it if you are against bots or work in Jagex.\n\nGood luck with AutoRune!\nKaitnieks\n");

      echo "Account created succesfully!<br><br>";



    }



    If($_POST["action"]=="acceptuser"){
      $result = mysql_query("INSERT INTO ARusers (User, Pass, Email, ExpDate) VALUES ('" . $_POST["newacc"] . "', '" . $_POST["newpass"] . "', '" . $_POST["newemail"] . "', " . time() . ")");
      echo ("<font color=#FF0000>" . mysql_error() . "</font>");
      $result = mysql_query("UPDATE ARApp SET invisible=1 WHERE accname='" . $_POST["newacc"] . "'" );
      echo ("<font color=#FF0000>" . mysql_error() . "</font>");
      echo "User added to the AR user list!<br><br>";
      //send_mail("Kaitnieks", "aivars@serveris.lv", $_POST["newacc"], $_POST["newemail"], "AutoRune account", "Your AutoRune trial account has just been created\n\nUsername: " . $_POST["newacc"] . "\nPassword: " . $_POST["newpass"] . "\n\nYou can download AutoRune trial at\nhttp://www.ltn.lv/~aivars27/ARtrial.zip\n\nYou are not allowed to download or open it if you are against bots or work in Jagex.\n\nWhen you decide to purchase it, visit this link:\nhttp://www.ltn.lv/~aivars27/AutoRune/buy.php\n\nGood luck with AutoRune!\nKaitnieks\n");
      echo "<input type=text value=\"" . $_POST["newemail"] . "\"><a href=\"mailto:" . $_POST["newemail"] . "?subject=Your%20AutoRune%20trial%20account%20has%20just%20been%20created\">" . $_POST["newemail"] . "</a><br>";
      $result = mysql_query("SELECT * FROM ARtexts WHERE Title='trialcreated'");
      echo ("<font color=#FF0000>" . mysql_error() . "</font>");
      if($row = mysql_fetch_array($result, MYSQL_ASSOC)){
        $disptext = $row["Data"];
        $disptext = str_replace("%user%", $_POST["newacc"], $disptext);
        $disptext = str_replace("%pass%", $_POST["newpass"], $disptext);
        $disptext = str_replace("%date%", date("Ymd\THis"), $disptext);
      }
      echo "<textarea  rows=6 cols=40>$disptext
      </textarea><br><br>";
    }
    
    
    If($_POST["action"]=="updateuser"){
      $result = mysql_query("UPDATE ARusers SET User=\"" . $_POST["newuser"] . "\", email=\"" . $_POST["newemail"] . "\",
                             Description=\"" . $_POST["newdesc"] . "\", Command=\"" . $_POST["newcommand"] . "\" WHERE id=\"" . $_POST["theid"] . "\"");
      echo ("<font color=#FF0000>" . mysql_error() . "</font>");
      echo "User information updated!<br><br>";
      
      If($_POST["newpass"]!=""){
        $result = mysql_query("UPDATE ARusers SET Pass=\"" . $_POST["newpass"] . "\" WHERE id=\"" . $_POST["theid"] . "\"");
        echo ("<font color=#FF0000>" . mysql_error() . "</font>");
        echo "The password changed!<br><br>";
      }
      

    }
    
    if($_POST["action"]=="updatetext"){
      $result = mysql_query("UPDATE ARtexts SET Data=\"" . $_POST["newdata"] . "\" WHERE Title=\"" . $_POST["whichtext"] . "\"");
      echo ("<font color=#FF0000>" . mysql_error() . "</font>");
      echo "The text was changed!<br><br>";
    }
    
    if($_POST["action"]=="edittext"){
      $result = mysql_query("SELECT Data FROM ARtexts WHERE Title=\"" . $_POST["whichtext"] . "\"");
      echo ("<font color=#FF0000>" . mysql_error() . "</font>");
      if($row = mysql_fetch_array($result, MYSQL_ASSOC)){
        echo "<form action=\"admin.php\" method=POST>";
        echo "<input type=hidden name=whichtext value=" .  $_POST["whichtext"] . ">";
        echo "<textarea rows=7 cols=40 name=newdata>" . $row["Data"] . "</textarea><br>";
        echo "<input name=action type=hidden value=\"updatetext\">";
        echo "<input name=user type=hidden value=\"$user\">";
        echo "<input name=pass type=hidden value=\"$pass\">";
        echo "<input type=submit name=editit value=\"Change Text\">";
        echo "</form><br><hr>";
      }
    }
    
    
    If($_POST["action"]=="edituser"){
      $result = mysql_query("SELECT * FROM ARusers WHERE id='" . $_POST["theid"] . "'" );
      echo ("<font color=#FF0000>" . mysql_error() . "</font>");
      if($row = mysql_fetch_array($result, MYSQL_ASSOC)){
        echo ("<font color=#FF0000>" . mysql_error() . "</font>");
        echo "<form action=\"admin.php\" method=POST>
              <table>";
        echo "<tr><td>User:</td><td><input name=newuser value='" . $row["User"] . "'></td></tr>\n";
        echo "<tr><td>Pass:</td><td><input name=newpass value='" . '' . "'></td></tr>\n";
        echo "<tr><td>E-Mail:</td><td><input name=newemail value='" . $row["email"] . "'></td></tr>\n";
        echo "<tr><td>Description:</td><td><textarea rows=7 cols=40 name=newdesc>" . $row["Description"] . "</textarea></td></tr>\n";
        echo "<tr><td>Command:</td><td><input name=newcommand value='" . $row["Command"] . "'></td></tr>\n";
        echo "</table>
             <input name=user type=hidden value=\"$user\">
             <input name=pass type=hidden value=\"$pass\">
             <input name=theid type=hidden value=\"" . $_POST["theid"] . "\">
             <input name=action type=hidden value=\"updateuser\">
             <input type=submit name=editit value=\"Update\">
             </form><hr><br><br>";
      }
    }



    If($_POST["action"]=="rejectuser"){

      $result = mysql_query("UPDATE ARApp SET invisible=1 WHERE accname='" . $_POST["newacc"] . "'" );

      echo ("<font color=#FF0000>" . mysql_error() . "</font>");

      echo "User rejected!<br><br>";

      echo "<input type=text value=\"" . $_POST["newemail"] . "\"><a href=\"mailto:" . $_POST["newemail"] . "?subject=Your%20AutoRune%20application%20has%20been%20rejected\">" . $_POST["newemail"] . "</a><br>";

      $result = mysql_query("SELECT * FROM ARtexts WHERE Title='trialrejected'");
      echo ("<font color=#FF0000>" . mysql_error() . "</font>");
      if($row = mysql_fetch_array($result, MYSQL_ASSOC)){
        $disptext = $row["Data"];
        $disptext = str_replace("%user%", $_POST["newacc"], $disptext);
        $disptext = str_replace("%pass%", $_POST["newpass"], $disptext);
        $disptext = str_replace("%date%", date("Ymd\THis"), $disptext);
      }
      echo "<textarea  rows=6 cols=40>$disptext
      </textarea><br><br>";
      


    }



    If($_POST["action"]=="enableuser"){

      $result = mysql_query("UPDATE ARusers SET Disabled=0 WHERE id='" . $_POST["theid"] . "'" );

      echo ("<font color=#FF0000>" . mysql_error() . "</font>");

      echo "User Enabled!<br><br>";

    }



    If($_POST["action"]=="disableuser"){

      $result = mysql_query("UPDATE ARusers SET Disabled=1 WHERE id='" . $_POST["theid"] . "'" );

      echo ("<font color=#FF0000>" . mysql_error() . "</font>");

      echo "User Disabled!<br><br>";

    }


    If($_POST["action"]=="tofulluser"){

      $result = mysql_query("UPDATE ARusers SET ExpDate=0 WHERE id='" . $_POST["theid"] . "'" );

      echo ("<font color=#FF0000>" . mysql_error() . "</font>");

      echo "User Upgraded to full!<br><br>";
      
      $result = mysql_query("SELECT * FROM ARtexts WHERE Title='trialupgraded'");
      echo ("<font color=#FF0000>" . mysql_error() . "</font>");
      if($row = mysql_fetch_array($result, MYSQL_ASSOC)){
        $disptext = $row["Data"];
        $disptext = str_replace("%user%", $_POST["newacc"], $disptext);
        $disptext = str_replace("%pass%", $_POST["newpass"], $disptext);
        $disptext = str_replace("%date%", date("Ymd\THis"), $disptext);
      }
      echo "<a href=\"mailto:" . $_POST["newemail"] . "?subject=AutoRune%20Registration\">" . $_POST["newemail"] . "</a><br>";
      echo "<textarea  rows=6 cols=40>$disptext
      </textarea><br><br>";

    }



    If($_POST["action"]=="totrialuser"){

      $result = mysql_query("UPDATE ARusers SET ExpDate=1 WHERE id='" . $_POST["theid"] . "'" );

      echo ("<font color=#FF0000>" . mysql_error() . "</font>");

      echo "User demoted to trial user!<br><br>";

    }




    If($_POST["action"]=="viewlog"){

      $result = mysql_query("SELECT * FROM ARlog WHERE user='" . $_POST["accname"] . "'");



      echo ("<font color=#FF0000>" . mysql_error() . "</font>");

      echo "<TABLE border=1>";

      echo "<TR><TD>Time</TD><TD>IP</TD><TD>HOST</TD><TD>Action</TD><TD>vers</TD><TD>CPU</TD><TD>Param</TD></TR>";

      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

        echo "<TR><TD>" . date("m.d.y H:i:s", $row["time"]) . "</TD><TD>" . $row["IP"] . "</TD>

              <TD>" . $row["HOST"] . "</TD><TD>";

        if($row["action"] == 1){

          echo "Logged in";

        }else if($row["action"] == 2){

          echo "Wrong password";
        }else if($row["action"] == 3){
          echo "Command reply";
        }else{
          echo $row["action"];
        }

        echo "</TD><TD>" . $row["vers"] . "</TD><TD>" . $row["CPU"] . "</TD><TD>" . $row["Param"] . "</TD></TR>";

      }

      echo "</TABLE>";

    }





    if($_POST["action"]=="listusers")

    {



      echo "User list<br><br>";



      $result = mysql_query("SELECT * FROM ARusers");



      echo ("<font color=#FF0000>" . mysql_error() . "</font>");



      echo "<TABLE>";

      echo "<TR bgcolor=#CCCCCC>";
      echo "<TD>User</TD><TD>Email</TD><td>Description</td><TD>Disable/Enable</TD><TD>Show_Log</TD><TD>Edit_User</TD><TD>Trial/Full</TD><TD>LastPos</TD></TR>";

      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {


        if((($row["ExpDate"]==0)or($_POST["showtrial"]))and(($row["ExpDate"]!=0)or($_POST["showfull"]))and
            (($row["Disabled"]==0)or($_POST["showdisabled"]))and(($row["User"]==$_POST["showonlyname"])or(!$_POST["showonlyname"]))){
          echo "<TR";
          if($row["ExpDate"]==0){
            echo " bgcolor=#EEEEEE";
          }

          echo "><TD>" . $row["User"];

          if(time() - $row["LastInTime"] < 900){

           echo " (*)";

          }

          echo "</TD><TD>" . $row["email"] . "</TD><TD>" . $row["Description"] . "</TD><TD>";

          If($row["Disabled"]){

            ?>

                 <form method=POST action="admin.php">

                 <input name="user" type="hidden" value="<?php echo $user; ?>">

                 <input name="pass" type="hidden" value="<?php echo $pass; ?>">

                 <input name="theid" type="hidden" value="<?php echo $row["id"]; ?>">



                 <input name="action" type="hidden" value="enableuser">

                 <input type="submit" name="Enable" value="Enable">

                 </form>

            <?php

          }else{

            ?>

                 <form method=POST action="admin.php">

                 <input name="user" type="hidden" value="<?php echo $user; ?>">

                 <input name="pass" type="hidden" value="<?php echo $pass; ?>">

                 <input name="theid" type="hidden" value="<?php echo $row["id"]; ?>">



                 <input name="action" type="hidden" value="disableuser">

                 <input type="submit" name="Disable" value="Disable">

                 </form>

            <?php

          }

          echo "</TD><TD>";

              ?>

                 <form method=POST action="admin.php">

                 <input name="user" type="hidden" value="<?php echo $user; ?>">

                 <input name="pass" type="hidden" value="<?php echo $pass; ?>">

                 <input name="accname" type="hidden" value="<?php echo $row["User"]; ?>">



                 <input name="action" type="hidden" value="viewlog">

                 <input type="submit" name="Log" value="Log">

                 </form>

            <?php

          echo "</TD><TD>";

              ?>

                 <form method=POST action="admin.php">
                 <input name="user" type="hidden" value="<?php echo $user; ?>">
                 <input name="pass" type="hidden" value="<?php echo $pass; ?>">
                 <input name="theid" type="hidden" value="<?php echo $row["id"]; ?>">
                 <input name="action" type="hidden" value="edituser">
                 <input type="submit" name="Edit" value="Edit">
                 </form>

            <?php


          echo "</TD><TD>";
          If($row["ExpDate"]==0){

            ?>

                 <form method=POST action="admin.php">

                 <input name="user" type="hidden" value="<?php echo $user; ?>">

                 <input name="pass" type="hidden" value="<?php echo $pass; ?>">

                 <input name="theid" type="hidden" value="<?php echo $row["id"]; ?>">

                 <input name="newacc" type="hidden" value="<?php echo $row["User"]; ?>">

                 <input name="newpass" type="hidden" value="<?php echo $row["Pass"]; ?>">

                 <input name="action" type="hidden" value="totrialuser">

                 <input type="submit" name="Trial" value="Convert To Trial">

                 </form>

            <?php

          }else{

            ?>

                 <form method=POST action="admin.php">

                 <input name="user" type="hidden" value="<?php echo $user; ?>">

                 <input name="pass" type="hidden" value="<?php echo $pass; ?>">

                 <input name="theid" type="hidden" value="<?php echo $row["id"]; ?>">

                 <input name="newacc" type="hidden" value="<?php echo $row["User"]; ?>">

                 <input name="newpass" type="hidden" value="<?php echo $row["Pass"]; ?>">
                 
                 <input name="newemail" type="hidden" value="<?php echo $row["email"]; ?>">


                 <input name="action" type="hidden" value="tofulluser">

                 <input type="submit" name="Full" value="Convert To Full">

                 </form>

            <?php

          }
          
          echo "</TD><TD>";
          
          echo $row["LastPos"];

          echo "</TD></TR>";
        }
      }

      echo "</TABLE><br><br>";



    }



    if($_POST["action"]=="listapp")

    {

      echo "Applications list<br><br>";



      $result = mysql_query("SELECT * FROM ARApp WHERE invisible=0");



      echo ("<font color=#FF0000>" . mysql_error() . "</font>");



      echo "<TABLE>";

      echo "<TR><TD>Name</TD><td>email</td><TD>OS</TD><TD>bots</TD><TD>trust</TD><TD>known</TD><TD>found</TD><TD>pay</TD><TD>age</TD><TD>Accept</TD><TD>Reject</TD></TR>";

      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

        echo "<TR><TD>" . $row["accname"] . "</TD><TD>" . $row["email"] . "</TD><TD>" . $row["OS"] . "</TD><TD><textarea rows=5 cols=20>" . $row["botsused"] . "</textarea></TD><TD><textarea rows=5 cols=20>" . $row["trust"] . "</textarea></TD><TD><textarea rows=5 cols=20>" . $row["known"] . "</textarea></TD><TD><textarea rows=5 cols=20>" . $row["findout"] . "</textarea></TD>

              <TD>" . $row["pay"] . "</TD><TD>" . $row["age"] . "</TD><TD>"  ?>

               <form method=POST action="admin.php">

               <input name="user" type="hidden" value="<?php echo $user; ?>">

               <input name="pass" type="hidden" value="<?php echo $pass; ?>">

               <input name="newacc" type="hidden" value="<?php echo $row["accname"]; ?>">

               <input name="newpass" type="hidden" value="<?php echo $row["accpass"]; ?>">

               <input name="newemail" type="hidden" value="<?php echo $row["email"]; ?>">



               <input name="action" type="hidden" value="acceptuser">

               <input type="submit" name="Accept" value="Accept">

               </form><?php

               echo "

              </TD>

              <TD>"  ?>

               <form method=POST action="admin.php">

               <input name="user" type="hidden" value="<?php echo $user; ?>">

               <input name="pass" type="hidden" value="<?php echo $pass; ?>">

               <input name="newacc" type="hidden" value="<?php echo $row["accname"]; ?>">

               <input name="newpass" type="hidden" value="blehyu23v23n">

               <input name="newemail" type="hidden" value="<?php echo $row["email"]; ?>">



               <input name="action" type="hidden" value="rejectuser">

               <input type="submit" name="Reject" value="Reject">

               </form><?php

               echo "

              </TD>

              </TR>";

      }

      echo "</TABLE><br><br>";



    }



    ?>











    Add new user:

    <form method=POST action="admin.php">

    <table>

  <tr>

    <td>Username:</td>

    <td><input name="newuser" type="text"></td>

  </tr>

  <tr>

    <td>Password:</td>

    <td><input name="newpass" type="text"></td>

    <input name="user" type="hidden" value="<?php echo $user; ?>">

    <input name="pass" type="hidden" value="<?php echo $pass; ?>">

    <input name="action" type="hidden" value="adduser">

  </tr>

  <tr>

    <td>e-mail:</td>

    <td><input name="newemail" type="text"></td>

  </tr>

  <tr>

    <td>Description:</td>

    <td><textarea name="newdescr" rows="5" cols="60"></textarea></td>

  </tr>

  <tr>

    <td colspan=2><center><input type="submit" name="Add" value="Add User"></center></td>

    <td></td>

  </tr>

</table>

    </form>





     <hr>

     List Applications to trial version:<br>

    <form method=POST action="admin.php">

    <input name="user" type="hidden" value="<?php echo $user; ?>">

    <input name="pass" type="hidden" value="<?php echo $pass; ?>">

    <input name="action" type="hidden" value="listapp">

    <input type="submit" name="List" value="List">

    </form>

     <hr>

     List Current AutoRune users:<br>

    <form method=POST action="admin.php">

    <input name="user" type="hidden" value="<?php echo $user; ?>">

    <input name="pass" type="hidden" value="<?php echo $pass; ?>">

    <input name="action" type="hidden" value="listusers">

    <input type="submit" name="List" value="List"><br>
    
    <input type="checkbox" name="showfull" value="Show Full Accounts" checked="checked">Show Full Accounts<br>
    
    <input type="checkbox" name="showtrial" value="Show Trial Accounts">Show Trial Accounts<br>
    
    <input type="checkbox" name="showdisabled" value="Show Disabled Accounts">Show Disabled Accounts<br>
    
    Serach by name: <input name="showonlyname">

    </form>
    
    <hr>
    Edit Automatic response texts:<br>
    
    <form method=POST action="admin.php">

    <input name="user" type="hidden" value="<?php echo $user; ?>">

    <input name="pass" type="hidden" value="<?php echo $pass; ?>">

    <input name="action" type="hidden" value="edittext">

    <select name="whichtext" size="1">
<option value="trialcreated">On Trial Created</option>
<option value="trialrejected">On Trial Rejected</option>
<option value="trialupgraded">On Trial Upgraded</option>
</select><br>
    <input type="submit" name="Edit" value="Edit">

    </form>


    <?php

  }else{

    ?>

    <form method=POST action="admin.php">

    <table>

  <tr>

    <td colspan=2><center>Log In</center></td>

    <td></td>

  </tr>

  <tr>

    <td>User:</td>

    <td><input name="user" type="text"></td>

  </tr>

  <tr>

    <td>Pass:</td>

    <td><input name="pass" type="password"></td>

  </tr>

  <tr>

    <td colspan=2><center><input type="submit" name="LogIn" value="Log In"></center></td>

    <td></td>

  </tr>

</table>

</form>

    <?php

  }

?>

