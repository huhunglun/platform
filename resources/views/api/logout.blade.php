<html>
<head>
<script src="http://code.jquery.com/jquery-2.2.1.min.js" integrity="sha256-gvQgAFzTH6trSrAWoH1iPo9Xc96QxSZ3feW6kem+O00=" crossorigin="anonymous"></script>
<?php

session_start();

if(isset($_GET["logout"])){
    $out = $_GET["logout"];
}
?>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '517506828428849',
            xfbml      : true,
            version    : 'v2.5'
        });

        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                console.log('Logged in.');
            }
            else {
                FB.login();
                $("#content").text('login');
            }
        });

    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


    function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    function myFacebookLogin() {
        FB.login(function(response) {
                    if (response.authResponse) {
                        console.log('Welcome!  Fetching your information.... ');
                        FB.api('/me?fields=email', function(response) {
                            console.log('Good to see you, ' + response.email + '.');
                        });
                    } else {
                        console.log('User cancelled login or did not fully authorize.');
                    }
                }, {scope: 'publish_actions'}
        );
    };

    function myFacebookOut() {
        FB.logout(function(response) {
            console.log('Logout');
        });
    };

    function getStatus(){
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token
                // and signed request each expire
                var uid = response.authResponse.userID;
                var accessToken = response.authResponse.accessToken;
                $("#content").text(accessToken);
                console.log(accessToken);
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook,
                // but has not authenticated your app
            } else {
                // the user isn't logged in to Facebook.
            }
        });
    }

    function myFacebookLogout() {
        FB.logout(function(response) {
            console.log('Logout');
            $("#content").text('Logout');
        });
    };

    $( document ).ready(function() {
        setTimeout(function(){
            var getUrlParameter = '{{$out}}';
            if(getUrlParameter == "out"){
                $("#logout").trigger("click");
            }
        }, 2000);
    });
</script>
</head>
<body>
<div id="fb-root"></div>
<button onclick="myFacebookLogin()">Login with Facebook</button>
<button onclick="getStatus()">Status</button>
<button id="logout" onclick="myFacebookLogout()">Logout</button>
<div id="content"></div>
</body>
</html>
