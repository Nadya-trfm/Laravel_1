<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{

    public function getAll()
    {
        $res = DB::table('client')
            ->leftJoin('address', 'client.id', '=', 'address.client_id')
            ->select('client.*', 'address.*');
        return response()->json($res);
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = validator($request->all(), [
            'first_name' => ['max:255', 'required'],
            'last_name' => ['max:255', 'required'],
            'agreement' => ['required', 'boolean'],
        ]);


        try {
            $validatedData = $validator->validate();
        } catch (ValidationException $e) {
            return response()->json(
                $validator->errors()
                , 422);
        }


        $id = DB::table('client')->insertGetId($validatedData);

        return response()->json(DB::table('client')->where('id', $id)->get());
    }

    public function edit($id): \Illuminate\Http\JsonResponse
    {
        $res = DB::table('client')->where('id', $id);
        if ($res->exists()) {
            return response()->json($res->get());
        } else {
            return response()->json(['message' => 'Клиент не найден'], 404);
        }

    }


    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $validator = validator($request->all(), [
            'first_name' => ['max:255', 'required'],
            'last_name' => ['max:255', 'required'],
            'agreement' => ['required', 'boolean'],
        ]);


        try {
            $validatedData = $validator->validate();
        } catch (ValidationException $e) {
            return response()->json(
                $validator->errors()
                , 422);
        }


        DB::table('client')
            ->where('id', $id)
            ->update($validatedData);

        return response()->json(DB::table('client')->where('id', $id)->get());
    }

    public function delete($id): \Illuminate\Http\JsonResponse
    {
        DB::table('client')->where('id', $id)->delete();
        return response()->json([
            'status' => 'OK'
        ]);
    }
}
