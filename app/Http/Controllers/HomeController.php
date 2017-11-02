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
        // dd($getEmails);
        return view('home.index', compact('getEmails'));
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
						                   <a data-toggle="modal" data-target="#editEmail" href="" class="btn btn-success btn-sm" title="Sửa">
						                       <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
						                   </a>
						                   <!-- Modal -->
						                   <div class="modal fade" id="editEmail" role="dialog">
						                       <div class="modal-dialog">

						                           <!-- Modal content-->
						                           <div class="modal-content">
						                               <div class="modal-header">
						                                   <button type="button" class="close" data-dismiss="modal">&times;</button>
						                                   <h4 class="modal-title">UPDATE EMAIL</h4>
						                               </div>
						                               <div class="modal-body">
						                                   <div class="form-group">
						                                       <input type="email" class="form-control" id="" placeholder="Vui long nhap email">
						                                   </div>
						                               </div>
						                               <div class="modal-footer">
						                                   <button type="button" class="btn btn-primary" data-dismiss="modal">Gui</button>
						                               </div>
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

    public function deleteEmail($id, Request $request)
    {
        DB::table('mails')->where('mail_id', '=', $id)->delete();
        $request->session()->flash('msg', 'Delete Email success!');
        return redirect()->route('home.index');
    }
}
