<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use Exception;
use App\Models\Role;

class RoleController extends Controller
{

    public function fetch(Request $request) {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit');

        $roleQuery = Role::query();

        // Get single data
        if ($id) {
            $role = $roleQuery->find($id);

            if($role) {
                return ResponseFormatter::success($role, 'Role Found');
            }

            return ResponseFormatter::error('Role not found', 404);
        }

        // Get multiple data
        $roles = $roleQuery->where('company_id', $request->company_id);

        if ($name) {
            $roles->where('name', 'like', '%' .$name. '%');
        }

        return ResponseFormatter::success($roles->paginate($limit), 'Role Found');

    }

    public function create(CreateRoleRequest $request) {

        try {

            $role = Role::create([
                'name' => $request->name,
                'company_id' => $request->company_id,
            ]);

            if (!$role) {
                throw new Exception('Role not created');
            }

            return ResponseFormatter::success($role, 'Role created');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage());
        }

    }

    public function update(UpdateRoleRequest $request, $id) {

        try {

            // Get role
            $role = Role::find($id);

            if (!$role) {
                throw new Exception('Role not found');
            }

            // Update role
            $role->update([
                'name' => $request->name,
                'company_id' => $request->company_id,
            ]);

            return ResponseFormatter::success($role, 'Role updated');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage());
        }
    }

    public function destroy($id) {

        try {

            // Get role
            $role = Role::find($id);

                if (!$role) {
                    throw new Exception('Role not found');
                }

            // Delete role
            $role->delete();

            return ResponseFormatter::success('Role deleted');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage());
        }

    }

}
