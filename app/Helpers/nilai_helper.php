<?php

if (!function_exists('konversi_nilai_ke_bobot')) {
    function konversi_nilai_ke_bobot($nilai)
    {
        switch ($nilai) {
            case 'A':
                return 4.0;
            case 'B':
                return 3.0;
            case 'C':
                return 2.0;
            case 'D':
                return 1.0;
            case 'E':
                return 0.0;
            default:
                return 0.0;
        }
    }
}
