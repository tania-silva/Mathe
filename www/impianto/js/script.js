window.onload = function() {
    var links = document.getElementsByTagName('a');
    for (var i=0;i < links.length;i++) {
        if (links[i].className == 'nw') {
            links[i].onclick = function() {
                window.open(this.href);
                return false;
            };
        }
    }
};

$(document).ready(function(){
	$('.bxslider').bxSlider({
	  auto: true,
	  pager: false
	});
});

$('.bxslider').bxSlider({
  auto: true,
  autoControls: true
});

function makelink( name, domain, desc, pre, post ) {
    if ( pre != null && pre != "" )
        document.write( pre );
    
    document.write( '<a href="mailto:' );
    document.write( name + '&#64;' );
    document.write( domain + '">' );
    
    if ( desc != null && desc != "" )
        document.write( desc )
    else
        document.write( name + '&#64;' + domain );
    
    document.write( '</a>' );
    
    if ( post != null && post != "" )
        document.write( post );
}

function modify(ogg,str) {
	if (ogg.value==str) {
		ogg.value="";
		ogg.click();
	}
}

function restore(ogg,str) {
	if (ogg.value=="") {
		ogg.value=str;
	}
}

function showhidd( idblk ) {
	if (document.getElementById(idblk).style.display=='block') {
		document.getElementById(idblk).style.display='none';
	} else {
		document.getElementById(idblk).style.display='block';
	}
}

function shid( idblk ) {
	if (document.getElementById(idblk).style.display=='block') {
		document.getElementById(idblk).style.display='none';
	} else {
		document.getElementById(idblk).style.display='block';
	}
}


function morizzshow(idblk) {
	var silly01="lo_"+idblk;
	var silly02="slo_"+idblk;

	//document.getElementById('slo_test').style.display='none';
	document.getElementById('slo_mn01').style.display='none';
	document.getElementById('slo_mn02').style.display='none';
	document.getElementById('slo_partnership').style.display='none';
	document.getElementById('slo_info').style.display='none';
	document.getElementById('slo_pm').style.display='none';
	
	//document.getElementById('lo_test').style.backgroundColor='transparent';
	document.getElementById('lo_mn01').style.backgroundColor='transparent';
	document.getElementById('lo_mn02').style.backgroundColor='transparent';
	//document.getElementById('lo_video').style.backgroundColor='transparent';
	document.getElementById('lo_partnership').style.backgroundColor='transparent';
	document.getElementById('lo_info').style.backgroundColor='transparent';
	document.getElementById('lo_pm').style.backgroundColor='transparent';

	document.getElementById(silly02).style.display='block';
	document.getElementById(silly01).style.backgroundColor='#164652';
}

function morizzhidd(idblk) {
	var silly01="lo_"+idblk;
	var silly02="slo_"+idblk;
	document.getElementById(silly02).style.display='none';
	document.getElementById(silly01).style.backgroundColor='transparent';
}

function vd_info(vdcode) {
	var silly01="bttinfom"+vdcode;
	var silly02="bttinfol"+vdcode;
	var silly03="info"+vdcode;
	document.getElementById(silly01).style.display='none';
	document.getElementById(silly02).style.display='block';
	document.getElementById(silly03).style.display='block';
}

function vd_info1(vdcode) {
	var silly01="bttinfom"+vdcode;
	var silly02="bttinfol"+vdcode;
	var silly03="info"+vdcode;
	document.getElementById(silly01).style.display='block';
	document.getElementById(silly02).style.display='none';
	document.getElementById(silly03).style.display='none';
}







//function previewLatex(txt,obj) {
//
//	if (document.getElementById(obj).style.display=='block') {
//		document.getElementById(obj).style.display='none';
//	} else {
//		document.getElementById(obj).style.display='block';
//		var text=document.getElementById(txt).value;
//
//		var dominio=document.domain;
//		var idblockname = obj;
//		var url = "./impianto/jquery/Rqst01.php?text="+text+"&rqst=1";
//
//		var xhr = makeXMLHttpRequest();
//		xhr.open("GET", url, true);
//		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
//		xhr.send(null); 
//
//	}
//}


function subTopic(obj) {
	document.getElementById('subtopic').style.display='none';
	
	if (obj) {
		document.getElementById('subtopic').style.display='block';

		var dominio=document.domain;
		var idblockname = "subtopic";
		var url = "./impianto/jquery/Rqst01.php?rqst=1&idTop="+obj;

		var xhr = makeXMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
		xhr.send(null); 
	}
}

function subTopic1(obj) {
	document.getElementById('subtopic').style.display='none';
	
	if (obj) {
		document.getElementById('subtopic').style.display='block';

		var dominio=document.domain;
		var idblockname = "subtopic";
		var url = "./impianto/jquery/Rqst01.php?rqst=2&idTop="+obj;

		var xhr = makeXMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
		xhr.send(null); 
	}
}

function subTopic2(obj) {
	document.getElementById('subtopic').style.display='none';
	
	if (obj) {
		document.getElementById('subtopic').style.display='block';

		var dominio=document.domain;
		var idblockname = "subtopic";
		var url = "./impianto/jquery/Rqst01.php?rqst=3&idTop="+obj;

		var xhr = makeXMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
		xhr.send(null); 
	}
}

function subTopic3(obj, TPOstr) {
	document.getElementById('subtopic').style.display='none';
	
	if (obj) {
		document.getElementById('subtopic').style.display='block';

		var dominio=document.domain;
		var idblockname = "subtopic";
		var url = "./impianto/jquery/Rqst01.php?rqst=4&idTop="+obj+"&TPOstr="+TPOstr;

		var xhr = makeXMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
		xhr.send(null); 
	}
}

function subTopic31(obj, TPOstr) {
	document.getElementById('subtopic').style.display='none';
	
	if (obj) {
		document.getElementById('subtopic').style.display='block';

		var dominio=document.domain;
		var idblockname = "subtopic";
		var url = "./impianto/jquery/Rqst01.php?rqst=5&idTop="+obj+"&TPOstr="+TPOstr;

		var xhr = makeXMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
		xhr.send(null); 
	}
}

function subTopic32(obj, TPOstr) {
	document.getElementById('subtopic').style.display='none';
	
	if (obj) {
		document.getElementById('subtopic').style.display='block';

		var dominio=document.domain;
		var idblockname = "subtopic";
		var url = "./impianto/jquery/Rqst01.php?rqst=7&idTop="+obj+"&TPOstr="+TPOstr;

		var xhr = makeXMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
		xhr.send(null); 
	}
}

function subTopic4(obj) {
	document.getElementById('subtopic').style.display='none';
	
	if (obj) {
		document.getElementById('subtopic').style.display='block';

		var dominio=document.domain;
		
		var idblockname = "subtopic";
		var url = "./impianto/jquery/Rqst05.php?rqst=1&idTop="+obj;

		var xhr = makeXMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
		xhr.send(null); 
		
		var idblockname1 = "keywords";
		var url1 = "./impianto/jquery/Rqst05.php?rqst=2&idTop="+obj;
		var xhr1 = makeXMLHttpRequest();
		xhr1.open("GET", url1, true);
		xhr1.onreadystatechange = function() {processResponse(xhr1, 'html', idblockname1);}
		xhr1.send(null); 
	}
}

function subTopic5(obj) {
	//document.getElementById('subtopic').style.display='none';
	
	if (obj) {
		document.getElementById('subtopic').style.display='block';

		var dominio=document.domain;
		var idblockname = "subtopic";
		var url = "./impianto/jquery/Rqst01.php?rqst=2&idTop="+obj;

		var xhr = makeXMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
		xhr.send(null); 
	}
}

function subTopic6(obj) {
	document.getElementById('subtopic').style.display='none';
	
	if (obj) {
		document.getElementById('subtopic').style.display='block';

		var dominio=document.domain;
		var idblockname = "subtopic";
		var url = "./impianto/jquery/Rqst01.php?rqst=6&idTop="+obj;

		var xhr = makeXMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
		xhr.send(null); 
	}
}

function keywords1(obj, idTop) {
	document.getElementById('keywords').style.display='none';
	
	if (obj) {
		document.getElementById('keywords').style.display='block';

		var dominio=document.domain;
		
		var idblockname1 = "keywords";
		var url1 = "./impianto/jquery/Rqst05.php?rqst=3&idTop="+idTop+"&idSub="+obj;
		var xhr1 = makeXMLHttpRequest();
		xhr1.open("GET", url1, true);
		xhr1.onreadystatechange = function() {processResponse(xhr1, 'html', idblockname1);}
		xhr1.send(null); 
	}
}

function subTopicSFA(obj) {
	document.getElementById('subtopic').style.display='none';
	
	if (obj) {
		document.getElementById('subtopic').style.display='block';

		var dominio=document.domain;
		var idblockname = "subtopic";
		//var url = "./impianto/jquery/Rqst02.php?rqst=1&idTop="+obj;
		var url = "./impianto/jquery/Rqst02.php?rqst=1&idTop="+obj;
		//alert(url);

		var xhr = makeXMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
		xhr.send(null); 
	}
}

function subTopicSFA1(obj) {
	document.getElementById('subtopic').style.display='none';
	
	if (obj) {
		document.getElementById('subtopic').style.display='block';

		var dominio=document.domain;
		var idblockname = "subtopic";
		//var url = "./impianto/jquery/Rqst02.php?rqst=2&idTop="+obj;
		var url = "./impianto/jquery/Rqst02.php?rqst=2&idTop="+obj;

		var xhr = makeXMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
		xhr.send(null); 
	}
}


function qstPoint(param,obj) {

	if (param && obj) {

		var dominio=document.domain;
		//var url = "./impianto/jquery/Rqst03.php?rqst=1&point="+obj;
		var url = "./impianto/jquery/Rqst03.php?rqst=1&param="+param+"&point="+obj;

		var xhr = makeXMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
		xhr.send(null); 
	}
}


function studRqstStatus(blk, param) {
	if (blk &&param) {

		var dominio=document.domain;
		var idblockname = blk;
		var url = "./impianto/jquery/Rqst04.php?rqst=1&param="+param;

		var xhr = makeXMLHttpRequest();
		xhr.open("GET", url, true);
		xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
		xhr.send(null); 
	}
}




//function preview(txt,obj) {
//	var testo=document.getElementById(txt).value;
//	document.getElementById(obj).innerHTML=testo;
//}







function makeXMLHttpRequest(){
   var request=undefined;
   if(window.XMLHttpRequest){
      request=new XMLHttpRequest();
      if(request.overrideMimeType){
         request.overrideMimeType("text/xml");
      }
   }else{
      if(window.ActiveXObject){
         try{
            request=new ActiveXObject("Msxml2.XMLHTTP");
         }catch(e){
            try{
               request=new ActiveXObject("Microsoft.XMLHTTP");
            }catch(e){}
         }
      }
   }
   return request;
}

function ajaxCallback(){
  try{
	 if(xmlHttpRequest.readyState==4){
	 //risposta completa
		if(xmlHttpRequest.status==200){
		   //risposta positiva
		   var text=xmlHttpRequest.responseText;
		   var doc=xmlHttpRequest.responseXML;
		   alert('Arriva a questo punto del callback?');
			  //document.getElementById('content').innerHTML=text;
		}else{
		   //404 (Not Found)
		   if(xmlHttpRequest.status==404){alert('404: Not Found'); }
		   //500 (Internal Server Error)
		   else if(xmlHttpRequest.status==500){alert('500: Internal Server Error'); }
		   //altro errore
		   else{alert(xmlHttpRequest.status+': '+xmlHttpRequest.statusText);}
		}
	 }else{
		//risposta in esecuzione
	 }
  }catch(e){
	 alert('Errore in callback function: '+e);
  }
}


function processResponse(xhr, responseType, idblockname) {
  //controlla lo stato della risposta


  if(xhr.readyState == 4 && xhr.status == 200)
  {

	   var html = xhr.responseText;
	   if(html) {
		   document.getElementById(idblockname).innerHTML = html;
	   }

  }
}

	//IPB: KEYWORDS TO QUESTIONS
	function keywordsQuestions(obj) {
		document.getElementById('subtopic').style.display='none';
		
		if (obj) {
			document.getElementById('subtopic').style.display='block';

			var dominio=document.domain;
			
			var idblockname = "subtopic";
			var url = "./impianto/jquery/Rqst05.php?rqst=4&idTop="+obj;

			var xhr = makeXMLHttpRequest();
			xhr.open("GET", url, true);
			xhr.onreadystatechange = function() {processResponse(xhr, 'html', idblockname);}
			xhr.send(null); 
			
			var idblockname1 = "keywords";
			var url1 = "./impianto/jquery/Rqst05.php?rqst=5&idTop="+obj;
			var xhr1 = makeXMLHttpRequest();
			xhr1.open("GET", url1, true);
			xhr1.onreadystatechange = function() {processResponse(xhr1, 'html', idblockname1);}
			xhr1.send(null); 
		}
	}

	//IPB: Get Keywords
	function keywords2(obj, idTop) {
		document.getElementById('keywords').style.display='none';
		
		if (obj) {
			document.getElementById('keywords').style.display='block';
	
			var dominio=document.domain;
			
			var idblockname1 = "keywords";
			var url1 = "./impianto/jquery/Rqst05.php?rqst=6&idTop="+idTop+"&idSub="+obj;
			var xhr1 = makeXMLHttpRequest();
			xhr1.open("GET", url1, true);
			xhr1.onreadystatechange = function() {processResponse(xhr1, 'html', idblockname1);}
			xhr1.send(null); 
		}
	}
