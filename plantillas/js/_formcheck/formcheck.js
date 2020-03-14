var FormCheck=new Class({Implements:[Options,Events],options:{tipsClass:"fc-tbx",errorClass:"fc-error",fieldErrorClass:"fc-field-error",submitByAjax:false,ajaxResponseDiv:false,ajaxEvalScripts:false,onAjaxRequest:$empty,onAjaxSuccess:$empty,onAjaxFailure:$empty,display:{showErrors:1,errorsLocation:1,indicateErrors:1,keepFocusOnError:0,checkValueIfEmpty:1,addClassErrorToField:0,fixPngForIe:1,replaceTipsEffect:1,flashTips:0,closeTipsButton:1,tipsPosition:"right",tipsOffsetX:-45,tipsOffsetY:0,listErrorsAtTop:false,scrollToFirst:true,fadeDuration:300},alerts:{required:"This field is required.",alpha:"This field accepts alphabetic characters only.",alphanum:"This field accepts alphanumeric characters only.",nodigit:"No digits are accepted.",digit:"Please enter a valid integer.",digitltd:"The value must be between %0 and %1",number:"Please enter a valid number.",email:"Please enter a valid email.",phone:"Please enter a valid phone.",url:"Please enter a valid url.",confirm:"This field is different from %0",differs:"This value must be different of %0",length_str:"The length is incorrect, it must be between %0 and %1",length_fix:"The length is incorrect, it must be exactly %0 characters",lengthmax:"The length is incorrect, it must be at max %0",lengthmin:"The length is incorrect, it must be at least %0",checkbox:"Please check the box",radios:"Please select a radio",select:"Please choose a value"},regexp:{required:/[^.*]/,alpha:/^[a-z ._-]+$/i,alphanum:/^[a-z0-9 ._-]+$/i,digit:/^[-+]?[0-9]+$/,nodigit:/^[^0-9]+$/,number:/^[-+]?\d*\.?\d+$/,email:/^[a-z0-9._%-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i,phone:/^[\d\s ().-]+$/,url:/^(http|https|ftp)\:\/\/[a-z0-9\-\.]+\.[a-z]{2,3}(:[a-z0-9]*)?\/?([a-z0-9\-\._\?\,\'\/\\\+&amp;%\$#\=~])*$/i}},initialize:function(form,options){if(this.form=$(form)){this.form.isValid=true;this.regex=["length"];this.setOptions(options);if(typeof (formcheckLanguage)!="undefined"){this.options.alerts=formcheckLanguage}this.validations=[];this.alreadyIndicated=false;this.firstError=false;var regex=new Hash(this.options.regexp);regex.each(function(el,key){this.regex.push(key)},this);this.form.getElements("*[class*=validate]").each(function(el){el.validation=[];var classes=el.getProperty("class").split(" ");classes.each(function(classX){if(classX.match(/^validate(\[.+\])$/)){var validators=eval(classX.match(/^validate(\[.+\])$/)[1]);for(var i=0;i<validators.length;i++){el.validation.push(validators[i])}this.register(el)}},this)},this);this.form.addEvents({submit:this.onSubmit.bind(this)});if(this.options.display.fixPngForIe){this.fixIeStuffs()}document.addEvent("mousewheel",function(){this.isScrolling=false}.bind(this))}},register:function(B){this.validations.push(B);B.errors=[];if(B.validation[0]=="submit"){B.addEvent("click",function(C){this.onSubmit(C)}.bind(this));return true}if(this.isChildType(B)==false){B.addEvent("blur",function(C){if((B.element||this.options.display.showErrors==1)&&(this.options.display.checkValueIfEmpty||B.value)){this.manageError(B,"blur")}}.bind(this))}else{if(this.isChildType(B)==true){var A=this.form.getElements('input[name="'+B.getProperty("name")+'"]');A.each(function(C){C.addEvent("blur",function(){if((B.element||this.options.display.showErrors==1)&&(this.options.display.checkValueIfEmpty||B.value)){this.manageError(B,"click")}}.bind(this))},this)}}},validate:function(el){el.errors=[];el.isOk=true;el.validation.each(function(rule){if(this.isChildType(el)){if(this.validateGroup(el)==false){el.isOk=false}}else{var ruleArgs=[];if(rule.match(/^.+\[/)){var ruleMethod=rule.split("[")[0];ruleArgs=eval(rule.match(/^.+(\[.+\])$/)[1].replace(/([A-Z\.]+)/i,"'$1'"))}else{var ruleMethod=rule}if(this.regex.contains(ruleMethod)&&el.get("tag")!="select"){if(this.validateRegex(el,ruleMethod,ruleArgs)==false){el.isOk=false}}if(ruleMethod=="confirm"){if(this.validateConfirm(el,ruleArgs)==false){el.isOk=false}}if(ruleMethod=="differs"){if(this.validateDiffers(el,ruleArgs)==false){el.isOk=false}}if(el.get("tag")=="select"||(el.type=="checkbox"&&ruleMethod=="required")){if(this.simpleValidate(el)==false){el.isOk=false}}}},this);if(el.isOk){return true}else{return false}},simpleValidate:function(A){if(A.get("tag")=="select"&&(A.options[A.selectedIndex].text==A.options[0].text)){A.errors.push(this.options.alerts.select);return false}else{if(A.type=="checkbox"&&A.checked==false){A.errors.push(this.options.alerts.checkbox);return false}}return true},validateRegex:function(C,B,D){var E="";if(D[1]&&B=="length"){if(D[1]==-1){this.options.regexp.length=new RegExp("^[\\s\\S]{"+D[0]+",}$");E=this.options.alerts.lengthmin.replace("%0",D[0])}else{if(D[0]==D[1]){this.options.regexp.length=new RegExp("^[\\s\\S]{"+D[0]+"}$");E=this.options.alerts.length_fix.replace("%0",D[0])}else{this.options.regexp.length=new RegExp("^[\\s\\S]{"+D[0]+","+D[1]+"}$");E=this.options.alerts.length_str.replace("%0",D[0]).replace("%1",D[1])}}}else{if(D[0]&&B=="length"){this.options.regexp.length=new RegExp("^.{0,"+D[0]+"}$");E=this.options.alerts.lengthmax.replace("%0",D[0])}else{E=this.options.alerts[B]}}if(D[1]&&B=="digit"){var A=true;if(!this.options.regexp.digit.test(C.value)){C.errors.push(this.options.alerts[B]);A=false}if(D[1]==-1){if(C.value>=D[0]){var F=true}else{var F=false}E=this.options.alerts.digitmin.replace("%0",D[0])}else{if(C.value>=D[0]&&C.value<=D[1]){var F=true}else{var F=false}E=this.options.alerts.digitltd.replace("%0",D[0]).replace("%1",D[1])}if(A==false||F==false){C.errors.push(E);return false}}else{if(this.options.regexp[B].test(C.value)==false){C.errors.push(E);return false}}return true},validateConfirm:function(B,C){if(B.validation.contains("required")==false){B.validation.push("required")}var A=C[0];if(B.value!=this.form[A].value){msg=this.options.alerts.confirm.replace("%0",C[0]);B.errors.push(msg);return false}return true},validateDiffers:function(B,C){var A=C[0];if(B.value==this.form[A].value){msg=this.options.alerts.differs.replace("%0",C[0]);B.errors.push(msg);return false}return true},isChildType:function(B){var A=B.type.toLowerCase();if((A=="radio")){return true}return false},validateGroup:function(D){D.errors=[];var A=this.form[D.getProperty("name")];D.group=A;var C=false;for(var B=0;B<A.length;B++){if(A[B].checked){C=true}}if(C==false){D.errors.push(this.options.alerts.radios);return false}else{return true}},listErrorsAtTop:function(A){if(!this.form.element){this.form.element=new Element("div",{id:"errorlist","class":this.options.errorClass}).injectTop(this.form)}if($type(A)=="collection"){new Element("p").set("html","<span>"+A[0].name+" : </span>"+A[0].errors[0]).injectInside(this.form.element)}else{if((A.validation.contains("required")&&A.errors.length>0)||(A.errors.length>0&&A.value&&A.validation.contains("required")==false)){A.errors.each(function(B){new Element("p").set("html","<span>"+A.name+" : </span>"+B).injectInside(this.form.element)},this)}}},manageError:function(A,C){var B=this.validate(A);if((!B&&A.validation.contains("required"))||(!A.validation.contains("required")&&A.value&&!B)){if(this.options.display.listErrorsAtTop==true&&C=="submit"){this.listErrorsAtTop(A,C)}if(this.options.display.indicateErrors==2||this.alreadyIndicated==false||A.name==this.alreadyIndicated.name){if(!this.firstError){this.firstError=A}this.alreadyIndicated=A;if(this.options.display.keepFocusOnError&&A.name==this.firstError.name){(function(){A.focus()}).delay(20)}this.addError(A);return false}}else{if((B||(!A.validation.contains("required")&&!A.value))&&A.element){this.removeError(A);return true}}return true},addError:function(C){if(!C.element&&this.options.display.indicateErrors!=0){if(this.options.display.errorsLocation==1){var E=(this.options.display.tipsPosition=="left")?C.getCoordinates().left:C.getCoordinates().right;var B={opacity:0,position:"absolute","float":"left",left:E+this.options.display.tipsOffsetX};C.element=new Element("div",{"class":this.options.tipsClass,styles:B}).injectInside(document.body);this.addPositionEvent(C)}else{if(this.options.display.errorsLocation==2){C.element=new Element("div",{"class":this.options.errorClass,styles:{opacity:0}}).injectBefore(C)}else{if(this.options.display.errorsLocation==3){C.element=new Element("div",{"class":this.options.errorClass,styles:{opacity:0}});if($type(C.group)=="object"||$type(C.group)=="collection"){C.element.injectAfter(C.group[C.group.length-1])}else{C.element.injectAfter(C)}}}}}if(C.element){C.element.empty();if(this.options.display.errorsLocation==1){var D=[];C.errors.each(function(F){D.push(new Element("p").set("html",F))});var A=this.makeTips(D).injectInside(C.element);if(this.options.display.closeTipsButton){A.getElements("a.close").addEvent("mouseup",function(){this.removeError(C)}.bind(this))}C.element.setStyle("top",C.getCoordinates().top-A.getCoordinates().height+this.options.display.tipsOffsetY)}else{C.errors.each(function(F){new Element("p").set("html",F).injectInside(C.element)})}if(!Browser.Engine.trident5&&C.element.getStyle("opacity")==0){new Fx.Morph(C.element,{duration:this.options.display.fadeDuration}).start({opacity:[1]})}else{C.element.setStyle("opacity",1)}}if(this.options.display.addClassErrorToField&&this.isChildType(C)==false){C.addClass(this.options.fieldErrorClass)}},addPositionEvent:function(A){if(this.options.display.replaceTipsEffect){A.event=function(){new Fx.Morph(A.element,{duration:this.options.display.fadeDuration}).start({left:[A.element.getStyle("left"),A.getCoordinates().right+this.options.display.tipsOffsetX],top:[A.element.getStyle("top"),A.getCoordinates().top-A.element.getCoordinates().height+this.options.display.tipsOffsetY]})}.bind(this)}else{A.event=function(){A.element.setStyles({left:A.getCoordinates().right+this.options.display.tipsOffsetX,top:A.getCoordinates().top-A.element.getCoordinates().height+this.options.display.tipsOffsetY})}.bind(this)}window.addEvent("resize",A.event)},removeError:function(A){this.firstError=false;this.alreadyIndicated=false;A.errors=[];A.isOK=true;window.removeEvent("resize",A.event);if(this.options.display.errorsLocation==2){new Fx.Morph(A.element,{duration:this.options.display.fadeDuration}).start({height:[0]})}if(!Browser.Engine.trident5){new Fx.Morph(A.element,{duration:this.options.display.fadeDuration,onComplete:function(){if(A.element){A.element.destroy();A.element=false}}.bind(this)}).start({opacity:[1,0]})}else{A.element.destroy();A.element=false}if(this.options.display.addClassErrorToField&&!this.isChildType(A)){A.removeClass(this.options.fieldErrorClass)}},focusOnError:function(B){if(this.options.display.scrollToFirst&&!this.alreadyFocused&&!this.isScrolling){if(this.alreadyIndicated.element){switch(this.options.display.errorsLocation){case 1:var A=B.element.getCoordinates().top;break;case 2:var A=B.element.getCoordinates().top-30;break;case 3:var A=B.getCoordinates().top-30;break}this.isScrolling=true}else{if(!this.options.display.indicateErrors){var A=B.getCoordinates().top-30}}if(window.getScroll.y!=A){new Fx.Scroll(window,{onComplete:function(){this.isScrolling=false;B.focus()}.bind(this)}).start(0,A)}else{this.isScrolling=false;B.focus()}this.alreadyFocused=true}},fixIeStuffs:function(){if(Browser.Engine.trident4){var F=new RegExp("url\\(([.a-zA-Z0-9_/:-]+.png)\\)");var H=new RegExp("(.+)formcheck.css");for(var C=0;C<document.styleSheets.length;C++){if(document.styleSheets[C].href.match(/formcheck\.css$/)){var E=document.styleSheets[C].href.replace(H,"$1");var D=document.styleSheets[C].rules.length;for(var B=0;B<D;B++){var I=document.styleSheets[C].rules[B].style;var G=E+I.backgroundImage.replace(F,"$1");if(G&&G.match(/\.png/i)){var A=(I.backgroundRepeat=="no-repeat")?"crop":"scale";I.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='"+G+"', sizingMethod='"+A+"')";I.backgroundImage="none"}}}}}},makeTips:function(C){var E=new Element("table");E.cellPadding="0";E.cellSpacing="0";E.border="0";var D=new Element("tbody").injectInside(E);var B=new Element("tr").injectInside(D);new Element("td",{"class":"tl"}).injectInside(B);new Element("td",{"class":"t"}).injectInside(B);new Element("td",{"class":"tr"}).injectInside(B);var H=new Element("tr").injectInside(D);new Element("td",{"class":"l"}).injectInside(H);var A=new Element("td",{"class":"c"}).injectInside(H);var G=new Element("div",{"class":"err"}).injectInside(A);C.each(function(I){I.injectInside(G)});if(this.options.display.closeTipsButton){new Element("a",{"class":"close"}).injectInside(A)}new Element("td",{"class":"r"}).injectInside(H);var F=new Element("tr").injectInside(D);new Element("td",{"class":"bl"}).injectInside(F);new Element("td",{"class":"b"}).injectInside(F);new Element("td",{"class":"br"}).injectInside(F);return E},reinitialize:function(){this.validations.each(function(A){if(A.element){A.errors=[];A.isOK=true;if(this.options.display.flashTips==1){A.element.destroy();A.element=false}}},this);if(this.form.element){this.form.element.empty()}this.alreadyFocused=false;this.firstError=false;this.alreadyIndicated=false;this.form.isValid=true},submitByAjax:function(){var A=this.form.getProperty("action");this.fireEvent("ajaxRequest");new Request({url:A,method:this.form.getProperty("method"),data:this.form.toQueryString(),evalScripts:this.options.ajaxEvalScripts,onFailure:function(B){this.fireEvent("ajaxFailure",B)}.bind(this),onSuccess:function(B){this.fireEvent("ajaxSuccess",B);if(this.options.ajaxResponseDiv){$(this.options.ajaxResponseDiv).set("html",B)}}.bind(this)}).send()},onSubmit:function(A){new Event(A).stop();this.reinitialize();this.validations.each(function(B){if(!this.manageError(B,"submit")){this.form.isValid=false}},this);(this.form.isValid)?(this.options.submitByAjax)?this.submitByAjax():this.form.submit():this.focusOnError(this.firstError)}});