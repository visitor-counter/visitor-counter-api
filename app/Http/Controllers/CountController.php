<?php

namespace App\Http\Controllers;

use App\Models\Count;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Ramsey\Uuid\Uuid;

class CountController extends Controller
{
    /**
     * Create count and return the count's uuid
     *
     * @param Request $request
     * @return array|Application|Response|ResponseFactory
     */
    #[ArrayShape(['uuid' => "\Ramsey\Uuid\UuidInterface"])]
    public function create(Request $request): array|Application|Response|ResponseFactory
    {
        if ($request->missing('user_uuid')) {
            return \response(status: 400);
        }
        $user_uuid = $request->input('user_uuid');

        if ($user_uuid === null) {
            return \response(status: 400);
        }
        if (!(Uuid::isValid($user_uuid))) {
            return \response(status: 400);
        }

        if (User::where('uuid', $user_uuid)->doesntExist()) {
            return \response(status: 403);
        }

        $count = new Count();
        $uuid  = Str::uuid();

        $count->uuid      = $uuid;
        $count->user_uuid = $user_uuid;

        DB::transaction(function () use ($count) {
            $count->save();
        });

        return ['uuid' => $uuid];
    }
}
