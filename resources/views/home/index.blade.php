@extends('layouts.master')

@section('master.content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(Session::has('msg'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ Session::get('msg') }}</li>
                    </ul>
                </div>
                @endif
                <div class="card">
                    <div class="header">
                        <h4 class="title">Mailer</h4>
                    </div>
                    <form method="POST" action="javascript:void(0)">
                        {{ csrf_field() }}
                        <div class="content">
                            <div class="form-group" style="padding: 20px;">
                                <div class="row">
                                    <textarea  class="form-control" id="emailContent" name="emails" style="width: 100%; height: 50vh; resize: none; border: 1px solid black;"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit"  id="addEmails" name="insertEmail" class="btn btn-default btn-full btn-radius" style="border:1px solid black;" value="Submit" />
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Mail Manager</h4>
                    </div>
                    <div class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control border-input" id="extensions">
                                        <option value="all">All</option>
                                        @foreach ($extensions as $extension)
                                        <option value="{{$extension->extension_content}}">{{$extension->extension_content}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input id="searchBox" class="form-control border-input" name="teacher" placeholder="Search">
                            </input>
                        </div>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-striped border-solid-black" >
                            <thead>
                                <tr>
                                    <th style="width: 50%; display: block; float:left;">Mail</th>
                                    <th style="width: 50%; display: block; float:left; text-align: center;">Options</th>
                                </tr>
                            </thead>
                            <tbody id="emailsTable" style="display: block; height: 500px; overflow-y: auto;">
                                @foreach ($mails as $mail)
                                <tr style="display: block;">
                                    <td style="width: 50%; display: block; float:left;">{{ $mail->mail.'@'.$mail->extension_content }}</td>
                                    <td style="width: 50%; display: block; float:left; text-align: right;">
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('master.js')
<script>
    var fetchEmailsTable = function() {
        var email = $('#searchBox').val().toLowerCase();
        var extension = $('#extensions').val().toLowerCase();
        // console.log(email + " " + extension);
        $.ajax({
            url : "/search",
            type : "POST",
            data : {
                email: email,
                extension: extension
            },
            success : function (result){
                $('#emailsTable').html(result);
            },
            error: function(err){
                alert(err);
            }
        });

        // console.log(mail+'@'+extension);
        // $("#myTable tr").filter(function() {
        //     $(this).toggle($(this).text().toLowerCase().indexOf(mail+'@'+extension) > -1)
        // });
    }
    $(document).ready(function(){
        hiddenLoader();
        $("#searchBox").on("keyup", function() {
            fetchEmailsTable();
        });

        $("#extensions").on("change", function() {
            fetchEmailsTable();
        });

        $("#addEmails").click(function(){
            var email = $('#emailContent').val();
            showLoader();
            $.ajax({
                url : "/storeEmail",
                type : "POST",
                data : {
                    email : email
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


    });
        var loadExtensions = function() {
           $.ajax({
                url : "/loadExtensions",
                type : "POST",
                data : {
                },
                success : function (result){
                    $('#extensions').html(result);
                    hiddenLoader();
                },
                error: function(err){
                    alert(err);
                }
            });
        }
</script>
@endsection
