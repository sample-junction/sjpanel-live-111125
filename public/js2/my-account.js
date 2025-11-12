
            function myFun(){
                var base = document.getElementById("basic_prof");
                // base.style.visibility = 'visible';
                base.style.display = 'block';
                document.getElementById('')
                document.getElementById('security').classList.remove('Show');
                document.getElementById('email_frequency').classList.remove('Show');
                document.getElementById('my_data').classList.remove('Show');
                document.getElementById('deactive_account').classList.remove('Show');
                document.getElementById('delete').classList.remove('Show');
            }
            function myFun1(){
                // document.getElementById('security').style.display = 'block';
                document.getElementById('security').classList.add('Show');
                document.getElementById('basic_prof').style.display = 'none';
                document.getElementById('email_frequency').classList.remove('Show');
                document.getElementById('my_data').classList.remove('Show');
                document.getElementById('deactive_account').classList.remove('Show');
                document.getElementById('delete').classList.remove('Show');
            }
            function myFun2(){
                document.getElementById('email_frequency').classList.add('Show');
                document.getElementById('security').classList.remove('Show');
                document.getElementById('basic_prof').style.display = 'none';
                document.getElementById('my_data').classList.remove('Show');
                document.getElementById('deactive_account').classList.remove('Show');
                document.getElementById('delete').classList.remove('Show');
            }
            function myFun3(){
                document.getElementById('email_frequency').classList.remove('Show');
                document.getElementById('security').classList.remove('Show');
                document.getElementById('basic_prof').style.display = 'none';
                document.getElementById('my_data').classList.add('Show');
                document.getElementById('deactive_account').classList.remove('Show');
                document.getElementById('delete').classList.remove('Show');
            }

            function myFun4(){
                document.getElementById('email_frequency').classList.remove('Show');
                document.getElementById('security').classList.remove('Show');
                document.getElementById('basic_prof').style.display = 'none';
                document.getElementById('my_data').classList.remove('Show');
                document.getElementById('deactive_account').classList.add('Show');
                document.getElementById('delete').classList.remove('Show');
            }

            function myFun5(){
                document.getElementById('email_frequency').classList.remove('Show');
                document.getElementById('security').classList.remove('Show');
                document.getElementById('basic_prof').style.display = 'none';
                document.getElementById('my_data').classList.remove('Show');
                document.getElementById('deactive_account').classList.remove('Show');
                document.getElementById('delete').classList.add('Show');
            }
            

    document.querySelectorAll(".basic_profile").forEach((ele) =>
            ele.addEventListener("click", function (event) {
            event.preventDefault();
       document.querySelectorAll(".basic_profile")
            .forEach((ele) => ele.classList.remove("active_color"));
            this.classList.add("active_color")
  })
);

$(document).ready(function(){

$('#my_profile_details a').on('click', function(){

    var bar = $('#my_profile_details');

    var barWidth = bar.width();

    var barScrollLeft = bar.scrollLeft();

    var barOffset = bar.offset().left;

    var tab = $(this).closest('a');

    var tabOffset = tab.offset().left;

    var tabWidth = tab.outerWidth();

    // alert (tabOffset + "<>" + tabWidth);

   

    var scrollOffset = (barWidth / 2) - (tabWidth /2);

    var scrollTo;

    if(tabOffset < barOffset ){

        scrollTo = barScrollLeft - (barOffset - tabOffset) - scrollOffset;

    }

    else if(tabOffset + tabWidth > barOffset + barWidth){

        scrollTo = barScrollLeft + tabOffset + tabWidth - (barOffset + barWidth) + scrollOffset;

    }

    bar.animate({

        scrollLeft: scrollTo

    }, 500);

   

});

});


$(document).ready(function() {
    $('#MyData').on('click' , function() {
        // alert("hii");
        $('#footer').addClass('footer_va');
    });
    $('#footer').removeClass('footer_va');
});

$(document).ready(function() {
    $('.basicProfile').on('click' , function() {
        // alert("hii");
        if($('#footer').hasClass('footer_va')){
            $('#footer').removeClass('footer_va');
        }
    });
    
});




$(document).ready(function() {
    $('.first_eye').on("click" , function(event) {
        event.preventDefault();
        // alert('click')
        if($('#security_1 input').attr("type") == "text"){
            $('#security_1 input').attr('type' , 'password');
            $('#security_1 i').addClass('fa-eye-slash');
            $('#security_1 i').removeClass('fa-eye');
        }
        else if($('#security_1 input').attr("type") == "password"){
            $('#security_1 input').attr('type' , 'text');
            $('#security_1 i').addClass('fa-eye');
            $('#security_1 i').removeClass('fa-eye-slash');
        }
    });
});

$(document).ready(function() {
$('.second_eye').on("click" , function(event) {
        event.preventDefault();
        // alert('click')
        if($('#security_2 input').attr("type") == "text"){
            $('#security_2 input').attr('type' , 'password');
            $('#security_2 i').addClass('fa-eye-slash');
            $('#security_2 i').removeClass('fa-eye');
        }
        else if($('#security_2 input').attr("type") == "password"){
            $('#security_2 input').attr('type' , 'text');
            $('#security_2 i').addClass('fa-eye');
            $('#security_2 i').removeClass('fa-eye-slash');
        }
    });
});

// function scrollSwitch(){
//     var icon =  document.getElementById('scroll-img');
//     var icon2 =  document.getElementById('image1');
//     // alert('shop')
//     // icon.classList.add('scrollImg');
//     icon.classList.toggle('scrollImg');
//     icon2.classList.toggle('scrollImg2');
//     e.preventDefault();
//     var headers = {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
//     }
//     jQuery('.question_loader').show();
//     $('.two_fact_setting').html('');
//     axios.get("{{ route('inpanel.user.profile.two_fact_auth.setting') }}").then(function (response) {
//         if (response.status === 200) {
//             console.log("Success");
//             //window.location.reload();
//             swal({
//         title: ''+"{{__('inpanel.dashboard.pop_up.title')}}",
//         html: "<h5>{{__('inpanel.dashboard.pop_up.content')}}</h5>",
//         type: "{{__('inpanel.dashboard.pop_up.title_5')}}",
//         customClass: 'swal-wide',
//         showCancelButton: false,
//         confirmButtonColor: "#1080d0",
//         confirmButtonText: "Ok",
//         //cancelButtonText: "Cancel",
//         closeOnConfirm: true
//     }).then((result) => {
        
//          if (result.value===true) {
//             window.location.href = "/logout";
//          } 
//          else if(result.value == undefined) {
//              window.location.href = "/logout";
//          }
//     });
//         }
//     }).catch(function (error) {
//         alert('error occured');
//         console.log(error);
//     }).then(function () {
//         jQuery('.question_loader').hide();
//     }); 
// }

// function close(){
//     var clo = document.getElementById('DEACTIVE');
//     console.log("5");
//     alert('5');
//     clo.style.display = "none"; 
// }

// $("body").click(function(){
//         if($('.offcanvas ').hasClass('show')){
//             $('.offcanvas-backdrop ').remove();
//             $('.btn-close').click();

//         }
//     });

function deactive(){
    var de = document.getElementById('DEACTIVE');
    // alert('hii');
    de.style.display = "block";
}

$(function(){
    $('#btn-upload').click(function(e){
        e.preventDefault();
        $('#images').click();}
    );
});



// for search icon

var sb = document.getElementById("searchBar");

var si = document.getElementById("searchIcon");

sb.addEventListener("keyup", () => {

    if(sb.value !== ''){

        si.style.visibility = 'hidden';

    }else{

        si.style.visibility = 'visible';

    }

});

$(document).on('click','a#get_started',function (e) {
    console.log("Click");
    e.preventDefault();

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    }
    jQuery('.question_loader').show();
    $('.two_fact_setting').html('');
    axios.get("{{ route('inpanel.user.profile.two_fact_auth.setting') }}").then(function (response) {
        if (response.status === 200) {
            console.log("Success2");
            //window.location.reload();
            swal({
        title: ''+"{{__('inpanel.dashboard.pop_up.title')}}",
        html: "<h5>{{__('inpanel.dashboard.pop_up.content')}}</h5>",
        type: "{{__('inpanel.dashboard.pop_up.title_5')}}",
        customClass: 'swal-wide',
        showCancelButton: false,
        confirmButtonColor: "#1080d0",
        confirmButtonText: "Ok",
        //cancelButtonText: "Cancel",
        closeOnConfirm: true
    }).then((result) => {
        
         if (result.value===true) {
            window.location.href = "/logout";
         } 
         else if(result.value == undefined) {
             window.location.href = "/logout";
         }
    });
        }
    }).catch(function (error) {
        alert('error occured');
        console.log(error);
    }).then(function () {
        jQuery('.question_loader').hide();
    });
    $('#twoFactAuth').modal('toggle');
})


$( "#verify_otp" ).submit(function( event ) {
    event.preventDefault();
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    }
    var questionForm = jQuery('form#verify_otp');
    var questionFormData = questionForm.serialize();
    var postData = questionFormData;
    console.log(postData);
    /* jQuery('.question_loader').show();
     $('.two_fact_setting').html('');*/
    axios.post("{{ route('inpanel.user.profile.two_fact_auth.verify-otp') }}",postData,headers).then(function (response) {
        if (response.status === 200) {
            if (response.data.status === false) {
                console.log("tada");
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000
                    };
                    toastr.error("{!! __('inpanel.user.profile.preferences.two_fact.error') !!}");
                }, 400);
                $('button#verify_opt_button').removeAttr('disabled');
            }else if(response.data.status === true){
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000
                    };
                    window.location.href = "{{route('inpanel.user.profile.preference.show',['two_fact_auth'])}}"
                    toastr.success( "{!! __('inpanel.user.profile.preferences.two_fact.success_messages') !!}");
                }, 400);
            }
        }
    }).catch(function (error) {
        alert('error occured');
        console.log(error);
    }).then(function () {
        jQuery('.question_loader').hide();
    });
});

function generate_uri(modal) {
    var modalDiv = modal;
    const type = "totp";
    var modalBody = $('div#twoFactAuth').find('div.two_fact_setting');
    console.log(modalBody);
    console.log(modalBody.find('div.google2fa'));
    var uri = modalBody.find('div.google2fa').find("#url").val();
    return uri;
}
function update_qr(modal) {
    var modalDiv = modal;
    const type = "totp";
    var modalBody = $('div#twoFactAuth').find('div.two_fact_setting');
    console.log(modalBody);
    console.log(modalBody.find('div.google2fa'));
    var uri = modalBody.find('div.google2fa').find("#url").val();
    const size = 200;
    $("#qr").empty().qrcode({
        text: uri,
        size: size,
    });
    if (label == "" && issuer == "") {
        $("#app_label").text("Issuer (label)");
    }
    else {
        $("#app_label").text(issuer == "" ? label : `${issuer} (${label})`);
    }
    // remove error on uri field
    $("#uri").removeClass("is-invalid");
    // mark empty required input fields
    $("#secret").toggleClass("is-invalid", secret == "");
    $("#label").toggleClass("is-invalid", label == "");
}
function decode(s) {
    return s ? decodeURIComponent(s) : undefined;
}