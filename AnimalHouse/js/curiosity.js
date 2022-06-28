function requestData(){
    let request = new XMLHttpRequest();
    request.open("GET", "https://zoo-animal-api.herokuapp.com/animals/rand");
    request.send();
    request.onload = () => {
        //console.log(request);
        if (request.status == 200){
            var jsonData = JSON.parse(request.response)
            //console.log(jsonData);
            presentData(jsonData);

        } else {
            console.log('Request error')
        }
    }
}
//requestData();

function presentData(jsonData){
    var animal = jsonData;
    document.getElementById('animalInfo').innerHTML = '<div class="w-100 my-4 d-flex flex-row justify-content-start"><div class=""><img src="' + animal['image_link']+'" id="animalImg"></div><div class="d-flex flex-column mx-4"><div class="w-100 d-flex"><div><strong>Type: </strong>' + animal['animal_type'] + '</div></div><div class="w-100 d-flex"><div><strong>Name: </strong>' + animal['name'] + '</div></div><div><strong>Latin name: </strong>' + animal['latin_name'] + '</div><div><strong>Diet: </strong>' + animal['diet'] + '</div></div></div>';
    
}

requestData();
