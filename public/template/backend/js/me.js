//------------------CUSTOM----------------------------------//
function submitForm(url){
  if(url != null){
    $("#adminForm").attr("action",url);
  }
  $("#adminForm").submit();
}
function sortList(orderBy,order){ 
  $("input[name=order]").val(order);       
  $("input[name=order_by]").val(orderBy);       
  submitForm();
}

function changeStatus(id,status){
  var linkSubmit = $("#adminForm").attr("action").replace(/filter/gi,"status")
  $("input[name=id]").val(id);       
  $("input[name=status]").val(status);  
  submitForm(linkSubmit);
}

function changeGroupAcp(id,status){
  var linkSubmit = $("#adminForm").attr("action").replace(/filter/gi,"groupAcp")
  $("input[name=id]").val(id);       
  $("input[name=status]").val(status);  
  submitForm(linkSubmit);
}

function changeMultiStatus(type){
  var linkSubmit = $("#adminForm").attr("action").replace(/filter/gi,"status")
  $("input[name=status]").val(type); 
  submitForm(linkSubmit);
}

function changeOrdering(type){
  var linkSubmit = $("#adminForm").attr("action").replace(/filter/gi,"ordering")
  submitForm(linkSubmit);
}

function changeSpecial(id,status){
  var linkSubmit = $("#adminForm").attr("action").replace(/filter/gi,"special")
  $("input[name=id]").val(id);       
  $("input[name=status]").val(status);  
  submitForm(linkSubmit);
}

function addBadgeForStatus(item){
    $("a[data-show=yes]").prepend("<span class='badge bg-aqua'>"+item+"</span>")
    if(item == null){
        $("a[data-show=yes] > span").remove();
    }
}

function deleteMulti(){
    if(!window.confirm("Bạn có chắc muốn xóa ?")){
      return false;
    }
    var linkSubmit = $("#adminForm").attr("action").replace(/filter/gi,"delete")
    submitForm(linkSubmit);
}

function saveAction(type){
  $("input[name=action]").val(type);
  submitForm();
}

function moveNode(id,type){
  var linkSubmit = $("#adminForm").attr("action").replace(/filter/gi,"changeMoveNode")
  $("input[name=id]").val(id);       
  $("input[name=status]").val(type);  
  submitForm(linkSubmit);
}

$(document).ready(function(){

        //event for Button    
        $("a[data-type=ordering]").click(function(){
          changeOrdering();
        })
        $("a[data-type=active]").click(function(){
          changeMultiStatus(1);
        })
        $("a[data-type=inactive]").click(function(){
          changeMultiStatus(0);
        })
        $("a[data-type=delete]").click(function(){
          deleteMulti();
        })
        $("a[data-type=save]").click(function(){
          saveAction("save");
        })
        $("a[data-type=save-close]").click(function(){
          saveAction("save-close");
        })
        $("a[data-type=save-new]").click(function(){
          saveAction("save-new");
        })


        //fadeOut alert
        $(".alert-dismissable").fadeOut(6000);

        $("select[name=filter_status]").on("change",function(){
          submitForm();
        })
        $("select[name=filter_group_acp]").on("change",function(){
          submitForm();
        })
        $("select[name=filter_group]").on("change",function(){
          submitForm();
        })
        $("select[name=filter_special]").on("change",function(){
          submitForm();
        })
        $("select[name=filter_level]").on("change",function(){
          submitForm();
        })
        $("select[name=filter_category]").on("change",function(){
          submitForm();
        })

        //nhấn enter submit luôn
        $("input[name=search_value]").keypress(function(e){
          if(e.keyCode == 13){
            e.preventDefault();
            submitForm();
          }
        })
      //CHECK ALL
          //Enable check and uncheck all functionality
          $(".checkbox-toggle").click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
                $("input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                //remove badge
                addBadgeForStatus(null);
            }else {
                $("input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
                //add bage
                var item = $("input.check-box:checked").length;
                addBadgeForStatus(item);
            }
            $(this).data("clicks", !clicks);
          });

          var count = 0;
          $(".check-box").click(function(){
              addBadgeForStatus(null);
              count = $(".check-box:checked").length;
              if(count == 0) count = null;
              addBadgeForStatus(count);

          })


})


