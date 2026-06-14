<?php

class ApiAuth
{
    protected $db;
    protected $client;

    public function __construct()
    {
        $this->db = (new Config())->db();
    }

    /*
    |--------------------------------------------------------------------------
    | Validate Token
    |--------------------------------------------------------------------------
    */

    public function authenticate()
    {
        $headers = getallheaders();

        $authHeader =
            $headers['Authorization']
            ??
            $headers['authorization']
            ??
            '';

        if (
            empty($authHeader)
            ||
            !str_starts_with($authHeader,'Bearer ')
        ) {

            $this->response(
                401,
                'Access Token Required'
            );
        }

        $token = trim(
            str_replace(
                'Bearer',
                '',
                $authHeader
            )
        );

        $stmt = $this->db->prepare("
            SELECT
                t.*,
                c.id as client_id,
                c.name,
                c.status as client_status
            FROM api_tokens t

            INNER JOIN api_clients c
            ON c.id=t.client_id

            WHERE t.access_token=?
            LIMIT 1
        ");

        $stmt->execute([
            $token
        ]);

        $client = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$client) {

            $this->response(
                401,
                'Invalid Token'
            );
        }

        if (!$client->status) {

            $this->response(
                401,
                'Token Disabled'
            );
        }

        if (!$client->client_status) {

            $this->response(
                401,
                'Client Disabled'
            );
        }

        if (
            !empty($client->expires_at)
            &&
            strtotime($client->expires_at) < time()
        ) {

            $this->response(
                401,
                'Token Expired'
            );
        }

        $update = $this->db->prepare("
            UPDATE api_tokens
            SET last_used_at=NOW()
            WHERE id=?
        ");

        $update->execute([
            $client->id
        ]);

        $this->client = $client;

        return $client;
    }

    /*
    |--------------------------------------------------------------------------
    | Check Permission
    |--------------------------------------------------------------------------
    */

    public function permission($permissionKey)
    {
        $stmt = $this->db->prepare("
            SELECT p.id

            FROM api_client_permissions cp

            INNER JOIN api_permissions p
            ON p.id=cp.permission_id

            WHERE cp.client_id=?
            AND p.permission_key=?

            LIMIT 1
        ");

        $stmt->execute([
            $this->client->client_id,
            $permissionKey
        ]);

        if (!$stmt->fetch()) {

            $this->response(
                403,
                'Permission Denied'
            );
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | Log API
    |--------------------------------------------------------------------------
    */

    public function log(
        $endpoint,
        $method,
        $statusCode
    )
    {
        $stmt = $this->db->prepare("
            INSERT INTO api_logs
            (
                client_id,
                endpoint,
                method,
                ip_address,
                response_code,
                created_at
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                NOW()
            )
        ");

        $stmt->execute([
            $this->client->client_id,
            $endpoint,
            $method,
            $_SERVER['REMOTE_ADDR'] ?? '',
            $statusCode
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | JSON Response
    |--------------------------------------------------------------------------
    */

    private function response(
        $code,
        $message
    )
    {
        http_response_code($code);

        echo json_encode([
            'success' => false,
            'message' => $message
        ]);

        exit;
    }
}