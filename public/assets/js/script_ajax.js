function updateCreateButton() {
	document.getElementById('belongsToId').value=document.getElementById('belongsToListSelect').value;
}		
	
$(document).ready(function() {
	afficheListeItems();
	updateCreateButton();
});


$("#belongsToListSelect").change(function(e) {
	afficheListeItems();
	updateCreateButton();
	
});