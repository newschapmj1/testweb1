<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">






    <link rel="stylesheet" href="bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="css/custom002_jan15.css" type="text/css" />
    <!--<link rel="stylesheet" href="css/all.css" type="text/css"/>  -->
    <!-- <link href='%2F%2Ffonts.googleapis.com%2Fcss%3Ffamily%3DMerriweather%3A400%2C900%7COpen%2BSans' rel='stylesheet' type='text/css'> -->
    <link href='//fonts.googleapis.com/css?family=Merriweather:400,900|Open+Sans' rel='stylesheet' type='text/css'>

    <!-- <script src="js/all.js"></script> -->
    <script src="js/jquery/jquery-1.11.3.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->

    <script src="bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="/favicon.ico" />



    <title>Redbridge Ramblers, Walks Programme</title>
    <meta name="description" content="A list of walks with Redbridge Ramblers" />


    <style>
        @media only screen and (max-width: 499px) {

.grid-container {
    display: grid;
    grid-template-columns: auto auto;
    grid-gap: 2px;
    background-color: rgba(0, 6, 3, 0.1);
    padding: 2px;
}



}

@media only screen and (min-width: 500px) {

.grid-container {
    display: grid;
    grid-template-columns: auto minmax(20px, 140px) auto auto;
    grid-gap: 2px;
    background-color:rgba(0,6,3,0.1);
    padding: 2px;               
}
}

      @media only screen and (max-width: 499px) {
/* background: 4 divs one shade, next 4 divs another shade */
          .grid-container  div:nth-of-type(8n-0) {
              background-color:#fafadb;
            }

            .grid-container   div:nth-of-type(8n-1) {
            background-color:#fafadb;
            }           

            .grid-container   div:nth-of-type(8n-2) {
            background-color:#fafadb;
            }   
            
            .grid-container   div:nth-of-type(8n-3) {
            background-color:#fafadb;
            }

            /*2nd shade*/

            .grid-container   div:nth-of-type(8n-4) {
                background-color:#ffffcc;
              }
  
              .grid-container   div:nth-of-type(8n-5) {
              background-color:#ffffcc;
              }           
  
              .grid-container   div:nth-of-type(8n-6) {
              background-color:#ffffcc;
              }   
              
              .grid-container   div:nth-of-type(8n-7) {
              background-color:#ffffcc;
              }
            }



@media only screen and (min-width: 500px) {
                  .grid-container  div {
                  background-color:#ffffcc;
                }
            }


        .grid-container>div {
            background-color: #ffffcc;
            text-align: left;
            padding: 2px 0;
        }

        /* @media print { */

        body,
   
        p {
            margin: 2px;
        }

        .wrapper {
            max-width:920px;
            margin:auto;
        }

        .col-sm-2,
        col-sm-6 {
            padding-left: 5px;
            padding-right: 5px;
        }

        .container
        {padding-left:5px;
        padding-right:5px;}

        a {
    background-color: transparent;
    color:#24537F;
    text-decoration: none;
}
    </style>
</head>

<body>
<?php
include_once 'analyticstracking.php';
?>
<?php
include 'navbar.php';
?>
<?php
function lastUpdate()
{


    try
    {
       $dbh = new PDO('mysql:host=localhost;dbname=php;charset=utf8mb4',
       'reader','0Ef2xeo2nIIs6vdt44af', array(PDO::ATTR_EMULATE_PREPARES => false,
       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
       
       $query="SELECT id,lastupdate FROM walks_lastupdate where id=1";
       foreach ($dbh->query($query) as $row)
       {
           $lastupdate=$row['lastupdate'];
           $id = $row['id'];
        }
        echo $lastupdate;
         
   }
       catch(PDOException $e)
       {
       echo $e->getMessage();
       }    
/*echo "30/03/2018"; */
}
?>


    <div id="logo003">
        <span class="redcolor text-centre">R</span>edbridge
        <span class="redcolor">R</span>amblers
    </div>

    <h2 class="text-center">
        <b>Walks Programme</b>
    </h2>

    <div class="container">

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <p class="text-center">
                    <a href="walks_getting_there.php">Walks - getting there</a>&nbsp;&nbsp;&nbsp;
                    <a href="directions.php">Directions</a>
                </p>
                <br>
                <p>Last update: <?php lastUpdate(); ?></p>
                <p>If this page is not displaying the walks in grid format try <a href="https://redbridgeramblers.org.uk/walks_oldbrowser.php">here</a><p>
            </div>

        </div>


        <br>

        <?php
                include("functions.php");




function lastUpdate2()
{

 try
 {
    $dbh = new PDO('mysql:host=localhost;dbname=php;charset=utf8mb4',
    'reader','0Ef2xeo2nIIs6vdt44af', array(PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    $query="SELECT lastupdate FROM walks_lastupdate";
    foreach ($dbh->query($query) as $row)
    {
        $lastupdate=$row['lastupdate'];
     }
     /*return date_format($lastupdate,"d/m/Y");*/
     return '30/03/2018';
}
    catch(PDOException $e)
    {
    echo $e->getMessage();
    }
}

 function walkCode($walkcode="E") {
      switch ($walkcode)
    {
      case 'E':$returnValue = 'easy';
      break;
      case  'EA':$returnValue = 'easy access';
      break;
      case 'L':$returnValue = 'leisurely';
      break;
      case 'M':$returnValue = 'moderate';
    break;
      case 'S':$returnValue = 'strenuous';
        break;
    default:
        $returnValue='&nbsp;';
        break;
    }
      // do stuff
      return $returnValue;

};

function routeType($walkcode) {
      switch ($walkcode)
    {
      case 'C':$returnValue = 'circular';
      break;

      case 'L':$returnValue = 'linear';
      break;

    default:
        $returnValue='';
        break;
    }
      // do stuff
      return $returnValue;

};




function createTable()
{
  $usertable="walks2_aug2018";
/*  $password="Walk2017$";
  $username="walkerS1";
*/

  $password="0Ef2xeo2nIIs6vdt44af";
  $username="reader";
  $thismonth=date('n');   /* 1-12 */

  try {


$dbh = new PDO('mysql:host=localhost;dbname=php;charset=utf8mb4',
'reader','0Ef2xeo2nIIs6vdt44af', array(PDO::ATTR_EMULATE_PREPARES => false,
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

     

                $query="SELECT walkid,walkdate,briefdescription,exp,startgridref,starttime,grade,longerdescription, miles,lon,lat,routetype
                FROM $usertable
                where walkdate>=date(now())-1
                order by walkdate";

    $oldmonth="";

print("<div class=\"wrapper\">");
print("<div class=\"grid-container\">");
  foreach ($dbh->query($query) as $row)
        {
                        $d=formatday($row['walkdate']);
                        $m=formatmonth($row['walkdate']);
                        
                        $y=formatyear($row['walkdate']);

                        //-------------make unix timestamp for formatting---------------------
                        $timestamp=mktime(0,0,0,substr($row['walkdate'],5,2),substr($row['walkdate'],8,2),substr($row['walkdate'],0,4));
                        $thiswalkmonth=date('n',$timestamp);
                        $formatteddate=date("M",$timestamp)."<br>".date("Y",$timestamp);

                        //---------------if month changes, add a new row----------------
                        if ($oldmonth!=$m)
                                {
                                //print if walkmonth is  >= current month
                                  if ($thiswalkmonth >= $thismonth )
                                  {
                                  print("<div><p><strong>".$formatteddate."</strong></p></div><div></div><div></div><div></div>");
                                  }

            
                                }
                        $oldmonth=$m;


                       
                        //$formatteddatetime=date("l",$timestamp)."<br>".date("jS",$timestamp)." of ".date("M",$timestamp)."<br> ".$row['starttime'];
                        $formatteddatetime=date("D",$timestamp)."<br>".date("j",$timestamp)." ".date("M",$timestamp)."<br> ".$row['starttime'];

                        $year= substr($row['walkdate'],0,4);
                    $month=(substr($row['walkdate'],5,2));
                    $day= substr($row['walkdate'],8,2);
                    $walktime=mktime(1,1,1,$month,$day,$year);
                    $t=time();
                    $t2=time()-(24*20000);
                        if ($walktime<$t2) {$old="Old";} else {$old="Current";}

                        //  for use later to make a clickable streetmap link
                        // e.g. http://www.streetmap.co.uk/streetmap.dll?G2M?X=440109&ampY=191498&amp;A=Y&Z=1
                        //http://streetmap.co.uk/grid/527383_174495
                        $easting=substr($row['startgridref'],3,3);
                        $northing=substr($row['startgridref'],6,3);
                        $gridsquare=substr($row['startgridref'],0,2);
                        $sqeast="5";
                        $sqnorth="1";

                        //Change to Streetmap as Multimap worked on some machines not others, cause unknown.
                        if($gridsquare=="SZ") { ($sqeast="4"); ($sqnorth=""); }
                        if($gridsquare=="SU") { ($sqeast="4"); ($sqnorth="1"); }
                        if($gridsquare=="SP") { ($sqeast="4"); ($sqnorth="2"); }
                        if($gridsquare=="TV") { ($sqeast="5"); ($sqnorth=""); }
                        if($gridsquare=="TQ") { ($sqeast="5"); ($sqnorth="1"); }
                        if($gridsquare=="TL") { ($sqeast="5"); ($sqnorth="2"); }
                        if($gridsquare=="TR") { ($sqeast="6"); ($sqnorth="1"); }
                        if($gridsquare=="TM") { ($sqeast="6"); ($sqnorth="2"); }

                        $mapgridref=$sqeast.$easting."00_".$sqnorth.$northing."00_120";

                        if ($old!="Old")
                                {

                                    $startgridref = str_replace(" ","_",$row['startgridref']);

                                    //print("<tr id=\".$row['walkid'].\">");
                                    //print("<div class=\"row $row[walkid]\">");
                                    //print("<tr id=\"$row[walkid]\">");
                                    //print("<td>$formatteddatetime");

                                    //col 1 of 4
                                    print("<div><p>".$formatteddatetime."<p></div>");
                                    //print("</td>");
                                    //print("<td>$row[briefdescription]<br><br>Miles: $row[miles]"."  ".routeType($row[routetype])."<br><br>Grade: ".walkCode($row['grade']));

                                    //col 2 of 4
                                    print("<div><p><strong>".$row['briefdescription']."</strong></p><p>Miles: ".$row['miles'].",  ".
                                      routeType($row['routetype']).', '.walkCode($row['grade'])."</p></div>");

                                    //col 3 of 4
                                    //  print("<div><p>".$startgridref." Map ".$row['exp']."</p>");
                                    //print("</td>");
                                    print("<div>");
                                    if ($startgridref<>"")
                                    {
                                    print("<p><a href=\"http://streetmap.co.uk/grid/$mapgridref\" target=\"_blank\" >$startgridref</a></p>");
                                    }
                                    if ($row['lat'] <>"") {
                                    print("<br><p><a href=\"http://maps.google.co.uk/?q=".$row['lat'].",".$row['lon']
                                    ."(See%20Description%20for%20departure%20details)&amp;z=16&amp;t=k\" target=\"_blank\">Satellite</a></p>");
                                    print("<br><p>Map ".$row['exp']."</p>");
                                    }
                                    print("</div>");
                                



                                    //col 4 of 4
                                    print("<div><p>".$row['longerdescription']."</p></div>");
                                    //exit loop when item is empty
                                    
                                    //$cars = array("Volvo", "BMW", "Toyota");
                                    //$contactString = $row['contact1'].' '.$row['contact2'];
                                    //$contacts=['a','b','c','d'];

                                    
                                    //4 of 4
                                    //print('<p>array: '+$contacts[0].' '.$contacts[1].' '.$contacts[2].' '.$contacts[3].'</p>');
                                    //print('contactString:'.$contactString."</div></div><hr>");
                                    //if (strlen($contactString)>1)
                                    //   {print("<br><br>".$contactString."str length ".strval(strlen($contactString))."</div>");}
                                    //else
                                    //{print("</div>");}
                                    //print('<p>array: '+$contacts[0].' '.contacts[1].' '.contacts[2].' '.contacts[3].'</p>');
                                    //.addData($row['contact1'],1).addData($row['contact2'],2).addData($row['contact3'],3).addData($row['contact4'],4)."</div></div><hr>");                         
                                }
        }
/*** close database  ***/
        $dbh = null;
         print("</div></div></div>");
    }

catch(PDOException $e)
    {
    echo $e->getMessage();
    }

}

//declare(strict_types=1);
function addData(string $a, int $i) {
    if ($i<4)
    {
    if (strlen(trim($a)) >0)
        {return trim($a)."X<br>";}
    else    
        {return "Z";}
    }
    else
    {
        if (strlen(trim($a)) >0)
        {return trim($a).'X';}
    else    
        {return "Z";}
    }

}






createTable();

?>


            <!--</div>
</div>
</div> -->
            <script type="application/ld+json">
                <?php
/* createJson(); */
  ?>
            </script>
</body>

</html>
