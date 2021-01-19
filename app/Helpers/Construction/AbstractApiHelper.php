<?php

namespace App\Helpers\Construction;

abstract class AbstractApiHelper {
    const KRS = 'krs';
    const NIP = 'nip';
    const REGON = 'regon';
    const AVAILABLE_VALUES = [
        self::KRS, self::NIP, self::REGON
    ];

    public function search(array $request){}
}
