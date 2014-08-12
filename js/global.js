/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function fnIsQtyKeyOkay(event) {
    var _allowedCtrlChars = [8, 9, 16, 17, 18, 27, 37, 38, 39, 40, 46, 116];
    
    if (event.which >= 48 && event.which <= 57) {
        // Allow number keys and the delete key
        return true;
    }
    else if ($.inArray(event.which, _allowedCtrlChars) > -1) {
        // Allow backspace, tab, escape, delete, control keys and the arrows, and F5 
        return true;
    }
    else {
        return false;
    }
}