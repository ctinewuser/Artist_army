   <!-- Footer -->

      <footer class="sticky-footer bg-white">

        <div class="container my-auto">

          <div class="copyright text-center my-auto">

            <span>Copyright &copy; Artist Army 2021</span>

          </div>

        </div>

      </footer>

      <!-- End of Footer -->



    </div>

    <!-- End of Content Wrapper -->

  </div>

  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->

  <a class="scroll-to-top rounded" href="#page-top">

    <i class="fas fa-angle-up"></i>

  </a>

  <!-- Logout Modal-->

  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

      <div class="modal-content">

        <div class="modal-header">

          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>

          <button class="close" type="button" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">×</span>

          </button>

        </div>

        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>

        <div class="modal-footer">

          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

          <a class="btn btn-primary" href="login.html">Logout</a>

        </div>

      </div>

    </div>

  </div>
  <?php $siteUrlUri = $this->uri->segment('2'); ?>
 <!-- Bootstrap core JavaScript-->

  <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>

  <!-- class test JavaScript-->
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>


  <!-- Core plugin JavaScript-->

  <script src="<?php echo base_url(); ?>assets/js/jquery.easing.min.js"></script>



  <!-- Custom scripts for all pages-->

  <script src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>



  <!-- Page level plugins -->

  <script src="<?php echo base_url(); ?>assets/js/Chart.min.js"></script>



  <!-- Page level custom scripts -->

  <script src="<?php echo base_url(); ?>assets/js/demo/chart-area-demo.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/demo/chart-pie-demo.js"></script>

           <!-- Page level plugins -->

  <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap4.min.js"></script>

  
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/dropzone.css">
<script src="<?php echo base_url(); ?>assets/js/dropzone.js"></script>
 


  <!-- Page level custom scripts -->

  <script src="<?php echo base_url(); ?>assets/js/demo/datatables-demo.js"></script>

<script src="<?php echo base_url();?>assets/js/toastr.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/toastr.min.css">

 <script src="<?php echo base_url();?>assets/js/dobpicker.js"></script>
<?php if($siteUrlUri == "dashboard"){?> 
  <!-- Page level plugins -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 
 <?php } ?>
<script>
  function checkNumberStatus(){
    //alert("came");
var phone=$(".phone-no").val();// value in field email
var country=$(".country-code").val();// value in field email
var user_type=$(".user_type").val();// value in field email
$.ajax({
    type:'post',
        url:'<?php echo base_url();?>home/checknumber',// put your real file name 
        data:{phone:phone,country:country,user_type:user_type},
        success:function(msg){
        //alert(msg); // your message will come here.     
        if(msg==1) {
            $(".submitternamee").text("Mobile Number Already Exists");
             document.getElementById("myBtn1").disabled = true;
          
        }
        else
        {
             $(".submitternamee").text("");
          document.getElementById("myBtn1").disabled = false;
         
        }
        }
 });
}

function checkMailStatus(){
    //alert("came");
var email=$(".email").val();// value in field email
var user_type=$(".user_type").val();// value in field email
$.ajax({
    type:'post',
        url:'<?php echo base_url();?>home/checkmail',// put your real file name 
        data:{email:email,user_type:user_type},
        success:function(msg){
        //alert(msg); // your message will come here.     
        if(msg==1) {
            $(".submittername").text("Email Already Exists");
           document.getElementById("myBtn1").disabled = true;
         
        }
        else
        {
             $(".submittername").text("");
         document.getElementById("myBtn1").disabled = false;
         
        }
        }
 });
}

 
</script>

<script>
            $(document).ready(function() {
                $.dobPicker({
                    daySelector: '#dobday', /* Required */
                    monthSelector: '#dobmonth', /* Required */
                    yearSelector: '#dobyear', /* Required */
                    dayDefault: 'Day', /* Optional */
                    monthDefault: 'Month', /* Optional */
                    yearDefault: 'Year', /* Optional */
                    minimumAge: 18, /* Optional */
                    maximumAge: 80 /* Optional */
                });
            });
        </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
 $("#datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  });


<?php if($this->session->flashdata('success')){ ?>

    toastr.success("<?php echo $this->session->flashdata('success'); ?>");

<?php }else if($this->session->flashdata('error')){  ?>

    toastr.error("<?php echo $this->session->flashdata('error'); ?>");

<?php }else if($this->session->flashdata('warning')){  ?>

    toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");

<?php }else if($this->session->flashdata('info')){  ?>

    toastr.info("<?php echo $this->session->flashdata('info'); ?>");

<?php } ?>

</script>

 <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);
  
      function drawVisualization() {
           var jsonData = $.ajax({
                type: "GET",
                url: "<?php echo base_url('admin/graph_chart/');?>",
                dataType: "json",
                async: false
                }).responseText;

                var json = JSON.parse(jsonData);
                var arr = [];
                arr.push( ['Month', 'Artist', 'Fan']);
                $.each(json.year,function(i,v){
                  arr.push(
                    [json.year[i]+'/'+json.month[i], json.customer[i],json.driver_price[i]]);
                });
        var data = google.visualization.arrayToDataTable(arr);
        var options = {
          title : '',
          vAxis: {title: 'Prices'},
          hAxis: {title: 'Year/Month'},
          seriesType: 'bars',
          series: {5: {type: 'line'}},
           animation:{
            duration: 1500,
            startup: true //This is the new option
          },
        };
        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    
<!-- 
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
     google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawMultSeries);

function drawMultSeries() {
      var data = new google.visualization.DataTable();
      data.addColumn('timeofday', 'Years');
      data.addColumn('number', 'Fans');
      data.addColumn('number', 'Artist');

      data.addRows([
        [{v: [8, 0, 0], f: '10'}, 1, .25],
        [{v: [9, 0, 0], f: '20'}, 2, .5],
        [{v: [10, 0, 0], f:'10'}, 3, 1],
        [{v: [11, 0, 0], f: '15'}, 4, 2.25],
        [{v: [12, 0, 0], f: '10'}, 5, 2.25],
        [{v: [13, 0, 0], f: '12'}, 6, 3],
        [{v: [14, 0, 0], f: '30'}, 7, 4],
        [{v: [15, 0, 0], f: '25'}, 8, 5.25],
        [{v: [16, 0, 0], f: '18'}, 9, 7.5],
        [{v: [17, 0, 0], f: '10'}, 10, 10],
      ]);

      var options = {
       title: '',
        hAxis: {
          title: '',
          // format: 'h:mm a',
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          }
        },
        vAxis: {
          title: ''
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_div'));

      chart.draw(data, options);
    }
    </script>

    
   -->
   </body>
</html>

 <script type="text/javascript">
     $('#select_user').on('change', function() {
  var value = $(this).val();
  if(value == 1){
    $('.artistclass').css('display','block');
  }else{
     $('.artistclass').css('display','none');
  }

});
 </script>

 <script type="text/javascript">

 Dropzone.options.myDropzone = {
            url: "<?php echo base_url('admin/uploadfolder_songs'); ?>",
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 100,
            acceptedFiles: "image/*,audio/*",

            init: function () {

                var submitButton = document.querySelector("#submit-all");
                var wrapperThis = this;

                submitButton.addEventListener("click", function () {
                    wrapperThis.processQueue();
                });

                this.on("addedfile", function (file) {

                    // Create the remove button
                    var removeButton = Dropzone.createElement("<button class='btn btn-danger btn-sm mt-2 w-100'>Remove</button>");

                    // Listen to the click event
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();

                        // Remove the file preview.
                        wrapperThis.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                    });

                    // Add the button to the file preview element.
                    file.previewElement.appendChild(removeButton);
                });

                this.on('sendingmultiple', function (data, xhr, formData) {

                    //formData.append("Username", $("#Username").val());

                });

               this.on("success", function (file) {
                  var idvar = $.trim(file.xhr.response);

                    if(idvar == 1){
                       toastr.success("Data Deleted Successfully!");
                       window.location.href = "<?php echo base_url('admin/uploadfolder');?>";
                    }

                    if(idvar == 0){
                       toastr.error("Something Went Wrong.!");
                       window.location.href = "<?php echo base_url('admin/uploadfolder');?>";
                    }


                  console.log(idvar,file);
                  //window.location.replace("/admin/ShopList);
              });
            }
        };


 </script>
<!-- 
 <script type="text/javascript">
       google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Artist', 'Fans'],
          ['Artist',     11],
          ['Fans',      2],
          ['Credits',  2],
         
          ['Followers',    7]
        ]);

        var options = {
          title: ''
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
 </script>   -->
 <?php if($siteUrlUri == "dashboard"){?> 
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
     var jsonData = $.ajax({
                type: "GET",
                url: "<?php echo base_url('admin/total_revence/')?>",
                dataType: "json",
                async: false
                }).responseText;
                var json = JSON.parse(jsonData);

        var data = google.visualization.arrayToDataTable([
          ['Artist', 'Fans'],
          ['Artist', json.user],
          ['Fans', json.follower],
          ['Friends', json.friends]
      
        ]);

        var options = {
          title: '',
            is3D: true,
        
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

              chart.draw(data, options);
}

    </script>
    <?php } ?>