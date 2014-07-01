function checkConnection() {
    if(doesConnectionExist()==true){
        alert("You currently have connection!");
        //insert code to submit local data previously stored
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
            success:completion(),
            failure:badConnection()
        });
    } else if(doesConnectionExist()==false){
        alert("Connection has failed!");
        // insert code to store form as local data
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
    // Insert some HTML into our DIV
    alert("Entry Successful!");
    
}

function badConnection()
{             
    // Insert some HTML into our DIV
    alert("Something is wrong.");
    alert("Connection too weak. Will store this entry for later submission.");
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