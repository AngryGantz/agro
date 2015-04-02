function Vu(i) {
    if (typeof(document.getElementById(i))=='object') {
        return document.getElementById(i);
    }
    var elements = new Array();
    for (var i = 0; i < arguments.length; i++) {
    var element = arguments[i];
    if (typeof(element) == 'string') element = document.getElementById(element);
    if (arguments.length == 1) return element;
    elements.push(element);
    }
    return elements;
}
function Vu(ID) {return document.getElementById(ID);}
function Vup(ID) {return window.parent.document.getElementById(ID);}

function cDialog() {
	$('#Dmid').remove();
	$('#Dtop').fadeOut('fast', function() {
		$('#Dtop').remove();
		Es();
	});
}


function map_cDialog() {map_sDialog('Dtop', 100,  '-');}
function map_sDialog(i, v, t) {
	if(t == '+') {
		if(isIE) {Vu(i).style.filter = 'Alpha(Opacity='+v+')';} else {Vu(i).style.opacity = v/100;}
		if(v == 100) {Eh(); return;}
		if(v+25 < 100) {window.setTimeout(function(){map_sDialog(i, v+25, t);}, 1);} else {map_sDialog(i, 100, t);}
	} else {
		try{Vu(i).style.display = 'none'; document.body.removeChild(Vu('Dtop')); Vu('Dmid').style.display = 'none'; document.body.removeChild(Vu('Dmid')); Es();} catch(e){}
	}
}


function get_code() 
{
	var CodeFile = "do.php";
	if(document.getElementById("imgid"))document.getElementById("imgid").innerHTML = '<img src="'+CodeFile+'?act=chkcode&'+Math.random()+'" alt="Кликните для обновления" style="cursor:pointer;border:0;vertical-align:top;" onclick="this.src=\''+CodeFile+'?act=chkcode&\'+Math.random()"/>'
}

function getObject(objectId) 
{ 
	if(document.getElementById && document.getElementById(objectId)) { 
		return document.getElementById(objectId); 
	} 
	else if (document.all && document.all(objectId)) { 
		return document.all(objectId); 
	} 
	else if (document.layers && document.layers[objectId]) { 
		return document.layers[objectId]; 
	} 
	else { 
		return false; 
	} 
} 

function showHide(e,objname)
{     
    var obj = getObject(objname); 
    if(obj.style.display == "none"){ 
        obj.style.display = "block"; 
        e.className="xias"; 
    }else{ 
        obj.style.display = "none"; 
        e.className="rights"; 
    }
}

function is_complex_password(str) {
	var n = str.length;
	if ( n < 6 ) { return false; }
	var cc = 0, c_step = 0;
	for (var i=0; i<n; ++i) {
		if ( str.charCodeAt(i) == str.charCodeAt(0) ) {
			++ cc;
		}
		if ( i > 0 && str.charCodeAt(i) == str.charCodeAt(i-1)+1) {
			++ c_step;
		}
	}
	if ( cc == n || c_step == n-1) {
		return false;
	}
	return true;
}