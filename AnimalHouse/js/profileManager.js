var array=[];
var favTemp;


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
    
    
    $.post('php/profilePost.php', { newArr : newFavtext}, function(result) { 
        alert(result); 
    });
    
/*
    $.ajax({ 
        type: "POST", 
        url: "php/profilePost.php", 
        data: { phpArr : newFav}, 
        success: function() { 
               alert("Success"); 
         } 
    }); */
    //location.reload();
}
function deletePref(index) {
        fillArray();
            for(var i=0; i<favTemp.length; i++){
                console.log("FavTemp in lettura, i:"+i+" index:"+index);
            if(i == index){
                favTemp.splice(i,1);
                document.getElementsByClassName("rowanimal")[index].remove();
                console.log(favTemp[0]);
                fillArray();
                break;
            }else{
                console.log("non uguale");
            }
        }
        

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
            console.log(array[i]);
            flag=0;
            for(var j=0; j<favTemp.length; j++){
                if(array[i] == favTemp[j].innerHTML){
                    flag=1;
                    break; 
                }
            }
                 
            if(flag == 0){
                add += '<div class="card card-off"> '+array[i]+' </div>'; 
            }else{
                add += '<div class="card card-on"> '+array[i]+' </div>'; 
            }
        }
        var grid = document.getElementById("animalsGrid");
        grid.innerHTML += add;
        favAdd();
    });
});
