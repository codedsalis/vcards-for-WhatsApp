function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    //document.getElementById("mySidenav").style.paddingRight = "5px";
    document.getElementById("trans_nav").style.width = "100%";
    
document.getElementById("myTransnav").style.pointerEvents = "none";

/*document.getElementById("navBar").style.display = 'none';
*/
document.getElementById("close").style.display = 'block';
    //document.getElementById("main").style.marginLeft = "71%";
     //document.body.style.backgroundColor = "rgba(255,255,255,1)";
}

function closeNav() {
	document.getElementById("trans_nav").style.width = "0";
document.getElementById("close").style.display = 'none'; document.getElementById("mySidenav").style.width = "0";
document.getElementById("myTransnav").style.pointerEvents = "auto";
    document.getElementById("main").style.marginLeft= "0";
    //document.body.style.backgroundColor = "white";
}