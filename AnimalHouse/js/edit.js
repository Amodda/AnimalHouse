$('.editable').on('click', function() {
    var $editable = $(this);
    if($editable.data("editing")) {
       return;
    }

    $editable.data("editing", true);
    var h5 = $("h5", this);
    var input = $('<input class="w-100" />').val(h5.text());
    //

    
    h5.after(input);
    h5.hide();

    input.on('focus', function(){
        $(this).focus();
        
    })
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
        console.log(input.val());
        h5.text(input.val());
        input.remove();
        h5.show();
        $editable.data("editing", false);
    }

        function reset () {
            input.remove();
        h5.show();
        $editable.data("editing", false);
        }
});

$('.editable').on('mouseover', function() {
    $('.editable').css('cursor','pointer');
});


