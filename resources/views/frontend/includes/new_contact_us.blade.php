<div class="row mt-5 text-center d-flex justify-content-center">

    <div class="col-12 col-lg-10 text-center shadow rounded-4 mb-5">

        <div class="row">

            <div class="col-lg-6 col-md-6 col-sm-12 text-start p-5 contact-round-1" style="background: #0F0E2C;">

                <p class="text-light" style="font-size: 28px; font-weight: 600;">{{__('frontend.index.contact_us_new.info')}}</p>


                <div class="row mt-5">

                    <div class="col-2"><img src="images/email.webp" loading="lazy" alt="survey sites free" width="27" height="27" class="img-fluid"></div>

                    <div class="col text-start p-0">
                        <p class="text-light" style="font-size: 17px;">support@sjpanel.com</p>
                    </div>

                </div>

                <div class="row mt-2">

                    <div class="col-2"><img src="images/location.webp" loading="lazy" alt="free online survey sites" width="27" height="27" class="img-fluid"></div>

                    <div class="col text-start p-0">
                        <!-- <p class="text-light m-0" style="font-size: 18px; font-weight:600">{{__('frontend.index.contact_us_new.headquater')}}</p> -->
                        <p class="text-light" style="font-size: 17px;">Suite 117, 9131 Keele St Suite A4, Vaughan, ON L4K 0G7</p>
                    </div>

                </div>

                <!-- <div class="row mt-4">

                    <div class="col-2"><img src="images/location.png" alt="icon" class="img-fluid"></div>

                    <div class="col text-start p-0">
                        <p class="text-light" style="font-size: 17px;">{!! __('frontend.index.contact_us.details_7') !!}</p>
                    </div>

                </div> -->


                <div class="row mt-2">

                    <div class="col-2"><img src="images/email.webp" loading="lazy" alt="market research online surveys" width="27" height="27" class="img-fluid"></div>

                    <div class="col text-start p-0">
                        <p class="text-light" style="font-size: 17px;">{{__('frontend.index.contact_us_new.sub_title')}} <a href="https://www.samplejunction.com/" style="text-decoration:none;" class="text-light" target="_blank">www.samplejunction.com</a></p>
                    </div>

                </div>


                <p class="text-light mt-5 pt-5">{!! __('frontend.index.contact_us.mailing_social_connection') !!}</p>

                <div class="mt-4">
                    <a href="//facebook.com/SJPanel" target="_blank"><img src="images/fimg.webp" loading="lazy" alt="SJ Panel Facebook" width="53" height="50" class="img-fluid me-2 me-lg-4"></a>
                    <a href="https://www.instagram.com/sjpanelsurveyplatform/" target="_blank"><img src="images/instaimg.webp" loading="lazy" alt="SJ Panel Instagram" class="img-fluid me-4 me-lg-5" width="40" height="40"></a>
                    <a href="https://x.com/sjpanelsurvey" target="_blank"><img src="images/Twitter-X-icon.webp" loading="lazy" width="30" height="30" alt="SJ Panel Twitter" class="img-fluid me-4 me-lg-5" style="transform: translateX(-7px);"></a>
                    <a href="https://www.youtube.com/@sjpanelsurvey" target="_blank"><img src="images/youtube-icon.webp" loading="lazy" alt="SJ Panel Youtube" class="img-fluid me-4 me-lg-5" style="scale:1.8; transform: translateX(-4px); width: 23px; height: 23px;"></a>
                    <a href="https://www.linkedin.com/company/sjpanel" target="_blank"><i class="fa-brands fa-linkedin text-light" style="scale:1.8; transform: translateX(-4px);"></i></a>
                </div>


            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 text-start p-4 p-md-5 position-relative contact-round-2">

                {{html()->form('POST',route('frontend.auth.send.email'))->id('contact-us')->open()}}

                <div class="mb-4">
                    <p class="mb-2" style="font-weight: 500;">{{__('frontend.index.contact_us.name')}}</p>
                    <input type="text" id="inlineFormInputGroupUsername" name="name" class="contact">
                </div>

                <div class="mb-4">
                    <p class="mb-2" style="font-weight: 500;">{{__('frontend.index.contact_us.email')}}</p>
                    <input type="email" id="inlineFormInputGroupUsername" name="email" class="contact">
                </div>

                <div class="mb-4">
                    <p class="mb-2" style="font-weight: 500;">{{__('frontend.index.contact_us.message')}}</p>
                    <textarea id="textContact" name="messages" rows="4" cols="50" class="contact">

                        </textarea>
                </div>

                <div>

                    <div class="d-flex align-items-start label_text"><input type="checkbox" value="1" class="form-check-input mt-1" name="consent" style="width: 16px; height: 16px;"><span class="ms-2" style="font-size:12px">{{__('frontend.index.contact_us.consent_1')}}<a href="{{route('frontend.cms.term_condition')}}"> {{__('frontend.index.contact_us.consent_2')}}</a> & <a href="{{route('frontend.cms.privacy')}}">{{__('frontend.index.contact_us.consent_3')}}</a></span></div>

                    <button class="g-recaptcha btn btn-primary ps-5 pe-5 mt-4 pt-2 pb-2" type="submit" style="font-size: 17px; font-weight: 500;" onclick="onSubmitData()"
                        data-sitekey="{{config('settings.RECAPTCHA_SITE_KEY')}}" data-callback="onSubmit">{{__('frontend.index.contact_us.button')}}</button>
                </div>

                {{html()->form()->close()}}


                <p class="mt-5" style="color: #858B91; font-size: 12px; line-height: 20px;">{{__('frontend.index.contact_us_new.text')}}</p>


                {{-- <div class="position-absolute end-0 bottom-0 d-none d-lg-block" style="transform: translate(30%,15px);">

                    <span class="pt-3 pb-3 ps-4 pe-4 rounded-3" style="background: #EEEEEE; font-weight: 600; font-size: 17px;"><span class="me-2"><img src="images/msg-box.webp" loading="lazy" width="30" height="30" alt="legit survey to earn money" class="img-fluid"></span>
                        <a href="javascript:void(Tawk_API.toggle())" id="chat_us" style="text-decoration:none" class="text-dark">
                            {{__('frontend.index.contact_us_new.start_chat')}}
                        </a>
                    </span>

                </div> --}}

            </div>



        </div>

    </div>

</div>


<div class="row d-lg-none">

    <div class="col-12 text-center d-flex justify-content-center">

        {{-- <p class="pt-3 pb-3 ps-5 pe-5 rounded-3" style="width:90%; background: #EEEEEE; font-weight: 600; font-size: 17px;"><span class="me-2"><img src="images/msg-box.webp" loading="lazy" alt="surveys that give you money" width="100" height="80" class="img-fluid"></span> 
             <a href="javascript:void(Tawk_API.toggle())" id="chat_us" style="text-decoration:none" class="text-dark">
                {{__('frontend.index.contact_us_new.start_chat')}}
            </a> 
        </p> --}}

    </div>

</div>

@push('after-styles')
<style>


</style>
@endpush
@push('after-scripts')
<script>
    function onSubmit(token) {
        $('#loading').show();
        $('form#contact-us').submit();
    }

    // Validation Code Updated by Vikas
    async function onSubmitData(e) {
        if (e) e.preventDefault();

        $('#load').show();
        let name = $('input[name="name"]').val().trim();
        let email = $('input[name="email"]').val().trim();
        let message = $('textarea[name="messages"]').val().trim();
        let consent = $('input[name="consent"]').is(':checked');

        $('.text-danger').remove();
        let isValid = true;

        const showError = function(selector, message) {
            const $field = $(selector);
            const $error = $('<div class="text-danger" style="font-size:15px;"></div>').text(message);
            if ($field.parent().find('.text-danger').length === 0) {
                $field.parent().append($error);
            }
        };

        // check only 3 consecutive identical chars
        function hasTripleConsecutive(str) {
            return /(.)\1{2,}/.test(str);
        }

        // Common TLD list (expandable)
        const validTLDs = [
            "com","org","net","edu","gov","mil","int",
            "info","biz","co","io","ai","in","uk","us","ca","au","de","fr","jp"
        ];

        function isValidDomain(domain) {
            const domainRegex = /^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!domainRegex.test(domain)) return false;

            let parts = domain.split(".");
            let tld = parts.slice(-2).join(".").toLowerCase(); // last 2 parts bhi check karo

            return validTLDs.includes(parts[parts.length - 1].toLowerCase()) || validTLDs.includes(tld);
        }


        // Name Validation
        if (name === '') {
            showError('input[name="name"]', '{{__('frontend.index.contact_us_new.name_validate_1')}}');
            isValid = false;
        } else if (name.length < 2) {
            showError('input[name="name"]', '{{__('frontend.index.contact_us_new.name_validate_2')}}');
            isValid = false;
        } else if (name.length > 15) {
            showError('input[name="name"]', '{{__('frontend.index.contact_us_new.name_validate_3')}}');
            isValid = false;
        } else if (hasTripleConsecutive(name)) {
            showError('input[name="name"]', '{{__('frontend.index.contact_us_new.name_validate_4')}}');
            isValid = false;
        } else if (!/^[A-Za-z]+$/.test(name)) {
            showError('input[name="name"]', '{{__('frontend.index.contact_us_new.name_validate_5')}}');
            isValid = false;
        }

        // Email Validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email === '') {
            showError('input[name="email"]', '{{__('frontend.index.contact_us_new.email_validate_1')}}');
            isValid = false;
        } else if (!emailRegex.test(email)) {
            showError('input[name="email"]', '{{__('frontend.index.contact_us_new.email_validate_2')}}');
            isValid = false;
        } else if (email.length > 254) {
            showError('input[name="email"]', '{{__('frontend.index.contact_us_new.email_validate_3')}}');
            isValid = false;
        } else {
            let parts = email.split('@');
            if (parts[0].length > 64) {
                showError('input[name="email"]', '{{__('frontend.index.contact_us_new.email_validate_4')}}');
                isValid = false;
            }
            if (parts[1].length > 255) {
                showError('input[name="email"]', '{{__('frontend.index.contact_us_new.email_validate_5')}}');
                isValid = false;
            } else if (!isValidDomain(parts[1])) {
                showError('input[name="email"]', '{{__('frontend.index.contact_us_new.email_validate_6')}}');
                isValid = false;
            }
        }

        // Message Validation
        if (message === '') {
            showError('textarea[name="messages"]', '{{__('frontend.index.contact_us_new.message_validate_1')}}');
            isValid = false;
        } else if (message.length < 2) {
            showError('textarea[name="messages"]', '{{__('frontend.index.contact_us_new.message_validate_2')}}');
            isValid = false;
        } else if (message.split(/\s+/).filter(Boolean).length > 200) {
            showError('textarea[name="messages"]', '{{__('frontend.index.contact_us_new.message_validate_3')}}');
            isValid = false;
        } else if (hasTripleConsecutive(message)) {
            showError('textarea[name="messages"]', '{{__('frontend.index.contact_us_new.message_validate_4')}}');
            isValid = false;
        }

        // Consent Validation
        if (!consent) {
            showError('input[name="consent"]', '{{__('frontend.index.contact_us_new.termscondition_validate')}}');
            isValid = false;
        }

        if (!isValid) {
            $('#load').hide();
            return false;
        }

        e.target.submit();
    }


    $(document).ready(function() {
        $('input.contact, textarea.contact').on('keyup', function() {
            $(this).siblings('.text-danger').remove();
        });

        $('input[name="consent"]').on('change', function() {
            $(this).siblings('.text-danger').remove();
        });

        $('form#contact-us').on('submit', function(e) {
            onSubmitData(e);
        });
    });

    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    // (function() {
    //     var s1 = document.createElement("script"),
    //         s0 = document.getElementsByTagName("script")[0];
    //     s1.async = true;
    //     s1.src = 'https://embed.tawk.to/640852554247f20fefe4a6c3/1gr083899';
    //     s1.charset = 'UTF-8';
    //     s1.setAttribute('crossorigin', '*');
    //     s0.parentNode.insertBefore(s1, s0);
    // })();
</script>
@endpush
