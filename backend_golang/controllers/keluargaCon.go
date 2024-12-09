package controllers

import (
	"backend_golang/models"
	"backend_golang/setup"
	"net/http"
	
	"github.com/gin-gonic/gin"
)

func Latest(c *gin.Context) {
	userData, _ := c.Get("user")
	user := userData.(models.User)
	role := user.Level
	
	var keluargaList []models.Keluarga
	query := setup.DB.Preload("User").Order("created_at DESC").Limit(5)
	
	if role == "enum" {
		query = query.Where("user_id = ?", user.Id)
	}
	
	if err := query.Find(&keluargaList).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal mengambil data"})
		return
	}

	hasil := make([]map[string]interface{}, 0)
	for _, data := range keluargaList {
		hasil = append(hasil, map[string]interface{}{
			"id":      data.Id,
			"kk":      data.NoKk,
			"nik":     data.KkNik,
			"status":  data.Status,
			"nama":    data.KkNama,
			"user_id": data.User.Name,
		})
	}

	c.JSON(http.StatusOK, hasil)
}

func LatestForInput(c *gin.Context) {
	userData, _ := c.Get("user")
	user := userData.(models.User)
	role := user.Level
	
	var keluargaList []models.Keluarga
	query := setup.DB.Preload("User").Order("created_at DESC").Limit(1)
	
	if role == "enum" {
		query = query.Where("user_id = ?", user.Id)
	}
	
	if err := query.Find(&keluargaList).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal mengambil data"})
		return
	}

	hasil := make([]map[string]interface{}, 0)
	for _, data := range keluargaList {
		hasil = append(hasil, map[string]interface{}{
			"id":      data.Id,
			"kk":      data.NoKk,
			"nik":     data.KkNik,
			"status":  data.Status,
			"nama":    data.KkNama,
			"user_id": data.User.Name,
		})
	}

	c.JSON(http.StatusOK, hasil)
}

func GetKeluargaByID(c *gin.Context) {
	id := c.Param("id")
	
	var keluarga models.Keluarga
	if err := setup.DB.Preload("User").First(&keluarga, id).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "Data tidak ditemukan"})
		return
	}

	hasil := map[string]interface{}{
		"id":        keluarga.Id,
		"no_kk":     keluarga.NoKk,
		"kk_nik":    keluarga.KkNik,
		"kk_nama":   keluarga.KkNama,
		"alamat":    keluarga.Alamat,
		"rt":        keluarga.Rt,
		"rw":        keluarga.Rw,
		"kode_pos":  keluarga.KodePos,
		"status":    keluarga.Status,
		"user_id":   keluarga.User.Id,
		"user_name": keluarga.User.Name,
	}

	c.JSON(http.StatusOK, hasil)
}

func AddKeluarga(c *gin.Context) {
	var input struct {
		NoKk    int64  `json:"no_kk" binding:"required"`
		KkNik   int64  `json:"kk_nik" binding:"required"`
		KkNama  string `json:"kk_nama" binding:"required"`
		Alamat  string `json:"alamat" binding:"required"`
		Rt      string `json:"rt" binding:"required"`
		Rw      string `json:"rw" binding:"required"`
		KodePos string `json:"kode_pos" binding:"required"`
		Status  int8   `json:"status" binding:"required"`
		UserId  int64  `json:"user_id" binding:"required"`
	}

	if err := c.ShouldBindJSON(&input); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{
			"valid":   false,
			"message": "Pastikan form sudah terisi dengan benar",
		})
		return
	}

	keluarga := models.Keluarga{
		NoKk:    input.NoKk,
		KkNik:   input.KkNik,
		KkNama:  input.KkNama,
		Alamat:  input.Alamat,
		Rt:      input.Rt,
		Rw:      input.Rw,
		KodePos: input.KodePos,
		Status:  input.Status,
		UserId:  input.UserId,
	}

	if err := setup.DB.Create(&keluarga).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{
			"valid":   false,
			"message": "Gagal menambah keluarga",
		})
		return
	}

	c.JSON(http.StatusOK, gin.H{
		"valid":   true,
		"message": "Sukses menambah keluarga",
	})
}

func UpdateKeluarga(c *gin.Context) {
	id := c.Param("id")

	var input struct {
		NoKk    int64  `json:"no_kk" binding:"required"`
		KkNik   int64  `json:"kk_nik" binding:"required"`
		KkNama  string `json:"kk_nama" binding:"required"`
		Alamat  string `json:"alamat" binding:"required"`
		Rt      string `json:"rt" binding:"required"`
		Rw      string `json:"rw" binding:"required"`
		KodePos string `json:"kode_pos" binding:"required"`
		Status  int8   `json:"status" binding:"required"`
		UserId  int64  `json:"user_id" binding:"required"`
	}

	if err := c.ShouldBindJSON(&input); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{
			"status":  false,
			"message": "Pastikan form sudah terisi dengan benar",
		})
		return
	}

	var keluarga models.Keluarga
	if err := setup.DB.First(&keluarga, id).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{
			"status":  false,
			"message": "Data tidak ditemukan",
		})
		return
	}

	if err := setup.DB.Model(&keluarga).Updates(input).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{
			"status":  false,
			"message": "Gagal mengupdate keluarga",
		})
		return
	}

	c.JSON(http.StatusOK, gin.H{
		"status":  true,
		"message": "Sukses mengupdate keluarga",
	})
}

func DeleteKeluarga(c *gin.Context) {
	id := c.Param("id")

	var keluarga models.Keluarga
	if err := setup.DB.First(&keluarga, id).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{
			"message": "Data keluarga tidak ditemukan",
		})
		return
	}

	if err := setup.DB.Delete(&keluarga).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{
			"message": "Gagal menghapus data keluarga",
		})
		return
	}

	c.JSON(http.StatusOK, gin.H{
		"message": "Data keluarga berhasil dihapus",
	})
}

