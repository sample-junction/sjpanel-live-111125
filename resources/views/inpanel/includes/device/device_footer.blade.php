<style type="text/css">
    @media(min-width:768px) and (max-width:982px){
        #footer_crt{
            text-align: center !important;
            width: 100% !important;
        } 
        #footer_dt{
            text-align: center !important;
            width: 100% !important;
        }
    }
</style>
 <footer >



                <div class="row mt-5 pt-3 rounded" style="background-color: white;">

                    <div class="col-sm-12 col-md-4 text-center text-md-start">

                        <small>{{__('frontend.register.static.footer_title_3')}} &reg; 2015 - {{ date('Y') }}</small>

                    </div>

                    <div class="col-sm-12 col-md-8 text-center text-md-end">

                        <ul style="list-style-type: none;" class="footer-ul pe-3 pe-md-0">
                        
                            <li><a href="{{route('frontend.cms.privacy')}}" target="_blank">{{__('inpanel.footer.title_1')}} |</a></li>
                            <li><a href="{{route('frontend.cms.cookie')}}" target="_blank">{{__('strings.emails.auth.confirmation.cookie')}} |</a></li>
                            <li><a href="{{route('frontend.cms.rewards_policy')}}" target="_blank">{{__('frontend.index.footer.links.reward_policy')}} |</a></li>
                            <li><a href="{{route('frontend.cms.referral_policy')}}">{{__('frontend.index.footer.links.referral_policy')}} |</a></li>
                            <li><a href="{{route('frontend.cms.safeguard')}}" target="_blank">{{__(('inpanel.footer.title_2'))}} |</a></li>
                            <li><a href="{{route('frontend.cms.term_condition')}}" target="_blank">{{__('frontend.index.footer.links.term_condition')}} |</a></li>
                            <li><a href="{{route('frontend.cms.faq')}}" target="_blank">{{__('inpanel.footer.title_3')}} |</a> </li>
                            <li><a href="{{route('frontend.cms.help_support')}}" target="_blank">{{__('frontend.nav.static.heading_4')}}</a> </li>

                        
                        </ul>

                    </div>
                    
                </div>


            </footer>

            @push('after-scripts')

            <script>
                var all_li_nav = document.querySelectorAll('.side-menu-li');
                console.log(all_li_nav);

                all_li_nav.forEach( (item)=> {


                    item.addEventListener('click', () => {

                        // item.style.visibility = 'hidden';

                        // for(let i = 0; i < all_li_nav.length; i++){
                        //     all_li_nav[i].classList.remove('cst-active');
                        // }

                    });

                });

            </script>  

            @endpush
