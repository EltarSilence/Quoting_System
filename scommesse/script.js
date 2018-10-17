$(document).ready(function (){
	var sc = new Scommessa();
	
	for(var i = 0; i < sc.size(); i++){
		var d = sc.getMultipla(i);
		var el = $("input[data-value='"+d['value']+"'][data-type='"+d['type'].substr(0, 1)+"'][name='"+d['chiave']+"']", parent.top.$("#scom").contents());
		if(el.length > 0){				
			el[0].checked = true
			$(el, parent.top.$("#scom").contents()).parent().addClass("active");
		}
	}
	
	$(".click").on("click", function(){
		var n = $("input[type=radio]", this).attr("name");
		var t = "UNDER";
		switch($("input[type=radio]", this).attr("data-type")){
			case "E":
				t = "ESATTO";
				break;
			case "O":
				t = "OVER";
				break;
		}
		var v = $("input[type=radio]", this).attr("data-value");
		var q = $("input[type=radio]", this).attr("data-quote");
		sc.removeMultipla(n);
		$(".click", $(".click input[name="+n+"]").parent().parent().parent()).removeClass("active");
		$.each($(".click input[name="+n+"]"), function($k, $v){
			$v.checked = false;
		});
		$("input[type=radio]", this)[0].checked = true
		$(this).addClass("active");
		sc.addMultipla(n, t, v, q);
		parent.top.$("#biglietto")[0].contentWindow.postMessage("cookieAreUpdated",'*');
	});
});
