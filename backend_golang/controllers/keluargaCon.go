package controllers

import (
	"backend_golang/config"
	"backend_golang/models"
	"backend_golang/setup"
	"net/http"

	"github.com/gin-gonic/gin"
)

func Index(c *gin.Context) {
	// Mengambil data user yang sedang login
	userID, exists := c.Get("user")
	if !exists {
		c.JSON(http.StatusNotFound, gin.H{"error": "User not found", "status": false})
		return
	}

	var user models.User
	if err := setup.DB.First(&user, userID).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "User not found", "status": false})
		return
	}

	var keluarga []models.Keluarga
	var err error
	var total int64

	if user.Level == "admin" {
		err = setup.DB.Preload("User").Order("created_at DESC").Find(&keluarga).Error
	} else {
		err = setup.DB.Preload("User").Where("user_id = ?", user.Id).Order("created_at DESC").Find(&keluarga).Error
	}

	setup.DB.Model(&models.Keluarga{}).Count(&total)

	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{
			"status": false,
			"error":  "Gagal mengambil data: " + err.Error(),
		})
		return
	}

	if len(keluarga) == 0 {
		c.JSON(http.StatusOK, gin.H{
			"status":  true,
			"data":    []map[string]interface{}{},
			"message": "Data kosong",
		})
		return
	}

	formattedKeluargas := make([]gin.H, len(keluarga))
	for i, keluarga := range keluarga {

		formattedKeluargas[i] = gin.H{
			"id":         keluarga.Id,
			"no_kk":      keluarga.NoKk,
			"kk_nik":     keluarga.KkNik,
			"kk_nama":    keluarga.KkNama,
			"alamat":     keluarga.Alamat,
			"rt":         keluarga.Rt,
			"rw":         keluarga.Rw,
			"kode_pos":   keluarga.KodePos,
			"status":     config.GetStatus(int(keluarga.Status)),
			"user_id":    keluarga.User.Name,
			"created_at": keluarga.CreatedAt,
			"updated_at": keluarga.UpdatedAt,
		}
	}

	c.JSON(http.StatusOK, gin.H{
		"user":  user,
		"data":  formattedKeluargas,
		"total": total,
	})
}

func Latest(c *gin.Context) {
	userID, exists := c.Get("user")
	if !exists {
		c.JSON(http.StatusNotFound, gin.H{"error": "User not found", "status": false})
		return
	}

	var user models.User
	if err := setup.DB.First(&user, userID).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "User not found", "status": false})
		return
	}
	var keluarga []models.Keluarga

	if user.Level == "admin" {
		if err := setup.DB.Preload("User").Order("created_at DESC").Limit(5).Find(&keluarga).Error; err != nil {
			c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal mengambil data"})
			return
		}
	} else {
		if err := setup.DB.Preload("User").Where("user_id = ?", user.Id).Order("created_at DESC").Limit(5).Find(&keluarga).Error; err != nil {
			c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal mengambil data"})
			return
		}
	}

	if len(keluarga) == 0 {
		c.JSON(http.StatusOK, gin.H{
			"status":  true,
			"data":    []map[string]interface{}{},
			"message": "Data kosong",
		})
		return
	}

	formattedKeluargas := make([]gin.H, len(keluarga))
	for i, keluarga := range keluarga {

		formattedKeluargas[i] = gin.H{
			"id":         keluarga.Id,
			"no_kk":      keluarga.NoKk,
			"kk_nik":     keluarga.KkNik,
			"kk_nama":    keluarga.KkNama,
			"alamat":     keluarga.Alamat,
			"rt":         keluarga.Rt,
			"rw":         keluarga.Rw,
			"kode_pos":   keluarga.KodePos,
			"status":     config.GetStatus(int(keluarga.Status)),
			"user_id":    keluarga.UserId,
			"created_at": keluarga.CreatedAt,
			"updated_at": keluarga.UpdatedAt,
		}
	}

	c.JSON(http.StatusOK, gin.H{
		"user": user,
		"data": formattedKeluargas,
	})
}

func LatestForInput(c *gin.Context) {
	userID, exists := c.Get("user")
	if !exists {
		c.JSON(http.StatusNotFound, gin.H{"error": "User not found", "status": false})
		return
	}

	var user models.User
	if err := setup.DB.First(&user, userID).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "User not found", "status": false})
		return
	}
	var keluarga []models.Keluarga

	if user.Level == "admin" {
		if err := setup.DB.Preload("User").Order("created_at DESC").Limit(1).Find(&keluarga).Error; err != nil {
			c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal mengambil data"})
			return
		}
	} else {
		if err := setup.DB.Preload("User").Where("user_id = ?", user.Id).Order("created_at DESC").Limit(1).Find(&keluarga).Error; err != nil {
			c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal mengambil data"})
			return
		}
	}

	if len(keluarga) == 0 {
		c.JSON(http.StatusOK, gin.H{
			"status":  true,
			"data":    []map[string]interface{}{},
			"message": "Data kosong",
		})
		return
	}

	formattedKeluargas := make([]gin.H, len(keluarga))
	for i, keluarga := range keluarga {

		formattedKeluargas[i] = gin.H{
			"id":         keluarga.Id,
			"no_kk":      keluarga.NoKk,
			"kk_nik":     keluarga.KkNik,
			"kk_nama":    keluarga.KkNama,
			"alamat":     keluarga.Alamat,
			"rt":         keluarga.Rt,
			"rw":         keluarga.Rw,
			"kode_pos":   keluarga.KodePos,
			"status":     config.GetStatus(int(keluarga.Status)),
			"user_id":    keluarga.UserId,
			"created_at": keluarga.CreatedAt,
			"updated_at": keluarga.UpdatedAt,
		}
	}

	c.JSON(http.StatusOK, gin.H{
		"user": user,
		"data": formattedKeluargas,
	})
}

func GetKeluargaByID(c *gin.Context) {
	id := c.Param("id")

	var keluarga models.Keluarga
	if err := setup.DB.First(&keluarga, id).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "Data tidak ditemukan"})
		return
	}

	response := gin.H{
		"id":         keluarga.Id,
		"no_kk":      keluarga.NoKk,
		"kk_nik":     keluarga.KkNik,
		"kk_nama":    keluarga.KkNama,
		"alamat":     keluarga.Alamat,
		"rt":         keluarga.Rt,
		"rw":         keluarga.Rw,
		"kode_pos":   keluarga.KodePos,
		"status":     config.GetStatus(int(keluarga.Status)),
		"user_id":    keluarga.UserId,
		"created_at": keluarga.CreatedAt,
		"updated_at": keluarga.UpdatedAt,
	}

	c.JSON(http.StatusOK, gin.H{"data": response})
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
			"error": err.Error(),
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
		NoKk    int64  `json:"no_kk"`
		KkNik   int64  `json:"kk_nik"`
		KkNama  string `json:"kk_nama"`
		Alamat  string `json:"alamat"`
		Rt      string `json:"rt"`
		Rw      string `json:"rw"`
		KodePos string `json:"kode_pos"`
		Status  int8   `json:"status"`
		UserId  int64  `json:"user_id"`
	}

	if err := c.ShouldBindJSON(&input); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{
			"error": err.Error(),
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
