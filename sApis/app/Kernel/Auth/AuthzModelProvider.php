<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Kernel\Auth;

use App\Model\UsersModel;
use Hyperf\Utils\Contracts\Arrayable;
use Hyperf\Utils\Str;
use HyperfExt\Auth\Contracts\AuthenticatableInterface;
use HyperfExt\Auth\UserProviders\ModelUserProvider;

/**
 * \App\Foundation\Auth\AuthzModelProvider.
 */
class AuthzModelProvider extends ModelUserProvider
{
    /**
     * retrieveByCredentials
     * @param array $credentials
     * @return \HyperfExt\Auth\Contracts\AuthenticatableInterface|null
     */
    public function retrieveByCredentials(array $credentials): ?AuthenticatableInterface
    {
        if (empty($credentials)
            || (count($credentials) === 1
                && Str::contains($this->firstCredentialKey($credentials), 'password'))) {
            return null;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->newModelQuery();

        foreach ($credentials as $key => $value) {
            if (Str::contains($key, 'password')) {
                continue;
            }

            if (is_array($value) || $value instanceof Arrayable) {
                $query->whereIn($key, $value);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }

    /**
     * validateCredentials
     * @param \HyperfExt\Auth\Contracts\AuthenticatableInterface $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(AuthenticatableInterface $user, array $credentials): bool
    {
        return $user instanceof UsersModel;
    }
}
