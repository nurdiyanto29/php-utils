<?php

// Format angka ke bentuk rupiah: 10000 -> Rp10.000
function format_rupiah($angka)
{
    return 'Rp' . number_format($angka, 0, ',', '.');
}

// Menghapus format rupiah jadi angka: "Rp10.000" -> 10000
function unformat_rupiah($string)
{
    $angka = preg_replace('/[^\d]/', '', $string);
    return (int) $angka;
}

// Konversi angka ke terbilang rupiah: 12500 -> "dua belas ribu lima ratus rupiah"
function terbilang_rupiah($angka)
{
    $bilangan = [
        '', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'
    ];

    if ($angka < 12) {
        return $bilangan[$angka];
    } elseif ($angka < 20) {
        return $bilangan[$angka - 10] . ' belas';
    } elseif ($angka < 100) {
        return $bilangan[floor($angka / 10)] . ' puluh ' . $bilangan[$angka % 10];
    } elseif ($angka < 200) {
        return 'seratus ' . terbilang_rupiah($angka - 100);
    } elseif ($angka < 1000) {
        return $bilangan[floor($angka / 100)] . ' ratus ' . terbilang_rupiah($angka % 100);
    } elseif ($angka < 2000) {
        return 'seribu ' . terbilang_rupiah($angka - 1000);
    } elseif ($angka < 1000000) {
        return terbilang_rupiah(floor($angka / 1000)) . ' ribu ' . terbilang_rupiah($angka % 1000);
    } elseif ($angka < 1000000000) {
        return terbilang_rupiah(floor($angka / 1000000)) . ' juta ' . terbilang_rupiah($angka % 1000000);
    } elseif ($angka < 1000000000000) {
        return terbilang_rupiah(floor($angka / 1000000000)) . ' miliar ' . terbilang_rupiah($angka % 1000000000);
    } elseif ($angka < 1000000000000000) {
        return terbilang_rupiah(floor($angka / 1000000000000)) . ' triliun ' . terbilang_rupiah($angka % 1000000000000);
    } else {
        return 'angka terlalu besar';
    }
}

// Konversi angka ke terbilang lengkap dengan kata “rupiah”
function terbilang_dengan_rupiah($angka)
{
    return trim(terbilang_rupiah($angka)) . ' rupiah';
}

// Format rupiah dengan desimal (misalnya untuk akuntansi)
function format_rupiah_decimal($angka)
{
    return 'Rp' . number_format($angka, 2, ',', '.');
}

// Pembulatan ke ribuan terdekat: 12870 -> 13000
function pembulatan_rupiah($angka)
{
    return round($angka, -3);
}
