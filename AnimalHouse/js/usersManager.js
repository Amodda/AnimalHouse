var utenti;

// prendo il file JSON dei clienti
function getUsers() {
    var table = document.getElementById("userTable");
    fetch("users.json")
        .then( response => response.json())
        .then(data => {
            console.log(data);
            utenti=data;
            for(var i=0; i<data.length; i++){
                var row = "<tr>"+
                "<td>" + JSON.stringify(utenti[i].name) + "</td>"+
                "<td>" + JSON.stringify(utenti[i].lastname) + "</td>"+
                "<td>" + JSON.stringify(utenti[i].email) + "</td>"+
                // quando clicchi il bottone apri scheda per gestire il cliente (manage())
                "<button onClick='manage("+i+")'> Apri scheda cliente </button>"+
                "</tr>";
                table.innerHTML += row;
            }
            
        })
   
}

function manage(index){
    var div = document.getElementById("data");
    var add = "<h1>" + JSON.stringify(utenti[index].name)+ " " + JSON.stringify(utenti[index].lastname) +"<h1>";
    add += "<p> Username: " + JSON.stringify(utenti[index].username)+"</p>";
    add += "<p> Password: " + JSON.stringify(utenti[index].password)+"</p> <button onclick='managePwd("+JSON.stringify(utenti[index].password) +","+index+")' style='font-size: small;'> modifica password</button>" ;
    add += "<p> Preferenze      vuoto </p>";
    add += "<p> Punteggio Quiz: " + JSON.stringify(utenti[index].gamePoints)+"</p>";
    div.innerHTML = add;
}

function managePwd(pwd, index){
    var message = document.getElementById("oldPwd");
    console.log(message);  
    message.innerHTML = "<p> Vecchia Password:  "+pwd+"</p>"
                        +"<button onclick='updatePassword("+index+")'> Invia </button>";
      
    document.getElementById("password").style.visibility = "visible";
      
}
// aggiungere controllo isset e se è una pssword lecita
function updatePassword(index){
    var input_pwd = document.getElementById("newPwd").value;
    if(input_pwd != "" && input_pwd.length > 6){
        console.log("nuova password: "+input_pwd);
        document.getElementById("password").style.visibility= "hidden";
        // aggiorna array utenti:
        utenti[index].password = input_pwd;
        // aggiorna il file Json con le nuove informazioni:
        const FileSystem = require("fs");
        FileSystem.writeFile('usersTest.json', JSON.stringify(utenti), (error) => {
        if (error) throw error;
        });
        console.log("nell'array: " + utenti[index].password);
    } 
    
}