if(window.jQuery==undefined){
    alert("dzscalendar.js -> jQuery is not defined or improperly declared ( must be included at the start of the head tag ), you need jQuery for this plugin");
}
var settings_dzscalendar = { animation_time: 500, animation_easing:'swing' };

function is_ie8(){
    if(jQuery.browser.msie==undefined){
        return false;
    }else{
        if(jQuery.browser.version>8)
            return false;
        else
            return true;
    }
}
(function($) {

    $.fn.dzscalendar = function(o) {

        var defaults = {
            settings_slideshowTime : '5' //in seconds
            , settings_autoHeight : 'on'
            , settings_skin : 'skin-default'
            , start_month : ''
            , start_year : ''
            , start_weekday : 'Sunday'
            , design_transition: 'slide'
            , design_transitionDesc: 'tooltipDef'
        }

        o = $.extend(defaults, o);
        this.each( function(){
            var cthis = jQuery(this);
            var tw
            ,th
            ;
            var cchildren = cthis.children();
            var currNr=-1
            ,currMon=0
            ,currYear=0
            ,_currTable
            ,currHeight
            ,currWidth
            ,currDesc
            ,_argTable
            ,busy = false
            ,forward=false
            ;
            var _c;
            var timebuf=0
            ,skin_tableWidth = 182
            ,skin_normalHeight = 138
            ;
            var slideshowTime = parseInt(o.settings_slideshowTime);
            var i=0, j=0, k=0;
            var theMonths
            ,theControls
            ,_currDate
            ;
            var events = [];
            var now
            ,dat
            ;
            var posX, posY, origH='auto';
            var monthNames = [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];
            init();


            function init(){
               // cchildren.eq(0).css('position', 'absolute');
               if(cthis.attr('class').indexOf("skin-")==-1){
                cthis.addClass(o.settings_skin);
                }
                if(cthis.hasClass('skin-default')){
                    o.settings_skin = 'skin-default';
                }
                if(cthis.hasClass('skin-black')){
                    o.settings_skin = 'skin-black';
                    skin_tableWidth = 192;
                    skin_normalHeight = 158;
                    tw = 192; th = 158;
                }
                if(cthis.hasClass('skin-aurora')){
                    tw = 212;
                    th = 220;
                }
                
                
                
                if(o.design_transitionDesc=='default'){
                    o.design_transitionDesc = 'tooltipDef';
                }
                
                
                
                now = new Date();
                
                //console.log(now, now.getFullYear(), now.getDate());
                
                for(i=0;i<cthis.children('.events').children().length;i++){
                    _c = cthis.children('.events').children().eq(i);
                    events[i] = {date: _c.attr('data-date'), content: _c.html()};
                }
                cthis.children('.events').remove();
                cthis.append('<div class="calendar-controls">' + '<div class="arrow-left"></div>' + '<div class="curr-date"><span class="curr-month">'+monthNames[now.getMonth()]+'</span><span class="curr-year">'+now.getFullYear()+'</span></div>' + '<div class="arrow-right"></div>' + '</div>')
                
                cthis.append('<div class="theMonths"></div>');
                _currDate = cthis.find('.curr-date');
                theMonths = cthis.children('.theMonths'); 
                theControls = cthis.children('.calendar-controls');
                
                
                if(o.design_transitionDesc=='slide'){
                    theMonths.css({'overflow': 'hidden'})
                }
                
                
                //var auxWeekRow = '<tr><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td></tr>';
                //var auxMout = auxWeekRow + auxWeekRow + auxWeekRow + auxWeekRow + auxWeekRow + auxWeekRow;
                
                //theMonths.find('tbody').append('')
                //setInterval(tick, 1000);
                //gotoItem(0);
                
                cthis.find('.arrow-left').click(click_arrow_left);
                cthis.find('.arrow-right').click(click_arrow_right);
                cthis.find('.hasEvent').live('click', click_event);
                
                currMon = now.getMonth();
                currYear = now.getFullYear();
                if(o.start_year!=''){
                    currYear = parseInt(o.start_year, 10);
                }
                if(o.start_month!=''){
                    currMon = parseInt(o.start_month, 10);
                    currMon--;
                }
                //console.log(currYear, currMon);
                gotoItem(currYear, currMon);
                
                cthis.css('height', cthis.height()); origH = cthis.height();
                //console.log(origH);
                
            }
            function hide_tooltips(){
                //console.log(currNr);
                if(o.design_transitionDesc=='tooltipDef'){
                cthis.find('.dzstooltip').each(function(){
                    var _t2 = jQuery(this);
                    _t2.removeClass('currTooltip');
                    _t2.animate({
                        'opacity' : 0
                        ,'left' : (posX + 50)
                    },{queue:false, complete:complete_removeTooltips, duration:settings_dzscalendar.animation_time, easing:settings_dzscalendar.animation_easing})
                })
                }
                cthis.css('height', origH);
            }
            function click_event(e){
                var _t = jQuery(this);
                //console.log('ceva');
                if(_t.hasClass("desc-close-button")){
                    
                    
                    if(o.design_transitionDesc=='slide'){
                        currDesc.animate({'top' : -skin_normalHeight}
                        ,{queue:false, duration:settings_dzscalendar.animation_time/1.5, easing:settings_dzscalendar.animation_easing})
                        theControls.animate({'top' : 0}
                        ,{queue:false, duration:settings_dzscalendar.animation_time/1.5, easing:settings_dzscalendar.animation_easing})
                        theMonths.animate({'top' : 0}
                        ,{queue:false, duration:settings_dzscalendar.animation_time/1.5, easing:settings_dzscalendar.animation_easing})
                        return;
                    }
                    return;
                    
                    
                }
                //return;
                
                hide_tooltips();
                if(_t.hasClass('openTooltip')){
                    _t.removeClass('openTooltip')
                    return;
                }
                var date = _t.attr('data-date');
                var _par = _t.parent().parent().parent().parent().parent();
                cthis.find('.openTooltip').each(function(){
                    var _t2 = jQuery(this);
                    _t2.removeClass('openTooltip');
                })
                _t.addClass('openTooltip');
                k=0;
                for(i=0;i<events.length;i++){
                    //console.log(events[i].date, date)
                    if(events[i].date == date){
                        k = i;
                        break;
                    }
                }
                posX = _t.offset().left - _par.offset().left;
                posY = _t.offset().top - _par.offset().top;
                //console.log(_t, _par, _t.offset().left, _t.offset().top, _par.offset().top, k, date, events);
                
                if(o.design_transitionDesc=='tooltipDef'){
                cthis.append('<div class="dzstooltip arrow-left currTooltip" style="left:'+(posX+50)+'px; top:'+posY+'px;"></div>');
                var ttip = cthis.children('.dzstooltip').last();
                ttip.html(events[k].content);
                    ttip.animate({
                        'opacity' : 1
                        ,'left' : posX + 30
                    },{queue:false, duration:settings_dzscalendar.animation_time/1.5, easing:settings_dzscalendar.animation_easing})
                
                //console.log(ttip.height(), parseInt(ttip.css('top'), 10), cthis.height());
                if(ttip.height() + parseInt(ttip.css('top'), 10) > cthis.height()){
                    origH = cthis.height();
                    cthis.css('height', (ttip.height() + parseInt(ttip.css('top'), 10)));
                    //cthis.height;
                }
                }
                //console.log(o.design_transitionDesc);
                if(o.design_transitionDesc=='slide'){
                    //console.log(cthis);
                    cthis.css({'overflow' : 'hidden'});
                    cthis.append('<div class="currDesc slideDescription" style=""></div>');
                    currDesc = cthis.find('.currDesc').eq(0);
                    currDesc.html(events[k].content);
                    currDesc.append('<div class="desc-close-button">x</div>')
                    currDesc.css({'top' : -skin_normalHeight, 'width' : skin_tableWidth})
                    currDesc.children('div').css({'width' : 'auto'})
                    currDesc.animate({'top' : 0}
                    ,{queue:false, duration:settings_dzscalendar.animation_time/1.5, easing:settings_dzscalendar.animation_easing})
                    theControls.animate({'top' : th + 20}
                    ,{queue:false, duration:settings_dzscalendar.animation_time/1.5, easing:settings_dzscalendar.animation_easing})
                    theMonths.animate({'top' : th + 20}
                    ,{queue:false, duration:settings_dzscalendar.animation_time/1.5, easing:settings_dzscalendar.animation_easing})
                    currDesc.children('.desc-close-button').bind('click', click_event);
                }
                
                //console.log(ttip);
                
            }
            function complete_removeTooltips(){
                if(o.design_transitionDesc=='tooltipDef'){
                cthis.find('.dzstooltip').each(function(){
                    var _t3 = jQuery(this);
                    //console.log(_t3);
                    if(_t3.hasClass('currTooltip')==false){
                        _t3.remove();
                    }
                })
                }
            }
            function tick(){
                timebuf++;
                if(timebuf>slideshowTime){
                    timebuf=0;
                    gotoNext();
                }
            }
            function click_arrow_left(){
                var auxMon = currMon - 1;
                var auxYear = currYear;
                if(auxMon == -1){
                    auxMon = 11;
                    auxYear--;
                }
                gotoItem(auxYear, auxMon);
            }
            function click_arrow_right(){
                var auxMon = currMon + 1;
                var auxYear = currYear;
                if(auxMon == 12){
                    auxMon = 0;
                    auxYear++;
                }
                gotoItem(auxYear, auxMon);
            }
            function gotoNext(){
                var aux=currNr+1;
                if(aux>cchildren.length-1){
                    aux=0;
                }
                gotoItem(aux);
            }
            function daysInMonth(y,m) {
                return new Date(y, m, 0).getDate();
            }
            //function 
            function gotoItem(arg1, arg2){
                
                var argdat = new Date();
                //console.log(arg1, arg2);
                if(busy==true){
                    return;
                }
                busy=true;
                
                argdat.setYear(arg1);
                argdat.setMonth(arg2)
                argdat.setDate(0);
                
                
                
                var lastMonth = arg2;
                var lastMonthYear = arg1;
                
                var nextMonth = arg2+1;
                var nextMonthYear = arg1;
                
                if(nextMonth==12){
                    nextMonth = 0;
                    nextMonthYear++;
                }
                
                var auxMout = '<tr>';
                var auxDay = argdat.getDay();
                
                //console.info(auxDay, arg2, lastMonth);
                
                if(o.start_weekday=='Monday'){
                    auxDay--;
                }
                
                
                var auxWeekSepInd = 0;
                // ----- past month
                for(i=0; i<=auxDay; i++){
                    auxMout+='<td class="other-months-date';
                    var auxdat = new Date(arg1, arg2,i+2);
                    
                    if(auxdat<now){
                        auxMout+=' past-date';
                    }
                    auxMout+='"';
                    //auxMout+=' data-date="'+(arg2+1)+'-'+(i+1)+'-'+arg1+'"';
                    auxMout+='>';
                    auxMout+=(daysInMonth(lastMonthYear, lastMonth) - auxDay + i + 1);
                    auxMout+= '</td>';
                    //auxMout = 
                    if(auxWeekSepInd==6){
                        auxMout+='</tr>';
                        auxMout+='<tr>';
                        auxWeekSepInd=-1;
                    }
                    auxWeekSepInd++;
                }
                
                // ----- current month
                for(i=0; i<daysInMonth(nextMonthYear, nextMonth); i++){
                    auxMout+='<td class="curr-months-date';
                    var auxdat = new Date(arg1, arg2,i+2);
                    
                    if(auxdat<now){
                        auxMout+=' past-date';
                    }
                    //console.log(i);
                    var date = (arg2+1)+'-'+(i+1)+'-'+arg1;
                    for(j=0; j<events.length;j++){
                            //console.log('ceva', events[j].date, date);
                        if(events[j].date == date){
                            //console.log('ceva', events[j].date);
                            auxMout+=' hasEvent';
                        }
                    }
                    auxMout+='"'; auxMout+=' data-date="'+date+'"'; auxMout+='>'; auxMout+=(i+1); auxMout+= '</td>';
                    
                    if(auxWeekSepInd==6){
                        auxMout+='</tr>';
                        auxMout+='<tr>';
                        auxWeekSepInd=-1;
                    }
                    auxWeekSepInd++;
                }
                // ----- next month
                if(auxWeekSepInd>0){
                    for(i=0;auxWeekSepInd<7;i++){
                        
                        auxMout+='<td class="other-months-date';
                    var auxdat = new Date(arg1, arg2,i+2);
                    
                    if(auxdat<now){
                        auxMout+=' past-date';
                    }
                    //console.log(i);
                    auxMout+='"';
                    //auxMout+=' data-date="'+(arg2+2)+'-'+(i+1)+'-'+arg1+'"';
                    auxMout+='>';
                    auxMout+=(i + 1); 
                    auxMout+= '</td>';
                    
                    auxWeekSepInd++;
                        
                        
                    }
                }
                
                auxMout += '</tr>';
                //console.log( auxWeekSepInd, daysInMonth(lastMonthYear, lastMonth));
                //console.info(auxMout);
                
                
                if(theMonths.children().length>0){
                    theMonths.children().eq(0).removeClass('argTable');
                    theMonths.children().eq(0).addClass('currTable');
                    if(arg1>currYear){
                        forward=true;
                    }else{
                        if(arg1<currYear){
                            forward=false;
                        }else{
                            if(arg1==currYear){
                                if(arg2<currMon){
                                    forward=false;
                                }else{
                                    forward=true;
                                }
                            }
                        }
                    }
                }else{
                    busy=false;
                }
                
                
                currYear = arg1;
                currMon = arg2;
                currNr = 0;
                //console.log(_currDate, _currDate.children('.curr-month'))
                _currDate.children('.curr-month').html(monthNames[currMon])
                _currDate.children('.curr-year').html(currYear)
                var aux = '';
                var weekDays = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
                if(o.header_weekdayStyle=='three'){
                    weekDays = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
                }
                
                if(o.start_weekday=='Sunday'){
                    aux = '<table class="argTable"><thead><tr class="headerRow">';
                    for(i=0;i<weekDays.length;i++){
                        aux+='<td>' + weekDays[i] + '</td>';
                    }
                        aux+='</tr><tbody>'+auxMout+'</tbody></table>';
                }
                if(o.start_weekday=='Monday'){
                    aux = '<table class="argTable"><thead><tr class="headerRow"><td>M</td><td>T</td><td>W</td><td>T</td><td>F</td><td>S</td><td>S</td></tr><tbody>'+auxMout+'</tbody></table>';
                }
                theMonths.append(aux);
                
                
                if(currNr>-1){
                hide_tooltips();
                if(theMonths.css('height')=='auto' || theMonths.css('height')=='0px'){
                theMonths.css('height', (cthis.find('.argTable tbody').find('tr').eq(0).height() * 7));
                }
            }
                
                
                the_transition();
                
                
                
                return;
                
                if(currNr>-1){
                    cchildren.eq(currNr).fadeOut('slow');
                }
                cchildren.eq(arg).fadeIn('slow');
                if(o.settings_autoHeight=='on'){
                    cthis.animate({
                        'height' : cchildren.eq(arg).height()
                        })
                }
                currNr=arg;

            }
            function the_transition(){
                if(theMonths.children().length==1){
                    return;
                }
                _currTable = theMonths.children('.currTable');
                _argTable = theMonths.children('.argTable');
                //var _theanimParams = ;
                //console.log(animParams);
                if(o.design_transition=='slide' || o.design_transition=='none'){
                _currTable.css({
                    'top' : 0
                    ,'left' : 0
                })
                if(forward==true){
                    _currTable.animate({
                        'top' : 0
                        ,'left' : -(skin_tableWidth+10)
                    },{queue:false, complete:the_transition_complete ,duration:settings_dzscalendar.animation_time, easing:settings_dzscalendar.animation_easing});
                    
                    _argTable.css({
                        'top' : 0
                        ,'left' : skin_tableWidth+10
                    })
                }else{
                    _currTable.animate({
                        'top' : 0
                        ,'left' : skin_tableWidth+10
                    },{queue:false, complete:the_transition_complete ,duration:settings_dzscalendar.animation_time, easing:settings_dzscalendar.animation_easing});
                    
                    _argTable.css({
                        'top' : 0
                        ,'left' : -(skin_tableWidth+10)
                    })
                    
                }
                _argTable.animate({
                        'top' : 0
                        ,'left' : 0
                    },{queue:false, duration:settings_dzscalendar.animation_time, easing:settings_dzscalendar.animation_easing});
                
                
                
                if(!is_ie8()){
                    for(i=_argTable.find('tbody').find('tr').length;i>-1;i--){
                        //continue;
                        _c = _argTable.find('tbody').find('tr').eq(i);
                        _c.css({
                            'opacity' : 0
                        })
                        var aux = settings_dzscalendar.animation_time *3 / (_argTable.find('tbody').find('tr').length-i+1);
                        //console.log(aux);
                        _c.delay(settings_dzscalendar.animation_time/2).animate({
                            'opacity' : 1
                        },{queue:true, duration:aux, easing:settings_dzscalendar.animation_easing});
                    }
                    for(i=_argTable.find('tbody').find('tr').length;i>-1;i--){
                        break;
                        _c = _currTable.find('tbody').find('tr').eq(i);
                        var aux = settings_dzscalendar.animation_time * 2 / (i+1);
                        //console.log(aux);
                        _c.animate({
                            'opacity' : 1
                        },{queue:true, duration:aux, easing:settings_dzscalendar.animation_easing});

                    }
                }
                }
                
                return;
            }
            function the_transition_complete(){
                _currTable.remove();
                busy=false;
            }
            return this;
        })
    }
})(jQuery)
