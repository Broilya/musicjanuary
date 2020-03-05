//var ewd_domain = 'http://reclame.com.ua/'; //set domain 
var ewd_loading_img = '../images/loading.gif';//set image path 
var ewd_loading_msg = 'Loading';//set loading message 
var xmlhttp_obj = false;       

//create the XMLHttpRequest 
function ewd_xmlhttp(){ 
	if (window.XMLHttpRequest){ // if Mozilla, Safari etc 
		xmlhttp_obj = new XMLHttpRequest(); 
	}else if (window.ActiveXObject){ // if IE 
		try{ 
			xmlhttp_obj = new ActiveXObject("Msxml2.XMLHTTP"); 
		}catch (e){ 
			try{ 
				xmlhttp_obj = new ActiveXObject("Microsoft.XMLHTTP"); 
			}catch (e){ 
			} 
		} 
	}else{ 
		xmlhttp_obj = false; 
	} 
	return xmlhttp_obj; 
}    

//get content via GET 
function ewd_getcontent(url, containerid){ 
	var xmlhttp_obj = ewd_xmlhttp(); 
	document.getElementById(containerid).innerHTML = '<img src="' + ewd_loading_img + '" /> ' + ewd_loading_msg; 
	xmlhttp_obj.onreadystatechange=function(){ 
		ewd_loadpage(xmlhttp_obj, '', containerid); 
	} 
	xmlhttp_obj.open('GET', url, true); 
	xmlhttp_obj.send(null); 
}       
	
function ewd_loadpage(xmlhttp_obj, content, containerid){ 
	if ( xmlhttp_obj.readyState == 4 && xmlhttp_obj.status == 200 ){ 
		document.getElementById(containerid).innerHTML = xmlhttp_obj.responseText; 
	} 
}       
