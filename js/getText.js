
var selection = '';

function gText(e) {
    selection = (document.all) ? document.selection.createRange().text : document.getSelection();
    document.getElementById('input').value = selection;
}

/*document.querySelector('textarea').addEventListener('mouseup', function () {
  window.mySelection = this.value.substring(this.selectionStart, this.selectionEnd)
  // window.getSelection().toString();
});*/

window.onmouseup = gText;

function printSelection() {
    var expr = selection;
    if (selection) {
        document.getElementById('expression').innerHTML  = expr;
    }
}