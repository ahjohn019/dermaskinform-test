// When user clicks outside of modal box, close it.
window.onclick = function(evt){
    var modaltarget = document.getElementsByClassName("modal")[0];
    if(evt.target === modaltarget){
        $('#rewardWinMessage').hide();
    }
}

function chooseItem(){
    document.getElementById("rewardWinMessage").style.display = "block";
}
