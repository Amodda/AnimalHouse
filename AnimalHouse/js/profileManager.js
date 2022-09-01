var array=[];
var favTemp;


fetch('animalList.json') 
    .then( response => response.json())
    .then(data => {
        for(var i=0; i<data["categories"].length; i++){
            array.push(data["categories"][i]);
        };
    });

function deletePref() {
    $('.remove').on("click",function() {
        var rim =  $(this).prev();
        if(favTemp != ""){
            console.log("Favtemp è pieno");
            for(var i=0; i<favTemp.length; i++){
                console.log("FavTemp in"+i+": "+favTemp[i].innerHTML+ "/// rim: "+rim.text());
            if(favTemp[i] == rim){
               
                pref.splice(i,1);
                console.log("rimosso: " + rim);
                $(this).closest("tr").remove();
            }
        }
        }
        
    });  
}
function favAdd() {
    $(".card").on("click", function(){
        $(this).css("background","rgb(0,0,0,0.5)");
        $('#tableBody tr:last').after('<tr><td class="rowanimal">'+this.innerHTML+'</td><td><a href="#" class="remove"> [-] </td></tr>');
        favTemp.push(this);
        console.log("aggiunto: "+this);
       deletePref();
    });
}
function fillArray(){
    favTemp = Array.from(document.getElementsByClassName('rowanimal'));
}
$(document).ready(function() {
    $("#add").on("click", function() {
        //riempio array temp
        fillArray();
        // mostro sezione scelta
        $("#sezP").show(1000);
        var add;
        // capire perchè primo è undefined
        for(var i=0; i<array.length; i++){
            add += '<div class="card"> '+array[i]+' </div>';
        }
        var grid = document.getElementById("animals");
        grid.innerHTML += add;
        favAdd();
    });
});
/*
function select(){
    $(this).css("background","rgb(0,0,0,0.5)");
    $('#tableBody tr:last').after('<tr><td>'+this.innerHTML+'</td><td><a href="#" class="remove"> [-] </td></tr>');
    //pref.push(this);
}
*/
/*
$(document).ready(function() {
var array=[];

fetch('animalList.json')
    .then( response => response.json())
    .then(data => {
        for(var i=0; i<data["categories"].length; i++){
            array.push(data["categories"][i]);
        };
    });





var pref;
// doppio ciclo brutto
fetch('favourites.json')
    .then( response => response.json())
    .then(data => {
        for(var i=0; i<data.length; i++){
            console.log($("#user").text());
            if(data[i]["username"] == $("#user").text()){
                console.log(data[i]["preferences"]);
                
                for(var j=0; j<data[i]["preferences"].length; j++){
                    pref.push(data[i]["preferences"][j]);
                };
            }
        }
    });


        var tbody = document.getElementById("tableBody");
        console.log("voglio cambiare la tabella!");
        var add="";
        console.log(pref);
        
        console.log("Prova:"+pref[0]);
        add += '<tr><td>'+pref[0]+'</td><td><a href="#" class="remove"> [-] </td></tr>';
        
        
        tbody.innerHTML = add; 
  

    // visualizzo sezione preferito
    $("#add").on("click", function() {
    $("#sezP").show(1000);
    var add;
    // capire perchè primo è undefined
    for(var i=0; i<array.length; i++){
        console.log("aggiunto: "+ array[i]);
        add += '<div class="card"> '+array[i]+' </div>';
    }
    var grid = document.getElementById("animals");
    grid.innerHTML += add;
        //seleziona preferiti
        $(".card").on("click", function(){
            $(this).css("background","rgb(0,0,0,0.5)");
            $('#tableBody tr:last').after('<tr><td>'+this.innerHTML+'</td><td><a href="#" class="remove"> [-] </td></tr>');
            pref.push(this);
            // elimina preferiti
            $('.remove').on("click",function() {
                var rim = this.innerHTML;
                console.log("rimosso: " + rim);
                $(this).closest("tr").remove();
                for(var i=0; i<pref.length; i++){
                    if(pref[i] == rim){
                        pref.splice(i,1);
                    }
                }
            });  
        });
    });
});

/* non aggiunge se tbody vuoto

$(document).ready(function() {

    
    
    $("#add").on("click", function() {
        $("#sezP").show(500);
    });
}); 

*/

