<!-- 
<!DOCTYPE html>
<html>
<body>  
	
	<%
		apikey = "yourapikey"
		address = "https://api.textlocal.in/send/?"
		message = "This is your message"
		message = Server.urlencode(message)
		numbers = "918123456789"
		sender = "TXTLCL"
		url = address & "apikey=" & apikey & "&numbers=" & numbers & "&message=" & message & "&sender=" & sender 
		set xmlhttp = CreateObject("MSXML2.ServerXMLHTTP")
		xmlhttp.open "POST", url, false
		xmlhttp.send ""
		msg = xmlhttp.responseText
		response.write(msg)
		set xmlhttp = nothing
	%>
 
</body>
</html> -->