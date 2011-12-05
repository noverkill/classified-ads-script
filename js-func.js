function setCookie(c_name,value,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name) {
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++) {
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name) return unescape(y);
	}
}

function shform (id) {
	var fr = document.getElementById(id);
	if (fr.style.display == 'none') {
		fr.style.display = 'table';
		setCookie (id, 'on', 1000);
		document.getElementById('hide-form').innerHTML = '';
	} else {
		fr.style.display = 'none';
		setCookie (id, 'off', 1000);
		document.getElementById('hide-form').innerHTML = 'Show Search Form';
	};
}

function lform (id) {
	var fr = document.getElementById(id);
	var shform = getCookie(id);			
	if (shform != null) {
		if (shform == 'off') {
			fr.style.display = 'none';
			document.getElementById('hide-form').innerHTML = 'Show Search Form';
		} else {
			document.getElementById('hide-form').innerHTML = '';
			fr.style.display = 'table';
		}
	}
}
		
function textCounter (field, maxlimit, countfield) {
	var f = document.getElementById(field);
	var l = maxlimit - f.value.length;
	if (l < 0) f.style.border = '2px solid red';
	else f.style.border = '1px solid #AAAAAA';
	document.getElementById(countfield).value = l;	
}
