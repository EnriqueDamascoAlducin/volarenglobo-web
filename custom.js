var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5aaaf4a8d7591465c7089bba/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();


    (function () {
        var options = {
            facebook: "volarenglobomex", // Facebook page ID
            whatsapp: "+5215524900000", // WhatsApp number
            email: "ventas@volarenglobo.com.mx", // Email
            call: "5558706611", // Call phone number
            company_logo_url: "//volarenglobo.com.mx/images/volar-en-globlo-logo_3.gif", // URL of company logo (png, jpg, gif)
            greeting_message: "¿Necesitas asistencia o mayor Información?", // Text of greeting message
            call_to_action: "Chat en Linea", // Call to action
            button_color: "#A8CE50", // Color of button
            position: "right", // Position may be 'right' or 'left'
            order: "facebook,whatsapp,email,call" // Order of buttons
        };
        var proto = document.location.protocol, host = "whatshelp.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();