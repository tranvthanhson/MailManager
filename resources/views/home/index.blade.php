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
                            <input type="submit"  id="submit_get" name="insertEmail" class="btn btn-default btn-full btn-radius" style="border:1px solid black;" value="Submit" />
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
                                <select class="form-control border-input">
                                    <option value="">-- Choose --</option>
                                    <option value="">gmail.com</option>
                                    <option value="">dtu.edu.vn</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <input class="form-control border-input" name="teacher">
                        </input>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-default btn-full btn-radius border-solid-black">Search</button>
                    </div>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-striped border-solid-black">
                        <thead>
                            <tr style="display: block;">
                                <th style="width: 50%; display: block; float:left;">Mail</th>
                                <th style="width: 50%; display: block; float:left; text-align: center;">Options</th>
                            </tr>
                        </thead>
                        <tbody class="ajaxsanpham" style="display: block; height: 500px; overflow-y: auto;">
                            <?php foreach ($getEmails as $getEmail): ?>
                                <tr style="display: block;">
                                  <td style="width: 50%; display: block; float:left;"><?=$getEmail->mail?>@<?=$getEmail->extension_content?></td>
                                  <td style="width: 50%; display: block; float:left; text-align: right;">
                                      <a href="" class="btn btn-success btn-sm" title="Sửa">
                                          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                      </a>
                                      <a href="" class="btn btn-danger btn-sm" title="Xoá">
                                          <i class="fa fa-trash" aria-hidden="true"></i>
                                      </a>
                                      <div class="clearfix"></div>
                                  </td>
                              </tr>
                          <?php endforeach;?>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>
</div>

@endsection
