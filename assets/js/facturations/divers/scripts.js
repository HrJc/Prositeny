jQuery(document).ready(function($) {

   $("#choisirBourika").click(function(){

        $('.facture_place').show();
       $('#facturationTbl > tbody').empty();
        var tableBody = document.getElementById("facturationBody");
        tableBody.innerHTML = ""; 
        var boutikChecked = new Array();

        $("input:checkbox[name=boutika]:checked").each(function(){
        	var temp = new Array()
            temp.push($(this).val());
        	var indice =temp[0].replace(/ /g,"_");
        	console.log(indice);
        	$("input[class=pu"+indice+"]").each(function(){
        		temp.push($(this).val());
        		
        		$("input[class=nb"+indice+"]").each(function(){
        			temp.push($(this).val());
        			    
        		});      
        	});
        	boutikChecked.push(temp);
        	//console.log(temp);
        	temp = undefined;
        	indice = undefined;
        });
		
    
		var nbrBoutikChecked = boutikChecked.length;
		//var boutikaList = JSON.stringify(boutikChecked);
		var nbrRedevance = 0;
     	var n = nbrBoutikChecked;
		while(n--)
		nbrRedevance += parseFloat(boutikChecked[n][2]) || 0;


		var totRedevance = 0;
     	var k = nbrBoutikChecked;
		while(k--)
		totRedevance += parseFloat(boutikChecked[k][1]) * parseFloat(boutikChecked[k][2]) || 0;

		//console.log(boutikaList);
        //var prixUnit = $("#prixUnit").html() ;
		//console.log(prixUnit);
		//var totHT = prixUnit * nbrBoutikChecked ;
		var totHT = totRedevance ;
        var tva = totHT * 20 / 100 ;
        var totTC = totHT + tva ;

        var totTLte = Math.abs(totTC);
        
        boutikChecked.forEach(CreatTbodyElem);
        $('#facturationModal').modal('hide'); 
        $('#valHT').html(totHT);
        $('#tva').html(tva);
        $('#ttc').html(totTC);
        $('#nbr').html(nbrRedevance);
        $('#prixUnit').html("--------");
        $('#montant').html(totHT);
       $('#ttcLettre').html(NumberToLetter(totTLte) + ' Ariary');

             
    });
    
    function CreatTbodyElem(element, index){
        var table = document.getElementById("facturationBody");
        var row = table.insertRow(0);
        var cell = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        cell.innerHTML = element[0] ;
        cell2.innerHTML = element[2] ;
        cell3.innerHTML = element[1] ;
        cell4.innerHTML = element[1] * element[2] ;
        
    }

    $('#typeFac').on('change', function() {
            if(this.value == 1) 
            {
            	var nFact = $('#numFacture_affiche').val();

               $('#numFacture_affiche').val("AV"+nFact.slice(3));
               $('#lttr').html(' ARRETE LA PRESENTE AVOIR A LA SOMME DE :');
            
            }else
            {
            	var nFact = $('#numFacture_affiche').val();

               $('#numFacture_affiche').val("SUP"+nFact.slice(2));
               $('#lttr').html(' ARRETE LA PRESENTE FACTURE A LA SOMME DE :');

            }
        $("#numFacture").val($('#numFacture_affiche').val());
        $('#valHT').html($('#valHT').html() * (-1));
        $('#tva').html($('#tva').html() * (-1));
        $('#ttc').html($('#ttc').html() * (-1));
     });

    $('#enregistre_facture').click(function(){
        var valHT =  Math.abs($('#valHT').html());
        var tva = Math.abs($('#tva').html());
        var totTC = Math.abs($('#ttc').html());
        var nbrBoutikChecked = $('#nbr').html();
        //var prixUnit = $('#prixUnit').html();
        var totHT = $('#montant').html();
        var ttcLettre = $('#ttcLettre').html()
        var url = $("#url_ajax").val(); //<?php echo site_url('facturation/DivCont/saveFacturationDivers'); ?>"
        var numFacture = $("#numFacture").val();
        var refClient = $('#refClient').val();
        var avoir = $('#typeFac').val();

       
        var boutikChecked = new Array();
        /*$("input:checkbox[name=boutika]:checked").each(function(){
            boutikChecked.push($(this).val());
        });*/
        //var tests =  new Array();

        //date Manuel
        var mois = $('#moisM').val();
        var annee = $('#anneeM').val();   
        var nomfounisseur =  $('#nomfrns').val();  
        
        console.log(nomfounisseur);
        $("input:checkbox[name=boutika]:checked").each(function(){
        	var temp = new Array()
            temp.push($(this).val());
            //tests.push(temp[0]);
        	var indice =temp[0].replace(/ /g,"_");
        	//console.log(indice);
        	$("input[class=pu"+indice+"]").each(function(){
        		temp.push($(this).val());
        		
        		$("input[class=nb"+indice+"]").each(function(){
        			temp.push($(this).val());
        			    
        		});      
        	});
        	if(temp[1]==""){
        		temp[1] = '0';
			}
			if(temp[2]==""){
        		temp[2] = '0';
			}
        	boutikChecked.push(temp);
        	//console.log(temp);
        	temp = undefined;
        	indice = undefined;
        });

        //var boutikaList = JSON.stringify(tests);
        var boutikaList = JSON.stringify(boutikChecked);

            //to save and load pdf
            data = {
                    boutika : boutikaList ,
                    valHT: valHT ,
                    tva: tva ,
                    totTC: totTC ,
                    nbrBoutikChecked: nbrBoutikChecked ,
                    prixUnit: "-----" ,
                    totHT: totHT ,
                    ttcLettre : ttcLettre ,
                    numFacture:numFacture ,
                    refClient:refClient,
                    moismd : mois,
                    anneemd : annee,
                    nomfrns : nomfounisseur,
                    avoir : avoir
                    }
                     
        /*console.log(data);
       	console.log(typeof data);
        console.log(url);*/

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            //dataType: "JSON",
            success: function(result) {
            	//console.log(result)
				window.location.replace(result);
            },
            error: function (e){
              console.log('error ajax'+ e);
            }
          });

   
    });

//************chiffre to number****************** */
function Unite( nombre ){
	var unite;
	switch( nombre ){
		case 0: unite = "zéro";		break;
		case 1: unite = "un";		break;
		case 2: unite = "deux";		break;
		case 3: unite = "trois"; 	break;
		case 4: unite = "quatre"; 	break;
		case 5: unite = "cinq"; 	break;
		case 6: unite = "six"; 		break;
		case 7: unite = "sept"; 	break;
		case 8: unite = "huit"; 	break;
		case 9: unite = "neuf"; 	break;
	}//fin switch
	return unite;
}//-----------------------------------------------------------------------

function Dizaine( nombre ){
	switch( nombre ){
		case 10: dizaine = "dix"; break;
		case 11: dizaine = "onze"; break;
		case 12: dizaine = "douze"; break;
		case 13: dizaine = "treize"; break;
		case 14: dizaine = "quatorze"; break;
		case 15: dizaine = "quinze"; break;
		case 16: dizaine = "seize"; break;
		case 17: dizaine = "dix-sept"; break;
		case 18: dizaine = "dix-huit"; break;
		case 19: dizaine = "dix-neuf"; break;
		case 20: dizaine = "vingt"; break;
		case 30: dizaine = "trente"; break;
		case 40: dizaine = "quarante"; break;
		case 50: dizaine = "cinquante"; break;
		case 60: dizaine = "soixante"; break;
		case 70: dizaine = "soixante-dix"; break;
		case 80: dizaine = "quatre-vingt"; break;
		case 90: dizaine = "quatre-vingt-dix"; break;
	}//fin switch
	return dizaine;
}//-----------------------------------------------------------------------

function NumberToLetter( nombre ){
	var i, j, n, quotient, reste, nb ;
	var ch
	var numberToLetter='';
	//__________________________________
	
	if(  nombre.toString().replace( / /gi, "" ).length > 15  )	return "dépassement de capacité";
	if(  isNaN(nombre.toString().replace( / /gi, "" ))  )		return "Nombre non valide";

	nb = parseFloat(nombre.toString().replace( / /gi, "" ));
	if(  Math.ceil(nb) != nb  )	return  "Nombre avec virgule non géré.";
	
	n = nb.toString().length;
	switch( n ){
		 case 1: numberToLetter = Unite(nb); break;
		 case 2: if(  nb > 19  ){
					   quotient = Math.floor(nb / 10);
					   reste = nb % 10;
					   if(  nb < 71 || (nb > 79 && nb < 91)  ){
							 if(  reste == 0  ) numberToLetter = Dizaine(quotient * 10);
							 if(  reste == 1  ) numberToLetter = Dizaine(quotient * 10) + "-et-" + Unite(reste);
							 if(  reste > 1   ) numberToLetter = Dizaine(quotient * 10) + "-" + Unite(reste);
					   }else numberToLetter = Dizaine((quotient - 1) * 10) + "-" + Dizaine(10 + reste);
				 }else numberToLetter = Dizaine(nb);
				 break;
		 case 3: quotient = Math.floor(nb / 100);
				 reste = nb % 100;
				 if(  quotient == 1 && reste == 0   ) numberToLetter = "cent";
				 if(  quotient == 1 && reste != 0   ) numberToLetter = "cent" + " " + NumberToLetter(reste);
				 if(  quotient > 1 && reste == 0    ) numberToLetter = Unite(quotient) + " cents";
				 if(  quotient > 1 && reste != 0    ) numberToLetter = Unite(quotient) + " cent " + NumberToLetter(reste);
				 break;
		 case 4 :  quotient = Math.floor(nb / 1000);
					  reste = nb - quotient * 1000;
					  if(  quotient == 1 && reste == 0   ) numberToLetter = "mille";
					  if(  quotient == 1 && reste != 0   ) numberToLetter = "mille" + " " + NumberToLetter(reste);
					  if(  quotient > 1 && reste == 0    ) numberToLetter = NumberToLetter(quotient) + " mille";
					  if(  quotient > 1 && reste != 0    ) numberToLetter = NumberToLetter(quotient) + " mille " + NumberToLetter(reste);
					  break;
		 case 5 :  quotient = Math.floor(nb / 1000);
					  reste = nb - quotient * 1000;
					  if(  quotient == 1 && reste == 0   ) numberToLetter = "mille";
					  if(  quotient == 1 && reste != 0   ) numberToLetter = "mille" + " " + NumberToLetter(reste);
					  if(  quotient > 1 && reste == 0    ) numberToLetter = NumberToLetter(quotient) + " mille";
					  if(  quotient > 1 && reste != 0    ) numberToLetter = NumberToLetter(quotient) + " mille " + NumberToLetter(reste);
					  break;
		 case 6 :  quotient = Math.floor(nb / 1000);
					  reste = nb - quotient * 1000;
					  if(  quotient == 1 && reste == 0   ) numberToLetter = "mille";
					  if(  quotient == 1 && reste != 0   ) numberToLetter = "mille" + " " + NumberToLetter(reste);
					  if(  quotient > 1 && reste == 0    ) numberToLetter = NumberToLetter(quotient) + " mille";
					  if(  quotient > 1 && reste != 0    ) numberToLetter = NumberToLetter(quotient) + " mille " + NumberToLetter(reste);
					  break;
		 case 7: quotient = Math.floor(nb / 1000000);
					  reste = nb % 1000000;
					  if(  quotient == 1 && reste == 0  ) numberToLetter = "un million";
					  if(  quotient == 1 && reste != 0  ) numberToLetter = "un million" + " " + NumberToLetter(reste);
					  if(  quotient > 1 && reste == 0   ) numberToLetter = NumberToLetter(quotient) + " millions";
					  if(  quotient > 1 && reste != 0   ) numberToLetter = NumberToLetter(quotient) + " millions " + NumberToLetter(reste);
					  break;  
		 case 8: quotient = Math.floor(nb / 1000000);
					  reste = nb % 1000000;
					  if(  quotient == 1 && reste == 0  ) numberToLetter = "un million";
					  if(  quotient == 1 && reste != 0  ) numberToLetter = "un million" + " " + NumberToLetter(reste);
					  if(  quotient > 1 && reste == 0   ) numberToLetter = NumberToLetter(quotient) + " millions";
					  if(  quotient > 1 && reste != 0   ) numberToLetter = NumberToLetter(quotient) + " millions " + NumberToLetter(reste);
					  break;  
		 case 9: quotient = Math.floor(nb / 1000000);
					  reste = nb % 1000000;
					  if(  quotient == 1 && reste == 0  ) numberToLetter = "un million";
					  if(  quotient == 1 && reste != 0  ) numberToLetter = "un million" + " " + NumberToLetter(reste);
					  if(  quotient > 1 && reste == 0   ) numberToLetter = NumberToLetter(quotient) + " millions";
					  if(  quotient > 1 && reste != 0   ) numberToLetter = NumberToLetter(quotient) + " millions " + NumberToLetter(reste);
					  break;  
		 case 10: quotient = Math.floor(nb / 1000000000);
						reste = nb - quotient * 1000000000;
						if(  quotient == 1 && reste == 0  ) numberToLetter = "un milliard";
						if(  quotient == 1 && reste != 0  ) numberToLetter = "un milliard" + " " + NumberToLetter(reste);
						if(  quotient > 1 && reste == 0   ) numberToLetter = NumberToLetter(quotient) + " milliards";
						if(  quotient > 1 && reste != 0   ) numberToLetter = NumberToLetter(quotient) + " milliards " + NumberToLetter(reste);
					    break;	
		 case 11: quotient = Math.floor(nb / 1000000000);
						reste = nb - quotient * 1000000000;
						if(  quotient == 1 && reste == 0  ) numberToLetter = "un milliard";
						if(  quotient == 1 && reste != 0  ) numberToLetter = "un milliard" + " " + NumberToLetter(reste);
						if(  quotient > 1 && reste == 0   ) numberToLetter = NumberToLetter(quotient) + " milliards";
						if(  quotient > 1 && reste != 0   ) numberToLetter = NumberToLetter(quotient) + " milliards " + NumberToLetter(reste);
					    break;	
		 case 12: quotient = Math.floor(nb / 1000000000);
						reste = nb - quotient * 1000000000;
						if(  quotient == 1 && reste == 0  ) numberToLetter = "un milliard";
						if(  quotient == 1 && reste != 0  ) numberToLetter = "un milliard" + " " + NumberToLetter(reste);
						if(  quotient > 1 && reste == 0   ) numberToLetter = NumberToLetter(quotient) + " milliards";
						if(  quotient > 1 && reste != 0   ) numberToLetter = NumberToLetter(quotient) + " milliards " + NumberToLetter(reste);
					    break;	
		 case 13: quotient = Math.floor(nb / 1000000000000);
						reste = nb - quotient * 1000000000000;
						if(  quotient == 1 && reste == 0  ) numberToLetter = "un billion";
						if(  quotient == 1 && reste != 0  ) numberToLetter = "un billion" + " " + NumberToLetter(reste);
						if(  quotient > 1 && reste == 0   ) numberToLetter = NumberToLetter(quotient) + " billions";
						if(  quotient > 1 && reste != 0   ) numberToLetter = NumberToLetter(quotient) + " billions " + NumberToLetter(reste);
					    break; 	
		 case 14: quotient = Math.floor(nb / 1000000000000);
						reste = nb - quotient * 1000000000000;
						if(  quotient == 1 && reste == 0  ) numberToLetter = "un billion";
						if(  quotient == 1 && reste != 0  ) numberToLetter = "un billion" + " " + NumberToLetter(reste);
						if(  quotient > 1 && reste == 0   ) numberToLetter = NumberToLetter(quotient) + " billions";
						if(  quotient > 1 && reste != 0   ) numberToLetter = NumberToLetter(quotient) + " billions " + NumberToLetter(reste);
					    break; 	
		 case 15: quotient = Math.floor(nb / 1000000000000);
						reste = nb - quotient * 1000000000000;
						if(  quotient == 1 && reste == 0  ) numberToLetter = "un billion";
						if(  quotient == 1 && reste != 0  ) numberToLetter = "un billion" + " " + NumberToLetter(reste);
						if(  quotient > 1 && reste == 0   ) numberToLetter = NumberToLetter(quotient) + " billions";
						if(  quotient > 1 && reste != 0   ) numberToLetter = NumberToLetter(quotient) + " billions " + NumberToLetter(reste);
					    break; 	
	 }//fin switch
	 /*respect de l'accord de quatre-vingt*/
	 if(  numberToLetter.substr(numberToLetter.length-"quatre-vingt".length,"quatre-vingt".length) == "quatre-vingt"  ) numberToLetter = numberToLetter + "s";
	 
	 return numberToLetter;
}


});