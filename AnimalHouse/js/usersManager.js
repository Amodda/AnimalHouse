var utenti;
aggiornaUtenti();
// ottengo array degli utenti anche in JS
function aggiornaUtenti(){
    fetch("usersTest.json")
    .then( response => response.json())
    .then(data => {  
        utenti=data;
    });
}

var animals=[];
function aggiornaPreferiti(){
    fetch('animalList.json') 
    .then( response => response.json())
    .then(data => {
        for(var i=0; i<data["categories"].length; i++){
            animals.push(data["categories"][i]);
        };
    });
}
aggiornaPreferiti();

var preferences;
fetch('favourites.json') 
    .then( response => response.json())
    .then(data => {
        preferences = data;
    });

// user attualmente nella scheda:
var currentUser;
// Cambiare label quando ci clicco sopra
//chiusura scheda:

// Creo la scheda in base all'indice
function manage(index){
    
    // dati modificabili al click
    currentUser = utenti[index].username;
    var name = document.getElementById("name");
    var lastname = document.getElementById("lastname");
    var email = document.getElementById("email");
    var username = document.getElementById("username");
    var divSave = document.getElementById("salva");
    var divPass = document.getElementById("pass");
    var divQuiz = document.getElementById("quiz");
    var divHang = document.getElementById("hang");
    var divMemo = document.getElementById("memo");
    var divElimina = document.getElementById("cancelUser");
    var prefBody = document.getElementById("favBody");

    name.innerHTML = utenti[index].name;
    lastname.innerHTML = utenti[index].lastname;
    email.innerHTML = utenti[index].email;
    username.innerHTML = utenti[index].username;
    divQuiz.innerHTML = JSON.stringify(utenti[index].gamesPoints.quiz);
    divHang.innerHTML = JSON.stringify(utenti[index].gamesPoints.hangman);
    divMemo.innerHTML = JSON.stringify(utenti[index].gamesPoints.memory);
    prefBody.innerHTML = fillPreferences(currentUser);

    divSave.innerHTML = "<button onclick='saveData("+index+")'> Salva Modifiche </button>";
    divPass.innerHTML = "<button onclick='managePwd("+index+")' style='font-size: small;'> modifica password</button>" ;
    divElimina.innerHTML = "<button onclick='eliminaUtente("+index+")' style='font-size: small;'> Elimina Utente </button>";
    
}
// creo sezione modifica password
function managePwd(index){
    var form = document.getElementById("password");
    var submit = document.getElementById("invia");
    submit.innerHTML = "<button onclick='updatePassword("+index+")' type='submit' name='submit'> Invia </button>"; 
    if(form.visibility != "visible"){
        form.style.visibility = "visible";
    }else{
        form.style.visibility = "hidden";
    }


}
// modifico la password tramite jQuery 
function updatePassword(index){
    var old_pwd = document.getElementById("oldPwd").value;
    var input_pwd = document.getElementById("newPwd").value;
    // Aggiungere controlli password: Lunghezza minima password 8 caratteri.
     //           Lunghezza massima 20 caratteri'
    if(input_pwd != "" && old_pwd != ""){
        document.getElementById("password").style.visibility= "hidden";
        // aggiorna array utenti:
        utenti[index].password = input_pwd;
        $.post('php/backPost.php', { num: index, npwd: input_pwd, olpwd: old_pwd }, function(result) { 
            alert(result); 
         });
        location.reload();
    }else{
        // visualizza messaggio errore
    }
    
}
// Sbagliato.
function eliminaUtente(index){
    utenti.splice(index, 1);
    $.post('php/popUser.php', { num: index}, function(result) { 
        alert(result); 
     });
    location.reload();
}
// salva modifica dati anagrafici
function saveData(index){
    var n = document.getElementById("name").textContent;
    var l = document.getElementById("lastname").textContent;
    var e = document.getElementById("email").textContent;
    var newu = document.getElementById("username").textContent;
    var preference = savePref();
    var msg = "";
    $.post('php/modificaAnagrafe.php', { name: n, lname: l, email: e, username: newu, i: index}, function(result) {
        message=result;
     });
     $.post('php/preferencePost.php', {newArr : preference, username: currentUser, newuser: newu}, function(result) {
        message=result;
    });
     aggiornaUtenti();
     aggiornaPreferiti();
     alert(msg);
     console.log("utente: "+utenti[index].username);
    location.reload();
}

// search tabella utenti
$(document).ready(function() {
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableBody tr").filter(function() {
            $(this).toggle($(this).text()
            .toLowerCase().indexOf(value) > -1)
        });
    });
});

// gestione preferenze:
// riempi la tabella delle preferenze.
function fillPreferences(user){
    var add="";
    for(var i=0; i<preferences.length; i++){
        if(preferences[i].username == user && preferences[i].preferences != null){
            var pref = preferences[i].preferences;
            for(var j=0; j<pref.length; j++){
                add += '<tr><td class="colanimal">'+ pref[j] +'</td></tr>'
            }
        }else{
        }
    }

    if(add != ""){
       return add; 
    }else{
        return '<tr><td>Nessun preferito</td></tr>';
    }
    
}
// da mettere già selezionate quelle presenti nella tabella.
function changePref(){
    $('.my-custom-scrollbar-scheda').hide(500);
    $('#choiceFav').show(500);
    var add='';
    for(var i=0; i<animals.length; i++){
      add += '<br><input class="animal" type="checkbox" name="'+animals[i]+'" value="'+animals[i]+'"/> '+animals[i]+'<br/>'
    }
      $('#fieldsetPref').append(add);
    
}

function savePref(){
    var animalSelected=[];
    if($('#choiceFav').is(":visible")){
        var animalElem=Array.from(document.getElementsByClassName('animal'));     
        for(var i=0; i<animalElem.length; i++){
        if(animalElem[i].checked == true){
            console.log("Questo è selezionato: " + animalElem[i].value ); 
            animalSelected.push(animalElem[i].value);
        }
    }
   
    }else if($('.my-custom-scrollbar-scheda').is(":visible")){
        var animalElem=Array.from(document.getElementsByClassName('colanimal'));
        for(var i=0; i<animalElem.length; i++){
            animalSelected.push(animalElem[i].innerHTML);
        }
    }else{
        animalSelected.push("Errore di trasmissione dati");
    }
    
    

    return animalSelected;
}