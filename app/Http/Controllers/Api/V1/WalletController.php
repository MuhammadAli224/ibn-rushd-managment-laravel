<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;

class WalletController extends Controller
{
    use \App\Traits\ApiResponseTrait;
    public function index(Request $request)
    {
        try {
            $user = auth()->user();

            return $this->success(
                data: [
                    'balance' => $user->balance,
                    'transaction' => $user->transactions,
                ],
                message: __('general.get_success'),
            );
        } catch (\Exception $e) {
            Log::error('Error Wallet Index: ' . $e->getMessage());
            return $this->error(
                message: __('general.get_failed'),
                statusCode: 500,
                error: 'Internal Server Error : ' . $e->getMessage()
            );
        }
    }
}
