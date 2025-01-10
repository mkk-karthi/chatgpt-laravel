<?php

namespace App\Http\Controllers;

use App\Models\ChatGroup;
use App\Models\Chats;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ChatGroupController extends Controller
{
    public function list()
    {
        // get chat group list
        $data = ChatGroup::orderBy("id", "desc")->get();

        return response()->json([
            "code" => count($data) > 0 ? 0 : 1,
            "data" => $data
        ]);
    }

    public function create(Request $request)
    {
        $input = $request->all();

        // validate input
        $validator = Validator::make($input, [
            "name" => "required|string|max:120"
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->toArray();
            return response()->json(["code" => 1, "message" => $message]);
        } else {
            $chat_message = $input["name"];

            // create chat group
            $chat_group = ChatGroup::create(["name" => $chat_message]);
            $chat_group_id = $chat_group->id;

            return response()->json([
                "code" => $chat_group_id ? 0 : 1,
                "data" => $chat_group_id
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $message = "";
            $code = 1;
            $input = $request->all();

            // validate input
            $validator = Validator::make($input, [
                "name" => "required|string|max:120"
            ]);

            if ($validator->fails()) {
                $message = $validator->errors()->toArray();
            } else {

                // check chat group
                $chat_group = ChatGroup::find($id);
                if (is_null($chat_group)) {
                    $message = "Invalid Chat Group";
                } else {

                    // update chat group
                    $chat_group->update(["name" => $input["name"]]);

                    $message = "Updated";
                    $code = 0;
                }
            }
        } catch (Exception $ex) {

            Log::channel('single')->error($ex->getMessage());
            $message = "Something went wrong";
        }

        return response()->json(["code" => $code, "message" => $message]);
    }

    public function delete($id)
    {
        try {
            $message = "";
            $code = 1;

            // check chat group
            $chat_group = ChatGroup::find($id);
            if (is_null($chat_group)) {
                $message = "Invalid Chat Group";
            } else {

                // delete chats
                $delete = Chats::where("chat_group_id", $id)->delete();

                if ($delete) {

                    // delete chat group
                    $chat_group->delete();

                    $message = "Deleted";
                    $code = 0;
                } else {
                    $message = "Something went wrong";
                }
            }
        } catch (Exception $ex) {

            Log::channel('single')->error($ex->getMessage());
            $message = "Something went wrong";
        }
        return response()->json(["code" => $code, "message" => $message]);
    }
}
