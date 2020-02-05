function confirms(judul,pesan,aksi,val)
{
    swal({
      title: judul,
      text: pesan,
      type: 'question',
      showCancelButton: true,
      confirmButtonText: judul,
      cancelButtonText: 'Close !',
      confirmButtonColor: '#1E88E5',
      cancelButtonColor: '#C62828',
     
    }).then(function() {
      $.post(aksi, {id:val}, function(result){
          var res = JSON.parse(result);
          if (res.code == 200){
            swal({
                title: "Success !",
                text: res.pesan,
                confirmButtonColor: '#1E88E5',
                type: "success",
               
            });
            eval(res.aksi);
          }else{
             swal({
                title: "Fail !",
                text: "Process Failed !",
                confirmButtonColor: '#C62828',
                type: "error",
              
             });
            setTimeout("location.reload(true);",1000);
          }
        });
    }, function(dismiss) {
      // dismiss can be 'cancel', 'overlay', 'close', 'timer'
      if (dismiss === 'cancel') {
        swal({
            title: "Canceled",
            text: "Process Canceled !",
            confirmButtonColor: '#C62828',
            
            type: "error"
        });
      }
    })
}

function notif(head,pesan,tipe)
    {

        $.jGrowl(pesan, {
            header: head,
            theme: 'alert-styled-right '+tipe,
            life:5000,
            animateOpen: { 
				height: "show",
				width: "show"
			},
			animateClose: { 
				height: "hide",
				width: "show"
			}
        });
    }