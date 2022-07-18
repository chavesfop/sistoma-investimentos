<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class WalletController extends Controller
{
    protected ?Authenticatable $user;

    public function __construct(){
        $this->user = Auth::user();
    }

    public function add(Request $request) : JsonResponse
    {
        $this->validate($request, ['name' => 'required|string|between:2,100']);
        $wallet = new Wallet;
        $wallet->name = $request->input('name');
        $wallet->user_id = $this->user->id;
        $wallet->save();
        return response()->json(['message' => 'Wallet added successfully']);
    }

    public function list() : JsonResponse
    {
        $wallets = Wallet::query()->where('user_id', $this->user->id);
        return response()->json($wallets->get());
    }

    public function update(Request $request) : JsonResponse
    {
        try {
            $this->validate($request, ['name' => 'required|string|between:2,100']);
            $wallet = Wallet::findOrFail($request->route('walletId'));
            if ($wallet->user_id != $this->user->id){
                return response()->json()->setStatusCode(403, 'Not your wallet');
            }
            $wallet->name = $request->input('name');
            $wallet->save();
            return response()->json(['message' => 'Wallet updated successfully']);
        } catch (ValidationException $e) {
            return response()->json()->setStatusCode(400, 'Invalid wallet name');
        } catch (\Exception $e){
            return response()->json()->setStatusCode(404, 'Wallet not found');
        }
    }

    public function remove(Request $request) : JsonResponse
    {
        try {
            $wallet = Wallet::findOrFail($request->route('walletId'));
            if ($wallet->user_id != $this->user->id){
                return response()->json()->setStatusCode(403, 'Not your wallet');
            }
            $wallet->delete();
            return response()->json()->setStatusCode(200, 'Wallet removed');
        } catch (\Exception $e){
            return response()->json()->setStatusCode(404, 'Wallet not found');
        }
    }
}
