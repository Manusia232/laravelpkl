<?php

/**
 * ============================================================
 * BAS TAG DEFINITION
 * ============================================================
 */
if (!function_exists('basDefinitions')) {
    function basDefinitions()
    {
        return [
            1 => [
                'key' => 'tahun_rilis',
                'label' => 'Tahun Rilis',
                'group' => 'Informasi Dasar',
                'numeric' => true,
                'unit' => '',
            ],
            2 => [
                'key' => 'material',
                'label' => 'Material',
                'group' => 'Spesifikasi Body',
                'numeric' => false,
                'unit' => '',
            ],
            3 => [
                'key' => 'trunk',
                'label' => 'Kapasitas Max Trunk',
                'group' => 'Spesifikasi Body',
                'numeric' => true,
                'unit' => 'L',
            ],
            4 => [
                'key' => 'frunk',
                'label' => 'Kapasitas Max Frunk',
                'group' => 'Spesifikasi Body',
                'numeric' => true,
                'unit' => 'L',
            ],
            5 => [
                'key' => 'power',
                'label' => 'Tenaga Maksimum',
                'group' => 'Performa',
                'numeric' => true,
                'unit' => 'kW',
            ],
            6 => [
                'key' => 'torque',
                'label' => 'Torsi Maksimum',
                'group' => 'Performa',
                'numeric' => true,
                'unit' => 'Nm',
            ],
            7 => [
                'key' => 'battery',
                'label' => 'Kapasitas Baterai',
                'group' => 'Baterai & Charging',
                'numeric' => true,
                'unit' => 'kWh',
            ],
            8 => [
                'key' => 'range',
                'label' => 'Jarak Tempuh Maksimum',
                'group' => 'Baterai & Charging',
                'numeric' => true,
                'unit' => 'km',
            ],
            9 => [
                'key' => 'dc_charging',
                'label' => 'Daya Charging DC Maksimum',
                'group' => 'Baterai & Charging',
                'numeric' => true,
                'unit' => 'kW',
            ],
            10 => [
                'key' => 'ac_charging',
                'label' => 'Daya Charging AC Maksimum',
                'group' => 'Baterai & Charging',
                'numeric' => true,
                'unit' => 'kW',
            ],
        ];
    }
}

/**
 * ============================================================
 * GET SPEC SOURCE - Ambil sumber data spesifikasi
 * ============================================================
 */
if (!function_exists('getSpecSource')) {
    function getSpecSource($model)
    {
        if (is_object($model)) {
            // Laravel: relasi specification (hasOne)
            if (isset($model->specification) && $model->specification) {
                return $model->specification;
            }
            return $model;
        }
        if (is_array($model)) {
            return $model['specification'] ?? $model;
        }
        return $model;
    }
}

/**
 * ============================================================
 * EXTRACT BAS TAGS
 * ============================================================
 */
if (!function_exists('extractBasTags')) {
    function extractBasTags($model)
    {
        $found = [];
        $specColumns = ['body', 'performa', 'kelistrikan', 'keselamatan', 'fiturlainya'];

        // Ambil dari relasi specification
        $source = getSpecSource($model);
        
        foreach ($specColumns as $col) {
            if (is_object($source)) {
                $rawData = $source->{$col} ?? null;
            } elseif (is_array($source)) {
                $rawData = $source[$col] ?? null;
            } else {
                continue;
            }

            if (empty($rawData)) continue;

            if (is_string($rawData)) {
                $data = json_decode($rawData, true);
            } else {
                $data = $rawData;
            }

            if (!is_array($data)) continue;

            foreach ($data as $key => $val) {
                if (!is_string($val)) continue;

                if (preg_match('/\(bas(\d+)\)/i', $val, $match)) {
                    $tagNum = (int) $match[1];
                    if ($tagNum < 1 || $tagNum > 10) continue;

                    $cleanValue = preg_replace('/\s*\(bas' . $tagNum . '\)\s*/i', '', $val);
                    $cleanValue = trim($cleanValue);

                    $found[$tagNum] = [
                        'value' => $cleanValue,
                        'raw' => $val,
                        'source_key' => $key,
                        'source_col' => $col,
                    ];
                }
            }
        }

        ksort($found);
        return $found;
    }
}

/**
 * ============================================================
 * GET SPEC TAGS FROM BAS (Untuk preview/kartu)
 * ============================================================
 */
if (!function_exists('getSpecTagsFromBas')) {
    function getSpecTagsFromBas($basData)
    {
        $tags = [];
        $priority = [1, 5, 7, 8];

        foreach ($priority as $tagNum) {
            if (!isset($basData[$tagNum])) continue;
            
            $value = $basData[$tagNum]['value'] ?? null;
            if ($value === null || $value === '' || $value === '-') continue;

            $tags[] = $value;
            if (count($tags) >= 3) break;
        }

        return $tags;
    }
}

/**
 * ============================================================
 * GET ALL SPECS
 * ============================================================
 */
if (!function_exists('getAllSpecs')) {
    function getAllSpecs($model)
    {
        $allSpecs = [];
        $columns = [
            'body' => 'Spesifikasi Body',
            'performa' => 'Performa',
            'kelistrikan' => 'Baterai & Charging',
        ];

        $source = getSpecSource($model);

        foreach ($columns as $col => $groupName) {
            if (is_object($source)) {
                $rawData = $source->{$col} ?? null;
            } elseif (is_array($source)) {
                $rawData = $source[$col] ?? null;
            } else {
                continue;
            }

            if (empty($rawData)) continue;

            if (is_string($rawData)) {
                $data = json_decode($rawData, true);
            } else {
                $data = $rawData;
            }

            if (!is_array($data)) continue;

            foreach ($data as $key => $val) {
                if (is_array($val) || is_object($val)) continue;

                $val = (string) $val;
                $cleanVal = preg_replace('/\s*\(bas\d+\)\s*/i', '', $val);
                $cleanVal = trim($cleanVal);

                $label = str_replace('_', ' ', $key);
                $label = ucwords($label);

                if (!isset($allSpecs[$groupName])) {
                    $allSpecs[$groupName] = [];
                }

                $allSpecs[$groupName][$key] = [
                    'label' => $label,
                    'value' => $cleanVal !== '' ? $cleanVal : '—',
                ];
            }
        }

        return $allSpecs;
    }
}

/**
 * ============================================================
 * PARSE NUMERIC VALUE
 * ============================================================
 */
if (!function_exists('parseNumericValue')) {
    function parseNumericValue($str)
    {
        if ($str === null) return null;
        $str = trim((string) $str);
        if ($str === '') return null;

        $str = preg_replace('/\s*\(bas\d+\)\s*/i', '', $str);
        $str = trim($str);

        if (!preg_match('/-?\d+(?:[.,]\d+)?/', $str, $match)) {
            return null;
        }

        $number = $match[0];
        if (str_contains($number, ',')) {
            $number = str_replace(',', '.', $number);
        }

        if (substr_count($number, '.') === 1 && preg_match('/\.\d{3}$/', $number)) {
            $number = str_replace('.', '', $number);
        }

        return is_numeric($number) ? (float) $number : null;
    }
}

/**
 * ============================================================
 * GET BAS VALUE
 * ============================================================
 */
if (!function_exists('getBasValue')) {
    function getBasValue($basData, $tagNum, $default = null)
    {
        if (!is_array($basData)) return $default;
        return $basData[$tagNum]['value'] ?? $default;
    }
}

/**
 * ============================================================
 * GET BAS LABEL
 * ============================================================
 */
if (!function_exists('getBasLabel')) {
    function getBasLabel($tagNum)
    {
        $definitions = basDefinitions();
        return $definitions[$tagNum]['label'] ?? "BAS {$tagNum}";
    }
}

/**
 * ============================================================
 * GET BAS UNIT
 * ============================================================
 */
if (!function_exists('getBasUnit')) {
    function getBasUnit($tagNum)
    {
        $definitions = basDefinitions();
        return $definitions[$tagNum]['unit'] ?? '';
    }
}

/**
 * ============================================================
 * CHECK BAS EXISTS
 * ============================================================
 */
if (!function_exists('hasBasTag')) {
    function hasBasTag($basData, $tagNum)
    {
        if (!is_array($basData)) return false;
        if (!isset($basData[$tagNum])) return false;
        
        $value = $basData[$tagNum]['value'] ?? null;
        return $value !== null && $value !== '' && $value !== '-';
    }
}