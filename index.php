<!DOCTYPE html>
<html lang="zh-CN" class="general-background">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="lib/js/jQuery.js" ></script>

    <!-- 自适应先决条件 -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!–[if lt IE 9]><script src="lib/js/css3-mediaQueries.js"></script><![endif]–>
    <!–[if lt IE 9]><script src="lib/js/html5.js"></script><![endif]–>
    <!–[if lt IE 9]><script type="text/javascript" src="lib/js/json.js" ></script><![endif]–>
    <!–[if lt IE 9]><script type="text/javascript" src="lib/js/md5.js" ></script><![endif]–>

    <link rel="stylesheet" href="lib/css/dialogPanel.css" />
    <link rel="stylesheet" href="lib/css/gridSystem.css" />
    <script type="text/javascript" src="lib/js/dialogPanel.js" ></script>

    <link rel="stylesheet" href="lib/css/BasicStyles.css" />
    
    <script type="text/javascript" src="lib/js/AccurateTime.js" ></script>

    <script type="text/javascript" src="lib/js/Notifier.js" ></script>

    <title>MoneyManager</title>
</head>
<body class="margin-none">
<div class="flex flex-row flex-center padding-sm decorate-header" href='javascript:void(0)'>
    <h1>MoneyManager</h1>
</div><hr/>
<div class="col-12 padding-none" style="height: 93%">
    <div class="col-12 flex flex-center flex-column">
        <?php
            include "lib/AccurateTime.php";
            $current_time = new AccurateTime();
            $year = $current_time->get_year();
            $month = $current_time->get_month();
            $day = $current_time->get_day();
            $hour = $current_time->get_hour();
            $minute = $current_time->get_minute();
            $second = $current_time->get_second();
        ?>
        <script>
            <?php
                if ($hour < 10) $hour = "0" . $hour;
                if ($minute < 10) $minute = "0" . $minute;
                if ($second < 10) $second = "0" . $second;
            ?>
            let displayTime, yearObj, monthObj, dayObj, hourObj, minuteObj, secondObj;
            function refreshTimeDisplay() {
                console.log("About to go: " + displayTime.toString());
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
                displayTime = new AccurateTime("<?php echo("$year-$month-$day $hour:$minute:$second"); ?>");
            });
        </script>
        <div class="col-11 flex">
            <p class="uni-font padding-none margin-none">Time</p>
        </div>
        <div class="date-operator" class="col-10 flex flex-center">
            <div class="col-2 flex flex-column flex-center margin-none padding-none">
                <div class="uni-font padding-none margin-none" onclick="displayTime.addOneYear();refreshTimeDisplay();">+</div>
                <input id="time-year" class="col-12 align-right uni-font-sm uni-input" style="text-align: center;" title="" value="<?php echo $year ?>" onfocus="$(this).val('')" onblur="modifyTime()" />
                <div class="uni-font padding-none margin-none" onclick="displayTime.minusOneYear();refreshTimeDisplay();">-</div>
            </div>
            <p class="col-1 uni-font" style="text-align: center;">-</p>
            <div class="col-1 flex flex-column flex-center margin-none padding-none">
                <div class="uni-font padding-none margin-none" onclick="displayTime.addOneMonth();refreshTimeDisplay();">+</div>
                <input id="time-month" class="col-12 align-right uni-font-sm uni-input" style="text-align: center;" title="" value="<?php echo $month ?>" onfocus="$(this).val('')" onblur="modifyTime()" />
                <div class="uni-font padding-none margin-none" onclick="displayTime.minusOneMonth();refreshTimeDisplay();">-</div>
            </div>
            <p class="col-1 uni-font" style="text-align: center;">-</p>
            <div class="col-1 flex flex-column flex-center margin-none padding-none">
                <div class="uni-font padding-none margin-none" onclick="displayTime.add(1, 0, 0, 0);refreshTimeDisplay();">+</div>
                <input id="time-day" class="col-12 align-right uni-font-sm uni-input" style="text-align: center;" title="" value="<?php echo $day ?>" onfocus="$(this).val('')" onblur="modifyTime()" />
                <div class="uni-font padding-none margin-none" onclick="displayTime.add(-1, 0, 0, 0);refreshTimeDisplay();">-</div>
            </div>
            <div class="col-1 uni-font"></div>
            <div class="col-1 flex flex-column flex-center margin-none padding-none">
                <div class="uni-font padding-none margin-none" onclick="displayTime.add(0, 1, 0, 0);refreshTimeDisplay();">+</div>
                <input id="time-hour" class="col-12 align-right uni-font-sm uni-input" style="text-align: center;" title="" value="<?php echo $hour ?>" onfocus="$(this).val('')" onblur="modifyTime()" />
                <div class="uni-font padding-none margin-none" onclick="displayTime.add(0, -1, 0, 0);refreshTimeDisplay();">-</div>
            </div>
            <p class="col-1 uni-font" style="text-align: center;">:</p>
            <div class="col-1 flex flex-column flex-center margin-none padding-none">
                <div class="uni-font padding-none margin-none" onclick="displayTime.add(0, 0, 1, 0);refreshTimeDisplay();">+</div>
                <input id="time-minute" class="col-12 align-right uni-font-sm uni-input" style="text-align: center;" title="" value="<?php echo $minute ?>" onfocus="$(this).val('')" onblur="modifyTime()" />
                <div class="uni-font padding-none margin-none" onclick="displayTime.add(0, 0, -1, 0);refreshTimeDisplay();">-</div>
            </div>
            <p class="col-1 uni-font" style="text-align: center;">:</p>
            <div class="col-1 flex flex-column flex-center margin-none padding-none">
                <div class="uni-font padding-none margin-none" onclick="displayTime.add(0, 0, 0, 1);refreshTimeDisplay();">+</div>
                <input id="time-second" class="col-12 align-right uni-font-sm uni-input" style="text-align: center;" title="" value="<?php echo $second ?>" onfocus="$(this).val('')" onblur="modifyTime()" />
                <div class="uni-font padding-none margin-none" onclick="displayTime.add(0, 0, 0, -1);refreshTimeDisplay();">-</div>
            </div>
        </div>
        <div class="col-11 flex">
            <p class="uni-font padding-none margin-none">Modification Type</p>
        </div>
        <script>
            function displayExtra() {
                $("#extra-" + $(this).attr("value")).show();
            }
            function hideOthers() {
                $("div[id^='extra-']").hide();
            }
        </script>
        <div id="type-selector" class="col-10 flex flex-center">
            <select title="" id="type">
                <option value="Dine" onselect="hideOthers();displayExtra();">Dining</option>
                <option value="Drink" onselect="hideOthers();displayExtra();">Drinking</option>
                <option value="bcp" onselect="hideOthers();displayExtra();">Make Backup</option>
                <option value="Daily" onselect="hideOthers();">Daily Essentials</option>
                <option value="Fare" onselect="hideOthers();displayExtra();">Transportation Fare</option>
                <option value="Fee" onselect="hideOthers();">School Fee</option>
                <option value="Special" onselect="hideOthers();">Other Outcome</option>
                <option value="Inc" onselect="hideOthers();">Income</option>
            </select>
            <select title="" id="extra-Dine" style="display: none;">
                <option value="minimum1">The 1.4 Yuan's set</option>
                <option value="minimum2">The 1.9 Yuan's set</option>
                <option value="minimum3">The 2.1 Yuan's set</option>
                <option value="better1">4 Yuan's Dumpling</option>
                <option value="better2">5 Yuan's Huntun</option>
                <option value="better3">6.6 Yuan's Fruit</option>
                <option value="super1">8 Yuan's Omelette</option>
                <option value="super2">12 Yuan's Omelette</option>
                <option value="super3">12 Yuan's Super set</option>
                <option value="others">Other</option>
            </select>
            <select title="" id="extra-Drink" style="display: none;">
                <option value="water">Normal Water</option>
                <option value="others">Juice, Drinks, etc.</option>
            </select>
            <select title="" id="extra-Fare" style="display: none;">
                <option value="STM">SDU-SOFT <---> SDU-MOUNTAIN</option>
                <option value="STO">SDU-SOFT <---> SDU-OLD</option>
                <option value="STC">SDU-SOFT <---> SDU-CENTER</option>
                <option value="STH">SDU-SOFT <---> HOME</option>
                <option value="STS">SDU-SOFT <---> SSFZ</option>
                <option value="others">Other Transportation</option>
            </select>
        </div>

    </div>
</div>

<!-- 统计界面 -->
<div class="dialog general-background ln-12" id="dialog-speak-public">
    <div id="dialog-speak-public-contents" class="dialog-content-fade ln-12">
        <div class="flex flex-row flex-around padding-sm decorate-header" href='javascript:void(0)'>
            <img src="resource/public/decorate-header/1.png" class="ln-12"/>
            <img src="resource/public/decorate-header/2.png" class="ln-12"/>
            <img src="resource/public/decorate-header/3.png" class="ln-12"/>
            <img src="resource/public/decorate-header/4.png" class="ln-12"/>
            <img src="resource/public/decorate-header/5.png" class="ln-12"/>
        </div>
        <div class="col-12 padding-none background flex flex-center flex-column" style="height: 93%">
            <div class="flex flex-column flex-center ln-10.5 col-12">
                <div class="ln-1 col-11 flex flex-center circled-border" href='javascript:void(0)'>
                    <img src="resource/dialog-speak/public/text1.png" class="ln-5"/>
                </div>
                <div class="ln-6 col-12 flex flex-center">
                    <label class="col-9 ln-9 flex flex-center">
                        <textarea id="content-public" class="col-12 ln-9 circled-border padding-lg cont-text-area uni-font">写下你想说的话吧</textarea>
                    </label>
                </div>
                <div class="ln-1 col-11 flex flex-center circled-border" href='javascript:void(0)'>
                    <img src="resource/dialog-speak/public/text2.png" class="ln-5"/>
                </div>
                <div class="ln-4 col-11 padding-mi flex flex-row">
                    <div class="col-4 ln-12 circled-border margin-sm" content-img-public-serial='1'>
                        <img src="resource/public/associate1.png" class="ln-12 col-12">
                    </div>
                    <div class="col-4 ln-12 circled-border margin-sm" content-img-public-serial='2'>
                        <img src="resource/public/associate2.png" class="ln-12 col-12">
                    </div>
                    <div class="col-4 ln-12 circled-border margin-sm" content-img-public-serial='3'>
                        <img src="resource/public/associate3.png" class="ln-12 col-12">
                    </div>
                </div>
            </div>
            <div class="flex flex-row flex-around ln-1.5 col-12 margin-lg">
                <div class="flex flex-column flex-center ln-12" onclick="submit(false);">
                    <img src="resource/dialog-speak/public/icon_submit.png" class="ln-7"/>
                    <img src="resource/dialog-speak/public/text_submit.png" class="ln-5"/>
                </div>
                <div class="flex flex-column flex-center ln-12" dialog-close-target="#dialog-speak-public">
                    <img src="resource/dialog-speak/public/icon_cancel.png" class="ln-7"/>
                    <img src="resource/dialog-speak/public/text_cancel.png" class="ln-5"/>
                </div>
            </div>
        </div>
        <img src="resource/dialog-speak/public/polygon.png" class="decorate-polygon" href='javascript:void(0)'/>
    </div>
</div>

<!-- "道"私密盒子 -->
<div class="dialog general-background ln-12" id="dialog-speak-private">
    <div id="dialog-speak-private-contents" class="dialog-content-fade ln-12">
        <div class="flex flex-row flex-around padding-sm decorate-header" href='javascript:void(0)'>
            <img src="resource/public/decorate-header/1.png" class="ln-12"/>
            <img src="resource/public/decorate-header/2.png" class="ln-12"/>
            <img src="resource/public/decorate-header/3.png" class="ln-12"/>
            <img src="resource/public/decorate-header/4.png" class="ln-12"/>
            <img src="resource/public/decorate-header/5.png" class="ln-12"/>
        </div>
        <div class="col-12 padding-none background flex flex-center flex-column" style="height: 93%">
            <div class="flex flex-column flex-center ln-10.5 col-12">
                <div class="ln-1 col-11 flex flex-center circled-border" href='javascript:void(0)'>
                    <img src="resource/dialog-speak/public/text1.png" class="ln-5"/>
                </div>
                <div class="ln-5 col-12 flex flex-center">
                    <label class="col-9 ln-9 flex flex-center">
                        <textarea id="content-private" class="col-12 ln-9 circled-border padding-lg cont-text-area uni-font">写下你想说的话吧</textarea>
                    </label>
                </div>
                <div class="ln-1 col-10 flex flex-center padding-mi">
                    <input id="content-password-private" type="text" class="ln-12 col-11 uni-font uni-input set-input-holder" value="请设置一个密语吧" title=""/>
                    <div class="ln-12 col-2 flex flex-center" id="set-pw-hint"></div>
                </div>
                <div class="ln-1 col-11 flex flex-center circled-border" href='javascript:void(0)'>
                    <img src="resource/dialog-speak/public/text2.png" class="ln-5"/>
                </div>
                <div class="ln-4 col-11 padding-mi flex flex-row">
                    <div class="col-4 ln-12 circled-border margin-sm" content-img-private-serial='1'>
                        <img src="resource/public/associate1.png" class="ln-12 col-12">
                    </div>
                    <div class="col-4 ln-12 circled-border margin-sm" content-img-private-serial='2'>
                        <img src="resource/public/associate2.png" class="ln-12 col-12">
                    </div>
                    <div class="col-4 ln-12 circled-border margin-sm" content-img-private-serial='3'>
                        <img src="resource/public/associate3.png" class="ln-12 col-12">
                    </div>
                </div>
            </div>
            <div class="flex flex-row flex-around ln-1.5 col-12 margin-lg">
                <div class="flex flex-column flex-center ln-12" onclick="submit(true);">
                    <img src="resource/dialog-speak/public/icon_submit.png" class="ln-7"/>
                    <img src="resource/dialog-speak/public/text_submit.png" class="ln-5"/>
                </div>
                <div class="flex flex-column flex-center ln-12" dialog-close-target="#dialog-speak-private">
                    <img src="resource/dialog-speak/public/icon_cancel.png" class="ln-7"/>
                    <img src="resource/dialog-speak/public/text_cancel.png" class="ln-5"/>
                </div>
            </div>
        </div>
        <img src="resource/dialog-speak/public/polygon.png" class="decorate-polygon" href='javascript:void(0)'/>
    </div>
</div>

<!-- 加载框 -->
<div class="dialog" id="loading-icon">
    <div class="flex flex-center flex-column dialog-centered">
        <img src="resource/public/loading.gif"/>
    </div>
</div>

<!-- 提示框 -->
<div class="dialog-partly" id="notice" style="background-color: white">
    <div class="flex flex-center flex-column dialog-centered">
        <p id="notice-content" class="uni-font" style="color: black">系统异常</p>
        <div class="ln-3 flex flex-center flex-column" dialog-close-target="#notice">
            <p id="notice-confirm" class="uni-font padding-none margin-none" style="color: black">确认</p>
        </div>
    </div>
</div>

<!-- 加载界面 -->
<div class="dialog" id="loading" style="background-color: black">
    <div class="flex flex-center flex-column dialog-centered">
        <img src="resource/public/loading.gif"/>
        <p style="color: white;">正在加载中</p>
    </div>
</div>
</body>
</html>