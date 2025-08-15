<html>
<head>
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/arsh/css/plugins.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/arsh/css/main.css') }}" />
   
     <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
</head>
<body>
<center><h1>Payment Details</h1></center>
<div class="container">
  <div class="row">
    <div class="col">
      <?php  echo "<center>";
    
    for($i = 0; $i < $dataSize; $i++) 
    {
        $information=explode('=',$decryptValues[$i]);
        if($i==3)	$order_status=$information[1];
	
    }

    if($order_status==="Success")
    {
        echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
        
    }
    else if($order_status==="Aborted")
    {
        echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
    
    }
    else if($order_status==="Failure")
    {
        echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
    }
    else
    {
        echo "<br>Security Error. Illegal access detected";
    
    }

    echo "<br><br>";

    echo "<table class='table table-bordered'>";
    for($i = 0; $i < $dataSize; $i++) 
    {
        $information=explode('=',$decryptValues[$i]);
	if($i==24){ exit();}
            echo '<tr><td>'.str_replace('_',' ',$information[0]).'</td><td>'.urldecode($information[1]).'</td></tr>';
    }

    echo "</table><br>";
    echo "</center>"; ?>
    </div>
  </div>
</div>
</body>
</html>