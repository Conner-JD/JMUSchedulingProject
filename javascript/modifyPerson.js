/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function enablePeople(){
    var person = document.getElementById('person');
    var addButton = document.getElementById('addPerson');
    
    person.disabled = false;
    addButton.disabled = false;   
}

function disablePeople(){
    var person = document.getElementById('person');
    var addButton = document.getElementById('addPerson');
    
    person.disabled = true;
    addButton.disabled = true;
}

function deleteRow(row) {
    var i = row.parentNode.parentNode.rowIndex;
    var x = document.getElementById('employeeTable');
    x.deleteRow(i);
    if (x.rows.length === 1){
        var firstDelete = x.rows[0].cells[2].getElementsByTagName('input')[0];
        firstDelete.parentNode.removeChild(firstDelete);
    }
}

function insPerson() {
    var x = document.getElementById('employeeTable');
    var tbody = document.getElementById('tbody');
    var len = x.rows.length;
    
    if (len === 1){
        var firstRowDelete = x.rows[0].cells[2];
        var newButton = document.createElement("input");
        newButton.type = "button";
        newButton.onclick = function() { deleteRow(this); };
        newButton.value = "Delete";
        newButton.name = "delete";
        firstRowDelete.appendChild(newButton);
    }
    
    var new_row = x.rows[0].cloneNode(true);
    var inp0 = new_row.cells[0].getElementsByTagName('select')[0];
    inp0.id += len;
    inp0.name = "person[" + len + "]";
    
    var delButton = new_row.cells[2].getElementsByTagName('input')[0];
    delButton.onclick = function() { deleteRow(this); };
    delButton.value = "Delete";
    delButton.name = "delete";
    
    tbody.appendChild(new_row);
}