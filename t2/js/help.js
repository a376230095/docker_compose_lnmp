var pltsPop=null;
var pltsoffsetX = 3;   // 弹出窗口位于鼠标左侧或者右侧的距离；3-12 合适
var pltsoffsetY = 5; // 弹出窗口位于鼠标下方的距离；3-12 合适
var pltsPopbg="#F6FDDC"; //背景色
var pltsPopfg="#DEDBDE"; //前景色
var pltsTitle=""

document.write('<div id="pltsTipLayer" style="display: none;position: absolute; z-index:10001"></div>');
var pltsTipLayer=document.getElementById("pltsTipLayer");
function pltsinits()
{
    document.onmouseover   = plts;
    document.onmousemove = moveToMouseLoc;
}
function plts(e)
{
if(e){o=e.target;MouseX=e.pageX;MouseY=e.pageY} else{o=event.srcElement;MouseX=event.x;MouseY=event.y}

    if(o.alt!=null && o.alt!=""){o.dypop=o.alt;o.alt=""};
    if(o.title!=null && o.title!=""){o.dypop=o.title;o.title=""};
    pltsPop=o.dypop;
    if(pltsPop!=null&&pltsPop!=""&&typeof(pltsPop)!="undefined")
    {
    pltsTipLayer.style.left=-1000;
    pltsTipLayer.style.display='';
    var Msg=pltsPop.replace(/\n/g,"<br>");
    Msg=Msg.replace(/\0x13/g,"<br>");
    var re=/\{(.[^\{]*)\}/ig;
    if(!re.test(Msg))pltsTitle=pltsTitle;
    else{
    re=/\{(.[^\{]*)\}(.*)/ig;
    pltsTitle=Msg.replace(re,"$1")+"&nbsp;";
    re=/\{(.[^\{]*)\}/ig;
    Msg=Msg.replace(re,"");
    Msg=Msg.replace("<br>","");}
    if (Msg.indexOf('img src=')<0){
        Msg = "<ul>" + Msg + "</ul>"
    }
           var content =
          '<table border=0 cellspacing=0 cellpadding=0 id=toolTipTalbe >'+
          '<tr><td><span id=pltsPoptop><span id=topleft style="float:left">'+pltsTitle+'</span><span id=topright style="display:none;float:right;">'+pltsTitle+'</span></td></tr>'+
          '<tr><td class="Bttd"><div>'+Msg+'</div></td></tr>'+
          '<tr><td><span id=pltsPopbot style="display:none"><b><span id=botleft align=left>'+pltsTitle+'</span><span id=botright align=right style="display:none;float:right;">'+pltsTitle+'</span></td></tr></table>';
           pltsTipLayer.innerHTML=content;
           document.getElementById("toolTipTalbe").style.width=Math.min(pltsTipLayer.clientWidth,document.body.clientWidth/2.2) + "px";
           moveToMouseLoc(e);
           return true;
       }
    else
    {
        pltsTipLayer.innerHTML='';
          pltsTipLayer.style.display='none';
           return true;
    }
}

function moveToMouseLoc(e)
{
if(e){MouseX=e.pageX;MouseY=e.pageY;}else{MouseX=event.clientX;MouseY=event.clientY;}
if(pltsTipLayer.innerHTML=='')return true;
    var popHeight=pltsTipLayer.clientHeight;
    var popWidth=pltsTipLayer.clientWidth;
    if(MouseY+pltsoffsetY+popHeight>document.body.clientHeight)
    {
        popTopAdjust=-popHeight-pltsoffsetY*1.5;
        document.getElementById("pltsPoptop").style.display="none";
        document.getElementById("pltsPopbot").style.display="";
    }
    else
    {
           popTopAdjust=0;
        document.getElementById("pltsPoptop").style.display="";
        document.getElementById("pltsPopbot").style.display="none";
    }
    if(MouseX+pltsoffsetX+popWidth>document.body.clientWidth)
    {
        popLeftAdjust=-popWidth-pltsoffsetX*2;
        document.getElementById("topleft").style.display="none";
        document.getElementById("botleft").style.display="none";
        document.getElementById("topright").style.display="";
        document.getElementById("botright").style.display="";
    }
    else
    {
        popLeftAdjust=0;
        document.getElementById("topleft").style.display="";
        document.getElementById("botleft").style.display="";
        document.getElementById("topright").style.display="none";
        document.getElementById("botright").style.display="none";
    }
    pltsTipLayer.style.left=MouseX+pltsoffsetX+document.body.scrollLeft+popLeftAdjust + "px";
        if (navigator.userAgent.indexOf("MSIE")<=0){
            pltsTipLayer.style.top=MouseY+pltsoffsetY+popTopAdjust + "px";
        }else{
            pltsTipLayer.style.top=MouseY+pltsoffsetY+document.body.scrollTop+popTopAdjust + "px";
        }
                    //alert(pltsTipLayer.style.top);
    return true;
}
pltsinits();

