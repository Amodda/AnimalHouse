var utenti;
// ottengo array degli utenti anche in JS
fetch("users.json")
    .then( response => response.json())
    .then(data => {  
        utenti=data;
    })
;

// Creo la scheda in base all'indice
function manage(index){
    var div = document.getElementById("data");
    
    var add = "<h1>" + JSON.stringify(utenti[index].name)+ " " + JSON.stringify(utenti[index].lastname) +"<h1>";
    add += "<div> Username: " + JSON.stringify(utenti[index].username)+"</div>";
    add += "<div> Password: " + JSON.stringify(utenti[index].password)+"</div> <button onclick='managePwd("+JSON.stringify(utenti[index].password) +","+index+")' style='font-size: small;'> modifica password</button>" ;
    add += "<div> Preferenze      vuoto </div>";
    add += "<div> Punteggio giochi: "+ 
            "<div> Quiz: "+ JSON.stringify(utenti[index].gamesPoints.quiz) +" </div>" +
            "<div> Quiz: "+ JSON.stringify(utenti[index].gamesPoints.hangman) +" </div>" +
            "<div> Quiz: "+ JSON.stringify(utenti[index].gamesPoints.memory) +" </div>"+
        "</div>"+
        "<button onclick='eliminaUtente()' style='font-size: small;'> Elimina Utente </button>";
    div.innerHTML = add;
    div.style.visibility = "visible";
}
// creo sezione modifica password
function managePwd(pwd, index){
    var message = document.getElementById("oldPwd");
    console.log(message);  
    message.innerHTML = "<p> Vecchia Password:  "+pwd+"</p>"
                        +"<button onclick='updatePassword("+index+")' type='submit' name='submit'> Invia </button>";
      
    document.getElementById("password").style.visibility = "visible";
      
}
// modifico la password tramite jQuery 
function updatePassword(index){
    var input_pwd = document.getElementById("newPwd").value;
    // Aggiungere controlli password 
    if(input_pwd != "" ){
        document.getElementById("password").style.visibility= "hidden"
        // aggiorna array utenti:
        utenti[index].password = input_pwd;
        $.post('php/backPost.php', { num: index, npwd: input_pwd }, function(result) { 
            alert(result); 
         });
    } 
    
}

function eliminaUtente(){
    // chiama script php che elimina qull'elemento dall'array e poi riscrive array su file
}