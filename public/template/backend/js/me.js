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
//iCheck for checkbox and radio inputs
    $('.mailbox-messages input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
        $("input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
      } else {
        //Check all checkboxes
        $("input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
      }
      $(this).data("clicks", !clicks);
    });
})

