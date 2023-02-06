let form;

function add(selectedForm,libelle,instruction = "") {
    form = selectedForm;
	document.getElementById("popup-libelle").innerHTML = libelle;
	document.getElementById("instruction").innerHTML = instruction;
}

let url = "http://medisoft.localhost/";
function showPopUp(targetCategorie,target,libelle,instruction = "") {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', popUp);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // display the popup
            document.getElementById('popup-container').innerHTML = xhr.responseText;
            document.getElementById('popup-container').style.display = 'block';
            document.getElementById('form-popup').action = url + targetCategorie + '/' + target;
            document.getElementById('popup-libelle').innerHTML = libelle;
        }
    };
    xhr.send();
}

function submitForm() {
    form.submit();
}
