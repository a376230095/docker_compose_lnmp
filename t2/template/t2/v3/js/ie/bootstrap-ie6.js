//IE6/7下对bootstrap3的修正
(function () {
   var bootstrapFileName=/bootstrap(\.min)?\.css$/;
   var bootstrap;
   var getBootStrapSheet = function () {
      if(!bootstrap){
         for (var c = 0; c < document.styleSheets.length; c++) {
            var stylesheet = document.styleSheets[c];
            if (stylesheet.href && stylesheet.href != '') {
               url = stylesheet.href;
               var csstext;
               if (url && bootstrapFileName.test(url)) {
                  bootstrap = stylesheet
               }
            }
         }         
      }
      return bootstrap;
   }

var  getCSSRule=function(ruleName, deleteFlag) {
   ruleName = ruleName.toLowerCase();
   var styleSheet = getBootStrapSheet();
   if (styleSheet) {
         var ii = 0;
         var cssRule = false;
         do {
            if (styleSheet.cssRules) {
               cssRule = styleSheet.cssRules[ii];
            } else {
               cssRule = styleSheet.rules[ii];
            }
            if (cssRule) {
               if (cssRule.selectorText && cssRule.selectorText.toLowerCase() == ruleName) {
                  if (deleteFlag == 'delete' || deleteFlag == 'remove' ) {
                     if (styleSheet.cssRules) {
                        styleSheet.deleteRule(ii);
                     } else {
                        styleSheet.removeRule(ii);
                     }
                     //return true;
                  } else {
                     return cssRule;
                  }
               }
            }
            ii++;
         } while (cssRule)
   }
   return false;
}
var  removeCSSRule=function(ruleName) {
   return getCSSRule(ruleName, 'delete');
}
var  addCSSRule=function(ruleName) {
   if (document.styleSheets) {
      if (!getCSSRule(ruleName)) {
         if (document.styleSheets[0].addRule) {
            document.styleSheets[0].addRule(ruleName, null, 0);
         } else {
            document.styleSheets[0].insertRule(ruleName + ' { }', 0);
         }
      }
   }
   return getCSSRule(ruleName);
}

   var init = function () {
      //bootstrap中的.list-group-item.active及.list-group-item.active:hover被当成了
      //.active，样式不对，去掉之
      removeCSSRule('.active');
      removeCSSRule('.active:hover');
   }

   init()
})()


