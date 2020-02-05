var table;
$(document).ready(function(){
  table = $('#table').DataTable({ 
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
        "url": "home/table",
        "type": "POST"
    },
    "columnDefs": [{ 
        "targets": [-1],
        "orderable": false,
    },],
  });

  $(document).on('click',"#submit-dokumen",function(){
    $("#dokumen-form").validate({
      rules: {
        nama: {
          required: true
        },
        buy: {
          required: true,
          digits: true
        }
      },
      messages: {
        nama: {
          required: "Please type here"
        },
        buy: {
          required: "Please type here"
        }
      },
      submitHandler: function () {
        var id = $("#id").val();
        if(!id){
          var url = $('#dokumen-form').attr("action"); 
        }else{
          var url = $('#dokumen-form').attr("action")+"/"+id;
        }
        $.ajax({
          type: "POST",
          url: url,
          dataType : "JSON",
          data: $('#dokumen-form').serialize(),
          success:function(data){
            if (data.code == 200) {
              $("#myModal").modal('hide');
              swal(data.message, '', 'success');
            }else{
              swal(data.message,'','error');
            }
            table.ajax.reload(null,false);
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            swal('Error proses data !','','error');
          }
        });
      }
    });
  });

  $(document).on('click',"#delete",function(){
    var id = $(this).data('id');
    swal({
      title: "Anda Yakin?",
      text: "Data Akan Dihapus Secara Permanen!",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false
    }).then(function() {
      $.post("home/delete/"+id, function(result){
        var data = JSON.parse(result);
        if (data.code == 200){
          $("#myModal").modal('hide');
          swal(data.message, ' ', 'success');
        }else{
          swal(data.message, ' ', 'error');
        }
        table.ajax.reload(null,false);
      });
    })
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