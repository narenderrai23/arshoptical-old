<html>
<head>
<script>


</script>
</head>
<body onload="document.forms['member_signup'].submit()">
<form method="post" name="member_signup" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<input type="hidden" name="encRequest" value="{{$encrypted_data}}">
<input type="hidden" name="access_code" value="{{$access_code}}">
</form>
</body>
</html>