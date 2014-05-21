/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/** Šalje GET zahtjev serveru za imenima korisnika na serveru
 * TRUE označava asinkroni zahtjev
 * @param {string} name Dio ili cijelo ime
 * @returns {string} Popis svih korisnika \name imena
 */
function searchPeople(name) {
    document.getElementById("resultTextArea").innerHTML="<img src='includes/files/ajax-loader.gif'>"; 
    xmlhttp=new XMLHttpRequest();
    
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("resultTextArea").innerHTML=xmlhttp.responseText;
        }
        else{
            document.getElementById("resultTextArea").innerHTML="Greška!";
        }
    };
    xmlhttp.open("GET","server.php?names=all",true);
    xmlhttp.send();
}
