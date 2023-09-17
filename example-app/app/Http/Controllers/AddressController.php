<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AddressController extends Controller
{
    public function getAll()
    {
        return response()->json(DB::table('address'));
    }


    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = validator($request->all(), [
            'region' => ['required', 'max:255'],
            'locality' => ['required', 'max:255'],
            'street' => ['required', 'max:255'],
            'house' => ['required',  'max:255'],
            'index' => ['required', 'integer'],
            'client_id' => ['required']
        ]);

        try {
            $validatedData = $validator->validate();
        } catch (ValidationException $e) {
            return response()->json(
                $validator->errors()
                , 422);
        }
        $res = DB::table('client')->where('id', $request->string('client_id')->trim());
        if ($res->exists()) {
            $id = DB::table('address')->insertGetId($validatedData);
            return response()->json(DB::table('address')->where('id', $id)->get());;
        } else {
            return response()->json(['message' =>$res->toSql(). 'Клиент не найден'], 404);
        }

    }

    public function edit($id): \Illuminate\Http\JsonResponse
    {
        $res = DB::table('address')->where('id', $id);
        if ($res->exists()) {
            return response()->json($res->get());
        } else {
            return response()->json(['message' => 'address не найден'], 404);
        }

    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'region' => ['required', 'max:255'],
            'locality' => ['required', 'max:255'],
            'street' => ['required', 'max:255'],
            'house' => ['required',  'max:255'],
            'index' => ['required', 'integer'],
            'client_id' => ['required']
        ]);
        DB::table('address')
            ->where('id', $id)
            ->update($validatedData);

        return response()->json(DB::table('address')->where('id', $id)->get());
    }

    public function delete($id): \Illuminate\Http\JsonResponse
    {
        DB::table('address')->where('id', $id)->delete();
        return response()->json([
            'status' => 'OK'
        ]);
    }
}
