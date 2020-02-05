$(document).ready(function(){
    table();
    function table(){
      $.ajax({
        type  : 'ajax',
        url   : 'home/table',
        dataType : 'json',
        success : function(data){
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html += 
                `<tr>
                  <td align="center">`+(i+1)+`</td>
                  <td>`+data[i].nama+`</td>
                  <td>`+data[i].buy+`</td>
                  <td>`+data[i].sale+`</td>
                  <td>`+data[i].qty+`</td>
                  <td align="center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">
                        <i class="fa fa-cog"></i>
                      </button>
                      <div class="dropdown-menu">
                        <button data-name="edit" class="btn-act dropdown-item" 
                        href="home/form/`+data[i].id+`"> <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn-act dropdown-item" 
                        id="delete" data-id="`+data[i].id+`"> <i class="fa fa-trash"></i> Delete
                        </button>
                      </div>
                    </div>
                  </td>
                </tr>`
            }
            $('#table').html(html);
        }
      }).fail(function(){});
    }
  
    $(document).on('click',"#submit-dokumen",function(){
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
            required: "Please type here"
          },
          buy: {
            required: "Please type here"
          },
          sale: {
            required: "Please type here"
          },
          qty: {
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
            data: {
              nama: $("#nama").val(),
              buy: $("#buy").val(),
              sale: $("#sale").val(),
              qty: $("#qty").val()
            },
            success:function(data){
              if (data.code == 200) {
                $("#myModal").modal('hide');
                swal(data.message, '', 'success');
              }else{
                $("#myModal").modal('hide');
                swal(data.message,'', 'error');
              }
              table();
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
            $("#myModal").modal('hide');
            swal(data.message, ' ', 'error');
          }
          table(); 
        });
      })
    });
    
    $(document).on("click", ".btn-act",function(){
          var name = $(this).data('name');
          if (name=='add') {
        $("#myModal .modal-title").html("Tambah Data");
        $("#myModal .modal-body").load($(this).attr('href'));
        $("#myModal").modal('show');
        var href = $(this).attr("href");
      }
      if (name=='edit') {
        $("#myModal .modal-title").html("Edit Data");
        $("#myModal .modal-body").load($(this).attr('href'));
        $("#myModal").modal('show');
      }
    });
  });