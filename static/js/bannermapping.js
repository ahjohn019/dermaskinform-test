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

function onSelect(){
    //if checked box checked, redeem text will display on images
    // var text = "";
    // $('input[name="derma_select_item[]"]:checked').each(function() {
    //     text += $(this).val() + ',';
    // });
    // console.log(text);
    $('input[name="derma_select_item[]"]').each(function() {
        var box = $(this).val();
        if(this.checked){
            $('#' + box).show();
            console.log(box);
        }
        
    });
}