<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class UserController extends Controller
{
    /**
     * Create user and return the user's uuid
     *
     * @return array
     */
    #[ArrayShape(['uuid' => "\Ramsey\Uuid\UuidInterface"])]
    public function create(): array
    {
        $user = new User();
        $uuid = Str::uuid();
        $user->uuid = $uuid;

        DB::transaction(function () use ($user) {
            $user->save();
        });

        return ['uuid' => $uuid];
    }
}
