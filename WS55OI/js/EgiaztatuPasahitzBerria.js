function egiaztatu(){
	var eposta = document.getElementById("eposta").value;
	var kodea = document.getElementById("berKodea").value;
	var pasahitza = document.getElementById("pasahitza").value;
	var pasahitza2 = document.getElementById("pasahitza2").value;
	if (eposta!="" && kodea!="" && pasahitza!="" && pasahitza2!=""){
		if(pasahitza.length >= 8){
			if(pasahitza == pasahitza2){
				return true;
			}else{
				alert("Bi pasahitzak ez dira berdinak.");
				return false;
			}
		}else{
			alert("Pasahitzak gutxienez 8ko luzera izan behar du.");
			return false;
		}
	}else {
		alert("Eremu guztiak bete behar dira.");
		return false;
	}
}