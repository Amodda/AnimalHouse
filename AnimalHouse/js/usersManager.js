var utenti;
aggiornaUtenti();
// ottengo array degli utenti anche in JS
function aggiornaUtenti(){
    fetch("users.json")
    .then( response => response.json())
    .then(data => {  
        utenti=data;
    });
}
// array delle preferenze
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

// array delle categorie di animali
var preferences;
fetch('favourites.json') 
    .then( response => response.json())
    .then(data => {
        preferences = data;
    });

// user attualmente nella scheda:
var currentUser;

// Creo la scheda in base all'indice
function manage(index){
    if($('#scheda').is(':visible')){
        // pulisci gli input di password e di preferences.
    }
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

    divSave.innerHTML = "<button class='btn-dark btn-block rounded-2 px-3 py-3' onclick='saveData("+index+")'> Salva Modifiche </button>";
    divPass.innerHTML = "<button class='rounded-2' onclick='managePwd("+index+")' > Change password </button>" ;
    divElimina.innerHTML = "<button class='rounded-2' onclick='deleteUser("+index+")'> Delete User </button>";
    
}
// creo sezione modifica password
function managePwd(index){
    
    if($('#password').is(":visible")){
        $('#msgErr').hide(500);
        $('#password').hide(500);
        
    }else{
        $('#password').show(500);
    }
    var submit = document.getElementById("invia");
    submit.innerHTML = "<button class='mt-3 rounded-2' onclick='updatePassword("+index+")' > Send Password </button>"; 
    


}
// sezione modifica password
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
// elimina utente dal file
function deleteUser(index){
    utenti.splice(index, 1);
    $.post('php/popUser.php', { num: index}, function(result) { 
        if(result == 2){
            alert("Utente eliminato con successo");
        }else{
            alert("errore");
        }
     });
    location.reload();
}
// salva modifica dati anagrafici
function saveData(index){
    var n = document.getElementById("name").textContent;
    var l = document.getElementById("lastname").textContent;
    var e = document.getElementById("email").textContent;
    var newu = document.getElementById("username").textContent;
    var newquiz = document.getElementById("quiz").textContent;
    var newhang =document.getElementById("hang").textContent;
    var newmemo =document.getElementById("memo").textContent;
    var preference = savePref();
    var msg = "";

    // semaforo per controllare se il nuovo username è valido
    var semaphore=false;
    if(newu != currentUser){
        semaphore=checkUser(newu);  
    }
    // mando nuovi dati a file anagrafe e preferenze
    if(semaphore == false){
        $.post('php/modificaAnagrafe.php', { name: n, lname: l, email: e, username: newu, i: index,
                                            quiz: newquiz, hang: newhang, memo: newmemo}, function(result) {
            msg=result;
         });
         $.post('php/preferencePost.php', {newArr : preference, username: currentUser, newuser: newu}, function(result) {
            msg=result;
        });
        // aggiorno gli array di sessione
         aggiornaUtenti();
         aggiornaPreferiti();
         alert("Nuovi dati utente salvati");
        location.reload();
    }else{
        alert("Username already in use, change it!");
    }
}
// controllo validità del nuovo username (se è già esistente)
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

        if(preferences[i].username == user && preferences[i].preferences != ''){
            console.log(preferences[i].preferences);
            var pref = preferences[i].preferences;
            for(var j=0; j<pref.length; j++){
                add += '<tr><td class="colanimal">'+ pref[j] +'</td></tr>'
            }
        }else{
        }
    }
    // se non ho preferti:
    if(add != ""){
       return add; 
    }else{
        return '<tr><td>Empty</td></tr>';
    }
    
}
// riempio il form delle categorie da selezionare
var access=0;
function changePref(){
    if($('.my-custom-scrollbar-scheda').is(":visible")){
        $('.my-custom-scrollbar-scheda').hide(500);
        $('#modificaPref').text("Annulla Modifica"); 
        $('#choiceFav').show(500);
        if(access == 0){
            var add='';
            for(var i=0; i<animals.length; i++){
            add += '<div><input class="animal" type="checkbox" name="'+animals[i]+'" value="'+animals[i]+'"/> '+animals[i]+'<div/>'
            }
           
            access=1;
        }
            $('#fieldsetPref').append(add);
          $('#modificaPref').text("Cancel Modify"); 
        
    }else{
        showFavTable();
    }
   
    
}
// controllo e restituisco le categorie selezionate
function savePref(){
    var animalSelected=[];
    if($('#choiceFav').is(":visible")){
        var animalElem=Array.from(document.getElementsByClassName('animal'));     
        for(var i=0; i<animalElem.length; i++){
        if(animalElem[i].checked == true){
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
//mostra tabella preferiti
function showFavTable(){
    $('#choiceFav').hide(500);
    $('#modificaPref').text("Change Prefernces"); 
    $('.my-custom-scrollbar-scheda').show(500);
}
// apertura e chiusura scheda, aggiungere animazione
$(document).ready(function(){
    $("#close").click(function(){
      $("#scheda").addClass("d-none");
      $(".inp_pwd").val("");
      $("#password").hide();
      $('#msgErr').hide();
      
    });
    $(".open").click(function(){
      $("#scheda").removeClass("d-none");
      if($('#choiceFav').is(":visible")){
        showFavTable();
      }
    });

    $("#close").mouseover(function(){
        $("#close").css('cursor','pointer');
    });
  });
