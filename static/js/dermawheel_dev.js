
// When user clicks outside of modal box, close it.
window.onclick = function(evt){
    var modaltarget = document.getElementsByClassName("modal")[0];
    console.log(modaltarget);
    if(evt.target === modaltarget){
        $('#luckywheelDlg').hide();
    }
}

function initialize() {
    console.log("luckywheelDlg");
    document.getElementById("luckywheelDlg").style.display = "block";
}