<head>
<title>Artist Army</title>
<link rel="stylesheet" type="text/css" href="../assets/css/scam.css">
</head>
<body>
<?php 
  include_once("Mobile_Detect.php");
  $artist_id = $_REQUEST['artist_id'];
  $user_id = $_REQUEST['user_id'];
 
  $detect = new Mobile_Detect();
 if($detect->isAndroid()) {
?>
     <div class="container" style="overflow:hidden;">
  <div class="innermain" id="innermain">
    <div class="innerright">
      <div class="truemain" id="defContent"> <img src="" id="tracking_url" style="display:none" width="0px" height="0px">
        <div class="_ncontainer">
          <div class="_nheader"> <img src="../assets/logo.png" class="_nlogo"></div>
          <div class="_ncontent">
            <div><a href="Artist Army://com.cti.artistarmy?artist_id=<?php echo $artist_id;?>&user_id=<?php echo $user_id;?>&type=3" class="discover pb-button playhandle" id= "linkid"> android</a> </div>

            <div id="div-gpt-ad-1393854463579-0" style="width: 100%;text-align: center;position: relative;z-index: 10;"> </div>
             <div class="_ngroup ">
                <a href="Artist Army://com.cti.artistarmy?artist_id=<?php echo $artist_id;?>&user_id=<?php echo $user_id;?>&type=3" class="dnapp-button">android</a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
  }elseif ($detect->isIphone()) { ?>

   <div class="container" style="overflow:hidden;">
  <div class="innermain" id="innermain">
    <div class="innerright">
      <div class="truemain" id="defContent"> <img src="" id="tracking_url" style="display:none" width="0px" height="0px">
        <div class="_ncontainer">
          <div class="_nheader"> <img src="../assets/logo.png" class="_nlogo"></div>
          <div class="_ncontent">
            <div><a href="artistarmy://?artist_id=<?php echo $artist_id;?>&user_id=<?php echo $user_id;?>&type=3" class="discover pb-button playhandle" id= "linkid"> ios</a> </div>

            <div id="div-gpt-ad-1393854463579-0" style="width: 100%;text-align: center;position: relative;z-index: 10;"> </div>
             <div class="_ngroup ">
                <a href="artistarmy://?artist_id=<?php echo $artist_id;?>&user_id=<?php echo $user_id;?>&type=3" class="dnapp-button">ios</a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php  }

  elseif($detect->isGeneric()) {    
    echo "The app is not available in Windows device at this time. ";
   }
   else{
      echo '<script type="text/javascript">
    window.location.href="http://google.com"</script>';
   echo "web site";
   }  
?>


</body>


<script type="text/javascript">
  window.onload=function(){
    //document.getElementById("linkid").click();
};
</script>



