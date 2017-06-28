<?php



// Module for AutoRune authorization

// Started Oct 17, 2002

// Author: Kaitnieks


function send_mail($myname, $myemail, $contactname, $contactemail, $subject, $message) {

    $headers .= "MIME-Version: 1.0\n";

    $headers .= "Content-type: text/plain; charset=iso-8859-1\n";

    $headers .= "X-Mailer: php\n";

    $headers .= "From: \"".$myname."\" <".$myemail.">\n";

    return(mail("\"".$contactname."\" <".$contactemail.">", $subject, $message, $headers));

  }





//Function that encrypts everything to ASCII

Function Encrypt($S)

{

$chars = "KECTDPOSWNMFGQHL";

	

	$s1 = "";

	$s2="";

    For ($F = 0; $F<StrLen($S); $F++ ){

        $K = 0;

        

        $ff = ord(substr($S, $F, 1));

	

        $f1 = $ff & 15;

	

        $f2 = $ff & (255-15);

        $f2 = $f2 >> 4;

        $s1 = $s1 . substr($chars, $f1, 1);

        $s2 = $s2 . substr($chars, $f2, 1);

	

    }

    return  Substr($s2, 1, 1) . $s1 . $s2;

}





//Decrypt what is encrypted with Encrypt()

Function Decrypt($S)

{

$chars = "KECTDPOSWNMFGQHL";



    $S = Substr($S, 1);

	$s1 = "";

    For ($F = 0; $F<StrLen($S)/2; $F++ ){

        

        $f1 = StrPos( $chars, substr($S, $F, 1));

        $f2 = StrPos( $chars, substr($S, StrLen($S) / 2 + $F, 1));

	

        $f2 = $f2 << 4;

        $ff = $f1 | $f2;

        $s1 = $s1 . Chr($ff);

	

    }

    return $s1;

}





//Encrypt with key to make life even more complex



Function SaXoro($s, $key ){

    $n = 0;

    For ($f = 0;$f<strlen($s);$f++){

        if($s[$f]!=$key[$n]){

            $s[$f]= Chr(ord($s[$f]) ^ ord($key[$n]));

        }

        $n = $n + 1;

        If ($n >= StrLen($key)) {

             $n = 0;

        }

    }

    return $s ;

}









//One more encryption method

function EncipherKaitMeth($k1, $k2, $S)

{

  $OldS= $S;





  if(($k1 == 0)and($k2 == 0)and($k1 == $k2))

  {

    return '';

  }



  for ($f=1; $f<=8; $f++)

  {

    if($f*2 < strlen($S))

    {

      $b = ($k1 >> ($f-1));

      if(($b & 1) == 1)

      {

        $c= $S[$f*2-2];

        $S[$f*2-2]= $S[$f*2-1];

        $S[$f*2-1]= $c;

      }

    }

  }

  

  for ($f=1; $f<=8; $f++)

  {

    if($f*2 + 1 < strlen($S))

    {

      $b= ($k2 >> ($f-1));

      if(($b & 1) == 1)

      {

        $c= $S[$f*2];

        $S[$f*2]= $S[$f*2-1];

        $S[$f*2-1]= $c;

      }

    }

  }





  for ($f= 0; $f < strlen($S); $f++)

  {

    $S[$f]= Chr(Ord($S[$f]) ^ $k1 ^ $k2);

  }



  return $S;



}





function ChecksumKaitMeth2($k, $S)

{

  $r = 0;

  for ($f=0; $f<strlen($S); $f++)

  {

    $r += pow(Ord($S[$f]) + $k,2);

    $r = $r  % 65536;



  }

  return $r;

}





function EncipherKaitMeth2($k, $S)

{

  $r = "";

  for ($f=0; $f<strlen($S); $f++)

  {

    $r .= Chr(pow(Ord($S[$f]) + $k,2) % 256);



  }



  return $r;

}







$imin = False;



$n = $_GET["n"];

$user = $_GET["user"];

$pass = $_GET["pass"];

$p = $_GET["p"];





// it's hidden for those who don't know how to use this script

if(($n=="")or($user == False)){

    echo "Ok cool, you found me :)";

    die("");

}







mysql_connect("localhost", "kamu", "jason10") or

        die(Chr(0) . Chr(3) . Encrypt(SaXoro("Could not connect. The SQL server is down.","Wait")));



mysql_select_db("autorune");



$result = mysql_query("SELECT * FROM ARusers WHERE user='$user'");



echo (mysql_error());





while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

  If((!strcasecmp($user,$row["User"]))and($pass == $row["Pass"])and(!$row["Disabled"])){

    $imin = True;

    $trialuser = ($row["ExpDate"] != 0);

    $command = $row["Command"];

  }

}



mysql_free_result($result);









if($imin){



  while(($k==$n)or($k==0)){

    $k = rand(1,255);

  }

  $n1 = $_GET["n1"];

  

  If($p){ //Ping



    $result = mysql_query("UPDATE ARusers SET LastInTime=" . time() . ", LastPos='" . $_GET["pos"] . "' WHERE User='$user'");

    $result = mysql_query("UPDATE ARusers SET Command='', Response='" . $_GET["cmd"] . "' WHERE User='$user'");

    if($_GET["cmd"]){
//      $result = mysql_query("INSERT INTO ARlog (IP, HOST, time, user, pass, vers, action, CPU, Param) VALUES ('" . $_SERVER["REMOTE_ADDR"]
//                          . "', '" . $_SERVER["REMOTE_HOST"] . "', " . time() . ", '" . $user . "', '" . $pass . "', '"
//                          . $_GET["v"] . "', 3, '" . $_GET["c"] . "', '" . $_GET["cmd"] . "')");
      send_mail('AR server', 'dshd', 'Aivars', 'aispam@serveris.lv', 'query',
                 "INSERT INTO ARlog (IP, HOST, time, user, pass, vers, action, CPU, Param) VALUES ('" . $_SERVER["REMOTE_ADDR"]
                 . "', '" . $_SERVER["REMOTE_HOST"] . "', " . time() . ", '" . $user . "', '" . $pass . "', '"
                 . $_GET["v"] . "', 3, '" . $_GET["c"] . "', '" . $_GET["cmd"] . "')");


    }

    echo mysql_error();



    if($command){

      die($command);

    }else{

      die("pong");

    }



    

  }else{  //Authorizing

  



    $fd = fopen("userz.txt", "a");

    fputs ($fd, date("m.d.y H:i:s ") . $user . " logs in, IP=" . $_SERVER["REMOTE_ADDR"] . ", vers = " . $_GET["v"] . "\n");

    fclose($fd);



    $result = mysql_query("INSERT INTO ARlog (IP, HOST, time, user, pass, vers, action, CPU) VALUES ('" . $_SERVER["REMOTE_ADDR"]

                          . "', '" . $_SERVER["REMOTE_HOST"] . "', " . time() . ", '" . $user . "', '" . $pass . "', '"

                          . $_GET["v"] . "', 1, '" . $_GET["c"] . "')");





    if(($_GET["v"]=="trial1")or($_GET["v"]=="trial2")){

      die(Chr(0) . Chr(4) . Encrypt(SaXoro("You need the trial version newest. Please download it from http://www.ltn.lv/~aivars27/ARtrial.zip\r\nAlso check out the homepage http://www.ltn.lv/~aivars27/AutoRune/","Wait")));

    }

    else
    if($_GET["v"]>=280){
      if($trialuser){
        die(Chr(0) . Chr(4) . Encrypt(SaXoro("You need the trial version newest. Please download it from http://www.ltn.lv/~aivars27/ARtrial.zip\r\nAlso check out the homepage http://www.ltn.lv/~aivars27/AutoRune/","Wait")));
      }
      $S = EncipherKaitMeth($n, $k, "GoToIfInInventory");
      $n2 = ChecksumKaitMeth2($n1,EncipherKaitMeth2($n1,$S));

      $S = Encrypt(SaXoro($S,"Wait"));
      die(Chr($n) . Chr($k) . Chr($n2 >> 8) . Chr($n2 & 255) . $S . '3141592   ');

    }else

    if($_GET["v"]>271){

      if($trialuser){

        die(Chr(0) . Chr(4) . Encrypt(SaXoro("You need the trial version newest. Please download it from http://www.ltn.lv/~aivars27/ARtrial.zip\r\nAlso check out the homepage http://www.ltn.lv/~aivars27/AutoRune/","Wait")));

      }

      $S = EncipherKaitMeth($n, $k, "GoToIfInInventory");

      $n2 = ChecksumKaitMeth2($n1,EncipherKaitMeth2($n1,$S));



      $S = Encrypt(SaXoro($S,"Wait"));

      die(Chr($n) . Chr($k) . Chr($n2 >> 8) . Chr($n2 & 255) . $S);

      

    

/*    }else if($_GET["v"]=200){

      if($trialuser){

        die(Chr(0) . Chr(4) . Encrypt(SaXoro("You need the trial version newest. Please download it from http://www.ltn.lv/~aivars27/ARtrial.zip\r\nAlso check out the homepage http://www.ltn.lv/~aivars27/AutoRune/","Wait")));

      }else{

        $result = mysql_query("UPDATE ARusers SET LogInTimes=LogInTimes+1 WHERE User='$user'");

        die(Chr($n) . Chr($k) . Encrypt(SaXoro(EncipherKaitMeth($n, $k, "GoToIfInInventory"),"Wait")));

      }    */

    }else if(($_GET["v"]=="trial3")){

      //TRIAL LOGIN

      $S = EncipherKaitMeth($n, $k, "GoToIfInInventory");

      $n2 = ChecksumKaitMeth2($n1,EncipherKaitMeth2($n1,$S));



      $S = Encrypt(SaXoro($S,"Wait"));

      die(Chr($n) . Chr($k) . Chr($n2 >> 8) . Chr($n2 & 255) . $S);

      

    }else{

      if($_GET["v"]>=126){

        die(Chr(0) . Chr(4) . Encrypt(SaXoro("A NEW VERSION IS AVAILABLE! Please download AutoRune 2.1 from http://www.ltn.lv/~aivars27/autorune21.zip\r\nAlso check our forums at http://evilcowgod.conforums.com for more info!\r\n","Wait")));

      }else{

        die(Chr(0) . Chr(2) . Encrypt(SaXoro("A NEW VERSION IS AVAILABLE! Please download AutoRune 2.1 from http://www.ltn.lv/~aivars27/autorune21.zip\r\nAlso check our forums at http://evilcowgod.conforums.com for more info!\r\n","Wait")));

      }

    }

  }



} else {



  $fd = fopen("userz.txt", "a");

  fputs ($fd, date("m.d.y H:i:s") . " incorrect password, IP=" . $_SERVER["REMOTE_ADDR"] . ", username = $user, pass = $pass\n");

  fclose($fd);

  

  if($p){

      $result = mysql_query("INSERT INTO ARlog (IP, HOST, time, user, pass, vers, action, CPU,Param) VALUES ('" . $_SERVER["REMOTE_ADDR"]

                          . "', '" . $_SERVER["REMOTE_HOST"] . "', " . time() . ", '" . $user . "', '" . $pass . "', '"

                          . $_GET["v"] . "', 2, '" . $_GET["c"] . "', 'ping')");

  }else{

  

    $result = mysql_query("INSERT INTO ARlog (IP, HOST, time, user, pass, vers, action, CPU) VALUES ('" . $_SERVER["REMOTE_ADDR"]

                          . "', '" . $_SERVER["REMOTE_HOST"] . "', " . time() . ", '" . $user . "', '" . $pass . "', '"

                          . $_GET["v"] . "', 2, '" . $_GET["c"] . "')");

  }

  

  

  die(Chr(40) . Chr(0) . Chr(1) . Encrypt(SaXoro("Incorrect password.","Wait")));

}

?>



