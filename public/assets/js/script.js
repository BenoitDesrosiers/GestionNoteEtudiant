$(function() {
       catchDataConfirm();
});

$(document).ajaxComplete(function(){
	//refait l'association du bouton data-confirm après un reload ajax.
	catchDataConfirm();
});

function catchDataConfirm() {
	
	 // Confirm deleting resources
    // méthode pour faire le delete tel que décrit sur http://www.codeforest.net/laravel-4-tutorial-part-2 
    $("form[data-confirm]").submit(function() {
            if ( ! confirm($(this).attr("data-confirm"))) {
                    return false;
            }
    });
}