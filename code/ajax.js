function callajax(url, id_container){
var request_page = false
if (window.XMLHttpRequest) {
request_page = new XMLHttpRequest()
} else if (window.ActiveXObject){ 
try {
request_page = new ActiveXObject("Msxml2.XMLHTTP")
} 
catch (e){
try{
request_page = new ActiveXObject("Microsoft.XMLHTTP")
}
catch (e){}
}
}
else
return false
request_page.onreadystatechange=function(){
loadpage(request_page, id_container)
}
request_page.open('GET', url, true)
request_page.send(null)
}


function loadpage(request_page, id_container){
if (request_page.readyState == 4 && (request_page.status==200 || window.location.href.indexOf("http")==-1))
document.getElementById(id_container).innerHTML=request_page.responseText
}
