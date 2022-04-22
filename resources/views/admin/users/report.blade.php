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
    color: #888a8d!important;
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

<div class="page-content container" style="padding-top: 20px;">
    <!-- <div class="page-header text-blue-d2">
        <h1 class="page-title text-secondary-d1">
            Invoice
            <small class="page-info">
                ID: #111-222
            </small>
        </h1>

        <div class="page-tools">
            <div class="action-buttons">
                <a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="Print">
                    Print
                </a>
                <a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="PDF">
                    Export
                </a>
            </div>
        </div>
    </div> -->

    <div class="container px-0">
        <div class="row mt-4">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="row" style="padding-top: 20px;">
                    <div class="col-12">
                        <div class="text-center text-150">
                            <span class="text-default-d3"><img src="https://mypropertyguardians.co.in/mprg/web//assets/images/header-logo.png" alt="" class="ic-logo" ></span>

                             <div class="download-r notprint">
				                <a onclick="generatePDF();" style="cursor: pointer;right:180px;float: right;color: #ffffff;cursor: pointer;font-weight: 800;font-size: 14px; line-height:border: 1px solid #223c50; padding: 6px 14px;border-radius: 5px; background-color: #0291d2">Download</a>
				              </div>



                        </div>
                    </div>
                </div>
                <!-- .row -->

                <hr class="row brc-default-l1 mx-n1 mb-4" />

                <div class="row">
                    <div class="col-sm-6">
                        <div>
                            <span class="text-sm text-grey-m2 align-middle">To:</span>
                            <span class="text-600 text-110 text-blue align-middle"><?php echo $user->name; ?></span>
                        </div>
                        <div class="text-grey-m2">
                            <div class="my-1">
                              <span class="text-600 text-90">Phone:</span> <?php echo $user->mobile; ?>
                            </div>
                            <div class="my-1">
                            	<span class="text-600 text-90">Email:</span>
                               <?php echo $user->email; ?>
                            </div>
                           <!--  <div class="my-1"><b class="text-600">111-111-111</b></div> -->
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                        <hr class="d-sm-none" />
                        <div class="text-grey-m2">

                            <div class="my-2"> <span class="text-600 text-90">Invoice ID:</span><?php echo $user->registration_no; ?> </div>

                            <div class="my-2"><span class="text-600 text-90">Issue Date:</span> <?php echo date('d-M-Y'); ?></div>

                            <div class="my-2"> <span class="text-600 text-90">Status:</span> <span class="badge badge-warning badge-pill px-25"><?php echo $user->test_id; ?></span></div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>

                <div class="mt-4">
                    <div class="row text-600 text-white bgc-default-tp1 py-25">
                        <div class="d-none d-sm-block col-1">#</div>
                        <div class="col-9 col-sm-5">Description</div>
                        <div class="d-none d-sm-block col-4 col-sm-2">Qty</div>
                        <div class="d-none d-sm-block col-sm-2">Unit Price ₹</div>
                        <div class="col-2">Amount ₹</div>
                    </div>

                    <div class="text-95 text-secondary-d3">

                <?php ?>
                        <div class="row mb-2 mb-sm-0 py-25">
                            <div class="d-none d-sm-block col-1">
                            	1</div>

                            <div class="col-9 col-sm-5">
                            	ccccc</div>
                            <div class="d-none d-sm-block col-2">1</div>

                            <div class="d-none d-sm-block col-2 text-95">
                            	34</div>

                            <div class="col-2 text-secondary-d2">
                            	3434</div>
                        </div>

                 

                    </div>

                    <div class="row border-b-2 brc-default-l2"></div>
                    <div class="row mt-3">
                        <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                            Extra note such as company or payment information...
                        </div>

                        <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                            <div class="row my-2">
                                <div class="col-7 text-right">
                                    SubTotal
                                </div>
                                <div class="col-5">
                                    <span class="text-120 text-secondary-d1">111</span>
                                </div>
                            </div>

                            <div class="row my-2">
                                <div class="col-7 text-right">
                                    Tax (18%)
                                </div>
                                <div class="col-5">
                                    <span class="text-110 text-secondary-d1">
                                       111
                                            
                                        </span>
                                </div>
                            </div>

                            <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                <div class="col-7 text-right">
                                    Total Amount
                                </div>
                                <div class="col-5">
                                    <span class="text-150 text-success-d3 opacity-2">111</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr />

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