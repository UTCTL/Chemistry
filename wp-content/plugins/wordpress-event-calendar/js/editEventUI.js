function showHideEventTimes(){ //Handles the allDayEvent.onClick event
    try {
        if ($("allDayEvent").checked) {
            Effect.Fade("startTimeRow", {
                duration: 0.25
            });
            Effect.Fade("endTimeRow", {
                duration: 0.25
            });
            Effect.Fade("spacerAboveRepeatFrequency", {
                duration: 0.25
            });
        }
        else {
            Effect.Appear("startTimeRow", {
                duration: 0.25
            });
            Effect.Appear("endTimeRow", {
                duration: 0.25
            });
            Effect.Appear("spacerAboveRepeatFrequency", {
                duration: 0.25
            });
        }
    } 
    catch (e) {
    }
    
}

function showHideRepeatTimes(){
    try {
        if ($("repeatForever").checked) {
            Effect.Fade("repeatTimesBox", {
                duration: 0.25
            });
        }
        else {
            Effect.Appear("repeatTimesBox", {
                duration: 0.25
            });
        }
        
    } 
    catch (e) {
    }
}

function showHideRepeatDetails(){
    try {
        if ($("eventFrequency").value != "n") {
            Effect.Appear("repeatForeverBox", {
                duration: 0.25
            });
            
            if (!$('repeatForever').checked) {
                Effect.Appear("repeatTimesBox", {
                    duration: 0.25
                });
            }
        }
        else { //if the user selects repeat: none
            //uncheck the repeat forever box
            $('repeatForever').checked = false;
            
            Effect.Fade("repeatTimesBox", {
                duration: 0.25
            });
            Effect.Fade("repeatForeverBox", {
                duration: 0.25
            });
            
        }
    } 
    catch (e) {
    }
    
}

function getEventInfo(f, g, d, b, a, h){
    var c = a + ";;" + h + ";;" + b;
    var e = new sack(f + "/wp-admin/admin-ajax.php");
    e.execute = 1;
    e.method = "POST";
    e.setVar("action", "displayCalendarFromExternalSource");
    e.setVar("query", g);
    e.setVar("container", d);
    e.setVar("formattingRules", c);
    e.onError = function(){
        document.getElementById(d).innerHTML = "An error has occured"
    };
    e.runAJAX();
    return true
}

function duplicateField(a, e){

    var d = document.getElementById(a).value.length - 1;
    var b = document.getElementById(a).value;
    for (var c = 0; c < b.length - 1; c++) {
        if (b.charAt(c) == " ") {
            b = setCharAt(b, c, "_")
        }
    }
    document.getElementById(e).style.color = "#c9c9c9";
    document.getElementById(e).value = b
}

function setCharAt(c, a, b){
    if (a > c.length - 1) {
        return c
    }
    return c.substr(0, a) + b + c.substr(a + 1)
}

function changeColorBack(a){
    document.getElementById(a).style.color = "#000000"
}

function validateCalendarNameOnCreate(c, d, e, b){
    var a = new sack(c + "/wp-admin/admin-ajax.php");
    a.execute = 1;
    a.method = "POST";
    a.setVar("action", "validateCalendarNameOnCreate");
    a.setVar("confirmationField", d);
    a.setVar("calendarName", document.getElementById(e).value);
    a.setVar("submitButton", b);
    a.onError = function(){
        return false
    };
    a.runAJAX();
    return true
}

function validateCalendarSlugOnCreate(c, e, d, b){
    var a = new sack(c + "/wp-admin/admin-ajax.php");
    a.execute = 1;
    a.method = "POST";
    a.setVar("action", "validateCalendarSlugOnCreate");
    a.setVar("confirmationField", e);
    a.setVar("calendarSlug", document.getElementById(d).value);
    a.setVar("submitButton", b);
    a.onError = function(){
        return false;
    };
    a.runAJAX();
    return true;
}

function validateCalendarNameOnEdit(d, e, f, b, c){
    var a = new sack(d + "/wp-admin/admin-ajax.php");
    a.execute = 1;
    a.method = "POST";
    a.setVar("action", "validateCalendarNameOnEdit");
    a.setVar("confirmationField", e);
    a.setVar("calendarName", document.getElementById(f).value);
    a.setVar("submitButton", b);
    a.setVar("calendarID", c);
    a.onError = function(){
        return false;
    };
    a.runAJAX();
    return true;
};



if (document.addEventListener) {

    document.addEventListener("DOMContentLoaded", attachEventHandlers, false);
    
}
else {

    window.onload = function(){
        attachEventHandlers();
    }
    
}


function attachEventHandlers(){
    //===============================================
    //	Event Repeats Forever Checkbox
    //=============================================== 
    if ($("repeatForever") != undefined) {
        Event.observe($("repeatForever"), 'click', showHideRepeatTimes);
    }
    
    //===============================================
    //	All Day Event Checkbox
    //===============================================
    if ($("allDayEvent") != undefined) {
        Event.observe($("allDayEvent"), 'click', showHideEventTimes);
    }
    
    //===============================================
    //	Repetition Type Selector
    //==============js.all.js=================================
    if ($("eventFrequency") != undefined) {
        Event.observe($("eventFrequency"), 'change', showHideRepeatDetails);
    }
}



function initalizeDateSelectors(){

    
    //===================================================================================
    //		Create start date picker
    //===================================================================================
    
    var start_dialog, start_calendar;
    
    start_calendar = new YAHOO.widget.Calendar("start_date_picker", {
        iframe: false, // Turn iframe off, since container has iframe support. 
        hide_blank_weeks: true // Enable, to demonstrate how we handle changing height, using changeContent 
    });
    
    function start_okHandler(){
        if (start_calendar.getSelectedDates().length > 0) {
        
            var selDate = start_calendar.getSelectedDates()[0];
            
            // Pretty Date Output, using Calendar's Locale values: Friday, 8 February 2008 
            var wStr = start_calendar.cfg.getProperty("WEEKDAYS_LONG")[selDate.getDay()];
            var dStr = selDate.getDate();
            var mStr = start_calendar.cfg.getProperty("MONTHS_LONG")[selDate.getMonth()];
            var yStr = selDate.getFullYear();
            
            YAHOO.util.Dom.get("eventStartDate").value = mStr + " " + dStr + ", " + yStr;
        }
        else {
            YAHOO.util.Dom.get("eventStartDate").value = "";
        }
        this.hide();
    }
    
    function start_cancelHandler(){
        this.hide();
    }
    
    start_dialog = new YAHOO.widget.Dialog("start_date_container", {
        context: ["show", "tl", "bl"],
        buttons: [{
            text: "Select",
            isDefault: true,
            handler: start_okHandler
        }, {
            text: "Cancel",
            handler: start_cancelHandler
        }],
        width: "16em", // Sam Skin dialog needs to have a width defined (7*2em + 2*1em = 16em). 
        draggable: false,
        close: true
    });
    
    start_calendar.render();
    start_dialog.render();
    
    // Using dialog.hide() instead of visible:false is a workaround for an IE6/7 container known issue with border-collapse:collapse. 
    start_dialog.hide();
    
    start_calendar.renderEvent.subscribe(function(){
        // Tell Dialog it's contents have changed, Currently used by container for IE6/Safari2 to sync underlay size 
        start_dialog.fireEvent("changeContent");
		
		if(document.getElementById('eventEndDate').value = ""){
			document.getElementById('eventEndDate').value = "success";
		}
		
    });
    
    
    YAHOO.util.Event.on("eventStartDate", "focus", start_dialog.show, start_dialog, true);
    
    
    //===================================================================================
    //		Create End date picker
    //===================================================================================
    
    var end_dialog, end_calendar;
    
    end_calendar = new YAHOO.widget.Calendar("end_date_picker", {
        iframe: false, // Turn iframe off, since container has iframe support. 
        hide_blank_weeks: true // Enable, to demonstrate how we handle changing height, using changeContent 
    });
    
    function end_okHandler(){
    
        if (end_calendar.getSelectedDates().length > 0) {
        
            var selDate = end_calendar.getSelectedDates()[0];
            
            // Pretty Date Output, using Calendar's Locale values: Friday, 8 February 2008 
            var wStr = end_calendar.cfg.getProperty("WEEKDAYS_LONG")[selDate.getDay()];
            var dStr = selDate.getDate();
            var mStr = end_calendar.cfg.getProperty("MONTHS_LONG")[selDate.getMonth()];
            var yStr = selDate.getFullYear();
            
            YAHOO.util.Dom.get("eventEndDate").value = mStr + " " + dStr + ", " + yStr;
        }
        else {
            YAHOO.util.Dom.get("eventEndDate").value = "";
        }
        this.hide();
        
        
    }
    
    function end_cancelHandler(){
        this.hide();
    }
    
    end_dialog = new YAHOO.widget.Dialog("end_date_container", {
        context: ["show", "tl", "bl"],
        buttons: [{
            text: "Select",
            isDefault: true,
            handler: end_okHandler
        }, {
            text: "Cancel",
            handler: end_cancelHandler
        }],
        width: "16em", // Sam Skin dialog needs to have a width defined (7*2em + 2*1em = 16em). 
        draggable: false,
        close: true
    });
    
    end_calendar.render();
    end_dialog.render();
    
    // Using dialog.hide() instead of visible:false is a workaround for an IE6/7 container known issue with border-collapse:collapse. 
    end_dialog.hide();
    
    end_calendar.renderEvent.subscribe(function(){
        // Tell Dialog it's contents have changed, Currently used by container for IE6/Safari2 to sync underlay size 
        end_dialog.fireEvent("changeContent");
    });
    
    
    YAHOO.util.Event.on("eventEndDate", "focus", end_dialog.show, end_dialog, true);
    
}
