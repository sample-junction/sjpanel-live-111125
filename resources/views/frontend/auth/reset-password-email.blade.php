@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('labels.frontend.auth.register_box_title'))

@push('after-styles')

 <!-- Bootstrap Core CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" 
    rel="stylesheet"  type='text/css'>

    <link href="{{ asset('vendor/css/plugins/datapicker/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{asset('css2/style2.css')}}" rel="stylesheet">
    <link href="{{asset('css2/bootstrap4.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css2/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css2/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css2/bootstrap.rtl.css')}}" rel="stylesheet">
    <link href="{{asset('css2/bootstrap.rtl.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css2/bootstrap-grid.css')}}" rel="stylesheet">
    <link href="{{asset('css2/bootstrap-grid.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css2/bootstrap-grid.rtl.css')}}" rel="stylesheet">
    <link href="{{asset('css2/bootstrap-grid.rtl.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css2/bootstrap-reboot.css')}}" rel="stylesheet">
    <link href="{{asset('css2/bootstrap-reboot.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css2/bootstrap-reboot.rtl.css')}}" rel="stylesheet">
    <link href="{{asset('css2/bootstrap-reboot.rtl.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css2/bootstrap-utilities.css')}}" rel="stylesheet">
    <link href="{{asset('css2/bootstrap-utilities.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css2/bootstrap-utilities.rtl.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css2/bootstrap-utilities.rtl.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
   <style>
   .Thank_text_h1{
	   font-size:24px !important;
    padding: 10px !important;
}   
   #email-error{
	   bottom:308px !important;
   }
   .gradient-custom-2 {
/* fallback for old browsers */
background: #006BDE;
display: grid !important;

}

#contain-div-1{
  border-radius: 10px 0px 0px 10px;
}
.div_m_t p{
    color: #757575 !important;
    font-size: 16px !important;
}
.footer_style{
  bottom: -56px;
}

@media(min-width: 220px) and (max-width:767px){
  /*#contain-div-1{
    display: none !important;
  }*/
  footer.footer_style{
    /*display: none !important;*/
  }
   .div_m_t .image_center {
    margin-top: 0px !important;
}
}

@media (min-width: 768px) and (max-width: 981px){
  .footer_style{
      margin-top: 165px !important;
  }
}
   </style>

@endpush

@section('content')


  <div id="container"><!-- main container starts-->
    <div id="wrapp"><!-- main wrapp starts-->
        <nav class="navbar navbar-expand-lg navbar-dark  static-top">
          <div class="container Nav-div" >
          <a class="navbar-brand" id="navbar-brand" href="{{ env('APP_URL') }}">
              <img src="/img/SJ Panel New LOGO without background.png" alt="legit survey websites that pay" class="img-fluid">
            </a>
            <!--<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button> -->
          
            <span class="navbar-brand-2 " id="span-1"><span class="already">{{__('frontend.index.contact_us.not_register')}} </span> <a href="{{url('/')}}/register" style="color: #006BDE;">
             {{__('frontend.index.how_it_works.title_action')}}
            </a></span>
          </div>
        </nav><!-- header ends-->
        
    </div>
  </div>

<div id="line"></div>

<div class="container" style="margin-bottom: 10px;">
    <section class="h-100 gradient-form">
      <div class="container py-5 h-100" id="card">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-xl-12">
            <div class="card rounded-3 text-black">
              <div class="row g-0" width="25px">
                
                <div class="col-lg-6  align-items-center gradient-custom-2" id="contain-div-1">
                  <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                    <img src="{{ asset('img/login_user.png')}}" alt="surveys that pay immediately" class="image_center"/>
                    <h4 class="mb-4 text_margin_style">{{__('frontend.index.contact_us.opinion')}}</h4>
                    <p class="small mb-0 p_open">{{__('frontend.index.contact_us.join')}}<br />
                    {{__('frontend.index.contact_us.join_1')}}</p>                
                    <div class="row div_m">
                      <div class="col-3 img-1">
                        <div class="icon_style">
                          <img src="{{ asset('img/Vector.png')}}" alt="paid survey sites that are legit" class="icon_padding_style " style="padding-top: 10px;"/>
                        </div>        
                        <h2 class="icon_heading sign">{{__('frontend.index.contact_us.signup_for')}}</h2>          
                      </div>

                      <div class="col-3 border-center img-2">
                      <div class="icon_style"><img src="{{ asset('img/Group.png')}}" alt="genuine survey sites" class="icon_padding_style" style="padding-left: 14px;"/></div>
                      <h2 class="icon_heading">{{__('frontend.index.how_it_works.title_subhead_4')}}</h2>
                      </div>
                      <div class="col-3 border-center2 img-3">
                      <div class="icon_style"><img src="{{ asset('img/Group 70.png')}}" alt="best survey site" class="icon_padding_style"/></div>
                      <h2 class="icon_heading">{{__('frontend.index.contact_us.take_survey')}}</h2>
                      </div>
                      <div class="col-3 border-center3 re-image">
                      <div class="icon_style"><img src="{{ asset('img/Vector-1.png')}}" alt="online survey site" class="icon_padding_style" style="padding-left: 12px;"/></div>
                      <h2 class="icon_heading">{{__('frontend.index.contact_us.redeem_rewards')}}</h2>
                      </div>
                    </div>
                  </div>
                </div>
            
            <div class="col-lg-6 div_m_t">
              

                <img src="{{ asset('img/thank reset pass.png')}}" alt="paid online survey" class="image_center" />
                <h4 class="mb-4 text_margin_style Thank_text_h1">{{__('frontend.index.contact_us.reset-thanks_1')}}</h4>
                <p class="small mb-0 p_open" style="color: black !important;">{{str_replace('#EMAIL',$email,__('frontend.index.contact_us.reset-thanks_2'))}}<br /> </p>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</section>




 </div> 	
   

   <footer class="footer_style" style="background:#E6E6E6;">
    <div class="container">
        <div class="row text-center">
             <div class="pull-left col-lg-6 col-xs-12 d-none d-md-block " style="text-align:start !important">
                <p><a href="#" style="color: black;" class="copyright">{{__('frontend.index.footer.links.copyright_sj',['year' => date('Y')])}}</a></p>
            </div>
            <div class="col-lg-6 col-lg-offset-4 col-xs-12">
              <div class="pull_right_style">
                <p style="padding-right: 2px;">
                  <a href="{{ route('frontend.cms.privacy') }}" class="policies" style="color: black;">{{__('frontend.index.contact_us.consent_3')}}</a> <span class=""> | </span>
                  <a href="{{ route('frontend.cms.cookie') }}" class="" style="color: black;">{{__('frontend.index.footer.links.cookie_policy')}}</a> <span class=""> | </span>
                  <a href="{{ route('frontend.cms.rewards_policy') }}" class=" pol" style="color: black;">{{__('frontend.index.footer.links.reward_policy')}}</a> <span cl
                  class=" pol"> | </span> 
                  <a href="{{ route('frontend.cms.referral_policy') }}" class=" pol" style="color: black;">{{__('frontend.index.footer.links.referral_policy')}}</a> <span cl
                  class=" pol"> | </span> 
                  <a href="{{ route('frontend.cms.safeguard') }}" class="Policy" style="color: black;">{{__('frontend.index.footer.links.Safeguards')}}</a> <span cl
                  class="policy"> | </span> 
                  <a href="{{ route('frontend.cms.term_condition') }}"  style="color: black;" class="terms policy"> 
                    {{__('frontend.index.footer.links.term_condition')}}</a> <span cl
                    class="policy"> | </span> 
                    <a href="{{ route('frontend.cms.faq') }}" style="color: black;" class="policy">{{__('frontend.index.footer.links.FAQ')}}</a></p>
              </div>
            </div>
             <div class="pull-left col-lg-6 col-xs-12 d-sm-none mt-3">
                <p><a href="#" style="color: black;" class="copyright">{{__('frontend.index.footer.links.copyright_sj',['year' => date('Y')])}}</a></p>
            </div>
        </div>
    </div>
</footer>

@endsection
    
    

