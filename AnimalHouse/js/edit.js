$('.editable').on('click', function() {
    var $editable = $(this);
    if($editable.data("editing")) {
       return;
    }

    $editable.data("editing", true);
    console.log("avviata la modifica");
  var h3 = $("h1", this);
  var input = $('<input />').val(h3.text());

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