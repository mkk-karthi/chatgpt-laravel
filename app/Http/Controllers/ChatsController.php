<?php

namespace App\Http\Controllers;

use App\Models\Chats;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\StreamedResponseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use OpenAI\Exceptions\ErrorException;
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
                "message" => "required|max:120",
                "group_id" => "required"
            ]);

            if ($validator->fails()) {
                $message = $validator->errors()->toArray();
            } else {

                $chat_message = $input["message"];
                $chat_group_id = $input["group_id"];

                // get last chats to look like the last chat
                $limit = 6;
                $last_chats = Chats::where([["chat_group_id", $chat_group_id]])->orderBy("id", "desc")->limit($limit)->get()->toArray();;

                $messages = [];
                if (count($last_chats) > 0) {
                    $last_chats = array_reverse($last_chats);
                    foreach ($last_chats as $row) {
                        $messages[] = [
                            "role" => $row["role"],
                            "content" => $row["message"]
                        ];
                    }
                }
                $messages[] = [
                    "role" => "user",
                    "content" => $chat_message
                ];

                // return stream response
                return response()->stream(function () use ($messages, $chat_message, $chat_group_id) {
                    $content = "";

                    try {
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
                        $user_chat = Chats::create([
                            "role" => "user",
                            "message" => $chat_message,
                            "chat_group_id" => $chat_group_id,
                        ]);

                        // add openai response in table 
                        $assistant_chat = Chats::create([
                            "role" => "assistant",
                            "message" => $content,
                            "chat_group_id" => $chat_group_id,
                        ]);
                    } catch (Exception $ex) {

                        Log::channel('single')->error($ex->getMessage());
                        $message = "#Error: Something went wrong#";
                        echo $message;
                    } catch (ErrorException $ex) {

                        Log::channel('single')->error($ex->getMessage());
                        $message = "#Error: Something went wrong#";
                    }
                }, 200, [
                    'X-Accel-Buffering' => 'no',
                    'Content-Type' => 'text/event-stream',
                    'Cache-Control' => 'no-cache'
                ]);
            }
        } catch (Exception $ex) {

            Log::channel('single')->error($ex->getMessage());
            $message = "Something went wrong";
        } catch (StreamedResponseException $ex) {

            Log::channel('single')->error("13:" . $ex->getMessage());
            $message = "Something went wrong";
        }

        return response()->json(["code" => $code, "message" => $message], 400);
    }
}
