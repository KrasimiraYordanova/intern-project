<?php

namespace App\Http\Controllers;
/**
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     scheme="bearer",
 *     in="header",
 *     name="bearerAuth",
 *     securityScheme="bearerAuth",
 * )
 */
abstract class Controller
{
    //
}
