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
    divPass.innerHTML = "<button onclick='managePwd("+index+")' style='font-size: small;'> Change password </button>" ;
    divElimina.innerHTML = "<button onclick='deleteUser("+index+")' style='font-size: small;'> Delete User </button>";
    
}
// creo sezione modifica password
function managePwd(index){
    
    if($('#password').is(":visible")){
        console.log("password is invisible now")
        $('#password').hide(500);
    }else{
        console.log("password is VISIBLE now")
        $('#password').show(500);
    }
    var submit = document.getElementById("invia");
    submit.innerHTML = "<button onclick='updatePassword("+index+")' > Send Password </button>"; 
    


}
// modifico la password
function updatePassword(index){
  
    var old_pwd = document.getElementById("oldPwd").value;
    var new_pwd = document.getElementById("newPwd").value;
    var conf_pwd = document.getElementById("confnewPwd").value;

    // Aggiungere controlli password: Lunghezza minima password 8 caratteri.
     //           Lunghezza massima 20 caratteri'
    if(new_pwd != "" && old_pwd != "" && conf_pwd != ""){
        if(new_pwd == conf_pwd){
            if((new_pwd.length > 7) && (new_pwd.length <= 20)){

            // $('#password').hide(500);
                // aggiorna array utenti:
                utenti[index].password = new_pwd;
                $.post('php/backPost.php', { num: index, npwd: new_pwd, olpwd: old_pwd }, function(result) { 
                    if(result=="Old"){
                        $('#msgErr').show();
                         $('#msgErr').text("Old Password uncorrect.");
                    }else if(result=="Yes"){
                        aggiornaUtenti();
                        alert("Password modificata con successo");
                        location.reload();
                    }
                });
                
            }else{
                $('#msgErr').show();
                $('#msgErr').text("Password length has to be between 8 and 20 characters.");
            }
       
        }else{
            $('#msgErr').show();
            $('#msgErr').text("Confirm password field uncorrect.");
        }
     
    }else{
        $('#msgErr').show();
        $('#msgErr').text("Plese fill all the fields.");
    }
    
}
// Sbagliato.
function deleteUser(index){
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
    if(checkUser(newu) == false){
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
    }else{
        alert("Username already in use, change it!");
    }
}
function checkUser(user){
    for(var i=0; i<utenti.length; i++){
        if(user == utenti[i].username){
            return true;
        }
    }
    return false;
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
    if($('.my-custom-scrollbar-scheda').is(":visible")){
        $('.my-custom-scrollbar-scheda').hide(500);
        $('#modificaPref').text("Annulla Modifica"); 
        $('#choiceFav').show(500);
        var add='';
        for(var i=0; i<animals.length; i++){
          add += '<br><input class="animal" type="checkbox" name="'+animals[i]+'" value="'+animals[i]+'"/> '+animals[i]+'<br/>'
        }
          $('#fieldsetPref').append(add);
          $('#modificaPref').text("Cancel Modify"); 
    }else{
        $('#choiceFav').hide(500);
        $('#modificaPref').text("Change Prefernces"); 
        $('.my-custom-scrollbar-scheda').show(500);
        
    }
   
    
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