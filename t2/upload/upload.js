function showUpload(a,c,b){
            tid="#"+a;
            processid=getID();
            //$(tid).parent().prepend(" <img src='https://img.lanrentuku.com/img/allimg/1212/5-121204193R7.gif' width='16' height='16'> ");
            $(tid).parent().append("<input type='file' id='testFile"+a+"' name='video' style='display:none;' onchange='aaa(\""+a+"\",\""+b+"\",\""+c+"\")'/>");
            $("#testFile"+a).trigger("click");
}

function aaa(a,b,c){
    const LENGTH = 1024 * 1024 * 2;//每次上传的大小 
      var file = document.getElementsByName('video')[0].files[0];//文件对象 
      var filename=document.getElementsByName('video')[0].files[0].name; 
      var totalSize = file.size;//文件总大小 
      var start = 0;//每次上传的开始字节 
      var end = start + LENGTH;//每次上传的结尾字节 
      var fd = null//创建表单数据对象 
      var blob = null;//二进制对象 
      var xhr = null;//xhr对象 
      while(start < totalSize){ 
        blob = file.slice(start,end);
        var form = new FormData();
        form.append("video", blob);
        form.append("filename", filename);
        form.append("size", totalSize);
        $.ajax({  
         url: "../upload/upfile.php?path="+b.replace("..","@@")+"&processid=AN"+processid+"&id="+a,
         type: 'POST',  
         data: form,  
         async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (msg) {
            start = end; 
            end = start + LENGTH; 
            if(msg!=""){
              if(msg.split("|")[0]=="error"){
                alert(msg.split("|")[1]);
              }else{
                if(a=="P_file"){
                  $(tid).val(c+"/media/"+msg);
                }else{
                  $(tid+"x").attr("src",b+"/"+msg);
                  $(tid+"x").attr("alt","<img src='"+b+"/"+msg+"' class='showpicx'>");
                  $(tid).val(msg);
                }
                $("#testFile"+a).remove();
              }
            }else{
                //$(tid).val("已上传："+(start/totalSize)+"%");
            }
         },  
         error: function (msg) {  
            console.log(msg);
         }  
    });
      }
    
}
function getID(){var mydt=new Date();with(mydt){var y=getYear();if(y<10){y='0'+y}var m=getMonth()+1;if(m<10){m='0'+m}var d=getDate();if(d<10){d='0'+d}var h=getHours();if(h<10){h='0'+h}var mm=getMinutes();if(mm<10){mm='0'+mm}var s=getSeconds();if(s<10){s='0'+s}}var r="000" + Math.floor(Math.random() * 1000);r=r.substr(r.length-4);return y + m + d + h + mm + s + r;};