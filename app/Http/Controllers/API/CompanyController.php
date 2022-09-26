<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\User;

class CompanyController extends Controller
{
    public function fetch(Request $request) {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        if ($id) {
            // ngambil data company yang di buat attau berdasarkan id user yang login saat ini
            // get list by user yang sedang login
            $company = Company::with(['users'])->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
                    })->with(['users'])->find($id);

            if($company) {
                return ResponseFormatter::success($company, 'Company Found');
            }

            return ResponseFormatter::error('Company not found', 404);
        }

        // ngambil data company yang di buat attau berdasarkan id user yang login saat ini
        // get list by user yang sedang login
        $companies = Company::with(['users'])->whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        });

        if ($name) {
            $companies->where('name', 'like', '%' . $name . '%');
        }

        return ResponseFormatter::success($companies->paginate($limit), 'Companies Found');
    }

    public function create(CreateCompanyRequest $request) {

        try {
        //   upload logo
        if($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public/logos');
        }

        // Create company
        $company = Company::create([
            'name' => $request->name,
            'logo' => $path,

        ]);

        if(!$company) {
            throw new Exception('Company not created');
        }

        // Attach company to user
        // karena di company & user menggunakan many to many jadi harus di attach/di tempelin datanya seperti ini
        $user = User::find(Auth::id());
        $user->companies()->attach($company->id);

        // kalo mau liat relasi users yang bersangkutan
        // $company->load('users');

            return ResponseFormatter::success($company, 'Company created');

        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 500);
        }
    }

    public function update(UpdateCompanyRequest $request, $id) {

        //dd($request->all());

        try {

            $company = Company::find($id);

            if (!$company) {
                throw new Exception('Company not found');
            }

            // Upload logo
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('public/logos');
            }

            // Update company
            $company->update([
                'name' => $request->name,
                'logo' => isset($path) ? $path : $company->logo,
            ]);

            return ResponseFormatter::success($company, 'Company updated');

        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), '500');
        }

    }



}
