const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const loginError = urlParams.get('login_error');


if (loginError) {
    document.getElementById('alertBox').style.display = 'block';
    
    
    setTimeout(function() {
        document.getElementById('alertBox').style.display = 'none';
    }, 5000);
}