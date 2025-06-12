<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\WebAdminOrganizationStoreRequest;
use App\Models\Dtos\OrganizationStoreDto;
use App\Models\Dtos\OrganizationUpdateDto;
use App\Models\Organization;
use App\Services\ServiceImpl\OrganizationServiceImpl;
use Illuminate\Http\Request;

class WebAdminOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('web.admin.organization.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('web.admin.organization.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAdminOrganizationStoreRequest $request)
    {
        //
        OrganizationServiceImpl::store(OrganizationStoreDto::fromJson([
            ...$request->all(),
            "logo" => $request->file('logo')
        ]));

        return redirect()->route('web.admin.organization.index')->with(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        //

        return view('web.admin.organization.edit', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        //
        //
        OrganizationServiceImpl::update(OrganizationUpdateDto::fromJson([
            ...$request->all(),
            "logo" => $request->file('logo'),
            'id' => $organization->id,
        ]));

        return redirect()->route('web.admin.organization.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
