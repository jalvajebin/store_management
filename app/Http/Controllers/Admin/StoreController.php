<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class StoreController extends Controller
{

    public function index(Builder $builder,Request $request)
    {

        if ($request->ajax()) {
            $query = Store::query();

            if ($request->filled('filter.search')) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->input('filter.search') . '%');
                });
            }

            return DataTables::of($query)
                ->addColumn('action', 'admin.pages.stores.action')
                ->rawColumns(['action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['name' => 'name', 'data' => 'name', 'title' => 'Name', 'orderable' => false],
            ['name' => 'latitude', 'data' => 'latitude', 'title' => 'Latitude', 'orderable' => false],
            ['name' => 'longitude', 'data' => 'longitude', 'title' => 'Longitude', 'orderable' => false],
            ['name' => 'radius', 'data' => 'radius', 'title' => 'Radius', 'orderable' => false],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'orderable' => false],
        ]);
        return view('admin.pages.stores.index', compact('html'));
    }


    public function create()
    {
       return view('admin.pages.stores.create');
    }


    public function store(Request $request)
    {
       $request->validate([
           'name' => 'required|string|max:255',
           'latitude' => 'required|numeric',
           'longitude' => 'required|numeric',
           'address' => 'required',
           'radius' => 'required|numeric',
           'image' => 'required|image',
       ]);

       $store = new Store();
       $store->name = $request->input('name');
       $store->latitude = $request->input('latitude');
       $store->longitude = $request->input('longitude');
       $store->address = $request->input('address');
       $store->radius = $request->input('radius');

        if ($request->hasFile('image')) {
            $Image = $request->file('image');
            $ImageName = $Image->getClientOriginalExtension() ? Str::uuid() . '.' . $Image->getClientOriginalExtension() : Str::uuid();
            $Image->storeAs('public/stores/images', $ImageName);
            $store->image_name = $ImageName;
        }

        $store->save();

        return redirect()->route('admin.stores.index')->with('success', 'Store created successfully.');
    }


    public function edit(Store $store)
    {
        return view('admin.pages.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required',
            'radius' => 'required|numeric',
            'image' => 'nullable|image',
        ]);

        $store->name = $request->input('name');
        $store->latitude = $request->input('latitude');
        $store->longitude = $request->input('longitude');
        $store->address = $request->input('address');
        $store->radius = $request->input('radius');

        if ($request->hasFile('image')) {
            $Image = $request->file('image');
            $ImageName = $Image->getClientOriginalExtension() ? Str::uuid() . '.' . $Image->getClientOriginalExtension() : Str::uuid();
            $Image->storeAs('public/stores/images', $ImageName);
            $store->image_name = $ImageName;
        }

        $store->save();

        return redirect()->route('admin.stores.index')->with('success', 'Store updated successfully.');
    }

    public function destroy(Store $store)
    {
       $store->delete();

       return redirect()->route('admin.stores.index')->with('success', 'Store deleted successfully.');
    }
}
