function openExternal(){if(!document.getElementsByTagName){return }var A=document.getElementsByTagName("a");for(var B=0;B<A.length;B++){var C=A[B];if(C.getAttribute("href")&&C.getAttribute("rel")=="external"){C.target="_blank"}}}window.onload=openExternal;