function checkConnection() {
    makeDatabase();
    if(doesConnectionExist()==true){
        alert("You currently have connection! Unsubmitted entries will now be uploaded.");
        //upload();
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
            success:storage()
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


//HTML Local Database 2.0

var TVRSdata = openDatabase('mydb', '1.0', 'my first database', 2 * 1024 * 1024);

function makeDatabase(){
    TVRSdata.transaction(function (db) {
        db.executeSql('CREATE TABLE IF NOT EXISTS foo (yourName, cilentName, servprov, othre, whoreceiv, howprov, hour, minute)');
    });
    alert("1 - Database is: "+TVRSdata);
}

function storage(){
    var urName= document.getElementById("providerName");
    var cltName= document.getElementById("clientName");
    var serv= document.getElementById("service");
    var othr= document.getElementById("other");
    var receive= document.getElementById("receiverGroup[]");
    var how= document.getElementById("method");
    var hrs= document.getElementById("hours");
    var min= document.getElementById("minutes");

    TVRSdata.transaction(function (db) {
        db.executeSql('INSERT INTO foo (yourName, cilentName, servprov, othre, whoreceiv, howprov, hour, minute) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [urName, cltName, serv, othr,receive, how, hrs, min]);
    });
    alert("2 - Database is: "+TVRSdata);
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