<!DOCTYPE html>
<html lang="zh-CN" class="general-background">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="lib/js/jQuery.js" ></script>
    <link rel="icon" href="resource/favicon.ico" type="image/x-icon"/>

    <!-- 自适应先决条件 -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!–[if lt IE 9]><script src="lib/js/css3-mediaQueries.js"></script><![endif]–>
    <!–[if lt IE 9]><script src="lib/js/html5.js"></script><![endif]–>
    <!–[if lt IE 9]><script type="text/javascript" src="lib/js/json.js" ></script><![endif]–>
    <!–[if lt IE 9]><script type="text/javascript" src="lib/js/md5.js" ></script><![endif]–>

    <script src="https://cdn.bootcss.com/sweetalert/2.1.2/sweetalert.min.js"></script>

    <link rel="stylesheet" href="lib/css/dialogPanel.css" />
    <link rel="stylesheet" href="lib/css/gridSystem.css" />

    <link rel="stylesheet" href="lib/css/BasicStyles.css" />
    
    <script type="text/javascript" src="lib/js/AccurateTime.js" ></script>

    <script type="text/javascript" src="lib/js/Notifier.js" ></script>

    <title>MoneyManager</title>
    <script>
        window.onload = function() {
            $("#loading").fadeOut();
        };
    </script>
</head>
<body class="margin-none">
<h1 class="margin-sm align-center">MoneyManager</h1><hr/>
<div class="col-12 padding-none flex flex-row flex-center">
    <script>
        function displayAnalyse() {
            $("#submit").fadeOut(200);
            setTimeout(function() {
                $("#analyse").fadeIn(200);
            });
            swal("Error", "This function is currently unavailable.", "error");
            displaySubmit();
        }
        function displaySubmit() {
            $("#analyse").fadeOut(200);
            setTimeout(function() {
                $("#submit").fadeIn(200);
            });
        }
    </script>
    <label class="col-6 margin-none" style="text-align: center;" onclick="displaySubmit();">Submit data</label>
    <label class="col-6 margin-none" style="text-align: center;" onclick="displayAnalyse();">Analyse</label>
</div><hr/>
<div id="submit" class="col-12 flex flex-center flex-column padding-none">
    <script>
        let displayTime, yearObj, monthObj, dayObj, hourObj, minuteObj, secondObj;
        function refreshTime() {
            $("#refreshTimeButton").html('<img src="resource/loading.gif" class="ln-12">');
            $.ajax({
                method : 'POST',
                url : 'getTime.php',
                success : function(result) {
                    displayTime = new AccurateTime(result);
                    refreshTimeDisplay();
                    insertTemplate();
                },
                error : function() {
                    swal({
                        title: "Error",
                        text: "Failed to fetch current time. Connection lost.",
                        icon: "error",
                        button: "ok",
                    });
                },
                complete : function() {
                    $("#refreshTimeButton").html('Current Time');
                }
            });
        }
        function upload() {
            $("#uploadButton").html('<img src="resource/loading.gif" style="height: 30px;" >');
            $.ajax({
                method : 'POST',
                url : 'submit.php',
                data : {
                    time: displayTime.toString(),
                    type: TypeUploadContent,
                    amount: AmountStorage,
                    comment: CommentStorage
                },
                success : function(result) {
                    if (parseInt(result.code) < 0) {
                        swal({
                            title: "Error",
                            text: result.obj,
                            icon: "error",
                            button: "ok",
                        });
                    } else {
                        alert(result);
                        swal({
                            title: "Success",
                            text: result.obj,
                            icon: "success",
                            button: "ok",
                        });
                    }
                },
                error : function() {
                    swal({
                        title: "Error",
                        text: "Failed to upload. Connection lost.",
                        icon: "error",
                        button: "ok",
                    });
                },
                complete : function() {
                    $("#uploadButton").html('Submit');
                }
            });
        }
        function refreshTimeDisplay() {
            yearObj.val(displayTime.getYear());
            monthObj.val(displayTime.getMonth());
            dayObj.val(displayTime.getDay());
            hourObj.val((displayTime.getHour() < 10 ? "0" : "") + displayTime.getHour());
            minuteObj.val((displayTime.getMinute() < 10 ? "0" : "") + displayTime.getMinute());
            secondObj.val((displayTime.getSecond() < 10 ? "0" : "") + displayTime.getSecond());
        }
        function modifyTime() {
            if(yearObj.val() !== '' || Number(yearObj.val()) > 0) {
                displayTime.setYear(parseInt(yearObj.val()));
            }
            if(monthObj.val() !== '' || Number(monthObj.val()) > 0) {
                displayTime.setMonth(parseInt(monthObj.val()));
            }
            if(dayObj.val() !== '' || Number(dayObj.val()) > 0) {
                displayTime.setDay(parseInt(dayObj.val()));
            }
            if(hourObj.val() !== '' || Number(hourObj.val()) > 0) {
                displayTime.setHour(parseInt(hourObj.val()));
            }
            if(minuteObj.val() !== '' || Number(minuteObj.val()) > 0) {
                displayTime.setMinute(parseInt(minuteObj.val()));
            }
            if(secondObj.val() !== '' || Number(secondObj.val()) > 0) {
                displayTime.setSecond(parseInt(secondObj.val()));
            }
            refreshTimeDisplay();
        }
        $(document).ready(function() {
            yearObj = $("#time-year");
            monthObj = $("#time-month");
            dayObj = $("#time-day");
            hourObj = $("#time-hour");
            minuteObj = $("#time-minute");
            secondObj = $("#time-second");
            refreshTime();
        });
    </script>
    <div class="col-11 flex">
        <p class="uni-font padding-none margin-none">Time</p>
        <p id="refreshTimeButton" class="uni-font margin-none border-circled padding-sm" style="font-size: 10px; border-width: 1px;margin-left: 5px;height: 15px;" onclick="refreshTime();">Current Time</p>
    </div>
    <div class="date-operator col-10 flex flex-center">
        <div class="col-2 flex flex-column flex-center margin-none padding-none">
            <div class="uni-font padding-none margin-none" onclick="displayTime.addOneYear();refreshTimeDisplay();">+</div>
            <input id="time-year" class="col-12 align-right uni-font-sm uni-input" style="text-align: center;" title="" onfocus="$(this).val('')" onblur="modifyTime()" />
            <div class="uni-font padding-none margin-none" onclick="displayTime.minusOneYear();refreshTimeDisplay();">-</div>
        </div>
        <p class="col-1 uni-font" style="text-align: center;">-</p>
        <div class="col-1 flex flex-column flex-center margin-none padding-none">
            <div class="uni-font padding-none margin-none" onclick="displayTime.addOneMonth();refreshTimeDisplay();">+</div>
            <input id="time-month" class="col-12 align-right uni-font-sm uni-input" style="text-align: center;" title="" onfocus="$(this).val('')" onblur="modifyTime()" />
            <div class="uni-font padding-none margin-none" onclick="displayTime.minusOneMonth();refreshTimeDisplay();">-</div>
        </div>
        <p class="col-1 uni-font" style="text-align: center;">-</p>
        <div class="col-1 flex flex-column flex-center margin-none padding-none">
            <div class="uni-font padding-none margin-none" onclick="displayTime.add(1, 0, 0, 0);refreshTimeDisplay();">+</div>
            <input id="time-day" class="col-12 align-right uni-font-sm uni-input" style="text-align: center;" title="" onfocus="$(this).val('')" onblur="modifyTime()" />
            <div class="uni-font padding-none margin-none" onclick="displayTime.add(-1, 0, 0, 0);refreshTimeDisplay();">-</div>
        </div>
        <div class="col-1 uni-font"> </div>
        <div class="col-1 flex flex-column flex-center margin-none padding-none">
            <div class="uni-font padding-none margin-none" onclick="displayTime.add(0, 1, 0, 0);refreshTimeDisplay();">+</div>
            <input id="time-hour" class="col-12 align-right uni-font-sm uni-input" style="text-align: center;" title="" onfocus="$(this).val('')" onblur="modifyTime()" />
            <div class="uni-font padding-none margin-none" onclick="displayTime.add(0, -1, 0, 0);refreshTimeDisplay();">-</div>
        </div>
        <p class="col-1 uni-font" style="text-align: center;">:</p>
        <div class="col-1 flex flex-column flex-center margin-none padding-none">
            <div class="uni-font padding-none margin-none" onclick="displayTime.add(0, 0, 1, 0);refreshTimeDisplay();">+</div>
            <input id="time-minute" class="col-12 align-right uni-font-sm uni-input" style="text-align: center;" title="" onfocus="$(this).val('')" onblur="modifyTime()" />
            <div class="uni-font padding-none margin-none" onclick="displayTime.add(0, 0, -1, 0);refreshTimeDisplay();">-</div>
        </div>
        <p class="col-1 uni-font" style="text-align: center;">:</p>
        <div class="col-1 flex flex-column flex-center margin-none padding-none">
            <div class="uni-font padding-none margin-none" onclick="displayTime.add(0, 0, 0, 1);refreshTimeDisplay();">+</div>
            <input id="time-second" class="col-12 align-right uni-font-sm uni-input" style="text-align: center;" title="" onfocus="$(this).val('')" onblur="modifyTime()" />
            <div class="uni-font padding-none margin-none" onclick="displayTime.add(0, 0, 0, -1);refreshTimeDisplay();">-</div>
        </div>
    </div>
    <div class="col-11 flex">
        <p class="uni-font padding-none margin-none">Modification Type</p>
    </div>
    <script>
        function displayExtra(mahalo) {
            $("#extra-" + $(mahalo).val()).show();
        }
        function hideOthers() {
            $("#extra-Dine").hide();
            $("#extra-Drink").hide();
            $("#extra-Fare").hide();
        }
        let dataBase = [
            [1.4, "A cheap %meal at the dining hall.", "Dine", "minimum1"],
            [1.9, "A cheap %meal at the dining hall.", "Dine", "minimum2"],
            [2.1, "A cheap %meal at the dining hall.", "Dine", "minimum3"],
            [2.0, "2 yuan's fried rice for breakfast.", "Dine", "minimum4"],
            [3.0, "2 yuan's fried rice with an egg or a ham for breakfast.", "Dine", "minimum5"],
            [4.0, "4 yuan's Slag cake for %meal.", "Dine", "minimum6"],
            [4.5, "4.5 yuan's Slag cake for %meal.", "Dine", "minimum7"],
            [4.0, "10 dumplings for %meal.", "Dine", "better1"],
            [5.0, "A bowl of Huntun for %meal.", "Dine", "better2"],
            [2.0, "A pack of fruit at a price lower than 2 yuan for %meal.", "Dine", "fruit1"],
            [4.0, "A pack of fruit at a price lower than 4 yuan for %meal.", "Dine", "fruit2"],
            [6.0, "A pack of fruit at a price lower than 6 yuan for %meal.", "Dine", "fruit3"],
            [8.0, "A pack of fruit at a price lower than 8 yuan for %meal.", "Dine", "fruit4"],
            [8.0, "A set of Normal Omelette for %meal.", "Dine", "super1"],
            [12.0, "A set of Chicken Omelette for %meal.", "Dine", "super2"],
            [12.0, "A super set for %meal.", "Dine", "super3"],
            [0.0, "A bottle of NonFu Spring.", "Drink", "water"],
            [0.0, "A whole trip between SOFT and MOUNTAIN.", "Fare", "STM"],
            [0.0, "A whole trip between SOFT and OLD.", "Fare", "STO"],
            [0.0, "A whole trip between SOFT and CENTER.", "Fare", "STC"],
            [0.0, "A whole trip between SOFT and HOME.", "Fare", "STH"],
            [0.0, "A whole trip between SOFT and SSFZ.", "Fare", "STS"]
        ];
        function parseComment(str) {
            let hour = displayTime.getHour();
            let rep = Array();

            // Input the processors below.
            if (hour < 10) {
                rep["meal"] = "breakfast";
            } else if (hour < 15) {
                rep["meal"] = "launch";
            } else {
                rep["meal"] = "dinner";
            }
            // Processor over.

            str = str.replace(/%meal/g, rep['meal']);

            return str;
        }
        function insertTemplate() {
            let master = $("#type").val();
            let sub1 = $("#extra-" + master).val();

            TypeUploadContent = master;
            if (sub1 !== undefined) TypeUploadContent += ">" + sub1;

            for (let key in dataBase) {
                if (dataBase[key][2] === master && dataBase[key][3] === sub1) {
                    amountObj.val(dataBase[key][0]);
                    commentObj.val(parseComment(dataBase[key][1]));
                    AmountStorage = parseFloat(amountObj.val());
                    CommentStorage = commentObj.val();
                    return;
                }
            }
            amountObj.val("");
            commentObj.val("");
            AmountStorage = "";
            CommentStorage = "";
        }
        let AmountStorage = "";
        let CommentStorage = "";
        let TypeUploadContent = "";
        let amountObj = null;       //The price input.
        let commentObj = null;      //The comment input
        $(document).ready(function() {
            amountObj = $("#amount");
            commentObj = $("#comment");
            amountObj.click(function() {
                $(this).val("");
            }).blur(function() {
                if ($(this).val() === "") $(this).val(AmountStorage);
                else AmountStorage = parseFloat($(this).val());
            });
            commentObj.click(function() {
                $(this).val("");
            }).blur(function() {
                if ($(this).val() === "") $(this).val(CommentStorage);
                else CommentStorage = $(this).val();
            });
        });

    </script>
    <div id="type-selector" class="col-10 flex flex-center flex-column">
        <select title="" id="type" onchange="hideOthers();displayExtra(this);insertTemplate();" class="col-12 uni-select" style="font-size: 20px;">
            <option value="Dine">Dining</option>
            <option value="Drink">Drinking</option>
            <option value="bcp">Make Backup</option>
            <option value="Daily">Daily Essentials</option>
            <option value="Fare">Transportation Fare</option>
            <option value="Fee">School Fee</option>
            <option value="Special">Other Outcome</option>
            <option value="Inc">Income</option>
        </select>
        <select title="" id="extra-Dine" class="col-12 uni-select" style="font-size: 20px;" onchange="insertTemplate();">
            <option value="minimum1">The 1.4 Yuan's set</option>
            <option value="minimum2">The 1.9 Yuan's set</option>
            <option value="minimum3">The 2.1 Yuan's set</option>
            <option value="minimum4">The 2 Yuan's rice for breakfast</option>
            <option value="minimum5">The 3 Yuan's rice for breakfast</option>
            <option value="minimum6">The 4 Yuan's Slag cake</option>
            <option value="minimum7">The 4.5 Yuan's Slag cake</option>
            <option value="better1">4 Yuan's Dumpling</option>
            <option value="better2">5 Yuan's Huntun</option>
            <option value="fruit1">2 Yuan's Fruit</option>
            <option value="fruit2">4 Yuan's Fruit</option>
            <option value="fruit3">6 Yuan's Fruit</option>
            <option value="fruit4">8 Yuan's Fruit</option>
            <option value="super1">8 Yuan's Omelette</option>
            <option value="super2">12 Yuan's Omelette</option>
            <option value="super3">12 Yuan's Super set</option>
            <option value="others">Other</option>
        </select>
        <select title="" id="extra-Drink" style="display: none;font-size: 20px;" class="col-12 uni-select" onchange="insertTemplate();">
            <option value="water">Normal Water</option>
            <option value="others">Juice, Drinks, etc.</option>
        </select>
        <select title="" id="extra-Fare" style="display: none;font-size: 20px;" class="col-12 uni-select" onchange="insertTemplate();">
            <option value="STM">SDU-SOFT <---> SDU-MOUNTAIN</option>
            <option value="STO">SDU-SOFT <---> SDU-OLD</option>
            <option value="STC">SDU-SOFT <---> SDU-CENTER</option>
            <option value="STH">SDU-SOFT <---> HOME</option>
            <option value="STS">SDU-SOFT <---> SSFZ</option>
            <option value="others">Other Transportation</option>
        </select>
    </div>
    <div class="col-11 flex" style="margin-top: 20px;">
        <p class="uni-font padding-none margin-none">Amount</p>
    </div>
    <div class="col-10 flex" style="margin-top: 20px;">
        <input id="amount" class="col-3 align-center uni-font-sm uni-input" title="" />
        <label>Yuan</label>
    </div>
    <div class="col-11 flex" style="margin-top: 20px;">
        <p class="uni-font padding-none margin-none">Comment</p>
    </div>
    <textarea id="comment" class="col-10 align-left" style="font-size: 20px;resize: none;height: 80px;" title=""><?php ?></textarea>
    <div class="col-11 flex flex-center" style="height: 70px;">
        <p id="uploadButton" class="uni-font margin-lg border-circled padding-sm" onclick="upload();">Submit</p>
    </div>
</div>
<div id="analyse" class="col-12 padding-none">

</div>

<!-- 加载框 -->
<div class="dialog" id="loading-icon">
    <div class="flex flex-center flex-column dialog-centered">
        <img src="resource/loading.gif"/>
    </div>
</div>

<!-- 加载界面 -->
<div class="dialog-pre" id="loading" style="background-color: black">
    <div class="flex flex-center flex-column dialog-centered">
        <img src="resource/loading.gif"/>
        <p style="color: white;">正在加载中</p>
    </div>
</div>
</body>
</html>