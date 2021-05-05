<?php

class Session extends Database
{
    /**
     * Insert a new login token into the database with the provided
     * user id and put the user id in the Session array.
     *
     * @prototype integer -> void
     *
     * @throws Exception
     *
     * @param integer   $userId  The id of an existing user
     *
     * @return void
     */
    public static function logUser($userId)
    {
        /* Generate a new login token and a new selection token */
        $strong = True;
        $selector = base64_encode(random_bytes(8));
        $token = bin2hex(openssl_random_pseudo_bytes(64, $strong));

        /* Hash the token, so we can store it securely in the database */
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);

        /* Insert the login token into the database */
        self::query("INSERT INTO sessions (id, user_id, selector, token) VALUES (NULL, :user_id, :selector, :token)", [
            ':token' => $hashedToken,
            ':selector' => $selector,
            ':user_id' => (int) $userId
        ]);

        /* Create a string containing the selector and the login token for the cookie */
        $cookieToken = $selector.":".$token;

        /* Send a cookie to the user containing the selection for the login token and the token  */
        setcookie(
            'SUPJEANLOG',
            $cookieToken,
            time()+(3600*24),
            NULL,
            NULL,
            NULL,
            True
        );

        /* Put the userId into the session array */
        $_SESSION['userId'] = $userId;
    }


    /**
     * Re log the user by putting the provided id into the session array.
     *
     * @prototype integer -> void
     *
     * @param integer   $userId  The id of an existing user
     *
     * @return void
     */
    public static function reLog($userId)
    {
        $_SESSION['userId'] = $userId;
    }


    /**
     * Log the user out by un setting his token and his sessions userId and
     * by deleting all his login_tokens in the database.
     *
     * @prototype void -> void
     *
     * @return void
     */
    public static function logOut()
    {
        /* Retrieve the selector and the token from the SUPJEANLOG cookie and store them into two variables */
        list($selector, $token) = explode(':', $_COOKIE['SUPJEANLOG']);

        /* Delete the selector's login token */
        self::query("DELETE FROM sessions WHERE selector = :selector", [':selector' => $selector]);

        /* Delete every login_tokens who have user_id equals to the session's userId if there id any */
        self::query("DELETE FROM sessions WHERE user_id = :user_id", [':user_id' => $_SESSION['userId']]);

        /* Unset the cookie and the sessions's userId */
        unset($_SESSION['userId']);
        setcookie('SUPJEANLOG', '', 1);
        unset($_COOKIE['SUPJEANLOG']);
    }


    /**
     * Check if the user is logged in by checking if he has an userId field
     * into his session array or by checking his token if the has one.
     *
     * @prototype void -> bool
     *
     * @return bool     This value tells us if the user is logged in or not.
     */
    public static function isLogged()
    {
        /* Check if there is a userId field in the session array */
        if (isset($_SESSION['userId']))
        {
            /* User already logged in */
            return True;
        }
        else
        {
            /* Check if the user has the SUPJEANLOG cookie */
            if (isset($_COOKIE['SUPJEANLOG']))
            {
                /* Retrieve the selector and the token from the SUPJEANLOG cookie and store them into two variables */
                list($selector, $token) = explode(':', $_COOKIE['SUPJEANLOG']);

                /* Check if the token exists */
                $result = self::query("SELECT user_id, token FROM sessions WHERE selector = :selector", [":selector" => $selector])[0];
                if ($result)
                {
                    /* Verify the token */
                    if (password_verify($token, $result['token']))
                    {
                        /* Re log the user */
                        Session::reLog($result['user_id']);
                        return True;
                    }
                    else
                    {
                        /* Wrong token, log the user out */
                        Session::logOut();
                        return False;
                    }
                }
                else
                {
                    /* Wrong token */
                    return False;
                }
            }
            else
            {
                /* The user doesn't have the cookie */
                return False;
            }
        }
    }


    /**
     * Get the field userId from the session array.
     *
     * @prototype void -> int
     *
     * @return integer  The session's userId
     */
    public static function getId()
    {
        return $_SESSION['userId'];
    }
}