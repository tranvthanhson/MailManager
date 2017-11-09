<?php

namespace App\Http\Controllers;

// use App\Http\Requests\EmailsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $getEmails = DB::table('mails')
            ->join('extensions', 'extensions.extension_id', '=', 'mails.extension_id')
            ->select('mails.*', 'extensions.extension_content')
            ->orderBy('mail_id', 'desc')
            ->get();
        $getExtensions = DB::table('extensions')
            ->select('extension_content')
            ->get();
        // dd($getExtension);
        return view('home.index', compact('getEmails', 'getExtensions'));
    }

    public function storeEmail(Request $request)
    {
        if (isset($request->tukhoa)) {
            $email = $request->tukhoa;

            $emails = explode("\n", $email);

            foreach ($emails as $email) {
                $detailEmail = explode('@', $email);
                // check email already
                $emailAlready = DB::table('mails')
                    ->join('extensions', 'extensions.extension_id', '=', 'mails.extension_id')
                    ->select('mails.mail', 'extensions.extension_content')
                    ->where([
                        ['extensions.extension_content', '=', $detailEmail[1]],
                        ['mails.mail', '=', $detailEmail[0]],
                    ])->get();
                // dd(count($emailAlready));
                if (count($emailAlready) == 0) {
                    //test extension already
                    $getExtensionRecord = DB::table('extensions')->where('extension_content', '=', $detailEmail[1])->get();

                    if (0 == count($getExtensionRecord)) {
                        DB::table('extensions')->insert(
                            ['extension_content' => $detailEmail[1]]
                        );
                    }

                    $getExtensionRecord = DB::table('extensions')->where('extension_content', '=', $detailEmail[1])->get();
                    DB::table('mails')->insert(
                        ['mail' => $detailEmail[0], 'extension_id' => $getExtensionRecord[0]->extension_id]
                    );
                }
                // $request->session()->flash('msg', 'Insert Emails Success!');
            }
            //display email already insert
            $getEmails = DB::table('mails')
                ->join('extensions', 'extensions.extension_id', '=', 'mails.extension_id')
                ->select('mails.*', 'extensions.extension_content')
                ->orderBy('mail_id', 'desc')
                ->get();
            foreach ($getEmails as $getEmail):
                echo '<tr style="display: block;">
						            <td style="width: 50%; display: block; float:left;">' . $getEmail->mail . '@' . $getEmail->extension_content . '</td>
						            <td style="width: 50%; display: block; float:left; text-align: right;">
						             <a data-toggle="modal" data-target="#editEmail' . $getEmail->mail_id . '" href="" class="btn btn-success btn-sm" title="Sửa">
						                 <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
						             </a>
						             <!-- Modal -->
						             <div class="modal fade" id="editEmail' . $getEmail->mail_id . '" role="dialog">
						                 <div class="modal-dialog">

						                     <!-- Modal content-->
						                     <div class="modal-content">
						                         <div class="modal-header">
						                             <button type="button" class="close" data-dismiss="modal">&times;</button>
						                             <h4 class="modal-title">UPDATE EMAIL</h4>
						                         </div>
						                         <form action="/updateEmail/' . $getEmail->mail_id . '" method="POST" >
						                             <div class="modal-body">
						                                 <div class="form-group">
						                                     <input type="text" class="form-control" value="' . $getEmail->mail . '" id="" placeholder="Enter mail">
						                                 </div>
						                                 <div class="form-group">
						                                     <input type="text" value="' . $getEmail->extension_content . '" class="form-control" id="" placeholder="Enter extension">
						                                 </div>
						                             </div>
						                             <div class="modal-footer">
						                                 <input type="submit" class="btn btn-primary"  value="Update" />
						                             </div>
						                         </form>
						                     </div>
						                 </div>
						             </div>
						             <a href="/deleteEmail/' . $getEmail->mail_id . '" class="btn btn-danger btn-sm" title="Xoá">
						                 <i class="fa fa-trash" aria-hidden="true"></i>
						             </a>
						             <div class="clearfix"></div>
						         </td>
						     </tr>';
            endforeach;
        }
    }

    public function updateEmail($id, Request $request)
    {
        $mail = $request->mail;
        $extension_content = $request->extension_content;
        $checkNewEmailAlready = DB::table('mails')
            ->join('extensions', 'extensions.extension_id', '=', 'mails.extension_id')
            ->where([
                ['extensions.extension_content', '=', $extension_content],
                ['mails.mail', '=', $mail],
            ])->get();
        if (count($checkNewEmailAlready) <= 0) {
            //get Email updating
            $getEmailUpdate = DB::table('mails')
                ->join('extensions', 'extensions.extension_id', '=', 'mails.extension_id')
                ->where([
                    ['mails.mail_id', '=', $id],
                ])->get();
            if ($getEmailUpdate[0]->extension_content != $extension_content) {
                //check new extension_content already?
                $newExtensionAlready = DB::table('extensions')->where('extension_content', '=', $extension_content)->get();
                if (count($newExtensionAlready) > 0) {
                    DB::table('mails')
                        ->where('mail_id', $id)
                        ->update(['extension_id' => $newExtensionAlready[0]->extension_id]);
                } else {
                    DB::table('extensions')
                        ->where('extension_id', $getEmailUpdate[0]->extension_id)
                        ->update(['extension_content' => $extension_content]);
                }
            }
            if ($getEmailUpdate[0]->mail != $mail) {
                DB::table('mails')
                    ->where('mail_id', $id)
                    ->update(['mail' => $mail]);
            }
            $request->session()->flash('msg', 'Edit Email success!');
            return redirect()->route('home.index');
        } else {
            $request->session()->flash('msg', 'Email Already!');
            return redirect()->route('home.index');
        }
    }

    public function deleteEmail($id, Request $request)
    {
        DB::table('mails')->where('mail_id', '=', $id)->delete();
        $request->session()->flash('msg', 'Delete Email success!');
        return redirect()->route('home.index');
    }
}
