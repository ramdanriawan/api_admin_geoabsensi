<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminTitleStoreRequest;
use App\Http\Requests\Web\Admin\WebAdminTitleUpdateRequest;
use App\Models\Dtos\TitleStoreDto;
use App\Models\Dtos\TitleUpdateDto;
use App\Models\Title;
use App\Services\ServiceImpl\TitleServiceImpl;

class WebAdminTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('web.admin.title.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.title.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminTitleStoreRequest $request)
    {
        //
        TitleServiceImpl::store(
            TitleStoreDto::fromJson($request->all())
        );

        return redirect()->route('web.admin.title.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Title $title)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Title $title)
    {
        //

        return view('web.admin.title.edit', compact('title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebAdminTitleUpdateRequest $request, Title $title)
    {
        //
        TitleServiceImpl::update(
            TitleUpdateDto::fromJson([
                ...$request->all(),
                "id" => $title->id,
            ]),
        );

        return redirect()->route('web.admin.title.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Title $title)
    {
        //

        TitleServiceImpl::delete($title);

        return redirect()->route('web.admin.title.index')->with('success', true);
    }
}
