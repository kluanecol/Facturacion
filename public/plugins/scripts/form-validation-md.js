var FormValidationMd = function() {
    var handleValidation = function(form, rules, messages, method) {

        form.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            messages: messages,
            rules: rules,

            invalidHandler: function(event, validator) {
                //console.log(event, validator);
            },

            errorPlacement: function(error, element) {
                if (element.is(':checkbox')) {
                    error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
                } else if (element.is(':radio')) {
                    error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
                } else if (element.hasClass('select2-hidden-accessible')) {
                    error.insertAfter( element.parent().find('.help-block') );
                } else {
                    error.insertAfter(element);
                }
            },

            highlight: function(element) {
                $(element)
                    .closest('.form-group').addClass('has-error');
            },

            unhighlight: function(element) {
                $(element)
                    .closest('.form-group').removeClass('has-error');
            },

            success: function(label) {
                label
                    .closest('.form-group').removeClass('has-error');
            },

            submitHandler: function(form) {
                if ( typeof method !== 'undefined' && typeof method === 'object' ) {
                    method.init();
                }
                if (typeof method === 'undefined' || method === false) {
                    form.submit();
                }
            }
        });
    };


    return {
        init: function(form, rules, messages, method, btnAction) {
            handleValidation(form, rules, messages, method, btnAction);
        }
    };
}();

var ComponentsBootstrapMaxlength = function () {

    var handleBootstrapMaxlength = function() {
        $('input[maxlength], textarea[maxlength]').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
        });
    };

    return {
        init: function () {
            handleBootstrapMaxlength();
        }
    };

}();

jQuery(document).ready(function() {
    ComponentsBootstrapMaxlength.init();
});