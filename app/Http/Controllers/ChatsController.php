<?php

namespace App\Http\Controllers;

use App\Models\Chats;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use OpenAI\Laravel\Facades\OpenAI;

class ChatsController extends Controller
{
    public function list($id)
    {
        // get chats list
        $data =  Chats::where([["chat_group_id", $id]])->get();

        return response()->json([
            "code" => count($data) > 0 ? 0 : 1,
            "data" => $data
        ]);
    }

    public function stream_chat(Request $request)
    {
        try {
            $message = "";
            $code = 1;
            $input = $request->all();

            // validate input
            $validator = Validator::make($input, [
                "message" => "required|max:120"
            ]);

            if ($validator->fails()) {
                $message = $validator->errors()->toArray();
            } else {

                $chat_message = $input["message"];

                // get last openai response
                $last_chat = Chats::where([["role", "assistant"]])->orderBy("id", "desc")->first();

                $messages = [];
                if (!is_null($last_chat)) {
                    $messages[] = [
                        "role" => "assistant",
                        "content" => $last_chat->message
                    ];
                }
                $messages[] = [
                    "role" => "user",
                    "content" => $chat_message
                ];

                // return stream response
                return response()->stream(function () use ($input, $messages, $chat_message) {
                    $content = "";
                    $chat_group_id = $input["group_id"];

                    // get openai chat content with stream
                    $stream = OpenAI::chat()->createStreamed([
                        "model" => "gpt-4o-mini",
                        "messages" => $messages,
                        "stream" => true
                    ]);

                    foreach ($stream as $response) {
                        $text = $response->choices[0]->delta->content;
                        $content .= $text;

                        if (connection_aborted()) {
                            break;
                        }

                        echo $text;
                        ob_flush();
                        flush();
                    }

                    // add user message in table
                    $chat = Chats::create([
                        "role" => "user",
                        "message" => $chat_message,
                        "chat_group_id" => $chat_group_id,
                    ]);

                    // add openai response in table 
                    $chat1 = Chats::create([
                        "role" => "assistant",
                        "message" => $content,
                        "chat_group_id" => $chat_group_id,
                    ]);
                }, 200, [
                    'X-Accel-Buffering' => 'no',
                    'Content-Type' => 'text/event-stream',
                    'Cache-Control' => 'no-cache'
                ]);
            }
        } catch (Exception $ex) {

            Log::channel('single')->error($ex->getMessage());
            $message = "Something went wrong";
        }

        return response()->json(["code" => $code, "message" => $message]);
    }
}
