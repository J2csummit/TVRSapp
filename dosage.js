var TVRSdata;
var _urName;
var _cltName;
var _serv;
var _othr;
var _who;
var _how;
var _hrs;
var _min;
var filled;
var other;

// This function will run upon the page being fully loaded
function checkConnection() {
    makeDatabase();
    filled = true;
    other = false;
    if(doesConnectionExist()==true){
        alert("You currently have connection! Unsubmitted entries will now be uploaded.");
        TVRSdata.transaction(upload,errorCB)
    } else if(doesConnectionExist()==false){
        alert("You currently do not have connection!");
    }
}

// This function will run when the submit button is clicked
function submission() {
    if(doesConnectionExist()==true){
        alert("begin submission?");

        // Temporarily using offline storage functions regardless if online or offline for development purposes
        TVRSdata.transaction(insertDB, errorCB)

        // Code to submit data to remote server (Turned off for time being because online submission currenlty isn't working)
        /*$.ajax({
            type:"POST",
            url:"dosage.php",
            dataType:"json",
            data: $('#dosageform').serialize(),
            success:completion()
        });*/

        return false;
    } else if(doesConnectionExist()==false){
        alert("Connection has failed. Will store this entry for later submission.");
        TVRSdata.transaction(insertDB, errorCB);
        return false;
    }
}

// This function checks for internet connection
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

// Once submission to remote server works,
// this function will confirm that the submission is complete
// (understand that the server submission code could run to completion
// and this function can still run even
// though there is no actual submission of data)
function completion()
{             
    alert("Entry Successful!");
}

// Because there are multiple choices with radio buttons and checkboxes
// we need these next three functions to properly obtain data
function getServiceValue(groupName) {
    other = false;
    var radios = document.getElementsByName(groupName);
    window.rdValue = null;
    for (var i=0; i<radios.length; i++) {
        var aRadio = radios[i];
        if (aRadio.checked) {
            var foundCheckedRadio = aRadio;
            rdValue = foundCheckedRadio.value;
            if (rdValue == '15') {
                other = true;
            }
            return rdValue;
        }
        else rdValue = 'noRadioChecked';
    }
    if (rdValue == 'noRadioChecked') {
        filled = false;
    }
}

function getWhoValue(groupName) {
    var boxes = document.getElementsByName(groupName);
    window.bxValue = null;
    var counter = 0;
    for (var i=0; i<boxes.length; i++) {
        var aBox = boxes[i];
        if (aBox.checked && counter==0) {
            var foundCheckedBox = aBox;
            bxValue = foundCheckedBox.value;
            counter++;
        } else if (aBox.checked && counter>0) {
            var foundCheckedBox = aBox;
            bxValue += foundCheckedBox.value;
        }
    }
    if(bxValue==null){
        filled = false;
    }
    return bxValue;
}

function getHowValue(groupName) {
    var radios = document.getElementsByName(groupName);
    window.rdValue = null;
    for (var i=0; i<radios.length; i++) {
        var aRadio = radios[i];
        if (aRadio.checked) {
            var foundCheckedRadio = aRadio;
            rdValue = foundCheckedRadio.value;
            return rdValue;
        }
        else rdValue = 'noRadioChecked';
    }
    if (rdValue == 'noRadioChecked') {
        filled = false;
    }
}

// -------------------------------------- HTML Local Database



// This fucntion creates inital database
function makeDatabase(){
    TVRSdata = openDatabase('mydb', '1.0', 'my first database', 2 * 1024 * 1024);
    alert("created database?");
    TVRSdata.transaction(createDB, errorCB);
}

// This function creates a table in the database 
// (if the user first runs app without internet connection)
function createDB(db){
    db.executeSql('CREATE TABLE IF NOT EXISTS DosageData (urName, cltName, serv, othr, who, how, hrs, min)');
}

// If there is an error with the SQL statments
// this function will run and provide a value that describes error
function errorCB(err){
    alert("SQL error occurred: " + err.code);
}

// This function inserts the user data from the form into the table in the database
// then shows the collective contents of the database
function insertDB(db){
    _urName= document.getElementById("providerNames").value;
    _cltName= document.getElementById("clientNames").value;
    _serv= getServiceValue("service");
    _othr= document.getElementById("others").value;
    _who= getWhoValue("receiverGroup[]");
    _how= getHowValue("method");
    _hrs= document.getElementById("hourss").value;
    _min= document.getElementById("minutess").value;

    alert(_urName + '' + _cltName + '' + _serv + '' + _othr + '' + _who + '' + _how + '' + _hrs + '' + _min);

    // Checks if everything is filled out correctly
    if (other==true && _othr==""){
        filled = false;
    }
    if (filled==false){
        alert("Please fill in the entire form.")
        filled = true;
        return;
    }

    // If form is filled out, results are submitted into database
    db.executeSql('INSERT INTO DosageData (urName, cltName, serv, othr, who, how, hrs, min) VALUES (?,?,?,?,?,?,?,?)', [_urName, _cltName, _serv, _othr, _who, _how, _hrs, _min]);

    //  This will show the data stored in the database
    db.executeSql('SELECT * FROM DosageData', [], function (db, results) {
        var len = results.rows.length, i;
        for (i = 0; i < len; i++) {
            var data = JSON.stringify(results.rows.item(i))
            alert(data);
        }
    });
}

// This function will run along with checkConnection()
// If there are previous submissions, this function
// will submit all of them
function upload(db){
    db.executeSql('SELECT * FROM DosageData', [], function (db, results) {
        var len = results.rows.length, i;
        for (i = 0; i < len; i++) {
            var data = results.rows.item(i);
            // Code to submit data to remote server (Turned off for time being because online submission currenlty isn't working)
            /*$.ajax({
                type:"POST",
                url:"dosage.php",
                dataType:"json",
                data: data.serialize(),
                success:completion()
            });*/
        }
        db.executeSql('DROP TABLE IF EXISTS DosageData');
        alert("Database will be dropped");
        db.executeSql('CREATE TABLE IF NOT EXISTS DosageData (urName, cltName, serv, othr, who, how, hrs, min)');
        alert("New database created")
    });
}


// -------------------------------------- End HTML Local Database

