window.navigator.yHTTPSsupport = true;
function secureForm(frm) {
    if (window.navigator.yHTTPSsupport && frm) {
        frm.action = frm.action.replace(/^http:/i, 'https:').replace(/^\//, 'https://' + window.location.host + '/');
    }
    return true;
}
(function() {
var d = document.documentElement;
if (d.className != '') {
    d.className += /\bg\-https\-on\b/.test(d.className) ? '' : ' g-https-on';
} else {
    d.className = 'g-https-on';
}
})();