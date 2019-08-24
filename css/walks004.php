<!DOCTYPE html>
<html manifest="example.appcache">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"  type="text/css"/> 

<!--    <link rel="stylesheet" href="css/all.css" type="text/css"/>  -->
    <!-- <link href='%2F%2Ffonts.googleapis.com%2Fcss%3Ffamily%3DMerriweather%3A400%2C900%7COpen%2BSans' rel='stylesheet' type='text/css'> -->
<link href='//fonts.googleapis.com/css?family=Merriweather:400,900|Open+Sans' rel='stylesheet' type='text/css'> 
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>  -->
<script src="js/jquery/jquery-1.11.2.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->

    <!-- <script src="bootstrap/3.3.1/js/bootstrap.min.js"></script> -->
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/favicon.ico"/>



<title>Redbridge Ramblers, Walks Programme</title>
<meta name="description" content="A list of walks with Redbridge Ramblers" />
</head>
<body>
<?php
include_once 'analyticstracking.php';
?>
 <?php
include 'navbar.php';
?>

<div id="logo003">
    <span class="redcolor text-centre">R</span>edbridge <span class="redcolor">R</span>amblers
 </div>
 <h2 class="text-center"><b>Walks Programme</b></h2>

<div class="container">
 <div class="row col-sm-8 col-sm-offset-2">
  <p class="text-center"><a href="walks_getting_there.php">Walks - getting there</a>&nbsp;&nbsp;&nbsp<a href="directions.php">Directions</a></p>
</div>
</div>
<br>


<!--table-hover -->
<!--new table sm offset 1 2,2,2,4 (1 off) -->


<div class="container">
     <div class="row">
        <div class="col-sm-2">Date</div>
        <div class="col-sm-2">Details</div>
        <div class="col-sm-2">Map</div>
        <div class="col-sm-4">Description</div>
      </div>
</div>

<!--
<table class="table table-hover table-responsive">
  <thead>
  <tr>
    <th>Date</th>
    <th>Details</th>
    <th>Map</th>
    <th>Description</th>
  </tr>
</thead>
-->


<?php
                include("functions.php");
#copied Multimap settings from walkstest.php
#removed references to Streetview which were out of date
#John Chapman 
#Date 14 Jun 2009
#Other minor syntax changes to suppress warning messages
#=========================
#V1.1
#Date 24 Jan 2010
#use of table padding to make table more readable
#
#V1.2 
#Date 11 April 2010
#add full code description, link to Google maps
#
#V1.3 5 Nov 2013
#New bootstrap layout
#
#V1.4 17 Oct 2015
#added json markup for Google                 

//*** new code starts here

//Openshift settings
        $usertable = "walks2_dec_2015";
             


define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT')); 
define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));


 function walkCode($walkcode="E") {
      switch ($walkcode)
    {
      case 'E':$returnValue = 'Easy';
      break;
      case  'EA':$returnValue = 'Easy Access';
      break;
      case 'L':$returnValue = 'Leisurely';
      break;
      case 'M':$returnValue = 'Moderate';
    break;    
      case 'S':$returnValue = 'Strenuous';
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
      case 'C':$returnValue = 'Circular';
      break;
      
      case 'L':$returnValue = 'Linear';
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
try {

  
    //$dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    /*** echo a message saying we have connected ***/
$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
$dbh = new PDO($dsn, DB_USER, DB_PASS);

           
                $query="SELECT walkid,walkdate,briefdescription,exp,startgridref,starttime,grade,longerdescription, miles,lon,lat,routetype
                  FROM walks2_dec_2015
        where walkdate>=date(now())-1
        order by walkdate";
       
    $oldmonth="";

  foreach ($dbh->query($query) as $row)
        {
                        $d=formatday($row['walkdate']);
                        $m=formatmonth($row['walkdate']);
                        $y=formatyear($row['walkdate']);

                        //-------------make unix timestamp for formatting---------------------
                        $timestamp=mktime(0,0,0,substr($row['walkdate'],5,2),substr($row['walkdate'],8,2),substr($row['walkdate'],0,4));
                        $formatteddate=date("F Y",$timestamp);
                        
                        //---------------if month changes, add a new row----------------
                        if ($oldmonth!=$m)
                                {
                                        print("<tr> <td colspan=\"4\"><b>$formatteddate</b></td>    </tr>");
                                }
                        $oldmonth=$m;
                                                
                       
                        //$formatteddate=date("l jS ",$timestamp)." of ".date("F",$timestamp);
                        $formatteddatetime=date("l",$timestamp)."<br>".date("jS",$timestamp)." of ".date("F",$timestamp)."<br>Time: ".$row[starttime];
                        
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

/*
      <div class="row x">
        <div class="col-sm-offset-1 col-sm-2">Date</div>
        <div class="col-sm-2">Details</div>
        <div class="col-sm-2">Map</div>
        <div class="col-sm-4">Description</div>
      </div>
*/                        
                        if ($old!="Old") 
                                {
                                
                                    $startgridref = str_replace(" ","_",$row['startgridref']);

                                    //print("<tr id=\".$row['walkid'].\">");
                                    print("<div class=\"row $row[walkid]\">");
                                    //print("<tr id=\"$row[walkid]\">");
                                    //print("<td>$formatteddatetime");
                                    print("<div class=\"col-sm-offset-1 col-sm-2\".$formatteddatetime\">");
                                    //print("</td>");
                                    //print("<td>$row[briefdescription]<br><br>Miles: $row[miles]"."  ".routeType($row[routetype])."<br><br>Grade: ".walkCode($row['grade']));
                                    print("<div class=\"col-sm-2\"$row[briefdescription]<br><br>Miles: $row[miles]"."  ".
                                      routeType($row[routetype])."<br><br>Grade: ".walkCode($row['grade'])."</div>");
                                    //print("</td>");
                                    
                                    /*print("<td><a href=\"http://streetmap.co.uk/grid/$mapgridref\" target=\"_blank\" >$startgridref</a><br><br>");
                                        if ($row['lat'] <>"") {
                                        print("<a href=\"http://maps.google.co.uk/?q=".$row['lat'].",".$row['lon']
                                        ."(See%20Description%20for%20departure%20details)&amp;z=16&amp;t=k\" target=\"_blank\">Satellite</a><br>");
                                        }

                                        print("<br>Map ".$row[exp]."</td>");
                                    */                                        
                                    print("<div class=\"col-sm-2\"<a href=\"http://streetmap.co.uk/grid/$mapgridref\" target=\"_blank\" >$startgridref</a><br><br>");
                                        if ($row['lat'] <>"") {
                                        print("<a href=\"http://maps.google.co.uk/?q=".$row['lat'].",".$row['lon']
                                        ."(See%20Description%20for%20departure%20details)&amp;z=16&amp;t=k\" target=\"_blank\">Satellite</a><br>");
                                        }
                                    
                                    print("<br>Map ".$row[exp]."</td>");
                                    print(">");

                                    //print("<td>$row[longerdescription]&nbsp;");
                                    print("<div class=\"col-sm-4\"<$row[longerdescription]&nbsp;");
                                    print("</div>");
                                    print("</div");
                                    

                                }
        }
/*** close database  ***/
        $dbh = null;        
    }  
 
catch(PDOException $e)
    {
    echo $e->getMessage();
    }        

}   

function createJson()
{

$usertable = "walks2_dec_2015";
/*

define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT')); 
define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));  */

try {
    
$dbh = null; 
$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
$dbh = new PDO($dsn, DB_USER, DB_PASS);

//1 count records
          $queryCnt="SELECT count(*)".
                  " FROM $usertable".
        " where walkdate>=date(now())-1";
$res = $dbh->query($queryCnt);
$rowcount=$res->fetchcolumn();
 

//2 list records
                $query="SELECT walkid,walkdate,briefdescription,exp,startgridref,starttime,grade,".
                "longerdescription, miles,lon,lat,routetype,Location".
                  " FROM $usertable".
        " where walkdate>=date(now())-1".
        " order by walkdate";
//print("test message after query defined");      
 
//print('total rows'.$rowcount);
print('[');

$ctr=0;

  foreach ($dbh->query($query) as $row)
        {
            $ctr++;
//print("in the loop");    
$briefdescription=$row['briefdescription'];
//print($briefdescription);
$longerdescription=$row['longerdescription'];


$newdate=strtotime($row['walkdate']);
$newdate2 = date('Y-m-d',$newdate);


$starttime=$row['starttime'];
$newdate2=$newdate2."T".$starttime;


$miles=$row['miles'];

$location=$row['Location'];
$lat=$row['lat'];
$lon=$row['lon'];
$grade=walkCode($row['grade']);
$longerdescription=$longerdescription.' Miles: '.$miles. ' Grade:'.$grade;

if ($ctr < $rowcount)
    {$rowSeparator=',';}
else
    {$rowSeparator='';}


print("
            {
                \"@context\" : \"http://schema.org\",  
                \"@type\" : \"SocialEvent\",
                \"name\" : \"$briefdescription\",
                \"description\" : \"$longerdescription\",
                \"startdate\" : \"$newdate2\",
                \"location\" : {
                \"@type\" : \"EventVenue\",
                \"name\" : \"$location\",
                \"address\" : \"$location\",
                \"geo\" :  {
                \"@type\" : \"GeoCoordinates\",
                \"latitude\" : \"$lat\",
                \"longitude\" : \"$lon\"
                          }
                              },
            \"offers\" : {
              \"@type\" : \"Offer\",
              \"url\" : \"#$row[walkid]\",
              \"Price\" : \"0.00\"
                        }
            }
        $rowSeparator");
    }
    print(']'); 
    
 
 } 
catch(PDOException $e)
    {
    echo $e->getMessage();
    }        
}




createTable();
             
?>

</table>
</div> 
</div> 
</div>
<script type="application/ld+json"> 

<?php 
createJson();
  ?>
</script>
</body>
</html>
