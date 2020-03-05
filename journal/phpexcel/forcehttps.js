(function(){
var frm = document.forms.MainLogin;
if(frm) {
 frm.action=frm.action.replace(/^http:/i, 'https:')
 frm.action=frm.action.replace(/^\//,'https://'+document.domain+'/')
}
})();
