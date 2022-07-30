

// prendo il file JSON dei clienti
function getUsers() {
    var table = document.getElementById("userTable");
    fetch("users.json")
        .then( response => response.json())
        .then(data => {
            console.log(data);
            
            for(var i=0; i<data.length; i++){
                var row = "<tr>"+
                "<td>" + JSON.stringify(data[i].name) + "</td>"+
                "<td>" + JSON.stringify(data[i].lastname) + "</td>"+
                "<td>" + JSON.stringify(data[i].email) + "</td>"+
                // quando clicchi il bottone apri scheda per gestire il cliente (manage())
                "<button onClick='manage("+i+")'> Apri scheda cliente </button>"+
                "</tr>";
                table.innerHTML += row;
            }
            
        })
   
}

function manage(index){
    console.log(index);
}

