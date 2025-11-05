<?php

namespace Modules\SysAdmin\Repository;

use Modules\SysAdmin\Core\Eloquent\Repository;
use Illuminate\Support\Facades\Hash;
use Modules\SysAdmin\Interfaces\UserInterface;

/**
 * Class UserRepository.
 *
 * @package namespace App\Entities\Modules\SysAdmin\Repository;
 */
class UserRepository extends Repository implements UserInterface
{

    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return 'Modules\SysAdmin\Models\User';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function create($data)
    {
        $data['password'] =  Hash::make($data['password']);
        $user = parent::create($data);
        return $user;
    }

    public function update($data, $id, $attribute = 'id')
    {
        $user = $this->find($id);
        if (isset($data['password '])) {
            if (Hash::check($user->password, $data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] =  Hash::make($data['password']);
            }
        } else {
            $data['password'] = $user->password;
        }
        parent::update($data, $id, $attribute);
        return $user;
    }
}
