package controllers

import (
	"backend_golang/config"
	"backend_golang/models"
	"backend_golang/setup"
	"net/http"
	"time"

	"github.com/gin-gonic/gin"
)

func GetPenduduk(c *gin.Context) {
	userData, exists := c.Get("user")
	if !exists {
		c.JSON(http.StatusUnauthorized, gin.H{"error": "User tidak terautentikasi"})
		return
	}

	user := userData.(models.User)
	role := user.Level
	
	var total int64
	var pendudukList []models.Penduduk
	query := setup.DB.Model(&models.Penduduk{})

	if role == "enum" {
		query = query.Where("user_id = ?", user.Id)
	}

	// Hitung total
	query.Count(&total)

	if err := query.Preload("Keluarga").Preload("User").Find(&pendudukList).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal mengambil data"})
		return
	}

	hasil := make([]map[string]interface{}, 0)
	for _, data := range pendudukList {
		hasil = append(hasil, map[string]interface{}{
			"id":          data.Id,
			"kels_id":     data.KelsId,
			"nomer_kk":    data.Keluarga.NoKk,
			"nik":         data.Nik,
			"nama":        data.Nama,
			"tmp_lhr":     data.TmpLahir,
			"tgl_lhr":     data.TglLahir,
			"kelamin":     config.GetKelamin(int(data.Kelamin)),
			"stat_kawin":  config.GetStatusKawin(int(data.StatKawin)),
			"hub_kel":     config.GetHubunganKeluarga(int(data.HubKel)),
			"warga_neg":   config.GetWargaNegara(int(data.WargaNeg)),
			"agama":       config.GetAgama(int(data.Agama)),
			"pendidikan":  config.GetPendidikan(int(data.Pendidikan)),
			"pekerjaan":   config.GetPekerjaan(int(data.Pekerjaan)),
			"ayah":        data.Ayah,
			"ibu":         data.Ibu,
			"kepala_kel":  data.Keluarga.KkNama,
			"no_hp":       data.NoHp,
			"domisili":    data.Domisili,
			"stat":        config.GetStatus(int(data.Status)),
			"user_id":     data.User.Name,
		})
	}

	c.JSON(http.StatusOK, gin.H{
		"success": true,
		"data": gin.H{
			"data":        hasil,
			"total":       total,
		},
	})
}

func GetLatestPenduduk(c *gin.Context) {
	userData, exists := c.Get("user")
	if !exists {
		c.JSON(http.StatusUnauthorized, gin.H{"error": "User tidak terautentikasi"})
		return
	}

	user := userData.(models.User)
	role := user.Level

	var pendudukList []models.Penduduk
	query := setup.DB.Order("created_at DESC").Limit(5)

	if role == "enum" {
		query = query.Where("user_id = ?", user.Id)
	}

	if err := query.Preload("Keluarga").Preload("User").Find(&pendudukList).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal mengambil data"})
		return
	}

	hasil := make([]map[string]interface{}, 0)
	for _, data := range pendudukList {
		hasil = append(hasil, map[string]interface{}{
			"id":         data.Id,
			"kk":         data.Keluarga.NoKk,
			"nik":        data.Nik,
			"nama":       data.Nama,
			"kepala_kel": data.Keluarga.KkNama,
			"status":     config.GetStatus(int(data.Status)),
			"user_id":    data.User.Name,
		})
	}

	c.JSON(http.StatusOK, hasil)
}

func ShowPenduduk(c *gin.Context) {
	id := c.Param("id")

	var penduduk models.Penduduk
	if err := setup.DB.Preload("Keluarga").Preload("User").First(&penduduk, id).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "Data tidak ditemukan"})
		return
	}

	hasil := map[string]interface{}{
		"id":          penduduk.Id,
		"nomer_kk":    penduduk.Keluarga.NoKk,
		"nik":         penduduk.Nik,
		"nama":        penduduk.Nama,
		"tmp_lhr":     penduduk.TmpLahir,
		"tgl_lhr":     penduduk.TglLahir,
		"kelamin":     config.GetKelamin(int(penduduk.Kelamin)),
		"stat_kawin":  config.GetStatusKawin(int(penduduk.StatKawin)),
		"hub_kel":     config.GetHubunganKeluarga(int(penduduk.HubKel)),
		"warga_neg":   config.GetWargaNegara(int(penduduk.WargaNeg)),
		"agama":       config.GetAgama(int(penduduk.Agama)),
		"pendidikan":  config.GetPendidikan(int(penduduk.Pendidikan)),
		"pekerjaan":   config.GetPekerjaan(int(penduduk.Pekerjaan)),
		"ayah":        penduduk.Ayah,
		"ibu":         penduduk.Ibu,
		"kepala_kel":  penduduk.Keluarga.KkNama,
		"no_hp":       penduduk.NoHp,
		"domisili":    penduduk.Domisili,
		"stat":        config.GetStatus(int(penduduk.Status)),
		"user_id":     penduduk.User.Name,
	}

	c.JSON(http.StatusOK, gin.H{"data": hasil})
}

func AddPenduduk(c *gin.Context) {
	var input struct {
		KelsId     int64     `json:"kels_id" binding:"required"`
		Nik        int64     `json:"nik" binding:"required"`
		Nama       string    `json:"nama" binding:"required"`
		TmpLahir   string    `json:"tmp_lhr" binding:"required"`
		TglLahir   time.Time `json:"tgl_lhr" binding:"required"`
		Kelamin    int8      `json:"kelamin" binding:"required"`
		StatKawin  int8      `json:"stat_kawin" binding:"required"`
		HubKel     int8      `json:"hub_kel" binding:"required"`
		WargaNeg   int8      `json:"warga_neg" binding:"required"`
		Agama      int8      `json:"agama" binding:"required"`
		Pendidikan int8      `json:"pendidikan" binding:"required"`
		Pekerjaan  int8      `json:"pekerjaan" binding:"required"`
		Ayah       string    `json:"ayah" binding:"required"`
		Ibu        string    `json:"ibu" binding:"required"`
		NoHp       string    `json:"no_hp" binding:"required"`
		Domisili   string    `json:"domisili" binding:"required"`
		Status     int8      `json:"stat" binding:"required"`
		UserId     int64     `json:"user_id" binding:"required"`
	}

	if err := c.ShouldBindJSON(&input); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{
			"valid":   false,
			"message": "Pastikan form sudah terisi dengan benar",
		})
		return
	}

	penduduk := models.Penduduk{
		KelsId:     input.KelsId,
		Nik:        input.Nik,
		Nama:       input.Nama,
		TmpLahir:   input.TmpLahir,
		TglLahir:   input.TglLahir,
		Kelamin:    input.Kelamin,
		StatKawin:  input.StatKawin,
		HubKel:     input.HubKel,
		WargaNeg:   input.WargaNeg,
		Agama:      input.Agama,
		Pendidikan: input.Pendidikan,
		Pekerjaan:  input.Pekerjaan,
		Ayah:       input.Ayah,
		Ibu:        input.Ibu,
		NoHp:       input.NoHp,
		Domisili:   input.Domisili,
		Status:     input.Status,
		UserId:     input.UserId,
	}

	if err := setup.DB.Create(&penduduk).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{
			"valid":   false,
			"message": "Gagal menambah penduduk",
		})
		return
	}

	c.JSON(http.StatusOK, gin.H{
		"valid":   true,
		"message": "Sukses menambah penduduk",
	})
}

func UpdatePenduduk(c *gin.Context) {
	id := c.Param("id")

	var input struct {
		KelsId     int64     `json:"kels_id" binding:"required"`
		Nik        int64     `json:"nik" binding:"required"`
		Nama       string    `json:"nama" binding:"required"`
		TmpLahir   string    `json:"tmp_lhr" binding:"required"`
		TglLahir   time.Time `json:"tgl_lhr" binding:"required"`
		Kelamin    int8      `json:"kelamin" binding:"required"`
		StatKawin  int8      `json:"stat_kawin" binding:"required"`
		HubKel     int8      `json:"hub_kel" binding:"required"`
		WargaNeg   int8      `json:"warga_neg" binding:"required"`
		Agama      int8      `json:"agama" binding:"required"`
		Pendidikan int8      `json:"pendidikan" binding:"required"`
		Pekerjaan  int8      `json:"pekerjaan" binding:"required"`
		Ayah       string    `json:"ayah" binding:"required"`
		Ibu        string    `json:"ibu" binding:"required"`
		NoHp       string    `json:"no_hp" binding:"required"`
		Domisili   string    `json:"domisili" binding:"required"`
		Status     int8      `json:"stat" binding:"required"`
		UserId     int64     `json:"user_id" binding:"required"`
	}

	if err := c.ShouldBindJSON(&input); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{
			"status":  false,
			"message": "Pastikan form sudah terisi dengan benar",
		})
		return
	}

	var penduduk models.Penduduk
	if err := setup.DB.First(&penduduk, id).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{
			"status":  false,
			"message": "Data tidak ditemukan",
		})
		return
	}

	if err := setup.DB.Model(&penduduk).Updates(input).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{
			"status":  false,
			"message": "Gagal mengupdate penduduk",
		})
		return
	}

	c.JSON(http.StatusOK, gin.H{
		"status":  true,
		"message": "Sukses mengupdate penduduk",
	})
}

func DeletePenduduk(c *gin.Context) {
	id := c.Param("id")

	var penduduk models.Penduduk
	if err := setup.DB.First(&penduduk, id).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{
			"message": "Data penduduk tidak ditemukan",
		})
		return
	}

	if err := setup.DB.Delete(&penduduk).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{
			"message": "Gagal menghapus data penduduk",
		})
		return
	}

	c.JSON(http.StatusOK, gin.H{
		"message": "Data penduduk berhasil dihapus",
	})
}