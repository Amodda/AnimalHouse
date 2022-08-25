var utenti;
// ottengo array degli utenti anche in JS
fetch("users.json")
    .then( response => response.json())
    .then(data => {  
        utenti=data;
    });

// Cambiare label quando ci clicco sopra
//chiusura scheda:

// Creo la scheda in base all'indice
function manage(index){
    // dati modificabili al click
    var name = document.getElementById("name");
    var lastname = document.getElementById("lastname");
    var email = document.getElementById("email");
    var username = document.getElementById("username");
    var divSave = document.getElementById("salva");
    console.log(divSave);
    name.innerHTML = utenti[index].name;
    lastname.innerHTML = utenti[index].lastname;
    email.innerHTML = utenti[index].email;
    username.innerHTML = utenti[index].username;
    // da attivare e disattivare

    divSave.innerHTML = "<button onclick='saveData("+index+")'> Salva Modifiche </button><hr>";
    
    // data
    var div = document.getElementById("data");
    var add = "<button onclick='managePwd("+index+")' style='font-size: small;'> modifica password</button>" ;
    add += "<div> Preferenze      vuoto </div>";
    add += "<div> Punteggio giochi: "+ 
            "<div> Quiz: "+ JSON.stringify(utenti[index].gamesPoints.quiz) +" </div>" +
            "<div> Quiz: "+ JSON.stringify(utenti[index].gamesPoints.hangman) +" </div>" +
            "<div> Quiz: "+ JSON.stringify(utenti[index].gamesPoints.memory) +" </div>"+
        "</div>"+
        "<button onclick='eliminaUtente("+index+")' style='font-size: small;'> Elimina Utente </button>";
    div.innerHTML = add;
    
}
// creo sezione modifica password
function managePwd(index){
    var message = document.getElementById("password");
    message.innerHTML += "<button onclick='updatePassword("+index+")' type='submit' name='submit'> Invia </button>"; 
    document.getElementById("password").style.visibility = "visible";
      
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
         
    }else{
        // visualizza messaggio errore
    }
    
}

function eliminaUtente(index){
    utenti[index]=utenti.pop();
    $.post('php/popUser.php', { num: index}, function(result) { 
        alert(result); 
     });
}
// salva modifica dati anagrafici
function saveData(index){
    var n = document.getElementById("name").textContent;
    var l = document.getElementById("lastname").textContent;
    var e = document.getElementById("email").textContent;
    var u = document.getElementById("username").textContent;

    $.post('php/modificaAnagrafe.php', { name: n, lname: l, email: e, username: u, i: index}, function(result) { 
        alert(result); 
     });
     
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