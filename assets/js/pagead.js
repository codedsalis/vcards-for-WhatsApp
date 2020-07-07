function afriPageAds(config) {
	var serverUrl = 'http://localhost';
var Req = new XMLHttpRequest();
Req.onreadystatechange = function() {
	if(this.readyState == 4 && this.status == 200) {
	var res = this.responseText;

	if(res.indexOf('<') != -1) {
		document.getElementById('page-' + config.uid).innerHTML = res;
	}
	else {
		var json = JSON.parse(res);

		//var splitt = config.t.split(' ');

	var adImgUrl = 'http://localhost/adimg';
	var aid = json[0].aid;
	var desc = json[0].description;
	var adurl = json[0].url;
	var token = json[0].token;
	var actnbtn = json[0].actnbtn;
	var subtext = json[0].subtext;
	var img = json[0].image_one;
	
	//var img = json[0][splitt[0]+splitt[1]+splitt[2]];

	var url = 'https://www.afriadverts.com/717/ad/bclick?aid=' + token + '&pid=' + config.pid + '&jid=' + aid + '&uid=' + config.uid + '&url=' + config.url + '&pub-id=' + Math.floor(Math.random()*100000000);

	if(!img) {
		document.getElementById('page-' + config.uid).innerHTML = '<center><div class=\"div\" id=\"div\" style=\"width:301px;\"><div style=\"float: left !important;\"><a target=\"_blank\" style="text-decoration:none;" href=\"https://www.afriadverts.com/?utm_source=' +config.url + '&utm_medium=' + token + '\" style=\"color:#2c3e50;text-decoration:none;\"><span style=\"background:#2c3e50;border-radius:2px;color:#fff;padding:0 4px 0 4px;\">∆</span></div><br/><div style="border:2px solid #009688; border-radius:4px;"><a style=\"text-decoration: none;\" target=\"_parent\" rel=\"nofollow\" href=\"' + url + '\"><button style=\"text-transform: capitalize; font-weight: lighter; font-size: 17px; background:#fff; width:100%;color: #009688;font-family: Sans-serif;\">' + subtext + '</button><br/><strong style=\"float:left !important; color: #27373A; font-family: Sans-serif; font-size: 15px; font-weight: lighter;\">' + desc + '</strong><button style=\"background: #009688; color: #fff; border-radius: 4px; border: 1px solid #009688; text-transform: uppercase;padding: 5px; float: right !important;\">' + actnbtn + '</button></a></div></center><br/><br/><br/>';
	}
	else {
		var width = 0;
		var swidth = 0;
		//if(splitt[0] >= 728) {
				width = '100%';
				swidth = '100%';
			/*}
			else {
				width = splitt[0];
				swidth = splitt[0] + 'px';
			}*/
		

		document.getElementById('page-' + config.uid).innerHTML = '<a style=\"text-decoration:none;\" target=\"_parent\" rel=\"nofollow\" href=\"' + url + '\"><center><div id=\"div\" style=\"width:' + swidth + ';position:relative;\"><img id=\"iimg\" src=\"' + adImgUrl + '/' + token + '/' + img + '\" width=\"' + width + '\" height=\"100%\"/></a><div style=\"position:absolute;right:0;top:0;\"><a target=\"_blank\" href=\"https://www.afriadverts.com/?utm_source=' +config.url + '&utm_medium=' + config.token + '\" style=\"color:#000;text-decoration:none;\"><div style=\"background:#cfd8dc;color:2c3e50;border:1px solid #ccc;padding: 0 1px 0 1px;\">∆</div></div></a></div></center><br/>';
	}
	}

	
	}
	else{
		
	}
};
Req.open('GET', serverUrl + '/ad/show?ssvp=717&pid=' + config.pid + '&uid=' + config.uid + '&t=' + config.t + '&url=' + config.url, true);
Req.send();
}