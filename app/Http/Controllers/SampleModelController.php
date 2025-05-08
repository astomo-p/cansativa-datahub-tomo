<?php

namespace App\Http\Controllers;

use App\Models\SampleModel;
use App\Http\Requests\StoreSampleModelRequest;
use App\Http\Requests\UpdateSampleModelRequest;
use App\Services\FileService;
use RealRashid\SweetAlert\Facades\Alert;

class SampleModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSampleModelRequest $request)
    {
        try {
            $data = $request->validated();

            // Assign and process new data here
            $data['image'] = FileService::upload($request->image, 'sample');

            $model = SampleModel::create($data);

            Alert::success('Berhasil', 'Data berhasil ditambahkan');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data gagal ditambahkan, mohon coba lagi beberapa saat.');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SampleModel $sampleModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SampleModel $sampleModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSampleModelRequest $request, SampleModel $sampleModel)
    {
        try {
            $data = $request->validated();

            // Assign and process new data here
            $data['image'] = FileService::replace($sampleModel->image, $request->image, 'sample');

            $sampleModel->update($data);

            Alert::success('Berhasil', 'Data berhasil diperbaharui');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data gagal diperbaharui, mohon coba lagi beberapa saat.');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SampleModel $sampleModel)
    {
        try {
            FileService::remove($sampleModel->image);

            $sampleModel->delete();

            Alert::success('Berhasil', 'Data berhasil dihapus');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data gagal dihapus, mohon coba lagi beberapa saat.');
            return redirect()->back();
        }
    }
}
