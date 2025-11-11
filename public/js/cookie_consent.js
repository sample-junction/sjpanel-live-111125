window.addEventListener("load", function(){
    window.cookieconsent.initialise({
        "palette": {
            "popup": {
                "background": "#237afc"
            },
            "button": {
                "background": "#fff",
                "text": "#237afc"
            }
        },
        "theme": "edgeless",
        "position": "bottom-left",
        "type":"opt-out",
        "dismissOnWindowClick":true,
        "onStatusChange": function(status, chosenBefore) {
            var type = this.options.type;
            var didConsent = this.hasConsented();
            if (type == 'opt-in' && didConsent) {
                $('.cc-window').css('display', 'none');
            }
            if (type == 'opt-out' && !didConsent) {
                $('.cc-window').css('display', 'none');
            }
        },
        "content": {
            "message": 'This website uses cookies to improve your experience.',
            "allow": 'Allow cookies',
            "link": 'Learn more',
            "policy": 'Cookie Policy',
            "target": '_blank',
            "deny": 'Decline',
            "href": "{{route('frontend.cms.cookie')}}"
        },
    })
});
