function afriRespoAds(config) {
	var serverUrl = 'http://localhost';

	
var Req = new XMLHttpRequest();
Req.onreadystatechange = function() {
	if(this.readyState == 4 && this.status == 200) {
	var res = this.responseText;

	if(res.indexOf('<') != -1) {
		document.getElementById('respo-' + config.uid).innerHTML = res;
	}
	else {
		var adImgUrl = 'http://localhost/adimg';
		var json = JSON.parse(res);
		var aid = json[0].aid;
	var desc = json[0].description;
	var adurl = json[0].url;
	var token = json[0].token;
	var actnbtn = json[0].actnbtn;
	var subtext = json[0].subtext;
	var img300 = json[0]['image_one'];
	var url = 'https://www.afriadverts.com/717/ad/dblclick?aid=' + token + '&pid=' + config.pid + '&jid=' + aid + '&uid=' + config.uid + '&url=' + config.url + '&pub-id=' + Math.floor(Math.random()*100000000);

if(img300.length < 5) {
		document.getElementById('respo-' + config.uid).innerHTML = '<center><div class=\"div\" id=\"div\" style=\"width:301px;\"><div style=\"float: left !important;\"><a target=\"_blank\" style="text-decoration:none;" href=\"https://afriadverts.com/?utm_source=' +config.url + '&utm_medium=' + token + '\" style=\"color:#2c3e50;text-decoration:none;\"><span style=\"background:#2c3e50;border-radius:2px;color:#fff;padding:0 4px 0 4px;\">∆</span></div><br/><div style="border:2px solid #009688; border-radius:4px;"><a style=\"text-decoration: none;\" target=\"_parent\" rel=\"nofollow\" href=\"' + url + '\"><button style=\"text-transform: capitalize; font-weight: lighter; font-size: 17px; background:#fff; width:100%;color: #009688;font-family: Sans-serif;\">' + subtext + '</button><br/><strong style=\"float:left !important; color: #27373A; font-family: Sans-serif; font-size: 15px; font-weight: lighter;\">' + desc + '</strong><button style=\"background: #009688; color: #fff; border-radius: 4px; border: 1px solid #009688; text-transform: uppercase;padding: 5px; float: right !important;\">' + actnbtn + '</button></a></div></center><br/><br/><br/>';
	}
	else {
		var parse = document.createElement('a');
		parse.href = adurl;
		var host = parse.hostname;

		document.getElementById('respo-' + config.uid).innerHTML = '<a style=\"text-decoration:none;\" target=\"_parent\" rel=\"nofollow\" href=\"' + url + '\"><center><div style=\"width:302px;\"><teekay style=\"color: #27373A; padding: 5px; font-family: Sans-serif; text-transform: capitalize;font-size: 15px; font-weight:5px;\">' + desc + '</teekay></div><div id=\"div\" style=\"width:300px;position:relative;\"><img id=\"iimg\" src=\"' + adImgUrl + '/' + token + '/' + img300 + '\" width=\"300\" height=\"250\"/></a><div style=\"position:absolute;right:0;top:0;\"><a target=\"_blank\" href=\"https://afriadverts.com/?utm_source=' +config.url + '&utm_medium=' + config.token + '\" style=\"color:#000;text-decoration:none;\"><div style=\"background:#cfd8dc;color:2c3e50;border:1px solid #ccc;padding: 0 3px 0 3px;\">∆</div></div></a><small style=\"color: gray;float:left !important;\"><b style=\"text-transform: capitalize;float:left !important;\">' + subtext + '</b></a> <a style=\"text-decoration:none;color:#27373A;\" href=\"' + url + '"><button style=\"background: #fff; color: #27373A; border-radius: 3px; border: 1px solid #27373A; text-transform: uppercase; margin-top: 6px; padding: 5px; float: right !important;\">' + actnbtn + '</button></a></div></div></center></a><br/><br/>';
	}
	}
	}
	else{
		
	}
};
Req.open('GET', serverUrl + '/ad/respo?ssvp=717&pid=' + config.pid + '&uid=' + config.uid + '&form=' + config.form + '&url=' + config.url, true);
Req.send();
}