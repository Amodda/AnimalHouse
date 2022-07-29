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
    //document.getElementById('animalInfo').innerHTML = '<div class="w-100 my-4 d-flex flex-row justify-content-start"><div class=""><img src="' + animal['image_link']+'" id="animalImg" ></div><div class="d-flex flex-column mx-4"><div class="w-100 d-flex"><div><strong>Type: </strong>' + animal['animal_type'] + '</div></div><div class="w-100 d-flex"><div><strong>Name: </strong>' + animal['name'] + '</div></div><div><strong>Latin name: </strong>' + animal['latin_name'] + '</div><div><strong>Diet: </strong>' + animal['diet'] + '</div></div></div>';
    document.getElementById('animalInfo').innerHTML = '<div class="w-100 my-4 d-flex flex-row justify-content-start"><div class=""><img src="' + animal['image_link']+'" id="animalImg" ></div><div class="d-flex flex-column mx-4"><h5>The ' + animal['name']+ ' is a ' + animal['animal_type']+ ' that lives in ' + animal['habitat']+ '.</h5> <br> <h6>The diet of this animal is usually based on ' +  animal['diet']+ '.</h5><br><h6>The weight of this animal usually stands between ' + animal['weight_min'] + ' kg and ' + animal['weight_max'] + 'kg.</h6></div></div>';
    
}

requestData();
