// JavaScript Document
(function($){
  $.zAutocomplete = function(options){
      var def = {
          selector    :   "#keyword",
          dataHidden  :   "#mID",
          text        :   "Enter your keywords...",
          result      :   "#result",
          record      :   5,
          minChar     :   2,
          linkType    :   false,            
            }
    options = $.extend(def,options);      
    //console.log(options);
    //khai báo các biến
    var selector   = $(options.selector);
    var dataHidden = $(options.dataHidden);
    var result     = $(options.result);
    
            
    addValue();
    
    //khi click vao thi xoa chu Enter your keywords...
    selector.on("click focus",function(){
      if(selector.val()  == options.text){
          selector.val('')
              .css({"font-style":"","color":""});
        }
      }).blur(function(){
        addValue();
        $(result).delay(1000).slideUp(300);
      })
    
    //khi ky tu trong keyword > minChar
    selector.on("keyup",function(){
      if($(this).val().length > options.minChar){
          //console.log($(this).val());
          $.ajax({
              url   : "/admin/slider/autocomplete",
              type  : "POST",
              dataType: "json",
              data  : {
                    "keyword" : selector.val(),
                    "record"  : options.record
                    }
              }).done(function(data_get){
                  setDivResult();
                  var text  = listItem(data_get);
                  result.html(text);
                  var selec = options.result + " ul li";
                  $(selec).on("mouseover mouseleave", function(){
                      $(this).toggleClass("bg02");
                    })
                  if(options.linkType == false){
                      $(selec).on("click",function(){
                        $(selector).val($(this).text());
                        $(dataHidden).val($(this).attr("id"));
                      })
                  }                 
                })
        }
      })    
    //các hàm trong plugin
    function listItem(data){
      var str ="" 
      str   += "<ul>";
      if(data.length >0){
        $.each(data,function(index,value){
          var Ttitle  = value.name;
          var Tid     = value.id;
          if(options.linkType == false){
            str +=  "<li id='"+ Tid +"' title='" + Ttitle + "'>"  + Ttitle +  "</li>";
          }else{
            str +=  "<li title='" + Ttitle + "' ><a href='"+ Tlink +"'>"+ Ttitle +"</a></li>";  
          }
        })
      }else{
        str +=  "<li>No record</li>"; 
      }
      
      str += "</ul>";
      return str;
    }
    
    function addValue(){
      if(selector.val() == ""){
        selector.val(options.text)
            .css({"font-style" : "italic","color" : "#ccc"});
      }
    }
    
    function setDivResult(){
      result.css({
          left    :   selector.offset().left + 100,
          top     :   selector.offset().top + selector.outerHeight(),
          width   :   selector.outerWidth(),
          position: "absolute important!",
          display : "block"
        })
        
    }
            
  } 
})(jQuery)

$(document).ready(function(){
  $.zAutocomplete();
})