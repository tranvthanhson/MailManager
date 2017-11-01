<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailsRequest;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function storeEmail(EmailsRequest $request)
    {
        if (isset($request->insertEmail)) {
            $email = $request->emails;
            $emails = explode("\r\n", $email);
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
            $request->session()->flash('msg', 'Add Emails successful!');
            return redirect()->route('home.index');
        }
    }

    public function ajax()
    {
        echo 'OK';
    }
}
