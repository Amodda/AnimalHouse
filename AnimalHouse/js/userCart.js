function addQty(id){
    var qty = parseInt(document.getElementById(id).innerHTML);
    qty += 1;
    document.getElementById(id).innerHTML = qty;
}
function removeQty(id){
    var qty = parseInt(document.getElementById(id).innerHTML);
    if(qty > 1){
        qty -= 1;
    }
    document.getElementById(id).innerHTML = qty;
}

function ajax(data, destination, response){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {

          document.getElementById(response).style.display = 'flex';
          document.getElementById(response).innerHTML = this.responseText;
          //console.log("ciao");
      }
    };

    xmlhttp.open("POST", destination + "?" + data,true);
    xmlhttp.send();
  
}

function updateCart(){
    var list = document.getElementById("itemsList").children;
    const items = list.length;
    console.log(items);
    products = [];
    for(i = 0; i < items; i++){
        product = [list[i].id, document.getElementById('product' + i).innerHTML];
        products.push(product);
    }

    console.log(products);
    var data = "updateCart&&productsNumber=" + items;
    for(i = 0; i < products.length; i++){
        data += '&&product' + i + '=' + products[i][0] + '&&qty' + i + '=' + products[i][1];
    }
    ajax(data, "php/productsManagement.php", "updateResponse");
    console.log(data);
}