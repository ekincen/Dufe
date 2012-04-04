/*
 *  Jquery Framework Plugin
 *  @Author:yijian.cen(yijian.cen#gmail.com)
 */
(function($){
    $.extend({
        framework:{
            setting:{
                dFlag:'default',
                dComp:'feed',
                contentId:'com_wrapper',
                com_wrapper:'com_wrapper',
                mod_wrapper:'mod_wrapper',
                ctrl_wrapper:'ctrl_wrapper',
                resTypePoperty:'dataType',
                resTypeStatic:'static',
                resTypeJs:'js',
                loadingFlag:'loading'
            },
            listenHash:function(){
                var runMethod=function(){
                    window.top.location.hash=location.hash
                    $('body').trigger('preHandleHash').dequeue('preHandleHash');
                    $.homeComp.handleHash();
                }
                if( ('onhashchange' in window) && ((typeof document.documentMode==='undefined') || document.documentMode==8)) {
                    window.onhashchange=runMethod;
                }else{
                    var itarget='/_blank.html?';
                    var last=location.hash;
                    //check if is IEbrowser
                    if($.browser.msie&&$.browser.version>='6.0'&&$.browser.version<='8.0'){
                        var iobj=$('<iframe></iframe>').attr('src',itarget+last.substr(1)).hide().prependTo($('body'));
                        iobj.load(function(){
                            $isearch=$(this).get(0).contentWindow.location.search;
                            $ihistory=$isearch=='?'?'':$isearch.replace('?','#');
                            if(location.hash!==$ihistory){
                                location.hash=$ihistory;
                            }
                        });
                        var checkHash=function(){
                            if(location.hash!==last){
                                last=location.hash;
                                iobj.attr('src',itarget+last.substr(1));
                                runMethod();
                            }
                        }
                    }else{
                        var checkHash=function(){
                            if(location.hash!==last){
                                last=location.hash;
                                runMethod();
                            }
                        }
                    }
                    window.setInterval(checkHash,100);
                }
            },
            handleHash:function(hash,userId,forceTarget){
                var setting=$.framework.setting;
                var getHtml=function(wname,wrapper,ele){
                    var wname_c='.'+wname;
                    var wtarget=wname+'-'+ele;
                    var wtarget_c='.'+wtarget;
                    if(!$(wtarget_c).length>0){
                        $(wrapper).append($('<div></div>').addClass(wname).addClass(wtarget));
                    }
                    $(wname_c).not($(wtarget_c).show()).hide();
                    return wtarget_c;
                }
                //module handler
                var loadModule=function(modinfoArr){
                    var mod_wrapper=setting.mod_wrapper;
                    var mod_wrapper_c='.'+mod_wrapper;
                    var mod_wtarget_cs=new Array();
                    var moduri='/home/mod';
                    for(i=0;i<modinfoArr.length;i++){
                        var modinfo=modinfoArr[i].split('@');
                        var mod=modinfo[0].split('_');
                        var act=mod[1]?'&&a='+mod[1]:'';mod=mod[0];
                        var mod_wtarget=mod_wrapper+'-'+modinfo[0];
                        var mod_wtarget_c='.'+mod_wtarget;
                        if(!$(mod_wtarget_c).length>0){
                            $('#'+modinfo[1]).append($('<div></div>').addClass(mod_wrapper).addClass(mod_wtarget));
                            $(mod_wtarget_c).load(moduri+'?q='+mod+act+(userId?'&&userId='+userId:''));
                        }
                        mod_wtarget_cs[i]=mod_wtarget_c;
                        /*
                        $(mod_wtarget_c).attr('dataType','reload').queue('reload',function(){ alert('df') });
                        */
                        var modStatus=$(mod_wtarget_c).attr('dataType');
                        if(modStatus){
                            $(mod_wtarget_c).dequeue(modStatus);
                            $(mod_wtarget_c).attr('dataType','').clearQueue();
                        }
                    }
                    $(mod_wrapper_c).not($(mod_wtarget_cs.join(',')).show()).hide();
                }
                //content handler
                var loadContent=function(comp,ctrl,target){
                    target=target+(userId?'&&userId='+userId:'');
                    var wtarget_c=getHtml(setting.com_wrapper,'#'+setting.contentId,comp);
                    //get module
                    var hideip=$('.hide-'+comp);
                    var hidevalArr=(hideip.length>0)?hideip.val().split(','):'';
                    loadModule(hidevalArr);
                    //get content
                    var cl_wtarget_c=getHtml(comp+'-'+setting.ctrl_wrapper,wtarget_c,ctrl);
                    //loading handler
                    switch($(cl_wtarget_c).attr(setting.resTypePoperty)){
                        case setting.resTypeStatic:
                        break;
                        case setting.resTypeJs:
                        $.ajax({
                            url:target+'&&restype='+setting.resTypeJs,
                            success:function(data){eval(data);}
                        });
                        break;
                        default:
                        var loadingData=$(wtarget_c).data(setting.loadingFlag);
                        if(loadingData) $(cl_wtarget_c).html(loadingData);
                        $.ajax({
                            url:target,
                            success:function(data){$(cl_wtarget_c).html(data)}
                        });
                    }
                }
                //hash handler
                if(res=$.framework.transHash(hash)){
                    //start to route
                    var target='/?_escaped_fragment_='+(forceTarget?forceTarget:res.target);
                    var comp=res.comp;
                    var ctrl=res.ctrl;

                    loadContent(comp,ctrl,target);
                }
            },
            transHash:function(hash){
                var patt=/(\/[\w]+)+\/?((&{0,2}[\w]+=[\w\u4e00-\u9fa5\+]+)+)?/i;
                var patt_h=/\/([\w]+)\/?([\w]+)?\/?([\w]+)?/i;
                if(patt.test(hash)){
                    //start to route
                    var res=patt_h.exec(hash);
                    var comp=res[1];
                    var ctrl=res[2]?res[2]:$.framework.setting.dFlag;
                    var target=patt.exec(hash)[0];
                    return {comp:comp,ctrl:ctrl,target:target}
                }else return false;
            },
            getCtrlobj:function(isDomain){
                if(res=$.framework.transHash(location.hash)){
                    return $('.'+(isDomain?$.framework.setting.dComp:res.comp)+'-'+$.framework.setting.ctrl_wrapper+'-'+res.ctrl+':visible');
                }else return false;
            },
            getCompobj:function(isDomain){
                if(res=$.framework.transHash(location.hash)){
                    return $('.'+$.framework.setting.com_wrapper+'-'+(isDomain?$.framework.setting.dComp:res.comp));
                }else return false;
            },
            setCtrlResponse:function(resType){
                var setting=$.framework.setting;
                var reg=/\/([\w]+)\/?([\w]+)?/;
                var res=reg.exec(location.hash);
                var comp=res[1];var ctrl=res[2]?res[2]:setting.dFlag;
                $('.'+comp+'-'+setting.ctrl_wrapper+'-'+ctrl).attr(setting.resTypePoperty,resType?resType:setting.resTypeStatic);
            }
        }
    });
    $.fn.extend({
        hashchange:function(execFunc,once){
            var thisoj=$(this);
            if(once){
                $('body').queue('preHandleHash',function(){
                    execFunc();
                });
            }else{
                if(!$(this).data('hashchange')){
                    $('body').bind('preHandleHash',function(){
                    execFunc.call(thisoj); });
                }
                $(this).data('hashchange',true);
            }
        }
    });
})(jQuery);