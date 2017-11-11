@foreach ($mails as $mail):
<tr style="display: block;">
    <td style="width: 50%; display: block; float:left;">{{ $mail->mail . '@' .$mail->extension_content }}</td>
    <td style="width: 50%; display: block; float:left; text-align: right;">
        <a data-toggle="modal" data-target="#editEmail' . $getEmail->mail_id . '" href="" class="btn btn-success btn-sm" title="Sửa">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        </a>
        <!-- Modal -->
        <div class="modal fade" id="editEmail{{$mail->mail_id}}" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">UPDATE EMAIL</h4>
                    </div>
                    <form action="/updateEmail/{{$mail->mail_id}}" method="POST" >
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{$mail->mail}}" id="" placeholder="Enter mail">
                            </div>
                            <div class="form-group">
                                <input type="text" value="{{$mail->extension_content}}" class="form-control" id="" placeholder="Enter extension">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary"  value="Update" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <button class="btn btn-danger btn-sm delete" title="Xoá" value="{{ $mail->mail_id }}">
            <i class="fa fa-trash" aria-hidden="true"></i>
        </button>
        <div class="clearfix"></div>
    </td>
</tr>
@endforeach
<script>
   $('.delete').click(function (){
    var mail_id = this.value;
    $.ajax({
        url : "{{ route('home.delete') }}",
        type : "POST",
        data : {
            id: mail_id
        },
        success : function (result){
            $('#emailsTable').html(result);
            loadExtensions();
        },
        error: function(err){
            loadExtensions();
            alert(err);
        }
    });
});
</script>
