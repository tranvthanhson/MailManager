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
        return view('home.index', compact('getEmails'));
    }

    public function storeEmail(Request $request)
    {
        if (isset($request->tukhoa)) {
            $email = $request->tukhoa;

            $emails = explode("\n", $email);
            foreach ($emails as $email) {
                $detailEmail = explode('@', $email);

                $getExtensionRecord = DB::table('extensions')->where('extension_content', '=', $detailEmail[1])->get();
                if (null == count($getExtensionRecord)) {
                    DB::table('extensions')->insert(
                        ['extension_content' => $detailEmail[1]]
                    );
                }
                $getExtensionRecord = DB::table('extensions')->where('extension_content', '=', $detailEmail[1])->get();
                DB::table('mails')->insert(
                    ['mail' => $detailEmail[0], 'extension_id' => $getExtensionRecord[0]->extension_id]
                );
            }
            $getEmails = DB::table('mails')
                ->join('extensions', 'extensions.extension_id', '=', 'mails.extension_id')
                ->select('mails.*', 'extensions.extension_content')
                ->orderBy('mail_id', 'desc')
                ->get();
            // dd($getEmails);

            foreach ($getEmails as $getEmail):
                echo '<tr style="display: block;">
				                  <td style="width: 50%; display: block; float:left;">' . $getEmail->mail . '@' . $getEmail->extension_content . '</td>
				                  <td style="width: 50%; display: block; float:left; text-align: right;">
				                      <a href="" class="btn btn-success btn-sm" title="Sửa">
				                          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
				                      </a>
				                      <a href="" class="btn btn-danger btn-sm" title="Xoá">
				                          <i class="fa fa-trash" aria-hidden="true"></i>
				                      </a>
				                      <div class="clearfix"></div>
				                  </td>
				              </tr>';
            endforeach;
        }
    }
}
