/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function addReason(section) {
    var x = document.getElementById('schedTable');
    var box = section.parentNode;
    
    if (box.children.length === 8){
        var input = document.createElement("input");
        var name = section.attributes[1].nodeValue;
        input.type = "text";
        var newName = name.replace("available", "reason");
        input.name = newName;
        input.placeholder = "Why not?";
        input.required = true;
        box.appendChild(input);
    }

}

function removeReason(section) {
    var x = document.getElementById('schedTable');
    var box = section.parentNode;
    if(box.children.length === 9){
        box.removeChild(box.childNodes[box.childNodes.length - 1]);
    }
}
