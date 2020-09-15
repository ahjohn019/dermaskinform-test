function validation_test(){
    $("#dermaskin_form").validate({
        rules: {
            inst_acc_name: {
                required:true
            },
            first_name:{
                required:true
            },
            last_name:{
                required:true
            },
            
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Please Enter Valid Email Format"
            }
        }
    });
}
