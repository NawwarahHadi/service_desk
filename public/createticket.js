"use strict";

var KTCreateTicket = function () {
    var form;
    var submitButton;
    var validator;

    var initValidation = function () {
        validator = FormValidation.formValidation(form, {
            fields: {
                title: {
                    validators: {
                        notEmpty: { message: 'Ticket title is required' }
                    }
                },
                category_id: {
                    validators: {
                        notEmpty: { message: 'Category is required' }
                    }
                },
                description: {
                    validators: {
                        notEmpty: { message: 'Description is required' }
                    }
                },
                location: {
                    validators: {
                        notEmpty: { message: 'Location is required' }
                    }
                },
                raised_date: {
                    validators: {
                        notEmpty: { message: 'Malfunction date is required' }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        });
    };

    var handleSubmit = function () {
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation(); // 🚨 BLOCK Metronic SweetAlert

            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    form.submit();
                }
            });
        });
    };

    return {
        init: function () {
            form = document.querySelector('#kt_modal_new_ticket_form');
            submitButton = document.querySelector('#kt_modal_new_ticket_submit');

            if (!form) return;

            initValidation();
            handleSubmit();
        }
    };
}();

document.addEventListener('DOMContentLoaded', function () {
    KTCreateTicket.init();
});
