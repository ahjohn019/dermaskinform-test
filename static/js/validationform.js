function validation_test(){
    $("#dermaskin_form").validate({
        rules: {
            inst_acc_name: {
                required:true,
            },
            first_name: {
                required: true,
            },
            last_name:{
                required:true,
            },
            email: {
                required: true,
                email: true
            },
            dateofbirth:{
                required:true,
            },
            phonenumber:{
                required:true,
                pattern:'(1-)?\d{3}-\d{7}'
            },
            address_one:{
                required:true,
            },
            city:{
                required:true,
            },
            postcode:{
                required:true,
            }
        },
        messages: {
            email: {
                required: "Please Enter Valid Email Format"
            }
        }
    });
}
