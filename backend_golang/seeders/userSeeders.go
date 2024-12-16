package seeders

import (
	"backend_golang/models"
	"log"

	"golang.org/x/crypto/bcrypt"
	"gorm.io/gorm"
)

func SeedersUser(db gorm.DB) {

	var user models.User

	password, _ := bcrypt.GenerateFromPassword([]byte("admin123"), bcrypt.DefaultCost)

	user = models.User{
		Name:     "admin",
		Email:    "admin@gmail.com",
		Password: string(password),
		ProfilePicture: "",
		Level:    "admin",
	}

	// Cek apakah sudah ada data di tabel aduans
	if err := db.First(&user).Error; err == nil {
		log.Println("seed has been created")
		return
	}

	db.Create(&user)
	log.Println("seed success")
}

