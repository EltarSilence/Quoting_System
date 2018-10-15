$(document).ready(function() {
	var sc = new Scommessa();

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

		var output = '<hr><div class="row"><div class="col-xs-12"><b>Verifica di'+materia+'</b></div></div><div class="row"><div class="col-xs-8"><i>'+persona+': '+tipo+' '+value+'</i> - </div><div class="col-xs-4"><b>'+quota+'</b> <i class="icon icon-exacoin"></i></div></div>';
		$("#multipla").append(output);
	}



	sc.getQuotaFinale();
});