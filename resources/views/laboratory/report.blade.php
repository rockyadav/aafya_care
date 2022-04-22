<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://mypropertyguardians.co.in/mprg/web/assets/css/bootstrap.css">

<style type="text/css">
    body{
    margin-top:20px;
    color: #484b51;
}
.text-secondary-d1 {
    color: #728299!important;
}
.page-header {
    margin: 0 0 1rem;
    padding-bottom: 1rem;
    padding-top: .5rem;
    border-bottom: 1px dotted #e2e2e2;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -ms-flex-align: center;
    align-items: center;
}
.page-title {
    padding: 0;
    margin: 0;
    font-size: 1.75rem;
    font-weight: 300;
}
.brc-default-l1 {
    border-color: #dce9f0!important;
}

.ml-n1, .mx-n1 {
    margin-left: -.25rem!important;
}
.mr-n1, .mx-n1 {
    margin-right: -.25rem!important;
}
.mb-4, .my-4 {
    margin-bottom: 1.5rem!important;
}

hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1);
}

.text-grey-m2 {
    color: #27282a!important;
}

.text-success-m2 {
    color: #86bd68!important;
}

.font-bolder, .text-600 {
    font-weight: 600!important;
}

.text-110 {
    font-size: 110%!important;
}
.text-blue {
    color: #478fcc!important;
}
.pb-25, .py-25 {
    padding-bottom: .75rem!important;
}

.pt-25, .py-25 {
    padding-top: .75rem!important;
}
.bgc-default-tp1 {
    background-color: rgba(121,169,197,.92)!important;
}
.bgc-default-l4, .bgc-h-default-l4:hover {
    background-color: #f3f8fa!important;
}
.page-header .page-tools {
    -ms-flex-item-align: end;
    align-self: flex-end;
}

.btn-light {
    color: #757984;
    background-color: #f5f6f9;
    border-color: #dddfe4;
}
.w-2 {
    width: 1rem;
}

.text-120 {
    font-size: 120%!important;
}
.text-primary-m1 {
    color: #4087d4!important;
}

.text-danger-m1 {
    color: #dd4949!important;
}
.text-blue-m2 {
    color: #68a3d5!important;
}
.text-150 {
    font-size: 150%!important;
}
.text-60 {
    font-size: 60%!important;
}
.text-grey-m1 {
    color: #7b7d81!important;
}
.align-bottom {
    vertical-align: bottom!important;
}




</style>

<div class="page-content container" >
    <div class="container px-0">
        <div class="row mt-4">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="row" style="background-color: #fff;">
                    <div class="col-12">
                        <div class="text-left text-150">
                            <span class="text-default-d3" style="text-align: left !important;">
                                <img src="https://aafya.care/public/frontassets/images/logo.png" style="width: 200px;" alt="" class="ic-logo1" ></span>

                        </div>
                    </div>
                </div>
                <!-- .row -->
                <!--  <div class="download-r notprint">
                    <a onclick="generatePDF();" style="cursor: pointer;right:180px;float: right;color: #ffffff;cursor: pointer;font-weight: 800;font-size: 14px; line-height:border: 1px solid #223c50; padding: 6px 14px;border-radius: 5px; background-color: #0291d2">Download</a>
                  </div> -->

                <hr class="row brc-default-l1 mx-n1 mb-4" />
                <div class="row"> <h5><b style="color: #11abe5;">Test Report for RT-PCR Covid-19</b></h5></div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="text-grey-m2">
                             <div class="my-2">
                              <span class="text-600 text-90">Name:</span> 
                               <span class="txt-val"> : <?php echo $user->name; ?></span>
                            </div>
                         <?php
                            $from  = new DateTime($user->dob);
                            $to    = new DateTime('today');
                            $myage = $from->diff($to)->y;

                           /* # procedural
                            echo date_diff(date_create($user->dob), date_create('today'))->y;*/
                            ?>

                             <div class="my-2">
                              <span class="text-600 text-90">Age/Gender:</span>
                              <span class="txt-val"> : <?php echo $myage."/".$user->gender; ?> </span>
                            </div>

                             <div class="my-2">
                              <span class="text-600 text-90">ID/Passport No</span> 
                              <span class="txt-val"> :  <?php echo $user->id_passport_no; ?></span>
                            </div>

                             <div class="my-2">
                              <span class="text-600 text-90">Referred By</span> 
                              <span class="txt-val"> : N/A </span>
                            </div>

                             <div class="my-2">
                              <span class="text-600 text-90">Registered Location</span> 
                              <span class="txt-val"> : <?php echo $user->city_name; ?> </span>
                            </div>

                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                        <hr class="d-sm-none" />
                        <div class="text-grey-m2">

                            <div class="my-2"> <span class="text-600 text-90">Sample Id</span> : <?php echo $user->registration_no; ?> </div>

                            <div class="my-2"><span class="text-600 text-90">Registered Lab Code</span> :  AS1001</div>

                            <div class="my-2"> <span class="text-600 text-90">Sample Collected On </span> :  <?php echo $user->sample_collect_date; ?></div>

                             <div class="my-2"> <span class="text-600 text-90">Sample Received On </span> :  <?php echo $user->sample_submitted_date; ?></div>

                              <div class="my-2"> <span class="text-600 text-90">Sample Released On </span> : <?php echo $user->report_generated_date; ?></div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>


                <div class="row" style="padding-top: 30px;">
                    <h5><b style="color: #11abe5;">Report Details</b></h5>
                </div>

                <div class="mt-4">
                    <div class="row">
                    <div class="col-sm-12">
                        <div class="text-grey-m2">

                   @if($report!='')

                     @php 
                        $rarray = array();
                        $rarray =json_decode($report->p_values);
                      @endphp

                      

                       @foreach ($rarray as $key => $value)
                    
                           @php 
                            $valname = Helper::getTableRow('course_perameters',array('id'=>$key));
                           @endphp
                            <div class="my-2" @if($value=="Detected" || $value=="Not Detected") style="border: 1px solid; background-color: #11abe5; color: #fff;" @endif>
                              <span class="text-600 text-90">{{$valname->name}}</span> 
                              <span class="txt-val"> :  {{$value}}</span>
                            </div>

                              @endforeach
                            
                            @endif

                        </div>
                    </div>
                    <!-- /.col -->
                  </div>
                </div>


              <div class="row" style="padding-top: 20px;">
                  <div class="col-sm-7"></div>

                  <div class="col-sm-5 text-right">
                     <p><span class="text-default-d3" style="text-align: left !important;">
                        <img src="https://aafya.care/public/icons/scan-img.png" style="width: 80px;" alt="" class="ic-logo1" ></span></p>

                    Reviewed By : <span>@if($report) {{$report->reviewed_by}} @endif</span>
                    

                  </div>
              </div>


             <div class="row" style="padding-top: 20px;">
                  <p style="padding: 10px; font-size: 13px; font-weight: 25px;"> Disclaimers:
                 <br>
                  1.RNA viruses like SARS-CoV-2 (COVID 19) have a lot of genetic variabilities and it’s possible that certain virus detection kits tests cannot detect some strains of the viruses. Although efforts were made by manufacturers of the diagnostic kits to design the test assays that target the parts of the viral genome which are shared by all the different circulating viral strains there still might be some mismatch between the primers and the probes used in the test and the target regions within the viruses. <br>
                  2. Sensitivity of this test results depends upon the quality of the sample submitted for the testing stage of infection type of the specimen collected for testing medical history and clinical presentation. <br>
                  3. All approved kits being used also may have different positive and negative predictive values leading to a mismatch of results. <br> 
                  4. A careful consideration to a combination of epidemiological factors stage of infection clinical history examination other relevant investigation findings and treatment history should be done when interpreting test results. <br>
                  5. Current knowledge about novel coronaviruses is evolving and more studies may be required for further evaluation and review of facts indicated in this report.</p>
              </div>



              <div class="row" style="background-color: #11abe5; padding-bottom: 10px;">
                  <div class="col-sm-12">
                    <p style="padding-top: 10px; font-size: 15px; font-weight: 25px; color: #fff;"> Take care of yourself and protect other by wearing mask, keeping 6ft social distance and frequently washing hand with soap and water.</p> </div>
              </div>

               <div class="row" style="padding-bottom: 50px;">
                  <div class="col-sm-12">
                    </div>
              </div>


            </div>
        </div>
    </div>
</div>
 <script src="https://mypropertyguardians.co.in/mprg/web/assets/js/jquery.min.js"></script>
<script type="text/javascript">
     function generatePDF() {     
        $('.notprint').hide();
        window.print();
        //window.close();
    }
</script>