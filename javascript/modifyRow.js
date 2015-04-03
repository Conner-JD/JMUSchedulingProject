/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function changeEID(){
    var jac = document.getElementById('jac');
    
    jac.disabled = false;   
}

function deleteRow(row) {
    var i = row.parentNode.parentNode.rowIndex;
    var x = document.getElementById('ClassTable');
    x.deleteRow(i);
    if (x.rows.length === 3){
        var firstDelete = x.rows[2].cells[8].getElementsByTagName('input')[0];
        firstDelete.parentNode.removeChild(firstDelete);
    }
}


function insRow() {
    console.log('hi');
    var x = document.getElementById('ClassTable');
    var tbody = document.getElementById('tbody');
    var len = x.rows.length;
    
    if (len === 3){
        var firstRowDelete = x.rows[2].cells[8];
        var newButton = document.createElement("input");
        newButton.type = "button";
        newButton.onclick = function() { deleteRow(this); };
        newButton.value = "Delete Class";
        newButton.name = "deleteClass";
        firstRowDelete.appendChild(newButton);
    }
    var new_row = x.rows[2].cloneNode(true);

    var inp0 = new_row.cells[0].getElementsByTagName('input')[0];
    inp0.id += len;
    inp0.name = "class[" + len + "][subject]";
    inp0.value = '';
    
    var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
    inp1.id += len;
    inp1.name = "class[" + len + "][num]";
    inp1.value = '';
    
    var inp2 = new_row.cells[2].getElementsByTagName('input')[0];
    inp2.id += len;
    inp2.name = "class[" + len + "][prof]";
    inp2.value = '';
    
    var inp3 = new_row.cells[3].getElementsByTagName('input')[0];
    inp3.id += len;
    inp3.name = "class[" + len + "][loc]";
    inp3.value = '';
    
    var inp4 = new_row.cells[4].getElementsByTagName('input')[0];
    inp4.id += len;
    inp4.name = "class[" + len + "][start]";
    inp4.value = '';
    
    var inp5 = new_row.cells[5].getElementsByTagName('input')[0];
    inp5.id += len;
    inp5.name = "class[" + len + "][end]";
    inp5.value = '';
    
    var inp6 = new_row.cells[6].getElementsByTagName('input')[0];
    inp6.id += len;
    inp6.name = "class[" + len + "][m]";
    inp6.checked = false;
    
    var inp7 = new_row.cells[6].getElementsByTagName('input')[1];
    inp7.id += len;
    inp7.name = "class[" + len + "][t]";
    inp7.checked = false;
    
    var inp8 = new_row.cells[6].getElementsByTagName('input')[2];
    inp8.id += len;
    inp8.name = "class[" + len + "][w]";
    inp8.checked = false;
    
    var inp9 = new_row.cells[6].getElementsByTagName('input')[3];
    inp9.id += len;
    inp9.name = "class[" + len + "][th]";
    inp9.checked = false;
    
    var inp10 = new_row.cells[6].getElementsByTagName('input')[4];
    inp10.id += len;
    inp10.name = "class[" + len + "][f]";
    inp10.checked = false;
    
    var delButton = new_row.cells[8].getElementsByTagName('input')[0];
    delButton.onclick = function() { deleteRow(this); };
    delButton.value = "Delete Class";
    delButton.name = "deleteClass";
    
    
    tbody.appendChild(new_row);
}