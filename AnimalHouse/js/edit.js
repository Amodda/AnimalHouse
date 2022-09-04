$('.editable').on('click', function() {
    var $editable = $(this);
    console.log($editable);
    if($editable.data("editing")) {
       return;
    }

  $editable.data("editing", true);
  var h3 = $("h3", this);
  var input = $('<input />').val(h3.text())


  h3.after(input);
  h3.hide();

  input.on('blur', function(){
      save();
      
  })
  input.on('keyup', function(e){
      if (e.keyCode == '13') {
          save();
      }
      if (e.keyCode == '27') {
          reset();
      }
  })

  function save() {
      h3.text(input.val());
      input.remove();
      h3.show();
      $editable.data("editing", false);
  }

    function reset () {
        input.remove();
      h3.show();
      $editable.data("editing", false);
    }
});

// apertura e chiusura scheda, aggiungere animazione
$(document).ready(function(){
    $("#close").click(function(){
      $("#scheda").addClass("d-none");
    });
    $(".open").click(function(){
      $("#scheda").removeClass("d-none");
    });
  });

