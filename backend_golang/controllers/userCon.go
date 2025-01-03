package controllers

import (
	"backend_golang/models"
	"backend_golang/setup"
	"net/http"
	"strings"
	"golang.org/x/crypto/bcrypt"

	"github.com/gin-gonic/gin"
)

func GetAllUser(c *gin.Context) {
	var users []models.User

	if err := setup.DB.Find(&users).Order("name ASC").Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error(), "status": false})
		return
	}

	c.JSON(http.StatusOK, gin.H{"data": users})
}

func UpdateUser(c *gin.Context) {
	userId := c.Param("id")
	var user models.User

	// Cek user yang akan diedit
	if err := setup.DB.First(&user, userId).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "Pengguna tidak ditemukan"})
		return
	}

	// Ambil data form
	name := c.PostForm("name")
	email := c.PostForm("email")
	profilePicture := c.PostForm("profile_picture")
	level := c.PostForm("level")

	// Update data user
	updates := map[string]interface{}{}

	if name != "" {
		updates["name"] = name
	}
	if email != "" {
		updates["email"] = email
	}
	if profilePicture != "" {
		updates["profile_picture"] = profilePicture
	}

	if level != "" {
		updates["level"] = level
	}

	// Handle foto profil jika ada
	file, err := c.FormFile("profile_picture")
	if err == nil {
		// Validasi tipe file
		if !strings.HasSuffix(strings.ToLower(file.Filename), ".jpg") &&
			!strings.HasSuffix(strings.ToLower(file.Filename), ".jpeg") &&
			!strings.HasSuffix(strings.ToLower(file.Filename), ".png") {
			c.JSON(http.StatusBadRequest, gin.H{"error": "Format file tidak didukung"})
			return
		}

		// Validasi ukuran file (max 2MB)
		if file.Size > 2*1024*1024 {
			c.JSON(http.StatusBadRequest, gin.H{"error": "Ukuran file terlalu besar"})
			return
		}

		// Gunakan nama file asli
		uploadPath := "public/uploads/profile_pictures/" + file.Filename

		// Simpan file
		if err := c.SaveUploadedFile(file, uploadPath); err != nil {
			c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal menyimpan foto profil"})
			return
		}

		// Simpan path lengkap ke database
		updates["profile_picture"] = uploadPath
	}

	if err := setup.DB.Model(&user).Updates(updates).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal memperbarui pengguna"})
		return
	}

	// Reload user data dengan relasi
	setup.DB.First(&user, userId)

	c.JSON(http.StatusOK, gin.H{"message": "Data berhasil diperbarui", "data": user})
}

func PasswordUpdate(c *gin.Context) {
	userId := c.Param("id")
	var user models.User

	// Cek user yang akan diedit
	if err := setup.DB.First(&user, userId).Error; err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "Pengguna tidak ditemukan"})
		return
	}

	// Ambil data form
	password := c.PostForm("password")
	confirmPassword := c.PostForm("confirm_password")

	if password != confirmPassword {
		c.JSON(http.StatusBadRequest, gin.H{"error": "Password dan konfirmasi password tidak cocok"})
		return	
	}

	hashedPassword, err := bcrypt.GenerateFromPassword([]byte(password), bcrypt.DefaultCost)
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to hash password"})
		return
	}

	// Update data user
	updates := map[string]interface{}{}

	if password != "" {
		updates["password"] = string(hashedPassword)
	}

	if err := setup.DB.Model(&user).Updates(updates).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal memperbarui pengguna"})
		return
	}

	// Reload user data dengan relasi
	setup.DB.First(&user, userId)

	c.JSON(http.StatusOK, gin.H{"message": "Data berhasil diperbarui", "data": user})
}

func UserData(c *gin.Context) {
	// Mengambil data user yang sedang login
	userData, exists := c.Get("user")
	if !exists {
		c.JSON(http.StatusUnauthorized, gin.H{"error": "User tidak terautentikasi"})
		return
	}

	user := userData.(models.User)
	userID := user.Id

	// Mengambil data keluarga
	var keluargaList []models.Keluarga
	if err := setup.DB.Where("user_id = ?", userID).Find(&keluargaList).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal mengambil data keluarga"})
		return
	}

	// Transformasi data keluarga
	hasilKeluarga := make([]map[string]interface{}, 0)
	for _, data := range keluargaList {
		hasilKeluarga = append(hasilKeluarga, map[string]interface{}{
			"id":         data.Id,
			"no_kk":      data.NoKk,
			"kk_nama":    data.KkNama,
			"alamat":     data.Alamat,
			"rt":         data.Rt,
			"rw":         data.Rw,
			"kode_pos":   data.KodePos,
			"status":     data.Status,
			"user_id":    data.UserId,
			"user_name":  user.Name,
		})
	}

	// Mengambil data penduduk dengan relasi keluarga
	var pendudukList []models.Penduduk
	if err := setup.DB.Preload("Keluarga").Where("user_id = ?", userID).Find(&pendudukList).Error; err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Gagal mengambil data penduduk"})
		return
	}

	// Transformasi data penduduk
	hasilPenduduk := make([]map[string]interface{}, 0)
	for _, data := range pendudukList {
		hasilPenduduk = append(hasilPenduduk, map[string]interface{}{
			"id":          data.Id,
			"kels_id":     data.KelsId,
			"nomer_kk":    data.Keluarga.NoKk,
			"nik":         data.Nik,
			"nama":        data.Nama,
			"tmp_lhr":     data.TmpLahir,
			"tgl_lhr":     data.TglLahir,
			"kelamin":     data.Kelamin,
			"stat_kawin":  data.StatKawin,
			"hub_kel":     data.HubKel,
			"warga_neg":   data.WargaNeg,
			"agama":       data.Agama,
			"pendidikan":  data.Pendidikan,
			"pekerjaan":   data.Pekerjaan,
			"ayah":        data.Ayah,
			"ibu":         data.Ibu,
			"kepala_kel":  data.Keluarga.KkNama,
			"no_hp":       data.NoHp,
			"domisili":    data.Domisili,
			"stat":        data.Status,
			"user_name":   user.Name,
		})
	}

	c.JSON(http.StatusOK, gin.H{
		"success":  true,
		"message":  "Data user " + user.Name,
		"keluarga": hasilKeluarga,
		"penduduk": hasilPenduduk,
	})
}

