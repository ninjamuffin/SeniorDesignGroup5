var t = '';

function gText() {
    t = (document.all) ? document.selection.createRange().text : document.getSelection();
    document.getElementById('input').value = t;
}
document.onmouseup = gText;
if (!document.all) document.captureEvents(Event.MOUSEUP);

/*function getSelection() {
    var text = ""'
    if (typeof window.getSelection != "undefined") {
        text = window.getSelection().toString();
    } else if (typeof document.selection != "undefined" && document.selection.type == "Text") {
        text = document.selection.createRange().text;
    }
    return text;
}*/

function printSelection() {
    var selection = getSelection();
    if (selection) {
        alert("Selection: " + selection);
    }
}