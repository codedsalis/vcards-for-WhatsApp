function renderPageViews(vars) {

var Req = new XMLHttpRequest();
Req.onreadystatechange = function() {
	if(this.readyState == 4 && this.status == 200) {
	console.log('Page views read and saved');
	}
	else{
		console.log('Error while getting and saving page views');
	}
};
Req.open("GET", "https://www.afriadverts.com/717/ad/rpv?url="+vars.url+"&pid="+vars.pid+"&key="+vars.key, true);
Req.send();
}