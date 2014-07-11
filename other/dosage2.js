function checkConnection() {
    if(doesConnectionExist()==true){
        alert("You currently have connection! Unsubmitted entries will now be uploaded.");
        upload();
    } else if(doesConnectionExist()==false){
        alert("You currently do not have connection!");
    }
}

function submission() {
    if(doesConnectionExist()==true){
        $.ajax({
            type:"POST",
            url:"dosage.php",
            dataType:"json",
            data: $('#dosageform').serialize(),
            success:completion()
        });
        return false;
    } else if(doesConnectionExist()==false){
        alert("Connection has failed. Will store this entry for later submission.");
        storage();
        return false;
    }
}

function doesConnectionExist() {
    var xhr = new XMLHttpRequest();
    var file = "http://www.kirupa.com/blank.png";
    var randomNum = Math.round(Math.random() * 10000);
     
    xhr.open('HEAD', file + "?rand=" + randomNum, false);
     
    try {
        xhr.send();
         
        if (xhr.status >= 200 && xhr.status < 304) {
            return true;
        } else {
            return false;
        }
    } catch (e) {
        return false;
    }
}

function completion()
{             
    alert("Entry Successful!");
    
}

function makeDatabase(){
	try {
        if (!window.openDatabase) {
            alert('not supported');
        } else {
            var shortName = 'mydatabase';
            var version = '1.0';
            var displayName = 'My Important Database';
            var maxSize = 65536; // in bytes
            var db = openDatabase(shortName, version, displayName, maxSize);
 
            // You should have a database instance in db.
        }
    } catch(e) {
        // Error handling code goes here.
        if (e == 2) {
            // Version number mismatch.
            alert("Invalid database version.");
        } else {
            alert("Unknown error "+e+".");
        }
        return;
    }
 
	alert("Database is: "+db);
}

function upload(){
	var urName= localStorage.getItem("providerName");
	document.getElementById("providerName").value = urName;

    var cltName= localStorage.getItem("clientName");
    document.getElementById("clientName").value = cltName;

    var serv= localStorage.getItem("service");
    document.getElementById("service").value = serv;

    var othr= localStorage.getItem("other");
    document.getElementById("other").value = othr;

    var receive= localStorage.getItem("receiverGroup[]");
    document.getElementById("receiverGroup[]").value = receive;

    var how= localStorage.getItem("method");
    document.getElementById("method").value = how;

    var hrs= localStorage.getItem("hours");
    document.getElementById("hours").value = hrs;

    var min= localStorage.getItem("minutes");
    document.getElementById("minutes").value = min;

    $.ajax({
            type:"POST",
            url:"dosage.php",
            dataType:"json",
            data: $('#dosageform').serialize(),
            success:completion()
    });
}

function storage(){
	var urName= document.getElementById("providerName");
    localStorage.setItem("providerName", urName.value);

    var cltName= document.getElementById("clientName");
    localStorage.setItem("clientName", cltName.value);

    var serv= document.getElementById("service");
    localStorage.setItem("service", serv.value);

    var othr= document.getElementById("other");
    localStorage.setItem("other", othr.value);

    var receive= document.getElementById("receiverGroup[]");
    localStorage.setItem("receiverGroup[]", receive.value);

    var how= document.getElementById("method");
    localStorage.setItem("method", how.value);

    var hrs= document.getElementById("hours");
    localStorage.setItem("hours", hrs.value);

    var min= document.getElementById("minutes");
    localStorage.setItem("minutes", min.value);
}