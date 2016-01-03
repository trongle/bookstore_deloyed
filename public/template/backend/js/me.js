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
  $("input[name=id]").val(id);       
  $("input[name=status]").val(status);  
  submitForm("/admin/group/status");
}
function changeMultiStatus(type){
  $("input[name=status]").val(type); 
  submitForm("/admin/group/status");
}

function addBadgeForStatus(item){
    $(".btn-status").prepend("<span class='badge bg-aqua'>"+item+"</span>")
    if(item == null){
        $(".btn-status > span").remove();
    }
}

function deleteMulti(){
    if(!window.confirm("Bạn có chắc muốn xóa ?")){
      return false;
    }
    submitForm("/admin/group/delete");
}

$(document).ready(function(){
  //fadeOut alert
  $(".alert-dismissable").fadeOut(3000);


  $("select[name=filter_status]").on("change",function(){
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

