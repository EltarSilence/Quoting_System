class Scommessa{
	constructor(){
		this.list = new Array();
		this.getCookie();
		this.cookieChecker();
	}
	addMultipla(chiave, type, value, quota){
		if(chiave != "" && type != "" && value != "" && quota != "" && quota > 0){
			var index = -1;
			for(let i = 0; i < this.size(); i++){
				if(this.list[i]['chiave'] == chiave){
					index = i;
				}
			}
			if(index >= 0){
				for(let i = index; i < this.size(); i++){
					this.list[i] = this.list[i + 1]
				}
				this.list.pop();
			}
			var a = new Array();
			a['chiave'] = chiave;
			a['type'] = type;
			a['value'] = value;
			a['quota'] = quota;
			this.list.push(a);
			this.setCookie();
		}else{
			//dai un errore
		}
	}
	removeMultipla(chiave){
		if(chiave != ""){
			var index = -1;
			for(let i = 0; i < this.size(); i++){
				if(this.list[i]['chiave'] == chiave){
					index = i;
				}
			}
			if(index >= 0){
				for(let i = index; i < this.size(); i++){
					this.list[i] = this.list[i + 1]
				}
				this.list.pop();
				this.setCookie();
			}else{
				//non esiste non ho nulla da rimuovere
			}
		}else{
			//dai un errore
		}
	}
	scommetti(coin){
		if(this.size() > 0 && coin != ""){
			var formdata = new FormData();
			formdata.append("coin", coin);
			for(var i = 0; i < this.size(); i++){
				var s = this.list[0]['chiave']+"|"+this.list[0]['type']+"|"+this.list[0]['value'];
				formdata.append("multiple", s);	
			}
			$.ajax({
				url: "sendData.php",
				type: 'POST',
				data: formdata,
				processData: false,
				contentType: false,
				beforeSend: function(){
					//show eventuale loader
				},
				success: function (data){
					//hide eventuale loader
					debugger;
					
					this.list = new Array();
					this.setCookie();
				},
				error: function(er){
					//show errori
					console.log(er);
					debugger;
				}
			});
		}else{
			//dai un errore
		}
	}
	size(){
		return this.list.length;
	}
	getMultipla(i){
		return this.list[i];
	}
	getQuotaFinale(){
		var f = 1;
		for(let i = 0; i < this.size(); i++){
			f = f * parseFloat(this.list[i]['quota']);
		}
		return f.toFixed(2);
	}
	readCookie() {
		var name = "quoting=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}
	getCookie(){
		var c = this.readCookie();
		if(c != "null"){
			var l = c.split("|");
			for(var i = 0; i < l.length - 1; i++){
				var d = l[i].split(":");
				var a = new Array();
				a['chiave'] = d[0];
				a['type'] = d[1];
				a['value'] = d[2];
				a['quota'] = d[3];
				this.list.push(a);
				var el = $("input[data-value='"+d[2]+"'][data-type='"+d[1].substr(0, 1)+"'][name='"+d[0]+"']", parent.top.$("#scom").contents());
				if(el.length > 0){				
					el[0].checked = true
					$(el).parent().addClass("active");
				}
			}
		}
	}
	setCookie() {
		var d = new Date();
		d.setTime(d.getTime() + (24*60*60*1000));
		var val = "";
		for(var i = 0; i <  this.size(); i++){
			val += this.list[i]['chiave'] + ":" +
			this.list[i]['type'] + ":" +
			this.list[i]['value'] + ":" +
			this.list[i]['quota'] + "|";
		}
		document.cookie = "quoting=" + (val == "" ? null : val) + ";" + "expires="+ d.toUTCString() + ";path=/";
	}
	cookieChecker(){
		parent.top.$("#scom")[0].contentWindow.onmessage = function(e){
			var e = $("input", parent.top.$("#scom").contents());
			for(var i = 0; i < e.length; i ++){
				e[i].checked = false;
				$(e[i]).parent().removeClass("active");
			}
			var name = "quoting=";
			var decodedCookie = decodeURIComponent(document.cookie);
			var ca = decodedCookie.split(';');
			var coockie = "";
			for(var i = 0; i <ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') {
					c = c.substring(1);
				}
				if (c.indexOf(name) == 0) {
					coockie = c.substring(name.length, c.length);
				}
			}
			if(coockie != "null"){
				var l = coockie.split("|");
				for(var i = 0; i < l.length - 1; i++){
					var d = l[i].split(":");
					
					var el = $("input[data-value='"+d[2]+"'][data-type='"+d[1].substr(0, 1)+"'][name='"+d[0]+"']", parent.top.$("#scom").contents());
					if(el.length > 0){				
						el[0].checked = true
						$(el, parent.top.$("#scom").contents()).parent().addClass("active");
					}
				}
			}
		}
		parent.top.$("#biglietto")[0].contentWindow.onmessage = function(e){	
			parent.top.$("#biglietto")[0].src += "";	
		}
	}
}