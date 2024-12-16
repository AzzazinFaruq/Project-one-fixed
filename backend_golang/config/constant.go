package config

// StatusSurat - Status surat dan keterangannya
var StatusSurat = map[int]string{
	1: "Selesai",
	2: "Diproses",
	9: "Menunggu",
}

var StatusSuratKet = map[int]string{
	1: "Surat telah selesai, silahkan mengambilnya di kantor %%level%%.",
	2: "Surat telah dicetak dan menunggu tanda tangan %%kep_level%% atau yang mewakili.",
	9: "Permohonan surat menunggu proses verifikasi oleh tim admin.",
}

// Golongan - Pangkat dan golongan
var Golongan = map[string]string{
	"I.a":  "Juru Muda",
	"I.b":  "Juru Muda Tingkat I",
	"I.c":  "Juru",
	"I.d":  "Juru Tingkat I",
	"II.a": "Pengatur Muda",
	"II.b": "Pengatur Muda Tingkat I",
	"II.c": "Pengatur",
	"II.d": "Pengatur Tingkat I",
	"III.a": "Penata Muda",
	"III.b": "Penata Muda Tingkat I",
	"III.c": "Penata",
	"III.d": "Penata Tingkat I",
	"IV.a": "Pembina",
	"IV.b": "Pembina Tingkat I",
	"IV.c": "Pembina Utama Muda",
	"IV.d": "Pembina Utama Madya",
	"IV.e": "Pembina Utama",
}

// JenisKelamin - Jenis kelamin
var JenisKelamin = map[int]string{
	1: "LAKI-LAKI",
	2: "PEREMPUAN",
	3: "LAINNYA",
}

// JK - Singkatan jenis kelamin
var JK = map[int]string{
	1: "Lk",
	2: "Pr",
}

// Agama - Daftar agama
var Agama = map[int]string{
	1: "ISLAM",
	2: "KRISTEN",
	3: "KATHOLIK",
	4: "HINDU",
	5: "BUDHA",
	6: "KHONGHUCU",
	7: "KEPERCAYAAN TERHADAP TUHAN YME / LAINNYA",
}

// StatusKawin - Status perkawinan
var StatusKawin = map[int]string{
	1: "BELUM KAWIN",
	2: "KAWIN",
	3: "CERAI HIDUP",
	4: "CERAI MATI",
}

// HubunganKeluarga - Status hubungan dalam keluarga
var HubunganKeluarga = map[int]string{
	1:  "KEPALA KELUARGA",
	2:  "SUAMI",
	3:  "ISTRI",
	4:  "ANAK",
	5:  "MENANTU",
	6:  "CUCU",
	7:  "ORANGTUA",
	8:  "MERTUA",
	9:  "FAMILI LAIN",
	10: "PEMBANTU",
	11: "LAINNYA",
}

// Pendidikan - Tingkat pendidikan
var Pendidikan = map[int]string{
	1:  "TIDAK / BELUM SEKOLAH",
	2:  "BELUM TAMAT SD/SEDERAJAT",
	3:  "TAMAT SD / SEDERAJAT",
	4:  "SLTP / SEDERAJAT",
	5:  "SLTA / SEDERAJAT",
	6:  "DIPLOMA I/II",
	7:  "AKADEMI/DIPLOMA III/S. MUDA",
	8:  "DIPLOMA IV/STRATA I",
	9:  "STRATA II",
	10: "STRATA III",
}

// WargaNegara - Kewarganegaraan
var WargaNegara = map[int]string{
	1: "WNI",
	2: "WNA",
}

// Pekerjaan - Daftar pekerjaan
var Pekerjaan = map[int]string{
	1:  "BELUM/TIDAK BEKERJA",
	2:  "MENGURUS RUMAH TANGGA",
	3:  "PELAJAR/MAHASISWA",
	4:  "PENSIUNAN",
	5:  "PEGAWAI NEGERI SIPIL (PNS)",
	6:  "TENTARA NASIONAL INDONESIA (TNI)",
	7:  "KEPOLISIAN RI (POLRI)",
	8:  "PERDAGANGAN",
	9:  "PETANI/PEKEBUN",
	10: "PETERNAK",
	// ... sisanya sama seperti di atas sampai 89
	89: "LAINNYA",
}

// Status - Status aktif/tidak aktif
var Status = map[int]string{
	1: "AKTIF",
	2: "TIDAK AKTIF",
}

// Domisili - Status domisili
var Domisili = map[int]string{
	1: "PENDUDUK TETAP",
	2: "PENDUDUK DOMISILI",
}

// Helper functions untuk mendapatkan nilai string
func GetStatusSurat(code int) string {
	if val, ok := StatusSurat[code]; ok {
		return val
	}
	return ""
}

func GetStatusSuratKet(code int) string {
	if val, ok := StatusSuratKet[code]; ok {
		return val
	}
	return ""
}

func GetGolongan(code string) string {
	if val, ok := Golongan[code]; ok {
		return val
	}
	return ""
}

func GetKelamin(code int) string {
	if val, ok := JenisKelamin[code]; ok {
		return val
	}
	return ""
}

func GetJK(code int) string {
	if val, ok := JK[code]; ok {
		return val
	}
	return ""
}

func GetAgama(code int) string {
	if val, ok := Agama[code]; ok {
		return val
	}
	return ""
}

func GetStatusKawin(code int) string {
	if val, ok := StatusKawin[code]; ok {
		return val
	}
	return ""
}

func GetHubunganKeluarga(code int) string {
	if val, ok := HubunganKeluarga[code]; ok {
		return val
	}
	return ""
}

func GetPendidikan(code int) string {
	if val, ok := Pendidikan[code]; ok {
		return val
	}
	return ""
}

func GetWargaNegara(code int) string {
	if val, ok := WargaNegara[code]; ok {
		return val
	}
	return ""
}

func GetPekerjaan(code int) string {
	if val, ok := Pekerjaan[code]; ok {
		return val
	}
	return ""
}

func GetStatus(code int) string {
	if val, ok := Status[code]; ok {
		return val
	}
	return ""
}

func GetDomisili(code int) string {
	if val, ok := Domisili[code]; ok {
		return val
	}
	return ""
}


