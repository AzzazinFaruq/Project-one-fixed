package models

import (
	"time"
)

type User struct {
	Id             uint      `gorm:"primaryKey"`
	Name           string    `json:"name"`
	Email          string    `json:"email" gorm:"unique;not null"`
	Password       string    `json:"-" gorm:"not null"`
	Level          string    `json:"level"`
	ProfilePicture string    `json:"profile_picture"`
	CreatedAt      time.Time `gorm:"type:timestamp;default:current_timestamp"`
	UpdatedAt      time.Time `gorm:"type:timestamp;default:current_timestamp on update current_timestamp"`
}
