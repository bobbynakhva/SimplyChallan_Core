@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
<!-- Blocks section Here -->
<div class="common__section">
   <div class="container-fluid">
      <div class="divided__common__body">
         <div class="side__sticky">
            <ul class="common__sidebar__wrapper">
               <li class="common__sideitems" >
                  <a href="{{ route('challan.create') }}" class="active">
                    New challan
                  </a>
               </li>
               <li class="common__sideitems">
                  <a href="b{{ route('challan.edit') }}">
                     Edit challan
                  </a>
               </li>
               <li class="common__sideitems">
                  <a href="{{ route('challan.inward') }}">
                     Inward challan
                  </a>
               </li>
               <li class="common__sideitems">
                  <a href="{{ route('challan.reports') }}">
                     Reports
                  </a>
               </li>
         </div>

         <div class="common__body">
        <h2 class="cmn__title text-center">
            DELIVERY CHALLAN FOR JOBWORK
        </h2>
        <p class="text-center">
            Under Rule 55 of the Central Goods and Service Tax Rules, 2017.
        </p>

        <div class="border p-3">
            <div class="row">
                <div class="col-md-6">
                    <strong>Name of the Consignor:</strong> OUR COMPANY NAME <br>
                    <strong>Address:</strong> OUR COMPANY ADDRESS <br>
                    <strong>GSTIN No.:</strong> OUR COMPANY GST NUMBER
                </div>
                <div class="col-md-6 text-end">
                    <strong>CHALLAN SR. NO.:</strong> 306/2021-22 <br>
                    <strong>CHALLAN DATE:</strong> 22.02.2022
                </div>
            </div>
        </div>

        <div class="common__body__section pb-4">
            <h4 class="pt-3">PART - I</h4>
            <table class="table table-bordered mt-3">
                <thead class="table-light">
                    <tr>
                        <th>Description of Inputs/Partially Processed Inputs</th>
                        <th>HSN Code</th>
                        <th>Quantity (Kgs)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12MM HEX LEAD FREE BRASS</td>
                        <td>74072120</td>
                        <td>224.800</td>
                    </tr>
                    <tr>
                        <td>Other Material</td>
                        <td>0</td>
                        <td>0.000</td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Vehicle No.</th>
                        <td>VEHICLE NUMBER</td>
                    </tr>
                    <tr>
                        <th>No of Packages</th>
                        <td>0</td>
                    </tr>
                    <tr>
                        <th>Value of Inputs/Partially Processed Goods</th>
                        <td>120268</td>
                    </tr>
                    <tr>
                        <th>Rate of Tax</th>
                        <td>CGST @ 9%, SGST @ 9%</td>
                    </tr>
                    <tr>
                        <th>Tax Amount</th>
                        <td>CGST: 10824.00, SGST: 10824.00, Total Tax: 21648.00</td>
                    </tr>
                    <tr>
                        <th>Purpose</th>
                        <td>Turning</td>
                    </tr>
                    <tr>
                        <th>Name of the Jobworker</th>
                        <td>Industry Name</td>
                    </tr>
                    <tr>
                        <th>Address of the Jobworker</th>
                        <td>Client Industry Name</td>
                    </tr>
                    <tr>
                        <th>GSTIN No. of Jobworker</th>
                        <td>Client GST Number</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="common__body__section pb-4">
            <h4 class="pt-3">PART - II</h4>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Date of Despatch of Finished Goods</th>
                        <td>To Parent's Factory</td>
                    </tr>
                    <tr>
                        <th>Quantity Returned</th>
                        <td>Rod / Finish Good / Semi Finish Good</td>
                    </tr>
                    <tr>
                        <th>Waste Scrap Returned</th>
                        <td>Generated Scrap</td>
                    </tr>
                    <tr>
                        <th>Waste & Scrap Not Recoverable</th>
                        <td>Burning Loss / Washing Loss</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- <div class="text-center">
            <strong>FOR, OUR COMPANY NAME</strong> <br>
            <span>PLACE: JAMNAGAR, STATE: GUJARAT, STATE CODE: 24</span> <br>
            <span>DATE: 22.02.2022</span> <br>
            <strong>AUTHORISED SIGNATORY</strong>
        </div> -->
        <div class="border p-3">
            <div class="row">
                <div class="col-md-6">
                    <strong>FOR, OUR COMPANY NAME</strong> <br>
                     <span>PLACE: JAMNAGAR, STATE: GUJARAT, STATE CODE: 24</span> <br>
                     <span>DATE: 22.02.2022</span> <br>
                </div>
                <div class="col-md-6 text-end">
                    <strong>AUTHORISED SIGNATORY</strong>
                </div>
            </div>
        </div>

        <!-- <div class="text-end mt-4">
            <button class="btn btn-primary" onclick="window.print()">Print</button>
            <button class="btn btn-success">Download</button>
        </div> -->
        <div class=" mt-4 text-center">
        <div class="align-items-center gap-3">
                                       <a onclick="window.print()" class="cmn__btn">
                                          <span>
                                             <i class="material-symbols-outlined">
                                                print
                                             </i>
                                          </span>
                                          <span class="print">
                                             Print
                                          </span>
                                       </a>
                                       <a href="print.html" class="cmn__btn">
                                          <span>
                                             <i class="material-symbols-outlined">
                                                download
                                             </i>
                                          </span>
                                          <span class="print">
                                             Download
                                          </span>
                                       </a>
                                    </div>
                                 </div>
    </div>
</div>


         <!-- <div class="common__body">
            <h2 class="cmn__title text-center">
               DELIVERY CHALLAN FOR JOBWORK
            </h2>
            <p class="text-center">
               Under Rule 55 of the Central Goods and Service Tax Rules, 2017.
           </p>
            
             <div class="border p-3">
                  <div class="row">
                      <div class="col-md-6">
                          <strong>Name of the Consignor:</strong> OUR COMPANY NAME <br>
                          <strong>Address:</strong> OUR COMPANY ADDRESS <br>
                          <strong>GSTIN No.:</strong> OUR COMPANY GST NUMBER
                      </div>
                      <div class="col-md-6 text-end">
                          <strong>CHALLAN SR. NO.:</strong> 306/2021-22 <br>
                          <strong>CHALLAN DATE:</strong> 22.02.2022
                      </div>
                  </div>
              </div>

            <div class="common__body__section pb__60">
               <div class="common__body__head pb__20">
                  <h4>
                     PART - I                               
                  </h4>
                  <ul class="nav nav-pills" id="pills-tabblocks" role="tablist">
                     <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-homeblocks" type="button" role="tab" aria-controls="pills-homeblocks" aria-selected="true">
                           Preview
                        </button>
                     </li>
                     <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profileblcoks" type="button" role="tab" aria-controls="pills-profileblcoks" aria-selected="false">
                        Html Code
                        </button>
                     </li>
                  </ul>
               </div>
               <div class="tab-content" id="pills-tabContentre">
                  <div class="tab-pane fade show active" id="pills-homeblocks" role="tabpanel" aria-labelledby="pills-home-tab">
                     <section class="order__section pt__60 pb__60">
                        <div class="container">
                           <div class="row">
                              <div class="col-xxl-8 col-xl-10 col-lg-12">
                                 <div class="order__wrappers invoice__wrapper">
                                    <div class="invoice__textwrapper mb__30">
                                       <div class="invoice__leftbox">
                                          <h3>
                                             Invoice
                                          </h3>
                                          <div class="invoice__leftnumber">
                                             <span class="bage">
                                                Description of inputs/partially processed inputs:        
                                             </span>
                                             <span class="counting">
                                                325546744
                                             </span>
                                          </div>
                                          <div class="invoice__leftnumber">
                                             <span class="bage">
                                                Order Date   
                                             </span>
                                             <span class="counting">
                                                07/11/2025
                                             </span>
                                          </div>
                                          <div class="invoice__leftnumber">
                                             <span class="bage">
                                                Payment Method
                                             </span>
                                             <span class="counting">
                                                Credit Card
                                             </span>
                                          </div>
                                       </div>
                                       <div class="invoice__righttbox">
                                          <span class="hirename">
                                             Hire's Nmae:
                                          </span>
                                          <h5 class="name">
                                             Leslie Alexander
                                          </h5>
                                          <div class="invoice__leftnumber">
                                             <span class="bage">
                                                Age
                                             </span>
                                             <span class="counting">
                                                21
                                             </span>
                                          </div>
                                          <div class="invoice__leftnumber">
                                             <span class="bage">
                                                Phone
                                             </span>
                                             <span class="counting">
                                                (684) 555-0102
                                             </span>
                                          </div>
                                          <div class="invoice__leftnumber">
                                             <span class="bage">
                                                Email
                                             </span>
                                             <span class="counting">
                                                <a href="https://pixner.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="fd938b89d3948e8e89d393888998bd9a909c9491d39e9290">[email&#160;protected]</a>
                                             </span>
                                          </div>
                                          <div class="invoice__leftnumber">
                                             <span class="bage">
                                                Address
                                             </span>
                                             <span class="counting">
                                                Royal Ln. Mesa, New Jersey
                                             </span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="order__summary__wrapper mb__40">
                                       <div class="over__responsive">
                                       <h5 class="summary__title">Order Summary</h5>
                                       <div class="order__table__fluid">
                                          <div class="order__table__items bg__add">
                                             <span>
                                                Recipient No
                                             </span>
                                             <span>
                                                Operrator
                                             </span>
                                             <span>
                                                Receive amount
                                             </span>
                                             <span>
                                                Amount
                                             </span>
                                          </div>
                                          <div class="order__table__items">
                                             <span>
                                                (406) 555-0120
                                             </span>
                                             <span>
                                                AT & T
                                             </span>
                                             <span>
                                                $4531.00
                                             </span>
                                             <span>
                                                $4531.00
                                             </span>
                                          </div>
                                       </div>
                                       <div class="order__table__box">
                                          <div class="order__graph">
                                             <ul>
                                                <li>
                                                   <span>Sub Total:</span>
                                                   <span class="bg">$4531.00</span>
                                                </li>
                                                <li>
                                                   <span>Promotional Code:</span>
                                                   <span class="bg">0</span>
                                                </li>
                                                <li>
                                                   <span>Total:</span>
                                                   <span class="bg">$4531.00</span>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                       </div>
                                    </div>
                                    <div class="getway__wrapper">
                                       <div class="getway__item">
                                          <span class="trnsdate fz-18 fw-400">
                                             Transaction Date :
                                          </span>
                                          <span class="subtrans">
                                             05/12/2020
                                          </span>
                                       </div>
                                       <div class="getway__item">
                                          <span class="trnsdate fz-18 fw-400">
                                             Gateway :
                                          </span>
                                          <span class="subtrans">
                                             Credit Card
                                          </span>
                                       </div>
                                       <div class="getway__item">
                                          <span class="trnsdate fz-18 fw-400">
                                             Transaction ID :
                                          </span>
                                          <span class="subtrans">
                                             321 565 954
                                          </span>
                                       </div>
                                       <div class="getway__item">
                                          <span class="trnsdate fz-18 fw-400">
                                             Amount :
                                          </span>
                                          <span class="subtrans">
                                             $362.00
                                          </span>
                                       </div>
                                    </div>
                                    <p class="note">
                                       Note : This is computer generated receipt and does not require physical signature.
                                    </p>
                                    <div class="print__point__btn d-flex align-items-center gap-3">
                                       <a href="print.html" class="cmn__btn">
                                          <span>
                                             <i class="material-symbols-outlined">
                                                print
                                             </i>
                                          </span>
                                          <span class="print">
                                             Print
                                          </span>
                                       </a>
                                       <a href="print.html" class="cmn__btn">
                                          <span>
                                             <i class="material-symbols-outlined">
                                                download
                                             </i>
                                          </span>
                                          <span class="print">
                                             Download
                                          </span>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                  </div>
                  <div class="tab-pane fade" id="pills-profileblcoks" role="tabpanel" aria-labelledby="pills-profile-tab">
                     <pre><code class="language-markup"></code></pre>
                  </div>
               </div>
            </div>
            
         </div> -->
      </div>
   </div>
</div>
<!-- Blocks section End -->




   <!--Jquery 3 6 0 Min Js-->
   <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery-3.6.0.min.js"></script>
   <!--Bootstrap bundle Js-->
   <script src="assets/js/bootstrap.bundle.min.js"></script>
   <!--Viewport Jquery Js-->
   <script src="assets/js/viewport.jquery.js"></script>
   <!--Odometer min Js-->
   <script src="assets/js/odometer.min.js"></script>
   <!--date picker Js-->
   <script src="assets/js/bootstrap-datepicker.js"></script>
   <!--Magnifiw Popup Js-->
   <script src="assets/js/jquery.magnific-popup.min.js"></script>
   <!--nice select Js-->
   <script src="assets/js/jquery.nice-select.min.js"></script>
   <!--Wow min Js-->
   <script src="assets/js/wow.min.js"></script>
   <!--Owl carousel min Js-->
   <script src="assets/js/owl.carousel.min.js"></script>
   <!--Prijm Js-->
   <script src="assets/js/prism.js"></script>
   <!--main Js-->
   <script src="assets/js/main.js"></script>

</body>


<!-- Mirrored from pixner.net/rechargio/rechargio/blocks-invoice.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 25 Feb 2025 15:07:39 GMT -->
</html>