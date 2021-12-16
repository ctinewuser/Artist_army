 
<head>
<title>Lucktto</title>
<link rel="stylesheet" type="text/css" href="../assets/css/scam.css">
</head>
<body>
<?php 
  include_once("Mobile_Detect.php");
  //$id = $_REQUEST['id'];
 // $user_id = $_REQUEST['user_id'];
 
  $detect = new Mobile_Detect();
 if($detect->isAndroid()) {
?>
<!--     <div class="container" style="overflow:hidden;">-->
<!--  <div class="innermain" id="innermain">-->
<!--    <div class="innerright">-->
<!--      <div class="truemain" id="defContent"> <img src="" id="tracking_url" style="display:none" width="0px" height="0px">-->
<!--        <div class="_ncontainer">-->

<!--          <div class="_nheader"> <img src="../assets/logo.png" class="_nlogo">-->
            <!-- <h1> Myparty <span>for Iphone</span></h1> -->
<!--          </div>-->
<!--          <div class="_ncontent">-->
            <!-- myparty://com.ctinfotech.hamro.nepali.music.activity/paymentSuccess-->
<!--            <div><a href="#" class="discover pb-button playhandle" id= "linkid"></a> </div>-->
<!--            <div id="div-gpt-ad-1393854463579-0" style="width: 100%;text-align: center;position: relative;z-index: 10;"> </div>-->
<!--             <div class="_ngroup ">-->

              <!--- https://itunes.apple.com/us/app/my-party-app/id1451059433?ls=1&mt=8-->
<!--              <a href="#" class="dnapp-button"> </a> </div>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->
<div><center><a class="discover pb-button playhandle"  id= "linkid" href="lucktto://com.lucktto.paypal">Success</a></center></div>

<?php
  }
 elseif($detect->isIphone()) {  
  
          //header("Location : lucktto://host/PaymentDone");
?>  
   <div><center><a class="discover pb-button playhandle"  id= "linkid" href="lucktto://host/PaymentDone">Success</a></center></div>
<!--     <script type="text/javascript">

alert("this is iphone");
</script> -->

<?php
  }
  elseif($detect->isGeneric()) {    
    echo "The app is not available in Windows device at this time. ";
  
   }
   else{
         ?>
         <div><center><a href="lucktto://host/PaymentDone">Success</a></center></div>


    <?php
 
   }  
?>


</body>


<script type="text/javascript">

  window.onload=function(){
  document.getElementById("linkid").click();
};
</script>



