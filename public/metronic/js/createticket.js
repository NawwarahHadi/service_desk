"use strict";

var KTCreateTicket = function () {
    var form;
    var submitButton;
    var cancelButton;
    var validator;

    // ==========================
    // Init Form Validation
    // ==========================
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

    // ==========================
    // Handle Submit Button
    // ==========================
    var handleSubmit = function () {
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation(); // Stop Metronic default submit

            validator.validate().then(function (status) {
                if (status === 'Valid') {

                    Swal.fire({
                        text: "Ticket has been successfully submitted!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-info"
                        }
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            form.submit(); // ✅ submit AFTER OK
                        }
                    });

                } else {
                    Swal.fire({
                        text: "Please fill in all required fields.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-light"
                        }
                    });
                }
            });
        });
    };

    // ==========================
    // Handle Cancel Button
    // ==========================
    var handleCancel = function () {
        cancelButton.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            Swal.fire({
                text: "Are you sure you want to cancel? Any unsaved data will be lost.",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel",
                cancelButtonText: "No, stay here",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-light"
                }
            }).then(function (result) {
                if (result.isConfirmed) {
                    window.location.href = window.ticketListUrl;
                }
            });
        });
    };

    // ==========================
    // Init Everything
    // ==========================
    return {
        init: function () {
            form = document.querySelector('#kt_modal_new_ticket_form');
            submitButton = document.querySelector('#kt_modal_new_ticket_submit');
            cancelButton = document.querySelector('#kt_modal_new_ticket_cancel');

            if (!form || !submitButton || !cancelButton) {
                console.error('Ticket form elements not found');
                return;
            }

            initValidation();
            handleSubmit();
            handleCancel();
        }
    };
}();

// ==========================
// DOM Ready
// ==========================
document.addEventListener('DOMContentLoaded', function () {
    KTCreateTicket.init();
});
