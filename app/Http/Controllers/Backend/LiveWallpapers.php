<?php

namespace App\Http\Controllers\Backend;

use App\LiveWallpapers as LiveWallpapersModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LiveWallpapers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = LiveWallpapersModel::with('category')
            ->with('type')
            ->with([
                'tags' => function($q){
                    return $q->pluck('tag');
                }
            ])
            ->with('category')
            ->get();

        //dd($items->toArray());

        $data = [
            'title' => 'Live Wallpapers',
            'type' => 'Listing'
        ];

        //dd($items);

        return view('theme.lw.index', compact('items', 'data'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
