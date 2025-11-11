<!-- footer -->

<div class="row mt-5 ps-1 pe-1">

    <div class="col-12 text-center" >

        <a href="/"><img src="https://pub-833cd4d3a7c946e2a7899f82004e7fa2.r2.dev/SJ%20Panel%20New%20LOGO%20without%20background.png" alt="surveys that pay immediately" class="img-fluid" width="150px"></a>

    </div>

    <!-- <div class="col-12 mt-3 text-center" >

        <p style="font-weight: 600;" class="text-dark">{{__('frontend.index.footer.links.footer_content')}}</p>

    </div> -->

    <div class="col-12 mt-4 text-center pb-4 border-bottom">

        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.privacy')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.privacy_policy')}}</a> </span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.cookie')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.cookie_policy')}}</a> </span>
        <span class="me-3 me-lg-4"><a href="{{route('frontend.cms.rewards_policy')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.reward_policy')}}</a></span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.referral_policy')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.referral_policy')}}</a> </span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.safeguard')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.Safeguards')}}</a> </span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.term_condition')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.term_condition')}}</a> </span>
        <span class="me-3 me-lg-4"> <a href="{{route('frontend.cms.faq')}}" class="text-black " style="text-decoration: none;">{{__('frontend.index.footer.links.FAQ')}}</a> </span>
        <span class=""> <a href="{{route('frontend.blog')}}" class="text-black " style="text-decoration: none;">{{__('frontend.nav.static.heading_6')}}</a> </span>
       

    </div>

    <div class="col-12 col-lg-6 text-center text-lg-start mt-3 mt-lg-4">
        <p class="mt-1 ">{{__('frontend.index.footer.links.copy_right_company')}}</p>
    </div>

    <div class="col-12 col-lg-6 text-center text-lg-end mt-lg-4">
        <p class="mt-lg-1">{{__('frontend.index.footer.links.copy_right_company2')}}{{ date('Y') }}</p>
    </div>

</div>

<script>
    // $('select#country').on('change',function(e){
    //     var country_code = $('select#country').val();
    //     console.log('sdfsd',country_code)
    //     fetchLanguage(country_code)
    // });

    // function fetchLanguage(country_code)
    // {
    //    var countryName={};
    //    countryName['US']='USA.png';
    //    countryName['CA']='CANADA.png';
    //    countryName['AU']='AUSTRALIA.png';
    //    countryName['ES']='SPAIN.png';
    //    countryName['DE']='GERMANY.png';
    //    countryName['UK']='UNITED KINGDOM.png';
    //    countryName['IN']='INDIA.png';
    //    countryName['FR']='FRANCE.png';
    //    countryName['IT']='ITALY.png';
    //    countryName['NL']='NETHERLAND.png';

       
    //    country_flag=countryName[country_code];
    //    //$('#img_01').attr('src','img/'+country_flag);

    //     var header = {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //     }
    //     if(!country_code || country_code == 0){
    //         return false;
    //     }
    //     axios.get("{{route('frontend.auth.language')}}",{
    //         params:{
    //             country_code: country_code,
    //         }
    //     }).then(function (response) {
    //         if(response.status === 200){
    //             $select = $('#language');
    //             $select.find('option').remove();
    //             var lang = response.data;
    //             $.each(lang, function (value, name) {
    //                 $select.append($('<option />', {value: value, text: name}));
                    
    //             });
                
    //         }
    //     }).catch(function (error) {
    //         // handle error
    //     }).then(function () {
    //         // always executed
    //         console.log('always executed');
    //     });
    // }
</script>



