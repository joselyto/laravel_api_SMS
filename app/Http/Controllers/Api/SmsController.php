<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Concerner;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmsController extends Controller
{
    //
    public function contacts(){
        $contacts = Contact::all();
        return response()->json([
            "contacts"=>$contacts,
            "status"=>true
        ], 200);
    }
    public function createContatct(Request $request){
        try {
            $request->validate([
                "nom"=>"required",
                "prenom"=>"required",
            ]);
            $contact =Contact::create([
                "nom"=>$request->nom,
                "prenom"=>$request->prenom,
            ], 201);
            return response()->json([
                "status"=>true,
                "contact"=>$contact
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status"=>false,
                "message"=>$th->getMessage(),
            ], 500);
        }
    }
    public function maliste_conversation($id){
   
        try {
            $conversations = DB::table('conversations')
            ->join('contconversas', 'conversations.id','=','contconversas.conversation_id')
            ->join('contacts', 'contacts.id','=','contconversas.contact_id')
            ->join('messages', 'messages.conversation_id', '=', 'conversations.id')
            ->where('contacts.id','=',$id)
            ->orWhere('messages.contact_id', '=',$id)
            ->select('conversations.*')
            ->get();
            return response()->json([
                "status"=>true,
                "data"=>$conversations
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                "status"=>false,
                "message"=>$th->getMessage(),
            ], 500);
        }
        
    }
    public function conversation_detail($id){
   
        try {
            $detailConversation = DB::table('conversations')
            ->join('messages', 'messages.conversation_id','=','conversations.id')
            ->where('messages.conversation_id','=',$id)
            ->select('messages.*')
            ->get();
            return response()->json([
                "status"=>true,
                "data"=>$detailConversation
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                "status"=>false,
                "message"=>$th->getMessage(),
            ], 500);
        }
        
    }

   
    public function envoyerMessage(Request $request, $id){
        try {
            $request->validate([
                "content"=>"required",
                "destinateur"=>"required"
            ]);
         

            $message =Message::create([
               "content"=>$request->content,
               "conversation_id"=>$id,
               "contact_id"=>$request->destinateur
            ]);
           
            return response()->json([
                "status"=>true,
                "content"=>$message
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "status"=>false,
                "message"=>$th->getMessage(),
            ], 500);
        }
    }
}
