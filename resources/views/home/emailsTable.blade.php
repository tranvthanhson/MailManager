@foreach ($mails as $mail)
<tr style="display: block;">
    <td style="width: 50%; display: block; float:left;">{{ $mail->mail.'@'.$mail->extension_content }}</td>
    <td style="width: 50%; display: block; float:left; text-align: right;">
<<<<<<< HEAD
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
       <input type="submit" id="deleteEmail" onclick="deleteEmail({{$mail->mail_id}})"  class="btn btn-danger btn-sm" value="Xoá">

       <div class="clearfix"></div>
   </td>
</tr>
@endforeach
=======
        <a data-toggle="modal" data-target="#editEmail{{$mail->mail_id}}" href="" class="btn btn-success btn-sm" title="Sửa">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        </a>
        <div class="modal fade" id="editEmail{{$mail->mail_id}}" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="text-align: center; color: #7f8c8d;">UPDATE EMAIL</h4>
                        <button type="button" class="close" data-dismiss="modal" style="margin-top: -40px;">&times;</button>
                    </div>
                    <form action="{{route('home.updateEmail', ['id'=>$mail->mail_id])}}" method="POST" >
                        {{ csrf_field()}}
                        <div class="modal-body">
                            <div class="form-group">
                                <p style="float: left; color: #7f8c8d;">Mail</p>
                                <input type="text" class="form-control" name="mail" value="{{$mail->mail}}" placeholder="Enter mail">
                            </div>
                            <div class="form-group">
                                <p style="float: left; color: #7f8c8d;">Extension</p>
                                <input type="text" name="extension_content"  class="form-control" value="{{$mail->extension_content}}" id="" placeholder="Enter extension">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Update" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- <input id="mailId" type="hidden" value="{{$mail->mail_id}}"> --}}
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
>>>>>>> dev
