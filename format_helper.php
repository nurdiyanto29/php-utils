<?php
// Format nomor identitas (KTP/NIK): 1234567890123456 -> "1234-5678-9012-3456"
function format_nik($nik)
{
    $nik = preg_replace('/[^0-9]/', '', $nik);

    if (strlen($nik) == 16) {
        return substr($nik, 0, 4) . '-' . substr($nik, 4, 4) . '-' . substr($nik, 8, 4) . '-' . substr($nik, 12, 4);
    }
    return $nik;
}

// Unformat NIK: "1234-5678-9012-3456" -> 1234567890123456
function unformat_nik($string)
{
    return preg_replace('/[^0-9]/', '', $string);
}

// Format nomor rekening bank: 1234567890 -> "1234-567-890"
function format_rekening($nomor, $jenis_bank = 'bca')
{
    $nomor = preg_replace('/[^0-9]/', '', $nomor);

    switch (strtolower($jenis_bank)) {
        case 'bca':
            // Format BCA: 123-456-7890
            if (strlen($nomor) == 10) {
                return substr($nomor, 0, 3) . '-' . substr($nomor, 3, 3) . '-' . substr($nomor, 6);
            }
            break;
        case 'mandiri':
            // Format Mandiri: 123-00-4567890-1
            if (strlen($nomor) == 13) {
                return substr($nomor, 0, 3) . '-' . substr($nomor, 3, 2) . '-' . substr($nomor, 5, 7) . '-' . substr($nomor, 12);
            }
            break;
        case 'bni':
            // Format BNI: 1234567890
            return $nomor;
        case 'bri':
            // Format BRI: 1234-01-567890-12-3
            if (strlen($nomor) >= 15) {
                return substr($nomor, 0, 4) . '-' . substr($nomor, 4, 2) . '-' . substr($nomor, 6, 6) . '-' . substr($nomor, 12, 2) . '-' . substr($nomor, 14);
            }
            break;
    }

    return $nomor;
}

// Format kartu kredit: 1234567890123456 -> "1234 5678 9012 3456"
function format_kartu_kredit($nomor, $hide = false)
{
    $nomor = preg_replace('/[^0-9]/', '', $nomor);

    if (strlen($nomor) == 16) {
        $formatted = substr($nomor, 0, 4) . ' ' . substr($nomor, 4, 4) . ' ' . substr($nomor, 8, 4) . ' ' . substr($nomor, 12, 4);

        if ($hide) {
            return substr($nomor, 0, 4) . ' **** **** ' . substr($nomor, 12, 4);
        }

        return $formatted;
    }
    return $nomor;
}

// Format persentase: 0.75 -> "75%"
function format_persentase($nilai, $desimal = 0)
{
    return number_format($nilai * 100, $desimal, ',', '.') . '%';
}

// Format desimal ke persentase dari angka: 75 -> "75%"
function format_persen($angka, $desimal = 0)
{
    return number_format($angka, $desimal, ',', '.') . '%';
}

// Format NPWP: 123456789012345 -> "12.345.678.9-012.345"
function format_npwp($npwp)
{
    $npwp = preg_replace('/[^0-9]/', '', $npwp);

    if (strlen($npwp) == 15) {
        return substr($npwp, 0, 2) . '.' . substr($npwp, 2, 3) . '.' . substr($npwp, 5, 3) . '.' . substr($npwp, 8, 1) . '-' . substr($npwp, 9, 3) . '.' . substr($npwp, 12, 3);
    }
    return $npwp;
}

// Unformat NPWP: "12.345.678.9-012.345" -> 123456789012345
function unformat_npwp($string)
{
    return preg_replace('/[^0-9]/', '', $string);
}

// Format kode pos: 12345 -> "12345" (dengan validasi)
function format_kode_pos($kode)
{
    $kode = preg_replace('/[^0-9]/', '', $kode);

    if (strlen($kode) == 5) {
        return $kode;
    }
    return null;
}

// Format nomor polisi kendaraan: B1234ABC -> "B 1234 ABC"
function format_nopol($nopol)
{
    $nopol = strtoupper(preg_replace('/\s+/', '', $nopol));

    if (preg_match('/^([A-Z]{1,2})(\d{1,4})([A-Z]{1,3})$/', $nopol, $matches)) {
        return $matches[1] . ' ' . $matches[2] . ' ' . $matches[3];
    }
    return $nopol;
}

// Format koordinat GPS: -6.200000, 106.816666 -> "6°12'00.0\"S 106°49'00.0\"E"
function format_koordinat($latitude, $longitude)
{
    $lat_dir = $latitude >= 0 ? 'N' : 'S';
    $lon_dir = $longitude >= 0 ? 'E' : 'W';

    $lat = abs($latitude);
    $lon = abs($longitude);

    $lat_deg = floor($lat);
    $lat_min = floor(($lat - $lat_deg) * 60);
    $lat_sec = round((($lat - $lat_deg) * 60 - $lat_min) * 60, 1);

    $lon_deg = floor($lon);
    $lon_min = floor(($lon - $lon_deg) * 60);
    $lon_sec = round((($lon - $lon_deg) * 60 - $lon_min) * 60, 1);

    return "{$lat_deg}°{$lat_min}'{$lat_sec}\"{$lat_dir} {$lon_deg}°{$lon_min}'{$lon_sec}\"{$lon_dir}";
}

// Format jarak: 1500 -> "1.5 km"
function format_jarak($meter)
{
    if ($meter < 1000) {
        return number_format($meter, 0, ',', '.') . ' m';
    } else {
        return number_format($meter / 1000, 1, ',', '.') . ' km';
    }
}

// Format berat: 1500 -> "1.5 kg"
function format_berat($gram)
{
    if ($gram < 1000) {
        return number_format($gram, 0, ',', '.') . ' gr';
    } else {
        return number_format($gram / 1000, 1, ',', '.') . ' kg';
    }
}

// Format volume: 1500 -> "1.5 L"
function format_volume($mililiter)
{
    if ($mililiter < 1000) {
        return number_format($mililiter, 0, ',', '.') . ' ml';
    } else {
        return number_format($mililiter / 1000, 1, ',', '.') . ' L';
    }
}

// Format durasi waktu: 3665 detik -> "1 jam 1 menit 5 detik"
function format_durasi($detik)
{
    $jam = floor($detik / 3600);
    $menit = floor(($detik % 3600) / 60);
    $sisa_detik = $detik % 60;

    $hasil = [];

    if ($jam > 0) {
        $hasil[] = $jam . ' jam';
    }
    if ($menit > 0) {
        $hasil[] = $menit . ' menit';
    }
    if ($sisa_detik > 0 || empty($hasil)) {
        $hasil[] = $sisa_detik . ' detik';
    }

    return implode(' ', $hasil);
}

// Format durasi singkat: 3665 -> "01:01:05"
function format_durasi_singkat($detik)
{
    $jam = floor($detik / 3600);
    $menit = floor(($detik % 3600) / 60);
    $sisa_detik = $detik % 60;

    return sprintf('%02d:%02d:%02d', $jam, $menit, $sisa_detik);
}

// Format suhu: 25 -> "25°C"
function format_suhu($celsius, $tipe = 'C')
{
    switch (strtoupper($tipe)) {
        case 'F':
            $fahrenheit = ($celsius * 9 / 5) + 32;
            return number_format($fahrenheit, 1, ',', '.') . '°F';
        case 'K':
            $kelvin = $celsius + 273.15;
            return number_format($kelvin, 1, ',', '.') . ' K';
        default:
            return number_format($celsius, 1, ',', '.') . '°C';
    }
}

// Format rating: 4.5 -> "★★★★☆ (4.5)"
function format_rating($nilai, $max = 5)
{
    $penuh = floor($nilai);
    $setengah = ($nilai - $penuh) >= 0.5 ? 1 : 0;
    $kosong = $max - $penuh - $setengah;

    $bintang = str_repeat('★', $penuh) . str_repeat('☆', $setengah) . str_repeat('☆', $kosong);

    return $bintang . ' (' . number_format($nilai, 1, ',', '.') . ')';
}

// Format IP Address dengan mask: "192.168.1.1/24"
function format_ip_dengan_mask($ip, $mask)
{
    return $ip . '/' . $mask;
}

// Format MAC Address: 1a2b3c4d5e6f -> "1A:2B:3C:4D:5E:6F"
function format_mac_address($mac)
{
    $mac = strtoupper(preg_replace('/[^0-9A-Fa-f]/', '', $mac));

    if (strlen($mac) == 12) {
        return substr($mac, 0, 2) . ':' . substr($mac, 2, 2) . ':' . substr($mac, 4, 2) . ':' . substr($mac, 6, 2) . ':' . substr($mac, 8, 2) . ':' . substr($mac, 10, 2);
    }
    return $mac;
}
