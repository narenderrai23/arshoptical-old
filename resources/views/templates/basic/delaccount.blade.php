@extends($activeTemplate.'layouts.frontend')
@section('content')

<section class="top-brands-section pt-60 pb-120">
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-12">
               <!--  <div class="section__header">
                    <h5 class="title">@lang('Delete Request')</h5>
                </div> -->
               <div class="loan-form-area pt-100 pb-100 mt-30">
         <!-- Container -->
         <div class="container">
            <!-- row -->
            <div class="row justify-content-center text-center">
               <!-- col -->
               <div class="col-lg-8 col-md-12 mb-50">
                                                   </div>
               <!-- /col -->
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="loan-form">
                     <div class="col-lg-12 col-md-12 mb-50">
                        <div class="section-title text-center">
                           <h2 class="title">Account Deletion</h2>
                           <div class="title-bdr">
                              <div class="left-bdr"></div>
                              <div class="right-bdr"></div>
                           </div>
                           <p></p>
                        </div>
                     </div>
                     <span id="errormsg"></span>
                     <div id="send-otp">
                     <form method="post">
                        <div class="row">
                           <div class="form-group">
                              <input type="text" name="name" class="form-control" placeholder="Enter Name" id="name" required>
                           </div>
                           <!-- <div class="form-group">
                              <input type="text" name="impl" class="form-control" placeholder="Enter IMPL number" id="impl" required>
                           </div> -->
                           <div class="form-group">
                              <input type="tel" pattern="^[1-9]+[0-9]*$" maxlength="10" name="phone" class="form-control" placeholder="Enter Phone Number" id="phone" required>
                           </div>
                              <br>
                        </div>
                        <div class="row mt-20">
                           <div class="col-lg-4"></div>
                           <div class="col-lg-4">
                              <button type="button" onclick="with_validation()" class="btn btn--primary w-100 subscribe-btn" name="submit">
                              Submit
                              </button>
                           </div>
                           <div class="col-lg-4">
                           </div>
                        </div>
                        </form>
                     </div>
                  <!-- /row -->
               </div>
            </div>
            <!-- /Container -->
         </div>
      </div>
      </div>
            </div>
        </div>

    </div>
</section>
@endsection