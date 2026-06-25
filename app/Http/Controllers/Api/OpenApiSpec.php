<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *     title="Infinite Portal API",
 *     version="1.0.0",
 *     description="REST API for managing staff accounts in Infinite Portal.",
 *     @OA\Contact(email="admin@infiniteability.com.au")
 * )
 *
 * @OA\Server(
 *     url="/api",
 *     description="API Base URL"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class OpenApiSpec {}
