var StepWizard = function () {

    return {

        initStepWizard: function () {
            var form = $(".shopping-cart");
                form.validate({
                    errorPlacement: function errorPlacement(error, element) { element.before(error); },
                    rules: {

                        zip: 
                            { required: true, regex : /^[\d\s]+$/,  minStrict: 0 },
                            
                        szip: 
                            { required: true, regex : /^[\d\s]+$/,  minStrict: 0 },

                        confirm: {
                            equalTo: "#password"
                        }
                    }
                });
                form.children("div").steps({
                    headerTag: ".header-tags",
                    bodyTag: "section",
                    transitionEffect: "fade",
                    onStepChanging: function (event, currentIndex, newIndex) {
                        if(newIndex == 3){ if($("#selected-fed-type").val() == '') { alert('Choose shipping method'); return false; } }
                        // Allways allow previous action even if the current form is not valid!
                        if(newIndex!=0){$("#couptext").hide();}else{$("#couptext").show();}
                        if (currentIndex > newIndex)
                        {
							return true;	
                        }
                        form.validate().settings.ignore = ":disabled,:hidden";
                        return form.valid();
                    },
                    onFinishing: function (event, currentIndex) {
                        //form.validate().settings.ignore = ":disabled";
                        //return form.valid();
                        cart_submission();
                    },
                    onFinished: function (event, currentIndex) {
                       // alert("Submitted!");
                    }
                });
        }, 

    };
}();        


$.validator.addMethod(
    "regex",
    function(value, element, regexp) {
        var check = false;
        return this.optional(element) || regexp.test(value);
    },
    "Please check your input."
);

$.validator.addMethod('minStrict', function (value, el, param) {
    return value > param;
});