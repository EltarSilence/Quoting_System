class Scommessa{
	constructor(){
		this.list = new Array();
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
			}else{
				//dai un errore	
			}
		}else{
			//dai un errore
		}
	}
	scommetti(coin){
		if(size() > 0 && coin != ""){
			var formdata = new FormData();
			formdata.append("coin", coin);
			formdata.append("multiple", this.list);
			
			$.ajax({
				url: "",
				type: 'POST',
				data: formdata,
				processData: false,
				contentType: false,
				beforeSend: function(){
					//show eventuale loader
				},
				success: function (data){
					//hide eventuale loader
				},
				error: function(er){
					//show errori
				}
			});
		}else{
			//dai un errore
		}
	}
	size(){
		return this.list.length;
	}
	getQuotaFinale(){
		var f = 1;
		for(let i = 0; i < this.size(); i++){
			f = f * this.list[i]['quota'];
		}
		return f;
	}
}
var sc = new Scommessa();
$(document).ready(function(){
	
	
});



