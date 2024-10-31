(function( $ ) {
    $(document).ready(function() {

        //-------------------------------------------------- Profile Form ----------------------------------------------------//
        $('#change_password_form').formValidation({
            framework: 'bootstrap',
            disabled: 'disabled',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
    
    
            fields: {
    
                user_password: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        stringLength: {
                            min: 6,
                            message: 'Your password must be at least 6 characters'
                        }
                    }
                },
    
                user_password2: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        identical: {
                            field: 'user_password',
                            message: 'The password do not match'
                        }
                    }
                },
    
            }
        });
    
    
        //-------------------------------------------------- Profile Form ----------------------------------------------------//
        $('#profile_form').formValidation({
            framework: 'bootstrap',
            disabled: 'disabled',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
    
    
            fields: {
    
                agent_first_name: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z\s]+$/,
                            message: 'Can only consist of alphabetical and Space'
                        }
                    }
                },
    
                agent_last_name: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        regexp: {
                            regexp: /^[a-zÀ-ú\s\.\'-]+$/i,
                            message: 'Can only consist of alphabetical and Space'
                        }
                    }
                },
    
                agent_phone_number: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        phone: {
                            country: 'US',
                            message: 'The value is not valid %s phone number'
                        }
                    }
                },
                /*
                                email_address: {
                                    validators: {
                                        notEmpty: {
                                            message: 'Required'
                                        },
                                        regexp: {
                                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                                            message: 'Please enter a valid email address'
                                        }
                                    }
                                },
                */
                agent_about_me: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        }
                    }
                },
    
    
            }
        });
    
    
        $('#agent_first_name, #agent_last_name').keyup(function() {
            populateEmailAddress();
        });
    
        function populateEmailAddress() {
            var first_name = $('#agent_first_name').val();
            var last_name = $('#agent_last_name').val();
    
            var emailaddress = first_name.charAt(0) + last_name + "@millereaton.com";
            $('#agent_email_address').val(emailaddress.toLowerCase());
        }
    
        if ($('#agent_first_name').val())
            populateEmailAddress();
    
    
    
        //-------------------------------------------------- Profile Form ----------------------------------------------------//
        $('#new_transaction_form').formValidation({
            framework: 'bootstrap',
            disabled: 'disabled',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
    
    
            fields: {
    
                property_no: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        }
                    }
                },
                property_street: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        }
                    }
                },
    
                property_city: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        }
                    }
                },
    
                property_zip: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        }
                    }
                },
    
                client_firstName: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z\s]+$/,
                            message: 'Can only consist of alphabetical and Space'
                        }
                    }
                },
    
                client_lastName: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        regexp: {
                            regexp: /^[a-zÀ-ú\s\.\'-]+$/i,
                            message: 'Can only consist of alphabetical and Space'
                        }
                    }
                },
    
                client_phoneNumber: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        phone: {
                            country: '',
                            message: 'The value is not valid %s phone number'
                        }
                    }
                },
    
                client_emailAddress: {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'Please enter a valid email address'
                        }
                    }
                },
    
                // 'sros[]': {
                //     validators: {
                //         notEmpty: {
                //             message: 'Required'
                //         },
                //     }
                // },
                //
                // 'lrol[]': {
                //     validators: {
                //         notEmpty: {
                //             message: 'Required'
                //         },
                //     }
                // },
                //
                // 'contract[]': {
                //     validators: {
                //         notEmpty: {
                //             message: 'Required'
                //         },
                //     }
                // },
    
    
            }
        });
        $("#sale_price").maskMoney({ allowNegative: false, thousands: ',', decimal: '.', allowZero: true }).maskMoney('mask');
        $("#total_commision").maskMoney({ allowNegative: false, thousands: ',', decimal: '.', allowZero: true }).maskMoney('mask');
        $("#rental_price").maskMoney({ allowNegative: false, thousands: ',', decimal: '.', allowZero: true }).maskMoney('mask');
        $("#total_commision_rental").maskMoney({ allowNegative: false, thousands: ',', decimal: '.', allowZero: true }).maskMoney('mask');
    
    
    
        $("#edit_transaction_form").keyup(function() {
            calcNumbers();
        });
    
        $("#commission_structure, #rental_term").change(function() {
            calcNumbers();
        });
    
        calcNumbers();
    
    
        function calcNumbers() {
            console.debug("====> calcNumbres  <====");
            if (typeof agent_commission === 'undefined') {
                return;
            }
    
            //sales
            temp = $('#sale_price').maskMoney('unmasked')[0];
            var sale_price = parseFloat(temp); //.replace(',', '').replace('.', ','));
    
            var transaction_commission = 0; //$('#transaction_commission').val() / 100;
    
            var total_commission = ($("#total_commision").val() != '') ? parseFloat($("#total_commision").maskMoney('unmasked')[0]) : 0; //sale_price * transaction_commission;
            var agent_payout = total_commission * agent_commission / 100;
            console.debug("===> sale_price: %o", sale_price);
            console.debug("===> total_commission: %o", total_commission);
            console.debug("===> agent_commission: %o", agent_commission);
            console.debug("===> agent_payout: %o", agent_payout);
            total_commission = parseFloat(total_commission);
            agent_payout = parseFloat(agent_payout);
    
            //$('#total_commision').val(total_commission); //.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            //$('#sale_price').val(sale_price.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#agent_payout').val(agent_payout.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    
            //rental
    
            if ($('#commission_structure').val() == 'halfmonth') {
                $('#rentalCommisionPercentage').hide();
            } else {
                $('#rentalCommisionPercentage').show();
            }
    
            var rental_price = $('#rental_price').val();
            var rental_term = $('#rental_term').val();
    
            var rent_for_term = rental_price * rental_term;
            $('#total_rent').val(rent_for_term);
    
    
            /*
            var commission_structure = $('#commission_structure').val();
    
            if (commission_structure == 'percentage') {
                var commission_percentage = $('#transaction_commission_rental').val();
                var total_commission = rent_for_term * commission_percentage;
                var agent_payout = total_commission * agent_commission / 100;
    
                total_commission = parseFloat(total_commission);
                agent_payout = parseFloat(agent_payout);
    
                //$('#total_commision_rental').val(total_commission.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#agent_payout_rental').val(agent_payout.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    
            }
    
            if (commission_structure == 'halfmonth') {
                var total_commission = rental_price / 2;
                var agent_payout = total_commission * agent_commission / 100;
    
    
                total_commission = parseFloat(total_commission);
                agent_payout = parseFloat(agent_payout);
    
                //$('#total_commision_rental').val(total_commission.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#agent_payout_rental').val(agent_payout.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    
            }*/
    
            var total_commission = ($("#total_commision_rental").val() != '') ? parseFloat($("#total_commision_rental").maskMoney('unmasked')[0]) : 0; //sale_price * transaction_commission;
            var agent_payout = total_commission * agent_commission / 100;
            $('#agent_payout_rental').val(agent_payout.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    
    
        }
    
    
        hideFiles();
        $('#transactionType1, #transactionType2, #transactionType3').change(function() {
            hideFiles();
        });
    
        function hideFiles() {
    
            var transactionType = $('input[name=transactionType]:checked', '#new_transaction_form').val();
    
            $('.fileUpload').hide();
            switch (transactionType) {
                case 'purchase':
                    $('#contract').show();
                    break;
                case 'lease-landlord':
                    $('#lrol').show();
                    break;
                case 'lease-tenant':
                    $('#contract').show();
                    break;
                case 'sale':
                    $('#sros').show();
                    break;
            }
    
        }
    
        function fileValidator(element) {
            var transactionType = $('input[name=transactionType]:checked', '#new_transaction_form').val();
    
            //console.log(transactionType);
    
    
            return false;
        }
    
    
    
    
    
        //-------------------------------------------------- Remove File -----------------------------------------------------//
        // $('.btn-delete').on('click', function(event) {
        //     event.preventDefault();
    
        //     var parent = $(this).parent();
        //     var file_id = $(this).data('file_id');
        //     var file_type = $(this).data('file_type');
    
        //     if (file_type == 'profile_image') {
        //         var file_html = '<div class="form-group"><label>Image</label><input type="file" name="image" id="image" accept="image/jpeg, image/png"><p class="help-block">1:1 Ratio image (.jpg / .png) Ideally on a plain background.</p></div>';
        //     } else {
        //         var file_html = 'File Removed';
        //     }
    
    
        //     $.ajax({
        //         url: site_url + 'portal/files/remove_file',
        //         type: "POST",
        //         data: { file_id: file_id, file_type: file_type },
        //         success: function(response) {
        //             if (response['result']) {
        //                 $(parent).html(file_html);
        //             } else {
        //                 alert('Could not remove file. Please contact support');
        //             }
    
        //         },
    
        //     });
    
    
    
        // });
    
    
    
    }); // /document ready
    
    
    $(function() {
    
        var ul = $('#upload ul');
    
        $('#drop a').click(function() {
            // Simulate a click on the file input button
            // to show the file browser dialog
            $(this).parent().find('input').click();
        });
    
        // Initialize the jQuery File Upload plugin
        // $('#upload').fileupload({
    
        //     // This element will accept file drag/drop uploading
        //     dropZone: $('#drop'),
    
        //     // This function is called when a file is added to the queue;
        //     // either via the browse button, or via drag/drop:
        //     add: function(e, data) {
    
        //         var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"' +
        //             ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');
    
        //         // Append the file name and file size
        //         tpl.find('p').text(data.files[0].name)
        //             .append('<i>' + formatFileSize(data.files[0].size) + '</i>');
    
        //         // Add the HTML to the UL element
        //         data.context = tpl.appendTo(ul);
    
        //         // Initialize the knob plugin
        //         tpl.find('input').knob();
    
        //         // Listen for clicks on the cancel icon
        //         tpl.find('span').click(function() {
    
        //             if (tpl.hasClass('working')) {
        //                 jqXHR.abort();
        //             }
    
        //             tpl.fadeOut(function() {
        //                 tpl.remove();
        //             });
    
        //         });
    
        //         // Automatically upload the file once it is added to the queue
        //         var jqXHR = data.submit();
        //     },
    
        //     progress: function(e, data) {
    
        //         // Calculate the completion percentage of the upload
        //         var progress = parseInt(data.loaded / data.total * 100, 10);
    
        //         // Update the hidden input field and trigger a change
        //         // so that the jQuery knob plugin knows to update the dial
        //         data.context.find('input').val(progress).change();
    
        //         if (progress == 100) {
        //             data.context.removeClass('working');
        //         }
        //     },
    
        //     fail: function(e, data) {
        //         // Something has gone wrong!
        //         data.context.addClass('error');
        //     }
    
        // });
    
    
        // Prevent the default action when a file is dropped on the window
        $(document).on('drop dragover', function(e) {
            e.preventDefault();
        });
    
        // Helper function that formats the file sizes
        function formatFileSize(bytes) {
            if (typeof bytes !== 'number') {
                return '';
            }
    
            if (bytes >= 1000000000) {
                return (bytes / 1000000000).toFixed(2) + ' GB';
            }
    
            if (bytes >= 1000000) {
                return (bytes / 1000000).toFixed(2) + ' MB';
            }
    
            return (bytes / 1000).toFixed(2) + ' KB';
        }
    
        // if( $('#commission_check_files li').length > 0 )
        // {
        //     $('#saveandclose').removeClass('disabled');
        // }
    
        var table = $('#dataTables-example').DataTable({
            renderer: {
                "header": "bootstrap"
            },
            "order": []
        });
    
        $('#closeLink').click(function(e) {
            e.preventDefault();
            $('#status').val('closed');
            $('#edit_transaction_form').submit();
        });
    
        $('#cancelLink').click(function(e) {
            e.preventDefault();
            $('#status').val('cancelled');
            $('#edit_transaction_form').submit();
        });
    
        $('#saveTransaction').click(function(e) {
            e.preventDefault();
            $('#status').val('open');
            $('#edit_transaction_form').submit();
        });
    
    });
})( jQuery );
