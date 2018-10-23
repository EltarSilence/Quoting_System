var sc = new Scommessa();
$(document).ready(function() {
	update();
	
	$("i").on("click", function(){
		var k = $(this).parents("ul").attr("data-key");
		sc.removeMultipla(k);
		$(this).parents("ul").remove();
		var h = $("body", parent.top.$("#biglietto").contents())[0].scrollHeight
		parent.top.$("#biglietto").height(h);
		$("#quota_finale").html(sc.getQuotaFinale());
		parent.top.$("#scom")[0].contentWindow.postMessage("cookieAreUpdated",'*');
	});
	
	$("#aum").on("click", function(){
		if ($("input#importo").val() < 10000)
			$("input#importo").val(parseInt($("input#importo").val())+100);
		$("#vincita").html(sc.getQuotaFinale()*parseInt($("input#Importo").val()));
	});

	$("#decr").on("click", function(){
		if ($("input#importo").val() >= 200)
			$("input#importo").val($("input#importo").val()-100);
		$("#vincita").html(sc.getQuotaFinale()*parseInt($("input#Importo").val()));
	});
	
	$("#scommetti").on("click", function(){
		sc.scommetti($("input#importo").val());
	});

});
parent.top.$("#biglietto")[0].contentWindow.onmessage = function(e){
	parent.top.$("#biglietto")[0].src += "";
}
function update(){
	$("#multipla").html("");
	for (var i = 0; i < sc.size(); i++) {
		var multiple = sc.getMultipla(i);

		var chiave = multiple.chiave;
		//materia_data_persona
		var ch_arr = chiave.split('_');
		var materia = ch_arr[0];
		var data = ch_arr[1];
		var persona = ch_arr[2];

		var quota = multiple.quota;
		var tipo = multiple.type;
		var value = multiple.value;

		var output = '<ul class="list-group list-group-flush" data-key="'+chiave+'"><li class="list-group-item">Verifica di ' + materia +'<br>' + persona+': '+tipo+' '+value+' <b>'+quota+'</b><i class="icon icon-cancel"></i></li></ul>';		

		$("#multipla").append(output);
	}
	$("#quota_finale").html(sc.getQuotaFinale());


	var h = $("body", parent.top.$("#biglietto").contents())[0].scrollHeight
	parent.top.$("#biglietto").height(h);
}
