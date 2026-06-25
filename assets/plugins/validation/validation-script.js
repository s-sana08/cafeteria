$.validator.setDefaults( {
			submitHandler: function () {
				// alert( "submitted!" );
			}
		} );

	$(document).ready(function () 
{
    // =========================
    // ✅ CUSTOM METHODS (TOP)
    // =========================

    // Alphanumeric (Emp id)
    $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
    }, "Employee id must contain only letters and numbers.");

    // Prevent all-zero empid
    $.validator.addMethod("validEmpId", function(value, element) {
        if (this.optional(element)) return true; 
        value = value.replace(/^0+/, ''); 
        return value.length > 0; 
    }, "Please enter a valid employee ID.");

    // Letters with single space
    $.validator.addMethod("lettersWithSingleSpace", function(value, element) {
        value = value.trim();
        return this.optional(element) || /^[A-Za-z]+( [A-Za-z]+)*$/.test(value);
    }, "Please enter valid name.");

    // No spaces in password
    $.validator.addMethod("noSpace", function(value, element) {
        return this.optional(element) || !/\s/.test(value);
    }, "Spaces are not allowed.");

    // Strong password
    $.validator.addMethod("strongPassword", function(value, element) {
        return this.optional(element) 
            || /[A-Z]/.test(value)
            && /[a-z]/.test(value)
            && /[0-9]/.test(value)
            && /[!@#$%^&*(),.?\":{}|<>]/.test(value);
    }, "Password must include uppercase, lowercase, number & special character.");


    // =========================
    // ✅ INPUT RESTRICTION
    // =========================
    $("#txtempid").on("input", function () 
    {
        let value = $(this).val();

        // Only letters + numbers
        value = value.replace(/[^a-zA-Z0-9]/g, '');

        // Max 10 characters
       if (value.length > 15) {
    value = value.slice(0, 15);
    }

        $(this).val(value);
    });


    // =========================
    // ✅ MAIN FORM VALIDATION
    // =========================
    $("#frmmaster").validate({
        onkeyup: false,
        onfocusout: function(element) {
            $(element).valid();
        },

        rules: {
            txtempid: {
    required: true,
    alphanumeric: true,
    minlength: 3,
    maxlength: 15,
    validEmpId: true,
    remote: {
        url: 'api/check_duplicate_empid.php',
        type: 'post',
        cache: false,
        data: {
            empid: function() {
                return $("#txtempid").val();
            },
            id: function() {
                return $("#idemp").val() || '';
            }
        }
    }
    },

            txtempname: {
                required: true,
                lettersWithSingleSpace: true
            },

            txtcompanyname: "required",
            txtdepartment: "required",
            txtfoodtime: "required",
            phone: "required",

            username: {
                required: true,
                minlength: 2
            },

            password: {
                required: true,
                minlength: 8,
                noSpace: true,
                strongPassword: true
            },

            confirm_password: {
                required: true,
                minlength: 8,
                noSpace: true,
                equalTo: "#password"
            },

            email: {
                required: true,
                email: true
            },

            country: "required",
            address: "required",
            agree: "required"
        },

        messages: {
            txtempid: {
    required: "Please enter employee id.",
    alphanumeric: "Only letters and numbers are allowed.",
    minlength: "Employee id must be at least 3 characters.",
    maxlength: "Employee id must be maximum 15 characters.",
    validEmpId: "Please enter a valid employee id.",
    remote: "Employee id already exists."
},

            txtempname: {
                required: "Please enter employee name."
            },

            txtcompanyname: "Please select company.",
            txtdepartment: "Please select department.",
            txtfoodtime: "Please select food time.",
            phone: "Please enter phone number.",

            username: {
                required: "Enter username.",
                minlength: "Minimum 2 characters."
            },

            password: {
                required: "Enter password.",
                minlength: "Minimum 8 characters."
            },

            confirm_password: {
                required: "Confirm password.",
                minlength: "Minimum 8 characters.",
                equalTo: "Passwords do not match."
            },

            email: "Enter valid email.",
            country: "Select country.",
            address: "Enter address.",
            agree: "Accept policy."
        }
    });


    // =========================
    // ✅ PASSWORD FORM
    // =========================
    $("#passwordForm").validate({
        rules: {
            old_password: {
                required: true,
                minlength: 8,
                noSpace: true,
                strongPassword: true
            },
            new_password: {
                required: true,
                minlength: 8,
                noSpace: true,
                strongPassword: true
            },
            confirm_password: {
                required: true,
                minlength: 8,
                noSpace: true,
                strongPassword: true,
                equalTo: "#new_password"
            }
        },

        messages: {
            old_password: {
                required: "Enter old password.",
                minlength: "Minimum 8 characters."
            },
            new_password: {
                required: "Enter new password.",
                minlength: "Minimum 8 characters."
            },
            confirm_password: {
                required: "Confirm password.",
                equalTo: "Passwords must match."
            }
        }
    });







    

    // =========================
    // ✅ FORCE REMOTE CHECK
    // =========================
    $("#txtempid").on("blur keyup", function () {
        $(this).valid();
    });

});





//         /// Validation Vendor
//         	$( document ).ready( function () {

//             // Valid Username Start
//             $.validator.addMethod("validUsername", function(value, element) 
//             {
//                 return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
//             }, "username must contain only letters and numbers (no spaces or special characters)");
//             // Valid Username End 

//             // Valid Password Start
//             $.validator.addMethod("strongPassword", function(value, element) {
//             return this.optional(element) || 
//             /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{6,}$/.test(value);
//             }, "password must be at least 6 characters");
//             // Valid Password End

//             //  // Email validation Start
//             // $.validator.addMethod("validEmail", function(value, element) {
//             // return this.optional(element) || /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|in|org|net|gov|edu|co|biz)$/i.test(value);
//             // }, "Please enter a valid email address (e.g., vendor@example.com)");
//             // // Email validation End

//              // Email validation Start
//             $.validator.addMethod("validEmail", function(value, element) {
//             // Strict email regex: no leading/trailing %, no multiple special chars at start/end
//             return this.optional(element) || 
//            /^[a-zA-Z0-9]([a-zA-Z0-9._+-]*)@[a-zA-Z0-9.-]+\.(com|in|org|net|gov|edu|co|biz)$/i.test(value);
//             }, "Please enter a valid email address (e.g., vendor@example.com)");
 
     
// 			$("#frmvendor").validate({            
//             rules: {
//             txtvendorname: {
//                 required: true,
//                 lettersonly: true, // only letters allowed
//             lettersWithSingleSpace: true, // Single Space
//                 minlength: 2,
//                 maxlength:20
//             },
//             txtvendorusername: {
//             required: true,
//             minlength: 2,
//             maxlength:20,
//             validUsername: true,
//              remote: {
//                 url: 'api/check_vendor_username.php',
//                 type: 'post',
//                 data: {
//             vndusernm: function() {
//                 return $("#txtvendorusername").val();
//             },
//             id: function() {
//             return $("#idvnd").val() || '';
//             }
//                 }
//             }
//         }, 
//         txtvendorpassword: {
//             required: true,
//             minlength: 6,
//             maxlength: 12,
//             strongPassword: true
//         },
//         vendoremailid: {
//             required: true,
//             minlength: 2,
//             email: true,
//             validEmail: true,
//             remote: {
//                 url: 'api/check_duplicate_email.php',
//                 type: 'post',
//                 data: {
//             vndemail: function() {
//                 return $("#vendoremailid").val();
//             },
//             id: function() {
//             return $("#idvnd").val() || '';
//             }
//                 }
//             }
//         },
//         txtfoodtype: "required"
//     },
//     messages: {
//         txtvendorname: {
//             required: "please enter vendor name",
//             lettersonly: "vendor name must be Letter only"
//         },
//         // txtvendorusername: {
//         //     required: "Please enter vendor username",
//         //     lettersonly: "Please valid username",

//         // },
//         txtvendorusername: {
//         required: "please enter vendor username",
//         minlength: "username must be at least 2 characters",
//         maxlength: "username must not exceed 20 characters",
//         validUsername: "username must contain only letters and numbers",
//         remote: "vendor user name already exists"

//         },
//         txtvendorpassword: {
//             required: "please enter password",
//             // lettersonly: "Password must be minimum 5 letter",
//             minlength: "password must be at least 6 characters",
//             maxlength: "password must not exceed 12 characters",
//             strongPassword: "password must include uppercase, lowercase, number and special character"
//         },
        
//         vendoremailid: {
//             required: "please enter vendor email ID",
//             lettersonly: "please valid email ID",
//             email: "Please enter a valid email address",
//             minlength: "username must be at least 2 characters",
//             validEmail: "Please enter a valid email address (e.g., vendor@example.com)",
//             remote: "email ID already exists"
//         },
//         txtfoodtype: "please select food type"
//     },



    
    
// });



// // Add letters only method if not included
// jQuery.validator.addMethod("lettersonly", function(value, element) {
//   return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
// }, "Letters only please"); 
			

// 		} );





$(document).ready(function() {
 
      // Auto-generate username from vendor name
  $('#txtvendorname').on('input', function() {
      let name = $(this).val().trim();
      let username = name.replace(/\s+/g, '');
      $('#txtvendorusername').val(username);
  });

  // Letters only
  $.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
  }, "Letters only please."); 

  // Valid username
  $.validator.addMethod("validUsername", function(value, element) {
      return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
  }, "Username must contain only letters and numbers.");

  // Strong password
  $.validator.addMethod("strongPassword", function(value, element) {
      return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{6,}$/.test(value);
  }, "Password must be at least 6 characters.");

  // Strict email
  $.validator.addMethod("validEmail", function(value, element) {
      return this.optional(element) || /^[a-zA-Z0-9]([a-zA-Z0-9._+-]*)@[a-zA-Z0-9.-]+\.(com|in|org|net|gov|edu|co|biz)$/i.test(value);
  }, "Please enter a valid email address (e.g., vendor@example.com).");

  // Initialize validation
$("#frmvendor").validate({
    rules: {
        txtvendorname: {
            required: true,
            lettersonly: true,
            minlength: 2,
            maxlength: 20
        },
        txtvendorusername: {
            required: true,
            minlength: 2,
            maxlength: 20,
            remote: {
                url: 'api/check_vendor_username.php',
                type: 'post',
                data: {
                    vndusernm: function () { return $("#txtvendorusername").val(); },
                    id: function () { return $("#idvnd").val() || ''; }
                }
            }
        },
        txtvendorpassword: {
            required: true,
            minlength: 6,
            maxlength: 15
        },
        vendoremailid: {
            required: true,
            email: true,
            validEmail: true,
            remote: {
                url: 'api/check_duplicate_email.php',
                type: 'post',
                data: {
                    vndemail: function () { return $("#vendoremailid").val(); },
                    id: function () { return $("#idvnd").val() || ''; }
                }
            }
        },
        txtfoodtype: "required",
        otp: "required"
    },

    messages: {
        txtvendorname: {
            required: "Please enter vendor name.",
            lettersonly: "Vendor name must contain letters only."
        },
        txtvendorusername: {
            required: "Please enter vendor username.",
            minlength: "Username must be at least 2 characters.",
            maxlength: "Username must not exceed 20 characters.",
            remote: "Vendor username already exists."
        },
        txtvendorpassword: {
            required: "Please enter password.",
            minlength: "Password must be at least 6 characters.",
            maxlength: "Password must not exceed 15 characters."
        },
        vendoremailid: {
            required: "Please enter vendor email ID.",
            email: "Please enter a valid email address.",
            validEmail: "Please enter a valid email address (e.g., vendor@example.com).",
            remote: "Email id already exists."
        },
        txtfoodtype: "Please select food type.",
        otp: "Please enter otp."
    },

    errorClass: "text-danger",

    errorPlacement: function (error, element) {

        // ✅ FIX FOR INPUT-GROUP (Bootstrap)
        if (element.parent('.input-group').length) {
            error.insertAfter(element.parent());

        }
        // ✅ FIX FOR YOUR d-flex OTP / EMAIL ROW
        else if (element.closest('.d-flex').length) {
            error.insertAfter(element.closest('.d-flex'));

        }
        else {
            error.insertAfter(element);
        }
    },

    highlight: function (element) {
        $(element).addClass("is-invalid");
    },

    unhighlight: function (element) {
        $(element).removeClass("is-invalid");
    }
});
});





$(document).ready(function() {
 
      // Auto-generate username from Admin name
  $('#txtadminname').on('input', function() {
      let name = $(this).val().trim();
      let username = name.replace(/\s+/g, '');
      $('#txtadminusername').val(username);
  });

  // Letters only
  $.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
  }, "Letters only please."); 

  // Valid username
  $.validator.addMethod("validUsername", function(value, element) {
      return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
  }, "Username must contain only letters and numbers.");

  // Strong password
  $.validator.addMethod("strongPassword", function(value, element) {
      return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{6,}$/.test(value);
  }, "Password must be at least 6 characters.");

  // Strict email
  $.validator.addMethod("validEmail", function(value, element) {
      return this.optional(element) || /^[a-zA-Z0-9]([a-zA-Z0-9._+-]*)@[a-zA-Z0-9.-]+\.(com|in|org|net|gov|edu|co|biz)$/i.test(value);
  }, "Please enter a valid email address (e.g., admin@example.com).");

  // Initialize validation
  $("#frmadmin").validate({
      rules: {
          txtadminname: {
              required: true,
              lettersonly: true,
              minlength: 2,
              maxlength: 20
          },
          txtadminusername: {
              required: true,
              minlength: 2,
              maxlength: 20,
              remote: {
                  url: 'api/check_vendor_username.php',
                  type: 'post',
                  data: {
                      vndusernm: function() { return $("#txtadminusername").val(); },
                      id: function() { return $("#idvnd").val() || ''; }
                  }
              }
          },
          txtadminpassword: {
              required: true,
              minlength: 6,
              maxlength: 15
          },
          adminemailid: {
              required: true,
              email: true,
              validEmail: true,
              remote: {
                  url: 'api/check_duplicate_email.php',
                  type: 'post',
                  data: {
                      vndemail: function() { return $("#adminemailid").val(); },
                      id: function() { return $("#idvnd").val() || ''; }
                  }
              }
          }
          
      },
      messages: {
          txtadminname: {
              required: "Please enter admin name.",
              lettersonly: "Admin name must contain letters only."
          },
          txtadminusername: {
              required: "Please enter admin username.",
              minlength: "Username must be at least 2 characters.",
              maxlength: "Username must not exceed 20 characters.",
              remote: "Admin username already exists."
          },
          txtadminpassword: {
              required: "Please enter admin password.",
              minlength: "Password must be at least 6 characters.",
              maxlength: "Password must not exceed 15 characters."
          },
          adminemailid: {
              required: "Please enter admin email ID.",
              email: "Please enter a valid email address.",
              validEmail: "Please enter a valid email address (e.g., admin@example.com).",
              remote: "Email id already exists."
          }
        
      },
      errorClass: "text-danger",
      errorPlacement: function(error, element) {
          // Handle input-group wrapper
          if(element.parent('.input-group').length) {
              error.insertAfter(element.parent());
          } else {
              error.insertAfter(element);
          }
      },
      highlight: function(element) { $(element).addClass("is-invalid"); },
      unhighlight: function(element) { $(element).removeClass("is-invalid"); }
  });

});



    /// food validation 


    $(document).ready(function () {

    $.validator.addMethod("lettersonly", function(value, element){
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Letters only please");

$.validator.addMethod("lettersonly2", function(value, element){
        return this.optional(element) || /^[a-zA-Z0-9\s]+$/.test(value);
    }, "Letters only please");


    // Validation for space start 
            $.validator.addMethod("lettersWithSinglefood", function(value, element) {
            value = value.trim();
            return this.optional(element) || /^[A-Za-z0-9]+( [A-Za-z0-9]+)*$/.test(value);
        }, "please enter a valid Food name");

    // validation for space end 
        

        
        // Validation for space End 

    $("#frmfood").validate({
        rules: {
            txtfoodname: {
                required: true,
                lettersonly2: true,
                lettersWithSinglefood: true,
                remote: {
                    url: 'api/check_food.php',
                    type: 'post',
                    data: {
                        txtfoodname: function(){ return $("#txtfoodname").val(); },
                        id: function(){ return $("#idfood").val() || ''; }
                    }
                }
            }
        },
        messages: {
            txtfoodname: {
                required: "Please enter food name.",
                lettersonly2: "Food name must contain letters and numbers.",
                lettersWithSinglefood: "please enter valid food name.",
                remote: "Food name already exists."
            }
        },
        errorClass: "text-danger",
        errorPlacement: function(error, element){ error.insertAfter(element); },
        onkeyup: function(element){ $(element).valid(); }
    });
});




  

$(document).ready(function () {
    $.validator.addMethod("lettersonly", function(value, element){
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Letters only please");

    $("#frmdprt").validate({
        rules: {
            txtdprtname: {
                required: true,
                lettersonly: true,
                remote: {
                    url: 'api/check_department.php',
                    type: 'post',
                    data: {
                        txtdprtname: function(){ return $("#txtdprtname").val(); },
                        id: function(){ return $("#iddprt").val() || ''; }
                    }
                }
            }
        },
        messages: {
            txtdprtname: {
                required: "Please enter department name.",
                lettersonly: "Department name must contain letters only.",
                remote: "Department name already exists."
            }
        },
        errorClass: "text-danger",
        errorPlacement: function(error, element){ error.insertAfter(element); },
        onkeyup: function(element){ $(element).valid(); }
    });
});




  // company validation

$(document).ready(function () {

    // Letters only validation
    $.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Letters only please");

    $("#frmcomp").validate({
        rules: {
            txtcompname: {
                required: true,
                remote: {
                    url: 'api/check_company.php',  // duplicate check file
                    type: 'post',
                    data: {
                        txtcompname: function() { return $("#txtcompname").val(); },
                        id: function() { return $("#idcomp").val() || ''; } // ignore current id in update
                    }
                }
            }
        },
        messages: {
            txtcompname: {
                required: "Please enter company name.",
                remote: "Company name already exists."
            }
        },
        errorClass: "text-danger", // show message in red
        errorPlacement: function(error, element) {
            error.insertAfter(element); // show message below input field
        },
        onkeyup: function(element) {
            $(element).valid(); // validate as user types
        }
    });
});




//// Validation for bulk inactive employee

$(document).ready(function () {

    // Validation message Numbers Only start 
    $.validator.addMethod("numbersCommaOnly", function (value, element) {
        return this.optional(element) || /^[0-9]+(,[0-9]+)*$/.test(value);
    }, "Only numbers separated by comma allowed.");
    // Validation message Numbers Only End 

    // Validation message duplicate employee id start 
    $.validator.addMethod("noDuplicateIds", function (value, element) {
    if (this.optional(element)) return true;

    let ids = value.split(',').map(id => id.trim());
    let uniqueIds = [...new Set(ids)];

    return ids.length === uniqueIds.length; 
    }, "Duplicate Employee IDs are not allowed.");

    // Validation message duplicate employee id End 

    $("#frmEmployee").validate({
        rules: {
            employee_ids: {
                required: true,
                numbersCommaOnly: true,
                noDuplicateIds: true
            }
        },
        messages: {
            employee_ids: {
                required: "Please enter employee IDs.",
                numbersCommaOnly: "Enter valid format like 23455,46576,37475.",
                noDuplicateIds: "Duplicate Employee IDs are not allowed."
            }
        },
        errorClass: "text-danger",
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        onkeyup: function(element) {
            $(element).valid();
        }
    });

});



 
// Request report validation

$(document).ready(function () {

    // Letters only validation
    $.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Letters only please");

    $("#frmrequest").validate({
        rules: {
            txtrequest: {
                required: true,
            }
        },
        messages: {
            txtrequest: {
                required: "please select report type.",
            }
        },
        errorClass: "text-danger", 
        errorPlacement: function(error, element) {
            error.insertAfter(element); 
        },
        onkeyup: function(element) {
            $(element).valid(); 
        }
    });
});




//// Approve model validation start 

$(document).ready(function () {
    // =========================
    // ✅ CUSTOM METHODS
    // =========================

    $.validator.addMethod("alphanumeric", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
    }, "Employee id must contain only letters and numbers.");

    $.validator.addMethod("validEmpId", function (value, element) {
        if (this.optional(element)) return true;
        value = value.replace(/^0+/, ''); // Remove leading zeros
        return value.length > 0;
    }, "Please enter a valid employee ID.");

    $.validator.addMethod("lettersWithSingleSpace", function (value, element) {
        value = value.trim();
        return this.optional(element) || /^[A-Za-z]+( [A-Za-z]+)*$/.test(value);
    }, "Please enter a valid name.");

    // =========================
    // ✅ INPUT RESTRICTION FOR EMP ID
    // =========================
    $("#emp_id").on("input", function () {
        let value = $(this).val();
        value = value.replace(/[^a-zA-Z0-9]/g, ''); // Only letters and numbers
        if (value.length > 15) value = value.slice(0, 15); // Max 15 chars
        $(this).val(value);
    });

    // =========================
    // ✅ MODAL FORM VALIDATION
    // =========================
    $("#emp_form").validate({
        onkeyup: false,
        onfocusout: function (element) {
            $(element).valid();
        },
        rules: {
            emp_id: {
                required: true,
                alphanumeric: true,
                minlength: 3,
                maxlength: 15,
                validEmpId: true,
                remote: {
                    url: 'api/check_duplicate_empid.php',
                    type: 'post',
                    cache: false,
                    data: {
                        empid: function () {
                            return $("#emp_id").val();
                        },
                        id: function () {
                            return $("#modalRequestId").val() || '';
                        }
                    }
                }
            },
            emp_name: 
            {
                required: true,
                lettersWithSingleSpace: true
            },
            foodTime: 
            {
                required: true
            },
            company_id: "required",
            department_id: "required",
            two_times_food_allowed: "required"
        },
        messages: {
            emp_id: {
                required: "Please enter employee id.",
                alphanumeric: "Only letters and numbers are allowed.",
                minlength: "Employee id must be at least 3 characters.",
                maxlength: "Employee id must be maximum 15 characters.",
                validEmpId: "Please enter a valid employee id.",
                remote: "Employee id already exists."
            },
            emp_name: {
                required: "Please enter employee name."
            },
            foodTime: 
            {
                required: "Please select food time."
            },
            company_id: "Please select company.",
            department_id: "Please select department.",
            two_times_food_allowed: "Please select food time."
        }
    });
});