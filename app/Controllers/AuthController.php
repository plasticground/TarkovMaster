<?php


namespace App\Controllers;


use App\Models\Request;

class AuthController
{
    public const AUTH_STATUS = 0;
    public const AUTH_MESSAGE = 'message';

    /**
     * @param Request $request
     * @return array
     */
    public static function auth(Request $request)
    {
        $token = $request->get('token');
        $auth = $request->get('auth');

        if ($auth === 'logout') {
            unset($_SESSION['auth']);
            header('Location: /home');
        }

        if (isset($_SESSION['auth']) && $_SESSION['auth'] > 0) {
            return [true, self::AUTH_MESSAGE => 'alreadyAuth'];
        }

        $check = self::checkToken($token);
        if ($check[0] !== false) {
            $_SESSION['auth'] = 1;
            return [true, self::AUTH_MESSAGE => $check[1]];
        }

        return [false, self::AUTH_MESSAGE => $check[1]];
    }

    /**
     * @param string|null $token
     * @return array
     */
    public static function checkToken(?string $token)
    {
        if (empty($token)) {
            return [false, 'successAuth'];
        }

        $success = stripos($token, AUTH_TOKEN);

        return [$success, 'errorAuth'];
    }
}