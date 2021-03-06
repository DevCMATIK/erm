<?php

namespace App\Http\WaterManagement\Device\Address\Controllers;

use App\App\Controllers\Controller;
use App\Domain\WaterManagement\Device\Address\Address;
use App\Http\WaterManagement\Device\Address\Requests\AddressRequest;
use Illuminate\Support\Str;

class AddressController extends Controller
{
    public function index()
    {
        return view('water-management.device.address.index');
    }

    public function create()
    {
        return view('water-management.device.address.create');
    }

    public function store(AddressRequest $request)
    {
        if (Address::findBySlug(Str::slug($request->name))) {
            return $this->slugError();
        } else {
            if (Address::create([
                'slug' => $request->name,
                'name' => $request->name,
                'register_type_id' => $request->register_type_id,
                'configuration_type' => $request->configuration_type
            ])) {
                return $this->getResponse('success.store');
            } else {
                return $this->getResponse('error.store');
            }
        }
    }

    public function edit($id)
    {
        $address = Address::findOrFail($id);
        return view('water-management.device.address.edit',compact('address'));
    }

    public function update(AddressRequest $request,$id)
    {
        $record = Address::findOrFail($id);
        if(Address::slugExists(Str::slug($request->name),$id)) {
            return $this->slugError();
        } else {
            if ($record->update([
                'slug' => $request->name,
                'name' => $request->name,
                'register_type_id' => $request->register_type_id,
                'configuration_type' => $request->configuration_type
            ])) {
                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }
        }
    }

    public function destroy($id)
    {
        $record = Address::findOrFail($id);
        if ($record->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
