<?php

/*
 * This file is part of the Osynapsy package.
 *
 * (c) Pietro Celeste <p.celeste@osynapsy.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Osynapsy\Jwt;

/**
 * Description of Encoder
 *
 * @author Pietro Celeste <p.celeste@osynapsy.net>
 */
class Encoder
{
    const HEADER = '{"alg": "HS256", "typ": "JWT"}';

    public function tokenFactory($secretKey, array $fields = [], $expiry = null)
    {
        if (!empty($expiry)) {
            $fields['tokenExpiry'] = $expiry;
        }
        $b64Header = $this->headerFactory(self::HEADER);
        $b64Payload = $this->payloadFactory($fields);
        $headerPayload = $this->headerPayloadFacory($b64Header, $b64Payload);
        $signature = $this->signatureFactory($secretKey, $headerPayload);
        return $this->tokenAssembly($headerPayload, $signature);
    }

    protected function headerFactory($header)
    {
        return base64_encode($header);
    }

    protected function headerPayloadFacory($b64Header, $b64Payload)
    {
        return $b64Header . '.' . $b64Payload;
    }

    protected function payloadFactory($fields)
    {
        return base64_encode(json_encode($fields));
    }

    protected function signatureFactory($secretKey, $headerPayload)
    {
        return base64_encode(hash_hmac('sha256', $headerPayload, $secretKey, true));
    }

    protected function tokenAssembly($headerPayload, $signature)
    {
        return $headerPayload . '.' . $signature;
    }

    public function __invoke($secretKey, $fields, $expiry)
    {
        return $this->tokenFactory($secretKey, $fields, $expiry);
    }
}
