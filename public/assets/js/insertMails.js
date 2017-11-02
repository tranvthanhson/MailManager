

    $(document).ready(function(){
//         $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });
        $("#submit_get").click(function(){
        //alert('OK');
        var tukhoa =$('#emailContent').val();
        // alert(tukhoa);
        $.ajax({
            url : "/storeEmail",
            type : "POST",
            data : {
                '_token': $('input[name=_token]').val(),
                tukhoa : tukhoa
           },
           success : function (result){
                // alert(result);
                $('.ajaxsanpham').html(result);
            },
            error: function(err){
                alert(err+'sfsdfdf');
            }
    });

    });
    });
