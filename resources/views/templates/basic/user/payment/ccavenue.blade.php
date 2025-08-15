<html>
<body>
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
</head> 
<body>    
<div class="col-md-6 mb-4" style="cursor: pointer">
                                    <div class="card">
                                        <div class="card-body" style="height: 100px">
                                      <form action="{{route('ccav-request-andler')}}" id="form1" method="post"> 
                                        @csrf 
                                            <input type="hidden" name="tid" value="{{$orderid}}">
                                          <input type="hidden" name="merchant_id" value="3338339">
                                          <input type="hidden" name="order_id" value="{{$orderid}}">
					<input type="hidden" name="amount" value="{{getAmount($deposit->final_amo)}}">
                                            <!--<input type="hidden" name="amount" value="1">-->
                                          <input type="hidden" name="currency" value="INR">                                           
                                          <input type="hidden" name="redirect_url" value="{{route('ccavenue-response')}}">
                                                <input type="hidden" name="cancel_url" value="{{route('paymentccavenue')}}">
 <input type="hidden" name="language" value="EN">
                                     
                                       <button class="btn btn-block click-if-alone" type="submit">
                                        <img width="200" src="{{asset('public/assets/front-end/img/ccavenue.jpg')}}" style="margin-top: -24px;"/>
                                        </button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                <script language='javascript'>
document.getElementById("form1").submit();

</script>
</body>
</html>