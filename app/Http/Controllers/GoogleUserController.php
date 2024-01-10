<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoregoogleUserRequest;
use App\Http\Requests\UpdategoogleUserRequest;
use App\googleUser;

class googleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoregoogleUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoregoogleUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\googleUser  $googleUser
     * @return \Illuminate\Http\Response
     */
    public function show(googleUser $googleUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\googleUser  $googleUser
     * @return \Illuminate\Http\Response
     */
    public function edit(googleUser $googleUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdategoogleUserRequest  $request
     * @param  \App\googleUser  $googleUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdategoogleUserRequest $request, googleUser $googleUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\googleUser  $googleUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(googleUser $googleUser)
    {
        //
    }
}
