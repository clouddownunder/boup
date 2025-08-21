
$(document).ready(function(){

    jQuery.validator.addMethod("validpass", function (value, element) {
        if (/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}/.test(value)) {
            return true;
        } else {
            return false; };
    }, "At least one uppercase, lowercase, numeric value & special character. Minimum six characters");

    jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please");

    jQuery.validator.addMethod("noSpace", function(value, element) {
       return value.indexOf(" ") < 0 && value != "";
    }, "No space please and don't leave it empty");

    jQuery.validator.addMethod("contactNumber", function(value, element) {
       if (/^\d{10}$/.test(value)) {
        return true;
       }
       else{
        return false;
       };
    }, "Mobile Number Must be 10 digit");

    jQuery.validator.addMethod("endDate", function(value, element) {
          //var startDate = moment($('#start_date').val()).format('MM-DD-YYYY');
            var startDate = $('#start_date').val();
            console.log(startDate);
            console.log(value);
            return Date.parse(startDate) <= Date.parse(value) || value == "";
          }, "End date must be after start date");
    jQuery.validator.addMethod("weburl", function(value,element) {
      if (/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,10}(:[0-9]{1,10})?(\/.*)?$/.test(value) || this.optional(element)) {
        return true;
      } else {
        return false;
      };
    }, "Please enter valid web url.");

    $("#userProfileForm").validate({
        rules: {
            name: {
                required: true,
                noSpace:true,
                maxlength: 30,
            },
            mobile: {
                required: true,
                noSpace:false,
                number: false,
                maxlength: 15,
                minlength: 10
            }
        },
        messages: {
            name: {
                required: "Name is required."
            },
            mobile: {
                required: "Mobile is required.",
                number: "Enter only digits."
            }
        }
    });

    $("#adminlogin").validate({
        rules: {
           email: {
               required: true,
               email: true
           },
           password: {
               required: true,
           },
       },
       messages: {
           email: {
               required: "Email is required.",
               email: "Enter valid email."
           },
           password: {
               required: "Password is required.",
           },
       },
       errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            error.appendTo($("#" + name + "_validate"));
        },
    });


    $("#faqAddForm").validate({
        rules: {
           question: {
               required: true,
           },
           answer: {
               required: true,
           },
       },
       messages: {
           question: {
               required: "Question is required.",
           },
           answer: {
               required: "Answer is required.",
           },
       }
    });

    $("#faqEditForm").validate({
        rules: {
           question: {
               required: true,
           },
           answer: {
               required: true,
           },
       },
       messages: {
           question: {
               required: "Question is required.",
           },
           answer: {
               required: "Answer is required.",
           },
       }
    });


    $("#adminreset").validate({
        rules: {
           email: {
               required: true,
               email: true
           },
       },
       messages: {
           email: {
               required: "Email is required.",
               email: "Enter valid email."
           },
       },
       errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            error.appendTo($("#" + name + "_validate"));
        },
    });

    $("#adminresetpassword").validate({
        rules: {
           email: {
               required: true,
               email: true
           },
           password: {
               required: true,
               noSpace: true,
           },
           password_confirmation: {
               required: true,
               equalTo: "#password",
           },
       },
       messages: {
           email: {
               required: "Email is required.",
               email: "Enter valid email."
           },
           password: {
               required: "Password is required.",
           },
           password_confirmation: {
               required: "Confirm password is required.",
               equalTo: "Password and confirm password does not match.",
           },
       },
       errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            error.appendTo($("#" + name + "_validate"));
        },
    });

    /*End*/

    // logout
    $("#adminlogout").click(function() {
        event.preventDefault();
        $("#modalConfirmLogout").modal('show');
    });

    $("#messageEditForm").validate({
        rules: {
            message: {
                required: true,
            },
        },
        messages: {
            message: {
                required: "Message is required.",
            },
        },
    });

    $("#resetPassword").validate({
        rules: {
           email: {
               required: true,
               email: true
           },
           password: {
               required: true,
               validpass:true
           },
           password_confirmation: {
               required: true,
               equalTo: "#password",
           },
       },
       messages: {
           email: {
               required: "Email is required.",
               email: "Enter valid email."
           },
           password: {
               required: "Password is required.",
               validpass: "At least one uppercase, lowercase, numeric value & special character. Minimum six characters"
           },
           password_confirmation: {
               required: "Confirm password is required.",
               equalTo: "Password and confirm password does not match.",
           },
       },
    });


    $("#changePassword").validate({
        rules: {
            current_password: {
                required: true,
            },
            new_password: {
                required: true,
                minlength : 8,
                noSpace: true,
            },
            new_password_confirmation: {
                required: true,
                equalTo: "#new_password",
            },
        },
        messages: {
            current_password: {
                required: "Current password is required.",
            },
            new_password: {
                required: "New password is required.",
            },
            new_password_confirmation: {
                required: "Confirm password is required.",
                equalTo: "Password and confirm password does not match.",
            },
        },
    });


    $("#userEditForm").validate({
        rules: {
            name: {
                required: true,
                noSpace:true,
                maxlength: 30,
            },
            last_name: {
                required: true,
                noSpace:true,
                maxlength: 30,
            },
            country: {
                required: true,
                noSpace:true,
            }
            // mobile: {
            //     required: true,
            //     noSpace:true,
            //     number: true,
            //     maxlength: 15,
            //     minlength: 10
            // }
        },
        messages: {
            name: {
                required: "First name is required."
            },
            last_name: {
                required: "Last name is required."
            },
            country: {
                required: "Country is required."
            }
            // mobile: {
            //     required: "Mobile is required.",
            //     number: "Enter only digits."
            // }
        }
    });

    $("#editAff").validate({
      rules:{
        url:{
          required:true
        }
      },
      messages:{
        url:{
          required:"Website Link is required."
        }
      }
    })


    $("#addAff").validate({
      rules:{
        affimage:{
          required:true
        },
        url:{
          required:true
        },
        business:{
            required:true
        },
        email:{
            required:true
        },
        phone:{
            required:true
        },
        name:{
            required:true
        },
        
      },
      messages:{
        affimage:{
          required:"Affiliate Logo is required."
        },
        url:{
            required: "Website Link is required."
          },
          business:{
            required :"Business Name is required."
          },
          email:{
              required:"Email is required."
          },
          phone:{
              required:"Phone number is required."
          },
          name:{
              required:"Name is required."
          },
      }
    })

    $("#addProgram").validate({
        rules:{
            title:{
                required:true
            },
            subtitle: {
                required: true
            },
            // program_duration:{
            //     required:true
            // },
            session_week:{
                required:true
            },
            description:{
                required:true
            },
            session_price:{
                required:true
            },
            "ageGroup[]": {
                required: true
            },
            "day[]": {
                required: true
            },
            "starttime[]": {
                required: true
            },
            "endtime[]": {
                required: true
            },
            "location[]": {
                required: true
            },
        },
        messages:{
            title:{
                required:"Title is required."
            },
            subtitle: {
                required: "Sub Title is required.."
            },
            // program_duration:{
            //     required: "Program duration is required."
            // },
            session_week:{
                required:"Total Session is required."
            },
            session_price:{
                required:"Session price is required."
            },
            description:{
                required:"Description is required."
            },
            "ageGroup[]": {
                required: "Please add age group fields."
            },
            "day[]": {
                required: "Please add day fields."

            },
            "starttime[]": {
                required: "Please add start time fields."

            },
            "endtime[]": {
                required: "Please add end time fields."

            },
            "location[]": {
                required: "Please add location fields."

            },
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") === "ageGroup[]") {
                error.appendTo("#keyNutritionsError");
            } else {
                error.insertAfter(element);
            }
        }
    })
});
