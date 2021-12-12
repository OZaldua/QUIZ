var liked = false;
var disliked = false;
function like(id){
	var l = document.getElementById("like");
	if(liked == true){ //Like-a emana zegoen, beraz orain kendu nahi da.
		l.style.color = "";
		liked = false;
		$("#dislike").css("pointer-events", "auto"); //Berraktibatu dislike-a
		//Like kopuruen testua dektrementatu
		var kop = document.getElementById("like_kop").innerText;
		var kopBerria = parseInt(kop, 10) - 1; //Dekrementatzeko testua zenbaki bihurtu
		document.getElementById("like_kop").innerHTML = " " + kopBerria + " ";
	}else{ //Like eman da
		l.style.color = "blue"; //Kolore urdinez like-a sakatua izan dela adierazi
		liked = true;
		$("#dislike").css("pointer-events", "none"); //Dislike-a desaktibatu
		//Like kopuruen testua inkrementatu
		var kop = document.getElementById("like_kop").innerText;
		var kopBerria = parseInt(kop, 10) + 1;
		document.getElementById("like_kop").innerHTML = " " + kopBerria + " ";
	}
	
	//Datu-basean like kopurua eguneratzeko
	xhr.open("POST", "../php/manageLikes.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("action=liked&plus=" + liked + "&id=" + id);
	
}
function dislike(id){
	var l = document.getElementById("like");
	var dl = document.getElementById('dislike');
	if(disliked == true){ //Dislike-a kendu
		dl.style.color = "";
		disliked = false;
		$("#like").css("pointer-events", "auto");
		//Disike kopuruen testua dekrementatu
		var kop = document.getElementById("dislike_kop").innerText;
		var kopBerria = parseInt(kop, 10) - 1;
		document.getElementById("dislike_kop").innerHTML = " " + kopBerria + " ";
	}else{ //Dislike-a sakatu
		dl.style.color = "blue";
		disliked = true;
		$("#like").css("pointer-events", "none");
		//Disike kopuruen testua inkrementatu
		var kop = document.getElementById("dislike_kop").innerText;
		var kopBerria = parseInt(kop, 10) + 1;
		document.getElementById("dislike_kop").innerHTML = " " + kopBerria + " ";
	}
	
	xhr.open("POST", "../php/manageLikes.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("action=disliked&plus=" + disliked + "&id=" + id);
}