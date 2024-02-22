<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    //
    public function package_lists()
    {
        $data = DB::table('packages')->get();
        return view('pages.package_list', ['data' => $data]);
    }

    public function package_upload(Request $request)
    {
        try {
            $validate = $request->validate([
                'package_name' => ['required', 'min:4', 'unique:packages'],
                'package_price' => ['required']
            ]);

            if ($validate) {
                $package = new Package;
                $package->package_name = $request->package_name;
                $package->package_price = $request->package_price;
                $count = DB::table('packages')->count('package_name');
                $package->package_role = $count;
                $package->save();

                return redirect()->route('admin.package_lists')->with('success', 'Package Created Successfully');
            }
        } catch (ValidationException $e) {
            return back()->withErrors([
                'error' => 'Package Name Should Be Unique. Package Name Must Be 4 Character'
            ]);
        }
    }

    public function package_edit($id)
    {
        $package = Package::find($id);
        return view('pages.package_edit', ['package' => $package]);
    }
    public function package_update(Request $request)
    {
        try {
            $validate = $request->validate([
                'package_name' => ['required', 'min:4',Rule::unique('packages')->ignore($request->package_id)],
                'package_price' => ['required']
            ]);
            if ($validate) {
                DB::table('packages')->where('id', $request->package_id)->update(['package_name' => $request->package_name, 'package_price' => $request->package_price]);
                return redirect()->route('admin.package_lists')->with('update', 'Updated Successfully');
            }
        } catch (ValidationException $e) {
            return back()->withErrors(['error'=>'Package Name Should Be Unique. Package Name Must Be 4 Character']);
        }
    }
    public function package_delete($id)
    {
        $data = Package::find($id)->delete();
        return redirect()->back()->with('deleted', 'Deleted Successfully');
    }
}
