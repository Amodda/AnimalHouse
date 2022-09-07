// array per cateogorie di animali, la lista temporanea (selezione utente) e le immagini
var categories=[];
var favTemp;
var arr_img=[];
// leggo il file animalList che contiene username e relativi animali preferiti
fetch('animalList.json') 
    .then( response => response.json())
    .then(data => {
        for(var i=0; i<data["categories"].length; i++){
            categories.push(data["categories"][i]);
            arr_img.push(data["pictures"][i]);
        };
    });

// funzione che manda al gestore delle prefernze i nuovi dati, dove verranno scritti su file
    function save(){
    var newFav= Array.from(document.getElementsByClassName('card-on'));
    var newFavtext = [];
    for(var i=0; i<newFav.length; i++){
        newFavtext.push(newFav[i].innerHTML);
    }

    
    var newUser = document.getElementById("user").textContent;

    $.post('php/preferencePost.php', { newArr : newFavtext, username : "flag", newuser : newUser}, function(result) { 
        alert("Lista modificata correttamente"); 
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
         var newFav = Array.from($('.card-on').find("div"));
    }); */
    
}

// all click sull'immagine cambia da card on a card off e viceversa
function favAdd() {
    $(".card").on("click", function(){
        if($(this).hasClass("card-off")){
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
// salvo in array favtemp gli aniamali già presenti 
function fillArray(){
    favTemp = Array.from(document.getElementsByClassName('colanimal'));
}

// apro la sezione di scelta animali
function openSection () {
    $("#add").on("click", function() {
        //riempio array con gli animali della tabella
        fillArray();
        // mostro sezione scelta
        $("#sezP").show(1000);
        var add='';

        // se gli animali sono già nella tabella li illumino (card-on)        
        for(var i=0; i<categories.length; i++){
            flag=0;
            for(var j=0; j<favTemp.length; j++){
                if(categories[i] == favTemp[j].innerHTML){
                    
                    flag=1;
                    break; 
                }
            }
            if(flag == 0){
                add += '<div class="card card-off" style="background-image: url(./img/'+arr_img[i]+');">'+categories[i]+'</div>'; 
            }else if(flag==1){
                add += '<div class="card card-on" style="background-image: url(./img/'+arr_img[i]+');">'+categories[i]+'</div>'; 
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
