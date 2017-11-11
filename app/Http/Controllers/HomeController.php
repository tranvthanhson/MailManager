<?php

namespace App\Http\Controllers;

// use App\Http\Requests\EmailsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $mails = DB::table('mails')
            ->join('extensions', 'extensions.extension_id', '=', 'mails.extension_id')
            ->select('mails.*', 'extensions.extension_content')
            ->orderBy('mail_id', 'desc')
            ->get();
        $extensions = DB::table('extensions')
            ->select('extension_content')
            ->groupBy('extension_content')
            ->get();
        return view('home.index', compact('mails', 'extensions'));
    }

    public function storeEmail(Request $request)
    {
        if (isset($request->email)) {
            $email = $request->email;

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
            $mails = DB::table('mails')
                ->join('extensions', 'extensions.extension_id', '=', 'mails.extension_id')
                ->select('mails.*', 'extensions.extension_content')
                ->orderBy('mail_id', 'desc')
                ->get();
// echo var_dump($mails);
            return view('home.emailsTable', compact('mails'));
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

    public function delete(Request $request)
    {
<<<<<<< HEAD
        // return $request->idEmail;
        $idEmail = $request->idEmail;
=======
        $id = $request->id;
>>>>>>> dev
        $mailExtensionId = DB::table('mails')
            ->where('mail_id', '=', $idEmail)
            ->select('extension_id')
            ->get();
        $mailExtensionId = $mailExtensionId[0]->extension_id;
        DB::table('mails')
            ->where('mail_id', '=', $idEmail)
            ->delete();
        $countExtension = DB::table('mails')
            ->where('extension_id', '=', $mailExtensionId)
            ->count();
        if (0 == $countExtension) {
            DB::table('extensions')
                ->where('extension_id', '=', $mailExtensionId)
                ->delete();
        }
        $request->session()->flash('msg', 'Delete Email success!');
        $mails = DB::table('mails')
            ->join('extensions', 'extensions.extension_id', '=', 'mails.extension_id')
            ->select('mails.*', 'extensions.extension_content')
            ->orderBy('mail_id', 'desc')
            ->get();
        return view('home.emailsTable', compact('mails'));
    }

    public function search(Request $request)
    {
        $email = $request->email;
        $extension = $request->extension;
        // dd($email. " " . $extension);
        if ('all' == $extension) {
            $mails = DB::table('mails')
                ->join('extensions', 'extensions.extension_id', '=', 'mails.extension_id')
                ->where([
                    ['mails.mail', 'like', '%' . $email . '%'],
                ])
                ->get();
        } else {
            $mails = DB::table('mails')
                ->join('extensions', 'extensions.extension_id', '=', 'mails.extension_id')
                ->where([
                    ['mails.mail', 'like', '%' . $email . '%'],
                    ['extensions.extension_content', '=', $extension],
                ])
                ->get();
        }
        return view('home.emailsTable', compact('mails'));
    }

    public function loadExtensions()
    {
        $extensions = DB::table('extensions')
            ->select('extension_content')
            ->groupBy('extension_content')
            ->get();
        return view('home.extensions', compact('extensions'));
    }
}
