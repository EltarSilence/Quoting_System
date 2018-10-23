$(document).ready(function() {
	var sc = new Scommessa();
	update();

	$("i").on("click", function(){
		var k = $(this).parents("ul").attr("data-key");
		sc.removeMultipla(k);
		$(this).parents("ul").remove();
		var h = $("body", parent.top.$("#biglietto").contents())[0].scrollHeight;
		parent.top.$("#biglietto").height(h);
		$("#quota_finale").html(sc.getQuotaFinale());
    $("#vincita").html(Math.round(sc.getQuotaFinale()*parseInt($("#importo").val())*100)/100);
		parent.top.$("#scom")[0].contentWindow.postMessage("cookieAreUpdated",'*');
	});

	$("#aum").on("click", function(){
		if ($("input#importo").val() < 10000)
			$("input#importo").val(parseInt($("input#importo").val())+100);
		$("#vincita").html(Math.round(sc.getQuotaFinale()*parseInt($("#importo").val())*100)/100);
	});

	$("#decr").on("click", function(){
		if ($("input#importo").val() >= 200)
			$("input#importo").val($("input#importo").val()-100);
		$("#vincita").html(Math.round(sc.getQuotaFinale()*parseInt($("#importo").val())*100)/100);
	});

	$("#scommetti").on("click", function(){
		sc.scommetti($("input#importo").val());
	});

  $("#importo").on("change", function(){
    if($(this).val() < 100){
      $(this).val(100);
    }
  });

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
	  $("#vincita").html(Math.round(sc.getQuotaFinale()*parseInt($("#importo").val())*100)/100);

		var h = $("body", parent.top.$("#biglietto").contents())[0].scrollHeight
		parent.top.$("#biglietto").height(h);
	}


});
parent.top.$("#biglietto")[0].contentWindow.onmessage = function(e){
	parent.top.$("#biglietto")[0].src += "";
}
