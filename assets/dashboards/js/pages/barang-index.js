$(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });

function showModal(target,index,tipe){
    var urlx = '';
    var datax = '';
    if (tipe == 'add')
    {
      urlx = target;
      datax= {};
    }else{
      urlx = target;
      datax = {id:index};
    }
   
    $.post(urlx, datax , function(mod) {
        $('#tampilModal').html(mod);
        $('#myModal').modal({show: true , backdrop : true , keyboard: true});
    });

}

$(document).on("click", "#submit-dokumen", function () {
  $("#dokumen-form").validate({
    rules: {
      nama: {
        required: true
      },
      buy: {
        required: true,
        digits: true
      },
      sale: {
        required: true,
        digits: true
      },
      qty: {
        required: true,
        digits: true
      }
    },
    messages: {
      nama: {
        required: "Insert your name"
      },
      buy: {
        required: "Insert your buy"
      },
      sale: {
        required: "Insert your sale"
      },
      qty: {
        required: "Insert your qty"
      }
    },
    submitHandler: function () {
      var post_data = new FormData($('#dokumen-form')[0]);
      $.ajax({ 
        url : $('#dokumen-form').attr("action"),
        type: "POST",
        data : post_data,
        contentType: false,
        cache: false,
        processData:false,
        dataType:"JSON",
        success: function(data) {
          if (data.code == 200)
          {
            swal(data.message, '', 'success');
            setTimeout("location.reload(true);",1000);
          }else{
            swal(data.message,'','error');
          }
        },
        error: function(data){
          swal(data.message,'','error');
        }
      });
    }
  });
});