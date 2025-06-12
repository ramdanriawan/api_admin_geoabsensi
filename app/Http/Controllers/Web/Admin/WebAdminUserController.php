<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminUserStoreRequest;
use App\Http\Requests\Web\Admin\WebAdminUserUpdateRequest;
use App\Models\Dtos\UserStoreDto;
use App\Models\Dtos\UserUpdateDto;
use App\Models\User;
use App\Services\ServiceImpl\UserServiceImpl;

class WebAdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('web.admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminUserStoreRequest $request)
    {

        //
        UserServiceImpl::store(
            UserStoreDto::fromJson(
                $request->all()
            )
        );

        return redirect()->route('web.admin.user.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        $data['user'] = $user;

        return view('web.admin.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebAdminUserUpdateRequest $request, User $user)
    {
        UserServiceImpl::update(
            UserUpdateDto::fromJson([
                ...$request->all(),
                'id' => $user->id
            ])
        );

        return redirect()->route('web.admin.user.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
