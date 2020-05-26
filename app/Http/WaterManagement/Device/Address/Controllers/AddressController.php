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
            if ($new = Address::create([
                'slug' => $request->name,
                'name' => $request->name,
                'register_type_id' => $request->register_type_id,
                'configuration_type' => $request->configuration_type
            ])) {
                addChangeLog('Direccion Creada','addresses',convertColumns($new));

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
        $address = Address::findOrFail($id);
        $old = convertColumns($address);
        if(Address::slugExists(Str::slug($request->name),$id)) {
            return $this->slugError();
        } else {
            if ($address->update([
                'slug' => $request->name,
                'name' => $request->name,
                'register_type_id' => $request->register_type_id,
                'configuration_type' => $request->configuration_type
            ])) {
                addChangeLog('Direccion Modificada','addresses',$old,convertColumns($address));

                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }
        }
    }

    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        if ($address->delete()) {
            addChangeLog('Direccion Eliminada','addresses',convertColumns($address));

            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
