var array=[];
var favTemp;

// crea oggetto cateogoria con immagine e nome per visualizzare sfondi
fetch('animalList.json') 
    .then( response => response.json())
    .then(data => {
        for(var i=0; i<data["categories"].length; i++){
            array.push(data["categories"][i]);
        };
    });


    function save(){
    var newFav= Array.from(document.getElementsByClassName('card-on'));
    var newFavtext = [];
    for(var i=0; i<newFav.length; i++){
        newFavtext.push(newFav[i].innerHTML);
    }
    console.log(newFavtext);
    
    var newUser = document.getElementById("user").textContent;
    console.log(newUser);
    $.post('php/preferencePost.php', { newArr : newFavtext, username : "flag", newuser : newUser}, function(result) { 
        //alert(result); 
    });
    location.reload();
/*
    $.ajax({ 
        type: "POST", 
        url: "php/profilePost.php", 
        data: { phpArr : newFav}, 
        success: function() { 
               alert("Success"); 
         } 
    }); */
    
}


function favAdd() {
    $(".card").on("click", function(){
        console.log("Entrato in modifica classe");
        if($(this).hasClass("card-off")){
            console.log("da cardoff a cardon")
            $(this).removeClass("card-off");
            $(this).addClass("card-on");
            // aggiungi ad array
            favTemp.push(this);
            
        }else if($(this).hasClass("card-on")){
            $(this).removeClass("card-on");
            $(this).addClass("card-off");
            //aggiugni ad arrau
        }
            
    });
}
function fillArray(){
    favTemp = Array.from(document.getElementsByClassName('colanimal'));
    console.log(favTemp[0].innerHTML);
}

function openSection () {
    $("#add").on("click", function() {
        //riempio array temp
        fillArray();
        // mostro sezione scelta
        $("#sezP").show(1000);
        var add='';
        // capire perchè primo è undefined
        for(var i=0; i<array.length; i++){
            console.log(array[i]);
            flag=0;
            for(var j=0; j<favTemp.length; j++){
                if(" "+array[i]+" " == favTemp[j].innerHTML){
                    console.log("trovata corripsondenza: " + array[i]);
                    flag=1;
                    break; 
                }
            }
     
            if(flag == 0){
                
                add += '<div class="card card-off"> '+array[i]+' </div>'; 
            }else if(flag==1){
                console.log("acceso: "+array[i]);
                add += '<div class="card card-on"> '+array[i]+' </div>'; 
            }
        }
        var grid = document.getElementById("animalsGrid");
        grid.innerHTML += add;
        favAdd();
    });
}
$(document).ready(function() {
    openSection();
});
