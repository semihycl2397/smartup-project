<?php

namespace App\Repositories\UserRepositories;

use App\Models\User;
use App\Models\Company;
class UserRepository
{
    public function fetchAllUsers()
    {
        return User::with('getCompany')->get();
    }

    public function getUserById(int $id)
    {
        return User::with('getCompany')->find($id);
    }

    public function createUser(array $data)
    {
        $company = Company::firstOrCreate(['name' => $data['company_name']]);

        $user = User::create(array_merge($data, ['company_id' => $company->id]));

        return [
            'user' => $user,
            'company' => $company
        ];
    }

    public function updateUser(int $id, array $data)
    {
        $user = User::find($id);

        if ($user) {
            if (isset($data['company_name'])) {
                $company = Company::firstOrCreate(['name' => $data['company_name']]);
                $data['company_id'] = $company->id;
            }
            $user->update($data);

            return $user->load('company');
        }

        return null;
    }

    public function deleteUser(int $id): bool
    {
        $user = User::find($id);
        if ($user) {
            return $user->delete();
        }

        return false;
    }

    public function searchUsers(array $filters)
    {
        $query = User::query();

        foreach ($filters as $key => $value) {
            if ($key === 'company_name' && $value) {
                $query->whereHas('getCompany', function ($subQuery) use ($value) {
                    $subQuery->where('name', 'like', "%{$value}%");
                });
            } elseif ($value) {
                $query->where($key, 'like', "%{$value}%");
            }
        }

        return $query->with('getCompany')->paginate(10);
    }
}
