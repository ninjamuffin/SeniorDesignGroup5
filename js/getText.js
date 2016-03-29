var t = '';

function gText() {
    t = (document.all) ? document.selection.createRange().text : document.getSelection();
    document.getElementById('input').value = t;
    document.getElementById('text-container').value = t;
}
document.onmouseup = gText;
if (!document.all) document.captureEvents(Event.MOUSEUP);