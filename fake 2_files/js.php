(function(c){function p(d,a,b){var e=this,l=d.add(this),h=d.find(b.tabs),j=a.jquery?a:d.children(a),i;h.length||(h=d.children());j.length||(j=d.parent().find(a));j.length||(j=c(a));c.extend(this,{click:function(f,g){var k=h.eq(f);if(typeof f=="string"&&f.replace("#","")){k=h.filter("[href*="+f.replace("#","")+"]");f=Math.max(h.index(k),0)}if(b.rotate){var n=h.length-1;if(f<0)return e.click(n,g);if(f>n)return e.click(0,g)}if(!k.length){if(i>=0)return e;f=b.initialIndex;k=h.eq(f)}if(f===i)return e;g=g||c.Event();g.type="onBeforeClick";l.trigger(g,[f]);if(!g.isDefaultPrevented()){o[b.effect].call(e,f,function(){g.type="onClick";l.trigger(g,[f])});i=f;h.removeClass(b.current);k.addClass(b.current);return e}},getConf:function(){return b},getTabs:function(){return h},getPanes:function(){return j},getCurrentPane:function(){return j.eq(i)},getCurrentTab:function(){return h.eq(i)},getIndex:function(){return i},next:function(){return e.click(i+1)},prev:function(){return e.click(i-1)}});c.each("onBeforeClick,onClick".split(","),function(f,g){c.isFunction(b[g])&&c(e).bind(g,b[g]);e[g]=function(k){c(e).bind(g,k);return e}});if(b.history&&c.fn.history){c.tools.history.init(h);b.event="history"}h.each(function(f){c(this).bind(b.event,function(g){e.click(f,g);return g.preventDefault()})});j.find("a[href^=#]").click(function(f){e.click(c(this).attr("href"),f)});if(location.hash)e.click(location.hash);else if(b.initialIndex===0||b.initialIndex>0)e.click(b.initialIndex)}c.tools=c.tools||{version:"1.2.2"};c.tools.tabs={conf:{tabs:"a",current:"current",onBeforeClick:null,onClick:null,effect:"default",initialIndex:0,event:"click",rotate:false,history:false},addEffect:function(d,a){o[d]=a}};var o={"default":function(d,a){this.getPanes().hide().eq(d).show();a.call()},fade:function(d,a){var b=this.getConf(),e=b.fadeOutSpeed,l=this.getPanes();e?l.fadeOut(e):l.hide();l.eq(d).fadeIn(b.fadeInSpeed,a)},slide:function(d,a){this.getPanes().slideUp(200);this.getPanes().eq(d).slideDown(400,a)},ajax:function(d,a){this.getPanes().eq(0).load(this.getTabs().eq(d).attr("href"),a)}},m;c.tools.tabs.addEffect("horizontal",function(d,a){m||(m=this.getPanes().eq(0).width());this.getCurrentPane().animate({width:0},function(){c(this).hide()});this.getPanes().eq(d).animate({width:m},function(){c(this).show();a.call()})});c.fn.tabs=function(d,a){var b=this.data("tabs");if(b)return b;if(c.isFunction(a))a={onBeforeClick:a};a=c.extend({},c.tools.tabs.conf,a);this.each(function(){b=new p(c(this),d,a);c(this).data("tabs",b)});return a.api?b:this}})(jQuery);(function($){function Carousel(obj,conf)
{var self=this,_isScrolling=false,$current,$root,$itemsContainer,$items,$prevButton,$nextButton,_rootCenterOffsetLeft,_rootOffsetLeft,_rootOffsetRight,_rootWidth,_rootCenterOffsetTop,_rootOffsetTop,_rootOffsetBottom,_rootHeight,pageCount,currentPage,$_lastItem,$_firstItem,_defaultPaginationContainerClass='carousel-pagination',_itemsContainerWidth,_itemsContainerHeight,_activeCarouselClass='active-carousel';var settings={itemsContainerSelector:'.items',itemSelector:'.item',nextButtonSelector:null,prevButtonSelector:null,callback:'',pagination:true,paginationContainerSelector:null,vertical:false};function init(root,userSettings)
{$root=$(root);if($root.length==0||$root.hasClass(_activeCarouselClass))return;$itemsContainer=$(settings.itemsContainerSelector,$root);if($itemsContainer.length==0)return;$items=$itemsContainer.children(settings.itemSelector);if($items.length==0)return;$_lastItem=$items.last();$_firstItem=$items.first();var lastItemMarginRight=$_lastItem.css('marginRight');if(lastItemMarginRight=='auto')lastItemMarginRight=0;var firstItemMarginLeft=$_firstItem.css('marginLeft');if(firstItemMarginLeft=='auto')firstItemMarginLeft=0;var lastItemMarginBottom=$_lastItem.css('marginBottom');if(lastItemMarginBottom=='auto')lastItemMarginBottom=0;var firstItemMarginTop=$_firstItem.css('marginTop');if(firstItemMarginTop=='auto')firstItemMarginTop=0;if(typeof userSettings=='object')$.extend(settings,userSettings);if(false!==settings.vertical)
{_itemsContainerHeight=Math.round(($_lastItem.offset().top+$_lastItem.outerHeight()+parseInt(lastItemMarginBottom))
-($_firstItem.offset().top-parseInt(firstItemMarginTop)));$itemsContainer.height(_itemsContainerHeight);}
else
{_itemsContainerWidth=Math.round(($_lastItem.offset().left+$_lastItem.outerWidth()+parseInt(lastItemMarginRight))
-($_firstItem.offset().left-parseInt(firstItemMarginLeft)));$itemsContainer.width(_itemsContainerWidth);}
$root.css('overflow','hidden');$itemsContainer.css('position','relative');_rootOffsetLeft=$root.offset().left;_rootCenterOffsetLeft=_rootOffsetLeft+($root.outerWidth()/2);_rootWidth=$root.width();_rootOffsetRight=_rootOffsetLeft+_rootWidth;_rootOffsetTop=$root.offset().top;_rootCenterOffsetTop=_rootOffsetTop+($root.outerHeight()/2);_rootHeight=$root.height();_rootOffsetBottom=_rootOffsetTop+_rootHeight;pageCount=Math.ceil((false!==settings.vertical?_itemsContainerHeight/$root.height():_itemsContainerWidth/$root.width()));if(pageCount==1)settings.pagination=false;pageCount=parseInt(pageCount)||0;if(settings.pagination){var paginationContainer;if(settings.paginationContainerSelector!=null)paginationContainer=$(settings.paginationContainerSelector);else
{paginationContainer=$root.find('.'+_defaultPaginationContainerClass);if(paginationContainer.length==0)
{paginationContainer=$('<div class="'+_defaultPaginationContainerClass+'"></div>');$root.append(paginationContainer);}}
var pageClick=function(event)
{event.preventDefault();_gotoPage(event.data.page);};for(var i=1;i<=pageCount;i++)
{var pageLinkClasses='carousel-page-'+i;var pageLink=$('<a href="#" class="'+pageLinkClasses+'"></a>');pageLink.bind('click',{page:i},pageClick);paginationContainer.append(pageLink);}}
var _firstCurrent=$items.filter('.current');_firstCurrent=(_firstCurrent.length>0)?_firstCurrent.eq(0):$_firstItem;select(_firstCurrent);_updatePagination();$nextButton=(settings.nextButtonSelector==null)?$('.next',$root):$(settings.nextButtonSelector);$prevButton=(settings.prevButtonSelector==null)?$('.prev',$root):$(settings.prevButtonSelector);_updateNextPreviousButtonState();if($nextButton.length!=0)$nextButton.click(self.nextPage);if($prevButton.length!=0)$prevButton.click(self.prevPage);$items.click(function(e)
{var href=($(e.target).attr('href')!=undefined)?$(e.target).attr('href'):$(e.target).parent().attr('href');if(href==undefined||href.indexOf('http')==-1)
{e.preventDefault();select(e.currentTarget);}});$root.addClass(_activeCarouselClass);}
self.prevPage=function()
{if(!$prevButton.hasClass('disabled'))
{_gotoPage(currentPage-1);}
return false;};self.nextPage=function()
{if(!$nextButton.hasClass('disabled'))
{_gotoPage(currentPage+1);}
return false;};function _gotoPage(page)
{if(page>pageCount)page=pageCount;else if(page<1)page=1;var
desiredOffset=((page-1)*(settings.vertical?_rootHeight:_rootWidth)),scrollOffset=(settings.vertical?_rootOffsetTop-$itemsContainer.offset().top:_rootOffsetLeft-$itemsContainer.offset().left)-desiredOffset;_scroll(scrollOffset,_setFirstVisibleItemToCurrent);};function select(index_or_element)
{var $selectedItem=(typeof index_or_element=='number')?$items.eq(index_or_element):$(index_or_element);if($selectedItem.length==0||$items.index($selectedItem)<0)return;_updateCurrent($selectedItem);var
selectedItemWidth=$selectedItem.outerWidth(),selectedItemHeight=$selectedItem.outerHeight(),elCenterOffsetLeft=$selectedItem.offset().left+(selectedItemWidth/2),elCenterOffsetTop=$selectedItem.offset().top+(selectedItemHeight/2),scrollOffset;if(settings.vertical)
scrollOffset=parseInt((_rootCenterOffsetTop-elCenterOffsetTop)/selectedItemHeight)*$selectedItem.outerHeight(true);elsescrollOffset=parseInt((_rootCenterOffsetLeft-elCenterOffsetLeft)/selectedItemWidth)*$selectedItem.outerWidth(true);if(scrollOffset!==0)_scroll(scrollOffset);}var _scroll=function(offset,onComplete)
{if(_isScrolling===true||offset===0)return;if(offset>0)
{var firstItemMarginLeft=$_firstItem.css('marginLeft');if(firstItemMarginLeft=='auto')firstItemMarginLeft=0;var firstItemMarginTop=$_firstItem.css('marginTop');if(firstItemMarginTop=='auto')firstItemMarginTop=0;if(settings.vertical)
scrollOffset=Math.min((_rootOffsetTop-($_firstItem.offset().top-parseInt(firstItemMarginTop))),offset);else
scrollOffset=Math.min((_rootOffsetLeft-($_firstItem.offset().left-parseInt(firstItemMarginLeft))),offset);}
else
{var $lastItem=$_lastItem;var lastItemMarginRight=$_lastItem.css('marginRight');if(lastItemMarginRight=='auto')lastItemMarginRight=0;var lastItemMarginBottom=$_lastItem.css('marginBottom');if(lastItemMarginBottom=='auto')lastItemMarginBottom=0;if(settings.vertical)
{var lastItemBottomEdge=$lastItem.offset().top+$lastItem.outerHeight()+parseInt(lastItemMarginBottom);if(lastItemBottomEdge<_rootOffsetBottom)return;scrollOffset=Math.max((_rootOffsetBottom-lastItemBottomEdge),offset);}
else
{var lastItemRightEdge=$lastItem.offset().left+$lastItem.outerWidth()+parseInt(lastItemMarginRight);if(lastItemRightEdge<_rootOffsetRight)return;scrollOffset=Math.max((_rootOffsetRight-lastItemRightEdge),offset);}}
if(scrollOffset!=0)
{var animate=settings.vertical?{"top":'+='+scrollOffset+'px'}:{"left":'+='+scrollOffset+'px'};_isScrolling=true;$itemsContainer.animate(animate,400,function(){if(typeof onComplete=='function')onComplete();_updatePagination();_updateNextPreviousButtonState();_isScrolling=false;});}};var _setFirstVisibleItemToCurrent=function()
{var $first;var itemsLength=$items.length;for(var i=0;i<itemsLength;i++)
{if(settings.vertical&&$items.eq(i).offset().top>=_rootOffsetTop)
{$first=$items.eq(i);break;}
else if(false===settings.vertical&&$items.eq(i).offset().left>=_rootOffsetLeft)
{$first=$items.eq(i);break;}}
_updateCurrent($first);};var _updatePagination=function()
{var newCurrent,currentPageClass='carousel-current-page';if(settings.vertical)
{var lastItemBottomEdge=$_lastItem.offset().top+$_lastItem.outerHeight();if(lastItemBottomEdge<=_rootOffsetBottom)newCurrent=pageCount;else newCurrent=Math.ceil(((Math.abs($itemsContainer.offset().top-_rootOffsetTop))+$current.height())/_rootHeight);}else
{var lastItemRightEdge=$_lastItem.offset().left+$_lastItem.outerWidth();if(lastItemRightEdge<=_rootOffsetRight)newCurrent=pageCount;else newCurrent=Math.ceil(((Math.abs($itemsContainer.offset().left-_rootOffsetLeft))+$current.width())/_rootWidth);}if(currentPage!==undefined&&newCurrent===currentPage)return;currentPage=newCurrent;if(settings.pagination)
{var paginationContainer;if(settings.paginationContainerSelector!=null)paginationContainer=$(settings.paginationContainerSelector);else paginationContainer=$root.find('div.carousel-pagination');paginationContainer.find('a').removeClass(currentPageClass);paginationContainer.find('a.carousel-page-'+currentPage).addClass(currentPageClass);}};var _updateNextPreviousButtonState=function()
{if(currentPage===1)$prevButton.addClass('disabled');else $prevButton.removeClass('disabled');if(currentPage==pageCount)$nextButton.addClass('disabled');else $nextButton.removeClass('disabled');};var _updateCurrent=function(newCurrent)
{if(undefined!==$current)$current.removeClass('current');$current=newCurrent;$current.addClass('current');if(typeof settings.callback=='function')settings.callback($current);};self.next=function()
{select($current.next());return $current;};self.prev=function()
{select($current.prev());return $current;};init(obj,conf);}
$.fn.carousel=function(conf)
{var carousels=new Array();this.each(function(i){carousels[i]=new Carousel(this,conf);});if(carousels.length==1)
return carousels[0];else return carousels;};})(jQuery);(function($)
{$(document).ready(function()
{if($(window).width()<=1000){$('#navigation #main-menu').prepend('<li class="menu-heading"><div class="nav-icon"><span class="small-nav"><i class="fa fa-navicon"></i></span></div></li>');$('.nav-icon').click(function(e){$('#navigation #main-menu').slideToggle();if($('.nav-icon').find('i').hasClass('fa-navicon')){$('.nav-icon').find('i').removeClass('fa-navicon');$('.nav-icon').find('i').addClass('fa-remove');$('.nav-icon').find('i').css('color','red');$('.search-icon').css('display','none');$('body').css('overflow-y','hidden');}else{$('.nav-icon').find('i').addClass('fa-navicon');$('.nav-icon').find('i').removeClass('fa-remove');$('.nav-icon').find('i').css('color','#848484');$('.search-icon').css('display','block');$('body').css('overflow-y','auto');}});$('.search-icon').click(function(e){$('#sub-nav').slideToggle('fast');if($('.search-icon').find('i').hasClass('fa-search')){$(this).find('i').removeClass('fa-search');$(this).find('i').addClass('fa-remove');$(this).find('i').css('color','red');}else{$(this).find('i').addClass('fa-search');$(this).find('i').removeClass('fa-remove');$(this).find('i').css('color','#848484');}});}
validateForm('commentform');wordcount();loadCarouselWidget('videos-widget');loadCarouselWidget('slideshows-widget');$('.comment-reply-link').click(function()
{$replyTo=$(this).parent().siblings('.author');var replyTo="@"+(($replyTo.find('a').length!=0)?$replyTo.find('a').text():$replyTo.html())+": ";$commentArea=$('#commentform textarea');var commentAreaValue=$commentArea.val();var re=new RegExp(replyTo,'g');if(re.exec(commentAreaValue)==null)
$commentArea.val(replyTo+'\n'+commentAreaValue);$commentArea.focus();return false;})
$('.email-link').click(function()
{var width=480;var height=470;var left=(screen.width-width)/2;var top=(screen.height-height)/2;popupWindow=window.open($(this).attr('href'),"_blank","width="+width+",height="+height+",toolbar=0,menubar=0,location=0,resizable=0,scrollbars=1,status=0,left="+left+",top="+top+"");if(window.focus)popupWindow.focus()return false;});if($('#cfct-search').length>0)
{var $searchBox=$('#cse-search-box').find('.text');var searchBoxBg=$searchBox.css('background-image');$('#cfct-search').find('.text').css({'background-image':searchBoxBg,'background-repeat':'no-repeat','background-position':$searchBox.css('background-position')}).focus(function()
{$(this).css('background-image','none');}).blur(function()
{if($(this).val()=='')
$(this).css('background-image',searchBoxBg);});}});})(jQuery);function loadCarouselWidget(elementId)
{jQuery('#'+elementId+' .carousel').carousel({prevButtonSelector:'#'+elementId+' .prev',nextButtonSelector:'#'+elementId+' .next',pagination:false});jQuery('#'+elementId+' .controls').show();}
function validateForm(form)
{jQuery('#'+form).submit(function()
{var errorsCount=0;var $inputs=jQuery(this).find('input, textarea');$inputs.each(function()
{if((jQuery(this).hasClass('required')&&jQuery.trim(jQuery(this).val())=='')||(jQuery(this).hasClass('email')&&validateEmail(jQuery(this).val())===false))
{jQuery(this).addClass('error-field');if(errorsCount==0)jQuery(this).focus();errorsCount++;}
else if(jQuery(this).hasClass('error-field'))
jQuery(this).removeClass('error-field')});return(errorsCount==0)?true:false;});}
function wordcount()
{jQuery("[class^='count[']").each(function(){var elClass=jQuery(this).attr('class');var minWords=0;var maxWords=0;var countControl=elClass.substring((elClass.indexOf('['))+1,elClass.lastIndexOf(']')).split(',');if(countControl.length>1){minWords=countControl[0];maxWords=countControl[1];}else{maxWords=countControl[0];}
jQuery(this).before('<span class="wordCount"><strong>0</strong> Word(s)</span>');showWordCounter(this,minWords,maxWords);jQuery(this).bind('keyup click blur focus change paste',function()
{showWordCounter(this,minWords,maxWords);});});}
function showWordCounter(element,minWords,maxWords)
{var numWords=jQuery.trim(jQuery(element).val()).split(' ').length;if(jQuery(element).val()==='')
numWords=0;wordCount=jQuery(element).siblings('.wordCount');wordCount.children('strong').text(numWords);if(numWords<minWords||(numWords>maxWords&&maxWords!=0))
wordCount.addClass('err-label');else if(wordCount.hasClass('err-label'))
wordCount.removeClass('err-label');}
function validateEmail(email){var reg=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;return reg.test(email);}
(function($){$.friendlyTime=function(timestamp){};var $ft=$.friendlyTime;$.extend($.friendlyTime,{settings:{refreshMillis:60000,strings:{seconds:"less than a minute ago",minute:"a minute ago",minutes:"%d minutes ago",hour:"an hour ago",hours:"%d hours ago",day:"yesterday",days:"%d days ago",month:"about a month ago",months:"%d months ago",year:"about a year ago",years:"%d years",numbers:[]}},inWords:function(seconds){var $l=this.settings.strings;var minutes=seconds/60;var hours=minutes/60;var days=hours/24;var years=days/365;function substitute(string,number){return string.replace(/%d/i,(($l.numbers&&$l.numbers[number])||number));}
var words=seconds<45&&substitute($l.seconds,Math.round(seconds))||seconds<90&&substitute($l.minute,1)||minutes<45&&substitute($l.minutes,Math.round(minutes))||minutes<90&&substitute($l.hour,1)||hours<24&&substitute($l.hours,Math.round(hours))||hours<48&&substitute($l.day,1)||days<30&&substitute($l.days,Math.floor(days))||days<60&&substitute($l.month,1)||days<365&&substitute($l.months,Math.floor(days/30))||years<2&&substitute($l.year,1)||substitute($l.years,Math.floor(years));return $.trim(words);},parse:function(gmtdate){var s=$.trim(gmtdate);s=s.replace(/-/,"/").replace(/-/,"/");s=s.replace(/T/," ");s=s.replace(/([\+-]\d\d)\:?(\d\d)/," $1$2");return new Date(s);}});$.fn.friendlyTime=function(minutes){var self=this;self.each(function(){refresh(this,minutes);});var $s=$ft.settings;if($s.refreshMillis>0)setInterval(function(){self.each(function(){refresh(this,minutes);});},$s.refreshMillis);return self;};function refresh(obj,minutes){var date=$ft.parse($(obj).attr("title"));var difference_in_seconds=(new Date().getTime()-date.getTime())/1000;if(minutes*60>difference_in_seconds)$(obj).text($ft.inWords(difference_in_seconds));if($.trim($(obj).text())!='')$(obj).show();}})(jQuery);jQuery(document).ready(function(){jQuery(".elections2013.group .story span.timestamp").addClass("no-timeago");jQuery("#comments .timestamp").friendlyTime(23*60);jQuery(".story span.timestamp:not(.no-timeago)").friendlyTime(4*60);});
;(function($){"use strict";var version='2.1.6';$.fn.cycle=function(options){var o;if(this.length===0&&!$.isReady){o={s:this.selector,c:this.context};$.fn.cycle.log('requeuing slideshow (dom not ready)');$(function(){$(o.s,o.c).cycle(options);});return this;}
return this.each(function(){var data,opts,shortName,val;var container=$(this);var log=$.fn.cycle.log;if(container.data('cycle.opts'))
return;if(container.data('cycle-log')===false||(options&&options.log===false)||(opts&&opts.log===false)){log=$.noop;}
log('--c2 init--');data=container.data();for(var p in data){if(data.hasOwnProperty(p)&&/^cycle[A-Z]+/.test(p)){val=data[p];shortName=p.match(/^cycle(.*)/)[1].replace(/^[A-Z]/,lowerCase);log(shortName+':',val,'('+typeof val+')');data[shortName]=val;}}
opts=$.extend({},$.fn.cycle.defaults,data,options||{});opts.timeoutId=0;opts.paused=opts.paused||false;opts.container=container;opts._maxZ=opts.maxZ;opts.API=$.extend({_container:container},$.fn.cycle.API);opts.API.log=log;opts.API.trigger=function(eventName,args){opts.container.trigger(eventName,args);return opts.API;};container.data('cycle.opts',opts);container.data('cycle.API',opts.API);opts.API.trigger('cycle-bootstrap',[opts,opts.API]);opts.API.addInitialSlides();opts.API.preInitSlideshow();if(opts.slides.length)
opts.API.initSlideshow();});};$.fn.cycle.API={opts:function(){return this._container.data('cycle.opts');},addInitialSlides:function(){var opts=this.opts();var slides=opts.slides;opts.slideCount=0;opts.slides=$();slides=slides.jquery?slides:opts.container.find(slides);if(opts.random){slides.sort(function(){return Math.random()-0.5;});}
opts.API.add(slides);},preInitSlideshow:function(){var opts=this.opts();opts.API.trigger('cycle-pre-initialize',[opts]);var tx=$.fn.cycle.transitions[opts.fx];if(tx&&$.isFunction(tx.preInit))
tx.preInit(opts);opts._preInitialized=true;},postInitSlideshow:function(){var opts=this.opts();opts.API.trigger('cycle-post-initialize',[opts]);var tx=$.fn.cycle.transitions[opts.fx];if(tx&&$.isFunction(tx.postInit))
tx.postInit(opts);},initSlideshow:function(){var opts=this.opts();var pauseObj=opts.container;var slideOpts;opts.API.calcFirstSlide();if(opts.container.css('position')=='static')
opts.container.css('position','relative');$(opts.slides[opts.currSlide]).css({opacity:1,display:'block',visibility:'visible'});opts.API.stackSlides(opts.slides[opts.currSlide],opts.slides[opts.nextSlide],!opts.reverse);if(opts.pauseOnHover){if(opts.pauseOnHover!==true)
pauseObj=$(opts.pauseOnHover);pauseObj.hover(function(){opts.API.pause(true);},function(){opts.API.resume(true);});}
if(opts.timeout){slideOpts=opts.API.getSlideOpts(opts.currSlide);opts.API.queueTransition(slideOpts,slideOpts.timeout+opts.delay);}
opts._initialized=true;opts.API.updateView(true);opts.API.trigger('cycle-initialized',[opts]);opts.API.postInitSlideshow();},pause:function(hover){var opts=this.opts(),slideOpts=opts.API.getSlideOpts(),alreadyPaused=opts.hoverPaused||opts.paused;if(hover)
opts.hoverPaused=true;else
opts.paused=true;if(!alreadyPaused){opts.container.addClass('cycle-paused');opts.API.trigger('cycle-paused',[opts]).log('cycle-paused');if(slideOpts.timeout){clearTimeout(opts.timeoutId);opts.timeoutId=0;opts._remainingTimeout-=($.now()-opts._lastQueue);if(opts._remainingTimeout<0||isNaN(opts._remainingTimeout))
opts._remainingTimeout=undefined;}}},resume:function(hover){var opts=this.opts(),alreadyResumed=!opts.hoverPaused&&!opts.paused,remaining;if(hover)
opts.hoverPaused=false;else
opts.paused=false;if(!alreadyResumed){opts.container.removeClass('cycle-paused');if(opts.slides.filter(':animated').length===0)
opts.API.queueTransition(opts.API.getSlideOpts(),opts._remainingTimeout);opts.API.trigger('cycle-resumed',[opts,opts._remainingTimeout]).log('cycle-resumed');}},add:function(slides,prepend){var opts=this.opts();var oldSlideCount=opts.slideCount;var startSlideshow=false;var len;if($.type(slides)=='string')
slides=$.trim(slides);$(slides).each(function(i){var slideOpts;var slide=$(this);if(prepend)
opts.container.prepend(slide);else
opts.container.append(slide);opts.slideCount++;slideOpts=opts.API.buildSlideOpts(slide);if(prepend)
opts.slides=$(slide).add(opts.slides);else
opts.slides=opts.slides.add(slide);opts.API.initSlide(slideOpts,slide,--opts._maxZ);slide.data('cycle.opts',slideOpts);opts.API.trigger('cycle-slide-added',[opts,slideOpts,slide]);});opts.API.updateView(true);startSlideshow=opts._preInitialized&&(oldSlideCount<2&&opts.slideCount>=1);if(startSlideshow){if(!opts._initialized)
opts.API.initSlideshow();else if(opts.timeout){len=opts.slides.length;opts.nextSlide=opts.reverse?len-1:1;if(!opts.timeoutId){opts.API.queueTransition(opts);}}}},calcFirstSlide:function(){var opts=this.opts();var firstSlideIndex;firstSlideIndex=parseInt(opts.startingSlide||0,10);if(firstSlideIndex>=opts.slides.length||firstSlideIndex<0)
firstSlideIndex=0;opts.currSlide=firstSlideIndex;if(opts.reverse){opts.nextSlide=firstSlideIndex-1;if(opts.nextSlide<0)
opts.nextSlide=opts.slides.length-1;}
else{opts.nextSlide=firstSlideIndex+1;if(opts.nextSlide==opts.slides.length)
opts.nextSlide=0;}},calcNextSlide:function(){var opts=this.opts();var roll;if(opts.reverse){roll=(opts.nextSlide-1)<0;opts.nextSlide=roll?opts.slideCount-1:opts.nextSlide-1;opts.currSlide=roll?0:opts.nextSlide+1;}
else{roll=(opts.nextSlide+1)==opts.slides.length;opts.nextSlide=roll?0:opts.nextSlide+1;opts.currSlide=roll?opts.slides.length-1:opts.nextSlide-1;}},calcTx:function(slideOpts,manual){var opts=slideOpts;var tx;if(opts._tempFx)
tx=$.fn.cycle.transitions[opts._tempFx];else if(manual&&opts.manualFx)
tx=$.fn.cycle.transitions[opts.manualFx];if(!tx)
tx=$.fn.cycle.transitions[opts.fx];opts._tempFx=null;this.opts()._tempFx=null;if(!tx){tx=$.fn.cycle.transitions.fade;opts.API.log('Transition "'+opts.fx+'" not found.  Using fade.');}
return tx;},prepareTx:function(manual,fwd){var opts=this.opts();var after,curr,next,slideOpts,tx;if(opts.slideCount<2){opts.timeoutId=0;return;}
if(manual&&(!opts.busy||opts.manualTrump)){opts.API.stopTransition();opts.busy=false;clearTimeout(opts.timeoutId);opts.timeoutId=0;}
if(opts.busy)
return;if(opts.timeoutId===0&&!manual)
return;curr=opts.slides[opts.currSlide];next=opts.slides[opts.nextSlide];slideOpts=opts.API.getSlideOpts(opts.nextSlide);tx=opts.API.calcTx(slideOpts,manual);opts._tx=tx;if(manual&&slideOpts.manualSpeed!==undefined)
slideOpts.speed=slideOpts.manualSpeed;if(opts.nextSlide!=opts.currSlide&&(manual||(!opts.paused&&!opts.hoverPaused&&opts.timeout))){opts.API.trigger('cycle-before',[slideOpts,curr,next,fwd]);if(tx.before)
tx.before(slideOpts,curr,next,fwd);after=function(){opts.busy=false;if(!opts.container.data('cycle.opts'))
return;if(tx.after)
tx.after(slideOpts,curr,next,fwd);opts.API.trigger('cycle-after',[slideOpts,curr,next,fwd]);opts.API.queueTransition(slideOpts);opts.API.updateView(true);};opts.busy=true;if(tx.transition)
tx.transition(slideOpts,curr,next,fwd,after);else
opts.API.doTransition(slideOpts,curr,next,fwd,after);opts.API.calcNextSlide();opts.API.updateView();}else{opts.API.queueTransition(slideOpts);}},doTransition:function(slideOpts,currEl,nextEl,fwd,callback){var opts=slideOpts;var curr=$(currEl),next=$(nextEl);var fn=function(){next.animate(opts.animIn||{opacity:1},opts.speed,opts.easeIn||opts.easing,callback);};next.css(opts.cssBefore||{});curr.animate(opts.animOut||{},opts.speed,opts.easeOut||opts.easing,function(){curr.css(opts.cssAfter||{});if(!opts.sync){fn();}});if(opts.sync){fn();}},queueTransition:function(slideOpts,specificTimeout){var opts=this.opts();var timeout=specificTimeout!==undefined?specificTimeout:slideOpts.timeout;if(opts.nextSlide===0&&--opts.loop===0){opts.API.log('terminating; loop=0');opts.timeout=0;if(timeout){setTimeout(function(){opts.API.trigger('cycle-finished',[opts]);},timeout);}
else{opts.API.trigger('cycle-finished',[opts]);}
opts.nextSlide=opts.currSlide;return;}
if(opts.continueAuto!==undefined){if(opts.continueAuto===false||($.isFunction(opts.continueAuto)&&opts.continueAuto()===false)){opts.API.log('terminating automatic transitions');opts.timeout=0;if(opts.timeoutId)
clearTimeout(opts.timeoutId);return;}}
if(timeout){opts._lastQueue=$.now();if(specificTimeout===undefined)
opts._remainingTimeout=slideOpts.timeout;if(!opts.paused&&!opts.hoverPaused){opts.timeoutId=setTimeout(function(){opts.API.prepareTx(false,!opts.reverse);},timeout);}}},stopTransition:function(){var opts=this.opts();if(opts.slides.filter(':animated').length){opts.slides.stop(false,true);opts.API.trigger('cycle-transition-stopped',[opts]);}
if(opts._tx&&opts._tx.stopTransition)
opts._tx.stopTransition(opts);},advanceSlide:function(val){var opts=this.opts();clearTimeout(opts.timeoutId);opts.timeoutId=0;opts.nextSlide=opts.currSlide+val;if(opts.nextSlide<0)
opts.nextSlide=opts.slides.length-1;else if(opts.nextSlide>=opts.slides.length)
opts.nextSlide=0;opts.API.prepareTx(true,val>=0);return false;},buildSlideOpts:function(slide){var opts=this.opts();var val,shortName;var slideOpts=slide.data()||{};for(var p in slideOpts){if(slideOpts.hasOwnProperty(p)&&/^cycle[A-Z]+/.test(p)){val=slideOpts[p];shortName=p.match(/^cycle(.*)/)[1].replace(/^[A-Z]/,lowerCase);opts.API.log('['+(opts.slideCount-1)+']',shortName+':',val,'('+typeof val+')');slideOpts[shortName]=val;}}
slideOpts=$.extend({},$.fn.cycle.defaults,opts,slideOpts);slideOpts.slideNum=opts.slideCount;try{delete slideOpts.API;delete slideOpts.slideCount;delete slideOpts.currSlide;delete slideOpts.nextSlide;delete slideOpts.slides;}catch(e){}
return slideOpts;},getSlideOpts:function(index){var opts=this.opts();if(index===undefined)
index=opts.currSlide;var slide=opts.slides[index];var slideOpts=$(slide).data('cycle.opts');return $.extend({},opts,slideOpts);},initSlide:function(slideOpts,slide,suggestedZindex){var opts=this.opts();slide.css(slideOpts.slideCss||{});if(suggestedZindex>0)
slide.css('zIndex',suggestedZindex);if(isNaN(slideOpts.speed))
slideOpts.speed=$.fx.speeds[slideOpts.speed]||$.fx.speeds._default;if(!slideOpts.sync)
slideOpts.speed=slideOpts.speed/2;slide.addClass(opts.slideClass);},updateView:function(isAfter,isDuring,forceEvent){var opts=this.opts();if(!opts._initialized)
return;var slideOpts=opts.API.getSlideOpts();var currSlide=opts.slides[opts.currSlide];if(!isAfter&&isDuring!==true){opts.API.trigger('cycle-update-view-before',[opts,slideOpts,currSlide]);if(opts.updateView<0)
return;}
if(opts.slideActiveClass){opts.slides.removeClass(opts.slideActiveClass).eq(opts.currSlide).addClass(opts.slideActiveClass);}
if(isAfter&&opts.hideNonActive)
opts.slides.filter(':not(.'+opts.slideActiveClass+')').css('visibility','hidden');if(opts.updateView===0){setTimeout(function(){opts.API.trigger('cycle-update-view',[opts,slideOpts,currSlide,isAfter]);},slideOpts.speed/(opts.sync?2:1));}
if(opts.updateView!==0)
opts.API.trigger('cycle-update-view',[opts,slideOpts,currSlide,isAfter]);if(isAfter)
opts.API.trigger('cycle-update-view-after',[opts,slideOpts,currSlide]);},getComponent:function(name){var opts=this.opts();var selector=opts[name];if(typeof selector==='string'){return(/^\s*[\>|\+|~]/).test(selector)?opts.container.find(selector):$(selector);}
if(selector.jquery)
return selector;return $(selector);},stackSlides:function(curr,next,fwd){var opts=this.opts();if(!curr){curr=opts.slides[opts.currSlide];next=opts.slides[opts.nextSlide];fwd=!opts.reverse;}
$(curr).css('zIndex',opts.maxZ);var i;var z=opts.maxZ-2;var len=opts.slideCount;if(fwd){for(i=opts.currSlide+1;i<len;i++)
$(opts.slides[i]).css('zIndex',z--);for(i=0;i<opts.currSlide;i++)
$(opts.slides[i]).css('zIndex',z--);}
else{for(i=opts.currSlide-1;i>=0;i--)
$(opts.slides[i]).css('zIndex',z--);for(i=len-1;i>opts.currSlide;i--)
$(opts.slides[i]).css('zIndex',z--);}
$(next).css('zIndex',opts.maxZ-1);},getSlideIndex:function(el){return this.opts().slides.index(el);}};$.fn.cycle.log=function log(){if(window.console&&console.log)
console.log('[cycle2] '+Array.prototype.join.call(arguments,' '));};$.fn.cycle.version=function(){return'Cycle2: '+version;};function lowerCase(s){return(s||'').toLowerCase();}
$.fn.cycle.transitions={custom:{},none:{before:function(opts,curr,next,fwd){opts.API.stackSlides(next,curr,fwd);opts.cssBefore={opacity:1,visibility:'visible',display:'block'};}},fade:{before:function(opts,curr,next,fwd){var css=opts.API.getSlideOpts(opts.nextSlide).slideCss||{};opts.API.stackSlides(curr,next,fwd);opts.cssBefore=$.extend(css,{opacity:0,visibility:'visible',display:'block'});opts.animIn={opacity:1};opts.animOut={opacity:0};}},fadeout:{before:function(opts,curr,next,fwd){var css=opts.API.getSlideOpts(opts.nextSlide).slideCss||{};opts.API.stackSlides(curr,next,fwd);opts.cssBefore=$.extend(css,{opacity:1,visibility:'visible',display:'block'});opts.animOut={opacity:0};}},scrollHorz:{before:function(opts,curr,next,fwd){opts.API.stackSlides(curr,next,fwd);var w=opts.container.css('overflow','hidden').width();opts.cssBefore={left:fwd?w:-w,top:0,opacity:1,visibility:'visible',display:'block'};opts.cssAfter={zIndex:opts._maxZ-2,left:0};opts.animIn={left:0};opts.animOut={left:fwd?-w:w};}}};$.fn.cycle.defaults={allowWrap:true,autoSelector:'.cycle-slideshow[data-cycle-auto-init!=false]',delay:0,easing:null,fx:'fade',hideNonActive:true,loop:0,manualFx:undefined,manualSpeed:undefined,manualTrump:true,maxZ:100,pauseOnHover:false,reverse:false,slideActiveClass:'cycle-slide-active',slideClass:'cycle-slide',slideCss:{position:'absolute',top:0,left:0},slides:'> img',speed:500,startingSlide:0,sync:true,timeout:4000,updateView:0};$(document).ready(function(){$($.fn.cycle.defaults.autoSelector).cycle();});})(jQuery);(function($){"use strict";$.extend($.fn.cycle.defaults,{autoHeight:0,autoHeightSpeed:250,autoHeightEasing:null});$(document).on('cycle-initialized',function(e,opts){var autoHeight=opts.autoHeight;var t=$.type(autoHeight);var resizeThrottle=null;var ratio;if(t!=='string'&&t!=='number')
return;opts.container.on('cycle-slide-added cycle-slide-removed',initAutoHeight);opts.container.on('cycle-destroyed',onDestroy);if(autoHeight=='container'){opts.container.on('cycle-before',onBefore);}
else if(t==='string'&&/\d+\:\d+/.test(autoHeight)){ratio=autoHeight.match(/(\d+)\:(\d+)/);ratio=ratio[1]/ratio[2];opts._autoHeightRatio=ratio;}
if(t!=='number'){opts._autoHeightOnResize=function(){clearTimeout(resizeThrottle);resizeThrottle=setTimeout(onResize,50);};$(window).on('resize orientationchange',opts._autoHeightOnResize);}
setTimeout(onResize,30);function onResize(){initAutoHeight(e,opts);}});function initAutoHeight(e,opts){var clone,height,sentinelIndex;var autoHeight=opts.autoHeight;if(autoHeight=='container'){height=$(opts.slides[opts.currSlide]).outerHeight();opts.container.height(height);}
else if(opts._autoHeightRatio){opts.container.height(opts.container.width()/opts._autoHeightRatio);}else if(autoHeight==='calc'||($.type(autoHeight)=='number'&&autoHeight>=0)){if(autoHeight==='calc')
sentinelIndex=calcSentinelIndex(e,opts);else if(autoHeight>=opts.slides.length)
sentinelIndex=0;else
sentinelIndex=autoHeight;if(sentinelIndex==opts._sentinelIndex)
return;opts._sentinelIndex=sentinelIndex;if(opts._sentinel)
opts._sentinel.remove();clone=$(opts.slides[sentinelIndex].cloneNode(true));clone.removeAttr('id name rel').find('[id],[name],[rel]').removeAttr('id name rel');clone.css({position:'static',visibility:'hidden',display:'block'}).prependTo(opts.container).addClass('cycle-sentinel cycle-slide').removeClass('cycle-slide-active');clone.find('*').css('visibility','hidden');opts._sentinel=clone;}}
function calcSentinelIndex(e,opts){var index=0,max=-1;opts.slides.each(function(i){var h=$(this).height();if(h>max){max=h;index=i;}});return index;}
function onBefore(e,opts,outgoing,incoming,forward){var h=$(incoming).outerHeight();opts.container.animate({height:h},opts.autoHeightSpeed,opts.autoHeightEasing);}
function onDestroy(e,opts){if(opts._autoHeightOnResize){$(window).off('resize orientationchange',opts._autoHeightOnResize);opts._autoHeightOnResize=null;}
opts.container.off('cycle-slide-added cycle-slide-removed',initAutoHeight);opts.container.off('cycle-destroyed',onDestroy);opts.container.off('cycle-before',onBefore);if(opts._sentinel){opts._sentinel.remove();opts._sentinel=null;}}})(jQuery);(function($){"use strict";$.extend($.fn.cycle.defaults,{caption:'> .cycle-caption',captionTemplate:'{{slideNum}} / {{slideCount}}',overlay:'> .cycle-overlay',overlayTemplate:'<div>{{title}}</div><div>{{desc}}</div>',captionModule:'caption'});$(document).on('cycle-update-view',function(e,opts,slideOpts,currSlide){if(opts.captionModule!=='caption')
return;var el;$.each(['caption','overlay'],function(){var name=this;var template=slideOpts[name+'Template'];var el=opts.API.getComponent(name);if(el.length&&template){el.html(opts.API.tmpl(template,slideOpts,opts,currSlide));el.show();}
else{el.hide();}});});$(document).on('cycle-destroyed',function(e,opts){var el;$.each(['caption','overlay'],function(){var name=this,template=opts[name+'Template'];if(opts[name]&&template){el=opts.API.getComponent('caption');el.empty();}});});})(jQuery);(function($){"use strict";var c2=$.fn.cycle;$.fn.cycle=function(options){var cmd,cmdFn,opts;var args=$.makeArray(arguments);if($.type(options)=='number'){return this.cycle('goto',options);}
if($.type(options)=='string'){return this.each(function(){var cmdArgs;cmd=options;opts=$(this).data('cycle.opts');if(opts===undefined){c2.log('slideshow must be initialized before sending commands; "'+cmd+'" ignored');return;}
else{cmd=cmd=='goto'?'jump':cmd;cmdFn=opts.API[cmd];if($.isFunction(cmdFn)){cmdArgs=$.makeArray(args);cmdArgs.shift();return cmdFn.apply(opts.API,cmdArgs);}
else{c2.log('unknown command: ',cmd);}}});}
else{return c2.apply(this,arguments);}};$.extend($.fn.cycle,c2);$.extend(c2.API,{next:function(){var opts=this.opts();if(opts.busy&&!opts.manualTrump)
return;var count=opts.reverse?-1:1;if(opts.allowWrap===false&&(opts.currSlide+count)>=opts.slideCount)
return;opts.API.advanceSlide(count);opts.API.trigger('cycle-next',[opts]).log('cycle-next');},prev:function(){var opts=this.opts();if(opts.busy&&!opts.manualTrump)
return;var count=opts.reverse?1:-1;if(opts.allowWrap===false&&(opts.currSlide+count)<0)
return;opts.API.advanceSlide(count);opts.API.trigger('cycle-prev',[opts]).log('cycle-prev');},destroy:function(){this.stop();var opts=this.opts();var clean=$.isFunction($._data)?$._data:$.noop;clearTimeout(opts.timeoutId);opts.timeoutId=0;opts.API.stop();opts.API.trigger('cycle-destroyed',[opts]).log('cycle-destroyed');opts.container.removeData();clean(opts.container[0],'parsedAttrs',false);if(!opts.retainStylesOnDestroy){opts.container.removeAttr('style');opts.slides.removeAttr('style');opts.slides.removeClass(opts.slideActiveClass);}
opts.slides.each(function(){var slide=$(this);slide.removeData();slide.removeClass(opts.slideClass);clean(this,'parsedAttrs',false);});},jump:function(index,fx){var fwd;var opts=this.opts();if(opts.busy&&!opts.manualTrump)
return;var num=parseInt(index,10);if(isNaN(num)||num<0||num>=opts.slides.length){opts.API.log('goto: invalid slide index: '+num);return;}
if(num==opts.currSlide){opts.API.log('goto: skipping, already on slide',num);return;}
opts.nextSlide=num;clearTimeout(opts.timeoutId);opts.timeoutId=0;opts.API.log('goto: ',num,' (zero-index)');fwd=opts.currSlide<opts.nextSlide;opts._tempFx=fx;opts.API.prepareTx(true,fwd);},stop:function(){var opts=this.opts();var pauseObj=opts.container;clearTimeout(opts.timeoutId);opts.timeoutId=0;opts.API.stopTransition();if(opts.pauseOnHover){if(opts.pauseOnHover!==true)
pauseObj=$(opts.pauseOnHover);pauseObj.off('mouseenter mouseleave');}
opts.API.trigger('cycle-stopped',[opts]).log('cycle-stopped');},reinit:function(){var opts=this.opts();opts.API.destroy();opts.container.cycle();},remove:function(index){var opts=this.opts();var slide,slideToRemove,slides=[],slideNum=1;for(var i=0;i<opts.slides.length;i++){slide=opts.slides[i];if(i==index){slideToRemove=slide;}
else{slides.push(slide);$(slide).data('cycle.opts').slideNum=slideNum;slideNum++;}}
if(slideToRemove){opts.slides=$(slides);opts.slideCount--;$(slideToRemove).remove();if(index==opts.currSlide)
opts.API.advanceSlide(1);else if(index<opts.currSlide)
opts.currSlide--;else
opts.currSlide++;opts.API.trigger('cycle-slide-removed',[opts,index,slideToRemove]).log('cycle-slide-removed');opts.API.updateView();}}});$(document).on('click.cycle','[data-cycle-cmd]',function(e){e.preventDefault();var el=$(this);var command=el.data('cycle-cmd');var context=el.data('cycle-context')||'.cycle-slideshow';$(context).cycle(command,el.data('cycle-arg'));});})(jQuery);(function($){"use strict";$(document).on('cycle-pre-initialize',function(e,opts){onHashChange(opts,true);opts._onHashChange=function(){onHashChange(opts,false);};$(window).on('hashchange',opts._onHashChange);});$(document).on('cycle-update-view',function(e,opts,slideOpts){if(slideOpts.hash&&('#'+slideOpts.hash)!=window.location.hash){opts._hashFence=true;window.location.hash=slideOpts.hash;}});$(document).on('cycle-destroyed',function(e,opts){if(opts._onHashChange){$(window).off('hashchange',opts._onHashChange);}});function onHashChange(opts,setStartingSlide){var hash;if(opts._hashFence){opts._hashFence=false;return;}
hash=window.location.hash.substring(1);opts.slides.each(function(i){if($(this).data('cycle-hash')==hash){if(setStartingSlide===true){opts.startingSlide=i;}
else{var fwd=opts.currSlide<i;opts.nextSlide=i;opts.API.prepareTx(true,fwd);}
return false;}});}})(jQuery);(function($){"use strict";$.extend($.fn.cycle.defaults,{loader:false});$(document).on('cycle-bootstrap',function(e,opts){var addFn;if(!opts.loader)
return;addFn=opts.API.add;opts.API.add=add;function add(slides,prepend){var slideArr=[];if($.type(slides)=='string')
slides=$.trim(slides);else if($.type(slides)==='array'){for(var i=0;i<slides.length;i++)
slides[i]=$(slides[i])[0];}
slides=$(slides);var slideCount=slides.length;if(!slideCount)
return;slides.css('visibility','hidden').appendTo('body').each(function(i){var count=0;var slide=$(this);var images=slide.is('img')?slide:slide.find('img');slide.data('index',i);images=images.filter(':not(.cycle-loader-ignore)').filter(':not([src=""])');if(!images.length){--slideCount;slideArr.push(slide);return;}
count=images.length;images.each(function(){if(this.complete){imageLoaded();}
else{$(this).load(function(){imageLoaded();}).on("error",function(){if(--count===0){opts.API.log('slide skipped; img not loaded:',this.src);if(--slideCount===0&&opts.loader=='wait'){addFn.apply(opts.API,[slideArr,prepend]);}}});}});function imageLoaded(){if(--count===0){--slideCount;addSlide(slide);}}});if(slideCount)
opts.container.addClass('cycle-loading');function addSlide(slide){var curr;if(opts.loader=='wait'){slideArr.push(slide);if(slideCount===0){slideArr.sort(sorter);addFn.apply(opts.API,[slideArr,prepend]);opts.container.removeClass('cycle-loading');}}
else{curr=$(opts.slides[opts.currSlide]);addFn.apply(opts.API,[slide,prepend]);curr.show();opts.container.removeClass('cycle-loading');}}
function sorter(a,b){return a.data('index')-b.data('index');}}});})(jQuery);(function($){"use strict";$.extend($.fn.cycle.defaults,{pager:'> .cycle-pager',pagerActiveClass:'cycle-pager-active',pagerEvent:'click.cycle',pagerEventBubble:undefined,pagerTemplate:'<span>&bull;</span>'});$(document).on('cycle-bootstrap',function(e,opts,API){API.buildPagerLink=buildPagerLink;});$(document).on('cycle-slide-added',function(e,opts,slideOpts,slideAdded){if(opts.pager){opts.API.buildPagerLink(opts,slideOpts,slideAdded);opts.API.page=page;}});$(document).on('cycle-slide-removed',function(e,opts,index,slideRemoved){if(opts.pager){var pagers=opts.API.getComponent('pager');pagers.each(function(){var pager=$(this);$(pager.children()[index]).remove();});}});$(document).on('cycle-update-view',function(e,opts,slideOpts){var pagers;if(opts.pager){pagers=opts.API.getComponent('pager');pagers.each(function(){$(this).children().removeClass(opts.pagerActiveClass).eq(opts.currSlide).addClass(opts.pagerActiveClass);});}});$(document).on('cycle-destroyed',function(e,opts){var pager=opts.API.getComponent('pager');if(pager){pager.children().off(opts.pagerEvent);if(opts.pagerTemplate)
pager.empty();}});function buildPagerLink(opts,slideOpts,slide){var pagerLink;var pagers=opts.API.getComponent('pager');pagers.each(function(){var pager=$(this);if(slideOpts.pagerTemplate){var markup=opts.API.tmpl(slideOpts.pagerTemplate,slideOpts,opts,slide[0]);pagerLink=$(markup).appendTo(pager);}
else{pagerLink=pager.children().eq(opts.slideCount-1);}
pagerLink.on(opts.pagerEvent,function(e){if(!opts.pagerEventBubble)
e.preventDefault();opts.API.page(pager,e.currentTarget);});});}
function page(pager,target){var opts=this.opts();if(opts.busy&&!opts.manualTrump)
return;var index=pager.children().index(target);var nextSlide=index;var fwd=opts.currSlide<nextSlide;if(opts.currSlide==nextSlide){return;}
opts.nextSlide=nextSlide;opts._tempFx=opts.pagerFx;opts.API.prepareTx(true,fwd);opts.API.trigger('cycle-pager-activated',[opts,pager,target]);}})(jQuery);(function($){"use strict";$.extend($.fn.cycle.defaults,{next:'> .cycle-next',nextEvent:'click.cycle',disabledClass:'disabled',prev:'> .cycle-prev',prevEvent:'click.cycle',swipe:false});$(document).on('cycle-initialized',function(e,opts){opts.API.getComponent('next').on(opts.nextEvent,function(e){e.preventDefault();opts.API.next();});opts.API.getComponent('prev').on(opts.prevEvent,function(e){e.preventDefault();opts.API.prev();});if(opts.swipe){var nextEvent=opts.swipeVert?'swipeUp.cycle':'swipeLeft.cycle swipeleft.cycle';var prevEvent=opts.swipeVert?'swipeDown.cycle':'swipeRight.cycle swiperight.cycle';opts.container.on(nextEvent,function(e){opts._tempFx=opts.swipeFx;opts.API.next();});opts.container.on(prevEvent,function(){opts._tempFx=opts.swipeFx;opts.API.prev();});}});$(document).on('cycle-update-view',function(e,opts,slideOpts,currSlide){if(opts.allowWrap)
return;var cls=opts.disabledClass;var next=opts.API.getComponent('next');var prev=opts.API.getComponent('prev');var prevBoundry=opts._prevBoundry||0;var nextBoundry=(opts._nextBoundry!==undefined)?opts._nextBoundry:opts.slideCount-1;if(opts.currSlide==nextBoundry)
next.addClass(cls).prop('disabled',true);else
next.removeClass(cls).prop('disabled',false);if(opts.currSlide===prevBoundry)
prev.addClass(cls).prop('disabled',true);else
prev.removeClass(cls).prop('disabled',false);});$(document).on('cycle-destroyed',function(e,opts){opts.API.getComponent('prev').off(opts.nextEvent);opts.API.getComponent('next').off(opts.prevEvent);opts.container.off('swipeleft.cycle swiperight.cycle swipeLeft.cycle swipeRight.cycle swipeUp.cycle swipeDown.cycle');});})(jQuery);(function($){"use strict";$.extend($.fn.cycle.defaults,{progressive:false});$(document).on('cycle-pre-initialize',function(e,opts){if(!opts.progressive)
return;var API=opts.API;var nextFn=API.next;var prevFn=API.prev;var prepareTxFn=API.prepareTx;var type=$.type(opts.progressive);var slides,scriptEl;if(type=='array'){slides=opts.progressive;}
else if($.isFunction(opts.progressive)){slides=opts.progressive(opts);}
else if(type=='string'){scriptEl=$(opts.progressive);slides=$.trim(scriptEl.html());if(!slides)
return;if(/^(\[)/.test(slides)){try{slides=$.parseJSON(slides);}
catch(err){API.log('error parsing progressive slides',err);return;}}
else{slides=slides.split(new RegExp(scriptEl.data('cycle-split')||'\n'));if(!slides[slides.length-1])
slides.pop();}}
if(prepareTxFn){API.prepareTx=function(manual,fwd){var index,slide;if(manual||slides.length===0){prepareTxFn.apply(opts.API,[manual,fwd]);return;}
if(fwd&&opts.currSlide==(opts.slideCount-1)){slide=slides[0];slides=slides.slice(1);opts.container.one('cycle-slide-added',function(e,opts){setTimeout(function(){opts.API.advanceSlide(1);},50);});opts.API.add(slide);}
else if(!fwd&&opts.currSlide===0){index=slides.length-1;slide=slides[index];slides=slides.slice(0,index);opts.container.one('cycle-slide-added',function(e,opts){setTimeout(function(){opts.currSlide=1;opts.API.advanceSlide(-1);},50);});opts.API.add(slide,true);}
else{prepareTxFn.apply(opts.API,[manual,fwd]);}};}
if(nextFn){API.next=function(){var opts=this.opts();if(slides.length&&opts.currSlide==(opts.slideCount-1)){var slide=slides[0];slides=slides.slice(1);opts.container.one('cycle-slide-added',function(e,opts){nextFn.apply(opts.API);opts.container.removeClass('cycle-loading');});opts.container.addClass('cycle-loading');opts.API.add(slide);}
else{nextFn.apply(opts.API);}};}
if(prevFn){API.prev=function(){var opts=this.opts();if(slides.length&&opts.currSlide===0){var index=slides.length-1;var slide=slides[index];slides=slides.slice(0,index);opts.container.one('cycle-slide-added',function(e,opts){opts.currSlide=1;opts.API.advanceSlide(-1);opts.container.removeClass('cycle-loading');});opts.container.addClass('cycle-loading');opts.API.add(slide,true);}
else{prevFn.apply(opts.API);}};}});})(jQuery);(function($){"use strict";$.extend($.fn.cycle.defaults,{tmplRegex:'{{((.)?.*?)}}'});$.extend($.fn.cycle.API,{tmpl:function(str,opts){var regex=new RegExp(opts.tmplRegex||$.fn.cycle.defaults.tmplRegex,'g');var args=$.makeArray(arguments);args.shift();return str.replace(regex,function(_,str){var i,j,obj,prop,names=str.split('.');for(i=0;i<args.length;i++){obj=args[i];if(!obj)
continue;if(names.length>1){prop=obj;for(j=0;j<names.length;j++){obj=prop;prop=prop[names[j]]||str;}}else{prop=obj[str];}
if($.isFunction(prop))
return prop.apply(obj,args);if(prop!==undefined&&prop!==null&&prop!=str)
return prop;}
return str;});}});})(jQuery);var $allVideos=jQuery("iframe[src^='//www.dailymotion.com'], iframe[src^='//player.vimeo.com']"),$fluidEl=jQuery("body");$allVideos.each(function(){jQuery(this).data('aspectRatio',this.height/this.width).removeAttr('height').removeAttr('width');});jQuery(window).resize(function(){var newWidth=$fluidEl.width();$allVideos.each(function(){var $el=jQuery(this);$el.width(newWidth).height(newWidth*$el.data('aspectRatio'));});}).resize();jQuery('#id-1079195 a').click(function(){window.open('http://labs.tribune.com.pk/ground-nine-zero/','_blank');return false;});(function($,window,document,undefined){var pluginName="rad",defaults={allowBiggerSizing:"false",maxWidth:null};function Plugin(element,options){this.element=element;Plugin._index=(Plugin._index||0)+1;this.uid=Plugin._index;this.options=$.extend({},defaults,options);this._defaults=defaults;this._name=pluginName;var self=this;self.init();self.setScale();self.__setScale=$.proxy(self.setScale,self);$(window).on("resize.rad."+this.uid+"orientationchange.rad."+this.uid,self.__setScale)}Plugin.prototype.init=function(){this.id=this.element.id;var $elem=$(this.element);this.adWidth=$elem.width();this.adHeight=$elem.height();$elem.closest('div[class^="radWrapper"]').css({position:"relative",width:this.adWidth+"px",height:this.adHeight+"px",maxWidth:"100%"});this.adParent=$elem.closest('div[class^="radWrapper"]').parent();if(this.options.maxWidth)this.options.maxWidth=parseFloat(this.options.maxWidth);$elem.css({"-webkit-transform-origin":"0 0","-moz-transform-origin":"0 0","-ms-transform-origin":"0 0","-o-transform-origin":"0 0","transform-origin":"0 0","position":"absolute"})};Plugin.prototype.destroy=function(){$(window).off("resize.rad."+this.uid+"orientationchange.rad."+this.uid,self.__setScale);this.adParent=null;this.element=null};Plugin.prototype.setScale=function(pWidth,adWidth){$elem=$(this.element);var pWidth=this.adParent.width();pWidth-=parseInt(this.adParent.parent().css("marginLeft").replace("px",""))+parseInt(this.adParent.parent().css("marginRight").replace("px",""));if(this.options.maxWidth)if(pWidth>this.options.maxWidth)return false;if(pWidth<this.adWidth||this.options.allowBiggerSizing==="true"){var newScale=pWidth/this.adWidth-0.001;var newHeight=pWidth*this.adHeight/this.adWidth;var newWidth=this.adWidth*newHeight/this.adHeight;$elem.closest('div[class^="radWrapper"]').css({"height":newHeight+"px","width":newWidth+"px"});$elem.css({"-moz-transform":"scale("+newScale+")","-webkit-transform":"scale("+newScale+")","-o-transform":"scale("+newScale+")","-ms-transform":"scale("+newScale+")","transform":"scale("+
newScale+")"})}};$.fn[pluginName]=function(options){return this.each(function(){if(!$.data(this,"plugin_"+pluginName))$.data(this,"plugin_"+pluginName,new Plugin(this,options))})}})(jQuery,window,document);(function($)
{$(document).ready(function(){var target_image=$('.story-image img');var target_caption=$('.story-image .caption');image_click=function($selected_image)
{var source=$($selected_image);var large_src=source.attr('longdesc');target_image.fadeTo('medium',0.5);var img=new Image();img.onload=function()
{target_image.fadeTo('fast',1,function()
{target_image.attr({src:large_src,width:source.attr('largewidth'),height:source.attr('largeheight')});});};img.src=large_src;target_caption.text(source.attr('alt'));return false;};$('.story-carousel').carousel({callback:image_click});CommentOperations.init();});var CommentOperations=function()
{var comments_shown=50;var comments_selector='#comments ul.commentlist li';var more_comments_selector='#comments .more-comments';var init=function()
{$(comments_selector+':gt('+(comments_shown-1)+')').addClass('hide-comment');var $comments=$(comments_selector);if($comments.length>comments_shown)$(more_comments_selector).show();$('#comments .more-comments').click(more_comments);$('#comments .ul-tabs li a').click(most_recommended_comments);};var more_comments=function(e)
{e.preventDefault();var $more_link=$(this);var $pagination_div=$('#comments .comment-pagination');var $hidden_comments=$(comments_selector+'.hide-comment:lt('+comments_shown+')');$hidden_comments.removeClass('hide-comment');if($(comments_selector+'.hide-comment').length==0)
{$more_link.hide();$pagination_div.show();}};var most_recommended_comments=function(e)
{e.preventDefault();var $tab=$(e.target);if(!$tab.hasClass('current'))
{var $comments_li=$(comments_selector);var $li_parent=$comments_li.parent();$li_parent.fadeOut(250,function(){if($comments_li.length>1)
{var sort_method;if($tab.hasClass('recommended-comments'))
{sort_method=sort_comments_likes;}
else if($tab.hasClass('all-comments'))
{sort_method=sort_comments_ids;}
$comments_li.sort(sort_method);$comments_li.appendTo($li_parent);$comments_li.filter(':lt('+comments_shown+')').removeClass('hide-comment');$comments_li.filter(':gt('+comments_shown+')').addClass('hide-comment');if($comments_li.length>comments_shown)$(more_comments_selector).show();}
$tab.parent().siblings('li').children('a').removeClass('current');$tab.addClass('current');$li_parent.fadeIn(250);});}};var sort_comments_likes=function(a,b)
{var likes_selector='.comments-like span';var $a=$(a);var $b=$(b);var a_likes=($a.find(likes_selector).length!=0)?parseInt($a.find(likes_selector).text()):0;var b_likes=($b.find(likes_selector).length!=0)?parseInt($b.find(likes_selector).text()):0;return(a_likes<b_likes)?1:(a_likes>b_likes)?-1:0;};var sort_comments_ids=function(a,b)
{var a_id=$(a).attr('id').match(/.*li-comment-([0-9]+).*/)[1];var b_id=$(b).attr('id').match(/.*li-comment-([0-9]+).*/)[1];return(a_id<b_id)?-1:(a_id>b_id)?1:0;};return{init:init};}();var $adjacent=document.getElementById('adjacent');if($adjacent!=null)
{var slideRightStyle=$adjacent.style.right;$(window).scroll(function()
{var canvasHeight=document.documentElement.clientHeight;var currWinScrollTop=$(window).scrollTop();var storyHeight=$('.story-content').height()+$('.story-content').offset().top;$adjacent.style.right=(currWinScrollTop>=storyHeight-canvasHeight)?0:slideRightStyle;});}})(jQuery);(function($){function get_class_list(elem){if(elem.classList){return elem.classList;}else{return $(elem).attr('class').match(/\S+/gi);}}
$.fn.ShareLink=function(options){var defaults={title:'',text:'',image:'',url:window.location.href,class_prefix:'s_'};var options=$.extend({},defaults,options);var class_prefix_length=options.class_prefix.length;var templates={twitter:'https://twitter.com/intent/tweet?url={url}&text={title}',facebook:'https://www.facebook.com/sharer.php?u={url}'}
function link(network){var url=templates[network];url=url.replace('{url}',encodeURIComponent(options.url));url=url.replace('{title}',encodeURIComponent(options.title));url=url.replace('{text}',encodeURIComponent(options.text));url=url.replace('{image}',encodeURIComponent(options.image));return url;}
this.each(function(i,elem){var classlist=get_class_list(elem);for(var i=0;i<classlist.length;i++){var cls=classlist[i];if(cls.substr(0,class_prefix_length)==options.class_prefix&&templates[cls.substr(class_prefix_length)]){var final_link=link(cls.substr(class_prefix_length));$(elem).attr('href',final_link).click(function(){var screen_width=screen.width;var screen_height=screen.height;var popup_width=options.width?options.width:(screen_width-(screen_width*0.2));var popup_height=options.height?options.height:(screen_height-(screen_height*0.2));var left=(screen_width/2)-(popup_width/2);var top=(screen_height/2)-(popup_height/2);var parameters='toolbar=0,status=0,width=550,height=350,top='+top+',left='+left;return window.open($(this).attr('href'),'',parameters)&&false;});}}});}
$.fn.ShareCounter=function(options){var defaults={url:window.location.href,class_prefix:'to',display_counter_from:0};var options=$.extend({},defaults,options);var class_prefix_length=options.class_prefix.length
var social={'twitter':twitter,'facebook':facebook,'total':total}
this.each(function(i,elem){var classlist=get_class_list(elem);for(var i=0;i<classlist.length;i++){var cls=classlist[i];if(cls.substr(0,class_prefix_length)==options.class_prefix&&social[cls]){social[cls](options.url,function(count){if(count>=options.display_counter_from){if(social[cls.substr(class_prefix_length)]==twitter){$(elem).text("("+addCommas(count)+")");}else{$(elem).text(addCommas(count));}}})}}});function twitter(url,callback){$.ajax({type:'GET',dataType:'jsonp',url:'https://cdn.api.twitter.com/1/urls/count.json',data:{'url':url}}).done(function(data){callback(data.count);}).fail(function(data){callback(0);})}
function facebook(url,callback){$.ajax({type:'GET',dataType:'jsonp',url:'https://api.facebook.com/restserver.php',data:{'method':'links.getStats','urls':[url],'format':'json'}}).done(function(data){callback(data[0].share_count)}).fail(function(){callback(0);})}
function total(url,callback){$.ajax({url:'https://graph.facebook.com/?id='+url,type:"GET",dataType:"json",contentType:'application/json',success:function(a1){var count_comment_share=parseInt(a1.share.share_count)+parseInt(a1.share.comment_count);if(count_comment_share>0){$('.tshare .number').html(count_comment_share);}else{$('.tshare').hide();}},error:function(data){console.log('Request Server Fail');}});}
function addCommas(nStr)
{nStr+='';x=nStr.split('.');x1=x[0];x2=x.length>1?'.'+x[1]:'';var rgx=/(\d+)(\d{3})/;while(rgx.test(x1)){x1=x1.replace(rgx,'$1'+','+'$2');}
return x1+x2;}}})(jQuery);(function($){function windowSize(){windowHeight=window.innerHeight?window.innerHeight:$(window).height();windowWidth=window.innerWidth?window.innerWidth:$(window).width();}
windowSize();$(window).resize(function(){windowSize();});var stickyHeaderTop=$('#socialshare').offset().top;$(window).scroll(function(){if($(window).scrollTop()>stickyHeaderTop){if(windowWidth>900){$('.stickybar').css({position:'fixed',top:'0px'});$('.stickybar').css('display','block');}else{$('.stickybar').css('display','none');}}else{$('.stickybar').css({position:'static',top:'0px'});$('.stickybar').css('display','none');}});$(".more_social").on("click",function(){$(this).siblings($(".more_social_secondary")).toggleClass("show");$(this).toggleClass("transform");});$(document).ready(function(){$('.share').ShareLink({title:shareTitle,text:shareText,image:shareImage,url:shareUrl});$('.total').ShareCounter({url:shareUrl});});$('.ss-email').click(function(event){var w=550,h=450,left=Number((screen.width/2)-(w/2)),tops=Number((screen.height/2)-(h/2));event.preventDefault();window.open($(this).attr("href"),"popupWindow","width="+w+", height="+h+", top="+tops+", left="+left);});})(jQuery);var Attacklab=Attacklab||{};Attacklab.wmdBase=function(){var wmd=top.Attacklab;var doc=top.document;var re=top.RegExp;var nav=top.navigator;wmd.Util={};wmd.Position={};wmd.Command={};wmd.Global={};var util=wmd.Util;var position=wmd.Position;var command=wmd.Command;var global=wmd.Global;global.isIE=/msie/.test(nav.userAgent.toLowerCase());global.isIE_5or6=/msie 6/.test(nav.userAgent.toLowerCase())||/msie 5/.test(nav.userAgent.toLowerCase());global.isIE_7plus=global.isIE&&!global.isIE_5or6;global.isOpera=/opera/.test(nav.userAgent.toLowerCase());global.isKonqueror=/konqueror/.test(nav.userAgent.toLowerCase());var imageDialogText="<p style='margin-top: 0px'><b>Enter the image URL.</b></p><p>You can also add a title, which will be displayed as a tool tip.</p><p>Example:<br />http://wmd-editor.com/images/cloud1.jpg   \"Optional title\"</p>";var linkDialogText="<p style='margin-top: 0px'><b>Enter the web address.</b></p><p>You can also add a title, which will be displayed as a tool tip.</p><p>Example:<br />http://wmd-editor.com/   \"Optional title\"</p>";var imageDefaultText="http://";var linkDefaultText="http://";var imageDirectory="images/";var previewPollInterval=500;var pastePollInterval=100;wmd.PanelCollection=function(){this.buttonBar=doc.getElementById("wmd-button-bar");this.preview=doc.getElementById("wmd-preview");this.output=doc.getElementById("wmd-output");this.input=doc.getElementById("wmd-input");};wmd.panels=undefined;wmd.ieCachedRange=null;wmd.ieRetardedClick=false;util.isVisible=function(elem){if(window.getComputedStyle){return window.getComputedStyle(elem,null).getPropertyValue("display")!=="none";}
else if(elem.currentStyle){return elem.currentStyle["display"]!=="none";}};util.addEvent=function(elem,event,listener){if(elem.attachEvent){elem.attachEvent("on"+event,listener);}
else{elem.addEventListener(event,listener,false);}};util.removeEvent=function(elem,event,listener){if(elem.detachEvent){elem.detachEvent("on"+event,listener);}
else{elem.removeEventListener(event,listener,false);}};util.fixEolChars=function(text){text=text.replace(/\r\n/g,"\n");text=text.replace(/\r/g,"\n");return text;};util.extendRegExp=function(regex,pre,post){if(pre===null||pre===undefined)
{pre="";}
if(post===null||post===undefined)
{post="";}
var pattern=regex.toString();var flags="";var result=pattern.match(/\/([gim]*)$/);if(result===null){flags=result[0];}
else{flags="";}
pattern=pattern.replace(/(^\/|\/[gim]*$)/g,"");pattern=pre+pattern+post;return new RegExp(pattern,flags);}
util.createImage=function(img){var imgPath=imageDirectory+img;var elem=doc.createElement("img");elem.className="wmd-button";elem.src=imgPath;return elem;};util.prompt=function(text,defaultInputText,makeLinkMarkdown){var dialog;var background;var input;if(defaultInputText===undefined){defaultInputText="";}
var checkEscape=function(key){var code=(key.charCode||key.keyCode);if(code===27){close(true);}};var close=function(isCancel){util.removeEvent(doc.body,"keydown",checkEscape);var text=input.value;if(isCancel){text=null;}
else{text=text.replace('http://http://','http://');text=text.replace('http://https://','https://');text=text.replace('http://ftp://','ftp://');if(text.indexOf('http://')===-1&&text.indexOf('ftp://')===-1&&text.indexOf('https://')===-1){text='http://'+text;}}
dialog.parentNode.removeChild(dialog);background.parentNode.removeChild(background);makeLinkMarkdown(text);return false;};var createBackground=function(){background=doc.createElement("div");background.className="wmd-prompt-background";style=background.style;style.position="absolute";style.top="0";style.zIndex="1000";if(global.isKonqueror){style.backgroundColor="transparent";}
else if(global.isIE){style.filter="alpha(opacity=50)";}
else{style.opacity="0.5";}
var pageSize=position.getPageSize();style.height=pageSize[1]+"px";if(global.isIE){style.left=doc.documentElement.scrollLeft;style.width=doc.documentElement.clientWidth;}
else{style.left="0";style.width="100%";}
doc.body.appendChild(background);};var createDialog=function(){dialog=doc.createElement("div");dialog.className="wmd-prompt-dialog";dialog.style.padding="10px;";dialog.style.position="fixed";dialog.style.width="400px";dialog.style.zIndex="1001";var question=doc.createElement("div");question.innerHTML=text;question.style.padding="5px";dialog.appendChild(question);var form=doc.createElement("form");form.onsubmit=function(){return close(false);};style=form.style;style.padding="0";style.margin="0";style.cssFloat="left";style.width="100%";style.textAlign="center";style.position="relative";dialog.appendChild(form);input=doc.createElement("input");input.type="text";input.value=defaultInputText;style=input.style;style.display="block";style.width="80%";style.marginLeft=style.marginRight="auto";form.appendChild(input);var okButton=doc.createElement("input");okButton.type="button";okButton.onclick=function(){return close(false);};okButton.value="OK";style=okButton.style;style.margin="10px";style.display="inline";style.width="7em";var cancelButton=doc.createElement("input");cancelButton.type="button";cancelButton.onclick=function(){return close(true);};cancelButton.value="Cancel";style=cancelButton.style;style.margin="10px";style.display="inline";style.width="7em";if(/mac/.test(nav.platform.toLowerCase())){form.appendChild(cancelButton);form.appendChild(okButton);}
else{form.appendChild(okButton);form.appendChild(cancelButton);}
util.addEvent(doc.body,"keydown",checkEscape);dialog.style.top="50%";dialog.style.left="50%";dialog.style.display="block";if(global.isIE_5or6){dialog.style.position="absolute";dialog.style.top=doc.documentElement.scrollTop+200+"px";dialog.style.left="50%";}
doc.body.appendChild(dialog);dialog.style.marginTop=-(position.getHeight(dialog)/2)+"px";dialog.style.marginLeft=-(position.getWidth(dialog)/2)+"px";};createBackground();top.setTimeout(function(){createDialog();var defTextLen=defaultInputText.length;if(input.selectionStart!==undefined){input.selectionStart=0;input.selectionEnd=defTextLen;}else if(input.createTextRange){var range=input.createTextRange();range.collapse(false);range.moveStart("character",-defTextLen);range.moveEnd("character",defTextLen);range.select();}
input.focus();},0);};position.getTop=function(elem,isInner){var result=elem.offsetTop;if(!isInner){while(elem=elem.offsetParent){result+=elem.offsetTop;}}
return result;};position.getHeight=function(elem){return elem.offsetHeight||elem.scrollHeight;};position.getWidth=function(elem){return elem.offsetWidth||elem.scrollWidth;};position.getPageSize=function(){var scrollWidth,scrollHeight;var innerWidth,innerHeight;if(self.innerHeight&&self.scrollMaxY){scrollWidth=doc.body.scrollWidth;scrollHeight=self.innerHeight+self.scrollMaxY;}
else if(doc.body.scrollHeight>doc.body.offsetHeight){scrollWidth=doc.body.scrollWidth;scrollHeight=doc.body.scrollHeight;}
else{scrollWidth=doc.body.offsetWidth;scrollHeight=doc.body.offsetHeight;}
if(self.innerHeight){innerWidth=self.innerWidth;innerHeight=self.innerHeight;}
else if(doc.documentElement&&doc.documentElement.clientHeight){innerWidth=doc.documentElement.clientWidth;innerHeight=doc.documentElement.clientHeight;}
else if(doc.body){innerWidth=doc.body.clientWidth;innerHeight=doc.body.clientHeight;}
var maxWidth=Math.max(scrollWidth,innerWidth);var maxHeight=Math.max(scrollHeight,innerHeight);return[maxWidth,maxHeight,innerWidth,innerHeight];};wmd.inputPoller=function(callback,interval){var pollerObj=this;var inputArea=wmd.panels.input;var lastStart;var lastEnd;var markdown;var killHandle;this.tick=function(){if(!util.isVisible(inputArea)){return;}
window.i=inputArea;try
{if(inputArea.selectionStart||inputArea.selectionStart===0){var start=inputArea.selectionStart;var end=inputArea.selectionEnd;if(start!=lastStart||end!=lastEnd){lastStart=start;lastEnd=end;if(markdown!=inputArea.value){markdown=inputArea.value;return true;}}}}
catch(e){}
return false;};var doTickCallback=function(){if(!util.isVisible(inputArea)){return;}
if(pollerObj.tick()){callback();}};var assignInterval=function(){killHandle=top.setInterval(doTickCallback,interval);};this.destroy=function(){top.clearInterval(killHandle);};assignInterval();};wmd.undoManager=function(callback){var undoObj=this;var undoStack=[];var stackPtr=0;var mode="none";var lastState;var poller;var timer;var inputStateObj;var setMode=function(newMode,noSave){if(mode!=newMode){mode=newMode;if(!noSave){saveState();}}
if(!global.isIE||mode!="moving"){timer=top.setTimeout(refreshState,1);}
else{inputStateObj=null;}};var refreshState=function(){inputStateObj=new wmd.TextareaState();poller.tick();timer=undefined;};this.setCommandMode=function(){mode="command";saveState();timer=top.setTimeout(refreshState,0);};this.canUndo=function(){return stackPtr>1;};this.canRedo=function(){if(undoStack[stackPtr+1]){return true;}
return false;};this.undo=function(){if(undoObj.canUndo()){if(lastState){lastState.restore();lastState=null;}
else{undoStack[stackPtr]=new wmd.TextareaState();undoStack[--stackPtr].restore();if(callback){callback();}}}
mode="none";wmd.panels.input.focus();refreshState();};this.redo=function(){if(undoObj.canRedo()){undoStack[++stackPtr].restore();if(callback){callback();}}
mode="none";wmd.panels.input.focus();refreshState();};var saveState=function(){var currState=inputStateObj||new wmd.TextareaState();if(!currState){return false;}
if(mode=="moving"){if(!lastState){lastState=currState;}
return;}
if(lastState){if(undoStack[stackPtr-1].text!=lastState.text){undoStack[stackPtr++]=lastState;}
lastState=null;}
undoStack[stackPtr++]=currState;undoStack[stackPtr+1]=null;if(callback){callback();}};var handleCtrlYZ=function(event){var handled=false;if(event.ctrlKey||event.metaKey){var keyCode=event.charCode||event.keyCode;var keyCodeChar=String.fromCharCode(keyCode);switch(keyCodeChar){case"y":undoObj.redo();handled=true;break;case"z":if(!event.shiftKey){undoObj.undo();}
else{undoObj.redo();}
handled=true;break;}}
if(handled){if(event.preventDefault){event.preventDefault();}
if(top.event){top.event.returnValue=false;}
return;}};var handleModeChange=function(event){if(!event.ctrlKey&&!event.metaKey){var keyCode=event.keyCode;if((keyCode>=33&&keyCode<=40)||(keyCode>=63232&&keyCode<=63235)){setMode("moving");}
else if(keyCode==8||keyCode==46||keyCode==127){setMode("deleting");}
else if(keyCode==13){setMode("newlines");}
else if(keyCode==27){setMode("escape");}
else if((keyCode<16||keyCode>20)&&keyCode!=91){setMode("typing");}}};var setEventHandlers=function(){util.addEvent(wmd.panels.input,"keypress",function(event){if((event.ctrlKey||event.metaKey)&&(event.keyCode==89||event.keyCode==90)){event.preventDefault();}});var handlePaste=function(){if(global.isIE||(inputStateObj&&inputStateObj.text!=wmd.panels.input.value)){if(timer==undefined){mode="paste";saveState();refreshState();}}};poller=new wmd.inputPoller(handlePaste,pastePollInterval);util.addEvent(wmd.panels.input,"keydown",handleCtrlYZ);util.addEvent(wmd.panels.input,"keydown",handleModeChange);util.addEvent(wmd.panels.input,"mousedown",function(){setMode("moving");});wmd.panels.input.onpaste=handlePaste;wmd.panels.input.ondrop=handlePaste;};var init=function(){setEventHandlers();refreshState();saveState();};this.destroy=function(){if(poller){poller.destroy();}};init();};wmd.editor=function(previewRefreshCallback){if(!previewRefreshCallback){previewRefreshCallback=function(){};}
var inputBox=wmd.panels.input;var offsetHeight=0;var editObj=this;var mainDiv;var mainSpan;var div;var creationHandle;var undoMgr;var doClick=function(button){inputBox.focus();if(button.textOp){if(undoMgr){undoMgr.setCommandMode();}
var state=new wmd.TextareaState();if(!state){return;}
var chunks=state.getChunks();var fixupInputArea=function(){inputBox.focus();if(chunks){state.setChunks(chunks);}
state.restore();previewRefreshCallback();};var useDefaultText=true;var noCleanup=button.textOp(chunks,fixupInputArea,useDefaultText);if(!noCleanup){fixupInputArea();}}
if(button.execute){button.execute(editObj);}};var setUndoRedoButtonStates=function(){if(undoMgr){setupButton(document.getElementById("wmd-undo-button"),undoMgr.canUndo());setupButton(document.getElementById("wmd-redo-button"),undoMgr.canRedo());}};var setupButton=function(button,isEnabled){var normalYShift="0px";var disabledYShift="-20px";var highlightYShift="-40px";if(isEnabled){button.style.backgroundPosition=button.XShift+" "+normalYShift;button.onmouseover=function(){this.style.backgroundPosition=this.XShift+" "+highlightYShift;};button.onmouseout=function(){this.style.backgroundPosition=this.XShift+" "+normalYShift;};if(global.isIE){button.onmousedown=function(){wmd.ieRetardedClick=true;wmd.ieCachedRange=document.selection.createRange();};}
if(!button.isHelp)
{button.onclick=function(){if(this.onmouseout){this.onmouseout();}
doClick(this);return false;}}}
else{button.style.backgroundPosition=button.XShift+" "+disabledYShift;button.onmouseover=button.onmouseout=button.onclick=function(){};}}
var makeSpritedButtonRow=function(){var buttonBar=document.getElementById("wmd-button-bar");var normalYShift="0px";var disabledYShift="-20px";var highlightYShift="-40px";var buttonRow=document.createElement("ul");buttonRow.id="wmd-button-row";buttonRow=buttonBar.appendChild(buttonRow);var boldButton=document.createElement("li");boldButton.className="wmd-button";boldButton.id="wmd-bold-button";boldButton.title="Strong <strong> Ctrl+B";boldButton.XShift="0px";boldButton.textOp=command.doBold;setupButton(boldButton,true);buttonRow.appendChild(boldButton);var italicButton=document.createElement("li");italicButton.className="wmd-button";italicButton.id="wmd-italic-button";italicButton.title="Emphasis <em> Ctrl+I";italicButton.XShift="-20px";italicButton.textOp=command.doItalic;setupButton(italicButton,true);buttonRow.appendChild(italicButton);var spacer1=document.createElement("li");spacer1.className="wmd-spacer";spacer1.id="wmd-spacer1";buttonRow.appendChild(spacer1);var linkButton=document.createElement("li");linkButton.className="wmd-button";linkButton.id="wmd-link-button";linkButton.title="Hyperlink <a> Ctrl+L";linkButton.XShift="-40px";linkButton.textOp=function(chunk,postProcessing,useDefaultText){return command.doLinkOrImage(chunk,postProcessing,false);};setupButton(linkButton,true);buttonRow.appendChild(linkButton);var quoteButton=document.createElement("li");quoteButton.className="wmd-button";quoteButton.id="wmd-quote-button";quoteButton.title="Blockquote <blockquote> Ctrl+Q";quoteButton.XShift="-60px";quoteButton.textOp=command.doBlockquote;setupButton(quoteButton,true);buttonRow.appendChild(quoteButton);var spacer2=document.createElement("li");spacer2.className="wmd-spacer";spacer2.id="wmd-spacer2";buttonRow.appendChild(spacer2);var undoButton=document.createElement("li");undoButton.className="wmd-button";undoButton.id="wmd-undo-button";undoButton.title="Undo - Ctrl+Z";undoButton.XShift="-200px";undoButton.execute=function(manager){manager.undo();};setupButton(undoButton,true);buttonRow.appendChild(undoButton);var redoButton=document.createElement("li");redoButton.className="wmd-button";redoButton.id="wmd-redo-button";redoButton.title="Redo - Ctrl+Y";if(/win/.test(nav.platform.toLowerCase())){redoButton.title="Redo - Ctrl+Y";}
else{redoButton.title="Redo - Ctrl+Shift+Z";}
redoButton.XShift="-220px";redoButton.execute=function(manager){manager.redo();};setupButton(redoButton,true);buttonRow.appendChild(redoButton);var helpButton=document.createElement("li");helpButton.className="wmd-button";helpButton.id="wmd-help-button";helpButton.XShift="-240px";helpButton.isHelp=true;setUndoRedoButtonStates();}
var setupEditor=function(){if(/\?noundo/.test(doc.location.href)){wmd.nativeUndo=true;}
if(!wmd.nativeUndo){undoMgr=new wmd.undoManager(function(){previewRefreshCallback();setUndoRedoButtonStates();});}
makeSpritedButtonRow();var keyEvent="keydown";if(global.isOpera){keyEvent="keypress";}
util.addEvent(inputBox,keyEvent,function(key){if(key.ctrlKey||key.metaKey){var keyCode=key.charCode||key.keyCode;var keyCodeStr=String.fromCharCode(keyCode).toLowerCase();switch(keyCodeStr){case"b":doClick(document.getElementById("wmd-bold-button"));break;case"i":doClick(document.getElementById("wmd-italic-button"));break;case"l":doClick(document.getElementById("wmd-link-button"));break;case"q":doClick(document.getElementById("wmd-quote-button"));break;case"y":doClick(document.getElementById("wmd-redo-button"));break;case"z":if(key.shiftKey){doClick(document.getElementById("wmd-redo-button"));}
else{doClick(document.getElementById("wmd-undo-button"));}
break;default:return;}
if(key.preventDefault){key.preventDefault();}
if(top.event){top.event.returnValue=false;}}});util.addEvent(inputBox,"keyup",function(key){if(!key.shiftKey&&!key.ctrlKey&&!key.metaKey){var keyCode=key.charCode||key.keyCode;if(keyCode===13){fakeButton={};fakeButton.textOp=command.doAutoindent;doClick(fakeButton);}}});if(global.isIE){util.addEvent(inputBox,"keydown",function(key){var code=key.keyCode;if(code===27){return false;}});}
if(inputBox.form){var submitCallback=inputBox.form.onsubmit;inputBox.form.onsubmit=function(){convertToHtml();if(submitCallback){return submitCallback.apply(this,arguments);}};}};var convertToHtml=function(){if(wmd.showdown){var markdownConverter=new wmd.showdown.converter();}
var text=inputBox.value;var callback=function(){inputBox.value=text;};if(!/markdown/.test(wmd.wmd_env.output.toLowerCase())){if(markdownConverter){inputBox.value=markdownConverter.makeHtml(text);top.setTimeout(callback,0);}}
return true;};this.undo=function(){if(undoMgr){undoMgr.undo();}};this.redo=function(){if(undoMgr){undoMgr.redo();}};var init=function(){setupEditor();};this.destroy=function(){if(undoMgr){undoMgr.destroy();}
if(div.parentNode){div.parentNode.removeChild(div);}
if(inputBox){inputBox.style.marginTop="";}
top.clearInterval(creationHandle);};init();};wmd.TextareaState=function(){var stateObj=this;var inputArea=wmd.panels.input;this.init=function(){if(!util.isVisible(inputArea)){return;}
this.setInputAreaSelectionStartEnd();this.scrollTop=inputArea.scrollTop;try{if(!this.text&&inputArea.selectionStart||inputArea.selectionStart===0){this.text=inputArea.value;}}
catch(e){}}
this.setInputAreaSelection=function(){if(!util.isVisible(inputArea)){return;}
if(inputArea.selectionStart!==undefined&&!global.isOpera){inputArea.focus();inputArea.selectionStart=stateObj.start;inputArea.selectionEnd=stateObj.end;inputArea.scrollTop=stateObj.scrollTop;}
else if(doc.selection){if(doc.activeElement&&doc.activeElement!==inputArea){return;}
inputArea.focus();var range=inputArea.createTextRange();range.moveStart("character",-inputArea.value.length);range.moveEnd("character",-inputArea.value.length);range.moveEnd("character",stateObj.end);range.moveStart("character",stateObj.start);range.select();}};this.setInputAreaSelectionStartEnd=function(){try{if(inputArea.selectionStart||inputArea.selectionStart===0){stateObj.start=inputArea.selectionStart;stateObj.end=inputArea.selectionEnd;}
else if(doc.selection){stateObj.text=util.fixEolChars(inputArea.value);var range;if(wmd.ieRetardedClick&&wmd.ieCachedRange){range=wmd.ieCachedRange;wmd.ieRetardedClick=false;}
else{range=doc.selection.createRange();}
var fixedRange=util.fixEolChars(range.text);var marker="\x07";var markedRange=marker+fixedRange+marker;range.text=markedRange;var inputText=util.fixEolChars(inputArea.value);range.moveStart("character",-markedRange.length);range.text=fixedRange;stateObj.start=inputText.indexOf(marker);stateObj.end=inputText.lastIndexOf(marker)-marker.length;var len=stateObj.text.length-util.fixEolChars(inputArea.value).length;if(len){range.moveStart("character",-fixedRange.length);while(len--){fixedRange+="\n";stateObj.end+=1;}
range.text=fixedRange;}
this.setInputAreaSelection();}}
catch(e){}};this.restore=function(){if(stateObj.text!=undefined&&stateObj.text!=inputArea.value){inputArea.value=stateObj.text;}
this.setInputAreaSelection();inputArea.scrollTop=stateObj.scrollTop;};this.getChunks=function(){var chunk=new wmd.Chunks();chunk.before=util.fixEolChars(stateObj.text.substring(0,stateObj.start));chunk.startTag="";chunk.selection=util.fixEolChars(stateObj.text.substring(stateObj.start,stateObj.end));chunk.endTag="";chunk.after=util.fixEolChars(stateObj.text.substring(stateObj.end));chunk.scrollTop=stateObj.scrollTop;return chunk;};this.setChunks=function(chunk){chunk.before=chunk.before+chunk.startTag;chunk.after=chunk.endTag+chunk.after;if(global.isOpera){chunk.before=chunk.before.replace(/\n/g,"\r\n");chunk.selection=chunk.selection.replace(/\n/g,"\r\n");chunk.after=chunk.after.replace(/\n/g,"\r\n");}
this.start=chunk.before.length;this.end=chunk.before.length+chunk.selection.length;this.text=chunk.before+chunk.selection+chunk.after;this.scrollTop=chunk.scrollTop;};this.init();};wmd.Chunks=function(){};wmd.Chunks.prototype.findTags=function(startRegex,endRegex){var chunkObj=this;var regex;if(startRegex){regex=util.extendRegExp(startRegex,"","$");this.before=this.before.replace(regex,function(match){chunkObj.startTag=chunkObj.startTag+match;return"";});regex=util.extendRegExp(startRegex,"^","");this.selection=this.selection.replace(regex,function(match){chunkObj.startTag=chunkObj.startTag+match;return"";});}
if(endRegex){regex=util.extendRegExp(endRegex,"","$");this.selection=this.selection.replace(regex,function(match){chunkObj.endTag=match+chunkObj.endTag;return"";});regex=util.extendRegExp(endRegex,"^","");this.after=this.after.replace(regex,function(match){chunkObj.endTag=match+chunkObj.endTag;return"";});}};wmd.Chunks.prototype.trimWhitespace=function(remove){this.selection=this.selection.replace(/^(\s*)/,"");if(!remove){this.before+=re.$1;}
this.selection=this.selection.replace(/(\s*)$/,"");if(!remove){this.after=re.$1+this.after;}};wmd.Chunks.prototype.addBlankLines=function(nLinesBefore,nLinesAfter,findExtraNewlines){if(nLinesBefore===undefined){nLinesBefore=1;}
if(nLinesAfter===undefined){nLinesAfter=1;}
nLinesBefore++;nLinesAfter++;var regexText;var replacementText;this.selection=this.selection.replace(/(^\n*)/,"");this.startTag=this.startTag+re.$1;this.selection=this.selection.replace(/(\n*$)/,"");this.endTag=this.endTag+re.$1;this.startTag=this.startTag.replace(/(^\n*)/,"");this.before=this.before+re.$1;this.endTag=this.endTag.replace(/(\n*$)/,"");this.after=this.after+re.$1;if(this.before){regexText=replacementText="";while(nLinesBefore--){regexText+="\\n?";replacementText+="\n";}
if(findExtraNewlines){regexText="\\n*";}
this.before=this.before.replace(new re(regexText+"$",""),replacementText);}
if(this.after){regexText=replacementText="";while(nLinesAfter--){regexText+="\\n?";replacementText+="\n";}
if(findExtraNewlines){regexText="\\n*";}
this.after=this.after.replace(new re(regexText,""),replacementText);}};command.prefixes="(?:\\s{4,}|\\s*>|\\s*-\\s+|\\s*\\d+\\.|=|\\+|-|_|\\*|#|\\s*\\[[^\n]]+\\]:)";command.unwrap=function(chunk){var txt=new re("([^\\n])\\n(?!(\\n|"+command.prefixes+"))","g");chunk.selection=chunk.selection.replace(txt,"$1 $2");};command.wrap=function(chunk,len){command.unwrap(chunk);var regex=new re("(.{1,"+len+"})( +|$\\n?)","gm");chunk.selection=chunk.selection.replace(regex,function(line,marked){if(new re("^"+command.prefixes,"").test(line)){return line;}
return marked+"\n";});chunk.selection=chunk.selection.replace(/\s+$/,"");};command.doBold=function(chunk,postProcessing,useDefaultText){return command.doBorI(chunk,2,"strong text");};command.doItalic=function(chunk,postProcessing,useDefaultText){return command.doBorI(chunk,1,"emphasized text");};command.doBorI=function(chunk,nStars,insertText){chunk.trimWhitespace();chunk.selection=chunk.selection.replace(/\n{2,}/g,"\n");chunk.before.search(/(\**$)/);var starsBefore=re.$1;chunk.after.search(/(^\**)/);var starsAfter=re.$1;var prevStars=Math.min(starsBefore.length,starsAfter.length);if((prevStars>=nStars)&&(prevStars!=2||nStars!=1)){chunk.before=chunk.before.replace(re("[*]{"+nStars+"}$",""),"");chunk.after=chunk.after.replace(re("^[*]{"+nStars+"}",""),"");}
else if(!chunk.selection&&starsAfter){chunk.after=chunk.after.replace(/^([*_]*)/,"");chunk.before=chunk.before.replace(/(\s?)$/,"");var whitespace=re.$1;chunk.before=chunk.before+starsAfter+whitespace;}
else{if(!chunk.selection&&!starsAfter){chunk.selection=insertText;}
var markup=nStars<=1?"*":"**";chunk.before=chunk.before+markup;chunk.after=markup+chunk.after;}
return;};command.stripLinkDefs=function(text,defsToAdd){text=text.replace(/^[ ]{0,3}\[(\d+)\]:[ \t]*\n?[ \t]*<?(\S+?)>?[ \t]*\n?[ \t]*(?:(\n*)["(](.+?)[")][ \t]*)?(?:\n+|$)/gm,function(totalMatch,id,link,newlines,title){defsToAdd[id]=totalMatch.replace(/\s*$/,"");if(newlines){defsToAdd[id]=totalMatch.replace(/["(](.+?)[")]$/,"");return newlines+title;}
return"";});return text;};command.addLinkDef=function(chunk,linkDef){var refNumber=0;var defsToAdd={};chunk.before=command.stripLinkDefs(chunk.before,defsToAdd);chunk.selection=command.stripLinkDefs(chunk.selection,defsToAdd);chunk.after=command.stripLinkDefs(chunk.after,defsToAdd);var defs="";var regex=/(\[(?:\[[^\]]*\]|[^\[\]])*\][ ]?(?:\n[ ]*)?\[)(\d+)(\])/g;var addDefNumber=function(def){refNumber++;def=def.replace(/^[ ]{0,3}\[(\d+)\]:/,"  ["+refNumber+"]:");defs+="\n"+def;};var getLink=function(wholeMatch,link,id,end){if(defsToAdd[id]){addDefNumber(defsToAdd[id]);return link+refNumber+end;}
return wholeMatch;};chunk.before=chunk.before.replace(regex,getLink);if(linkDef){addDefNumber(linkDef);}
else{chunk.selection=chunk.selection.replace(regex,getLink);}
var refOut=refNumber;chunk.after=chunk.after.replace(regex,getLink);if(chunk.after){chunk.after=chunk.after.replace(/\n*$/,"");}
if(!chunk.after){chunk.selection=chunk.selection.replace(/\n*$/,"");}
chunk.after+="\n\n"+defs;return refOut;};command.doLinkOrImage=function(chunk,postProcessing,isImage){chunk.trimWhitespace();chunk.findTags(/\s*!?\[/,/\][ ]?(?:\n[ ]*)?(\[.*?\])?/);if(chunk.endTag.length>1){chunk.startTag=chunk.startTag.replace(/!?\[/,"");chunk.endTag="";command.addLinkDef(chunk,null);}
else{if(/\n\n/.test(chunk.selection)){command.addLinkDef(chunk,null);return;}
var makeLinkMarkdown=function(link){if(link!==null){chunk.startTag=chunk.endTag="";var linkDef=" [999]: "+link;var num=command.addLinkDef(chunk,linkDef);chunk.startTag=isImage?"![":"[";chunk.endTag="]["+num+"]";if(!chunk.selection){if(isImage){chunk.selection="alt text";}
else{chunk.selection="link text";}}}
postProcessing();};if(isImage){util.prompt(imageDialogText,imageDefaultText,makeLinkMarkdown);}
else{util.prompt(linkDialogText,linkDefaultText,makeLinkMarkdown);}
return true;}};util.makeAPI=function(){wmd.wmd={};wmd.wmd.editor=wmd.editor;wmd.wmd.previewManager=wmd.previewManager;};util.startEditor=function(){if(wmd.wmd_env.autostart===false){util.makeAPI();return;}
var edit;var previewMgr;var loadListener=function(){wmd.panels=new wmd.PanelCollection();previewMgr=new wmd.previewManager();var previewRefreshCallback=previewMgr.refresh;edit=new wmd.editor(previewRefreshCallback);previewMgr.refresh(true);};util.addEvent(top,"load",loadListener);};wmd.previewManager=function(){var managerObj=this;var converter;var poller;var timeout;var elapsedTime;var oldInputText;var htmlOut;var maxDelay=3000;var startType="delayed";var setupEvents=function(inputElem,listener){util.addEvent(inputElem,"input",listener);inputElem.onpaste=listener;inputElem.ondrop=listener;util.addEvent(inputElem,"keypress",listener);util.addEvent(inputElem,"keydown",listener);poller=new wmd.inputPoller(listener,previewPollInterval);};var getDocScrollTop=function(){var result=0;if(top.innerHeight){result=top.pageYOffset;}
else
if(doc.documentElement&&doc.documentElement.scrollTop){result=doc.documentElement.scrollTop;}
else
if(doc.body){result=doc.body.scrollTop;}
return result;};var makePreviewHtml=function(){if(!wmd.panels.preview&&!wmd.panels.output){return;}
var text=wmd.panels.input.value;if(text&&text==oldInputText){return;}
else{oldInputText=text;}
var prevTime=new Date().getTime();if(!converter&&wmd.showdown){converter=new wmd.showdown.converter();}
if(converter){text=converter.makeHtml(text);}
var currTime=new Date().getTime();elapsedTime=currTime-prevTime;pushPreviewHtml(text);htmlOut=text;};var applyTimeout=function(){if(timeout){top.clearTimeout(timeout);timeout=undefined;}
if(startType!=="manual"){var delay=0;if(startType==="delayed"){delay=elapsedTime;}
if(delay>maxDelay){delay=maxDelay;}
timeout=top.setTimeout(makePreviewHtml,delay);}};var getScaleFactor=function(panel){if(panel.scrollHeight<=panel.clientHeight){return 1;}
return panel.scrollTop/(panel.scrollHeight-panel.clientHeight);};var setPanelScrollTops=function(){if(wmd.panels.preview){wmd.panels.preview.scrollTop=(wmd.panels.preview.scrollHeight-wmd.panels.preview.clientHeight)*getScaleFactor(wmd.panels.preview);;}
if(wmd.panels.output){wmd.panels.output.scrollTop=(wmd.panels.output.scrollHeight-wmd.panels.output.clientHeight)*getScaleFactor(wmd.panels.output);;}};this.refresh=function(requiresRefresh){if(requiresRefresh){oldInputText="";makePreviewHtml();}
else{applyTimeout();}};this.processingTime=function(){return elapsedTime;};this.output=function(){return htmlOut;};this.setUpdateMode=function(mode){startType=mode;managerObj.refresh();};var isFirstTimeFilled=true;var pushPreviewHtml=function(text){var emptyTop=position.getTop(wmd.panels.input)-getDocScrollTop();if(wmd.panels.output){if(wmd.panels.output.value!==undefined){wmd.panels.output.value=text;wmd.panels.output.readOnly=true;}
else{var newText=text.replace(/&/g,"&amp;");newText=newText.replace(/</g,"&lt;");wmd.panels.output.innerHTML="<pre><code>"+newText+"</code></pre>";}}
if(wmd.panels.preview){wmd.panels.preview.innerHTML=text;}
setPanelScrollTops();if(isFirstTimeFilled){isFirstTimeFilled=false;return;}
var fullTop=position.getTop(wmd.panels.input)-getDocScrollTop();if(global.isIE){top.setTimeout(function(){top.scrollBy(0,fullTop-emptyTop);},0);}
else{top.scrollBy(0,fullTop-emptyTop);}};var init=function(){setupEvents(wmd.panels.input,applyTimeout);makePreviewHtml();if(wmd.panels.preview){wmd.panels.preview.scrollTop=0;}
if(wmd.panels.output){wmd.panels.output.scrollTop=0;}};this.destroy=function(){if(poller){poller.destroy();}};init();};command.doAutoindent=function(chunk,postProcessing,useDefaultText){chunk.before=chunk.before.replace(/(\n|^)[ ]{0,3}([*+-]|\d+[.])[ \t]*\n$/,"\n\n");chunk.before=chunk.before.replace(/(\n|^)[ ]{0,3}>[ \t]*\n$/,"\n\n");chunk.before=chunk.before.replace(/(\n|^)[ \t]+\n$/,"\n\n");useDefaultText=false;if(/(\n|^)[ ]{0,3}([*+-])[ \t]+.*\n$/.test(chunk.before)){if(command.doList){command.doList(chunk,postProcessing,false,true);}}
if(/(\n|^)[ ]{0,3}(\d+[.])[ \t]+.*\n$/.test(chunk.before)){if(command.doList){command.doList(chunk,postProcessing,true,true);}}
if(/(\n|^)[ ]{0,3}>[ \t]+.*\n$/.test(chunk.before)){if(command.doBlockquote){command.doBlockquote(chunk,postProcessing,useDefaultText);}}
if(/(\n|^)(\t|[ ]{4,}).*\n$/.test(chunk.before)){if(command.doCode){command.doCode(chunk,postProcessing,useDefaultText);}}};command.doBlockquote=function(chunk,postProcessing,useDefaultText){chunk.selection=chunk.selection.replace(/^(\n*)([^\r]+?)(\n*)$/,function(totalMatch,newlinesBefore,text,newlinesAfter){chunk.before+=newlinesBefore;chunk.after=newlinesAfter+chunk.after;return text;});chunk.before=chunk.before.replace(/(>[ \t]*)$/,function(totalMatch,blankLine){chunk.selection=blankLine+chunk.selection;return"";});var defaultText=useDefaultText?"Blockquote":"";chunk.selection=chunk.selection.replace(/^(\s|>)+$/,"");chunk.selection=chunk.selection||defaultText;if(chunk.before){chunk.before=chunk.before.replace(/\n?$/,"\n");}
if(chunk.after){chunk.after=chunk.after.replace(/^\n?/,"\n");}
chunk.before=chunk.before.replace(/(((\n|^)(\n[ \t]*)*>(.+\n)*.*)+(\n[ \t]*)*$)/,function(totalMatch){chunk.startTag=totalMatch;return"";});chunk.after=chunk.after.replace(/^(((\n|^)(\n[ \t]*)*>(.+\n)*.*)+(\n[ \t]*)*)/,function(totalMatch){chunk.endTag=totalMatch;return"";});var replaceBlanksInTags=function(useBracket){var replacement=useBracket?"> ":"";if(chunk.startTag){chunk.startTag=chunk.startTag.replace(/\n((>|\s)*)\n$/,function(totalMatch,markdown){return"\n"+markdown.replace(/^[ ]{0,3}>?[ \t]*$/gm,replacement)+"\n";});}
if(chunk.endTag){chunk.endTag=chunk.endTag.replace(/^\n((>|\s)*)\n/,function(totalMatch,markdown){return"\n"+markdown.replace(/^[ ]{0,3}>?[ \t]*$/gm,replacement)+"\n";});}};if(/^(?![ ]{0,3}>)/m.test(chunk.selection)){command.wrap(chunk,wmd.wmd_env.lineLength-2);chunk.selection=chunk.selection.replace(/^/gm,"> ");replaceBlanksInTags(true);chunk.addBlankLines();}
else{chunk.selection=chunk.selection.replace(/^[ ]{0,3}> ?/gm,"");command.unwrap(chunk);replaceBlanksInTags(false);if(!/^(\n|^)[ ]{0,3}>/.test(chunk.selection)&&chunk.startTag){chunk.startTag=chunk.startTag.replace(/\n{0,2}$/,"\n\n");}
if(!/(\n|^)[ ]{0,3}>.*$/.test(chunk.selection)&&chunk.endTag){chunk.endTag=chunk.endTag.replace(/^\n{0,2}/,"\n\n");}}
if(!/\n/.test(chunk.selection)){chunk.selection=chunk.selection.replace(/^(> *)/,function(wholeMatch,blanks){chunk.startTag+=blanks;return"";});}};command.doCode=function(chunk,postProcessing,useDefaultText){var hasTextBefore=/\S[ ]*$/.test(chunk.before);var hasTextAfter=/^[ ]*\S/.test(chunk.after);if((!hasTextAfter&&!hasTextBefore)||/\n/.test(chunk.selection)){chunk.before=chunk.before.replace(/[ ]{4}$/,function(totalMatch){chunk.selection=totalMatch+chunk.selection;return"";});var nLinesBefore=1;var nLinesAfter=1;if(/\n(\t|[ ]{4,}).*\n$/.test(chunk.before)||chunk.after===""){nLinesBefore=0;}
if(/^\n(\t|[ ]{4,})/.test(chunk.after)){nLinesAfter=0;}
chunk.addBlankLines(nLinesBefore,nLinesAfter);if(!chunk.selection){chunk.startTag="    ";chunk.selection=useDefaultText?"enter code here":"";}
else{if(/^[ ]{0,3}\S/m.test(chunk.selection)){chunk.selection=chunk.selection.replace(/^/gm,"    ");}
else{chunk.selection=chunk.selection.replace(/^[ ]{4}/gm,"");}}}
else{chunk.trimWhitespace();chunk.findTags(/`/,/`/);if(!chunk.startTag&&!chunk.endTag){chunk.startTag=chunk.endTag="`";if(!chunk.selection){chunk.selection=useDefaultText?"enter code here":"";}}
else if(chunk.endTag&&!chunk.startTag){chunk.before+=chunk.endTag;chunk.endTag="";}
else{chunk.startTag=chunk.endTag="";}}};command.doList=function(chunk,postProcessing,isNumberedList,useDefaultText){var previousItemsRegex=/(\n|^)(([ ]{0,3}([*+-]|\d+[.])[ \t]+.*)(\n.+|\n{2,}([*+-].*|\d+[.])[ \t]+.*|\n{2,}[ \t]+\S.*)*)\n*$/;var nextItemsRegex=/^\n*(([ ]{0,3}([*+-]|\d+[.])[ \t]+.*)(\n.+|\n{2,}([*+-].*|\d+[.])[ \t]+.*|\n{2,}[ \t]+\S.*)*)\n*/;var bullet="-";var num=1;var getItemPrefix=function(){var prefix;if(isNumberedList){prefix=" "+num+". ";num++;}
else{prefix=" "+bullet+" ";}
return prefix;};var getPrefixedItem=function(itemText){if(isNumberedList===undefined){isNumberedList=/^\s*\d/.test(itemText);}
itemText=itemText.replace(/^[ ]{0,3}([*+-]|\d+[.])\s/gm,function(_){return getItemPrefix();});return itemText;};chunk.findTags(/(\n|^)*[ ]{0,3}([*+-]|\d+[.])\s+/,null);if(chunk.before&&!/\n$/.test(chunk.before)&&!/^\n/.test(chunk.startTag)){chunk.before+=chunk.startTag;chunk.startTag="";}
if(chunk.startTag){var hasDigits=/\d+[.]/.test(chunk.startTag);chunk.startTag="";chunk.selection=chunk.selection.replace(/\n[ ]{4}/g,"\n");command.unwrap(chunk);chunk.addBlankLines();if(hasDigits){chunk.after=chunk.after.replace(nextItemsRegex,getPrefixedItem);}
if(isNumberedList==hasDigits){return;}}
var nLinesBefore=1;chunk.before=chunk.before.replace(previousItemsRegex,function(itemText){if(/^\s*([*+-])/.test(itemText)){bullet=re.$1;}
nLinesBefore=/[^\n]\n\n[^\n]/.test(itemText)?1:0;return getPrefixedItem(itemText);});if(!chunk.selection){chunk.selection=useDefaultText?"List item":" ";}
var prefix=getItemPrefix();var nLinesAfter=1;chunk.after=chunk.after.replace(nextItemsRegex,function(itemText){nLinesAfter=/[^\n]\n\n[^\n]/.test(itemText)?1:0;return getPrefixedItem(itemText);});chunk.trimWhitespace(true);chunk.addBlankLines(nLinesBefore,nLinesAfter,true);chunk.startTag=prefix;var spaces=prefix.replace(/./g," ");command.wrap(chunk,wmd.wmd_env.lineLength-spaces.length);chunk.selection=chunk.selection.replace(/\n/g,"\n"+spaces);};command.doHeading=function(chunk,postProcessing,useDefaultText){chunk.selection=chunk.selection.replace(/\s+/g," ");chunk.selection=chunk.selection.replace(/(^\s+|\s+$)/g,"");if(!chunk.selection){chunk.startTag="## ";chunk.selection="Heading";chunk.endTag=" ##";return;}
var headerLevel=0;chunk.findTags(/#+[ ]*/,/[ ]*#+/);if(/#+/.test(chunk.startTag)){headerLevel=re.lastMatch.length;}
chunk.startTag=chunk.endTag="";chunk.findTags(null,/\s?(-+|=+)/);if(/=+/.test(chunk.endTag)){headerLevel=1;}
if(/-+/.test(chunk.endTag)){headerLevel=2;}
chunk.startTag=chunk.endTag="";chunk.addBlankLines(1,1);var headerLevelToCreate=headerLevel==0?2:headerLevel-1;if(headerLevelToCreate>0){var headerChar=headerLevelToCreate>=2?"-":"=";var len=chunk.selection.length;if(len>wmd.wmd_env.lineLength){len=wmd.wmd_env.lineLength;}
chunk.endTag="\n";while(len--){chunk.endTag+=headerChar;}}};command.doHorizontalRule=function(chunk,postProcessing,useDefaultText){chunk.startTag="----------\n";chunk.selection="";chunk.addBlankLines(2,1,true);}};Attacklab.wmd_env={};Attacklab.account_options={};Attacklab.wmd_defaults={version:1,output:"HTML",lineLength:40,delayLoad:false};if(!Attacklab.wmd)
{Attacklab.wmd=function()
{Attacklab.loadEnv=function()
{var mergeEnv=function(env)
{if(!env)
{return;}
for(var key in env)
{Attacklab.wmd_env[key]=env[key];}};mergeEnv(Attacklab.wmd_defaults);mergeEnv(Attacklab.account_options);mergeEnv(top["wmd_options"]);Attacklab.full=true;var defaultButtons="bold italic link blockquote code image ol ul heading hr";Attacklab.wmd_env.buttons=Attacklab.wmd_env.buttons||defaultButtons;};Attacklab.loadEnv();};Attacklab.wmd();Attacklab.wmdBase();Attacklab.Util.startEditor();};var imgshow_Src=new Array();var imgshow_Captions=new Array();var imgshow_cImage=0;var imgshow_iPeriod=500;var imgshow_iTimer=null;var imgshow_iPath='';var imgshow_cAttr=(navigator.appName=='Microsoft Internet Explorer')?"className":"class";function imgshow_glow(obj)
{obj.setAttribute(imgshow_cAttr,"active");}
function imgshow_fade(obj)
{if(('img_gallery_'+imgshow_cImage)!=obj.getAttribute('id'))
obj.setAttribute(imgshow_cAttr,"faded");}
function imgshow_clearTimer()
{if(imgshow_iTimer)
clearTimeout(imgshow_iTimer);}
function imgshow_delay()
{imgshow_clearTimer();imgshow_iTimer=setTimeout("imgshow_show()",imgshow_iPeriod*5);}
function imgshow_set(number)
{if(typeof(number)=='object')
{var id=number.getAttribute('id');number=parseInt(id.replace('img_gallery_',''));}
imgshow_cImage=number;imgshow_set_info();imgshow_clearTimer();imgshow_iTimer=setTimeout("imgshow_show()",imgshow_iPeriod);}
function imgshow_show()
{imgshow_cImage=(imgshow_cImage<imgshow_Captions.length-1)?(imgshow_cImage+1):0;imgshow_set_info();imgshow_clearTimer();imgshow_iTimer=setTimeout("imgshow_show()",imgshow_iPeriod);}
function imgshow_previous()
{imgshow_cImage=parseInt((imgshow_cImage>0)?(imgshow_cImage-1):(imgshow_Captions.length-1));imgshow_set_info();imgshow_delay();}
function imgshow_next()
{imgshow_cImage=parseInt((imgshow_cImage<imgshow_Captions.length-1)?(imgshow_cImage+1):0);imgshow_set_info();imgshow_delay();}
function imgshow_set_info()
{var children=new Array;if(document.getElementById('exp_img_show_navigator'))
children=document.getElementById('exp_img_show_navigator').getElementsByTagName('img');var len=children.length;for(iLoop=0;iLoop<len;iLoop++)
children[iLoop].setAttribute(imgshow_cAttr,((imgshow_cImage==iLoop)?"active":"faded"));document.getElementById('exp_img_gallery_image').src=imgshow_Src[imgshow_cImage].src;document.getElementById('exp_img_gallery_caption').innerHTML=imgshow_Captions[imgshow_cImage];}
function imgshow_init(src,caption,spliter,imgPeriod,imgshow_iPath)
{var images=src.split(spliter);imgshow_Captions=caption.split(spliter);imgshow_iPeriod=imgPeriod;imgshow_iPath=imgshow_iPath;for(var i=0;i<images.length;i++)
{imgshow_Src[i]=new Image(120,120);imgshow_Src[i].src=images[i];}
imgshow_iTimer=setTimeout("imgshow_show()",imgshow_iPeriod);}
function imgshow_toggle(display)
{if(document.getElementById('exp_gallery_wraper'))
{document.getElementById('exp_gallery_wraper').style.display=display;}}
document.onkeyup=function image_show_keyboard_navigation_handler(e){var e=window.event||e;var keyunicode=e.charCode||e.keyCode;if(keyunicode==37)
imgshow_next();else if(keyunicode==39)
imgshow_previous();};jQuery(document).ready(function(){jQuery("#exp_img_show_navigator img").bind("click",function(event){imgshow_set(this);});jQuery("#exp_img_show_navigator img").bind("mouseover",function(event){imgshow_glow(this);});jQuery("#exp_img_show_navigator img").bind("mouseout",function(event){imgshow_fade(this);});});jQuery.noConflict();cfct={}
cfct.loading=function(){return'<div class="loading"><span>Loading...</span></div>';}
cfct.ajax_post_content=function(){jQuery('ol.archive .excerpt .entry-title a').unbind().click(function(){var post_id=jQuery(this).attr('rev').replace('post-','');var excerpt=jQuery('#post-excerpt-'+post_id);var target=jQuery('#post-content-'+post_id+'-target');excerpt.hide();target.html(cfct.loading()).show().load(CFCT_URL+'/index.php?cfct_action=post_content&id='+post_id,function(){cfct.ajax_post_comments();jQuery('#post_close_'+post_id+' a').click(function(){target.slideUp(function(){excerpt.show();});return false;});jQuery(this).hide().slideDown();});return false;});}
cfct.ajax_post_comments=function(){jQuery('p.comments-link a').unbind().click(function(){var a=jQuery(this);var post_id=a.attr('rev').replace('post-','');var target=jQuery('#post-comments-'+post_id+'-target');target.html(cfct.loading()).show().load(CFCT_URL+'/index.php?cfct_action=post_comments&id='+post_id,function(){jQuery(this).hide().slideDown(function(){a.attr('rel',a.html()).html('Hide Comments').unbind().click(function(){target.slideUp(function(){a.html(a.attr('rel'));cfct.ajax_post_comments();});return false;});});});return false;});}
addComment={moveForm:function(commId,parentId,respondId,postId){var t=this,div,comm=t.I(commId),respond=t.I(respondId),cancel=t.I('cancel-comment-reply-link-p'+postId),parent=t.I('comment_parent_p'+postId),post=t.I('comment_post_ID_p'+postId);if(!comm||!respond||!cancel||!parent)
return;t.respondId=respondId;postId=postId||false;if(!t.I('wp-temp-form-div-p'+postId)){div=document.createElement('div');div.id='wp-temp-form-div-p'+postId;div.style.display='none';respond.parentNode.insertBefore(div,respond);}
comm.parentNode.insertBefore(respond,comm.nextSibling);if(post&&postId)
post.value=postId;parent.value=parentId;cancel.style.display='';cancel.onclick=function(){var t=addComment,temp=t.I('wp-temp-form-div-p'+postId),respond=t.I(t.respondId);if(!temp||!respond)
return;t.I('comment_parent_p'+postId).value='0';temp.parentNode.insertBefore(respond,temp);temp.parentNode.removeChild(temp);this.style.display='none';this.onclick=null;return false;}
try{t.I('comment-p'+postId).focus();}
catch(e){}
return false;},I:function(e){return document.getElementById(e);}}
jQuery(function($){$('.nav li:first-child').addClass('first-child');$('.comment .comment-content p:last-child').addClass('last-child');$('.full').mouseover(function(){$(this).addClass('hover');});$('.full').mouseout(function(){$(this).removeClass('hover');});$('.nav li').mouseover(function(){$(this).addClass('hover');});$('.nav li').mouseout(function(){$(this).removeClass('hover');});if((!$.browser.msie||$.browser.version.substr(0,1)!='6')&&typeof CFCT_AJAX_LOAD!='undefined'&&CFCT_AJAX_LOAD){cfct.ajax_post_content();cfct.ajax_post_comments();}
$('.nav li a').removeAttr('title');});var Attacklab=Attacklab||{}
Attacklab.showdown=Attacklab.showdown||{}
Attacklab.showdown.converter=function(){var g_urls;var g_titles;var g_html_blocks;var g_list_level=0;this.makeHtml=function(text){g_urls=new Array();g_titles=new Array();g_html_blocks=new Array();text=text.replace(/~/g,"~T");text=text.replace(/\$/g,"~D");text=text.replace(/\r\n/g,"\n");text=text.replace(/\r/g,"\n");text="\n\n"+text+"\n\n";text=_Detab(text);text=text.replace(/^[ \t]+$/mg,"");text=_HashHTMLBlocks(text);text=_StripLinkDefinitions(text);text=_RunBlockGamut(text);text=_UnescapeSpecialChars(text);text=text.replace(/~D/g,"$$");text=text.replace(/~T/g,"~");return text;}
var _StripLinkDefinitions=function(text){var text=text.replace(/^[ ]{0,3}\[(.+)\]:[ \t]*\n?[ \t]*<?(\S+?)>?[ \t]*\n?[ \t]*(?:(\n*)["(](.+?)[")][ \t]*)?(?:\n+)/gm,function(wholeMatch,m1,m2,m3,m4){m1=m1.toLowerCase();g_urls[m1]=_EncodeAmpsAndAngles(m2);if(m3){return m3+m4;}else if(m4){g_titles[m1]=m4.replace(/"/g,"&quot;");}
return"";});return text;}
var _HashHTMLBlocks=function(text){text=text.replace(/\n/g,"\n\n");var block_tags_a="p|div|h[1-6]|blockquote|pre|table|dl|ol|ul|script|noscript|form|fieldset|iframe|math|ins|del"
var block_tags_b="p|div|h[1-6]|blockquote|pre|table|dl|ol|ul|script|noscript|form|fieldset|iframe|math"
text=text.replace(/^(<(p|div|h[1-6]|blockquote|pre|table|dl|ol|ul|script|noscript|form|fieldset|iframe|math|ins|del)\b[^\r]*?\n<\/\2>[ \t]*(?=\n+))/gm,hashElement);text=text.replace(/^(<(p|div|h[1-6]|blockquote|pre|table|dl|ol|ul|script|noscript|form|fieldset|iframe|math)\b[^\r]*?.*<\/\2>[ \t]*(?=\n+)\n)/gm,hashElement);text=text.replace(/(\n[ ]{0,3}(<(hr)\b([^<>])*?\/?>)[ \t]*(?=\n{2,}))/g,hashElement);text=text.replace(/(\n\n[ ]{0,3}<!(--[^\r]*?--\s*)+>[ \t]*(?=\n{2,}))/g,hashElement);text=text.replace(/(?:\n\n)([ ]{0,3}(?:<([?%])[^\r]*?\2>)[ \t]*(?=\n{2,}))/g,hashElement);text=text.replace(/\n\n/g,"\n");return text;}
var hashElement=function(wholeMatch,m1){var blockText=m1;blockText=blockText.replace(/\n\n/g,"\n");blockText=blockText.replace(/^\n/,"");blockText=blockText.replace(/\n+$/g,"");blockText="\n\n~K"+(g_html_blocks.push(blockText)-1)+"K\n\n";return blockText;};var _RunBlockGamut=function(text){text=_DoHeaders(text);var key=hashBlock("<hr />");text=text.replace(/^[ ]{0,2}([ ]?\*[ ]?){3,}[ \t]*$/gm,key);text=text.replace(/^[ ]{0,2}([ ]?-[ ]?){3,}[ \t]*$/gm,key);text=text.replace(/^[ ]{0,2}([ ]?_[ ]?){3,}[ \t]*$/gm,key);text=_DoLists(text);text=_DoCodeBlocks(text);text=_DoBlockQuotes(text);text=_HashHTMLBlocks(text);text=_FormParagraphs(text);return text;}
var _RunSpanGamut=function(text){text=_DoCodeSpans(text);text=_EscapeSpecialCharsWithinTagAttributes(text);text=_EncodeBackslashEscapes(text);text=_DoImages(text);text=_DoAnchors(text);text=_DoAutoLinks(text);text=_EncodeAmpsAndAngles(text);text=_DoItalicsAndBold(text);text=text.replace(/  +\n/g," <br />\n");return text;}
var _EscapeSpecialCharsWithinTagAttributes=function(text){var regex=/(<[a-z\/!$]("[^"]*"|'[^']*'|[^'">])*>|<!(--.*?--\s*)+>)/gi;text=text.replace(regex,function(wholeMatch){var tag=wholeMatch.replace(/(.)<\/?code>(?=.)/g,"$1`");tag=escapeCharacters(tag,"\\`*_");return tag;});return text;}
var _DoAnchors=function(text){text=text.replace(/(\[((?:\[[^\]]*\]|[^\[\]])*)\][ ]?(?:\n[ ]*)?\[(.*?)\])()()()()/g,writeAnchorTag);text=text.replace(/(\[((?:\[[^\]]*\]|[^\[\]])*)\]\([ \t]*()<?(.*?)>?[ \t]*((['"])(.*?)\6[ \t]*)?\))/g,writeAnchorTag);text=text.replace(/(\[([^\[\]]+)\])()()()()()/g,writeAnchorTag);return text;}
var writeAnchorTag=function(wholeMatch,m1,m2,m3,m4,m5,m6,m7){if(m7==undefined)m7="";var whole_match=m1;var link_text=m2;var link_id=m3.toLowerCase();var url=m4;var title=m7;if(url==""){if(link_id==""){link_id=link_text.toLowerCase().replace(/ ?\n/g," ");}
url="#"+link_id;if(g_urls[link_id]!=undefined){url=g_urls[link_id];if(g_titles[link_id]!=undefined){title=g_titles[link_id];}}
else{if(whole_match.search(/\(\s*\)$/m)>-1){url="";}else{return whole_match;}}}
url=escapeCharacters(url,"*_");var result="<a href=\""+url+"\"";if(title!=""){title=title.replace(/"/g,"&quot;");title=escapeCharacters(title,"*_");result+=" title=\""+title+"\"";}
result+=">"+link_text+"</a>";return result;}
var _DoImages=function(text){text=text.replace(/(!\[(.*?)\][ ]?(?:\n[ ]*)?\[(.*?)\])()()()()/g,writeImageTag);text=text.replace(/(!\[(.*?)\]\s?\([ \t]*()<?(\S+?)>?[ \t]*((['"])(.*?)\6[ \t]*)?\))/g,writeImageTag);return text;}
var writeImageTag=function(wholeMatch,m1,m2,m3,m4,m5,m6,m7){var whole_match=m1;var alt_text=m2;var link_id=m3.toLowerCase();var url=m4;var title=m7;if(!title)title="";if(url==""){if(link_id==""){link_id=alt_text.toLowerCase().replace(/ ?\n/g," ");}
url="#"+link_id;if(g_urls[link_id]!=undefined){url=g_urls[link_id];if(g_titles[link_id]!=undefined){title=g_titles[link_id];}}
else{return whole_match;}}
alt_text=alt_text.replace(/"/g,"&quot;");url=escapeCharacters(url,"*_");var result="<img src=\""+url+"\" alt=\""+alt_text+"\"";title=title.replace(/"/g,"&quot;");title=escapeCharacters(title,"*_");result+=" title=\""+title+"\"";result+=" />";return result;}
var _DoHeaders=function(text){text=text.replace(/^(.+)[ \t]*\n=+[ \t]*\n+/gm,function(wholeMatch,m1){return hashBlock("<h1>"+_RunSpanGamut(m1)+"</h1>");});text=text.replace(/^(.+)[ \t]*\n-+[ \t]*\n+/gm,function(matchFound,m1){return hashBlock("<h2>"+_RunSpanGamut(m1)+"</h2>");});text=text.replace(/^(\#{1,6})[ \t]*(.+?)[ \t]*\#*\n+/gm,function(wholeMatch,m1,m2){var h_level=m1.length;return hashBlock("<h"+h_level+">"+_RunSpanGamut(m2)+"</h"+h_level+">");});return text;}
var _ProcessListItems;var _DoLists=function(text){text+="~0";var whole_list=/^(([ ]{0,3}([*+-]|\d+[.])[ \t]+)[^\r]+?(~0|\n{2,}(?=\S)(?![ \t]*(?:[*+-]|\d+[.])[ \t]+)))/gm;if(g_list_level){text=text.replace(whole_list,function(wholeMatch,m1,m2){var list=m1;var list_type=(m2.search(/[*+-]/g)>-1)?"ul":"ol";list=list.replace(/\n{2,}/g,"\n\n\n");;var result=_ProcessListItems(list);result=result.replace(/\s+$/,"");result="<"+list_type+">"+result+"</"+list_type+">\n";return result;});}else{whole_list=/(\n\n|^\n?)(([ ]{0,3}([*+-]|\d+[.])[ \t]+)[^\r]+?(~0|\n{2,}(?=\S)(?![ \t]*(?:[*+-]|\d+[.])[ \t]+)))/g;text=text.replace(whole_list,function(wholeMatch,m1,m2,m3){var runup=m1;var list=m2;var list_type=(m3.search(/[*+-]/g)>-1)?"ul":"ol";var list=list.replace(/\n{2,}/g,"\n\n\n");;var result=_ProcessListItems(list);result=runup+"<"+list_type+">\n"+result+"</"+list_type+">\n";return result;});}
text=text.replace(/~0/,"");return text;}
_ProcessListItems=function(list_str){g_list_level++;list_str=list_str.replace(/\n{2,}$/,"\n");list_str+="~0";list_str=list_str.replace(/(\n)?(^[ \t]*)([*+-]|\d+[.])[ \t]+([^\r]+?(\n{1,2}))(?=\n*(~0|\2([*+-]|\d+[.])[ \t]+))/gm,function(wholeMatch,m1,m2,m3,m4){var item=m4;var leading_line=m1;var leading_space=m2;if(leading_line||(item.search(/\n{2,}/)>-1)){item=_RunBlockGamut(_Outdent(item));}
else{item=_DoLists(_Outdent(item));item=item.replace(/\n$/,"");item=_RunSpanGamut(item);}
return"<li>"+item+"</li>\n";});list_str=list_str.replace(/~0/g,"");g_list_level--;return list_str;}
var _DoCodeBlocks=function(text){text+="~0";text=text.replace(/(?:\n\n|^)((?:(?:[ ]{4}|\t).*\n+)+)(\n*[ ]{0,3}[^ \t\n]|(?=~0))/g,function(wholeMatch,m1,m2){var codeblock=m1;var nextChar=m2;codeblock=_EncodeCode(_Outdent(codeblock));codeblock=_Detab(codeblock);codeblock=codeblock.replace(/^\n+/g,"");codeblock=codeblock.replace(/\n+$/g,"");codeblock="<pre><code>"+codeblock+"\n</code></pre>";return hashBlock(codeblock)+nextChar;});text=text.replace(/~0/,"");return text;}
var hashBlock=function(text){text=text.replace(/(^\n+|\n+$)/g,"");return"\n\n~K"+(g_html_blocks.push(text)-1)+"K\n\n";}
var _DoCodeSpans=function(text){text=text.replace(/(^|[^\\])(`+)([^\r]*?[^`])\2(?!`)/gm,function(wholeMatch,m1,m2,m3,m4){var c=m3;c=c.replace(/^([ \t]*)/g,"");c=c.replace(/[ \t]*$/g,"");c=_EncodeCode(c);return m1+"<code>"+c+"</code>";});return text;}
var _EncodeCode=function(text){text=text.replace(/&/g,"&amp;");text=text.replace(/</g,"&lt;");text=text.replace(/>/g,"&gt;");text=escapeCharacters(text,"\*_{}[]\\",false);return text;}
var _DoItalicsAndBold=function(text){text=text.replace(/(\*\*|__)(?=\S)([^\r]*?\S[\*_]*)\1/g,"<strong>$2</strong>");text=text.replace(/(\*|_)(?=\S)([^\r]*?\S)\1/g,"<em>$2</em>");return text;}
var _DoBlockQuotes=function(text){text=text.replace(/((^[ \t]*>[ \t]?.+\n(.+\n)*\n*)+)/gm,function(wholeMatch,m1){var bq=m1;bq=bq.replace(/^[ \t]*>[ \t]?/gm,"~0");bq=bq.replace(/~0/g,"");bq=bq.replace(/^[ \t]+$/gm,"");bq=_RunBlockGamut(bq);bq=bq.replace(/(^|\n)/g,"$1  ");bq=bq.replace(/(\s*<pre>[^\r]+?<\/pre>)/gm,function(wholeMatch,m1){var pre=m1;pre=pre.replace(/^  /mg,"~0");pre=pre.replace(/~0/g,"");return pre;});return hashBlock("<blockquote>\n"+bq+"\n</blockquote>");});return text;}
var _FormParagraphs=function(text){text=text.replace(/^\n+/g,"");text=text.replace(/\n+$/g,"");var grafs=text.split(/\n{2,}/g);var grafsOut=new Array();var end=grafs.length;for(var i=0;i<end;i++){var str=grafs[i];if(str.search(/~K(\d+)K/g)>=0){grafsOut.push(str);}
else if(str.search(/\S/)>=0){str=_RunSpanGamut(str);str=str.replace(/^([ \t]*)/g,"<p>");str+="</p>"
grafsOut.push(str);}}
end=grafsOut.length;for(var i=0;i<end;i++){while(grafsOut[i].search(/~K(\d+)K/)>=0){var blockText=g_html_blocks[RegExp.$1];blockText=blockText.replace(/\$/g,"$$$$");grafsOut[i]=grafsOut[i].replace(/~K\d+K/,blockText);}}
return grafsOut.join("\n\n");}
var _EncodeAmpsAndAngles=function(text){text=text.replace(/&(?!#?[xX]?(?:[0-9a-fA-F]+|\w+);)/g,"&amp;");text=text.replace(/<(?![a-z\/?\$!])/gi,"&lt;");return text;}
var _EncodeBackslashEscapes=function(text){text=text.replace(/\\(\\)/g,escapeCharacters_callback);text=text.replace(/\\([`*_{}\[\]()>#+-.!])/g,escapeCharacters_callback);return text;}
var _DoAutoLinks=function(text){text=text.replace(/<((https?|ftp|dict):[^'">\s]+)>/gi,"<a href=\"$1\">$1</a>");text=text.replace(/<(?:mailto:)?([-.\w]+\@[-a-z0-9]+(\.[-a-z0-9]+)*\.[a-z]+)>/gi,function(wholeMatch,m1){return _EncodeEmailAddress(_UnescapeSpecialChars(m1));});return text;}
var _EncodeEmailAddress=function(addr){function char2hex(ch){var hexDigits='0123456789ABCDEF';var dec=ch.charCodeAt(0);return(hexDigits.charAt(dec>>4)+hexDigits.charAt(dec&15));}
var encode=[function(ch){return"&#"+ch.charCodeAt(0)+";";},function(ch){return"&#x"+char2hex(ch)+";";},function(ch){return ch;}];addr="mailto:"+addr;addr=addr.replace(/./g,function(ch){if(ch=="@"){ch=encode[Math.floor(Math.random()*2)](ch);}else if(ch!=":"){var r=Math.random();ch=(r>.9?encode[2](ch):r>.45?encode[1](ch):encode[0](ch));}
return ch;});addr="<a href=\""+addr+"\">"+addr+"</a>";addr=addr.replace(/">.+:/g,"\">");return addr;}
var _UnescapeSpecialChars=function(text){text=text.replace(/~E(\d+)E/g,function(wholeMatch,m1){var charCodeToReplace=parseInt(m1);return String.fromCharCode(charCodeToReplace);});return text;}
var _Outdent=function(text){text=text.replace(/^(\t|[ ]{1,4})/gm,"~0");text=text.replace(/~0/g,"")
return text;}
var _Detab=function(text){text=text.replace(/\t(?=\t)/g,"    ");text=text.replace(/\t/g,"~A~B");text=text.replace(/~B(.+?)~A/g,function(wholeMatch,m1,m2){var leadingText=m1;var numSpaces=4-leadingText.length%4;for(var i=0;i<numSpaces;i++)leadingText+=" ";return leadingText;});text=text.replace(/~A/g,"    ");text=text.replace(/~B/g,"");return text;}
var escapeCharacters=function(text,charsToEscape,afterBackslash){var regexString="(["+charsToEscape.replace(/([\[\]\\])/g,"\\$1")+"])";if(afterBackslash){regexString="\\\\"+regexString;}
var regex=new RegExp(regexString,"g");text=text.replace(regex,escapeCharacters_callback);return text;}
var escapeCharacters_callback=function(wholeMatch,m1){var charCodeToEscape=m1.charCodeAt(0);return"~E"+charCodeToEscape+"E";}}
var Showdown=Attacklab.showdown;if(Attacklab.fileLoaded){Attacklab.fileLoaded("showdown.js");}
(function($)
{$('#ad-leaderboard-top').rad({maxWidth:"728"});$('#home-small-lb').rad({maxWidth:"468"});$('#ad-leaderboard-bottom').rad({maxWidth:"970"});$(document).ready(function()
{activateTabbedWidgets();$('.home .videos .carousel').carousel({paginationContainerSelector:'.home .videos .carousel-pagination'});$('.home .opinion .carousel').carousel({paginationContainerSelector:'.home .opinion .carousel-pagination'});$('.letters-widget .carousel').carousel({paginationContainerSelector:'.letters-widget .carousel-pagination'});$('.home .slideshows .carousel').carousel({paginationContainerSelector:'.home .slideshows .carousel-pagination'});$('.home .elections2013 .carousel').carousel({paginationContainerSelector:'.home .elections2013 .carousel-pagination'});$('.home .political-figures .carousel').carousel({paginationContainerSelector:'.home .political-figures .carousel-pagination'});$('ul.tabs li').click(function(){setTimeout('moveAds()',100);});$('.container').bind('ajaxComplete',function(){setTimeout('moveAds()',500);});if($('.ad-loader').length>1)
{var hoverInterval=new Array;$('.ad-loader').each(function()
{if($(this).find('div').length>0)
{var target=$(this).attr('class').match(/for-([a-z\-]+)/);if(target.length<=1)return;var $target=$('#'+target[1]);if($target.length<=0)return;$target.parent().show();var o=$target.offset();var offsetTop=(typeof(o.top)=='number')?o.top:getTopOffSet($target);var offsetLeft=(typeof(o.left)=='number')?o.left-$('.container').offset().left-parseInt($('.container').css('border-left-width')):getLeftOffSet($target)-getLeftOffSet($('.container'));var $source=$(this);var sourceId=$source.attr('id');var $embed=$source.find('embed');if($embed.length==0)
$embed=$source.find('object');if($embed.length>0)
{$(this).css('z-index',0);$source.data('targetHeight',$target.height());$source.hover(function(e){hoverInterval[sourceId]=setInterval(function()
{$source.height('auto');if($source.height()!=$target.height())
{var $nextAllAdLoader=$source.nextAll('.ad-loader');if($nextAllAdLoader.length>0)
{var heightDiff=0;if($source.height()>$target.height())
heightDiff=parseInt($source.height())-parseInt($target.height());else
heightDiff=parseInt($target.height())-parseInt($source.height());if(heightDiff>0)
{$nextAllAdLoader.each(function()
{var top=parseInt($(this).css('top'));var newtop;if($source.height()>$target.height())
newtop=top+heightDiff
else
newtop=top-heightDiff;if(top>0)$(this).css('top',newtop+'px');});}}
$target.height($source.height());}
else $source.height($source.data("targetHeight"));},400);});setTimeout(function(){$source.trigger('mouseover');},1000);}
$(this).css({'top':offsetTop+parseInt($target.css('border-top-width')),'left':offsetLeft+parseInt($target.css('border-left-width')),'height':$target.height(),'width':$target.width(),'position':'absolute'});}});}
if(window.name=='_email_popup')window.onload=null;else
{$('.email-friend').click(function()
{var width=480;var height=470;var left=(screen.width-width)/2;var top=(screen.height-height)/2;popupWindow=window.open($(this).attr('href'),'_email_popup',"width="+width+",height="+height+",toolbar=0,menubar=0,location=0,resizable=0,scrollbars=1,status=0,left="+left+",top="+top+"");if(window.focus)popupWindow.focus();return false;});}});$(window).load(function(){if($('.ad-loader').length>1)
{$('.ad-loader').each(function()
{if($(this).find('div').length>0)
{var target=$(this).attr('class').match(/for-([a-z\-]+)/);if(target.length<=1)return;if($('#'+target[1]).length>0)$(this).show();}});}});$('.read-full-story-button').click(function(){$('div').removeClass('read-full');});})(jQuery);window.onload=showMap;function showMap()
{$map=document.getElementById("map");if($map&&typeof GMap!='undefined')
{$map.style.background='';var map=new GMap($map);var lat=67.079477;var lng=24.831660;map.addControl(new GSmallMapControl());map.centerAndZoom(new GPoint(lat,lng),3);map.addOverlay(new GMarker(new GPoint(lat,lng)));}}
function activateTabbedWidgets()
{jQuery('ul.tabs').tabs('div.tabs-content');}
function smartenInputs()
{var temp=document.createElement('input');var isPlaceholderSupported='placeholder'in temp;if(isPlaceholderSupported)return;jQuery('input').each(function(){var curr=jQuery(this);var placeholder=curr.attr('placeholder');if(curr.val()==''&&placeholder!=undefined&&placeholder!='')
{curr.val(placeholder);curr.focus(function(){if(curr.val()==placeholder)curr.val('');});curr.blur(function(){if(curr.val()=='')curr.val(placeholder);});}});}
function moveAds()
{var $ads=jQuery('.ad-loader');for(var i=0;i<$ads.length;i++)
{var $source=jQuery($ads[i]);var has_ad=($source.find('div').length==0)?false:true;if(has_ad)
{var target=$source.attr('class').match(/for-([a-z\-]+)/);target=target[1];var $target=jQuery('#'+target);$target.parent().show();var o=$target.offset();var offsetTop=o.top+parseInt($target.css('border-top-width'));var offsetLeft=o.left+parseInt($target.css('border-left-width'))-jQuery('.container').offset().left;if($source.height()!=$target.height()&&parseInt($source.height())>0)
{$source.data('actualHeight',$source.height());$source.data('targetHeight',$target.height());$source.mouseover(function(){$target.height(jQuery(this).data("actualHeight"));$source.height(jQuery(this).data("actualHeight"));}).mouseout(function(){$target.height(jQuery(this).data("targetHeight"));$source.height(jQuery(this).data("targetHeight"));}).css('overflow','hidden');}
$source.css({'top':offsetTop,'left':offsetLeft,'height':$target.height(),'width':$target.width()});}}}
function showAds()
{var $ads=jQuery('.ad-loader');for(var i=0;i<$ads.length;i++)
{var $source=jQuery($ads[i]);if($source.find('div').length>0)
$source.show();}}
function getTopOffSet(obj)
{var offset=0;while(obj.parentNode)
{offset+=(obj.offsetTop)?obj.offsetTop:0;if(obj==document.body)break;obj=obj.parentNode;}
return offset;}
function getLeftOffSet(obj)
{var offset=0;while(obj.parentNode)
{offset+=(obj.offsetLeft)?obj.offsetLeft:0;if(obj==document.body)break;obj=obj.parentNode;}
return offset;}