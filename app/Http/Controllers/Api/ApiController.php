<?php declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

abstract class ApiController extends Controller
{

    protected function returnJsonErrorResponse(\Exception $e, $status = 500) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ],$status);
    }


}